<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\EmailVerificationMail;
use App\Services\EmailVerificationService;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Register extends Component
{
    use LivewireAlert;

    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    protected $email_verification_service;

    public function mount() {
        $this->email_verification_service = new EmailVerificationService();
    }

    public function hydrate() {
        $this->email_verification_service = new EmailVerificationService();
    }

    public function register()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:30',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
        ]);

        $user = User::createUser($validated);

        // Generate verification token and send email
        $token = Str::random(60);
        $this->email_verification_service->updateVerificationToken($user->email, $token);
        Mail::to($user->email)->send(new EmailVerificationMail($user, $token));

        $this->alert('success', 'Registration successful! Please check your email to verify your account before logging in.', [
            'position' => 'center',
            'timer' => 5000,
            'toast' => true,
        ]);
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
