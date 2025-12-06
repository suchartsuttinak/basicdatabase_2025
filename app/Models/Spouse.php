<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Spouse extends Model
{
    protected $fillable = [
        'fname','lname','age','occupation','income','idcard',
        'address_no','moo','soi','road','village',
        'client_id','province_id','district_id','sub_district_id',
        'phone'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // Relationships
    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function subDistrict()
    {
        return $this->belongsTo(SubDistrict::class, 'sub_district_id');
    }
}
