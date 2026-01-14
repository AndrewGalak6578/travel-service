<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Budget;
use App\Models\Trip;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    public function upsert(Request $request, Trip $trip)
    {
        $data = $request->validate([
            'currency' => ['nullable','string','max:10'],
            'travel_cost' => ['required','integer','min:0'],
            'accommodation_cost' => ['required','integer','min:0'],
            'activity_cost' => ['required','integer','min:0'],
        ]);

        $budget = Budget::updateOrCreate(
            ['trip_id' => $trip->id],
            [
                'currency' => $data['currency'] ?? 'USD',
                'travel_cost' => $data['travel_cost'],
                'accommodation_cost' => $data['accommodation_cost'],
                'activity_cost' => $data['activity_cost'],
            ]
        );

        return $budget;
    }
}
