<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Followup extends Model
{
    protected $table = 'followups';

    protected $fillable = [
        'client_id',
        'followup_date',
        'assistance_detail',
        'note',
    ];

    protected $casts = [
        'followup_date' => 'date',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
}