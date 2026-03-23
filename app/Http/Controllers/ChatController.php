<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ChatService;
use Illuminate\Support\Facades\Auth; // import Auth facade

class ChatController extends Controller
{
    private ChatService $chatService;

    public function __construct(ChatService $chatService)
    {
        $this->chatService = $chatService;
    }

    /**
     * Fetch all messages for a given event
     */
    public function fetchMessages($eventId)
    {
        return response()->json(
            $this->chatService->getMessages($eventId)
        );
    }

    /**
     * Send a new message for an event
     */
    public function sendMessage(Request $request, $eventId)
    {
        // Validate incoming request
        $request->validate([
            'message' => 'required|string|max:1000',
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|max:255'
        ]);

        // Determine the sender (organization/staff or attendee)
        $user = Auth::user(); // default guard (organization/staff)
        if (!$user) {
            $user = Auth::guard('attendee')->user(); // attendee guard
        }

        // Send message using ChatService
        $message = $this->chatService->sendMessage(
            $eventId,
            $user,                // can be null if needed
            $request->message
        );

        return response()->json($message);
    }
}