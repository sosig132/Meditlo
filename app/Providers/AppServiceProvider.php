<?php

namespace App\Providers;
use Illuminate\Support\Facades\Blade;
use Doctrine\DBAL\Types\Type;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
         // Register a custom Blade directive
        Blade::directive('admin', function () {
            return "<?php if(auth()->check() && auth()->user()->isAdmin()): ?>";
        });

        Blade::directive('endadmin', function () {
            return "<?php endif; ?>";
        });

        Blade::if('tutor', function () {
            return auth()->check() && auth()->user()->isTutor();
        });
        Blade::if('student', function () {
            return auth()->check() && auth()->user()->isStudent();
        });

    }
}
