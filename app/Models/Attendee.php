<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Attendee extends Authenticatable
{
    use Notifiable;

    protected $table = 'attendees';

    protected $fillable = [
        'name',
        'email',
        'ticket_type',
        'event_id',
        'attendee_id', // or any unique attendee identifier
    ];

    protected $hidden = ['password'];

    // Relationship to Event if needed
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}