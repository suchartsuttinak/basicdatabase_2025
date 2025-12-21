<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Absent extends Model
{
  use HasFactory;

    protected $table = 'absents';

     protected $guarded = [];

// ความสัมพันธ์
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function educationRecord()
    {
        return $this->belongsTo(EducationRecord::class);
    }
}
