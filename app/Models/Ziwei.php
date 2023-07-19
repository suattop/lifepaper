<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ziwei extends Model
{
    protected $fillable = [
        'stem',
        'branch',
        'palace',
        'destiny_id',
        'begin_age',
        'end_age',
    ];

    public function destiny()
    {
        return $this->belongsTo(Destiny::class);
    }

    public function stars()
    {
        return $this->hasMany(Star::class);
    }
}
