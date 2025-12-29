<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Misbehavior extends Model
{
    // ป้องกัน mass assignment เฉพาะฟิลด์ที่ไม่ต้องการ
    protected $guarded = [];

    /**
     * ความสัมพันธ์: Misbehavior มีหลาย Observe
     */
    public function observes()
    {
        return $this->hasMany(Observe::class);
    }
}