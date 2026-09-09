<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Chat;

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
      // chats is the relation
      $chatUsers = User::where('id', '!=', $userId)->whereHas('chats', function($query) use ($userId){
        $query->where(function($subQuery) use ($userId){
          $subQuery->where('sender_id', $userId)->orWhere('receiver_id', $userId);
        });
      })->orderByDesc('created_at')->distinct()->get();

      //dd($chatUsers);
      return view('admin.chat.index', compact('chatUsers'));
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
             ->orderBy('created_at', 'asc')->get();

          return response()->json($messages);
    }
}
