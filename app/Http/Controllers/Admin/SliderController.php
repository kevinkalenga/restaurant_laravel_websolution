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
    // public function index()
    // {
    //     if(request()->ajax()) {
    //       $sliders = Slider::query();
    //       return DataTables::of($sliders)
    //         ->addColumn('action', function($slider){
    //             // return '<a href="'.route("admin.sliders.edit", $slider->id).'" class="btn btn-sm btn-primary">Edit</a>';
    //              return '<img src="'.asset('storage/'.$slider->image).'" 
    //              style="width:80px; height:60px; object-fit:cover;">';
    //         })
    //         ->addColumn('image', function($slider){
    //             // return '<img src="'.asset($slider->image).'" width="80">';
    //             return '<img src="'.asset('storage/'.$slider->image).'" width="80">';

    //         })
    //         ->rawColumns(['action','image'])
    //         ->make(true);
    //     }
    
    //     return view('admin.slider.index');
    // }

    public function index()
    {
      if (request()->ajax()) {
        $sliders = Slider::query();

        return DataTables::of($sliders)
            ->addColumn('image', function ($slider) {
                // 🔥 Chemin correct pour ton trait : public/uploads/…
                return asset($slider->image);
            })
            ->addColumn('action', function ($slider) {
                return '<a href="'.route("admin.sliders.edit", $slider->id).'" class="btn btn-sm btn-primary">Edit</a>';
            })
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
