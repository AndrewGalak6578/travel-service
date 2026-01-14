<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use Illuminate\Http\Request;

class TripController extends Controller
{
    public function index()
    {
        return Trip::with(['destination','budget'])
            ->latest()
            ->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required','string','max:255'],
            'destination_id' => ['required','exists:destinations,id'],
            'start_date' => ['nullable','date'],
            'days_count' => ['required','integer','min:1','max:60'],
            'notes' => ['nullable','string'],
        ]);

        $trip = Trip::create($data);

        // создаём дни 1..days_count
        for ($i=1; $i <= $trip->days_count; $i++) {
            $trip->days()->create(['day_number' => $i]);
        }

        return Trip::with(['destination','days.activities','budget'])->findOrFail($trip->id);
    }

    public function show(Trip $trip)
    {
        return $trip->load(['destination','budget']);
    }

    public function update(Request $request, Trip $trip)
    {
        $data = $request->validate([
            'title' => ['sometimes','required','string','max:255'],
            'destination_id' => ['sometimes','required','exists:destinations,id'],
            'start_date' => ['nullable','date'],
            'days_count' => ['sometimes','required','integer','min:1','max:60'],
            'notes' => ['nullable','string'],
        ]);

        $trip->update($data);

        return $trip->load(['destination','budget']);
    }

    public function destroy(Trip $trip)
    {
        $trip->delete();
        return response()->noContent();
    }

    public function full(Trip $trip)
    {
        return $trip->load(['destination','days.activities','budget']);
    }

}
