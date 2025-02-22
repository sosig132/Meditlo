<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PasswordResetService
{
    public function updatePasswordResetToken($email, $token) {
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            ['token' => $token, 'created_at' => now()]
        );
    }

    public function getPasswordResetToken($email) {
        return DB::table('password_reset_tokens')->where('email', $email)->first();
    }

    public function deletePasswordResetToken($email) {
        DB::table('password_reset_tokens')->where('email', $email)->delete();
    }

    public function getUserByToken($token) {
        return DB::table('password_reset_tokens')->where('token', $token)->first();
    }
}
