<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\FileUploadTrait;
use App\Models\BannerSlider;
use Yajra\DataTables\Facades\DataTables;

class BannerSliderController extends Controller
{

     use FileUploadTrait;
    

     /**
     * Display a listing of the resource.
     */
   
     public function index()
    {
            if (request()->ajax()) {

                $banners = BannerSlider::query();

                return DataTables::of($banners)

                    ->addColumn('banner', function ($banner) {
                        return asset($banner->banner);
                    })

                    ->addColumn('action', function ($banner) {

                        return '
                            <a href="' . route('admin.banner-slider.edit', $banner->id) . '"
                            class="text-primary fw-bold">
                                <i class="fas fa-edit"></i>
                            </a>
                            |
                            <a href="' . route('admin.banner-slider.destroy', $banner->id) . '"
                            class="text-danger fw-bold"
                            onclick="event.preventDefault();
                            if(confirm(\'Are you sure you want to delete?\')) {
                                document.getElementById(\'delete-form-' . $banner->id . '\').submit();
                            }">
                                 <i class="fas fa-trash"></i>
                            </a>

                            <form id="delete-form-' . $banner->id . '"
                                action="' . route('admin.banner-slider.destroy', $banner->id) . '"
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

            return view('admin.banner-slider.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view('admin.banner-slider.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
              'banner' => 'required|image|max:2048',
              'title' => 'required|string|max:255',
              'sub_title' => 'required|string|max:255',
              'url' => 'required',
              'status' => 'required|boolean',
        ]);

        // Utiliser le trait pour uploader l'image
        $imagePath = $this->uploadImage($request, 'banner', 'uploads');

        BannerSlider::create([
            'banner' => $imagePath,
            'title' => $request->title,
            'sub_title' => $request->sub_title,
            'url' => $request->url,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.banner-slider.index')->with('success', 'Banner Slider created successfully!');
    }

   

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $bannerSlider = BannerSlider::findOrFail($id);

       return view('admin.banner-slider.edit', compact('bannerSlider'));
    }

    /**
     * Update the specified resource in storage.
     */
    
    public function update(Request $request, string $id)
    {
        $bannerSlider = BannerSlider::findOrFail($id);

        $request->validate([
            'banner' => 'nullable|image|max:2048',
            'title' => 'required|string|max:255',
            'sub_title' => 'required|string|max:255',
            'url' => 'required',
            'status' => 'required|boolean',
        ]);

        if ($request->hasFile('banner')) {

            if ($bannerSlider->banner && file_exists(public_path($bannerSlider->banner))) {
                unlink(public_path($bannerSlider->banner));
            }

            $bannerSlider->banner = $this->uploadImage($request, 'banner', 'uploads');
        }

        $bannerSlider->update([
            'title' => $request->title,
            'sub_title' => $request->sub_title,
            'url' => $request->url,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('admin.banner-slider.index')
            ->with('status', 'Banner Slider updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         $coupon = BannerSlider::findOrFail($id);

      

        $coupon->delete();

        return redirect()
            ->route('admin.banner-slider.index')
            ->with('success', 'Banner Slider deleted successfully!');
    }
}
