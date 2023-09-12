<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TranscationItem;
use Auth;
use Exception;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;


class FrontendController extends Controller
{
    public function index(Request $request)
    {
        $product = Product::with(['galleries'])->latest()->get();

        return view('pages.frontend.index', ['items' => $product]);
    }

    public function details(Request $request, $slug)
    {
        $products = Product::with(['galleries'])->where('slug', $slug)->firstOrFail();
        $rekomendasi = Product::with(['galleries'])->inRandomOrder()->limit(4)->get();

        return view('pages.frontend.details', ['items' => $products, 'rekomen' => $rekomendasi]);
    }

    public function cartAdd(Request $request, $id)
    {
        Cart::create([
            'users_id' => Auth::user()->id,
            'products_id' => $id
        ]);

        return redirect('cart');
    }

    public function cart(Request $request)
    {
        $carts = Cart::with(['product.galleries'])->where('users_id', Auth::user()->id)->get();

        return view('pages.frontend.cart', ['items' => $carts]);
    }

    public function success(Request $request)
    {
        return view('pages.frontend.success');
    }

    public function cartDelete(Request $request, $id)
    {
        $items = Cart::findOrFail($id);
        $items->delete();

        return redirect('cart');
    }

    public function checkout(CheckoutRequest $request)
    {
        $data = $request->all();

        // get cart data
        $carts = Cart::with(['product'])->where('users_id', Auth::user()->id)->get();

        // add to transaction data
        $data['users_id'] = Auth::user()->id;
        $data['total_price'] = $carts->sum('product.price');

        // create transaction
        $transaction = Transaction::create($data);

        // create transaction items
        foreach ($carts as $cart) {
            $items[] = TranscationItem::create([
                'transaction_id' => $transaction->id,
                'users_id' => $cart->users_id,
                'products_id' => $cart->products_id
            ]);
        }

        // delete cart after transaction
        Cart::where('users_id', Auth::user()->id)->delete();

        // konfirgurasi midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        // setup variable midtrans
        $midtrans = [
            'transaction_details' => [
                'order_id' => 'Hello-' . $transaction->id,
                'gross_amount' => (int) $transaction->total_price
            ],
            'customer_details' => [
                'first_name' => $transaction->name,
                'email' => $transaction->email
            ],
            'enabled_payments' => ['gopay', 'bank_transfer'],
            'vtweb' => []
        ];

        // payment process
        try {
            // get snap payment page URL
            $paymenturl = Snap::createTransaction($midtrans)->redirect_url;

            $transaction->payment_url = $paymenturl;
            $transaction->save();

            // redirect to snap payment page
            return redirect($paymenturl);

        } catch (Exception $e) {
            echo $e->getMessage();
        }

    }

}