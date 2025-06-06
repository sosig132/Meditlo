<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class Register extends Component
{
    public $name;
    public $email;
    public $password;
    public $password_confirmation;

    public function register()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:30',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
        ]);

        User::createUser($validated);

        session()->flash('message', 'User created successfully.');

        Auth::attempt($validated);

        return redirect()->to('/home');
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
