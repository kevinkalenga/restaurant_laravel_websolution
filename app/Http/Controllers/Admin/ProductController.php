<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Models\Product;
use App\Models\Category;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    use FileUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      if (request()->ajax()) {
        $products = Product::query(); // Modèle Product

        return DataTables::of($products)
             ->addColumn('thumb_image', function ($product) {
                 return asset($product->thumb_image);
            })

            ->addColumn('action', function ($product) {
                return '
                    <a href="'.route('admin.product.edit', $product->id).'" 
                       class="text-primary fw-bold">
                        Edit
                    </a>
                    |
                    <a href="'.route('admin.product.destroy', $product->id).'" 
                       class="text-danger fw-bold"
                       onclick="event.preventDefault();
                       if(confirm(\'Are you sure you want to delete?\')) {
                           document.getElementById(\'delete-form-'.$product->id.'\').submit();
                       }">
                        Delete
                    </a>

                    <form id="delete-form-'.$product->id.'" 
                          action="'.route('admin.product.destroy', $product->id).'" 
                          method="POST" style="display:none;">
                        '.csrf_field().'
                        '.method_field('DELETE').'
                    </form>
                ';
            })

            ->rawColumns(['action'])
            ->make(true);
       }

        return view('admin.product.index'); // Vue index pour produits
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
         return view('admin.product.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
      // Validation
      $request->validate([
        'name' => ['required', 'max:255'],
        'category_id' => ['required', 'exists:categories,id'],
        'thumb_image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        'short_description' => ['nullable', 'string'],
        'long_description' => ['nullable', 'string'],
        'price' => ['required', 'numeric', 'min:0'],
        'offer_price' => ['nullable', 'numeric', 'min:0'],
        'sku' => ['nullable', 'string', 'max:255'],
        'seo_title' => ['nullable', 'string', 'max:255'],
        'seo_description' => ['nullable', 'string'],
        'show_at_home' => ['required', 'boolean'],
        'status' => ['required', 'boolean'],
      ]);

      
      // Upload image  trait
        $thumbImagePath = $this->uploadImage($request, 'thumb_image', 'uploads/products');

      // Création du produit
      $product = new Product();
      $product->name = $request->name;
      $product->slug = Str::slug($request->name);
      $product->category_id = $request->category_id;
      $product->thumb_image = $thumbImagePath;
      $product->short_description = $request->short_description;
      $product->long_description = $request->long_description;
      $product->price = $request->price;
      $product->offer_price = $request->offer_price ?? 0;
      $product->sku = $request->sku;
      $product->seo_title = $request->seo_title;
      $product->seo_description = $request->seo_description;
      $product->show_at_home = $request->show_at_home;
      $product->status = $request->status;
      $product->save();

      return redirect()
        ->route('admin.product.index')
        ->with('success', 'Product created successfully!');
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
