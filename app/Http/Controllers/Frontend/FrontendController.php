<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use App\Models\WhyChooseUs;
use App\Models\SectionTitle;

class FrontendController extends Controller
{
    public function index()
    {
        $sliders = Slider::where('status', 1)->get();
        $sectionTitles = $this->getSectionTitles();
        $whyChooseUs = WhyChooseUs::where('status', 1)->get();
        // dd($sectionTitles);
        return view('frontend.home.index', compact('sliders', 'sectionTitles', 'whyChooseUs'));
       
    }

    public function getSectionTitles() 
    {
        $keys = ['why_choose_top_title', 'why_choose_main_title', 'why_choose_sub_title'];
        return SectionTitle::whereIn('key', $keys)->pluck('value', 'key');
    }
}
