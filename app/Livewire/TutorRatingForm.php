<?php

namespace App\Livewire;

use App\Models\TutorRating;
use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class TutorRatingForm extends Component
{
  use LivewireAlert;

  public $tutorId;
  public $studentId;
  public $rating;
  public $comment;
  public $hoverRating = null;
  public $avgRating = null;
  private $successMessage = 'Rating submitted successfully!';
  private $errorMessage = 'An error occurred while submitting your rating.';
  protected $rules = [
    'rating' => 'required|integer|min:1|max:5',
    'comment' => 'nullable|string|max:500',
  ];
  public $checkStudent;
  public function mount($tutorId)
  {
    $this->tutorId = $tutorId;
    $this->studentId = auth()->user()->id;

    $tutor = User::find($this->tutorId);
    if (!$tutor) {
      abort(404, 'Tutor not found.');
    }

    if ($tutor->role !== 'tutor') {
      abort(403, 'The user is not a tutor.');
    }

    if ($this->studentId === $this->tutorId) {
      abort(403, 'You cannot rate yourself.');
    }

    $existingRating = $tutor->getGivenRatingByUser($this->studentId);

    if ($existingRating) {
      $this->rating = $existingRating->rating;
      $this->comment = $existingRating->comment;
    } else {
      $this->rating = 0;
      $this->comment = '';
    }
    $this->avgRating = TutorRating::getAverageRating($tutorId);
    $this->checkStudent = $this->checkStudent();
  }

  public function setHoverRating($rating)
  {
    $this->hoverRating = $rating;
  }

  public function resetHoverRating()
  {
    $this->hoverRating = $this->rating;
  }

  public function checkStudent()
  {
    $student = auth()->user();
    return User::checkIfStudentIsInTutorList($this->tutorId, $student->id);
  }

  public function submitRating()
  {
    $this->validate();
    try {
      $student = auth()->user();
      if (!$this->checkStudent()) {
        return;
      }
      $student->rateTutor($this->tutorId, $this->rating, $this->comment);
      $this->alert('success', $this->successMessage, [
        'position' => 'top',
        'timer' => 3000,
        'toast' => true,
      ]);
    } catch (\Exception $e) {
      session()->flash('error', $this->errorMessage);
      $this->alert('error', $this->errorMessage, [
        'position' => 'top',
        'timer' => 3000,
        'toast' => true,
      ]);
      \Log::error('Error submitting tutor rating: ' . $e->getMessage());
      return;
    }
  }

  public function render()
  {
    return view('livewire.tutor-rating-form');
  }
}
