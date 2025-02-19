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

        if ($user) {
            $profile = DB::table('user_profiles')->where('user_id', $user->id)->first();
            return $profile ? $profile->user_photo : null;
        }

        return null;
    }
}
