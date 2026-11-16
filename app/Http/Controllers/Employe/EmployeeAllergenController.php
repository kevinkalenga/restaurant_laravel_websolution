<?php

namespace App\Http\Controllers\Employe;

use App\Http\Controllers\Controller;
use App\Models\Allergen;
use Illuminate\Http\Request;

class EmployeeAllergenController extends Controller
{
    public function index()
    {
        $allergens = Allergen::orderBy('name')->paginate(10);

        return view('employe.allergens.index', compact('allergens'));
    }


    public function create()
    {
        return view('employe.allergens.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:allergens,name'],
            'description' => ['nullable', 'string'],
        ]);

        Allergen::create($validated);

        return redirect()
            ->route('employe.allergens.create')
            ->with('success', 'Allergène créé avec succès.');
    }
}
