<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TermsAndCondition;

class TermsAndConditionController extends Controller
{
    public function index()
    {
        $termsAndConditions = TermsAndCondition::first();
        return view('admin.terms-and-conditions.index', compact('termsAndConditions'));
    }
    
    public function update(Request $request)
    {
        $request->validate([
         'content' => ['required','string'],
        
        ]);

        TermsAndCondition::updateOrCreate(
            ['id' => 1],
            [
                'content' => $request->content
            ]
        );

         return redirect()->back()->with('success', 'Terms and Conditions Update successfully!');
    }
}
