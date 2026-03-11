<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{

    use HasFactory;

    protected $fillable = [
        'organization_id',
        'title',
        'description',
        'start_time',
        'end_time',
        'status',
        'created_by'
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function attendees()
    {
        return $this->hasMany(Attendee::class);
    }

    public function channels()
    {
        return $this->hasMany(Channel::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class,'created_by');
    }

}
