<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\FileUploadTrait;
use App\Models\Chef;

class ChefController extends Controller
{
     use FileUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         return view('admin.chef.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.chef.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
              'image' => 'required|image|max:2048',
              'name' => 'required|string|max:255',
              'title' => 'required|string|max:255',
              'fb' => 'nullable|string|url|max:255',
              'in' => 'nullable|string|url|max:255',
              'x' => 'nullable|string|url|max:255',
              'web' => 'nullable|string|url|max:255',
              'show_at_home' => 'required|boolean',
              'status' => 'required|boolean',
        ]);

        // Utiliser le trait pour uploader l'image
        $imagePath = $this->uploadImage($request, 'image', 'uploads');

        Chef::create([
            'image' => $imagePath,
            'name' => $request->name,
            'title' => $request->title,
            'fb' => $request->fb,
            'in' => $request->in,
            'x' => $request->x,
            'web' => $request->web,
            'show_at_home' => $request->show_at_home,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.chefs.index')->with('success', 'Chef created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
