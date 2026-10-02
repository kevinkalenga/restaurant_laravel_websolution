<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FooterInfo;

class FooterInfoController extends Controller
{
    public function index()
    {
        $footerInfo = FooterInfo::first();
        return view('admin.footer-info.index', compact('footerInfo'));
    }
    public function update(Request $request)
    {
        $request->validate([
            'short_info' => ['nullable', 'max:2000'],
            'address' => ['nullable', 'max:255'],
            'phone' => ['nullable', 'max:255'],
            'email' => ['nullable', 'max:255'],
            'copyright' => ['nullable', 'max:255'],
        ]);

        FooterInfo::updateOrCreate(
            ['id' => 1],
            [
                'short_info' => $request->short_info,
                'address' => $request->address,
                'phone' => $request->phone,
                'email' => $request->email,
                'copyright' => $request->copyright,
               
            ]
        );

        return redirect()->back()->with(
                'success',
                'Foot info update successfully.'
         );
    }
}
