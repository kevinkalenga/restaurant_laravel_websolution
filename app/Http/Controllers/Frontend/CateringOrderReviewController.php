<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\CateringOrderReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CateringOrderReviewController extends Controller
{
    public function create(int $orderId)
    {
        $order = Order::where('user_id', Auth::id())
            ->whereNotNull('catering_menu_id')
            ->where('order_status', 'completed')
            ->findOrFail($orderId);

        if (CateringOrderReview::where('order_id', $order->id)->exists()) {
            return redirect()->route('dashboard')
                ->with('error', 'Vous avez déjà donné votre avis sur cette commande.');
        }

        return view('frontend.pages.catering-orders.review', compact('order'));
    }

    public function store(Request $request, int $orderId)
    {
        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'review' => ['required', 'string', 'max:1000'],
        ]);

        $order = Order::where('user_id', Auth::id())
            ->whereNotNull('catering_menu_id')
            ->where('order_status', 'completed')
            ->findOrFail($orderId);

        if (CateringOrderReview::where('order_id', $order->id)->exists()) {
            return redirect()->route('dashboard')
                ->with('error', 'Vous avez déjà donné votre avis sur cette commande.');
        }

        CateringOrderReview::create([
            'order_id' => $order->id,
            'user_id' => Auth::id(),
            'rating' => $validated['rating'],
            'review' => $validated['review'],
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Merci pour votre avis !');
    }
}
