<?php

namespace App\Livewire;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Answer;
use App\Models\PossibleAnswer;

class AdminDashboard extends Component
{
  use LivewireAlert;
  public $answers = [];
  public $possibleAnswers;
  public $users = [];
  public $selectedUser = null;

  public function mount()
  {
    if (!$this->isAdmin()) {
      abort(403, 'Unauthorized action.');
    }

    foreach (range(1, 4) as $questionNumber) {
      $this->answers[$questionNumber] = '';
    }
    $this->possibleAnswers = PossibleAnswer::getAnswersGroupedByQuestionNumber()->map(function ($group) {
      return $group->toArray();
    })->toArray();


    $this->users = User::getNonAdminUsers();
  }

  public function getPossibleAnswers()
  {
    return $this->possibleAnswers;
  }

  public function selectUser($userId)
  {
    $this->selectedUser = $userId;
  }

  public function deleteUser($userId)
  {
    if (!$this->isAdmin()) {
      abort(403, 'Unauthorized action.');
    }

    $user = User::find($userId);
    if ($user) {
      $user->deleteUser();
      $this->users = User::getNonAdminUsers();
      session()->flash('message', 'User deleted successfully.');
    } else {
      session()->flash('error', 'User not found.');
    }
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
    $this->possibleAnswers = PossibleAnswer::getAnswersGroupedByQuestionNumber()->map(function ($group) {
        return $group->toArray();
      })->toArray();;
  }

  public function runCron()
  {
    if (!$this->isAdmin()) {
      abort(403, 'Unauthorized action.');
    }

    \Artisan::call('app:cache-global-rating-average');
    $this->alert('success', 'Cron job executed successfully!', [
      'position' => 'top-end',
      'timer' => 3000,
      'toast' => true,
    ]);
  }

  public function deleteAnswer($answerId)
  {
    if (!$this->isAdmin()) {
      abort(403, 'Unauthorized action.');
    }

    $answer = PossibleAnswer::find($answerId);
    if ($answer) {
      $answer->delete();
      $this->possibleAnswers = PossibleAnswer::getAnswersGroupedByQuestionNumber()->map(function ($group) {
        return $group->toArray();
      })->toArray();
      $this->alert('success', 'Answer deleted successfully!', [
        'position' => 'top-end',
        'timer' => 3000,
        'toast' => true,
      ]);
    } else {
      $this->alert('error', 'Answer not found!', [
        'position' => 'top-end',
        'timer' => 3000,
        'toast' => true,
      ]);
    }
  }

  public function render()
  {
    return view('livewire.admin-dashboard', [
      'questions' => range(1, 4),
    ]);
  }
}
