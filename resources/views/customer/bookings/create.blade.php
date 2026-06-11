@extends('layouts.customer')

@section('title', 'Buat Reservasi Meja — Zero Nine Coffee Shop')

@section('content')
<div class="min-h-screen pt-28 pb-20" style="background:#FDF6EC;">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <a href="{{ route('customer.bookings.index') }}" class="inline-flex items-center gap-2 text-amber-800 hover:text-amber-950 mb-8 transition-colors text-sm font-medium">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar Reservasi
        </a>

        <h1 class="font-display text-3xl font-bold text-stone-900 mb-8">
            Reservasi <span class="text-amber-800">Meja & VIP Lounge</span>
        </h1>

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl mb-6 text-sm">
                {{ session('error') }}
            </div>
        @endif

        {{-- Slots checker form --}}
        <div style="background:rgba(255,255,255,0.7); border:1px solid rgba(197,168,128,0.3); border-radius:1rem; padding:1.5rem; margin-bottom:2rem;">
            <h3 class="font-display text-lg font-bold mb-4 pb-3" style="color:#1B120D; border-bottom:1px solid rgba(197,168,128,0.35);">🗓️ Pilih Jadwal & Kapasitas</h3>
            <form method="GET" action="{{ route('customer.bookings.create') }}" class="grid grid-cols-1 sm:grid-cols-4 gap-4 items-end">
                <div>
                    <label class="block text-xs font-semibold text-stone-700 mb-1.5 uppercase tracking-wide">Pilih Tanggal</label>
                    <input type="date" name="booking_date" value="{{ $date }}" min="{{ Carbon\Carbon::today()->toDateString() }}"
                        class="w-full px-3 py-2.5 rounded-xl border border-stone-400 bg-white text-stone-800 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-stone-700 mb-1.5 uppercase tracking-wide">Jam Mulai</label>
                    <select name="start_time" class="w-full px-3 py-2.5 rounded-xl border border-stone-400 bg-white text-stone-800 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition">
                        @for($hour = 10; $hour <= 22; $hour++)
                            <option value="{{ sprintf('%02d:00', $hour) }}" {{ $startTime == sprintf('%02d:00', $hour) ? 'selected' : '' }}>{{ sprintf('%02d:00', $hour) }}</option>
                            <option value="{{ sprintf('%02d:30', $hour) }}" {{ $startTime == sprintf('%02d:30', $hour) ? 'selected' : '' }}>{{ sprintf('%02d:30', $hour) }}</option>
                        @endfor
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-stone-700 mb-1.5 uppercase tracking-wide">Jam Selesai</label>
                    <select name="end_time" class="w-full px-3 py-2.5 rounded-xl border border-stone-400 bg-white text-stone-800 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition">
                        @for($hour = 10; $hour <= 22; $hour++)
                            <option value="{{ sprintf('%02d:00', $hour) }}" {{ $endTime == sprintf('%02d:00', $hour) ? 'selected' : '' }}>{{ sprintf('%02d:00', $hour) }}</option>
                            <option value="{{ sprintf('%02d:30', $hour) }}" {{ $endTime == sprintf('%02d:30', $hour) ? 'selected' : '' }}>{{ sprintf('%02d:30', $hour) }}</option>
                        @endfor
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-stone-700 mb-1.5 uppercase tracking-wide">Jumlah Tamu</label>
                    <select name="guest_count" class="w-full px-3 py-2.5 rounded-xl border border-stone-400 bg-white text-stone-800 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition">
                        @for($i = 1; $i <= 10; $i++)
                            <option value="{{ $i }}" {{ $guestCount == $i ? 'selected' : '' }}>{{ $i }} Orang</option>
                        @endfor
                    </select>
                </div>
                <div class="sm:col-span-4 flex justify-end">
                    <button type="submit" class="inline-flex items-center gap-2 bg-amber-700 hover:bg-amber-800 text-white font-semibold py-2.5 px-6 rounded-xl text-sm transition-colors shadow-sm">
                        🔍 Periksa Ketersediaan Meja
                    </button>
                </div>
            </form>
        </div>

        {{-- Booking submission form --}}
        <form method="POST" action="{{ route('customer.bookings.store') }}" x-data="{ selectedTable: '' }" class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            @csrf

            <input type="hidden" name="booking_date" value="{{ $date }}">
            <input type="hidden" name="start_time" value="{{ $startTime }}">
            <input type="hidden" name="end_time" value="{{ $endTime }}">
            <input type="hidden" name="guest_count" value="{{ $guestCount }}">
            <input type="hidden" name="table_id" :value="selectedTable" required>

            {{-- Table Selector Column --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Available Tables Grid --}}
                <div style="background:rgba(255,255,255,0.7); border:1px solid rgba(197,168,128,0.3); border-radius:1rem; padding:1.5rem;">
                    <h3 class="font-display text-lg font-bold mb-4 pb-3" style="color:#1B120D; border-bottom:1px solid rgba(197,168,128,0.35);">📍 Pilih Meja</h3>

                    @if($availableTables->isEmpty())
                        <div class="text-center py-10 text-amber-800 font-semibold text-sm bg-amber-50 rounded-xl border border-amber-200">
                            ⚠️ Maaf, tidak ada meja yang tersedia pada jadwal tersebut. Silakan pilih tanggal atau waktu lainnya.
                        </div>
                    @else
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                            @foreach($availableTables as $table)
                                <div @click="selectedTable = '{{ $table->id }}'"
                                     class="p-4 rounded-xl border-2 cursor-pointer transition-all flex flex-col justify-between items-center text-center group"
                                     :class="selectedTable == '{{ $table->id }}'
                                         ? 'border-amber-600 bg-amber-100 shadow-md'
                                         : 'border-stone-300 bg-white hover:border-amber-400 hover:bg-amber-50'">

                                    <span class="text-3xl mb-2">🪑</span>
                                    <h4 class="font-bold text-stone-800 text-sm"
                                        :class="selectedTable == '{{ $table->id }}' ? 'text-amber-800' : ''">
                                        Meja {{ $table->number }}
                                    </h4>
                                    <p class="text-xs text-stone-600 mt-1">Kapasitas: {{ $table->capacity }} Tamu</p>
                                    <span class="text-[10px] font-bold uppercase tracking-wider mt-2"
                                          :class="selectedTable == '{{ $table->id }}' ? 'text-amber-700' : 'text-stone-400'">
                                        {{ $table->name }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Contact Information Form --}}
                <div style="background:rgba(255,255,255,0.7); border:1px solid rgba(197,168,128,0.3); border-radius:1rem; padding:1.5rem;">
                    <h3 class="font-display text-lg font-bold mb-4 pb-3" style="color:#1B120D; border-bottom:1px solid rgba(197,168,128,0.35);">👤 Informasi Kontak</h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-xs font-semibold text-stone-700 mb-1.5 uppercase tracking-wide">Nama Kontak</label>
                            <input type="text" name="contact_name" value="{{ old('contact_name', auth()->user()->name) }}" required
                                class="w-full px-3 py-2.5 rounded-xl border border-stone-400 bg-white text-stone-800 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition">
                            @error('contact_name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-stone-700 mb-1.5 uppercase tracking-wide">Nomor Telepon</label>
                            <input type="text" name="contact_phone" value="{{ old('contact_phone', auth()->user()->phone) }}" placeholder="Contoh: 08123456789" required
                                class="w-full px-3 py-2.5 rounded-xl border border-stone-400 bg-white text-stone-800 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition">
                            @error('contact_phone') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-stone-700 mb-1.5 uppercase tracking-wide">Acara Khusus (Opsional)</label>
                            <select name="occasion" class="w-full px-3 py-2.5 rounded-xl border border-stone-400 bg-white text-stone-800 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition">
                                <option value="">Tidak ada acara khusus</option>
                                <option value="Ulang Tahun">🎂 Perayaan Ulang Tahun</option>
                                <option value="Anniversary">💖 Anniversary / Kencan</option>
                                <option value="Bisnis">💼 Pertemuan Bisnis</option>
                                <option value="Lainnya">☕ Lainnya</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-stone-700 mb-1.5 uppercase tracking-wide">Permintaan Khusus (Opsional)</label>
                            <textarea name="special_requests" rows="3" placeholder="Contoh: Kursi bayi, dekorasi kecil, dll."
                                class="w-full px-3 py-2.5 rounded-xl border border-stone-400 bg-white text-stone-800 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition resize-none"></textarea>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Checkout Side Card --}}
            <div class="space-y-5 sticky top-28" style="background:rgba(255,255,255,0.7); border:1px solid rgba(197,168,128,0.3); border-radius:1rem; padding:1.25rem;">
                <h3 class="text-xs font-bold uppercase tracking-widest pb-3" style="color:#6F4E37; border-bottom:1px solid rgba(197,168,128,0.35);">Rincian Reservasi</h3>

                <div class="space-y-3 text-xs text-stone-600">
                    <div class="flex justify-between">
                        <span>Tanggal</span>
                        <span class="font-bold text-stone-800">{{ Carbon\Carbon::parse($date)->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Rentang Waktu</span>
                        <span class="font-bold text-stone-800">{{ $startTime }} – {{ $endTime }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Jumlah Tamu</span>
                        <span class="font-bold text-stone-800">{{ $guestCount }} Orang</span>
                    </div>

                    <div class="border-t border-stone-100 pt-3" x-show="selectedTable">
                        <span class="text-amber-700 font-semibold block text-center uppercase tracking-wide text-[11px]">✓ Meja Terpilih</span>
                    </div>
                </div>

                <button type="submit"
                    class="w-full flex items-center justify-center gap-2 bg-amber-700 hover:bg-amber-800 disabled:bg-stone-400 disabled:cursor-not-allowed text-white font-bold py-3.5 rounded-xl text-sm transition-colors shadow-sm"
                    :disabled="!selectedTable">
                    📅 Konfirmasi Reservasi
                </button>
                <p class="text-[10px] text-stone-500 text-center leading-relaxed">Reservasi Anda memerlukan waktu verifikasi persetujuan oleh Admin kami.</p>
            </div>

        </form>

    </div>
</div>
@endsection