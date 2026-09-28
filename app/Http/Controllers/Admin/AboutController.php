<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\About;
use App\Traits\FileUploadTrait;

class AboutController extends Controller
{
     use FileUploadTrait;
    public function index()
    {
        $about = About::first();
        return view('admin.about.index', compact('about'));
    }
    public function update(Request $request)
    {
       


        $request->validate([
              'image' => 'nullable|image|max:2048',
              'title' => 'required|string|max:255',
              'main_title' => 'required|string|max:255',
              'description' => 'required|string',
              'video_link' => 'required|url',
          
        ]);

        $imagePath = $this->uploadImage($request, 'image', 'uploads', $request->old_image);

        About::updateOrCreate(
            ['id' => 1],
            [
                'image' => !empty($imagePath) ? $imagePath : $request->old_image,
                'title' => $request->title,
                'main_title' => $request->main_title,
                'description' => $request->description,
                'video_link' => $request->video_link
            ]
        );

         return redirect()->back()->with('success', 'About Update successfully!');
    }
}
