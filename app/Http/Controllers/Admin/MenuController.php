<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::latest()->paginate(10);

        return view('admin.catering-menus.index', compact('menus'));
    }

    public function create()
    {
        return view('admin.catering-menus.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
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

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')
                ->store('catering-menus', 'public');
        }

        $validated['slug'] = Str::slug($validated['title']);
        $validated['status'] = $request->boolean('status');

        $baseSlug = $validated['slug'];
        $counter = 1;

        while (Menu::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $baseSlug . '-' . $counter++;
        }

        Menu::create($validated);

        return redirect()
            ->route('admin.catering-menus.index')
            ->with('success', 'Menu créé avec succès.');
    }

    public function edit(Menu $menu)
    {
        return view('admin.catering-menus.edit', compact('menu'));
    }

    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
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

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')
                ->store('catering-menus', 'public');
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

        return redirect()
            ->route('admin.catering-menus.index')
            ->with('success', 'Menu modifié avec succès.');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();

        return redirect()
            ->route('admin.catering-menus.index')
            ->with('success', 'Menu supprimé avec succès.');
    }
}
