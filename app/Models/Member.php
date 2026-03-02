<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'fullname',
        'member_age',
        'education_id',
        'relationship',
        'occupation_id',
        'income_id',
        'remark',
    ];

    // ความสัมพันธ์
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function education()
    {
        return $this->belongsTo(Education::class);
    }

    public function occupation()
    {
        return $this->belongsTo(Occupation::class);
    }

    public function income()
    {
        return $this->belongsTo(Income::class);
    }

    


}
