<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolFollowup extends Model
{
    use HasFactory;

    protected $table = 'school_followups';

 protected $fillable = [
    'client_id',
    'education_record_id',
    'follow_date',
    'teacher_name',
    'tel',
    'follow_type',
    'result',
    'remark',
    'contact_name',
    'follo_no', // ✅ เพิ่มตรงนี้
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
