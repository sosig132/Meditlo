<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class TutorDashboard extends Component
{
    use LivewireAlert;

    public $students = [];
    public $categories = [];
    public $selectedStudentId = null;
    public $studentCategories = []; 
    public $selectedCategories = [];
    public $selectedStudentToRemoveId = null;
    public $user;
    public $showRemoveStudentModal = false;
    public function mount() {
      
        $this->user = Auth::user();
        if ($this->user->role !== 'tutor') {
            return redirect()->to('/');
        }
        $this->students = $this->user->getStudents();
        $this->categories = $this->user->getOwnedCategories();
    }

    public function hydrate() {
        $this->user = Auth::user();
        $this->students = $this->user->getStudents();
        $this->categories = $this->user->getOwnedCategories();
    }

    public function removeStudent($studentId) {
        $this->user->removeStudentFromTutor($studentId);
        $this->students = $this->user->getStudents();

        $this->alert('success', 'Student removed successfully.');
    }

    public function selectStudentToRemove($studentId) {
        $this->selectedStudentToRemoveId = $studentId;
    }
    public function confirmRemoveStudent() {
        $this->removeStudent($this->selectedStudentToRemoveId);
        $this->selectedStudentToRemoveId = null;
    }
    public function cancelRemoveStudent() {
        $this->selectedStudentToRemoveId = null;
    }

    public function assignCategories() {
        User::assignCategoriesToStudent($this->selectedCategories, $this->selectedStudentId);
        $this->studentCategories = [];
        $this->selectedCategories = [];
        $this->selectedStudentId = null;
        $this->alert('success', 'Categories assigned successfully.');
    }

    public function getStudentCategories() {
        $this->studentCategories = User::getStudentCategories($this->selectedStudentId);
        $this->selectedCategories = [];
        foreach ($this->studentCategories as $category) {
            if (in_array($category->id, $this->categories->pluck('id')->toArray())) {
                $this->selectedCategories[] = $category->id;
            }
        }
    }

    public function selectStudent($studentId) {
        $this->selectedStudentId = $studentId;
        $this->getStudentCategories();
    }

    public function unselectStudent() {
        $this->selectedStudentId = null;
        $this->studentCategories = [];
        $this->selectedCategories = [];
    }
    public function updateSelectedCategories($categories) {
        $this->selectedCategories = $categories;
    }

    
    public function render()
    {
        return view('livewire.tutor-dashboard');
    }
}
