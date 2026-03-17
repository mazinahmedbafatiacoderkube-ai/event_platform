<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
class Attendee extends Model
{
    use Notifiable;
    protected $fillable = [
        'name',
        'email',
        'ticket_type',
        'event_id',
        'attendee_id',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
