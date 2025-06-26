<?php

namespace App\Livewire;

use App\Models\Answer;
use App\Models\PossibleAnswer;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class EditAnswers extends Component
{
    use LivewireAlert;

    public $checkedAnswers = [];
    public $allAnswers = [];
    public $user;
    public $questions = [
        2 => "What subjects are you interested in?",
        3 => "Online or in person?",
        4 => "What education level are you interested in?"
    ];

    public function mount()
    {
        $this->user = Auth::user();
        $this->loadAnswers();
    }

    private function loadAnswers()
    {
        // Get all possible answers for questions 2, 3, and 4
        $this->allAnswers = collect(range(2, 4))
            ->mapWithKeys(fn($q) => [$q => PossibleAnswer::getPossibleAnswersForQuestion($q)]);

        // Get user's current answers
        $this->checkedAnswers = $this->user->answers()
            ->whereHas('possibleAnswer', function ($query) {
                $query->whereIn('question_number', [2, 3, 4]);
            })
            ->pluck('answer_id')
            ->toArray();
    }

    public function toggleCheck($answerId)
    {
        $possibleAnswer = PossibleAnswer::find($answerId);
        if (!$possibleAnswer) {
            return;
        }

        // Allow multiple selections for all questions (2, 3, and 4)
        if (in_array($answerId, $this->checkedAnswers)) {
            $this->checkedAnswers = array_diff($this->checkedAnswers, [$answerId]);
        } else {
            $this->checkedAnswers[] = $answerId;
        }
    }

    public function saveAnswers()
    {
        // Validate that at least one answer is selected for each question
        $answeredQuestions = collect($this->checkedAnswers)
            ->map(fn($id) => PossibleAnswer::find($id)->question_number)
            ->unique()
            ->count();

        if ($answeredQuestions < 3) {
            $this->alert('error', 'Please answer all questions!', [
                'position' => 'top',
                'timer' => 3000,
                'toast' => true,
            ]);
            return;
        }

        // Delete existing answers for questions 2, 3, and 4
        $this->user->answers()
            ->whereHas('possibleAnswer', function ($query) {
                $query->whereIn('question_number', [2, 3, 4]);
            })
            ->delete();

        // Add new answers
        $data = collect($this->checkedAnswers)->map(fn($answer) => [
            'user_id' => $this->user->id,
            'answer_id' => $answer,
            'created_at' => now(),
            'updated_at' => now(),
        ])->toArray();

        Answer::insert($data);

        $this->alert('success', 'Answers updated successfully!', [
            'position' => 'top',
            'timer' => 3000,
            'toast' => true,
        ]);

        $this->dispatch('closeEditAnswersModal');
    }

    public function render()
    {
        return view('livewire.edit-answers');
    }
} 