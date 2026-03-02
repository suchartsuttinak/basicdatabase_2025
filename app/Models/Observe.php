<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Observe extends Model
{
    use HasFactory;

    // กำหนดชื่อตารางให้ตรงกับฐานข้อมูล
    protected $table = 'observes';

    // ฟิลด์ที่สามารถ mass assignment ได้
    protected $fillable = [
        'date',
        'behavior',
        'cause',
        'solution',
        'action',
        'obstacles',
        'result',
        'record_date',
        'recorder',
        'misbehavior_id',
        'client_id',
    ];

    /**
     * ความสัมพันธ์: Observe เป็นของ Client
     * หลาย Observe → 1 Client
     */
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    /**
     * ความสัมพันธ์: Observe เป็นของ Misbehavior
     * หลาย Observe → 1 Misbehavior
     */
    public function misbehavior()
    {
        return $this->belongsTo(Misbehavior::class, 'misbehavior_id');
    }

    /**
     * ความสัมพันธ์: Observe มีหลาย Followups
     * 1 Observe → หลาย Followup
     */
    public function followups()
    {
        return $this->hasMany(ObserveFollowup::class, 'observe_id');
    }
}