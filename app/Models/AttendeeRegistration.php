<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
class AttendeeRegistration extends Authenticatable
{
    use Notifiable;
    use HasApiTokens;

    protected $table = 'attendee_registrations';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];
    public function event()
{
    return $this->belongsTo(Event::class, 'event_id'); // make sure event_id exists in attendee_registrations table
}
}