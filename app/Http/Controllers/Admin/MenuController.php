<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\MenuGallery;
use App\Models\MenuItem;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::latest()->paginate(10);

        return view('admin.catering-menus.index', compact('menus'));
    }

    public function create()
    {
        $menuItems = MenuItem::orderBy('category')
            ->orderBy('name')
            ->get();

        return view('admin.catering-menus.create', compact('menuItems'));
    }

    public function edit(Menu $menu)
    {
        $menuItems = MenuItem::orderBy('category')
            ->orderBy('name')
            ->get();

        $menu->load(['menuItems', 'galleries']);

        return view(
            'admin.catering-menus.edit',
            compact('menu', 'menuItems')
        );
    }

    
    
    
    
    
    
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
            'gallery' => ['nullable', 'array'],
            'gallery.*' => ['image', 'max:2048'],
            'price' => ['required', 'numeric', 'min:0'],
            'minimum_persons' => ['required', 'integer', 'min:1'],
            'theme' => ['required', Rule::in(['classique', 'noel', 'paques', 'evenement'])],
            'diet' => ['required', Rule::in(['classique', 'vegetarien', 'vegan'])],
            'available_stock' => ['required', 'integer', 'min:0'],
            'advance_notice_hours' => ['required', 'integer', 'min:0'],
            'storage_conditions' => ['nullable', 'string'],
            'order_conditions' => ['nullable', 'string'],
            'status' => ['nullable', 'boolean'],
        ]);

        $selectedMenuItems = $this->validatedMenuItems($request);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('catering-menus', 'public');
        }

        $validated['slug'] = Str::slug($validated['title']);
        $validated['status'] = $request->boolean('status');

        $baseSlug = $validated['slug'];
        $counter = 1;

        while (Menu::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $baseSlug . '-' . $counter++;
        }

        $menu = Menu::create($validated);
        $menu->menuItems()->sync($selectedMenuItems);

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $image) {
                $path = $image->store('catering-menus/gallery', 'public');

                $menu->galleries()->create([
                    'image' => $path,
                ]);
            }
        }

        return redirect()
            ->route('admin.catering-menus.index')
            ->with('success', 'Menu créé avec succès.');
    }

    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
            'gallery' => ['nullable', 'array'],
            'gallery.*' => ['image', 'max:2048'],
            'delete_gallery' => ['nullable', 'array'],
            'delete_gallery.*' => ['integer', 'exists:menu_galleries,id'],
            'price' => ['required', 'numeric', 'min:0'],
            'minimum_persons' => ['required', 'integer', 'min:1'],
            'theme' => ['required', Rule::in(['classique', 'noel', 'paques', 'evenement'])],
            'diet' => ['required', Rule::in(['classique', 'vegetarien', 'vegan'])],
            'available_stock' => ['required', 'integer', 'min:0'],
            'advance_notice_hours' => ['required', 'integer', 'min:0'],
            'storage_conditions' => ['nullable', 'string'],
            'order_conditions' => ['nullable', 'string'],
            'status' => ['nullable', 'boolean'],
        ]);

        $selectedMenuItems = $this->validatedMenuItems($request);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('catering-menus', 'public');
        } else {
            unset($validated['image']);
        }

        $validated['slug'] = Str::slug($validated['title']);
        $validated['status'] = $request->boolean('status');

        $baseSlug = $validated['slug'];
        $counter = 1;

        while (
            Menu::where('slug', $validated['slug'])
                ->where('id', '!=', $menu->id)
                ->exists()
        ) {
            $validated['slug'] = $baseSlug . '-' . $counter++;
        }

        $menu->update($validated);
        $menu->menuItems()->sync($selectedMenuItems);


        // Supprimer les photos sélectionnées
        if ($request->filled('delete_gallery')) {
            $galleries = $menu->galleries()
                ->whereIn('id', $request->input('delete_gallery'))
                ->get();

            foreach ($galleries as $gallery) {
                \Illuminate\Support\Facades\Storage::disk('public')
                    ->delete($gallery->image);

                $gallery->delete();
            }
        }
        

        // Ajouter les nouvelles photos
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $image) {
                $path = $image->store('catering-menus/gallery', 'public');

                $menu->galleries()->create([
                    'image' => $path,
                ]);
            }
        }

        
        
        
        return redirect()
            ->route('admin.catering-menus.index')
            ->with('success', 'Menu modifié avec succès.');
    }

    /**
     * Valide et prépare les produits sélectionnés pour la table pivot.
     */
    
    
     /**
 * Valide et prépare les éléments sélectionnés
 * pour la table pivot catering_menu_item.
 */
    private function validatedMenuItems(Request $request): array
    {
        $rows = collect($request->input('menu_items', []))
            ->filter(fn ($row) => is_array($row) && !empty($row['selected']))
            ->map(function ($row, $menuItemId) {
                return [
                    'id' => $menuItemId,
                    'quantity' => $row['quantity'] ?? null,
                ];
            })
            ->values()
            ->all();

        $validator = Validator::make(
            ['menu_items' => $rows],
            [
                'menu_items' => ['array'],
                'menu_items.*.id' => [
                    'required',
                    'integer',
                    'distinct',
                    'exists:catering_menu_items,id',
                ],
                'menu_items.*.quantity' => [
                    'required',
                    'integer',
                    'min:1',
                ],
            ],
            [
                'menu_items.*.quantity.required' =>
                    'Indique une quantité pour chaque élément sélectionné.',
            ]
        );

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return collect($validator->validated()['menu_items'])
            ->mapWithKeys(fn ($item) => [
                $item['id'] => [
                    'quantity' => $item['quantity'],
                ],
            ])
            ->all();
    }








    public function destroy(Menu $menu)
    {
        $menu->delete();

        return redirect()
            ->route('admin.catering-menus.index')
            ->with('success', 'Menu supprimé avec succès.');
    }
}
