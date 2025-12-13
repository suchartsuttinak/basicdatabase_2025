<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EducationRecord extends Model
{

    protected $guarded = [];
    
    public function subjects()
{
   return $this->belongsToMany(Subject::class, 'education_record_subjects')
                ->withPivot('score','grade')
                ->withTimestamps();

}
/**
     * ความสัมพันธ์กับ client
     */
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    /**
     * ความสัมพันธ์กับ education (ระดับการศึกษา)
     */
    public function education() {
        return $this->belongsTo(Education::class, 'education_id');
    }


}

