@extends('layouts.admin')
@section('title', 'Meja')
@section('page-title', 'Manajemen Meja')
@section('content')
<div class="flex justify-end mb-5">
    <a href="{{ route('admin.tables.create') }}" class="inline-flex items-center gap-2 bg-[#1B120D] text-white text-sm font-semibold px-4 py-2.5 rounded-lg hover:bg-coffee-800 transition-all">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Meja
    </a>
</div>
<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr class="text-left text-xs text-gray-500 uppercase tracking-wide">
                <th class="px-6 py-3">No. Meja</th>
                <th class="px-6 py-3">Nama</th>
                <th class="px-6 py-3">Kapasitas</th>
                <th class="px-6 py-3">Lokasi</th>
                <th class="px-6 py-3">Status</th>
                <th class="px-6 py-3 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($tables as $table)
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-6 py-4 font-bold text-gray-800">{{ $table->number }}</td>
                <td class="px-6 py-4 text-gray-600">{{ $table->name ?? '-' }}</td>
                <td class="px-6 py-4 text-gray-600">{{ $table->capacity }} orang</td>
                <td class="px-6 py-4 text-gray-500">{{ $table->location ?? '-' }}</td>
                <td class="px-6 py-4">
                    @php
                        $sc = match($table->status) {
                            'available'   => 'bg-green-100 text-green-700',
                            'occupied'    => 'bg-red-100 text-red-700',
                            'reserved'    => 'bg-yellow-100 text-yellow-700',
                            'maintenance' => 'bg-gray-100 text-gray-600',
                            default       => 'bg-gray-100 text-gray-600',
                        };
                    @endphp
                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $sc }}">{{ ucfirst($table->status) }}</span>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.tables.edit', $table) }}" class="text-xs font-semibold text-blue-600 px-3 py-1.5 border border-blue-200 rounded-lg hover:bg-blue-50 transition-all">Edit</a>
                        <form method="POST" action="{{ route('admin.tables.destroy', $table) }}" onsubmit="return confirm('Hapus meja ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs font-semibold text-red-600 px-3 py-1.5 border border-red-200 rounded-lg hover:bg-red-50 transition-all">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
                <tr><td colspan="6" class="px-6 py-16 text-center text-gray-400 text-sm">Belum ada meja terdaftar.</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($tables->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">{{ $tables->links() }}</div>
    @endif
</div>
@endsection
