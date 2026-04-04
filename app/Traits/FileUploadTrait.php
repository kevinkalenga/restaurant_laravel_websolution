<?php 

namespace App\Traits; 
use Illuminate\Http\Request;

trait FileUploadTrait 
{
    

    function uploadImage(Request $request, $inputName, $path = "uploads") 
    {
        if ($request->hasFile($inputName)) {
            $image = $request->{$inputName};
            $ext = $image->getClientOriginalExtension();
            $imageName = 'media_'.uniqid().'.'.$ext;

            $destination = public_path($path);
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            $image->move($destination, $imageName);

            // Stocke le chemin relatif pour asset()
            // Exemple retourné : "uploads/media_abc123.jpg"
            return $path.'/'.$imageName;
        }

        return null;
    }
    
}