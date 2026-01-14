<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    protected $fillable = [
        'name', 'slug','region','experience_type','description',
        'highlights','sustainability_notes','cover_image'
    ];

    protected $casts = [
        'highlights' => 'array'
    ];

    public function trips()
    {
        return $this->hasMany(Trip::class);
    }
}
