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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
