<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Psychiatric extends Model
{
    protected $table = 'psychiatrics';

    protected $fillable = [
        'sent_date',
        'hotpital',
        'psycho_id',
        'diagnose',
        'appoin_date',
        'drug_no',
        'drug_name',
        'disa_no',
        'client_id',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function psycho()
    {
        return $this->belongsTo(Psycho::class, 'psycho_id');
    }
}