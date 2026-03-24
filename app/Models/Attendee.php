<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Event;

class Attendee extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'title',
        'name',
        'email',
        'ticket_type',
        'checkin_status'
    ];
     public function event()
    {
        return $this->belongsTo(Event::class);
    }

    protected static function booted()
    {
        static::creating(function ($attendee) {
            $event = Event::find($attendee->event_id);
            if ($event) {
                $attendee->title = $event->title; // Automatically fill title from event
            }
        });
    }
}