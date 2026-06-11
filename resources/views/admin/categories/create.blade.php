@extends('layouts.admin')
@section('title', 'Tambah Kategori')
@section('page-title', 'Tambah Kategori Baru')
@section('content')
<div class="max-w-xl">
    <div class="mb-4">
        <a href="{{ route('admin.categories.index') }}" class="text-sm text-gray-500 hover:text-gray-700 flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali
        </a>
    </div>
    <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data"
          class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        @csrf
        <div class="p-6 border-b border-gray-100"><h2 class="font-semibold text-gray-800">Informasi Kategori</h2></div>
        <div class="p-6 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Kategori <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-gold-400/30 focus:border-gold-400 @error('name') border-red-400 @enderror">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Deskripsi</label>
                <textarea name="description" rows="3" class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-gold-400/30 focus:border-gold-400 resize-none">{{ old('description') }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Urutan Tampil</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0"
                       class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-gold-400/30 focus:border-gold-400">
            </div>
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="is_active" value="1" checked class="w-4 h-4 accent-[#1B120D] rounded">
                <span class="text-sm font-medium text-gray-700">Aktifkan kategori ini</span>
            </label>
        </div>
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
            <a href="{{ route('admin.categories.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 border border-gray-200 rounded-lg hover:bg-gray-100 transition-all">Batal</a>
            <button type="submit" class="px-5 py-2 text-sm font-semibold bg-[#1B120D] text-white rounded-lg hover:bg-coffee-800 transition-all">Simpan Kategori</button>
        </div>
    </form>
</div>
@endsection
