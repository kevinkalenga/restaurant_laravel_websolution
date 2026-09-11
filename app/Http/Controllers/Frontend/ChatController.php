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

    public function getConversation($senderId)
    {
       /**
       * Récupère l'ensemble des messages échangés entre
       * l'utilisateur connecté et l'utilisateur sélectionné.
       *
       * La conversation est recherchée dans les deux sens :
       * l'utilisateur sélectionné peut être l'expéditeur ou le destinataire.
       *
       * Les messages sont triés par date de création, du plus ancien
       * au plus récent, afin de respecter l'ordre chronologique de la conversation.
       */
        $receiverId = auth()->user()->id;

        $messages = Chat::whereIn('sender_id', [$senderId, $receiverId])
             ->whereIn('receiver_id', [$senderId, $receiverId])
             ->with(['sender'])
             ->orderBy('created_at', 'asc')->get();

          return response()->json($messages);
    }
}
