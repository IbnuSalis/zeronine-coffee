<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['user', 'table'])
            ->orderBy('booking_date', 'desc')
            ->orderBy('start_time', 'desc')
            ->paginate(15);

        return view('admin.bookings.index', compact('bookings'));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,checked_in,completed,cancelled'
        ]);

        $booking->update(['status' => $request->status]);

        return back()->with('success', "Status reservasi #{$booking->booking_code} berhasil diperbarui menjadi {$request->status}.");
    }
}
