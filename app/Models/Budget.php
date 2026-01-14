<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    protected $fillable = ['trip_id','currency','travel_cost','accommodation_cost','activity_cost'];
    protected $appends = ['total'];

    public function trip() { return $this->belongsTo(Trip::class); }

    public function getTotalAttribute(): int
    {
        return (int)$this->travel_cost + (int)$this->accommodation_cost + (int)$this->activity_cost;
    }
}
