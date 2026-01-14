<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ItineraryDay;
use App\Models\Trip;
use Illuminate\Http\Request;

class TripDayController extends Controller
{
    public function store(Request $request, Trip $trip)
    {
        $data = $request->validate([
            'day_number' => ['nullable','integer','min:1','max:60'],
            'date' => ['nullable','date'],
        ]);

        $dayNumber = $data['day_number'] ?? ((int)$trip->days()->max('day_number') + 1);

        $day = $trip->days()->create([
            'day_number' => $dayNumber,
            'date' => $data['date'] ?? null,
        ]);

        $trip->update(['days_count' => max($trip->days_count, $dayNumber)]);

        return $day->load('activities');
    }

    public function destroy(Trip $trip, ItineraryDay $day)
    {
        abort_unless($day->trip_id === $trip->id, 404);

        $day->delete();

        // не усложняем: days_count не пересчитываем, можно потом
        return response()->noContent();
    }

}
