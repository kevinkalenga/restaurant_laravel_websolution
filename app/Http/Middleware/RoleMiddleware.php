<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        // we get the instance of the user from the request 
        // if($request->user()->role === $role) {
        //    return $next($request);
        // }

         // Vérifie si l'utilisateur est connecté et Vérifie si l'utilisateur a le bon rôle

        if (!$request->user() || $request->user()->role !== $role) {
          return to_route('dashboard');
        }

       return $next($request);


        
       
    }
}
