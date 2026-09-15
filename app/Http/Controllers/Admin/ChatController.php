<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Chat;
use App\Events\ChatEvent;

class ChatController extends Controller
{
    /**
     * Récupère la liste des utilisateurs ayant une conversation
     * avec l'utilisateur actuellement connecté.
     *
     * Exclut l'utilisateur connecté de la liste et recherche uniquement
     * les utilisateurs associés à une conversation où il est soit
     * l'expéditeur, soit le destinataire.
     *
     * Les utilisateurs sont triés du plus récent au plus ancien
     * et les doublons sont supprimés.
     */
    public function index()
    {
      //dd(auth()->user()->chats);
      $userId = auth()->user()->id;
     

      $senders = Chat::select('sender_id')
           ->where('receiver_id', $userId)
           ->where('sender_id', '!=', $userId)
           ->selectRaw('MAX(created_at) as latest_message_sent')
           ->groupBy('sender_id')
           ->orderByDesc('latest_message_sent')
           ->get();
        

      //dd($chatUsers);
      return view('admin.chat.index', compact('senders'));
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

        Chat::where('sender_id', $senderId)->where('receiver_id', $receiverId)->where('seen', 0)->update(['seen' => 1]);

        $messages = Chat::whereIn('sender_id', [$senderId, $receiverId])
             ->whereIn('receiver_id', [$senderId, $receiverId])
             ->with(['sender'])
             ->orderBy('created_at', 'asc')->get();

          return response()->json($messages);
    }


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

       $avatar = asset(auth()->user()->avatar);
        $senderId = auth()->user()->id;
        broadcast(new ChatEvent($request->message, $avatar, $request->receiver_id, $senderId))->toOthers();

        return response(['status' => 'success', 'msgId' => $request->msg_temp_id, 'message' => "The message has been sent Successfully!", 'chat' => $chat->load('sender')], 200);

       
    }
}
