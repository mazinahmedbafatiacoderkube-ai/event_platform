<?php

namespace App\DTO;

use Illuminate\Http\Request;

class CreateStaffDTO
{
    public $organization_id;
    public $name;
    public $email;
    public $password;
    public $role;

    public function __construct($organization_id, $name, $email, $password, $role)
    {
        $this->organization_id = $organization_id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
    }

    public static function fromRequest(Request $request)
    {
        return new self(
            auth()->user()->organization_id,
            $request->name,
            $request->email,
            bcrypt($request->password),
            'event_manager'
        );
    }
}