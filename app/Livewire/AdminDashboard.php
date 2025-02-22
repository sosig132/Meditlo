<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Answer;
use App\Models\PossibleAnswer;

class AdminDashboard extends Component
{
    public $answers = [];
    private $possibleAnswers;

    public function mount()
    {
        if (!$this->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        foreach (range(1, 4) as $questionNumber) {
            $this->answers[$questionNumber] = '';
        }
        $this->possibleAnswers = PossibleAnswer::getAnswersGroupedByQuestionNumber();
    }

    public function getPossibleAnswers()
    {
        return $this->possibleAnswers;
    }

    private function isAdmin(): bool
    {
        return User::find(Auth::id())->isAdmin();
    }

    public function addAnswer($questionNumber)
    {
        $this->validate([
            "answers.$questionNumber" => 'required|string',
        ]);

        PossibleAnswer::addPossibleAnswer($this->answers[$questionNumber], $questionNumber);
        $this->answers[$questionNumber] = '';
        $this->possibleAnswers = PossibleAnswer::getAnswersGroupedByQuestionNumber();
    }

    public function render()
    {
        // dd($this->getPossibleAnswers());
        return view('livewire.admin-dashboard', [
            'questions' => range(1, 4),
            'possibleAnswers' => $this->getPossibleAnswers(),
        ]);
    }
}
