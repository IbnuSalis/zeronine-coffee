<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Table;
use App\Services\BookingService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function __construct(
        private readonly BookingService $bookingService
    ) {}

    /**
     * Display a listing of user bookings.
     */
    public function index()
    {
        $bookings = Booking::where('user_id', auth()->id())
            ->with('table')
            ->orderBy('booking_date', 'desc')
            ->orderBy('start_time', 'desc')
            ->paginate(10);

        return view('customer.bookings.index', compact('bookings'));
    }

    /**
     * Show the booking creation form.
     */
    public function create(Request $request)
    {
        $date = $request->input('booking_date', Carbon::today()->toDateString());
        $startTime = $request->input('start_time', '10:00');
        $endTime = $request->input('end_time', '12:00');
        $guestCount = $request->input('guest_count', 2);

        // Fetch tables that are available for the selected slot
        $availableTables = $this->bookingService->getAvailableTables(
            Carbon::parse($date),
            $startTime,
            $endTime,
            $guestCount
        );

        return view('customer.bookings.create', compact('availableTables', 'date', 'startTime', 'endTime', 'guestCount'));
    }

    /**
     * Store a newly created booking.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'table_id' => 'required|exists:tables,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|string',
            'end_time' => 'required|string',
            'guest_count' => 'required|integer|min:1|max:10',
            'contact_name' => 'required|string|max:100',
            'contact_phone' => 'required|string|max:20',
            'occasion' => 'nullable|string|max:50',
            'special_requests' => 'nullable|string|max:500',
        ]);

        try {
            $booking = $this->bookingService->create(auth()->user(), $validated);
            
            return redirect()->route('customer.bookings.index')
                ->with('success', 'Reservasi meja #' . $booking->booking_code . ' berhasil dibuat!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Show detail of a single booking.
     */
    public function show(Booking $booking)
    {
        abort_unless($booking->user_id === auth()->id(), 403);
        $booking->load('table');
        
        return view('customer.bookings.show', compact('booking'));
    }

    /**
     * Cancel the booking.
     */
    public function cancel(Request $request, Booking $booking)
    {
        $request->validate([
            'reason' => 'required|string|max:250',
        ]);

        try {
            $this->bookingService->cancel($booking, auth()->user(), $request->reason);
            
            return back()->with('success', 'Reservasi berhasil dibatalkan.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
