<?php

namespace App\Http\Controllers\Employe;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class EmployeeOrderController extends Controller
{
    public function show(Order $order)
    {
        $order->load(['user', 'orderItems']);

        return view('employe.orders.show', compact('order'));
    }

    
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'order_status' => 'required|in:pending,in_process,delivered,waiting_equipment_return,completed',
        ]);

        $order->update([
            'order_status' => $request->order_status,
        ]);

        return redirect()
            ->route('employe.orders.show', $order->id)
            ->with('success', 'Statut de la commande mis à jour.');
    }


    public function updateEquipment(Request $request, Order $order)
    {
        $request->validate([
            'equipment_loaned' => 'required|boolean',
        ]);

        $order->update([
            'equipment_loaned' => $request->equipment_loaned,
        ]);

        return redirect()
            ->route('employe.orders.show', $order->id)
            ->with('success', 'Information sur le matériel mise à jour.');
    }

}
