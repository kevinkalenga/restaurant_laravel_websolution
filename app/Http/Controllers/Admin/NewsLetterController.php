<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subscriber;
use Yajra\DataTables\Facades\DataTables;
use App\Mail\NewsLetter;
use Illuminate\Support\Facades\Mail;


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

       
         
        public function sendNewsLetter(Request $request)
        {
            $request->validate([
                'subject' => ['required', 'max:255'],
                'message' => ['required'],
            ]);

            $subscribers = Subscriber::all();

            foreach ($subscribers as $subscriber) {

                Mail::to($subscriber->email)
                    ->send(new NewsLetter(
                        $request->subject,
                        $request->message
                    ));
            }

            return redirect()->back()->with(
                'success',
                'Newsletter successfully sent to all subscribers.'
            );
        }




}
