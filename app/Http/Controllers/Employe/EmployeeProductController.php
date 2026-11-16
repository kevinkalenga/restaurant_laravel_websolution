<?php

namespace App\Http\Controllers\Employe;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class EmployeeProductController extends Controller
{
    /**
     * Afficher la liste des produits de la page d'accueil.
     */
    public function index()
    {
        $products = Product::where('show_at_home', 1)
            ->orderBy('name')
            ->paginate(10);

        return view('employe.products.index', compact('products'));
    }

    /**
     * Afficher le formulaire de modification de la composition.
     */
    public function editComposition(Product $product)
    {
        $menuItems = MenuItem::where('status', 1)
            ->orderBy('category')
            ->orderBy('name')
            ->get();

        $product->load('menuItems');

        return view('employe.products.edit-composition', compact(
            'product',
            'menuItems'
        ));
    }

    /**
     * Mettre à jour uniquement la composition du produit.
     */
    public function updateComposition(Request $request, Product $product)
    {
        $request->validate([
            'menu_items' => ['sometimes', 'array'],
            'menu_items.*' => [
                'integer',
                'distinct',
                'exists:catering_menu_items,id'
            ],
            'quantities' => ['sometimes', 'array'],
            'quantities.*' => ['integer', 'min:1'],
        ]);

        $menuItemAssociations = collect($request->input('menu_items', []))
            ->mapWithKeys(fn ($menuItemId) => [
                $menuItemId => [
                    'quantity' => $request->input(
                        'quantities.' . $menuItemId,
                        1
                    ),
                ],
            ])
            ->all();

        $product->menuItems()->sync($menuItemAssociations);

        return redirect()
            ->route('employe.products.index')
            ->with('success', 'Composition du produit mise à jour avec succès !');
    }
}
