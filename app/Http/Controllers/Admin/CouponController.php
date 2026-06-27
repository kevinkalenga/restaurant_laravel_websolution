<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use DataTables;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     
    public function index()
    {
        if (request()->ajax()) {

            $coupons = Coupon::query();

            return DataTables::of($coupons)

                ->addColumn('action', function ($coupon) {
                    return '
                        <a href="'.route('admin.coupon.edit', $coupon->id).'"
                            class="btn btn-sm btn-primary mr-1">
                            <i class="fas fa-edit"></i>
                        </a>

                        <a href="'.route('admin.coupon.destroy', $coupon->id).'"
                            class="btn btn-sm btn-danger"
                            onclick="event.preventDefault();
                            if(confirm(\'Are you sure you want to delete?\')) {
                                document.getElementById(\'delete-form-'.$coupon->id.'\').submit();
                            }">
                            <i class="fas fa-trash"></i>
                        </a>

                        <form id="delete-form-'.$coupon->id.'"
                            action="'.route('admin.coupon.destroy', $coupon->id).'"
                            method="POST"
                            style="display:none;">
                            '.csrf_field().'
                            '.method_field('DELETE').'
                        </form>
                    ';
                })

                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.coupon.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.coupon.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation
      $request->validate([
        'name' => ['required', 'max:255'],
        'code' => ['required', 'max:50'],
        'quantity' => ['required', 'integer'],
        'min_purchase_amount' => ['required', 'integer'],
        'expire_date' => ['required', 'date'],
        'discount_type' => ['required'],
        'discount' => ['required'],
        'status' => ['required', 'boolean'],
      ]);

      


      // Création du produit
      $coupon = new Coupon();
      $coupon->name = $request->name;
      $coupon->code = $request->code;
      $coupon->quantity = $request->quantity;
      $coupon->min_purchase_amount = $request->min_purchase_amount;
      $coupon->expire_date = $request->expire_date;
      $coupon->discount_type = $request->discount_type;
      $coupon->discount = $request->discount;
      $coupon->status = $request->status;
    
  
      $coupon->save();

      return redirect()
        ->route('admin.coupon.index')
        ->with('success', 'Coupon created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
