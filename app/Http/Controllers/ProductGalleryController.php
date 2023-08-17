<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class ProductGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Product $product)
    {
        if(request()->ajax())
        {
            $query = ProductGallery::query();

            return DataTables::of($query)
            ->addColumn('action', function($item)
            {
                return '
                <form class="inline-block" action="'. route('dashboard.product.destroy', $item->id) .'">
                    <button class="bg-red-500 text-white rounded-md px-2 py-1 m-2">
                        Hapus
                    </button>
                '. method_field('delete') . csrf_field() .'
                </form>
                ';
            })
            ->editColumn('url', function($item)
            {
                return '<img style="max-width: 150px" src="'. Storage::url($item->url) .'"></img>';
            })
            ->editColumn('is_featured', function($item){
                return $item->is_featured ? 'Yes' : 'No';
            })
            ->rawColumns(['action'])
            ->make();
        }

        return view('pages.dashboard.gallery.index', compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
