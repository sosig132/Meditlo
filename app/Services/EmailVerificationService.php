<?php

namespace App\Services;

use App\Models\EmailVerificationToken;
use App\Models\User;

class EmailVerificationService
{
    public function updateVerificationToken($email, $token) {
        EmailVerificationToken::updateOrCreate(
            ['email' => $email],
            ['token' => $token, 'created_at' => now()]
        );
    }

    public function getVerificationToken($email) {
        return EmailVerificationToken::where('email', $email)->first();
    }

    public function deleteVerificationToken($email) {
        EmailVerificationToken::where('email', $email)->delete();
    }

    public function getUserByToken($token) {
        return EmailVerificationToken::where('token', $token)->first();
    }

    public function verifyEmail($email) {
        $user = User::where('email', $email)->first();
        if ($user) {
            $user->email_verified_at = now();
            $user->save();
            return true;
        }
        return false;
    }
} 