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

    public function mount() {
        if(Auth::check()){
            return redirect()->to('/home');
        }
    }
    public function sendPasswordRecoveryEmail()
    {
        $this->validate([
            'email' => 'required|email',
        ]);

        // Check if email exists in the database
        $user_model = new User();
        $password_reset_service = new PasswordResetService();
        $user = $user_model->getUserByEmail($this->email);
        if ($user) {
            $token = Str::random(60);
            $password_reset_service->updatePasswordResetToken($user->email, $token);

            Mail::to($this->email)->send(new PasswordRecoveryMail($user, $token));
        }
        Sleep::for(0.5)->seconds();

        $this->dispatch('closeForgotPasswordModal');

        // $this->showAlert('Daca adresa de email este corecta, iti vom trimite un link pentru resetarea parolei.');
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
