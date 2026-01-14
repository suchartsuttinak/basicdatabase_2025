<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // ✅ ต้องมีบรรทัดนี้



class Refer extends Model
{
     use HasFactory;

    protected $table = 'refers';

    // ✅ เปิด mass assignment
    protected $fillable = [
        'refer_date',
        'translate_id',
        'destination',
        'address',
        'guardian',
        'parent_name',
        'parent_tel',
        'member',
        'teacher',
        'remark',
        'client_id',
    ];

    // ✅ ให้ Eloquent จัดการ timestamps (ต้องตรงกับชนิดคอลัมน์)
    public $timestamps = true;

    // (ทางเลือก) ถ้าต้อง cast วันที่
    protected $casts = [
        'refer_date' => 'date',
    ];

    // ความสัมพันธ์
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function translate()
    {
        return $this->belongsTo(Translate::class);
    }
}


