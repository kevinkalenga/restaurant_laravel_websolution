<?php

namespace App\Http\Controllers\Employe;

use App\Http\Controllers\Controller;
use App\Models\ProductRating;
use Illuminate\Http\Request;

class EmployeeProductReviewController extends Controller
{
    public function index()
    {
        $reviews = ProductRating::with(['user', 'product'])
            ->latest()
            ->get();

        return view('employe.product-reviews.index', compact('reviews'));
    }

    public function toggleStatus($id)
    {
        $review = ProductRating::findOrFail($id);

        $review->status = !$review->status;
        $review->save();

        return redirect()
            ->route('employe.product-reviews.index')
            ->with(
                'success',
                $review->status
                    ? 'Avis approuvé avec succès.'
                    : 'Approbation de l’avis retirée avec succès.'
            );
    }
}
