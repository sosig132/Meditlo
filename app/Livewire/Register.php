<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class Register extends Component
{
    public $name;
    public $email;
    public $password;


    public function register()
    {
        $validated = $this->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        User::create($validated);

        session()->flash('message', 'User created successfully.');

        Auth::attempt($validated);

        return redirect()->to('/home');
    }

    public function render()
    {
        return view('livewire.register');
    }
}
