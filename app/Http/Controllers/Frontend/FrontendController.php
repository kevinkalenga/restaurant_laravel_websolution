<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use App\Models\WhyChooseUs;
use App\Models\Category;
use App\Models\SectionTitle;
use App\Models\Product;

class FrontendController extends Controller
{
    public function index()
    {
        $sliders = Slider::where('status', 1)->get();
        $sectionTitles = $this->getSectionTitles();
        $whyChooseUs = WhyChooseUs::where('status', 1)->get();
        // dd($sectionTitles);
        $categories = Category::where(['show_at_home' => 1, 'status' => 1])->get();
        return view('frontend.home.index', compact('sliders', 'sectionTitles', 'whyChooseUs', 'categories'));
       
    }

    public function getSectionTitles() 
    {
        $keys = ['why_choose_top_title', 'why_choose_main_title', 'why_choose_sub_title'];
        return SectionTitle::whereIn('key', $keys)->pluck('value', 'key');
    }

    public function showProduct($slug)
    {
      $product = Product::where(['slug' => $slug, 'status' => 1])->firstOrFail();
      return view('frontend.pages.product-view', compact('product'));
    }
}
