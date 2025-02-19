<?php

use App\Services\UserProfilePhotoService;

if (!function_exists('authUserPhoto')) {
    /**
     * Get the authenticated user's photo path.
     *
     * @return string|null
     */
    function authUserPhoto()
    {
        return app(UserProfilePhotoService::class)->getAuthUserPhoto();
    }
}
