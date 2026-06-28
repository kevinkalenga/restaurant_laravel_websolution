<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use App\Models\WhyChooseUs;
use App\Models\Category;
use App\Models\SectionTitle;
use App\Models\Product;
use App\Models\Coupon;
use Cart;

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
      $product = Product::with(['productImages', 'productSizes', 'productOptions'])->where(['slug' => $slug, 'status' => 1])->firstOrFail();
       // show products by their category and ignore the product that we are viewing   
      $relatedProducts = Product::where('category_id', $product->category_id)->where('id', '!=', $product->id)->take(8)->latest()->get();
      return view('frontend.pages.product-view', compact('product', 'relatedProducts'));
    }

    public function loadProductModal($productId)
    {
       $product = Product::with(['productSizes', 'productOptions'])->findOrFail($productId);
      
       return view('frontend.layouts.ajax-files.product_popup_modal', compact('product'))->render();
    }
   



    public function applyCoupon(Request $request)
    {
        $subtotal = cartTotal();
        $code = $request->code;

        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon) {
            return response(['message' => 'Invalid Coupon Code.'], 422);
        }

        if ($coupon->quantity <= 0) {
            return response(['message' => 'Coupon has been fully redeemed.'], 422);
        }

        if ($coupon->expire_date < now()) {
            return response(['message' => 'Coupon is expired.'], 422);
        }

        $discount = $coupon->discount_type === 'percent'
            ? $subtotal * ($coupon->discount / 100)
            : $coupon->discount;

        $discount = round($discount, 2);
        $finalTotal = round($subtotal - $discount, 2);

        return response()->json([
            'subtotal' => $subtotal,
            'discount' => $discount,
            'finalTotal' => $finalTotal,
            'message' => 'Coupon Applied Successfully.'
        ]);
    }

  
}
