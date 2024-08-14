<?php

namespace App\Livewire;

use Illuminate\Support\Collection;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Welcome extends Component
{
    public function mount(){
        // if logged in, redirect to home
        if(Auth::check()){
            return redirect()->to('/home');
        }
    }
    public function render()
    {
        return view('livewire.welcome');
    }
}
