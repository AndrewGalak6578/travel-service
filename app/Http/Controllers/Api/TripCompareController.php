<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use Illuminate\Http\Request;

class TripCompareController extends Controller
{
    public function compare(Request $request)
    {
        $data = $request->validate([
            'a' => ['required','integer','exists:trips,id'],
            'b' => ['required','integer','exists:trips,id'],
        ]);

        $a = Trip::with('budget')->findOrFail($data['a']);
        $b = Trip::with('budget')->findOrFail($data['b']);

        $aTotal = $a->budget?->total ?? 0;
        $bTotal = $b->budget?->total ?? 0;

        return [
            'a' => ['id' => $a->id, 'title' => $a->title, 'days' => $a->days_count, 'total_budget' => $aTotal],
            'b' => ['id' => $b->id, 'title' => $b->title, 'days' => $b->days_count, 'total_budget' => $bTotal],
            'diff' => [
                'days' => $a->days_count - $b->days_count,
                'total_budget' => $aTotal - $bTotal,
            ],
        ];
    }

}
