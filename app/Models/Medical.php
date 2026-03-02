<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medical extends Model
{
     protected $fillable = [
        'medical_date',
        'disease_name',
        'illness',
        'treatment',
        'refer',
        'diagnosis',
        'appt_date',
        'teacher',
        'remark',
        'client_id',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}


