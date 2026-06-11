@extends('layouts.admin')

@section('title', 'Edit Menu')
@section('page-title', 'Edit Menu: ' . $menu->name)

@section('content')
<div class="max-w-3xl">
    <div class="mb-4">
        <a href="{{ route('admin.menus.index') }}" class="text-sm text-gray-500 hover:text-gray-700 flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Daftar Menu
        </a>
    </div>

    <form method="POST" action="{{ route('admin.menus.update', $menu) }}" enctype="multipart/form-data"
          class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        @csrf @method('PUT')

        <div class="p-6 border-b border-gray-100">
            <h2 class="font-semibold text-gray-800">Edit Produk</h2>
        </div>

        <div class="p-6 space-y-5">
            {{-- Image Preview --}}
            @if($menu->image)
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Foto Saat Ini</label>
                <img src="{{ $menu->image_url }}" alt="{{ $menu->name }}" class="w-24 h-24 object-cover rounded-xl border border-gray-200">
            </div>
            @endif

            {{-- Name & Category --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Menu <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $menu->name) }}" required
                           class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-gold-400/30 focus:border-gold-400 @error('name') border-red-400 @enderror">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Kategori <span class="text-red-500">*</span></label>
                    <select name="category_id" required class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-gold-400/30 focus:border-gold-400 bg-white">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $menu->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Description --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Deskripsi</label>
                <textarea name="description" rows="3"
                          class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-gold-400/30 focus:border-gold-400 resize-none">{{ old('description', $menu->description) }}</textarea>
            </div>

            {{-- Price, Stock, Prep Time --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Harga (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" name="price" value="{{ old('price', $menu->price) }}" min="0" required
                           class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-gold-400/30 focus:border-gold-400">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Stok <span class="text-red-500">*</span></label>
                    <input type="number" name="stock" value="{{ old('stock', $menu->stock) }}" min="0" required
                           class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-gold-400/30 focus:border-gold-400">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Waktu Saji (menit)</label>
                    <input type="number" name="preparation_time" value="{{ old('preparation_time', $menu->preparation_time) }}" min="0"
                           class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-gold-400/30 focus:border-gold-400">
                </div>
            </div>

            {{-- New Image --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Ganti Foto (opsional)</label>
                <input type="file" name="image" accept="image/*"
                       class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200">
            </div>

            {{-- Badges --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-3">Opsi & Badge</label>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    <label class="flex items-center gap-2 cursor-pointer p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-all">
                        <input type="checkbox" name="is_available" value="1" {{ old('is_available', $menu->is_available) ? 'checked' : '' }}
                               class="w-4 h-4 accent-[#1B120D] rounded">
                        <span class="text-sm font-medium text-gray-700">Tersedia</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-all">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $menu->is_featured) ? 'checked' : '' }}
                               class="w-4 h-4 accent-[#1B120D] rounded">
                        <span class="text-sm font-medium text-gray-700">Featured</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-all">
                        <input type="checkbox" name="is_new" value="1" {{ old('is_new', $menu->is_new) ? 'checked' : '' }}
                               class="w-4 h-4 accent-[#1B120D] rounded">
                        <span class="text-sm font-medium text-gray-700">New</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-all">
                        <input type="checkbox" name="is_best_seller" value="1" {{ old('is_best_seller', $menu->is_best_seller) ? 'checked' : '' }}
                               class="w-4 h-4 accent-[#1B120D] rounded">
                        <span class="text-sm font-medium text-gray-700">Best Seller</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
            <a href="{{ route('admin.menus.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 border border-gray-200 rounded-lg hover:bg-gray-100 transition-all">Batal</a>
            <button type="submit" class="px-5 py-2 text-sm font-semibold bg-[#1B120D] text-white rounded-lg hover:bg-coffee-800 transition-all">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
