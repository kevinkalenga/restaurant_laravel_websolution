<?php

namespace App\Http\Controllers\Admin;

use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeliveryArea;

class DeliveryAreaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {

            $deliveryAreas = DeliveryArea::query();

            return DataTables::of($deliveryAreas)

            ->addColumn('action', function ($deliveryArea) {
                return '
                    <a href="'.route('admin.delivery-area.edit', $deliveryArea->id).'"
                        class="btn btn-sm btn-primary mr-1">
                        <i class="fas fa-edit"></i>
                    </a>

                    <a href="'.route('admin.delivery-area.destroy', $deliveryArea->id).'"
                        class="btn btn-sm btn-danger"
                        onclick="event.preventDefault();
                        if(confirm(\'Are you sure you want to delete?\')) {
                            document.getElementById(\'delete-form-'.$deliveryArea->id.'\').submit();
                        }">
                        <i class="fas fa-trash"></i>
                    </a>

                    <form id="delete-form-'.$deliveryArea->id.'"
                        action="'.route('admin.delivery-area.destroy', $deliveryArea->id).'"
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
    
    
       return view('admin.delivery-area.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view('admin.delivery-area.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'area_name' => ['required', 'max:255'],
            'min_delivery_time' => ['required', 'max:255'],
            'max_delivery_time' => ['required', 'max:255'],
            'delivery_fee' => ['required', 'numeric'],
            'status' => ['required', 'boolean'],
        ]);


        $deliveryArea = new DeliveryArea();
        $deliveryArea->area_name = $request->area_name;
        $deliveryArea->min_delivery_time = $request->min_delivery_time;
        $deliveryArea->max_delivery_time = $request->max_delivery_time;
        $deliveryArea->delivery_fee = $request->delivery_fee;
        $deliveryArea->status = $request->status;
    
  
        $deliveryArea->save();

         return redirect()
        ->route('admin.delivery-area.index')
        ->with('success', 'Delivery Area created successfully!');
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
