<?php

namespace App\Livewire;

use App\Models\PossibleAnswer;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class Home extends Component
{
    public $personName;
    public $optionsSubjects = [];
    public $optionsLevels = [];
    public $optionsStyles = [];

    public $selectedSubjects = [];
    public $selectedLevels = [];
    public $selectedStyles = [];

    protected $listeners = ['optionsUpdated' => 'updateSelectedOptions'];
    public function mount(){
        if(!Auth::check()){
            return redirect()->to('/');
        }
        $this->optionsSubjects = $this->getSubjects();
        $this->optionsLevels = $this->getLevels();
        $this->optionsStyles = $this->getStyles();
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

    private function getAnswersFromCollection($collection){
        return $collection->map(fn($answer) => $answer->answer)->toArray();
    }

    public function updateSelectedOptions($collection, $selected){
        $this->$collection = $selected;
    }

    public function filter(){
        dd($this->selectedSubjects);
    }

    public function render()
    {
        return view('livewire.home');
    }
}
