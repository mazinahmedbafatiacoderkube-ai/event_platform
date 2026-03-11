<?php

namespace App\Actions;

use App\DTO\LoginUserDTO;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginUserAction
{
    public function execute(LoginUserDTO $dto)
    {
        if (!Auth::attempt([
            'email' => $dto->email,
            'password' => $dto->password
        ])) {

            throw ValidationException::withMessages([
                'email' => ['Invalid email or password']
            ]);
        }

        return Auth::user();
    }
}