<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    use HasFactory;

    // กำหนดชื่อตารางให้ตรงกับฐานข้อมูล
    protected $table = 'institutions';

    // ฟิลด์ที่สามารถบันทึก/แก้ไขได้
    protected $fillable = ['institution_name'];
}