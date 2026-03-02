<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstimatePicture extends Model
{
  protected $fillable = ['estimate_id','path'];

    public function estimate()
    {
        return $this->belongsTo(Estimate::class);
    }


}
