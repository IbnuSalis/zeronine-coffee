@extends('layouts.admin')
@section('title', 'Edit Pengguna')
@section('page-title', 'Edit Pengguna: ' . $user->name)
@section('content')
<div class="max-w-xl">
    <div class="mb-4">
        <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-500 hover:text-gray-700 flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali
        </a>
    </div>
    <form method="POST" action="{{ route('admin.users.update', $user) }}" class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        @csrf @method('PUT')
        <div class="p-6 border-b border-gray-100"><h2 class="font-semibold text-gray-800">Edit Pengguna</h2></div>
        <div class="p-6 space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-gold-400/30 focus:border-gold-400">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">No. Telepon</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-gold-400/30 focus:border-gold-400">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-gold-400/30 focus:border-gold-400 @error('email') border-red-400 @enderror">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Password Baru <span class="text-gray-400 font-normal">(kosongkan jika tidak ingin mengubah)</span></label>
                <input type="password" name="password" class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-gold-400/30 focus:border-gold-400">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Role <span class="text-red-500">*</span></label>
                <select name="role" required class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-gold-400/30 focus:border-gold-400 bg-white">
                    @php $currentRole = $user->roles->first()?->name ?? 'customer'; @endphp
                    <option value="customer" {{ $currentRole === 'customer' ? 'selected' : '' }}>Pelanggan</option>
                    <option value="cashier"  {{ $currentRole === 'cashier' ? 'selected' : '' }}>Kasir</option>
                    <option value="admin"    {{ $currentRole === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>
        </div>
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 border border-gray-200 rounded-lg hover:bg-gray-100 transition-all">Batal</a>
            <button type="submit" class="px-5 py-2 text-sm font-semibold bg-[#1B120D] text-white rounded-lg hover:bg-coffee-800 transition-all">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
