<?php
namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserProfilePhotoService
{
    /**
     * Get the authenticated user's profile photo path.
     *
     * @return string|null
     */
    public function getAuthUserPhoto()
    {
        $user = Auth::user();

        return $user?->profile?->user_photo;
    }
}
