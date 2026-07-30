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

                ->addColumn('action', function($order){
                    return '
                         <a href="'.route('admin.orders.show', $order->id).'" 
                            class="btn btn-sm btn-primary">
                                <i class="fas fa-eye"></i>
                         </a>

                        <a href="'.route('admin.orders.edit', $order->id).'" 
                           class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i>
                        </a>

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
}
