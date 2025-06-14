<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Models\User;

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
        // Binding parameter 'data_user' ke model User
        Route::bind('data_user', function ($value) {
            return User::findOrFail($value);
        });
    }

    protected function mapApiRoutes(): void
    {
        Route::middleware('api')
            ->prefix('api') // Ini yang menambahkan awalan /api/
            ->group(base_path('routes/api.php')); // Ini yang memuat file api.php
    }
}
