<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()->notifications;

        return view('notifications.index', compact('notifications'));
    }

    // when user clicks notification
    public function open($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);

        // mark notification as read
        $notification->markAsRead();

        // get event id from notification
        $eventId = $notification->data['event_id'] ?? null;

        // redirect to event page
        return redirect('/events/'.$eventId);
    }

    public function markAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();

        return redirect()->back();
    }
}