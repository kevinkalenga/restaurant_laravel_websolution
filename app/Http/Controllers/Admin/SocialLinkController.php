<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SocialLink;
use Yajra\DataTables\Facades\DataTables;

class SocialLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     
    public function index()
    {
            if (request()->ajax()) {

                $socialLinks = SocialLink::query();

                return DataTables::of($socialLinks)

                    /*
                    |--------------------------------------------------------------------------
                    | Icon
                    |--------------------------------------------------------------------------
                    */
                    ->addColumn('icon', function ($socialLink) {

                        return $socialLink->icon ?? 'N/A';
                    })

                    /*
                    |--------------------------------------------------------------------------
                    | Name
                    |--------------------------------------------------------------------------
                    */
                    ->addColumn('name', function ($socialLink) {

                        return $socialLink->name ?? 'N/A';
                    })

                    /*
                    |--------------------------------------------------------------------------
                    | Link
                    |--------------------------------------------------------------------------
                    */
                    ->addColumn('link', function ($socialLink) {

                        return $socialLink->link
                            ? '<a href="' . $socialLink->link . '" target="_blank">
                                    ' . $socialLink->link . '
                            </a>'
                            : 'N/A';
                    })

                    /*
                    |--------------------------------------------------------------------------
                    | Status
                    |--------------------------------------------------------------------------
                    */
                    ->addColumn('status', function ($socialLink) {

                        return $socialLink->status
                            ? '<span class="badge badge-success">Active</span>'
                            : '<span class="badge badge-danger">Inactive</span>';
                    })

                    /*
                    |--------------------------------------------------------------------------
                    | Action
                    |--------------------------------------------------------------------------
                    */
                    ->addColumn('action', function ($socialLink) {

                        return '
                            <a href="' . route('admin.social-link.edit', $socialLink->id) . '"
                                class="btn btn-sm btn-primary mr-1">
                                <i class="fas fa-edit"></i>
                            </a>

                            <a href="' . route('admin.social-link.destroy', $socialLink->id) . '"
                                class="btn btn-sm btn-danger"
                                onclick="event.preventDefault();
                                if(confirm(\'Are you sure you want to delete?\')) {
                                    document.getElementById(\'delete-form-' . $socialLink->id . '\').submit();
                                }">
                                <i class="fas fa-trash"></i>
                            </a>

                            <form id="delete-form-' . $socialLink->id . '"
                                action="' . route('admin.social-link.destroy', $socialLink->id) . '"
                                method="POST"
                                style="display:none;">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                            </form>
                        ';
                    })

                    ->rawColumns([
                        'link',
                        'status',
                        'action'
                    ])

                    ->make(true);
            }

            return view('admin.social-link.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.social-link.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
              'icon' => 'required|string',
              'name' => 'required|string|max:255',
              'link' => 'required',
              'status' => 'required|boolean',
        ]);

        $link = new SocialLink();
        $link->icon = $request->icon;
        $link->name = $request->name;
        $link->link = $request->link;
        $link->status = $request->status;
       
        $link->save();

         return redirect()->route('admin.social-link.index')->with('success', 'Social link created successfully!');
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
