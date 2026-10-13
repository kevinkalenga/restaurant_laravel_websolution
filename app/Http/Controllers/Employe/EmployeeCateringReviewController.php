<?php

namespace App\Http\Controllers\Employe;

use App\Http\Controllers\Controller;
use App\Models\CateringOrderReview;

class EmployeeCateringReviewController extends Controller
{
    public function index()
    {
        $reviews = CateringOrderReview::with(['user', 'order'])
            ->latest()
            ->get();

        return view('employe.catering-reviews.index', compact('reviews'));
    }

    public function toggleStatus($id)
    {
        $review = CateringOrderReview::findOrFail($id);
        $review->status = !$review->status;
        $review->save();

        return redirect()
            ->route('employe.catering-reviews.index')
            ->with('success', $review->status
                ? 'Avis traiteur approuvé.'
                : 'Approbation de l’avis retirée.');
    }
}
