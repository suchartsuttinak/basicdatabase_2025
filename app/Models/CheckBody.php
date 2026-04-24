<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CheckBody extends Model
{
    use HasFactory;

    protected $table = 'check_bodies';

    protected $fillable = [
        'assessor_date',
        'development',
        'development_type',
        'special_support_type',
        'special_support_other',
        'detail',
        'weight',
        'height',
        'oral',
        'appearance',
        'wound',
        'disease',
        'hygiene',
        'health',
        'inoculation',
        'injection',
        'vaccination',
        'contagious',
        'other',
        'drug_allergy',
        'recorder',
        'remark',
        'client_id',
    ];

    // ✅ กำหนดการแปลงข้อมูล
    protected $casts = [
        'assessor_date' => 'date',
        'weight' => 'decimal:2',
        'height' => 'decimal:2',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
