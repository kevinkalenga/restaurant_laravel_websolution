<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'string', 'max:20'],
            'password' => [
                'required', 
                'confirmed', 
                 Password::min(10) 
                          ->mixedCase() 
                          ->numbers() 
                          ->symbols(),
            ],
             
            [ 
                'password.required' => 'Le mot de passe est obligatoire.', 
                'password.confirmed' => 'Les mots de passe ne correspondent pas.', 
                'password.min' => 'Le mot de passe doit contenir au moins 10 caractères.', 
                'password.mixed' => 'Le mot de passe doit contenir au moins une majuscule et une minuscule.', 
                'password.numbers' => 'Le mot de passe doit contenir au moins un chiffre.', 
                'password.symbols' => 'Le mot de passe doit contenir au moins un caractère spécial.', 
            ]
            
           
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));
        Mail::to($user->email)->send(new WelcomeMail($user->name));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
