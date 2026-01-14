<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $fillable = ['title','destination_id','start_date','days_count','notes'];
    protected $casts = ['start_date' => 'date'];

    public function destination() { return $this->belongsTo(Destination::class); }
    public function days() { return $this->hasMany(ItineraryDay::class)->orderBy('day_number'); }
    public function budget() { return $this->hasOne(Budget::class); }
}
