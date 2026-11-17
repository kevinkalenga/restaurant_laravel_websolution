<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Requests\Frontend\ProfilePasswordUpdateRequest;
use App\Http\Requests\Frontend\ProfileUpdateRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Traits\FileUploadTrait;

class ProfileController extends Controller
{
    use FileUploadTrait;


    public function edit()
    {
        return view('profile.edit', [
            'user' => Auth::user(),
        ]);
    }




    public function updateProfile(ProfileUpdateRequest $request)
    {
      //dd($request->all());
      $user = Auth::user();
      $user->name = $request->name;
      if ($user->email !== $request->email) {
            $user->email = $request->email;
            $user->email_verified_at = null;
      }

      $user->phone = $request->phone;
      $user->save();
      return redirect('/profile')->with('status', 'Utilisateur mis à jour avec succès!');
    }


    public function updatePassword(ProfilePasswordUpdateRequest $request)
    {
         $user = Auth::user();
         $user->password = bcrypt($request->password); //new pwd
         $user->save();

         return redirect()->back()->with('status', 'Mot de passe mis à jour avec succès !');
    }


    public function updateAvatar(Request $request)
    {
        // Handle img file
        $imagePath = $this->uploadImage($request, 'avatar');

        $user = Auth::user();
        $user->avatar = $imagePath;
        $user->save();

        return redirect()->back()->with('status', 'Photo de profil mise à jour avec succès!');
    }
}
