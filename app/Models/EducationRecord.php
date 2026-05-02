<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EducationRecord extends Model
{
    protected $table = 'education_records';

    protected $guarded = [];

    protected $casts = [
        'record_date'     => 'date',
        'grade_average'  => 'decimal:2',
        'client_id'      => 'integer',
        'education_id'   => 'integer',
        'semester_id'    => 'integer',
        'institution_id' => 'integer',
    ];

    public function subjects()
    {
        return $this->belongsToMany(
            Subject::class,
            'education_record_subjects',
            'education_record_id',
            'subject_id'
        )
        ->withPivot('score', 'grade')
        ->withTimestamps();
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    public function education()
    {
        return $this->belongsTo(Education::class, 'education_id', 'id');
    }

    public function institution()
    {
        return $this->belongsTo(Institution::class, 'institution_id', 'id');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id', 'id');
    }
}