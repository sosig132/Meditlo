<?php

namespace App\Livewire;

use App\Models\Answer;
use App\Models\PossibleAnswer;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class AnswerQuestions extends Component
{
    use LivewireAlert;
    public $checkedAnswers = [];
    public $currentStep = 0;
    public $allAnswers = [];
    public $hasSelectedAnswers = [];
    public $card_title = [
        // "Doresti sa fii student sau tutore?",
        // "Ce materii te intereseseaza?",
        // "Online sau fata in fata?",
        // "Ce nivel de invatamant te intereseseaza?"
        "Do you want to be a student or a tutor?",
        "What subjects are you interested in?",
        "Online or face-to-face?",
        "What level of education are you interested in?",
    ];

    protected $answersModel;

    public function mount()
    {
        $user = $this->getAuthUser();

        if ($this->hasAnsweredAllQuestions($user)) {
            return redirect()->route('home');
        }

        $this->allAnswers = $this->getAllAnswers();
        $this->checkedAnswers = $this->getUserCheckedAnswers($user);
        $this->answersModel = new Answer();
    }

    private function hasAnsweredAllQuestions(User $user)
    {
        return $user->getDifferentQuestionsAnswersCount() === count($this->card_title);
    }

    private function getAuthUser()
    {
        return User::find(Auth::user()->id);
    }

    private function getAllAnswers(){
        $possibleAnswers = PossibleAnswer::getPossibleAnswers();
        return collect(range(1, count($this->card_title)))
            ->mapWithKeys(fn($q) => [$q - 1 => $possibleAnswers->where('question_number', $q)]);
    }

    private function getUserCheckedAnswers(User $user)
    {
        return $user->answers()->pluck('answer_id')->toArray();
    }

    private function checkQuestions($user){
        $user = User::find(Auth::user()->id);
        $answers = $user->getDifferentQuestionsAnswersCount();
        if ($answers == count($this->card_title)) {
            return true;
        }
        return false;
    }


    public function toggleCheck($answerId){
        $tutorAnswerId = PossibleAnswer::getTutorAnswerId();
        $studentAnswerId = PossibleAnswer::getStudentAnswerId();

        $pair = [$tutorAnswerId => $studentAnswerId, $studentAnswerId => $tutorAnswerId];

        // if the answer is tutor or student, remove the other one
        if (isset($pair[$answerId])) {
            $this->checkedAnswers = array_diff($this->checkedAnswers, [$pair[$answerId]]);
        }
        if (in_array($answerId, $this->checkedAnswers)){
            $this->checkedAnswers = array_diff($this->checkedAnswers, [$answerId]);
        } else {
            $this->checkedAnswers[] = $answerId;
        }
    }

    public function nextStep(){
        if($this->currentStep < count($this->card_title) - 1){
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

        return PossibleAnswer::getPossibleAnswers();
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
        if (!$this->validateAllQuestionsAnswered()) {
            $this->alertError('Please answer all the questions!');
            return;
        }

        $user = $this->getAuthUser();
        $actualAnswers = [];
        $actualAnswers = collect($this->checkedAnswers)
            ->map(fn($id) => PossibleAnswer::getPossibleAnswerById($id)->answer);

        if ($actualAnswers->contains('Student')) {
            $user->makeStudent();
        }
        if ($actualAnswers->contains('Tutore')) {
            $user->makeTutor();
        }

        Answer::addUserAnswers($this->checkedAnswers, $user->id);
        $this->alertSuccess('Answers submitted successfully!');
        return redirect()->route('home');
    }

    private function validateAllQuestionsAnswered()
    {
        $answered = collect($this->checkedAnswers)
            ->map(fn($id) => $this->getAnswerQuestionNumber($id))
            ->unique()
            ->count();

        return $answered === count($this->card_title);
    }

    private function alertError($message){
        $this->alert('error', $message, [
            'position' => 'top',
            'timer' => 3000,
            'toast' => true,
        ]);
    }

    private function alertSuccess($message){
        $this->alert('success', $message, [
            'position' => 'top',
            'timer' => 3000,
            'toast' => true,
        ]);
    }

    public function render()
    {
        return view('livewire.answer-questions', [
            'currentAnswers' => $this->allAnswers[$this->currentStep] ?? [],
        ]);
    }
}
