<?php

namespace App\Http\Controllers\Employe;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class EmployeeMenuController extends Controller
{
    public function index()
    {
        $menus = Menu::latest()->paginate(10);

        return view('employe.catering-menus.index', compact('menus'));
    }

    public function create()
    {
        $products = Product::orderBy('name')->get();

        return view('employe.catering-menus.create', compact('products'));
    }

    public function edit(Menu $menu)
    {
        $products = Product::orderBy('name')->get();
        $menu->load('products');

        return view(
            'employe.catering-menus.edit',
            compact('menu', 'products')
        );
    }

    public function store(Request $request)
    {
        $validated = $this->validateMenu($request);
        $selectedProducts = $this->validatedMenuProducts($request);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')
                ->store('catering-menus', 'public');
        }

        $validated['slug'] = $this->uniqueSlug($validated['title']);
        $validated['status'] = $request->boolean('status');

        $menu = Menu::create($validated);
        $menu->products()->sync($selectedProducts);

        return redirect()
            ->route('employe.catering-menus.index')
            ->with('success', 'Menu créé avec succès.');
    }

    public function update(Request $request, Menu $menu)
    {
        $validated = $this->validateMenu($request);
        $selectedProducts = $this->validatedMenuProducts($request);

        if ($request->hasFile('image')) {
            if ($menu->image) {
                Storage::disk('public')->delete($menu->image);
            }

            $validated['image'] = $request->file('image')
                ->store('catering-menus', 'public');
        } else {
            unset($validated['image']);
        }

        $validated['slug'] = $this->uniqueSlug(
            $validated['title'],
            $menu->id
        );

        $validated['status'] = $request->boolean('status');

        $menu->update($validated);
        $menu->products()->sync($selectedProducts);

        return redirect()
            ->route('employe.catering-menus.index')
            ->with('success', 'Menu modifié avec succès.');
    }

    public function destroy(Menu $menu)
    {
        $image = $menu->image;

        // Détacher les plats avant la suppression du menu.
        $menu->products()->detach();
        $menu->delete();

        if ($image) {
            Storage::disk('public')->delete($image);
        }

        return redirect()
            ->route('employe.catering-menus.index')
            ->with('success', 'Menu supprimé avec succès.');
    }

    private function validateMenu(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
            'price' => ['required', 'numeric', 'min:0'],
            'minimum_persons' => ['required', 'integer', 'min:1'],
            'theme' => [
                'required',
                Rule::in(['classique', 'noel', 'paques', 'evenement']),
            ],
            'diet' => [
                'required',
                Rule::in(['classique', 'vegetarien', 'vegan']),
            ],
            'available_stock' => ['required', 'integer', 'min:0'],
            'advance_notice_hours' => ['required', 'integer', 'min:0'],
            'storage_conditions' => ['nullable', 'string'],
            'order_conditions' => ['nullable', 'string'],
            'status' => ['nullable', 'boolean'],
        ]);
    }

    private function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($title) ?: 'menu';
        $slug = $baseSlug;
        $counter = 1;

        while (
            Menu::where('slug', $slug)
                ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter++;
        }

        return $slug;
    }

    private function validatedMenuProducts(Request $request): array
    {
        $rows = collect($request->input('products', []))
            ->filter(fn ($row) => is_array($row) && !empty($row['selected']))
            ->map(function ($row, $productId) {
                return [
                    'id' => $productId,
                    'dish_type' => $row['dish_type'] ?? null,
                    'quantity' => $row['quantity'] ?? null,
                ];
            })
            ->values()
            ->all();

        $validator = Validator::make(
            ['products' => $rows],
            [
                'products' => ['array'],
                'products.*.id' => [
                    'required', 'integer', 'distinct', 'exists:products,id',
                ],
                'products.*.dish_type' => [
                    'required', Rule::in(['entree', 'plat', 'dessert']),
                ],
                'products.*.quantity' => [
                    'required', 'integer', 'min:1',
                ],
            ],
            [
                'products.*.dish_type.required' =>
                    'Choisis une catégorie pour chaque plat sélectionné.',
                'products.*.quantity.required' =>
                    'Indique une quantité pour chaque plat sélectionné.',
            ]
        );

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return collect($validator->validated()['products'])
            ->mapWithKeys(fn ($product) => [
                $product['id'] => [
                    'dish_type' => $product['dish_type'],
                    'quantity' => $product['quantity'],
                ],
            ])
            ->all();
    }
}
