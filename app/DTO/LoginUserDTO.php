<?php

namespace App\DTO;

class LoginUserDTO
{
    public $email;
    public $password;

    public function __construct($email,$password)
    {
        $this->email = $email;
        $this->password = $password;
    }
}