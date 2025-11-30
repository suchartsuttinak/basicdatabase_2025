<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $fillable = [
        'dist_code',
        'dist_name',
        'province_id'
    ];

    public function province()
    {
        return $this->belongsTo(Province::class,'province_id');
    }
}
