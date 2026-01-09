<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\ProfileUpdateRequest;
use Auth;

class ProfileController extends Controller
{
    public function index()
    {
     return view('admin.profile.index');
    }

    public function updateProfile(ProfileUpdateRequest $request)
   {
      // dd($request->all());
      // user instance
     $user = Auth::user();
     
    //   $imagePath = $this->uploadImage($request, 'avatar');
      //dd($imagePath);

     $user->name = $request->name;
     $user->email = $request->email;
    //  $user->avatar = isset($imagePath) ? $imagePath : $user->avatar;
     $user->save();
     
     
     return redirect()->back()->with('status', 'Admin Updated Successfully!');
   }
}
