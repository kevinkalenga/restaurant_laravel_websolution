<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\DailyOffer;
use Yajra\DataTables\Facades\DataTables;
use App\Models\SectionTitle;

class DailyOfferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   
    
    
public function index()
{
    if (request()->ajax()) {

        $dailyOffers = DailyOffer::with('product');

        return DataTables::of($dailyOffers)

            /*
            |--------------------------------------------------------------------------
            | Image
            |--------------------------------------------------------------------------
            */
            ->addColumn('image', function ($dailyOffer) {

                if (!$dailyOffer->product || !$dailyOffer->product->thumb_image) {
                    return null;
                }

                return asset($dailyOffer->product->thumb_image);
            })

            /*
            |--------------------------------------------------------------------------
            | Product Name
            |--------------------------------------------------------------------------
            */
            ->addColumn('name', function ($dailyOffer) {

                return $dailyOffer->product
                    ? $dailyOffer->product->name
                    : 'N/A';
            })

            /*
            |--------------------------------------------------------------------------
            | Action
            |--------------------------------------------------------------------------
            */
            ->addColumn('action', function ($dailyOffer) {

                return '
                    <a href="' . route('admin.dayly-offer.edit', $dailyOffer->id) . '"
                        class="btn btn-sm btn-primary mr-1">
                        <i class="fas fa-edit"></i>
                    </a>

                    <a href="' . route('admin.dayly-offer.destroy', $dailyOffer->id) . '"
                        class="btn btn-sm btn-danger"
                        onclick="event.preventDefault();
                        if(confirm(\'Are you sure you want to delete?\')) {
                            document.getElementById(\'delete-form-' . $dailyOffer->id . '\').submit();
                        }">
                        <i class="fas fa-trash"></i>
                    </a>

                    <form id="delete-form-' . $dailyOffer->id . '"
                        action="' . route('admin.dayly-offer.destroy', $dailyOffer->id) . '"
                        method="POST"
                        style="display:none;">
                        ' . csrf_field() . '
                        ' . method_field('DELETE') . '
                    </form>
                ';
            })

            ->rawColumns(['action'])

            ->make(true);
    }

    
       $keys = ['daily_offer_top_title', 'daily_offer_main_title', 'daily_offer_sub_title'];
       $titles = SectionTitle::whereIn('key', $keys)->pluck('value', 'key');

    return view('admin.daily-offer.index', compact('titles'));
}







    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view('admin.daily-offer.create');
    }

    public function productSearch(Request $request)
    {
        $product = Product::select('id', 'name', 'thumb_image')->where('name', 'LIKE', '%'.$request->search.'%')->get();
         
        $product->transform(function ($item) {
            $item->thumb_image = asset($item->thumb_image);
            return $item;
        });

         return response($product);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product' => ['required', 'integer'],
            'status' => ['required', 'boolean']
        ]);

        $offer = new DailyOffer();
        $offer->product_id = $request->product;
        $offer->status = $request->status;
        $offer->save();

        return redirect()
        ->route('admin.dayly-offer.index')
        ->with('success', 'Dayly Offer created successfully!');
    }

    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $dailyOffer = DailyOffer::with('product')->findOrFail($id);
        return view('admin.daily-offer.edit', compact('dailyOffer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $dailyOffer = DailyOffer::findOrFail($id);
        $request->validate([
            'product' => ['required', 'integer'],
            'status' => ['required', 'boolean']
        ]);

       
        $dailyOffer->product_id = $request->product;
        $dailyOffer->status = $request->status;
        $dailyOffer->save();

        return redirect()
        ->route('admin.dayly-offer.index')
        ->with('success', 'Dayly Offer updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dailyOffer = DailyOffer::findOrFail($id);

      

        $dailyOffer->delete();

        return redirect()
            ->route('admin.dayly-offer.index')
            ->with('success', 'Dayly Offer deleted successfully!');
    }

    public function updateTitle(Request $request)
    {
        $validatedData = $request->validate([
                'daily_offer_top_title' => ['max:100'],
                'daily_offer_main_title' => ['max:200'],
                'daily_offer_sub_title' => ['max:500'],
            ]);
        foreach($validatedData as $key => $value){
            SectionTitle::updateOrCreate(
                ['key' => $key],
                ['value' => $value],
            
            );
        }
            
        

      return redirect()->back()->with('status', 'Updated Titles Successfully!');
    }
}
