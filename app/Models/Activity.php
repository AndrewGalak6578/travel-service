<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'itinerary_day_id','title','description','start_time','end_time',
        'cost_estimate','location','is_eco','position'
    ];

    protected $casts = ['is_eco' => 'boolean'];

    public function day()
    {
        return $this->belongsTo(ItineraryDay::class, 'itinerary_day_id');
    }
}
