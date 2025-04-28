<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Sleep;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Services\PasswordResetService;

class ResetPassword extends Component
{
    use LivewireAlert;
    public $password;
    public $password_confirmation;
    public $token;
    public $password_has_been_reset = false;
    protected $password_reset_service;
    protected $user_model;
    public function mount($token)
    {
        if(Auth::check()){
            return redirect()->to('/home');
        }
        $this->token = $token;

        if (!$this->checkToken()) {
            return redirect()->to('/');
        }
        $this->password_reset_service = new PasswordResetService();
        $this->user_model = new User();
    }

    public function hydrate() {
        $this->password_reset_service = new PasswordResetService();
        $this->user_model = new User();
    }

    private function checkToken() {
        $this->password_reset_service = new PasswordResetService();
        $user = $this->password_reset_service->getUserByToken($this->token);

        return $user;
    }

    public function resetPassword()
    {
        $this->validate([
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|min:8',
        ]);




        $user = $this->user_model->findByEmail(email: $this->password_reset_service->getUserByToken($this->token)->email);

        if ($user) {
            $user->updatePassword($this->password);
            $this->password_reset_service->deletePasswordResetToken($user->email);
            $this->showAlert('Parola a fost resetata cu succes.');
            $this->dispatch('redirectToHome');
            $this->password_has_been_reset = true;
        }
        else {
            $this->showAlert('A aparut o eroare la resetarea parolei.', 'error');
            $this->dispatch('redirectToHome');
        }
    }


    private function showAlert($message, $type = 'success'){
        $this->alert($type, $message[0], [
            'position' => 'center',
            'timer' => 3000,
            'toast' => true,
        ]);
    }

    public function render()
    {
        return view('livewire.reset-password');
    }
}
