<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Changerecord extends Model
{
    protected $fillable = [
        'self_palace',
        'change_palace',
        'four_change',
        'star_name',
        'destiny_id',
    ];
}
