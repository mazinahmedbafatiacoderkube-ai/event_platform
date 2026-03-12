<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Event;

class EventPolicy
{

    // Anyone in same organization can view event
    public function view(User $user, Event $event)
    {
        return $user->organization_id === $event->organization_id;
    }

    // Owner can edit anything
    // Managers only their own events
    public function update(User $user, Event $event)
    {
        if ($user->role === 'owner') {
            return true;
        }

        return $user->id === $event->created_by;
    }

    // Owner can delete anything
    // Managers only their own events
    public function delete(User $user, Event $event)
    {
        if ($user->role === 'owner') {
            return true;
        }

        return $user->id === $event->created_by;
    }

}