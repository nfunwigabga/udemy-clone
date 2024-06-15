<?php

namespace App\Actions\Auth;

use App\Data\Auth\RegisterUserData;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

class RegisterUserAction
{
    public static function run(RegisterUserData $data)
    {
        $user = User::create([
            'first_name' => $data->first_name,
            'last_name' => $data->last_name,
            'username' => $data->username,
            'email' => $data->email,
            'password' => Hash::make($data->password),
        ]);
        event(new Registered($user));

        return $user;
    }

    
}
