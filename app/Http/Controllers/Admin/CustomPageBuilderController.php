<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomPageBuilder;
use Illuminate\Support\Str;
use DataTables;

class CustomPageBuilderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {

            $pages = CustomPageBuilder::query();

            return DataTables::of($pages)

                ->addColumn('action', function ($page) {
                    return '
                        <a href="' . route('admin.custom-page-builder.edit', $page->id) . '"
                            class="btn btn-sm btn-primary mr-1">
                            <i class="fas fa-edit"></i>
                        </a>

                        <a href="' . route('admin.custom-page-builder.destroy', $page->id) . '"
                            class="btn btn-sm btn-danger"
                            onclick="event.preventDefault();
                            if(confirm(\'Are you sure you want to delete?\')) {
                                document.getElementById(\'delete-form-' . $page->id . '\').submit();
                            }">
                            <i class="fas fa-trash"></i>
                        </a>

                        <form id="delete-form-' . $page->id . '"
                            action="' . route('admin.custom-page-builder.destroy', $page->id) . '"
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

        return view('admin.custom-page-builder.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.custom-page-builder.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:200', 'unique:custom_page_builders,name'],
            'content' => ['required'],
            'status' => ['required', 'boolean'],
        ]);

        $page = new CustomPageBuilder();

        $page->name = $request->name;
        $page->slug = Str::slug($request->name);
        $page->content = $request->content;
        $page->status = $request->status;

        $page->save();

        return redirect()
            ->route('admin.custom-page-builder.index')
            ->with('success', 'Page created successfully!');
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
        $page = CustomPageBuilder::findOrFail($id);

        return view('admin.custom-page-builder.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $page = CustomPageBuilder::findOrFail($id);

        $request->validate([
            'name' => [
                'required',
                'max:200',
                'unique:custom_page_builders,name,' . $id,
            ],
            'content' => ['required'],
            'status' => ['required', 'boolean'],
        ]);

        $page->name = $request->name;
        $page->slug = Str::slug($request->name);
        $page->content = $request->content;
        $page->status = $request->status;

        $page->save();

        return redirect()
            ->route('admin.custom-page-builder.index')
            ->with('success', 'Page updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $page = CustomPageBuilder::findOrFail($id);

        $page->delete();

        return redirect()
            ->route('admin.custom-page-builder.index')
            ->with('success', 'Page deleted successfully!');
    }
}

