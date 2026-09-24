<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogCategory;
use App\Traits\FileUploadTrait;
use App\Models\Blog;
use Illuminate\Support\Str;
use Auth;

class BlogController extends Controller
{
     use FileUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         return view('admin.blog.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = BlogCategory::all();
         return view('admin.blog.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
     
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'title' => 'required|string|max:255|unique:blogs,title',
            'category_id' => 'required|exists:blog_categories,id',
            'description' => 'required|string',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        $imagePath = $this->uploadImage($request, 'image', 'uploads');

        Blog::create([
            'user_id' => Auth::id(),
            'image' => $imagePath,
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'category_id' => $request->category_id,
            'description' => $request->description,
            'seo_title' => $request->seo_title,
            'seo_description' => $request->seo_description,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('admin.blogs.index')
            ->with('success', 'Blog created successfully!');
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
