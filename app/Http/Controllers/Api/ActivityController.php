<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\ItineraryDay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActivityController extends Controller
{
    public function store(Request $request, ItineraryDay $day)
    {
        $data = $request->validate([
            'title' => ['required','string','max:255'],
            'description' => ['nullable','string'],
            'start_time' => ['nullable','date_format:H:i'],
            'end_time' => ['nullable','date_format:H:i'],
            'cost_estimate' => ['nullable','integer','min:0'],
            'location' => ['nullable','string','max:255'],
            'is_eco' => ['nullable','boolean'],
        ]);

        $nextPos = ((int)$day->activities()->max('position')) + 1;

        $activity = $day->activities()->create(array_merge($data, [
            'position' => $nextPos,
            'cost_estimate' => $data['cost_estimate'] ?? 0,
            'is_eco' => $data['is_eco'] ?? false,
        ]));

        return $activity;
    }

    public function update(Request $request, Activity $activity)
    {
        $data = $request->validate([
            'title' => ['sometimes','required','string','max:255'],
            'description' => ['nullable','string'],
            'start_time' => ['nullable','date_format:H:i'],
            'end_time' => ['nullable','date_format:H:i'],
            'cost_estimate' => ['nullable','integer','min:0'],
            'location' => ['nullable','string','max:255'],
            'is_eco' => ['nullable','boolean'],
            'position' => ['nullable','integer','min:1','max:200'],
        ]);

        $activity->update($data);

        return $activity;
    }

    public function destroy(Activity $activity)
    {
        $activity->delete();
        return response()->noContent();
    }

    public function reorder(Request $request, ItineraryDay $day)
    {
        $data = $request->validate([
            'ordered_ids' => ['required','array','min:1'],
            'ordered_ids.*' => ['integer','exists:activities,id'],
        ]);

        $ids = $data['ordered_ids'];

        // защита: все айди должны принадлежать этому дню
        $count = $day->activities()->whereIn('id', $ids)->count();
        abort_unless($count === count($ids), 422, 'Some activities do not belong to this day.');

        DB::transaction(function () use ($ids) {
            foreach ($ids as $index => $id) {
                Activity::whereKey($id)->update(['position' => $index + 1]);
            }
        });

        return $day->load('activities');
    }

}
