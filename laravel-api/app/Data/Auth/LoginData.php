<?php

namespace App\Data\Auth;

use Spatie\LaravelData\Data;

class LoginData extends Data
{
    public string $email;

    public string $password;

    public static function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ];
    }
}
