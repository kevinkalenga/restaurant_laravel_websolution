<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subscriber;
use Yajra\DataTables\Facades\DataTables;

class NewsLetterController extends Controller
{
    
        public function index(Request $request)
        {
            if ($request->ajax()) {

                $subscribers = Subscriber::query();

                return DataTables::of($subscribers)
                    ->addColumn('action', function ($subscriber) {

                        return '
                            <button type="button"
                                    class="btn btn-danger btn-sm delete-subscriber"
                                    data-id="' . $subscriber->id . '">
                                <i class="fas fa-trash"></i>
                            </button>
                        ';

                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }

            return view('admin.news-letter.index');
        }


}
