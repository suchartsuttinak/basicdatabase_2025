<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientFile extends Model
{
      protected $fillable = [
        'client_id',
        'file_type',
        'file_name',
        'file_path',
        'uploaded_at',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}


