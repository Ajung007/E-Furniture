<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Auth;
use Illuminate\Http\Request;


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
        return view('pages.frontend.cart');
    }

    public function success(Request $request)
    {
        return view('pages.frontend.success');
    }

}