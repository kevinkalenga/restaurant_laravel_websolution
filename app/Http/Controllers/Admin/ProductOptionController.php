<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductOption;

class ProductOptionController extends Controller
{
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation
      $request->validate([
          'name' => ['required', 'max:255'],
          'price' => ['required', 'numeric'],
          'product_id' => ['required', 'integer'],
      ], [
        'name.required' => "Product option name is required",
        'name.max' => "Product option max length is 255",
        'price.required' => "Product option price is required",
        'price.numeric' => "Product option price have to be a number",
      ]);

           $option = new ProductOption();

           $option->product_id = $request->product_id;
           $option->name = $request->name;
           $option->price = $request->price;
           $option->save();

           return redirect()
        ->back()
        ->with('success', 'Option Created successfully!');
    }

    

    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // récupère l’image ou erreur 404
        $option = ProductOption::findOrFail($id);


        // Supprimer en base
        $option->delete();

        return redirect()
            ->back()
            ->with('success', 'Option Deleted Successfully !');
    }
}
