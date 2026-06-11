@extends('layouts.admin')
@section('title', 'Pengguna')
@section('page-title', 'Manajemen Pengguna')
@section('content')

<div class="flex justify-end mb-5">
    <a href="{{ route('admin.users.create') }}" class="inline-flex items-center gap-2 bg-[#1B120D] text-white text-sm font-semibold px-4 py-2.5 rounded-lg hover:bg-coffee-800 transition-all">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
        Tambah Pengguna
    </a>
</div>

<form method="GET" class="bg-white rounded-xl border border-gray-200 p-4 mb-5 flex flex-col sm:flex-row gap-3">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / email..."
           class="flex-1 text-sm border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-gold-400/30 focus:border-gold-400">
    <select name="role" class="text-sm border border-gray-200 rounded-lg px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-gold-400/30 focus:border-gold-400">
        <option value="">Semua Role</option>
        <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
        <option value="cashier" {{ request('role') === 'cashier' ? 'selected' : '' }}>Kasir</option>
        <option value="customer" {{ request('role') === 'customer' ? 'selected' : '' }}>Pelanggan</option>
    </select>
    <button type="submit" class="bg-gray-800 text-white text-sm font-semibold px-4 py-2 rounded-lg hover:bg-gray-700 transition-all">Filter</button>
    @if(request()->anyFilled(['search','role']))
        <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-500 px-4 py-2 rounded-lg border border-gray-200 hover:bg-gray-50 transition-all text-center">Reset</a>
    @endif
</form>

<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr class="text-left text-xs text-gray-500 uppercase tracking-wide">
                    <th class="px-6 py-3">Pengguna</th>
                    <th class="px-6 py-3">Email</th>
                    <th class="px-6 py-3">Role</th>
                    <th class="px-6 py-3">Bergabung</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($users as $user)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-gold-400 to-gold-600 flex items-center justify-center text-coffee-950 font-bold text-xs flex-shrink-0">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <span class="font-medium text-gray-800">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-gray-500">{{ $user->email }}</td>
                    <td class="px-6 py-4">
                        @foreach($user->roles as $role)
                            @php
                                $rc = match($role->name) {
                                    'admin'    => 'bg-red-100 text-red-700',
                                    'cashier'  => 'bg-blue-100 text-blue-700',
                                    default    => 'bg-gray-100 text-gray-600',
                                };
                            @endphp
                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $rc }}">{{ ucfirst($role->name) }}</span>
                        @endforeach
                    </td>
                    <td class="px-6 py-4 text-gray-400 text-xs">{{ $user->created_at->format('d M Y') }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.users.edit', $user) }}" class="text-xs font-semibold text-blue-600 px-3 py-1.5 border border-blue-200 rounded-lg hover:bg-blue-50 transition-all">Edit</a>
                            @if($user->id !== auth()->id())
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Hapus pengguna ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-xs font-semibold text-red-600 px-3 py-1.5 border border-red-200 rounded-lg hover:bg-red-50 transition-all">Hapus</button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                    <tr><td colspan="5" class="px-6 py-16 text-center text-gray-400 text-sm">Belum ada pengguna.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">{{ $users->links() }}</div>
    @endif
</div>
@endsection
