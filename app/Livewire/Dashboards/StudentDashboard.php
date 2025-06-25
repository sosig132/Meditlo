<?php

namespace App\Livewire\Dashboards;

use Livewire\Component;

class StudentDashboard extends Component
{
    public $tutors = [];
    public $upcomingSessions = [];
    public $pastSessions = [];

    public function mount()
    {
        $this->tutors = auth()->user()->getTutors();
        $this->upcomingSessions = auth()->user()->upcomingRegisteredSessions();
        $this->pastSessions = auth()->user()->pastRegisteredSessions();
    }
    public function render()
    {
        return view('livewire.dashboards.student-dashboard');
    }
}
