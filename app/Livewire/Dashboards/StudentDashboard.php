<?php

namespace App\Livewire\Dashboards;

use Livewire\Component;

class StudentDashboard extends Component
{
    public $tutors = [];

    public function mount()
    {
        $this->tutors = auth()->user()->getTutors();
    }
    public function render()
    {
        return view('livewire.dashboards.student-dashboard');
    }
}
