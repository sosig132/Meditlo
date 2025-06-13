<?php

namespace App\Livewire;

use Illuminate\Support\Collection;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Welcome extends Component
{
    use LivewireAlert;

    public function mount(){
        // if logged in, redirect to home
        if(Auth::check()){
            return redirect()->to('/home');
        }

        // Check for email verification messages
        if (session()->has('success')) {
            $this->alert('success', session('success'), [
                'position' => 'center',
                'timer' => 5000,
                'toast' => true,
            ]);
        }

        if (session()->has('error')) {
            $this->alert('error', session('error'), [
                'position' => 'center',
                'timer' => 5000,
                'toast' => true,
            ]);
        }
    }

    public function render()
    {
        return view('livewire.welcome');
    }
}
