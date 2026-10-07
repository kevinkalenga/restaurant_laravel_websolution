<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Services\SettingsService;
use Illuminate\Support\Facades\Cache;
use App\Traits\FileUploadTrait;

class SettingController extends Controller
{
    use FileUploadTrait;
    
    public function index()
    {
        //dd(config('mail'));
      return view('admin.setting.index');
    }
    
    public function updateGeneralSetting(Request $request)
    {
        $data = $request->validate([
            'site_name' => 'required|string|max:255',
            'site_default_currency' => 'required|string|size:3',
            'site_currency_icon' => 'required|string|max:10',
            'site_currency_icon_position' => 'required|in:left,right',
        ]);

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        $settingsService = app(SettingsService::class);
        $settingsService->clearCachedSettings();

        return back()->with('success', 'Settings updated successfully.');
    }

    public function UpdatePusherSetting(Request $request) {
        $data = $request->validate([
            'pusher_app_id' => ['required'],
            'pusher_key' => ['required'],
            'pusher_secret' => ['required'],
            'pusher_cluster' => ['required'],
        ]);

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        $settingsService = app(SettingsService::class);
        $settingsService->clearCachedSettings();

        return back()->with('success', 'Settings updated successfully.');
    }

    public function UpdateMailSetting(Request $request)
    {
         $data = $request->validate([
            'mail_driver' => ['required'],
            'mail_host' => ['required'],
            'mail_port' => ['required'],
            'mail_username' => ['required'],
            'mail_password' => ['required'],
            'mail_encryption' => ['required'],
            'mail_from_address' => ['required'],
            'mail_receive_address' => ['required'],
        ]);

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        $settingsService = app(SettingsService::class);
        $settingsService->clearCachedSettings();
        Cache::forget('mail_settings');

        return back()->with('success', 'Settings updated successfully.');
    }


    
    
    
    public function UpdateLogoSetting(Request $request)
    {
        $request->validate([
            'logo' => ['nullable', 'image', 'max:2048'],
            'footer_logo' => ['nullable', 'image', 'max:2048'],
            'favicon' => ['nullable', 'image', 'max:2048'],
            'breadcrumb' => ['nullable', 'image', 'max:2048'],
        ]);

        $images = [
            'logo',
            'footer_logo',
            'favicon',
            'breadcrumb',
        ];

        foreach ($images as $imageName) {

            // Si une nouvelle image a été sélectionnée
            if ($request->hasFile($imageName)) {

                // Récupérer l'ancien chemin
                $oldSetting = Setting::where('key', $imageName)->first();

                // Supprimer l'ancienne image
                if ($oldSetting && $oldSetting->value) {

                    $oldFile = public_path($oldSetting->value);

                    if (file_exists($oldFile)) {
                        unlink($oldFile);
                    }
                }

                // Upload de la nouvelle image avec ton trait
                $imagePath = $this->uploadImage(
                    $request,
                    $imageName,
                    'uploads'
                );

                // Enregistrer / mettre à jour le paramètre
                Setting::updateOrCreate(
                    ['key' => $imageName],
                    ['value' => $imagePath]
                );
            }
        }

        // Vider le cache des paramètres
        $settingsService = app(SettingsService::class);
        $settingsService->clearCachedSettings();

        return back()->with(
            'success',
            'The image settings have been successfully updated.'
        );
    }



}
