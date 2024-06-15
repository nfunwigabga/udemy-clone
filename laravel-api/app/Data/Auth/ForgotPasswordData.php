<?php

namespace App\Data\Auth;

use Spatie\LaravelData\Data;

class ForgotPasswordData extends Data
{
    public string $email;

    public static function rules(): array
    {
        return [
            'email' => ['required', 'email'],
        ];
    }
}
