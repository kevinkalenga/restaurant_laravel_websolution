<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;
use DataTables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function index()
{
      if (request()->ajax()) {
        $categories = Category::query();

        return DataTables::of($categories)

            ->addColumn('action', function ($category) {
                return '
                    <a href="'.route('admin.category.edit', $category->id).'" 
                       class="text-primary fw-bold">
                        Edit
                    </a>
                    |
                    <a href="'.route('admin.category.destroy', $category->id).'" 
                       class="text-danger fw-bold"
                       onclick="event.preventDefault();
                       if(confirm(\'Are you sure you want to delete?\')) {
                           document.getElementById(\'delete-form-'.$category->id.'\').submit();
                       }">
                        Delete
                    </a>

                    <form id="delete-form-'.$category->id.'" 
                          action="'.route('admin.category.destroy', $category->id).'" 
                          method="POST" style="display:none;">
                        '.csrf_field().'
                        '.method_field('DELETE').'
                    </form>
                ';
            })

            ->rawColumns(['action'])
            ->make(true);
       }

       return view('admin.product.category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.product.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'name' => ['required', 'max:255'],
            'status' => ['required', 'boolean'],
            'show_at_home' => ['required', 'boolean'],
        ]);

        // Création
        $category = new Category();
        $category->name = $request->name;
        $category->slug = Str::slug($request->name); // auto slug
        $category->status = $request->status;
        $category->show_at_home = $request->show_at_home;
        $category->save();

        // Redirection
        return redirect()
            ->route('admin.category.index')
            ->with('success', 'Category created successfully!');

        

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
