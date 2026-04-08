<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // ====== CUSTOMER SIDE ======
    public function getUserChats()
    {
        $chats = Chat::where('user_id', Auth::id())->orderBy('created_at', 'asc')->get();
        return response()->json(['chats' => $chats]);
    }

    public function userSend(Request $request)
    {
        $request->validate(['message' => 'required|string']);
        
        $chat = Chat::create([
            'user_id' => Auth::id(),
            'message' => $request->message,
            'is_admin' => false
        ]);

        return response()->json(['success' => true, 'chat' => $chat]);
    }

    // ====== ADMIN SIDE ======
    public function adminIndex()
    {
        // Get all users who have ever chatted
        $users = User::whereHas('chats')->with(['chats' => function($q) {
            $q->orderBy('created_at', 'desc');
        }])->get();

        // Sort users by latest chat message
        $users = $users->sortByDesc(function($user) {
            return count($user->chats) > 0 ? $user->chats->first()->created_at : $user->created_at;
        });

        return view('auth.admin-chat', compact('users'));
    }

    public function getAdminChats($userId)
    {
        $chats = Chat::where('user_id', $userId)->orderBy('created_at', 'asc')->get();
        return response()->json(['chats' => $chats]);
    }

    public function adminSend(Request $request, $userId)
    {
        $request->validate(['message' => 'required|string']);

        $chat = Chat::create([
            'user_id' => $userId,
            'message' => $request->message,
            'is_admin' => true
        ]);

        return response()->json(['success' => true, 'chat' => $chat]);
    }
}
