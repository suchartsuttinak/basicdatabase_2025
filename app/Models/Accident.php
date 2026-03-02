<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Accident extends Model
{
    use HasFactory;

    // กำหนดชื่อ table (ถ้าไม่ตรงกับ convention)
    protected $table = 'accidents';

    // ฟิลด์ที่สามารถกรอกข้อมูลได้
    protected $fillable = [
        'incident_date',
        'location',
        'eyewitness',
        'detail',
        'cause',
        'treat_no',
        'hospital',
        'diagnosis',   // แก้ชื่อจาก dianosis → diagnosis
        'appointment',
        'protection',
        'treatment',
        'caretaker',
        'record_date',
        'client_id',
    ];

    /**
     * ความสัมพันธ์: Accident → Client
     * อุบัติเหตุแต่ละรายการจะเชื่อมโยงกับ Client หนึ่งคน
     */
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
}