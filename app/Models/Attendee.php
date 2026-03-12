<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendee extends Model
{
    protected $fillable = [
        'name',
        'email',
        'ticket_type',
        'event_id'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
