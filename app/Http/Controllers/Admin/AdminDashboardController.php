<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderPlacedNotification;

class AdminDashboardController extends Controller
{
    public function index()
    {
        
        return view('admin.dashboard.index');
       
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
