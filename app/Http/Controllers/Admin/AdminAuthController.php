<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class AdminAuthController extends Controller
{
    public function index()
    {
         return view('admin.auth.login');
       
    }


    // public function login(Request $request)
    // {
    //     $credentials = $request->validate([
    //         'email' => ['required', 'email'],
    //         'password' => ['required'],
    //     ]);

    //     if (Auth::guard('admin')->attempt($credentials)) {

    //     if (Auth::guard('admin')->user()->role !== 'admin') {
    //         Auth::guard('admin')->logout();

    //         return back()->withErrors([
    //             'email' => 'You must be an Administrator',
    //         ]);
    //     }

    //     $request->session()->regenerate();

    //     return redirect()->route('admin.dashboard');
    // }

    //     return back()->withErrors([
    //         'email' => 'Invalide credentials',
    //     ]);
    // } 


}
