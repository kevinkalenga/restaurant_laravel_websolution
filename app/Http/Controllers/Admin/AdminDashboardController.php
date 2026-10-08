<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderPlacedNotification;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use App\Models\OrderStatistic;


class AdminDashboardController extends Controller
{
    
   public function index()
    {
         $total_completed_orders = Order::where('payment_status', 'completed')->where('order_status', 'delivered')->count();
         $total_completed_Earnings = Order::where('payment_status', 'completed')->where('order_status', 'delivered')->sum('grand_total');
         $thisMonthOrders = Order::whereMonth('created_at', now()->month)->where('order_status', 'delivered')->count();
         $thisMonthEarnings = Order::whereMonth('created_at', now()->month)->where('order_status', 'delivered')->sum('grand_total');
         $thisYearOrders = Order::whereYear('created_at', now()->year)->where('order_status', 'delivered')->count();
         $thisYearEarnings = Order::whereYear('created_at', now()->year)->where('order_status', 'delivered')->sum('grand_total');
        $statistics = OrderStatistic::orderBy('total_orders', 'desc')->get();

        return view('admin.dashboard.index', compact(
            'statistics', 
            'total_completed_orders', 
            'total_completed_Earnings', 
            'thisMonthOrders', 
            'thisMonthEarnings',
            'thisYearOrders',
            'thisYearEarnings'
        ));
    }
    public function clearNotification()
    {
        
        $notification = OrderPlacedNotification::query()->update(['seen' => 1]);

           // Redirection
        return redirect()
            ->back()
            ->with('success', 'Notification cleared successfully!');
       
    }
}
