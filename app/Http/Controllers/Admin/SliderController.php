<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Slider;
use App\Traits\FileUploadTrait;

class SliderController extends Controller
{

    // php artisan make:controller Admin/SliderController -r
    // Method   URI                      Name
    // GET      admin/sliders             admin.sliders.index
    // POST     admin/sliders             admin.sliders.store
    // GET      admin/sliders/create      admin.sliders.create
    // GET      admin/sliders/{slider}    admin.sliders.show

      use FileUploadTrait;


    /**
     * Display a listing of the resource.
     */
    

    public function index()
    {
      if (request()->ajax()) {
        $sliders = Slider::query();

        return DataTables::of($sliders)
            ->addColumn('image', function ($slider) {
                //  Chemin correct pour ton trait : public/uploads/…
                return asset($slider->image);
            })
             ->addColumn('action', function ($slider) {
    return '
        <a href="'.route('admin.sliders.edit', $slider->id).'" 
           class="text-primary fw-bold">
            Edit
        </a>
        |
        <a href="'.route('admin.sliders.destroy', $slider->id).'" 
           class="text-danger fw-bold"
           onclick="event.preventDefault();
           if(confirm(\'Are you sure you want to delete?\')) {
               document.getElementById(\'delete-form-'.$slider->id.'\').submit();
           }">
            Delete
        </a>

        <form id="delete-form-'.$slider->id.'" 
              action="'.route('admin.sliders.destroy', $slider->id).'" 
              method="POST" style="display:none;">
            '.csrf_field().'
            '.method_field('DELETE').'
        </form>
    ';
})
->rawColumns(['action'])

            ->rawColumns(['action']) // seul 'action' doit être raw ici car le <img> est géré par le render JS
            ->make(true);
      }

    return view('admin.slider.index');
}






    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.slider.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
              'image' => 'required|image|max:2048',
              'offer' => 'nullable|string|max:255',
              'title' => 'required|string|max:255',
              'sub_title' => 'required|string|max:255',
              'short_description' => 'required|string',
              'button_link' => 'nullable|url',
              'status' => 'required|boolean',
        ]);

           // Utiliser le trait pour uploader l'image
          $imagePath = $this->uploadImage($request, 'image', 'uploads');

        Slider::create([
              'image' => $imagePath,
              'offer' => $request->offer,
              'title' => $request->title,
              'sub_title' => $request->sub_title,
              'short_description' => $request->short_description,
              'button_link' => $request->button_link,
              'status' => $request->status,
        ]);

        return redirect()->route('admin.sliders.index')->with('success', 'Slider created successfully!');
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
         $slider = Slider::findOrFail($id);
         return view('admin.slider.edit', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $slider = Slider::findOrFail($id);

        $request->validate([
           'image' => 'nullable|image|max:2048',
           'offer' => 'nullable|string|max:255',
           'title' => 'required|string|max:255',
           'sub_title' => 'required|string|max:255',
           'short_description' => 'required|string',
           'button_link' => 'nullable|url',
           'status' => 'required|boolean',
        ]);

        // Si une nouvelle image est uploadée
        if ($request->hasFile('image')) {

           // Supprimer l'ancienne image
           if ($slider->image && file_exists(public_path($slider->image))) {
               unlink(public_path($slider->image));
           }

           // Upload nouvelle image via le trait
           $slider->image = $this->uploadImage($request, 'image', 'uploads');
        }

         // Mise à jour des autres champs
        $slider->update([
           'offer' => $request->offer,
           'title' => $request->title,
           'sub_title' => $request->sub_title,
           'short_description' => $request->short_description,
           'button_link' => $request->button_link,
           'status' => $request->status,
        ]);


         return redirect()
           ->route('admin.sliders.index')
           ->with('status', 'Slider updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $slider = Slider::findOrFail($id);

        // Supprimer l'image si elle existe
       if (file_exists(public_path($slider->image))) {
        unlink(public_path($slider->image));
       }

        $slider->delete();

        return redirect()
        ->route('admin.sliders.index')
        ->with('status', 'Slider deleted successfully!');
    }
}
