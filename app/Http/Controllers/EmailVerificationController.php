<?php

namespace App\Http\Controllers;

use App\Services\EmailVerificationService;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    protected $email_verification_service;

    public function __construct(EmailVerificationService $email_verification_service)
    {
        $this->email_verification_service = $email_verification_service;
    }

    public function verify($token)
    {
        $verification = $this->email_verification_service->getUserByToken($token);

        if (!$verification) {
            return redirect()->route('unauthenticated')->with('error', 'Invalid verification token.');
        }

        if ($this->email_verification_service->verifyEmail($verification->email)) {
            $this->email_verification_service->deleteVerificationToken($verification->email);
            return redirect()->route('unauthenticated')->with('success', 'Email verified successfully! You can now log in.');
        }

        return redirect()->route('unauthenticated')->with('error', 'Failed to verify email.');
    }
} 