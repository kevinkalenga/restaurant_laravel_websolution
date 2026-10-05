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


            // Load reviews with their related user and product
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

                ->addColumn('review', function ($review) {
                    return $review->review;
                })

                ->addColumn('status', function ($review) {
                    return $review->status
                        ? '<span class="badge badge-success">Approved</span>'
                        : '<span class="badge badge-warning">Pending</span>';
                })

                ->addColumn('action', function ($review) {

                    $statusButton = $review->status
                        ? '<button type="button"
                                    class="btn btn-warning btn-sm toggle-review-status"
                                    data-id="' . $review->id . '">
                                Unapprove
                            </button>'
                        : '<button type="button"
                                    class="btn btn-success btn-sm toggle-review-status"
                                    data-id="' . $review->id . '">
                                Approve
                            </button>';

                    $deleteButton = '<button type="button"
                                            class="btn btn-danger btn-sm delete-review"
                                            data-id="' . $review->id . '">
                                        Delete
                                    </button>';

                    return $statusButton . ' ' . $deleteButton;
                })

                ->rawColumns(['rating', 'status', 'action'])
                ->make(true);
        }

        return view('admin.product.product-review.index');


    }


    public function toggleStatus($id)
    {
        $review = ProductRating::findOrFail($id);


        $review->status = !$review->status;
        $review->save();

        return response()->json([
            'success' => true,
            'message' => $review->status
                ? 'Review approved successfully.'
                : 'Review unapproved successfully.',
        ]);


    }

    public function destroy($id)
    {
        $review = ProductRating::findOrFail($id);


        $review->delete();

        return response()->json([
            'success' => true,
            'message' => 'Review deleted successfully.',
        ]);


    }



}
