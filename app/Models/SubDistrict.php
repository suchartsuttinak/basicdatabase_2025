<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubDistrict extends Model
{
   protected $fillable = [
        'subd_code',
        'subd_name',
        'zipcode',
        'district_id'
    ];

    public function district()
    {
        return $this->belongsTo(District::class,'district_id');
    }
}
