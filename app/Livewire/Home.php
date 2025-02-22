<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class Home extends Component
{
    public function mount(){
        if(!Auth::check()){
            return redirect()->to('/');
        }
    }

    public function render()
    {
        return view('livewire.home');
    }
}
