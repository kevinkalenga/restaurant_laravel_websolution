<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class ChatController extends Controller
{
    public function index()
    {
      //dd(auth()->user()->chats);
      $userId = auth()->user()->id;
      // chats is the relation
      $chatUsers = User::where('id', '!=', $userId)->whereHas('chats', function($query) use ($userId){
        $query->where(function($subQuery) use ($userId){
          $subQuery->where('sender_id', $userId)->orWhere('receiver_id', $userId);
        });
      })->orderByDesc('created_at')->distinct()->get();

      dd($chatUsers);
      return view('admin.chat.index');
    }
}
