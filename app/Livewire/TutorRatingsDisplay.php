<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\TutorRating;
use App\Models\User;

class TutorRatingsDisplay extends Component
{
    public $tutorId;
    public $ratings;
    public $average;
    public $count;

    public function mount($tutorId)
    {
        $this->tutorId = $tutorId;
        $this->ratings = TutorRating::where('tutor_id', $tutorId)->latest()->get();
        $this->average = $this->ratings->avg('rating');
        $this->count = $this->ratings->count();
    }

    public function render()
    {
        return view('livewire.tutor-ratings-display');
    }
} 