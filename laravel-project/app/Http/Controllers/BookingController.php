<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingRequest;
use App\Http\Requests\CancelBookingRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Concert;
use App\Models\SeatType;
use App\Models\Booking; 

class BookingController extends Controller
{
    public function book(BookingRequest $request)
    {
        $userId = Auth::id();

        $concertId = $request->concert_id;
        $seatTypeId = $request->seat_type_id;

        // Check if concert already started
        $concert = Concert::findOrFail($concertId);
        if (now()->greaterThanOrEqualTo($concert->start_time)) {
            return response()->json(['error' => 'Concert already started'], 403);
        }

        try {
            DB::beginTransaction();

            // Check if user already booked 
            $alreadyBooked = Booking::where('user_id', $userId)
                ->where('concert_id', $concertId)
                ->whereNull('deleted_at')
                ->exists();

            if ($alreadyBooked) {
                DB::rollBack();
                return response()->json(['error' => 'You have already booked this concert'], 400);
            }

            $seat = SeatType::where('id', $seatTypeId)
                ->where('concert_id', $concertId)
                ->lockForUpdate()
                ->firstOrFail();

            // Count bookings  
            $bookedCount = Booking::where('concert_id', $concertId)
                ->where('seat_type_id', $seatTypeId)
                ->whereNull('deleted_at')
                ->lockForUpdate()
                ->count();

            if ($bookedCount >= $seat->total_quantity) {
                DB::rollBack();
                return response()->json(['error' => 'Seat type sold out'], 400);
            }

            // Get price and insert booking
            $price = $seat->price;

            Booking::create([
                'user_id' => $userId,
                'concert_id' => $concertId,
                'seat_type_id' => $seatTypeId,
                'price' => $price,
            ]);

            DB::commit();

            return response()->json(['message' => 'Booking successful', 'price' => $price], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Internal server error', 'detail' => $e->getMessage()], 500);
        } 
    }

    public function cancel(CancelBookingRequest $request)
    {
        $userId = Auth::id();
        $concertId = $request->concert_id;
        $seatTypeId = $request->seat_type_id;

        $concert = Concert::findOrFail($concertId);
        if (now()->greaterThanOrEqualTo($concert->start_time)) {
            return response()->json(['error' => 'Concert already started. Cannot cancel.'], 403);
        }

        $booking = Booking::where('user_id', $userId)
            ->where('concert_id', $concertId)
            ->where('seat_type_id', $seatTypeId)
            ->whereNull('deleted_at')
            ->first();

        if (!$booking) {
            return response()->json(['error' => 'No booking found to cancel.'], 404);
        }

        $booking->delete(); 

        return response()->json(['message' => 'Booking cancelled successfully.']);
    }
}
