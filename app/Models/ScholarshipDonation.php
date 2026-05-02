<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScholarshipDonation extends Model
{
    protected $guarded = [];

    protected $casts = [
        'donation_date' => 'date', // ✅ แปลงวันที่อัตโนมัติ
    ];

    // ✅ ความสัมพันธ์กลับไปหา Scholarship
    public function scholarship()
    {
        return $this->belongsTo(Scholarship::class);
    }
}
