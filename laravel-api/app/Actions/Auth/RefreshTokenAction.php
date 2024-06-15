<?php

namespace App\Actions\Auth;

use Illuminate\Support\Facades\Auth;

class RefreshTokenAction
{
    public static function run()
    {
        return Auth::refresh(true);
    }
}
