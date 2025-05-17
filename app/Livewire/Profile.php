<?php

namespace App\Livewire;

use App\Models\Answer;
use App\Models\Categories;
use Livewire\Component;
use App\Models\User;
use Livewire\WithFileUploads;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Spatie\Image\Image;
use Illuminate\Support\Facades\Storage;

class Profile extends Component
{
  use WithFileUploads;
  use LivewireAlert;

  public $user;
  public $editingPhone = false;
  public $editingEmail = false;
  public $editingAbout = false;
  public $newPhone;
  public $newEmail;
  public $newAboutMe;
  public $userId;
  public $photo;
  private $user_model;
  public $materii = [];
  public $nivel = [];
  public $stil_invatare = [];
  private $profile_model;
  public $newCategory;
  public $categories = [];
  public $categoryToDelete = null;
  public function mount($id)
  {
    $answers_model = new Answer();
    $this->user_model = new User();
    $this->profile_model = new \App\Models\Profile();
    $this->userId = $id;
    $this->user = User::with('profile')->find($this->userId);
    if (!$this->user) {
      abort(404);
    }
    $this->newEmail = $this->user->email;
    $this->newPhone = $this->user->profile->phone;
    $this->newAboutMe = $this->user->profile->about_me;
    $this->photo = $this->user->profile->user_photo;
    $this->materii = $answers_model->getUserAnswersForQuestion($this->userId, 2);
    $this->stil_invatare = $answers_model->getUserAnswersForQuestion($this->userId, 3);
    $this->nivel = $answers_model->getUserAnswersForQuestion($this->userId, 4);
    if ($id == auth()->user()->id) {
      $this->categories = $this->user->getOwnedCategories();
    }
    else if (User::checkIfStudentIsInTutorList($this->userId, auth()->user()->id)) {
      $this->categories = User::getStudentCategoriesForTutor(auth()->user()->id, $this->userId);
    }
  }

  public function hydrate() {
    $this->user = User::with('profile')->find($this->userId);
    if (!$this->user) {
      abort(404);
    }
  }

  public function getMaterii()
  {
    return $this->materii;
  }

  public function getStilInvatare()
  {
    return $this->stil_invatare;
  }

  public function getNivel()
  {
    return $this->nivel;
  }

  public function toggleEdit($field)
  {
    if ($field === 'phone') {
      $this->editingPhone = !$this->editingPhone;
    } elseif ($field === 'email') {
      $this->editingEmail = !$this->editingEmail;
    } elseif ($field === 'about_me') {
      $this->editingAbout = !$this->editingAbout;
    }
  }

  public function updatePhone()
  {
    $this->validate([
      'newPhone' => 'nullable|string|max:15',
    ]);
    $check = \App\Models\Profile::updateProfile(['phone' => $this->newPhone], $this->userId);

    $this->showAlert($check, "Numarul de telefon");

    $this->editingPhone = false;
  }

  public function triggerUpload()
  {
    $this->dispatch('triggerFileUpload');

  }

  public function updatedPhoto()
  {
    $this->validate([
      'photo' => 'image|max:1024',
    ]);

    $imagePath = $this->photo->getRealPath();

    $image = Image::load($imagePath)
      ->width(128)
      ->height(128)
      ->save($imagePath);

    $path = 'photos/' . $this->photo->getClientOriginalName();
    Storage::disk('public')->put($path, file_get_contents($imagePath));
    $this->photo = $path;

    $check = \App\Models\Profile::updateProfile(['user_photo' => $path], $this->userId);

    $this->showAlert($check, "Poza de profil");
  }


  private function showAlert($boolean, $type)
  {

    $gen = null;
    if ($type == "Numarul de telefon") {
      $gen = "a fost schimbat";
    } else if ($type == "Descrierea ta" || $type == "Poza de profil") {
      $gen = "a fost schimbata";
    }

    if (!$boolean) {
      $this->alert('error', $type . ' nu ' . $gen . '!', [
        'position' => 'center',
        'timer' => 3000,
        'toast' => true,
      ]);
    } else {
      $this->alert('success', $type . ' ' . $gen . '!', [
        'position' => 'center',
        'timer' => 3000,
        'toast' => true,
      ]);
    }
  }

  public function updateAboutMe()
  {
    $this->validate([
      'newAboutMe' => 'nullable|string|max:500',
    ]);

    $check = \App\Models\Profile::updateProfile(['about_me' => $this->newAboutMe], $this->userId);

    $this->showAlert($check, "Descrierea ta");

    $this->editingAbout = false;
  }

  public function addCategory()
  {
    if (!$this->user->isTutor()) {
      return;
    }

    if (empty($this->newCategory)) {
      $this->dispatch('closeAddCategoryModal');

      $this->alert('error', 'Introduceti o categorie!', [
        'position' => 'center',
        'timer' => 3000,
        'toast' => true,
      ]);
      return;
    }

    if (strlen($this->newCategory) > 50) {
      $this->dispatch('closeAddCategoryModal');

      $this->alert('error', 'Categoria nu poate depasi 50 de caractere!', [
        'position' => 'center',
        'timer' => 3000,
        'toast' => true,
      ]);
      return;
    }
    if ($this->user->userHasOwnedCategory($this->newCategory)) {
      $this->dispatch('closeAddCategoryModal');
      $this->alert('error', 'Categoria exista deja!', [
        'position' => 'center',
        'timer' => 3000,
        'toast' => true,
      ]);
      return;
    }

    $check = Categories::addCategory($this->newCategory, $this->userId);

    if (!$check) {
      $this->alert('error', 'A aparut o eroare la adaugarea categoriei!', [
        'position' => 'center',
        'timer' => 3000,
        'toast' => true,
      ]);
    }
    $this->categories = $this->user->getOwnedCategories();
    $this->dispatch('closeAddCategoryModal');
  }

  public function deleteCategory()
  {
    if (!$this->user->isTutor()) {
      return;
    }
    if ($this->categoryToDelete && $this->user->userHasOwnedCategory($this->categoryToDelete)) {
      $categoryId = $this->user->getOwnedCategoryId($this->categoryToDelete);
      $check = Categories::deleteCategory($categoryId);
      $this->dispatch('closeDeleteCategoryModal');
      $this->categoryToDelete = null;
      $this->categories = $this->user->getOwnedCategories();
      if (!$check) {
        $this->alert('error', 'A aparut o eroare la stergerea categoriei!', [
          'position' => 'center',
          'timer' => 3000,
          'toast' => true,
        ]);
      } else {
        $this->alert('success', 'Categoria a fost stearsa!', [
          'position' => 'center',
          'timer' => 3000,
          'toast' => true,
        ]);
      }
    }
  }

  public function render()
  {
    return view('livewire.profile', [
      'materii' => $this->getMaterii(),
      'stil_invatare' => $this->getStilInvatare(),
      'nivel' => $this->getNivel(),
    ]);
  }
}
