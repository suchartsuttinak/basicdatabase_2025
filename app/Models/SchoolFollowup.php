<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolFollowup extends Model
{
    use HasFactory;

    protected $table = 'school_followups';

 protected $guarded = [
   
];

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
