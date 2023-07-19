<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Star extends Model
{
    protected $fillable = [
        'name', 'ziwei_id', 'destiny_id',
    ];

    public function destiny()
    {
        return $this->belongsTo(Destiny::class);
    }
}
