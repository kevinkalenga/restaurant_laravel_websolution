<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class DailyOfferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         return view('admin.daily-offer.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view('admin.daily-offer.create');
    }

    public function productSearch(Request $request)
    {
        $product = Product::select('id', 'name', 'thumb_image')->where('name', 'LIKE', '%'.$request->search.'%')->get();
         
        $product->transform(function ($item) {
            $item->thumb_image = asset($item->thumb_image);
            return $item;
        });

         return response($product);
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
