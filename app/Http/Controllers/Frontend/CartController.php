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
      try{
        // 1. Récupérer le produit avec relations
        $product = Product::with(['productSizes', 'productOptions'])
            ->findOrFail($request->product_id);

        // 2. Récupérer la taille (peut être null)
        $productSize = null;

        if ($request->product_size) {
            $productSize = $product->productSizes
                ->firstWhere('id', $request->product_size);

            // sécurité métier
            if (!$productSize) {
                return redirect()->back()
                    ->withErrors('Invalid size for this product');
            }
        }

        // 3. Récupérer les options (toujours en collection)
        $productOptions = $product->productOptions
            ->whereIn('id', $request->product_option ?? []);

        // 4. Construire le tableau options
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

        // 5. Ajouter les options sélectionnées
        foreach ($productOptions as $option) {
            $options['product_options'][] = [
                'id' => $option->id,
                'name' => $option->name,
                'price' => $option->price
            ];
        }

      

       // 6. Ajouter au panier
       Cart::add([
           'id' => $product->id,
           'name' => $product->name,
           'qty' => $request->quantity ?? 1,
           'price' => $product->offer_price > 0 ? $product->offer_price : $product->price,
           'weight' => 0,
           'options' => $options
       ]);

        return response(['status' => 'success', 'message' => "Product Added Into Card Successfully!"], 200);
      }catch(\Exception $e){
        return response(['status' => 'error', 'message' => "Something went wrong!"], 500);
      }   
    }

    public function getCartProduct()
    {
        return view('frontend.layouts.ajax-files.sidebar-cart-item')->render();
    }
    public function cartProductRemove($rowId)
    {
       try {
           Cart::remove($rowId);
           return response(['status' => 'success', 'message' => 'Item has been removed!'], 200);
       }catch(\Exception $e) {
            return response(['status' => 'error', 'message' => 'Sorry something went wrong'], 500);
       }
    }

    public function index()
    {
        return view('frontend.pages.cart-view');
    }
}
