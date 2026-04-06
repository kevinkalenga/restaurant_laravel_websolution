<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\FileUploadTrait;
use App\Models\ProductGallery;

class ProductGalleryController extends Controller
{
      use FileUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index($productId)
    {
        $product = \App\Models\Product::findOrFail($productId);
        $images = ProductGallery::where('product_id', $productId)->get();
        return view('admin.product.gallery.index', compact('product', 'images'));
    }

    

    /**
     * Store a newly created resource in storage.
     */
     
    
    public function store(Request $request)
    {
      // Validation
      $request->validate([
          'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
          'product_id' => ['required', 'exists:products,id'],
      ]);

      // Upload via ton trait
      $imagePath = $this->uploadImage($request, 'image', 'uploads/product-gallery');

      // Sauvegarde en base
      $gallery = new \App\Models\ProductGallery();
      $gallery->product_id = $request->product_id;
      $gallery->image = $imagePath;
      $gallery->save();

       return redirect()
        ->back()
        ->with('success', 'Image uploaded successfully!');
    }

   

 

    /**
     * Remove the specified resource from storage.
     */
    
    public function destroy(string $id)
    {
        // récupère l’image ou erreur 404
        $image = ProductGallery::findOrFail($id);

        // Supprimer le fichier du dossier
        if (file_exists(public_path($image->image))) {
            unlink(public_path($image->image));
        }

        // Supprimer en base
        $image->delete();

        return redirect()
            ->back()
            ->with('success', 'Image Deleted Successfully !');
    }
}
