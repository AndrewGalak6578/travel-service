<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItineraryDay extends Model
{
    protected $fillable = ['trip_id','day_number','date'];
    protected $casts = ['date' => 'date'];

    public function trip() { return $this->belongsTo(Trip::class); }
    public function activities() { return $this->hasMany(Activity::class)->orderBy('position'); }
}
