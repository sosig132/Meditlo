<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\UserProfilePhotoService;

class UserProfilePhotoServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(UserProfilePhotoService::class, function ($app) {
            return new UserProfilePhotoService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
