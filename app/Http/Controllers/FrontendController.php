<?php

namespace App\Http\Controllers;

use App\Models\Product;
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

        return view('pages.frontend.details', ['items' => $products]);
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