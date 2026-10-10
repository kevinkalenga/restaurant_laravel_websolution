<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Vérifier que l'utilisateur est connecté
        if (!$request->user()) {
            return to_route('login');
        }

        // Vérifier que son compte est actif
        if (!$request->user()->is_active) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return to_route('login')
                ->withErrors([
                    'email' => 'Votre compte a été désactivé. Contactez l’administrateur.',
                ]);
        }

        // Vérifier le rôle autorisé
        if ($request->user()->role !== $role) {
            return to_route('dashboard');
        }

        return $next($request);
    }
}
