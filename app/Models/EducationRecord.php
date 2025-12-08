<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EducationRecord extends Model
{

    protected $guarded = [];
    
    public function subjects()
{
    return $this->belongsToMany(Subject::class, 'education_record_subjects')
                ->withPivot('score', 'grade')
                ->withTimestamps();
}

 public function client() {
        return $this->belongsTo(Client::class);
    }



}
