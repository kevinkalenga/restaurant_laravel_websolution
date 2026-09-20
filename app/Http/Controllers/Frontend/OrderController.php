<?php

namespace App\Http\Controllers\Frontend;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\OrderService;

class OrderController extends Controller
{
    public function cancelOrder($id, OrderService $orderService): RedirectResponse { 
        $cancelled = $orderService->cancelOrder($id); 
        if (!$cancelled) { 
            return back()->with( 'error', 'This order can no longer be cancelled.' ); 
        } 
        return back()->with( 'success', 'Your order has been cancelled successfully.' ); 
    }
}
