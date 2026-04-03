<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Models\Poruduct;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      if (request()->ajax()) {
        $products = Product::query(); // Modèle Product

        return DataTables::of($products)

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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
