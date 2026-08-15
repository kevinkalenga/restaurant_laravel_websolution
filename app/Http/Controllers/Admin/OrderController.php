<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {

            // Récupère toutes les commandes depuis la table orders
            // et charge en même temps les informations de l'utilisateur associé
            // grâce à la relation "user" définie dans le modèle Order.
            // select('orders.*') permet de sélectionner uniquement les colonnes
            // de la table orders.

            $orders = Order::with('user')->select('orders.*');

            return DataTables::of($orders)

                ->addColumn('user.name', function($order){
                    return $order->user->name ?? 'Guest';
                })



                // ->addColumn('action', function($order){
                //     return '
                //          <a href="'.route('admin.orders.show', $order->id).'" 
                //             class="btn btn-sm btn-primary order_status" data-id="'.$order->id.'">
                //                 <i class="fas fa-eye"></i>
                //          </a>

                //         <a href="'.route('admin.orders.edit', $order->id).'" 
                //            class="btn btn-sm btn-warning" data-toggle="modal" data-target="#order_model" data-id="'.$order->id.'">
                //             <i class="fas fa-edit"></i>
                //         </a>

                //         <a href="'.route('admin.orders.destroy', $order->id).'" 
                //         class="btn btn-sm btn-danger delete-item">
                //             <i class="fas fa-trash"></i>
                //         </a>
                //     ';
                // })

                ->addColumn('action', function($order){
                    return '
                        <a href="'.route('admin.orders.show', $order->id).'" 
                        class="btn btn-sm btn-primary">
                            <i class="fas fa-eye"></i>
                        </a>

                        <button type="button"
                                class="btn btn-sm btn-warning edit-order-status"
                                data-id="'.$order->id.'">
                            <i class="fas fa-edit"></i>
                        </button>

                        <a href="'.route('admin.orders.destroy', $order->id).'" 
                        class="btn btn-sm btn-danger delete-item">
                            <i class="fas fa-trash"></i>
                        </a>
                    ';
                })

                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.order.index');
    }

    public function show(Order $order)
    {
      return view('admin.order.show', compact('order'));
    }

   


    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,completed,failed,cancelled',
            'order_status' => 'required|in:pending,in_process,delivered,declined',
        ]);

        $order->update([
            'payment_status' => $request->payment_status,
            'order_status'   => $request->order_status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Order status updated successfully.',
        ]);
    }



    public function getOrderStatus($id)
    {
        $order = Order::select(['order_status', 'payment_status'])->findOrFail($id);
        return response($order);
    }
}
