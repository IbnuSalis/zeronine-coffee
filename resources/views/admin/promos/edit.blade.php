@extends('layouts.admin')
@section('title', 'Edit Promo')
@section('page-title', 'Edit Promo: ' . $promo->code)
@section('content')
<div class="max-w-2xl">
    <div class="mb-4">
        <a href="{{ route('admin.promos.index') }}" class="text-sm text-gray-500 hover:text-gray-700 flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali
        </a>
    </div>
    <form method="POST" action="{{ route('admin.promos.update', $promo) }}" class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        @csrf @method('PUT')
        <div class="p-6 border-b border-gray-100"><h2 class="font-semibold text-gray-800">Edit Promo</h2></div>
        <div class="p-6 space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Kode Promo <span class="text-red-500">*</span></label>
                    <input type="text" name="code" value="{{ old('code', $promo->code) }}" required class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-gold-400/30 focus:border-gold-400 uppercase @error('code') border-red-400 @enderror">
                    @error('code') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Promo <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $promo->name) }}" required class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-gold-400/30 focus:border-gold-400">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Deskripsi</label>
                <textarea name="description" rows="2" class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-gold-400/30 focus:border-gold-400 resize-none">{{ old('description', $promo->description) }}</textarea>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Tipe Diskon</label>
                    <select name="type" class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2.5 bg-white focus:outline-none focus:ring-2 focus:ring-gold-400/30 focus:border-gold-400">
                        <option value="percentage" {{ old('type', $promo->type) === 'percentage' ? 'selected' : '' }}>Persentase (%)</option>
                        <option value="fixed" {{ old('type', $promo->type) === 'fixed' ? 'selected' : '' }}>Nominal (Rp)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nilai Diskon</label>
                    <input type="number" name="value" value="{{ old('value', $promo->value) }}" required min="0" step="0.01" class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-gold-400/30 focus:border-gold-400">
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Min. Belanja (Rp)</label>
                    <input type="number" name="min_spend" value="{{ old('min_spend', $promo->min_spend) }}" min="0" class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-gold-400/30 focus:border-gold-400">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Maks. Diskon</label>
                    <input type="number" name="max_discount" value="{{ old('max_discount', $promo->max_discount) }}" min="0" class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-gold-400/30 focus:border-gold-400">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Batas Penggunaan</label>
                    <input type="number" name="usage_limit" value="{{ old('usage_limit', $promo->usage_limit) }}" min="1" class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-gold-400/30 focus:border-gold-400">
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal Mulai</label>
                    <input type="date" name="start_date" value="{{ old('start_date', $promo->start_date?->format('Y-m-d')) }}" class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-gold-400/30 focus:border-gold-400">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal Berakhir</label>
                    <input type="date" name="end_date" value="{{ old('end_date', $promo->end_date?->format('Y-m-d')) }}" class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-gold-400/30 focus:border-gold-400">
                </div>
            </div>
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $promo->is_active) ? 'checked' : '' }} class="w-4 h-4 accent-[#1B120D]">
                <span class="text-sm font-medium text-gray-700">Aktifkan promo ini</span>
            </label>
        </div>
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
            <a href="{{ route('admin.promos.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 border border-gray-200 rounded-lg hover:bg-gray-100 transition-all">Batal</a>
            <button type="submit" class="px-5 py-2 text-sm font-semibold bg-[#1B120D] text-white rounded-lg hover:bg-coffee-800 transition-all">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
