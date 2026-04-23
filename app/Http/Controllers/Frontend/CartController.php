<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        //  dd($request->all());
        // fetch the product from the database 
        $product = Product::with(['productSizes', 'productOptions'])->findOrFail($request->product_id);
        $productSize = $product->productSizes->where('id', $request->product_size)->first();
        $productOptions = $product->productOptions->whereIn('id', $request->product_option)->first();
        // where will be storing the product size
        $options = [
            'product_size' => [
                'id' => $productSize->id,
                'name' => $productSize->name,
                'price' => $productSize->price
            ],
            'product_options' => []
        ]

        foreach($productOptions as $option) {
            $options['product_options'][] = [
                'id' => $option->id,
                'name' => $option->name,
                'price' => $option->price
            ]
        }
    }
}
