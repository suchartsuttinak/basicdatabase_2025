<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estimate extends Model
{
    protected $fillable = [
        'date',
        'count',
        'follo_no',
        'results',
        'family_income',
        'guardian_job',
        'income_sufficiency',
        'income_reason',
        'debt',
        'housing_condition',
        'teacher',
        'remark',
        'client_id'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function pictures()
    {
        return $this->hasMany(EstimatePicture::class);
    }
}