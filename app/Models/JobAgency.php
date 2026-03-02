<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobAgency extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_date','occupation_id','position','income',
        'company','coordinator','remark','client_id','count'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // ✅ ใช้ belongsTo เพราะตาราง job_agencies มี occupation_id
   public function occupation()
{
    return $this->belongsTo(Occupation::class, 'occupation_id');
}
}

