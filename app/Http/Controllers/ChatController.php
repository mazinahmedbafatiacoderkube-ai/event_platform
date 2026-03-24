<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ChatService;
use App\Events\MessageSent;

class ChatController extends Controller
{
    private ChatService $chatService;

    public function __construct(ChatService $chatService)
    {
        $this->chatService = $chatService;
    }

    public function fetchMessages($eventId)
    {
        return response()->json(
            $this->chatService->getMessages($eventId)
        );
    }

    public function sendMessage(Request $request, $eventId)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        // Determine sender: user or attendee
        $sender = auth()->user() ?? auth()->guard('attendee')->user();

        if (!$sender) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $message = $this->chatService->sendMessage($eventId, $sender, $request->message);

        event(new MessageSent($message, $sender));

        return response()->json($message);
    }
}   