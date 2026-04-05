<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\FileUploadTrait;

class ProductGalleryController extends Controller
{
      use FileUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index($productId)
    {
        $product = \App\Models\Product::findOrFail($productId);
        return view('admin.product.gallery.index', compact('product'));
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
