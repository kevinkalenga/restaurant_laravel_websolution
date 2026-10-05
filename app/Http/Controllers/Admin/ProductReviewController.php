<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductRating;
use Yajra\DataTables\Facades\DataTables;

class ProductReviewController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            // Récupère les reviews avec les informations de l'utilisateur et du produit associés
            $reviews = ProductRating::with(['user', 'product'])
                ->select('product_ratings.*');

            return DataTables::of($reviews)
                ->addColumn('user', function ($review) {
                    return $review->user->name ?? 'N/A';
                })
                ->addColumn('product', function ($review) {
                    return $review->product->name ?? 'N/A';
                })
                ->addColumn('rating', function ($review) {
                    $stars = '';

                    for ($i = 1; $i <= 5; $i++) {
                        $stars .= $i <= $review->rating
                            ? '<i class="fas fa-star text-warning"></i>'
                            : '<i class="far fa-star text-muted"></i>';
                    }

                    return $stars;
                })
                ->addColumn('status', function ($review) {
                    return $review->status
                        ? '<span class="badge badge-success">Active</span>'
                        : '<span class="badge badge-danger">Inactive</span>';
                })
                ->addColumn('action', function ($review) {
                    return '';
                })
                ->rawColumns(['rating', 'status', 'action'])
                ->make(true);
        }

        return view('admin.product.product-review.index');


    }

}
