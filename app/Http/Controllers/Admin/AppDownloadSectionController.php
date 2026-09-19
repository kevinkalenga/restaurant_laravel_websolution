<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\FileUploadTrait;
use App\Models\AppDownloadSection;

class AppDownloadSectionController extends Controller
{
     use FileUploadTrait;
    
    public function index()
    {
        $appSection = AppDownloadSection::first();
        return view('admin.app-download-section.index', compact('appSection'));
    }

   
   
    public function store(Request $request)
    {
            $request->validate([
                'image' => 'nullable|image|max:2048',
                'background' => 'nullable|image|max:2048',
                'title' => 'required|string|max:255',
                'short_description' => 'required|string|max:1000',
                'play_store_link' => 'nullable|url',
                'apple_store_link' => 'nullable|url',
            ]);

            $data = [
                'image' => $request->old_image,
                'background' => $request->old_background,
                'title' => $request->title,
                'short_description' => $request->short_description,
                'play_store_link' => $request->play_store_link,
                'apple_store_link' => $request->apple_store_link,
            ];

            // Nouvelle image
            if ($request->hasFile('image')) {
                $data['image'] = $this->uploadImage(
                    $request,
                    'image',
                    'uploads'
                );
            }

            // Nouveau background
            if ($request->hasFile('background')) {
                $data['background'] = $this->uploadImage(
                    $request,
                    'background',
                    'uploads'
                );
            }

            AppDownloadSection::updateOrCreate(
                ['id' => 1],
                $data
            );

            return redirect()
                ->back()
                ->with('success', 'App download updated successfully!');
    }


}
