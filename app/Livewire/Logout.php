<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;


class Logout extends Component
{
    public function testLogout()
    {
        \Log::info('Test logout method called');
    }

    public function logout(Request $request)
        {
            Auth::logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return redirect()->to('/');
        }

}
