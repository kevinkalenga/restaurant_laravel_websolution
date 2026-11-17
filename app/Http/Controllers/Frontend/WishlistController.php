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
                'message' => 'Vous devez être connecté pour ajouter un produit à votre liste de souhaits.'
            ], 401);
        }
    
        $productAlreadyExist = Wishlist::where(['user_id' => auth()->user()->id, 'product_id' => $productId])->exists();
        if($productAlreadyExist) {
            throw ValidationException::withMessages(['Ce produit figure déjà dans votre liste de souhaits.']);
        }
    
         $wishlist = new Wishlist();
         $wishlist->user_id = auth()->user()->id;
         $wishlist->product_id = $productId;
         $wishlist->save();

         return response(['status' => 'success', 'message' => 'Produit ajouté à votre liste de souhaits.']);
    }

    
    public function wishlistDelete($id)
    {
        $obj = Wishlist::find($id);

        if (!$obj) {
            return redirect()->back()->with('error', 'Article introuvable dans votre liste de souhaits!');
        }

        $obj->delete();

        return redirect()->back()->with(
            'success',
            'Article supprimé de votre liste de souhaits avec succès !'
        );
    }

}
