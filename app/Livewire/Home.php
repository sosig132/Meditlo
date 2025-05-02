<?php

namespace App\Livewire;

use App\Models\MatchRequest;
use App\Models\PossibleAnswer;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class Home extends Component
{
    public $personName = "";
    public $optionsSubjects = [];
    public $optionsLevels = [];
    public $optionsStyles = [];

    public $selectedSubjects = [];
    public $selectedLevels = [];
    public $selectedStyles = [];
    public $users = [];
    protected $userId;
    protected $user_model;
    public $modalUser = null;

    public function mount(){
        if(!Auth::check()){
            return redirect()->to('/');
        }
        $this->userId = Auth::id();
        $this->user_model = new User();
        $this->optionsSubjects = $this->getSubjects();
        $this->optionsLevels = $this->getLevels();
        $this->optionsStyles = $this->getStyles();
        $this->users = $this->getRecommendations();
    }

    public function hydrate(){
        $this->user_model = new User();
        $this->userId = Auth::id();
    }

    public function getSubjects(){
        $subjects = PossibleAnswer::getPossibleAnswersForQuestion(2);
        $subjects = $this->getAnswersFromCollection($subjects);
        return $subjects;
    }

    public function getLevels(){
        $levels = PossibleAnswer::getPossibleAnswersForQuestion(4);
        $levels = $this->getAnswersFromCollection($levels);
        return $levels;
    }

    public function getStyles(){
        $styles = PossibleAnswer::getPossibleAnswersForQuestion(3);
        $styles = $this->getAnswersFromCollection($styles);
        return $styles;
    }

    protected function getAnswersFromCollection($collection){
        return $collection->map(fn($answer) => $answer->answer)->toArray();
    }

    protected function filteredUsers($role){
        $users =  $this->user_model->filterUsers($this->selectedSubjects, $this->selectedLevels, $this->selectedStyles, $this->personName, $role);
        return $users->filter(function ($user) {
            return $user->profile;
        });
    }

    protected function filterUsersByRole($users, $role) {
        return $users->filter(function ($user) use ($role) {
            return $user->role === $role;
        });
    }

    public function getRecommendations() {
        $role = $this->getUserRole();
        $roleToGet = ($role === 'student' || $role === 'admin') ? 'tutor' : 'student';
        $filteredUsers = $this->filteredUsers($roleToGet);
        if (!$filteredUsers->isEmpty()) {
            $this->users = $filteredUsers;
            return $this->users;
        }
        $this->users = collect();

        return $this->users;
    }

    protected function getUserRole() {
        if (!$this->userId) {
            return 'tutor';
        }
        return $this->user_model->getUserById($this->userId)->role;
    }

    public function showUserModal($id) {
        $this->modalUser = $this->user_model->getUserById($id);
        if (!$this->modalUser) {
            return;
        }

        $this->dispatch('show-modal');
    }

    public function closeUserModal() {
        $this->dispatch('close-modal');
    }

    public function sendMatchRequest($userId) {
        $this->dispatch('matchRequestSent',  $userId);
    }

    public function render()
    {
        return view('livewire.home');
    }
}
