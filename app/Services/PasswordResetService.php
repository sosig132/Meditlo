<?php

namespace App\Services;

use App\Models\PasswordResetToken;
use Illuminate\Support\Facades\DB;

class PasswordResetService
{
    public function updatePasswordResetToken($email, $token) {
        PasswordResetToken::updateOrCreate(
            ['email' => $email],
            ['token' => $token, 'created_at' => now()]
        );
    }

    public function getPasswordResetToken($email) {
        return PasswordResetToken::where('email', $email)->first();
    }

    public function deletePasswordResetToken($email) {
        PasswordResetToken::where('email', $email)->delete();
    }

    public function getUserByToken($token) {
        return PasswordResetToken::where('token', $token)->first();
    }
}
