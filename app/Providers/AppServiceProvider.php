<?php

namespace App\Providers;

use App\Models\Pelanggan;
use App\Policies\PelangganPolicy;
use Illuminate\Support\Facades\Gate;
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
        Gate::policy(Pelanggan::class, PelangganPolicy::class);

        Gate::define('lihat-ringkasan', function ($user) {
            return in_array($user->role, ['admin', 'staff']);
        });
    }
}
