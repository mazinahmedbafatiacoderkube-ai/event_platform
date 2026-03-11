<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Event;

class EventPolicy
{

public function update(User $user, Event $event)
{
    return $user->id === $event->created_by;
}

public function delete(User $user, Event $event)
{
    return $user->id === $event->created_by;
}

}