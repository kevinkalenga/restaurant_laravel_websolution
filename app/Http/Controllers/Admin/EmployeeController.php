<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Notifications\EmployeeAccountCreated;

class EmployeeController extends Controller
{
    /**
     * Afficher la liste des employés.
     */
    public function index()
    {
        $employees = User::where('role', 'employe')
            ->orderBy('name')
            ->get();

        return view('admin.employees.index', compact('employees'));
    }

    /**
     * Afficher le formulaire de création.
     */
    public function create()
    {
        return view('admin.employees.create');
    }

    /**
     * Enregistrer un nouveau compte employé.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => [
                'required',
                'confirmed',
                Password::min(10)->mixedCase()->numbers()->symbols(),
            ],
        ]);

        $employee = User::create([
          'name' => $validated['name'],
          'email' => strtolower($validated['email']),
          'password' => Hash::make($validated['password']),
          'role' => 'employe',
          'is_active' => true,
        ]);

       try {
          $employee->notify(new EmployeeAccountCreated());
       } catch (\Throwable $exception) {
          report($exception);
       }

        return redirect()
            ->route('admin.employees.index')
            ->with('success', 'Le compte employé a été créé avec succès.');
    }

    /**
     * Activer ou désactiver un compte employé.
     */
    public function toggleStatus(User $employee)
    {
        abort_unless($employee->role === 'employe', 404);

        $employee->is_active = ! $employee->is_active;
        $employee->save();

        return redirect()
            ->route('admin.employees.index')
            ->with('success', $employee->is_active
                ? 'Le compte employé a été activé.'
                : 'Le compte employé a été désactivé.');
    }
}
