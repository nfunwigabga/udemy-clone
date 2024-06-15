<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\RegisterUserAction;
use App\Data\Auth\RegisterUserData;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    public function store(RegisterUserData $data)
    {
        RegisterUserAction::run($data);

        return response()->json(null, 201);
    }
}
