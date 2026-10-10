<?php

namespace App\Http\Controllers\Employe;

use App\Http\Controllers\Controller;
use App\Models\Order;

class EmployeeDashboardController extends Controller
{
    public function index()
    {
        $totalOrders = Order::count();

        $pendingOrders = Order::where('order_status', 'pending')->count();

        $inProcessOrders = Order::where('order_status', 'in_process')->count();

        $deliveredOrders = Order::where('order_status', 'delivered')->count();

        $recentOrders = Order::with(['user', 'orderItems'])
            ->latest()
            ->take(10)
            ->get();

        return view('employe.dashboard', compact(
            'totalOrders',
            'pendingOrders',
            'inProcessOrders',
            'deliveredOrders',
            'recentOrders'
        ));
    }
}
