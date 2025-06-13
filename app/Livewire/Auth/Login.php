<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Login extends Component
{
    use LivewireAlert;

    public $email;
    public $password;

    public function login()
    {
        $validated = $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (!$user) {
            $this->addError('email', 'Email or password is wrong.');
            return;
        }

        if (!$user->email_verified_at) {
            $this->addError('email', 'Please verify your email address before logging in.');
            return;
        }

        if (Auth::attempt($validated)) {
            session()->regenerate();
            return redirect()->to('/home');
        }

        $this->addError('email', 'Email or password is wrong.');
    }

    public function index()
    {
        if (!Auth::check()) {
            return redirect()->to('/landing');
        }
        else {
            return redirect()->to('/home');
        }
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
