<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\FileUploadTrait;
use App\Models\Testimonial;
use App\Models\SectionTitle;
use Yajra\DataTables\DataTables;

class TestimonialController extends Controller
{
     use FileUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {

            $testimonials = Testimonial::query();

             return DataTables::of($testimonials)

            /*
            |--------------------------------------------------------------------------
            | Image
            |--------------------------------------------------------------------------
            */
            ->addColumn('image', function ($testimonial) {

                if (!$testimonial->image) {
                    return null;
                }

                return asset($testimonial->image);
            })

            /*
            |--------------------------------------------------------------------------
            | Name
            |--------------------------------------------------------------------------
            */
            ->addColumn('name', function ($testimonial) {

                return $testimonial->name ?? 'N/A';
            })

            /*
            |--------------------------------------------------------------------------
            | Title
            |--------------------------------------------------------------------------
            */
            ->addColumn('title', function ($testimonial) {

                return $testimonial->title ?? 'N/A';
            })

            /*
            |--------------------------------------------------------------------------
            | Review
            |--------------------------------------------------------------------------
            */
            ->addColumn('review', function ($testimonial) {

                return $testimonial->review ?? 'N/A';
            })

            /*
            |--------------------------------------------------------------------------
            | Rating
            |--------------------------------------------------------------------------
            */
            ->addColumn('rating', function ($testimonial) {

                return $testimonial->rating ?? 0;
            })

            /*
            |--------------------------------------------------------------------------
            | Show At Home
            |--------------------------------------------------------------------------
            */
            ->addColumn('show_at_home', function ($testimonial) {

                return $testimonial->show_at_home
                    ? '<span class="badge badge-success">Yes</span>'
                    : '<span class="badge badge-danger">No</span>';
            })

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */
            ->addColumn('status', function ($testimonial) {

                return $testimonial->status
                    ? '<span class="badge badge-success">Active</span>'
                    : '<span class="badge badge-danger">Inactive</span>';
            })

            /*
            |--------------------------------------------------------------------------
            | Action
            |--------------------------------------------------------------------------
            */
            ->addColumn('action', function ($testimonial) {

                        return '
                            <a href="' . route('admin.testimonial.edit', $testimonial->id) . '"
                                class="btn btn-sm btn-primary mr-1">
                                <i class="fas fa-edit"></i>
                            </a>

                            <a href="' . route('admin.testimonial.destroy', $testimonial->id) . '"
                                class="btn btn-sm btn-danger"
                                onclick="event.preventDefault();
                                if(confirm(\'Are you sure you want to delete?\')) {
                                    document.getElementById(\'delete-form-' . $testimonial->id . '\').submit();
                                }">
                                <i class="fas fa-trash"></i>
                            </a>

                            <form id="delete-form-' . $testimonial->id . '"
                                action="' . route('admin.testimonial.destroy', $testimonial->id) . '"
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

        $keys = [
            'why_choose_top_title',
            'why_choose_main_title',
            'why_choose_sub_title'
        ];

        $titles = SectionTitle::whereIn('key', $keys)
            ->pluck('value', 'key');

        return view('admin.testimonial.index', compact('titles'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.testimonial.create');
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
              'rating' => 'required|integer|max:5',
              'review' => 'required|string|max:1000',
              'show_at_home' => 'required|boolean',
              'status' => 'required|boolean',
        ]);

         // Utiliser le trait pour uploader l'image
        $imagePath = $this->uploadImage($request, 'image', 'uploads');

        Testimonial::create([
            'image' => $imagePath,
            'name' => $request->name,
            'title' => $request->title,
            'rating' => $request->rating,
            'review' => $request->review,
            'show_at_home' => $request->show_at_home,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.testimonial.index')->with('success', 'Testimonial created successfully!');
    }

   

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
         $testimonial = Testimonial::findOrFail($id);
         return view('admin.testimonial.edit', compact('testimonial'));
    }

    /**
 * Update the specified resource in storage.
 */
    public function update(Request $request, string $id)
    {
        $testimonial = Testimonial::findOrFail($id);

        $request->validate([
            'image' => 'nullable|image|max:2048',
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|max:1000',
            'show_at_home' => 'required|boolean',
            'status' => 'required|boolean',
        ]);

        $data = [
            'name' => $request->name,
            'title' => $request->title,
            'rating' => $request->rating,
            'review' => $request->review,
            'show_at_home' => $request->show_at_home,
            'status' => $request->status,
        ];

        // Si une nouvelle image est envoyée
        if ($request->hasFile('image')) {

            // Supprimer l'ancienne image
            if ($testimonial->image && file_exists(public_path($testimonial->image))) {
                unlink(public_path($testimonial->image));
            }

            // Upload de la nouvelle image
            $data['image'] = $this->uploadImage(
                $request,
                'image',
                'uploads'
            );
        }

        $testimonial->update($data);

        return redirect()
            ->route('admin.testimonial.index')
            ->with('success', 'Testimonial updated successfully!');
    }

   /**
    * Remove the specified resource from storage.
   */
    public function destroy(string $id)
    {
        $testimonial = Testimonial::findOrFail($id);

        // Supprimer l'image
        if ($testimonial->image && file_exists(public_path($testimonial->image))) {
            unlink(public_path($testimonial->image));
        }

        // Supprimer le testimonial
        $testimonial->delete();

        return redirect()
            ->route('admin.testimonial.index')
            ->with('success', 'Testimonial deleted successfully!');
    }
}
