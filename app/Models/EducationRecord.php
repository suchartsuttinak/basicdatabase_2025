<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EducationRecord extends Model
{
    protected $guarded = [];

    /**
     * ความสัมพันธ์กับ Subject (pivot table education_record_subjects)
     */
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'education_record_subjects')
                    ->withPivot('score','grade')
                    ->withTimestamps();
    }

    /**
     * ความสัมพันธ์กับ Client
     */
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    /**
     * ความสัมพันธ์กับ Education (ระดับการศึกษา)
     */
    public function education()
    {
        return $this->belongsTo(Education::class, 'education_id');
    }

    /**
     * ความสัมพันธ์กับ Institution (สถานศึกษา)
     */
    public function institution()
    {
        return $this->belongsTo(Institution::class, 'institution_id');
    }

    /**
     * ความสัมพันธ์กับ Semester (ภาคเรียน)
     */
    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }
}