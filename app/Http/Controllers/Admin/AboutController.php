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
        return view('admin.about.index');
    }
    public function update(Request $request)
    {
       


        $request->validate([
              'image' => 'required|image|max:2048',
              'title' => 'required|string|max:255',
              'main_title' => 'required|string|max:255',
              'description' => 'required|string',
              'video_link' => 'required|url',
          
        ]);

        $imagePath = $this->uploadImage($request, 'image', 'uploads', $request->old_image);

        About::updateOrCreate(
            ['id' => 1],
            [
                'image' => $imagePath,
                'title' => $request->title,
                'main_title' => $request->main_title,
                'description' => $request->description,
                'video_link' => $request->video_link
            ]
        );

         return redirect()->back()->with('success', 'About Update successfully!');
    }
}
