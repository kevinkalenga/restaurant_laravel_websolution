<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SliderController extends Controller
{

    // php artisan make:controller Admin/SliderController -r
    // Method   URI                      Name
    // GET      admin/sliders             admin.sliders.index
    // POST     admin/sliders             admin.sliders.store
    // GET      admin/sliders/create      admin.sliders.create
    // GET      admin/sliders/{slider}    admin.sliders.show




    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.slider.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
