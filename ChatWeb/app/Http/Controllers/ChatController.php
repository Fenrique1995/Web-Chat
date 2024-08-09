<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function showChat()
    {
        $messages = ChatMessage::with('user')->get();
        return view('chat', compact('messages'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        ChatMessage::create([
            'user_id' => auth()->id(),
            'message' => $request->message,
        ]);

        return response()->json(['success' => true]);
    }

    public function getMessages()
    {
        $messages = ChatMessage::with('user')->get();
        return view('partials.chat-messages', compact('messages'));
    }
}
