<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogCategory;
use App\Traits\FileUploadTrait;
use App\Models\Blog;
use Illuminate\Support\Str;
use Auth;
use Yajra\DataTables\Facades\DataTables;

class BlogController extends Controller
{
     use FileUploadTrait;
    /**
     * Display a listing of the resource.
     */
     
    public function index()
    {
        if (request()->ajax()) {

            $blogs = Blog::with(['category'])->select('blogs.*');

            return DataTables::of($blogs)

                ->addColumn('category_name', function ($blog) {
                    return $blog->category
                        ? $blog->category->name
                        : '-';
                })

                ->addColumn('user_name', function ($blog) {
                    return $blog->user
                        ? $blog->user->name
                        : '-';
                })

                ->addColumn('action', function ($blog) {
                    return '
                        <a href="' . route('admin.blogs.edit', $blog->id) . '"
                        class="text-primary fw-bold">
                            Edit
                        </a>
                        |
                        <a href="' . route('admin.blogs.destroy', $blog->id) . '"
                        class="text-danger fw-bold"
                        onclick="event.preventDefault();
                        if(confirm(\'Are you sure you want to delete?\')) {
                            document.getElementById(\'delete-form-' . $blog->id . '\').submit();
                        }">
                            Delete
                        </a>

                        <form id="delete-form-' . $blog->id . '"
                            action="' . route('admin.blogs.destroy', $blog->id) . '"
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
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $blog = Blog::findOrFail($id);
        $categories = BlogCategory::all();

       return view('admin.blog.edit', compact('blog', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         $blog = Blog::findOrFail($id);

        $request->validate([
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'title' => 'required|string|max:255|unique:blogs,title,' . $blog->id,
            'category_id' => 'required|exists:blog_categories,id',
            'description' => 'required|string',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'category_id' => $request->category_id,
            'description' => $request->description,
            'seo_title' => $request->seo_title,
            'seo_description' => $request->seo_description,
            'status' => $request->status,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadImage($request, 'image', 'uploads');
        }

        $blog->update($data);

        return redirect()
            ->route('admin.blogs.index')
            ->with('success', 'Blog updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $blog = Blog::findOrFail($id);

        // Supprimer l'image
        if ($blog->image) {

            $imagePath = public_path($blog->image);

            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        // Supprimer le blog
        $blog->delete();

        return redirect()
            ->route('admin.blogs.index')
            ->with('success', 'Blog deleted successfully!');
    }
}
