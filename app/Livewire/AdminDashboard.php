<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Answers;

class AdminDashboard extends Component
{
    public $answer1;
    public $answer2;
    public $answer3;
    public $answer4;

    private function checkAdmin($user){
        $userModel = new User();
        if ($userModel->getIsUserAdmin($user)){
            return true;
        }
        return false;
    }

    public function addAnswer($questionNumber){
        $answerProperty = 'answer' . $questionNumber;

        $this->validate([
            $answerProperty => 'required',
        ]);

        $answerModel = new Answers();
        $answerModel->addAnswer($this->$answerProperty, $questionNumber);
        $this->$answerProperty = '';
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
            $question_4_answers = $answers->where('question_number', 4);
            return view('livewire.admin-dashboard', [
                'question_1_answers' => $question_1_answers,
                'question_2_answers' => $question_2_answers,
                'question_3_answers' => $question_3_answers,
                'question_4_answers' => $question_4_answers,
                'answer1' => $this->answer1,
                'answer2' => $this->answer2,
                'answer3' => $this->answer3,
                'answer4' => $this->answer4,
            ]);
        }
        return redirect()->to('/home');
    }
}
