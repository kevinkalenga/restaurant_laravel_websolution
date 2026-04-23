<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Cart;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $product = Product::with(['productSizes', 'productOptions'])
        ->findOrFail($request->product_id);

        // SIZE (peut être null)
        $productSize = $product->productSizes
            ->firstWhere('id', $request->product_size);

        // OPTIONS (collection)
        $productOptions = $product->productOptions
            ->whereIn('id', $request->product_option ?? []);

        $options = [
            'product_size' => $productSize ? [
                'id' => $productSize->id,
                'name' => $productSize->name,
                'price' => $productSize->price
            ] : null,

            'product_options' => [],

            'product_info' => [
                'image' => $product->thumb_image,
                'slug' => $product->slug
            ]
        ];

        foreach ($productOptions as $option) {
            $options['product_options'][] = [
                'id' => $option->id,
                'name' => $option->name,
                'price' => $option->price
            ];
        }

        Cart::add([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => $request->quantity ?? 1,
            'price' => $product->offer_price > 0 ? $product->offer_price : $product->price,
            'weight' => 0,
            'options' => $options
        ]);

        return redirect()->back()->with('status', 'Product Added Into Cart Successfully!');
    }
}
