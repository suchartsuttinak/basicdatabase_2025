<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitFamily extends Model
{
    use HasFactory;

    protected $table = 'visit_families';

    protected $fillable = [
        'visit_date',
        'count', // ✅ เปลี่ยนชื่อจาก count
        'family_fname',
        'family_age',
        'member',
        'address',
        'moo',
        'soi',
        'road',
        'village',
        'province_id',
        'district_id',
        'sub_district_id',
        'zipcode',
        'phone',
        'outside_address',
        'inside_address',
        'environment',
        'neighbor',
        'member_relation',
        'income_id',
        'problem',
        'need',
        'diagnose',
        'assistance',
        'comment',
        'modify',
        'teacher',
        'remark',
        'client_id',
    ];

    // ความสัมพันธ์กับ Client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // ความสัมพันธ์กับ Income
    public function income()
    {
        return $this->belongsTo(Income::class);
    }

    // ความสัมพันธ์กับ Province/District/SubDistrict
    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function subDistrict()
    {
        return $this->belongsTo(SubDistrict::class, 'sub_district_id');
    }

    // ✅ ความสัมพันธ์กับ Images
    public function images()
    {
        return $this->hasMany(Image::class, 'visit_family_id');
    }
}