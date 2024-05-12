<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Answers;

class AdminDashboard extends Component
{

    public $answer;

    private function checkAdmin($user){
        $userModel = new User();
        if ($userModel->getIsUserAdmin($user)){
            return true;
        }
        return false;

    }

    public function addAnswer($questionNumber){


        $this->validate([
            'answer' => 'required',
        ]);

        $answerModel = new Answers();
        $answerModel->addAnswer($this->answer, $questionNumber);
        $this->answer = '';
    }

    public function render(){
        $user = Auth::user();
        $answerModel = new Answers();
        $isAdmin = $this->checkAdmin($user);
        if ($isAdmin == true) {
            $answers = $answerModel->getPossibleAnswersForAll();
            $question_1_answers = $answers->where('question_number', 1);
            $question_2_answers = $answers->where('question_number', 2);
            $question_3_answers = $answers->where('question_number', 3);
            return view('livewire.admin-dashboard', [
                'question_1_answers' => $question_1_answers,
                'question_2_answers' => $question_2_answers,
                'question_3_answers' => $question_3_answers,
                'answer' => $this->answer
            ]);
        }
        return redirect()->to('/home');
    }
}


