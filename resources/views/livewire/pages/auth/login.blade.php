<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login">
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="form.email" id="email" class="block mt-1 w-full" type="email" name="email" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <div class="relative" x-data="{ show: false }">
                <x-text-input wire:model="form.password" id="password" class="block mt-1 w-full pr-10"
                                ::type="show ? 'text' : 'password'"
                                name="password"
                                required autocomplete="current-password" />
                
                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-[#6F4E37] hover:text-[#1B120D] transition-colors">
                    <!-- Eye Open -->
                    <svg x-show="show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <!-- Eye Closed -->
                    <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                    </svg>
                </button>
            </div>

            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember" class="inline-flex items-center">
                <input wire:model="form.remember" id="remember" type="checkbox" class="rounded border-[#C5A880]/50 bg-[#FDF6EC] text-[#9A7D3A] shadow-sm focus:ring-[#9A7D3A]" name="remember">
                <span class="ms-2 text-sm font-medium text-[#3E2C1C]">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-8">
            @if (Route::has('password.request'))
                <a class="underline text-sm font-medium text-[#6F4E37] hover:text-[#1B120D] rounded-md focus:outline-none transition-colors" href="{{ route('password.request') }}" wire:navigate>
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button>
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>

    {{-- Google OAuth Button --}}
    <div class="mt-8 border-t border-[#C5A880]/40 pt-6">
        <div class="text-center mb-4">
            <span class="text-[11px] text-[#6F4E37] font-bold uppercase tracking-widest">Atau masuk dengan</span>
        </div>
        
        <a href="{{ route('auth.google') }}" class="w-full flex items-center justify-center gap-3 px-4 py-3.5 bg-[#FFFFFF] hover:bg-[#FDF6EC] border border-[#C5A880]/50 rounded-xl text-sm text-[#1B120D] font-bold transition-all shadow-sm hover:shadow-md">
            <svg class="w-5 h-5" viewBox="0 0 24 24">
                <path fill="#EA4335" d="M12.24 10.285V14.4h6.887c-.648 2.41-2.519 4.02-5.137 4.02-3.484 0-6.31-2.827-6.31-6.31s2.826-6.31 6.31-6.31c1.55 0 2.97.56 4.08 1.49l2.96-2.96C18.665 2.14 15.615 1 12.24 1 6.042 1 12.24 6.042 1 12.24s5.042 11.24 11.24 11.24c5.82 0 10.74-4.21 10.74-11.24 0-.7-.06-1.39-.18-1.955H12.24z"/>
            </svg>
            Google Account
        </a>
    </div>

    <div class="mt-6 text-center">
        <span class="text-sm text-[#6F4E37]">Belum punya akun?</span>
        <a href="{{ route('register') }}" class="text-sm text-[#9A7D3A] font-bold hover:underline ml-1" wire:navigate>Daftar Sekarang</a>
    </div>
</div>
