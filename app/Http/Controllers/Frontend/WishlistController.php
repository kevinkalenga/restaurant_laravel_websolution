<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wishlist;
use Illuminate\Validation\ValidationException;

class WishlistController extends Controller
{
    public function store(string $productId)
    {
        if (!auth()->check()) {
            return response([
                'status' => 'error',
                'message' => 'You must be logged in to add a product to your wishlist.'
            ], 401);
        }
    
        $productAlreadyExist = Wishlist::where(['user_id' => auth()->user()->id, 'product_id' => $productId])->exists();
        if($productAlreadyExist) {
            throw ValidationException::withMessages(['Product has already been added to wishlist']);
        }
    
         $wishlist = new Wishlist();
         $wishlist->user_id = auth()->user()->id;
         $wishlist->product_id = $productId;
         $wishlist->save();

         return response(['status' => 'success', 'message' => 'Product added to wishlist']);
    }

    
    public function wishlistDelete($id)
    {
        $obj = Wishlist::find($id);

        if (!$obj) {
            return redirect()->back()->with('error', 'Wishlist item not found!');
        }

        $obj->delete();

        return redirect()->back()->with(
            'success',
            'Wishlist item is deleted successfully!'
        );
    }

}
