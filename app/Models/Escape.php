<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Escape extends Model
{
    // ฟิลด์ที่สามารถบันทึกได้
    protected $fillable = [
        'retire_date',
        'retire_id',
        'stories',
        'client_id',
    ];

    // Cast ให้ฟิลด์วันที่เป็น Carbon object อัตโนมัติ
    protected $casts = [
        'retire_date' => 'date',
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
    ];

    // ความสัมพันธ์กับ Client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // ความสัมพันธ์กับ Retire
    public function retire()
    {
        return $this->belongsTo(Retire::class);
    }

    // ความสัมพันธ์กับ EscapeFollow
    public function follows()
    {
        return $this->hasMany(EscapeFollow::class);
    }
}