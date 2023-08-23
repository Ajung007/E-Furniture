<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TranscationItem;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(request()->ajax())
        {
            $query = Transaction::query();

            return DataTables::of($query)
            ->addColumn('action', function($item)
            {
                return '
                <a class="inline-block border border-blue-700 bg-blue-700 text-black rounded-md px-2 py-1 m-1 transition duration-500 ease select-none hover:bg-blue-800 focus:outline-none focus:shadow-outline" 
                    href="' . route('dashboard.transaction.show', $item->id) . '">
                    Show
                </a>
                <a class="inline-block border border-gray-700 bg-gray-700 text-white rounded-md px-2 py-1 m-1 transition duration-500 ease select-none hover:bg-gray-800 focus:outline-none focus:shadow-outline" 
                    href="' . route('dashboard.transaction.edit', $item->id) . '">
                    Edit
                </a>';
        })
            ->editColumn('total_price', function($item)
            {
                return number_format($item->total_price);
            })
            ->rawColumns(['action'])
            ->make();
        }

        return view('pages.dashboard.transaction.index');
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
    public function store(Transaction $transaction)
    {
    
    }


    public function show(Transaction $transaction)
    {
       if (request()->ajax()) {
        $query = TranscationItem::with(['product'])->where('transaction_id', $transaction->id);

        return DataTables::of($query)
            ->editColumn('product.price', function ($item) 
            {
                return number_format($item->product->price);
            })
            ->make();
        }

        return view('pages.dashboard.transaction.show', compact('transaction'));
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
