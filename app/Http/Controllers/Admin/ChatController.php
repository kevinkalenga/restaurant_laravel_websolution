<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

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

    }
}
