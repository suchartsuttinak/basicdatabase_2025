<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HealthcHeckup extends Model
{
    use HasFactory;

    protected $table = 'healthc_heckups';

    protected $fillable = [
        'client_id',
        'checkup_date',
        'hospital_name',
        'checkup_result',
        'abnormal_detail',
        'medical_document',
        'recorded_by',
    ];

    protected $casts = [
        'checkup_date' => 'date',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function recorder()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}