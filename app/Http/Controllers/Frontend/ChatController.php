<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Chat;
use Auth;

class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {
       $request->validate([
          'message' => ['required', 'max:1000'],
          'receiver_id' => ['required', 'integer']
       ]);

       $chat = new Chat();
       $chat->sender_id = Auth()->user()->id;
       $chat->receiver_id = $request->receiver_id;
       $chat->message = $request->message;
       $chat->save();

        return response(['status' => 'success', 'message' => "The message has been sent Successfully!"], 200);

       
    }
}
