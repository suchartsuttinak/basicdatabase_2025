<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estimate extends Model
{
    protected $fillable = [
        'date','count','follo_no','results','teacher','remark','client_id'
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
