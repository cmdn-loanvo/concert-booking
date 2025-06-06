<?php

namespace App\Http\Controllers;

use App\Models\Concert;
use App\Http\Requests\ShowConcertRequest;

class ConcertController extends Controller
{
    public function index()
    {
        $concerts = Concert::where('start_time', '>', now())
            ->orderBy('start_time')
            ->get(['id', 'title', 'start_time']);

        return response()->json($concerts);
    }

    public function show(ShowConcertRequest $request, $id)
    {
        $concert = Concert::with('seatTypes')->findOrFail($id);

        $seatTypes = $concert->seatTypes->map(function ($seat) {
            $bookedCount = $seat->bookings()->whereNull('deleted_at')->count();

            return [
                'id' => $seat->id,
                'name' => $seat->name,
                'total_quantity' => $seat->total_quantity,
                'remaining_quantity' => $seat->total_quantity - $bookedCount,
                'price' => $seat->price,
            ];
        });

        return response()->json([
            'id' => $concert->id,
            'title' => $concert->title,
            'start_time' => $concert->start_time,
            'seat_types' => $seatTypes,
        ]);
    }
}
