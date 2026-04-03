<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

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

            ->addColumn('image', function ($category) {
                return asset($category->image);
            })

            ->addColumn('action', function ($category) {
                return '
                    <a href="'.route('admin.categories.edit', $category->id).'" 
                       class="text-primary fw-bold">
                        Edit
                    </a>
                    |
                    <a href="'.route('admin.categories.destroy', $category->id).'" 
                       class="text-danger fw-bold"
                       onclick="event.preventDefault();
                       if(confirm(\'Are you sure you want to delete?\')) {
                           document.getElementById(\'delete-form-'.$category->id.'\').submit();
                       }">
                        Delete
                    </a>

                    <form id="delete-form-'.$category->id.'" 
                          action="'.route('admin.categories.destroy', $category->id).'" 
                          method="POST" style="display:none;">
                        '.csrf_field().'
                        '.method_field('DELETE').'
                    </form>
                ';
            })

            ->rawColumns(['action']) // important ⚠️
            ->make(true);
        }

      return view('admin.product.category.index');
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
