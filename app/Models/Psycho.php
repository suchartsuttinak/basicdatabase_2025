<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Psycho extends Model
{
    // กำหนดชื่อ table ให้ตรงกับฐานข้อมูล
    protected $table = 'psychos';

    // ฟิลด์ที่อนุญาตให้บันทึกแบบ mass assignment
    protected $fillable = [
        'psycho_name',
    ];

    // ความสัมพันธ์: Psycho มี Psychiatric หลายรายการ
    public function psychiatrics()
    {
        return $this->hasMany(Psychiatric::class, 'psycho_id');
    }
}