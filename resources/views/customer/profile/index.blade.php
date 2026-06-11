@extends('layouts.customer')

@section('title', 'Profil Saya — Zero Nine Coffee Shop')

@section('content')
<div class="min-h-screen pt-28 pb-20 bg-stone-200">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <h1 class="font-display text-3xl font-bold text-stone-900 mb-8">Profil <span class="text-amber-800">Saya</span></h1>

        @if(session('success'))
            <div class="flex items-start gap-3 bg-emerald-50 border border-emerald-300 text-emerald-800 p-4 rounded-xl mb-6 text-sm shadow-sm">
                <span class="text-xl leading-none mt-0.5">✅</span>
                <div>
                    <p class="font-semibold">Berhasil!</p>
                    <p class="text-emerald-700 mt-0.5">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-start">

            {{-- Member Card --}}
            <div class="bg-stone-800 rounded-2xl p-6 text-center relative overflow-hidden shadow-md">
                <div class="absolute -top-8 -right-8 w-28 h-28 bg-amber-600/20 rounded-full blur-2xl"></div>
                <div class="absolute -bottom-8 -left-8 w-24 h-24 bg-amber-800/20 rounded-full blur-2xl"></div>

                <div class="relative z-10">
                    <div class="w-20 h-20 rounded-full mx-auto bg-gradient-to-br from-amber-500 to-amber-700 p-0.5 mb-4 shadow-xl">
                        <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-full h-full object-cover rounded-full">
                    </div>

                    <h3 class="font-display font-bold text-lg text-stone-50 leading-tight">{{ $user->name }}</h3>
                    <span class="text-xs text-stone-400 block mt-1">{{ $user->email }}</span>

                    @if($user->membershipTier)
                        <span class="inline-flex items-center gap-1.5 mt-4 px-3 py-1.5 rounded-lg bg-amber-600/20 border border-amber-500/30 text-amber-400 text-xs font-bold">
                            ⭐ {{ $user->membershipTier->name }}
                        </span>
                        <div class="mt-3 bg-stone-700/50 rounded-xl px-4 py-3">
                            <p class="text-xs text-stone-400 uppercase tracking-wide font-semibold mb-1">Loyalty Points</p>
                            <p class="text-2xl font-display font-bold text-amber-400">{{ number_format($user->loyalty_points) }}</p>
                            <p class="text-xs text-stone-500 mt-0.5">Pts</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Forms Column --}}
            <div class="md:col-span-2 space-y-6">

                {{-- Personal Information Form --}}
                <div class="bg-stone-100 border border-stone-300 rounded-2xl shadow-sm p-6">
                    <h3 class="font-display text-base font-bold text-stone-800 border-b border-stone-300 pb-3 mb-5">👤 Informasi Pribadi</h3>
                    <form method="POST" action="{{ route('customer.profile.update') }}" class="space-y-4">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label class="block text-xs font-semibold text-stone-600 uppercase tracking-wide mb-1.5">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                class="w-full px-3 py-2.5 rounded-xl border border-stone-400 bg-white text-stone-800 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition">
                            @error('name') <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-stone-600 uppercase tracking-wide mb-1.5">Nomor Telepon</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Contoh: 08123456789"
                                class="w-full px-3 py-2.5 rounded-xl border border-stone-400 bg-white text-stone-800 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition">
                            @error('phone') <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-stone-600 uppercase tracking-wide mb-1.5">Alamat Email (Akun)</label>
                            <input type="email" value="{{ $user->email }}" disabled
                                class="w-full px-3 py-2.5 rounded-xl border border-stone-300 bg-stone-200 text-stone-500 text-sm cursor-not-allowed">
                            <span class="text-[11px] text-stone-500 mt-1.5 block">Email tidak dapat diubah untuk keamanan akun.</span>
                        </div>

                        <button type="submit" class="inline-flex items-center gap-2 bg-amber-700 hover:bg-amber-800 text-white font-semibold py-2.5 px-5 rounded-xl text-sm transition-colors shadow-sm">
                            Simpan Perubahan
                        </button>
                    </form>
                </div>

                {{-- Change Password Form --}}
                <div class="bg-stone-100 border border-stone-300 rounded-2xl shadow-sm p-6">
                    <h3 class="font-display text-base font-bold text-stone-800 border-b border-stone-300 pb-3 mb-5">🔑 Ganti Kata Sandi</h3>
                    <form method="POST" action="{{ route('customer.profile.password') }}" class="space-y-4">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label class="block text-xs font-semibold text-stone-600 uppercase tracking-wide mb-1.5">Kata Sandi Saat Ini</label>
                            <input type="password" name="current_password" required
                                class="w-full px-3 py-2.5 rounded-xl border border-stone-400 bg-white text-stone-800 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition">
                            @error('current_password', 'updatePassword') <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-stone-600 uppercase tracking-wide mb-1.5">Kata Sandi Baru</label>
                            <input type="password" name="password" required
                                class="w-full px-3 py-2.5 rounded-xl border border-stone-400 bg-white text-stone-800 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition">
                            @error('password', 'updatePassword') <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-stone-600 uppercase tracking-wide mb-1.5">Konfirmasi Kata Sandi Baru</label>
                            <input type="password" name="password_confirmation" required
                                class="w-full px-3 py-2.5 rounded-xl border border-stone-400 bg-white text-stone-800 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition">
                        </div>

                        <button type="submit" class="inline-flex items-center gap-2 bg-amber-700 hover:bg-amber-800 text-white font-semibold py-2.5 px-5 rounded-xl text-sm transition-colors shadow-sm">
                            Perbarui Kata Sandi
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection