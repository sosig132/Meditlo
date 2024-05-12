<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class Home extends Component
{


    private function checkAnswers(){
        $user = Auth::user();
        $userModel = new User();

        $answers = $userModel->getUserAnswers($user);
        if ($answers->count() == 3) {
            return true;
        }
        return $answers->count();
    }

    public function render()
    {
        if(!Auth::check()){
            return redirect()->to('/');
        }

        $answers = $this->checkAnswers();

        if ($answers == true) {
            return view('livewire.home');
        }
        return view('livewire.home');

        #return redirect()->to('/answer-questions');
    }
}
