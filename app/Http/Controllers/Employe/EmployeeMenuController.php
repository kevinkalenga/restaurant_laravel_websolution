<?php

namespace App\Http\Controllers\Employe;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuItem;
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
        $menuItems = MenuItem::orderBy('category')
            ->orderBy('name')
            ->get();

        return view(
            'employe.catering-menus.create',
            compact('menuItems')
        );
    }

    public function edit(Menu $menu)
    {
        $menuItems = MenuItem::orderBy('category')
            ->orderBy('name')
            ->get();

        $menu->load(['menuItems', 'galleries']);

        return view(
            'employe.catering-menus.edit',
            compact('menu', 'menuItems')
        );
    }

    public function store(Request $request)
    {
        $validated = $this->validateMenu($request);
        $selectedMenuItems = $this->validatedMenuItems($request);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')
                ->store('catering-menus', 'public');
        }

        $validated['slug'] = $this->uniqueSlug($validated['title']);
        $validated['status'] = $request->boolean('status');

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
            ->route('employe.catering-menus.index')
            ->with('success', 'Menu créé avec succès.');
    }

    public function update(Request $request, Menu $menu)
    {
        $validated = $this->validateMenu($request);
        $selectedMenuItems = $this->validatedMenuItems($request);

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

        $menu->menuItems()->sync($selectedMenuItems);

        // Supprimer les photos sélectionnées
        if ($request->filled('delete_gallery')) {
            $galleries = $menu->galleries()
                ->whereIn('id', $request->input('delete_gallery'))
                ->get();

            foreach ($galleries as $gallery) {
                Storage::disk('public')->delete($gallery->image);
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
            ->route('employe.catering-menus.index')
            ->with('success', 'Menu modifié avec succès.');
    }

    public function destroy(Menu $menu)
    {
        $image = $menu->image;

        // Récupérer les photos de la galerie avant suppression
        $galleries = $menu->galleries()->get();

        // Détacher les éléments du menu
        $menu->menuItems()->detach();

        // Supprimer le menu
        $menu->delete();

        // Supprimer l'image principale
        if ($image) {
            Storage::disk('public')->delete($image);
        }

        // Supprimer les fichiers de la galerie
        foreach ($galleries as $gallery) {
            Storage::disk('public')->delete($gallery->image);
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
            'gallery' => ['nullable', 'array'],
            'gallery.*' => ['image', 'max:2048'],
            'delete_gallery' => ['nullable', 'array'],
            'delete_gallery.*' => ['integer'],
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
                ->when(
                    $ignoreId,
                    fn ($query) => $query->where('id', '!=', $ignoreId)
                )
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter++;
        }

        return $slug;
    }

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
                'menu_items.*.quantity.min' =>
                    'La quantité doit être au minimum de 1.',
            ]
        );

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return collect($validator->validated()['menu_items'] ?? [])
            ->mapWithKeys(fn ($menuItem) => [
                $menuItem['id'] => [
                    'quantity' => $menuItem['quantity'],
                ],
            ])
            ->all();
    }
}
