<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // ✅ ต้องมีบรรทัดนี้



class Refer extends Model
{
     use HasFactory;

    protected $fillable = [
        'refer_date','translate_id','destination','address',
        'guardian','parent_name','parent_tel','member',
        'teacher','remark','client_id'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function translate()
    {
        return $this->belongsTo(Translate::class);
    }
}

