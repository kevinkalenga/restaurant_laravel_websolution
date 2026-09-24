<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogCategory;
use Illuminate\Support\Str;
use DataTables;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     
    public function index()
    {
        if (request()->ajax()) {

            $categories = BlogCategory::query();

            return DataTables::of($categories)

                ->addColumn('action', function ($category) {

                    return '
                        <a href="' . route('admin.blog-category.edit', $category->id) . '"
                        class="text-primary fw-bold">
                            Edit
                        </a>
                        |
                        <a href="' . route('admin.blog-category.destroy', $category->id) . '"
                        class="text-danger fw-bold"
                        onclick="event.preventDefault();
                        if(confirm(\'Are you sure you want to delete?\')) {
                            document.getElementById(\'delete-form-' . $category->id . '\').submit();
                        }">
                            Delete
                        </a>

                        <form id="delete-form-' . $category->id . '"
                            action="' . route('admin.blog-category.destroy', $category->id) . '"
                            method="POST"
                            style="display:none;">

                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '

                        </form>
                    ';
                })

                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.blog.blog-category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.blog.blog-category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $request->validate([
             
              'name' => 'required|string|max:255|unique:blog_categories,name',
              'status' => 'required|boolean',
        ]);

         BlogCategory::create([
           
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'status' => $request->status,
            
        ]);

        return redirect()->route('admin.blog-category.index')->with('success', 'Blog category created successfully!');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = BlogCategory::findOrFail($id);

        return view(
        'admin.blog.blog-category.edit',
        compact('category')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = BlogCategory::findOrFail($id);

        $request->validate([
        'name' => [
        'required',
        'string',
        'max:255',
        'unique:blog_categories,name,' . $category->id
        ],
        'status' => ['required', 'boolean'],
        ]);

        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->status = $request->status;

        $category->save();

        return redirect()
        ->route('admin.blog-category.index')
        ->with('success', 'Blog category updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = BlogCategory::findOrFail($id);

        $category->delete();

        return redirect()
        ->route('admin.blog-category.index')
        ->with('success', 'Blog category deleted successfully!');
    }
}
