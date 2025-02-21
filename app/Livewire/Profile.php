<?php

namespace App\Livewire;

use App\Models\Answers;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
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
    public $user_model;
    public $materii;
    public $nivel;
    public $stil_invatare;
    public function mount($id)
    {
        $answers_model = new Answers();
        $this->user_model = new User();
        $this->userId = $id;
        $this->user = $this->user_model->getUserWithProfile($this->userId);
        if (!$this->user) {
            abort(404);
        }
        $this->newPhone = $this->user->phone;
        $this->newEmail = $this->user->email;
        $this->newAboutMe = $this->user->about_me;
        $this->photo = $this->user->user_photo;
        $this->materii = $answers_model->getUserAnswersForQuestion($this->userId, 2);
        $this->stil_invatare = $answers_model->getUserAnswersForQuestion($this->userId, 3);
        $this->nivel = $answers_model->getUserAnswersForQuestion($this->userId, 4);
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

        $check = $this->user_model->updateProfile(['phone' => $this->newPhone]);

        $this->showAlert($check, "Numarul de telefon");

        $this->editingPhone = false;
    }

    public function triggerUpload()
    {
        $this->dispatch('triggerFileUpload');

    }

    public function updatedPhoto()
    {
        // Validate the uploaded file
        $this->validate([
            'photo' => 'image|max:1024',
        ]);

        // Get the uploaded file's temporary path
        $imagePath = $this->photo->getRealPath();

        // Resize the image to 128x128 pixels using Spatie Image
        $image = Image::load($imagePath)
            ->width(128)
            ->height(128)
            ->save($imagePath);

        // Save the image to storage
        $path = 'photos/' . $this->photo->getClientOriginalName();
        Storage::disk('public')->put($path, file_get_contents($imagePath));
        $this->photo = $path;

        // Update the user profile with the new photo path
        $check = $this->user_model->updateProfile(['user_photo' => $path]);

        // Provide feedback
        $this->showAlert($check, "Poza de profil");
    }


    private function showAlert($boolean, $type){

        $gen = null;
        if($type == "Numarul de telefon"){
            $gen = "a fost schimbat";
        } else if($type == "Descrierea ta" || $type == "Poza de profil"){
            $gen = "a fost schimbata";
        }

        if(!$boolean){
            $this->alert('error', $type . ' nu ' . $gen . '!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => true,
            ]);
        }
        else{
            $this->alert('success', $type . ' ' . $gen .'!', [
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

        $check = $this->user_model->updateProfile(['about_me'=>$this->newAboutMe]);

        $this->showAlert($check, "Descrierea ta");

        $this->editingAbout = false;
    }

    public function render()
    {
        $user_model = new User();
        $user = $user_model->getUserWithProfile(Auth::user());
        return view('livewire.profile', ['user' => $user]);
    }
}
