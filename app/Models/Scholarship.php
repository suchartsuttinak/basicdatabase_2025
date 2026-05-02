<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scholarship extends Model
{
    protected $guarded = [];

    // ✅ แปลง JSON เป็น array
    protected $casts = [
        'support_types' => 'array',
    ];

    // ✅ ความสัมพันธ์: 1 ผู้สนับสนุน มีหลายการบริจาค
    public function donations()
    {
        return $this->hasMany(ScholarshipDonation::class);
    }
}