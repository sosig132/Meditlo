<?php

namespace App\Livewire;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Answers;


class AnswerQuestions extends Component
{
    use LivewireAlert;
    public $checkedAnswers = [];
    public $currentStep = 0;
    public $allAnswers = [];
    public $hasSelectedAnswers = [];
    public $card_title = ["Doresti sa fii student sau tutore?", "Ce materii te intereseseaza?", "Ce stil de invatare ti se potriveste mai bine?"];

    private function checkQuestions($user){
        $userModel = new User();
        $answers = $userModel->getDifferentQuestionsAnswersCount($user);
        if ($answers == 3) {
            return true;
        }
        return false;
    }

    private function getAllAnswers(){
        $possibleAnswers = $this->getPossibleAnswersForAll();
        $answers_1 = $possibleAnswers->where('question_number', 1);
        $answers_2 = $possibleAnswers->where('question_number', 2);
        $answers_3 = $possibleAnswers->where('question_number', 3);
        return [
            0 => $answers_1,
            1 => $answers_2,
            2 => $answers_3,
        ];
    }

    public function toggleCheck($answerId){
        if (in_array($answerId, $this->checkedAnswers)){
            $this->checkedAnswers = array_diff($this->checkedAnswers, [$answerId]);
        }
        else{
            $this->checkedAnswers[] = $answerId;
        }

    }

    public function nextStep(){
        if($this->currentStep < 2){
            sleep(0.5);
            $this->currentStep++;
        }
    }

    public function previousStep()
    {
        if ($this->currentStep > 0) {
            sleep(0.5);
            $this->currentStep--;

        }
    }

    private function getPossibleAnswersForAll(){
        $answersModel = new Answers();
        return $answersModel->getPossibleAnswersForAll();
    }

    private function getAnswerQuestionNumber($answerId)
    {
        foreach ($this->allAnswers as $answers) {
            foreach ($answers as $answer) {
                if ($answer->id == $answerId) {
                    return $answer->question_number;
                }
            }
        }
        return null;
    }

    public function submitAnswers(){
        $check = [0,0,0];
        foreach ($this->checkedAnswers as $answer){


            $check[$this->getAnswerQuestionNumber($answer) - 1] = 1;
        }

        if (in_array(0, $check)){
            // show error message
            $this->alert('error', 'Please answer all the questions!', [
                'position' => 'top',
                'timer' => 3000,
                'toast' => true,
            ]);
            return;
        }

        $user = Auth::user();
        $answersModel = new Answers();
        $userModel = new User();
        $actualAnswers = [];
        foreach ($this->checkedAnswers as $answer){
            $actualAnswers[] = $answersModel->getAnswerByAnswerId($answer)->answer;
        }

        if(in_array("Student", $actualAnswers)){
            $userModel->makeStudent($user->id);
        }

        if(in_array("Tutor", $actualAnswers)){
            $userModel->makeTutor($user->id);
        }
        
        $answersModel->addUserAnswers($this->checkedAnswers, $user->id);
        $this->alert('success', 'Answers submitted successfully!', [
            'position' => 'top',
            'timer' => 3000,
            'toast' => true,
        ]);
        return redirect()->route('home');
    }

    public function mount()
    {
        $user = Auth::user();
        $answers = $this->checkQuestions($user);

        if ($answers) {
            return redirect()->route('home');
        }
    }

    public function render(){
        $this->allAnswers = $this->getAllAnswers();
        $this->hasSelectedAnswers = array_fill(0, 3, 0);
        return view('livewire.answer-questions',
            [
                'currentAnswers' => $this->allAnswers[$this->currentStep],
            ]);
    }
}
