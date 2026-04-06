<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductSize;
use App\Models\ProductOption;
use App\Models\Product;

class ProductSizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($productId)
    {
          $product = Product::findOrFail($productId);
          $sizes = ProductSize::where('product_id', $productId)->get();
          $options = ProductOption::where('product_id', $productId)->get();
          return view('admin.product.product_size.index', compact('product', 'sizes', 'options'));
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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // récupère l’image ou erreur 404
        $size = ProductSize::findOrFail($id);


        // Supprimer en base
        $size->delete();

        return redirect()
            ->back()
            ->with('success', 'Size Deleted Successfully !');
    }
}
