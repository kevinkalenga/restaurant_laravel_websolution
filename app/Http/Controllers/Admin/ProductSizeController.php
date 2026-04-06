<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductSize;
use App\Models\Product;

class ProductSizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($productId)
    {
         $product = Product::findOrFail($productId);
          return view('admin.product.product_size.index', compact('product'));
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
        $request->validate([
            'name' => ['required', 'max:255'],
            'price' => ['required', 'numeric'],
            'product_id' => ['required', 'integer'],
        ]);

        $size = new ProductSize();

        $size->product_id = $request->product_id;
        $size->name = $request->name;
        $size->price = $request->price;
        $size->save();


        return redirect()->back()->with('success', 'Size created successfully!');


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
