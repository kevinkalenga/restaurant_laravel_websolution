<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Allergen;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AllergenController extends Controller
{
    public function index()
    {
        $allergens = Allergen::withCount('products')
            ->orderBy('name')
            ->paginate(10);

        return view('admin.allergens.index', compact('allergens'));
    }

    public function create()
    {
        return view('admin.allergens.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:allergens,name'],
            'description' => ['nullable', 'string'],
        ]);

        Allergen::create($validated);

        return redirect()
            ->route('admin.allergens.index')
            ->with('success', 'Allergène créé avec succès.');
    }

    public function edit(Allergen $allergen)
    {
        return view('admin.allergens.edit', compact('allergen'));
    }

    public function update(Request $request, Allergen $allergen)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('allergens', 'name')->ignore($allergen->id),
            ],
            'description' => ['nullable', 'string'],
        ]);

        $allergen->update($validated);

        return redirect()
            ->route('admin.allergens.index')
            ->with('success', 'Allergène modifié avec succès.');
    }

    public function destroy(Allergen $allergen)
    {
        $allergen->products()->detach();
        $allergen->delete();

        return redirect()
            ->route('admin.allergens.index')
            ->with('success', 'Allergène supprimé avec succès.');
    }
}
