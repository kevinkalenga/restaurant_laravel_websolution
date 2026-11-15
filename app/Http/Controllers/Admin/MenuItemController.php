<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\Allergen;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class MenuItemController extends Controller
{
    public function index()
    {
        $menuItems = MenuItem::latest()->paginate(10);

        return view('admin.menu-items.index', compact('menuItems'));
    }

    public function create()
    {
        $allergens = Allergen::orderBy('name')->get();

        return view('admin.menu-items.create', compact('allergens'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'category' => ['required', Rule::in(['entree', 'plat', 'dessert'])],
            'price' => ['nullable', 'numeric', 'min:0'],
            'image' => ['nullable', 'image', 'max:2048'],
            'status' => ['nullable', 'boolean'],
            'allergens' => ['nullable', 'array'],
            'allergens.*' => ['integer', 'exists:allergens,id'],
        ]);

        $selectedAllergens = $validated['allergens'] ?? [];
        unset($validated['allergens']);

        $validated['slug'] = $this->generateSlug($validated['name']);
        $validated['status'] = $request->boolean('status');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')
                ->store('catering-items', 'public');
        }

        $menuItem = MenuItem::create($validated);

        $menuItem->allergens()->sync($selectedAllergens);

        return redirect()
            ->route('admin.menu-items.index')
            ->with('success', 'Élément traiteur créé avec succès.');
    }

    public function edit(MenuItem $menuItem)
    {
        $allergens = Allergen::orderBy('name')->get();

        $menuItem->load('allergens');

        return view('admin.menu-items.edit', compact('menuItem', 'allergens'));
    }

    public function update(Request $request, MenuItem $menuItem)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'category' => ['required', Rule::in(['entree', 'plat', 'dessert'])],
            'price' => ['nullable', 'numeric', 'min:0'],
            'image' => ['nullable', 'image', 'max:2048'],
            'status' => ['nullable', 'boolean'],
            'allergens' => ['nullable', 'array'],
            'allergens.*' => ['integer', 'exists:allergens,id'],
        ]);

        $selectedAllergens = $validated['allergens'] ?? [];
        unset($validated['allergens']);

        $validated['slug'] = $this->generateSlug(
            $validated['name'],
            $menuItem->id
        );

        $validated['status'] = $request->boolean('status');

        if ($request->hasFile('image')) {
            if ($menuItem->image) {
                Storage::disk('public')->delete($menuItem->image);
            }

            $validated['image'] = $request->file('image')
                ->store('catering-items', 'public');
        } else {
            unset($validated['image']);
        }

        $menuItem->update($validated);

        $menuItem->allergens()->sync($selectedAllergens);

        return redirect()
            ->route('admin.menu-items.index')
            ->with('success', 'Élément traiteur modifié avec succès.');
    }

    public function destroy(MenuItem $menuItem)
    {
        if ($menuItem->image) {
            Storage::disk('public')->delete($menuItem->image);
        }

        $menuItem->delete();

        return redirect()
            ->route('admin.menu-items.index')
            ->with('success', 'Élément traiteur supprimé avec succès.');
    }

    private function generateSlug(string $name, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $counter = 1;

        while (
            MenuItem::where('slug', $slug)
                ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter++;
        }

        return $slug;
    }
}
