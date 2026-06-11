@extends('layouts.admin')
@section('title', 'Ulasan')
@section('page-title', 'Manajemen Ulasan')
@section('content')
<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr class="text-left text-xs text-gray-500 uppercase tracking-wide">
                    <th class="px-6 py-3">Pelanggan</th>
                    <th class="px-6 py-3">Menu</th>
                    <th class="px-6 py-3">Rating</th>
                    <th class="px-6 py-3">Komentar</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($reviews as $review)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 font-medium text-gray-800">{{ $review->user?->name ?? 'Guest' }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $review->menu?->name ?? '-' }}</td>
                    <td class="px-6 py-4">
                        <span class="text-gold-500 font-bold">{{ $review->rating }}★</span>
                    </td>
                    <td class="px-6 py-4 text-gray-500 max-w-xs truncate">{{ $review->comment ?? '-' }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $review->is_approved ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ $review->is_approved ? 'Disetujui' : 'Menunggu' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-end gap-2">
                            <form method="POST" action="{{ route('admin.reviews.approve', $review) }}">
                                @csrf @method('PATCH')
                                <button type="submit" class="text-xs font-semibold text-blue-600 px-3 py-1.5 border border-blue-200 rounded-lg hover:bg-blue-50 transition-all">
                                    {{ $review->is_approved ? 'Cabut' : 'Setujui' }}
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}" onsubmit="return confirm('Hapus ulasan ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-xs font-semibold text-red-600 px-3 py-1.5 border border-red-200 rounded-lg hover:bg-red-50 transition-all">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                    <tr><td colspan="6" class="px-6 py-16 text-center text-gray-400 text-sm">Belum ada ulasan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($reviews->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">{{ $reviews->links() }}</div>
    @endif
</div>
@endsection
