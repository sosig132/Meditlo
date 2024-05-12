<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class Login extends Component
{


    public $email;
    public $password;

    public function login()
    {
        $validated = $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

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
        else{
            return redirect()->to('/home');
        }
    }
    public function render()
    {
        return view('livewire.login');
    }
}
