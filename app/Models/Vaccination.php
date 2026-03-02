<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;



class Vaccination extends Model
{
  use HasFactory;

    protected $fillable = [
        'date',
        'vaccine_name',
        'hospital',
        'recorder',
        'remark',
        'client_id',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }


}
