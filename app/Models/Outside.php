<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Outside extends Model
{
    // ป้องกัน mass assignment เฉพาะฟิลด์ที่ไม่ต้องการ
    protected $guarded = [];

    /**
     * ความสัมพันธ์: Misbehavior มีหลาย Observe
     */
   
}