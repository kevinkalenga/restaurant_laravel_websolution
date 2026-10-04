<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomPageBuilder;

class CustomPageController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, string $slug)
    {
        $page = CustomPageBuilder::where(['slug'=> $slug, 'status' => 1])->firstOrFail();
        return view('frontend.pages.custom-page', compact('page'));
    }
}
