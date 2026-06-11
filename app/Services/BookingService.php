<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Table;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BookingService
{
    /**
     * Check if a table is available for the requested time slot.
     */
    public function isAvailable(int $tableId, Carbon $date, string $startTime, string $endTime): bool
    {
        return ! Booking::where('table_id', $tableId)
            ->where('booking_date', $date->toDateString())
            ->whereIn('status', ['pending', 'confirmed', 'checked_in'])
            ->where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime, $endTime])
                    ->orWhereBetween('end_time', [$startTime, $endTime])
                    ->orWhere(function ($q) use ($startTime, $endTime) {
                        $q->where('start_time', '<=', $startTime)
                          ->where('end_time', '>=', $endTime);
                    });
            })
            ->exists();
    }

    /**
     * Get all available tables for a specific time slot.
     */
    public function getAvailableTables(Carbon $date, string $startTime, string $endTime, int $guestCount = 2): \Illuminate\Database\Eloquent\Collection
    {
        $bookedTableIds = Booking::where('booking_date', $date->toDateString())
            ->whereIn('status', ['pending', 'confirmed', 'checked_in'])
            ->where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime, $endTime])
                    ->orWhereBetween('end_time', [$startTime, $endTime])
                    ->orWhere(function ($q) use ($startTime, $endTime) {
                        $q->where('start_time', '<=', $startTime)
                          ->where('end_time', '>=', $endTime);
                    });
            })
            ->pluck('table_id');

        return Table::where('is_active', true)
            ->where('capacity', '>=', $guestCount)
            ->whereNotIn('id', $bookedTableIds)
            ->orderBy('capacity')
            ->get();
    }

    /**
     * Create a new booking.
     */
    public function create(User $user, array $data): Booking
    {
        $date = Carbon::parse($data['booking_date']);

        abort_if(
            ! $this->isAvailable($data['table_id'], $date, $data['start_time'], $data['end_time']),
            422,
            'Maaf, meja ini sudah dipesan pada waktu tersebut.'
        );

        return DB::transaction(function () use ($user, $data, $date) {
            return Booking::create([
                'booking_code' => Booking::generateBookingCode(),
                'user_id' => $user->id,
                'table_id' => $data['table_id'],
                'booking_date' => $date,
                'start_time' => $data['start_time'],
                'end_time' => $data['end_time'],
                'guest_count' => $data['guest_count'] ?? 2,
                'status' => 'pending',
                'occasion' => $data['occasion'] ?? null,
                'special_requests' => $data['special_requests'] ?? null,
                'contact_name' => $data['contact_name'] ?? $user->name,
                'contact_phone' => $data['contact_phone'] ?? $user->phone,
            ]);
        });
    }

    /**
     * Cancel a booking and restore table availability.
     */
    public function cancel(Booking $booking, User $user, string $reason): Booking
    {
        abort_if(
            $booking->user_id !== $user->id,
            403,
            'Kamu tidak memiliki akses untuk membatalkan booking ini.'
        );
        abort_if(
            ! in_array($booking->status, ['pending', 'confirmed']),
            422,
            'Booking ini tidak dapat dibatalkan.'
        );

        $booking->update([
            'status' => 'cancelled',
            'cancellation_reason' => $reason,
        ]);

        return $booking;
    }
}
