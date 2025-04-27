<?php

namespace App\Livewire;

use App\Mail\PasswordRecoveryMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Sleep;
use Illuminate\Support\Str;
use App\Services\PasswordResetService;

class ForgotPassword extends Component
{
    use LivewireAlert;

    public $email;

    protected $password_reset_service;
    protected $user_model;

    public function mount() {
        if(Auth::check()){
            return redirect()->to('/home');
        }
        $this->password_reset_service = new PasswordResetService();
        $this->user_model = new User();
    }
    public function hydrate() {
        $this->password_reset_service = new PasswordResetService();
        $this->user_model = new User();
    }
    public function sendPasswordRecoveryEmail()
    {
        $this->validate([
            'email' => 'required|email',
        ]);

        $user = $this->user_model->findByEmail($this->email);
        if ($user) {
            $token = Str::random(60);
            $this->password_reset_service->updatePasswordResetToken($user->email, $token);

            Mail::to($this->email)->send(new PasswordRecoveryMail($user, $token));
        }
        Sleep::for(0.5)->seconds();

        $this->dispatch('closeForgotPasswordModal');

        $this->dispatch('showAlert', 'Daca adresa de email este corecta, iti vom trimite un link pentru resetarea parolei.');
    }

    public function showAlert($message){
        $this->alert('success', $message[0], [
            'position' => 'center',
            'timer' => 3000,
            'toast' => true,
        ]);
    }

    public function render()
    {
        return view('livewire.forgot-password');
    }
}
