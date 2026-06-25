<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Cart;
use Illuminate\Validation\ValidationException;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        // 1. Récupérer le produit avec relations
        $product = Product::with(['productSizes', 'productOptions'])
            ->findOrFail($request->product_id);
        if($product->quantity < $request->quantity) {
            throw ValidationException::withMessages(['Quantity is not available!']);
        }
      try{
        

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




    public function cartQtyUpdate(Request $request)
    {
        $cartItem = Cart::get($request->rowId);
          // 1. Récupérer le produit si il existe sinon une erreur
        $product = Product::findOrFail($cartItem->id);
           
        if($product->quantity < $request->qty) {
           return response(['status' => 'error', 'message' => 'Quantity is not available!', 'qty' => $cartItem->qty]);
        }
        
        try {
            $cart = Cart::update($request->rowId, $request->qty);

            return response()->json([
                'status' => 'success',
                'message' => 'Cart updated successfully',
                'product_total' => productTotal($request->rowId), 'qty' => $cart->qty
            ], 200);

        } catch (\Exception $e) {

            logger($e);

            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong'
            ], 500);
        }
    }

    public function cartDestroy() {
        Cart::destroy();
        return redirect()->back();
    }
}
