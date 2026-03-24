<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class AttendeeRegistration extends Authenticatable
{
    use Notifiable, HasApiTokens;

    protected $table = 'attendee_registrations';

    protected $fillable = [
        'name',
        'email',
        'password',
        'ticket_type',    // Added ticket_type
        'attendee_id',    // Foreign key to Attendee
        'event_id',       // Foreign key to Event
    ];

    protected $hidden = [
        'password',
    ];

    /**
     * Each ticket belongs to an Event
     */
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id'); 
    }

    /**
     * Optional: Each ticket belongs to an Attendee
     */
    public function attendee()
    {
        return $this->belongsTo(Attendee::class, 'attendee_id');
    }
}