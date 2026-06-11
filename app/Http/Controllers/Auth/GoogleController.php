<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\MembershipTier;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Spatie\Permission\Models\Role;

class GoogleController extends Controller
{
    /**
     * Redirect to Google OAuth.
     */
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle callback from Google OAuth.
     */
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->withErrors(['email' => 'Login Google gagal. Silakan coba lagi.']);
        }

        // Find or create user
        $user = User::where('google_id', $googleUser->getId())
            ->orWhere('email', $googleUser->getEmail())
            ->first();

        if ($user) {
            // Update Google ID if logging in for the first time via Google
            $user->update([
                'google_id' => $googleUser->getId(),
                'avatar' => $user->avatar ?? $googleUser->getAvatar(),
                'email_verified_at' => $user->email_verified_at ?? now(),
            ]);
        } else {
            // Create new user from Google profile
            $bronzeTier = MembershipTier::where('slug', 'bronze')->first();

            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'email_verified_at' => now(),
                'membership_tier_id' => $bronzeTier?->id,
                'loyalty_points' => 0,
            ]);

            Role::findOrCreate('customer', 'web');
            $user->assignRole('customer');
        }

        abort_if(! $user->is_active, 403, 'Akun kamu telah dinonaktifkan.');

        Auth::login($user, remember: true);

        return redirect()->intended(route('home'));
    }
}
