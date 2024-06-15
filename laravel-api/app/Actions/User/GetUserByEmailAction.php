<?php

namespace App\Actions\User;

use App\Models\User;

class GetUserByEmailAction
{
    public static function run(string $email)
    {
        return User::where('email', $email)->first();
    }
}
