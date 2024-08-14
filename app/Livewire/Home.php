<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class Home extends Component
{

    public function render()
    {
        if(!Auth::check()){
            return redirect()->to('/');
        }

        return view('livewire.home');

        #return redirect()->to('/answer-questions');
    }
}
