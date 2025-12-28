<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;



class Addictive extends Model
{
    use HasFactory;

    protected $fillable = [
        'date', 'count', 'exam', 'refer', 'record', 'recorder', 'client_id'
    ];

    // ความสัมพันธ์กับ Client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}

