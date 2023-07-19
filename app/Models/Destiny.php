<?php

namespace App\Models;

use Helper;
use Illuminate\Database\Eloquent\Model;

class Destiny extends Model
{
    protected $fillable = [
        'gender',
        'born_year',
        'born_month',
        'born_day',
        'born_hour',
        'year_stem',
        'year_branch',
        'month_stem',
        'month_branch',
        'day_stem',
        'day_branch',
        'hour_stem',
        'hour_branch',
        'lunar_year',
        'lunar_month',
        'lunar_day',
        'lunar_hour',
        'lunar_year_chi',
        'lunar_month_chi',
        'lunar_day_chi',
        'lunar_hour_chi',
        'animal',
        'week_name',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($destiny) {
            $life_branch = Helper::lifeBranch($destiny['lunar_month'], $destiny['hour_branch']);
            $body_branch = Helper::bodyBranch($destiny['lunar_month'], $destiny['hour_branch']);
            $destiny->ziwei()->create(['stem' => Helper::findFirstStem($destiny['year_stem']),
                'branch' => Helper::convertNotoBranch(1),
                'palace' => Helper::palace($life_branch, Helper::convertNotoBranch(1)),
                'destiny_id' => $destiny['id']]);
            for ($i = 2; $i <= 12; $i++) {
                $destiny->ziwei()->create(['stem' => Helper::findOtherStem(Helper::convertNoToBranch($i), Helper::findFirstStem($destiny['year_stem'])),
                    'branch' => Helper::convertNotoBranch($i),
                    'palace' => Helper::palace($life_branch, Helper::convertNotoBranch($i)),
                    'destiny_id' => $destiny['id']]);
            }
        });
    }

    public function ziwei()
    {
        return $this->hasOne(Ziwei::class);
    }
}
