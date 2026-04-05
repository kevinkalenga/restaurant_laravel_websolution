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
                       class="btn btn-sm btn-primary mr-1" title="Edit">
                         <i class="fas fa-edit"></i>
                    </a>
                    |
                    <a href="'.route('admin.product.destroy', $product->id).'" 
                       class="btn btn-sm btn-danger mr-1"
                       onclick="event.preventDefault();
                       if(confirm(\'Are you sure you want to delete?\')) {
                           document.getElementById(\'delete-form-'.$product->id.'\').submit();
                       }">
                        <i class="fas fa-trash"></i>
                    </a>
                     |
                     <div class="btn-group dropleft">
                          <button type="button" class="btn btn-sm btn-dark dropdown-toggle" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false"><i class="fas fa-cog"></i></button>
                            <div class="dropdown-menu dropleft" x-placement="left-start" style="position:absolute; transform:
                                translated3d(-2px, 0px, 0px); top:0px; left:0px; will-change: transform;">
                                <a class="dropdown-item" href="'.route('admin.product-gallery.show-index', $product->id).'">Product Gallery</a>
                              
                            </div>
                     </div>

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
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
         $product = Product::findOrFail($id);
         $categories = Category::all(); 
        return view('admin.product.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    
      /**
 * Update the specified resource in storage.
 */
  public function update(Request $request, string $id)
  {
    $product = Product::findOrFail($id);

    // Validation
    $request->validate([
        'name' => ['required', 'max:255'],
        'category_id' => ['required', 'exists:categories,id'],
        'thumb_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
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

    // Upload de l'image si nécessaire
    if ($request->hasFile('thumb_image')) {
        $thumbImagePath = $this->uploadImage($request, 'thumb_image', 'uploads/products');
        $product->thumb_image = $thumbImagePath;
    }

    // Mise à jour des autres champs
    $product->name = $request->name;
    $product->slug = Str::slug($request->name);
    $product->category_id = $request->category_id;
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
        ->with('success', 'Product updated successfully!');
  }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
   {
    $product = Product::findOrFail($id);

    // Supprimer l'image du produit si besoin
    if ($product->thumb_image && file_exists(public_path($product->thumb_image))) {
        unlink(public_path($product->thumb_image));
    }

    $product->delete();

    return redirect()
        ->route('admin.product.index')
        ->with('success', 'Product deleted successfully!');
  }
}
