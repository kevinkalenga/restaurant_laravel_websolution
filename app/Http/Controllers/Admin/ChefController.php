<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\FileUploadTrait;
use App\Models\Chef;
use Yajra\DataTables\Facades\DataTables;

class ChefController extends Controller
{
     use FileUploadTrait;
    /**
     * Display a listing of the resource.
     */
     
    public function index()
    {
        if (request()->ajax()) {

            $chefs = Chef::query();

            return DataTables::of($chefs)

                /*
                |--------------------------------------------------------------------------
                | Image
                |--------------------------------------------------------------------------
                */
                ->addColumn('image', function ($chef) {

                    if (!$chef->image) {
                        return null;
                    }

                    return asset($chef->image);
                })

                /*
                |--------------------------------------------------------------------------
                | Name
                |--------------------------------------------------------------------------
                */
                ->addColumn('name', function ($chef) {

                    return $chef->name ?? 'N/A';
                })

                /*
                |--------------------------------------------------------------------------
                | Title
                |--------------------------------------------------------------------------
                */
                ->addColumn('title', function ($chef) {

                    return $chef->title ?? 'N/A';
                })

                /*
                |--------------------------------------------------------------------------
                | Show At Home
                |--------------------------------------------------------------------------
                */
                ->addColumn('show_at_home', function ($chef) {

                    return $chef->show_at_home
                        ? '<span class="badge badge-success">Yes</span>'
                        : '<span class="badge badge-danger">No</span>';
                })

                /*
                |--------------------------------------------------------------------------
                | Status
                |--------------------------------------------------------------------------
                */
                ->addColumn('status', function ($chef) {

                    return $chef->status
                        ? '<span class="badge badge-success">Active</span>'
                        : '<span class="badge badge-danger">Inactive</span>';
                })

                /*
                |--------------------------------------------------------------------------
                | Action
                |--------------------------------------------------------------------------
                */
                ->addColumn('action', function ($chef) {

                    return '
                        <a href="' . route('admin.chefs.edit', $chef->id) . '"
                            class="btn btn-sm btn-primary mr-1">
                            <i class="fas fa-edit"></i>
                        </a>

                        <a href="' . route('admin.chefs.destroy', $chef->id) . '"
                            class="btn btn-sm btn-danger"
                            onclick="event.preventDefault();
                            if(confirm(\'Are you sure you want to delete?\')) {
                                document.getElementById(\'delete-form-' . $chef->id . '\').submit();
                            }">
                            <i class="fas fa-trash"></i>
                        </a>

                        <form id="delete-form-' . $chef->id . '"
                            action="' . route('admin.chefs.destroy', $chef->id) . '"
                            method="POST"
                            style="display:none;">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                        </form>
                    ';
                })

                ->rawColumns([
                    'show_at_home',
                    'status',
                    'action'
                ])

                ->make(true);
        }

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
