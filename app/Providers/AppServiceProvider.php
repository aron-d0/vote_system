<?php

namespace App\Providers;

use App\Models\Election;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
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
        if ((bool) env('APP_FORCE_HTTPS', app()->environment('production'))) {
            URL::forceScheme('https');
        }

        Gate::define('isAdmin', fn (User $user): bool => (bool) $user->is_admin);

        Gate::define('view', fn (User $user, Election $election): bool => (bool) $user->is_admin);
    }
}
