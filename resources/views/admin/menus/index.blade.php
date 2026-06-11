@extends('layouts.admin')

@section('title', 'Manajemen Menu')
@section('page-title', 'Menu Produk')

@section('content')
{{-- Header --}}
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <p class="text-sm text-gray-500">Kelola produk/menu yang tampil di katalog pelanggan.</p>
    </div>
    <a href="{{ route('admin.menus.create') }}" class="inline-flex items-center gap-2 bg-[#1B120D] text-white text-sm font-semibold px-4 py-2.5 rounded-lg hover:bg-coffee-800 transition-all">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Menu
    </a>
</div>

{{-- Filters --}}
<form method="GET" class="bg-white rounded-xl border border-gray-200 p-4 mb-5 flex flex-col sm:flex-row gap-3">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama menu..."
           class="flex-1 text-sm border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-gold-400/30 focus:border-gold-400">
    <select name="category_id" class="text-sm border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-gold-400/30 focus:border-gold-400 bg-white">
        <option value="">Semua Kategori</option>
        @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
        @endforeach
    </select>
    <select name="status" class="text-sm border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-gold-400/30 focus:border-gold-400 bg-white">
        <option value="">Semua Status</option>
        <option value="available" {{ request('status') === 'available' ? 'selected' : '' }}>Tersedia</option>
        <option value="unavailable" {{ request('status') === 'unavailable' ? 'selected' : '' }}>Tidak Tersedia</option>
    </select>
    <button type="submit" class="bg-gray-800 text-white text-sm font-semibold px-4 py-2 rounded-lg hover:bg-gray-700 transition-all">Filter</button>
    @if(request()->anyFilled(['search','category_id','status']))
        <a href="{{ route('admin.menus.index') }}" class="text-sm text-gray-500 px-4 py-2 rounded-lg border border-gray-200 hover:bg-gray-50 transition-all text-center">Reset</a>
    @endif
</form>

{{-- Table --}}
<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr class="text-left text-xs text-gray-500 uppercase tracking-wide">
                    <th class="px-6 py-3">Menu</th>
                    <th class="px-6 py-3">Kategori</th>
                    <th class="px-6 py-3">Harga</th>
                    <th class="px-6 py-3">Stok</th>
                    <th class="px-6 py-3">Badge</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($menus as $menu)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-coffee-700 to-coffee-900 overflow-hidden flex-shrink-0">
                                @if($menu->image)
                                    <img src="{{ $menu->image_url }}" alt="{{ $menu->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-lg">☕</div>
                                @endif
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">{{ $menu->name }}</p>
                                <p class="text-xs text-gray-400 truncate max-w-[200px]">{{ Str::limit($menu->description, 50) }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="bg-gray-100 text-gray-600 text-xs font-medium px-2.5 py-1 rounded-full">{{ $menu->category->name }}</span>
                    </td>
                    <td class="px-6 py-4 font-bold text-gray-800">{{ $menu->formatted_price }}</td>
                    <td class="px-6 py-4">
                        <span class="font-semibold {{ $menu->stock <= 0 ? 'text-red-600' : ($menu->stock <= 5 ? 'text-orange-600' : 'text-gray-800') }}">
                            {{ $menu->stock }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-wrap gap-1">
                            @if($menu->is_featured)    <span class="text-[10px] bg-gold-100 text-gold-700 px-1.5 py-0.5 rounded font-semibold">Featured</span> @endif
                            @if($menu->is_new)          <span class="text-[10px] bg-green-100 text-green-700 px-1.5 py-0.5 rounded font-semibold">New</span> @endif
                            @if($menu->is_best_seller)  <span class="text-[10px] bg-orange-100 text-orange-700 px-1.5 py-0.5 rounded font-semibold">Best Seller</span> @endif
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $menu->is_available ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }}">
                            {{ $menu->is_available ? 'Tersedia' : 'Tidak Tersedia' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.menus.edit', $menu) }}"
                               class="text-xs font-semibold text-blue-600 hover:text-blue-800 px-3 py-1.5 border border-blue-200 rounded-lg hover:bg-blue-50 transition-all">
                                Edit
                            </a>
                            <form method="POST" action="{{ route('admin.menus.destroy', $menu) }}"
                                  onsubmit="return confirm('Hapus menu ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-xs font-semibold text-red-600 hover:text-red-800 px-3 py-1.5 border border-red-200 rounded-lg hover:bg-red-50 transition-all">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center text-gray-400">
                            <div class="text-4xl mb-2">☕</div>
                            <p class="text-sm font-medium">Belum ada menu.</p>
                            <a href="{{ route('admin.menus.create') }}" class="text-gold-600 hover:underline text-sm mt-1 inline-block">Tambah sekarang →</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($menus->hasPages())
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $menus->links() }}
    </div>
    @endif
</div>
@endsection
