<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index()
    {
        $contact = Contact::first();
        return view('admin.contact.index', compact('contact'));
    }
    public function update(Request $request)
    {

        $request->validate([
              'phone_one' => 'nullable|string|max:50',
              'phone_two' => 'nullable|string|max:50',
              'mail_one' => 'nullable|string|max:255',
              'mail_two' => 'nullable|string|max:255',
              'address' => 'nullable|string|max:1000',
              'map_link' => 'nullable|string|max:1000',
           
        ]);

        Contact::updateOrCreate(
            ['id'=> 1],
            [
                'phone_one' => $request->phone_one,
                'phone_two' => $request->phone_two,
                'mail_one' => $request->mail_one,
                'mail_two' => $request->mail_two,
                'address' => $request->address,
                'map_link' => $request->map_link,
                
            ]
        );
        
         return redirect()->back()->with('success', 'Contact Update successfully!');
    }
}
