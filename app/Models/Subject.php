<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
     protected $fillable = ['subject_name'];

    public function educationRecords()
    {
      return $this->belongsToMany(EducationRecord::class, 'education_record_subjects')
                ->withPivot('score','grade')
                ->withTimestamps();



    }




}
