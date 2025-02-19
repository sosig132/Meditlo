<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Sleep;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ResetPassword extends Component
{
    use LivewireAlert;
    public $password;
    public $password_confirmation;
    public $token;
    public $password_has_been_reset = false;
    public function mount($token)
    {
        if(Auth::check()){
            return redirect()->to('/home');
        }
        $this->token = $token;
    }

    public function resetPassword()
    {
        $this->validate([
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|min:8',
        ]);

        $user_model = new User();

        $user = $user_model->getUserByEmail($user_model->getUserByToken($this->token)->email);

        if ($user) {
            $user_model->updatePassword($user, $this->password);
            $user_model->deletePasswordResetToken($user->email);
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
        $user_model = new User();
        $token = $user_model->getUserByToken($this->token);
        if (!$token) {
            return redirect()->to('unauthenticated');
        }

        return view('livewire.reset-password');
    }
}
