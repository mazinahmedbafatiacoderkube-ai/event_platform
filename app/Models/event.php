<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    | Boot Method (Organization Scope)
    |--------------------------------------------------------------------------
    */

    protected static function booted()
    {
        if (auth()->check()) {

            static::addGlobalScope('organization', function ($query) {
                $query->where('organization_id', auth()->user()->organization_id);
            });

        }
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

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
        return $this->belongsTo(User::class, 'created_by');
    }
}