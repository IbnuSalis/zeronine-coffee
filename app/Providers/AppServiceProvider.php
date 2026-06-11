<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind service classes for dependency injection
        $this->app->singleton(\App\Services\CartService::class);
        $this->app->singleton(\App\Services\LoyaltyService::class);
        $this->app->singleton(\App\Services\PaymentService::class);
        $this->app->singleton(\App\Services\BookingService::class);
        $this->app->singleton(\App\Services\OrderService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Super Admin bypasses all permission checks
        Gate::before(function (User $user, string $ability) {
            return $user->hasRole('super_admin') ? true : null;
        });

        // Customize the password reset notification URL
        ResetPassword::createUrlUsing(function (User $user, string $token) {
            return url(route('password.reset', [
                'token' => $token,
                'email' => $user->getEmailForPasswordReset(),
            ], false));
        });
    }
}
