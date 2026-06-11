@extends('layouts.admin')
@section('title', 'Promo')
@section('page-title', 'Manajemen Promo')
@section('content')
<div class="flex justify-end mb-5">
    <a href="{{ route('admin.promos.create') }}" class="inline-flex items-center gap-2 bg-[#1B120D] text-white text-sm font-semibold px-4 py-2.5 rounded-lg hover:bg-coffee-800 transition-all">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Promo
    </a>
</div>
<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr class="text-left text-xs text-gray-500 uppercase tracking-wide">
                    <th class="px-6 py-3">Kode</th>
                    <th class="px-6 py-3">Nama</th>
                    <th class="px-6 py-3">Tipe</th>
                    <th class="px-6 py-3">Nilai</th>
                    <th class="px-6 py-3">Penggunaan</th>
                    <th class="px-6 py-3">Berlaku</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($promos as $promo)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 font-mono font-bold text-gray-800">{{ $promo->code }}</td>
                    <td class="px-6 py-4 font-medium text-gray-700">{{ $promo->name }}</td>
                    <td class="px-6 py-4">
                        <span class="text-xs font-semibold {{ $promo->type === 'percentage' ? 'text-purple-600' : 'text-blue-600' }}">
                            {{ $promo->type === 'percentage' ? 'Persentase' : 'Fixed' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 font-bold text-gray-800">{{ $promo->formatted_value }}</td>
                    <td class="px-6 py-4 text-gray-500 text-xs">{{ $promo->used_count }} / {{ $promo->usage_limit ?? '∞' }}</td>
                    <td class="px-6 py-4 text-gray-400 text-xs">
                        {{ $promo->start_date?->format('d/m') ?? '—' }} — {{ $promo->end_date?->format('d/m') ?? '—' }}
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $promo->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                            {{ $promo->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.promos.edit', $promo) }}" class="text-xs font-semibold text-blue-600 px-3 py-1.5 border border-blue-200 rounded-lg hover:bg-blue-50 transition-all">Edit</a>
                            <form method="POST" action="{{ route('admin.promos.destroy', $promo) }}" onsubmit="return confirm('Hapus promo ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-xs font-semibold text-red-600 px-3 py-1.5 border border-red-200 rounded-lg hover:bg-red-50 transition-all">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                    <tr><td colspan="8" class="px-6 py-16 text-center text-gray-400 text-sm">Belum ada promo.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($promos->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">{{ $promos->links() }}</div>
    @endif
</div>
@endsection
