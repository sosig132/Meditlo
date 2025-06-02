<?php

namespace App\Livewire;

use App\Models\MatchRequest;
use App\Models\PossibleAnswer;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\RatingService;

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
  public $userId;
  protected $user_model;
  public $sortBy = 'relevance';
  public $sorts = [
    'relevance' => 'Relevance',
    'rating' => 'Rating',
    'newest' => 'Newest',
    'most_rated' => 'Most Rated',
  ];
  public $modalUser = null;
  protected $ratingService;

  public function mount(RatingService $ratingService)
  {
    if (!Auth::check()) {
      return redirect()->to('/');
    }
    $this->ratingService = $ratingService;
    $this->userId = Auth::id();
    $this->user_model = new User();
    $this->optionsSubjects = $this->getSubjects();
    $this->optionsLevels = $this->getLevels();
    $this->optionsStyles = $this->getStyles();
    $this->users = $this->getRecommendations();
    $this->sortUsers();
  }

  public function boot(RatingService $ratingService)
  {
    $this->ratingService = $ratingService;
  }

  public function hydrate()
  {
    $this->user_model = new User();
  }

  public function getSubjects()
  {
    $subjects = PossibleAnswer::getPossibleAnswersForQuestion(2);
    $subjects = $this->getAnswersFromCollection($subjects);
    return $subjects;
  }

  public function getLevels()
  {
    $levels = PossibleAnswer::getPossibleAnswersForQuestion(4);
    $levels = $this->getAnswersFromCollection($levels);
    return $levels;
  }

  public function getStyles()
  {
    $styles = PossibleAnswer::getPossibleAnswersForQuestion(3);
    $styles = $this->getAnswersFromCollection($styles);
    return $styles;
  }

  protected function getAnswersFromCollection($collection)
  {
    return $collection->map(fn($answer) => $answer->answer)->toArray();
  }

  protected function filteredUsers($role)
  {
    $users = $this->user_model->filterUsers($this->selectedSubjects, $this->selectedLevels, $this->selectedStyles, $this->personName, $role);
    return $users->filter(function ($user) {
      return $user->profile && !User::checkIfStudentIsInTutorList(Auth::id(), $user->id) && !User::checkIfStudentIsInTutorList($user->id, Auth::id());
    });
  }

  protected function filterUsersByRole($users, $role)
  {
    return $users->filter(function ($user) use ($role) {
      return $user->role === $role;
    });
  }

  public function getRecommendations()
  {
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

  protected function getUserRole()
  {
    if (!$this->userId) {
      return 'tutor';
    }
    return $this->user_model->getUserById($this->userId)->role;
  }

  public function showUserModal($id)
  {
    $this->modalUser = $this->user_model->getUserById($id);
    if (!$this->modalUser) {
      return;
    }

    $this->dispatch('show-modal');
  }

  public function closeUserModal()
  {
    $this->dispatch('close-modal');
  }

  public function sendMatchRequest($userId)
  {
    $this->dispatch('matchRequestSent', $userId);
  }

  //TODO: make sorts. for relevance, the rating portion should be calculated using Bayesian average, maybe with an exponential decay factor, or if time doesn't allow, just use recent rating weighting

  public function sortUsers()
  {
    switch ($this->sortBy) {
      case 'relevance':
        $this->users = $this->users->sortByDesc(function (User $user) {
          return $this->getRelevanceScore($user);
        });
        break;
      case 'rating':
        $this->users = $this->users->sortByDesc(function (User $user) {
          return $user->getAverageRating();
        });
        break;
      case 'newest':
        $this->users = $this->users->sortByDesc(function (User $user) {
          return $user->created_at;
        });
        break;
      case 'most_rated':
        $this->users = $this->users->sortByDesc(function (User $user) {
          return $user->getRatingCount();
        });
        break;
    }
  }

  protected function getRelevanceScore(User $user)
  {


    $weights = [0.4, 0.5, 0.3];
    $weightSum = array_sum($weights);

    $currentUser = User::find($this->userId);
    if (!$currentUser) {
      return 0;
    }
    $questionScores = [];

    foreach (range(2, 4) as $questionNumber) {
      $questionScores[$questionNumber] = $currentUser->getSameAnswerCount($questionNumber, $user->id) * $weights[$questionNumber - 2];
    }

    $totalScore = array_sum($questionScores) / $weightSum;
    if ($currentUser->role == 'student' || $currentUser->role == 'admin') {
      $weighted = $this->ratingService->computeWeightedAverage($user->id, 0.03);
      $bayesianAverage = $this->ratingService->computeBayesianAverage($weighted['average'], (int) round($weighted['count']));
      $score = $bayesianAverage + $totalScore;
    } else {
      $score = $totalScore;
    }
    if ($score < 0) {
      $score = 0;
    }
    return $score;
  }

  public function render()
  {
    return view('livewire.home');
  }
}
