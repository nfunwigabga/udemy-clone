<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\ResetPasswordAction;
use App\Actions\User\GetUserByEmailAction;
use App\Data\Auth\ForgotPasswordData;
use App\Data\Auth\ResetPasswordData;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class PasswordResetController extends Controller
{
    public function store(ForgotPasswordData $data)
    {
        $status = Password::sendResetLink(
            $data->toArray()
        );
        if ($status == Password::RESET_LINK_SENT) {
            return response()->json(['status' => __($status)], 201);
        }
        throw ValidationException::withMessages([
            'email' => [trans($status)],
        ]);
    }

    public function update(ResetPasswordData $data)
    {
        $status = ResetPasswordAction::run($data);

        if ($status == Password::PASSWORD_RESET) {
            $user = GetUserByEmailAction::run($data->email);
            $user->tokens()?->delete();

            return response()->json(['status' => __($status)]);
        }
        throw ValidationException::withMessages([
            'email' => [trans($status)],
        ]);
    }
}
