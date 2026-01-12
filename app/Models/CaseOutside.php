<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseOutside extends Model
{
    protected $fillable = [
        'date','count','outside_id','dormitory',
        'follo_no','results','teacher','remerk','client_id'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function outside()
    {
        return $this->belongsTo(Outside::class);
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            // ตรวจสอบ date ห้ามซ้ำ
            $exists = CaseOutside::where('client_id',$model->client_id)
                ->where('date',$model->date)
                ->exists();

            if ($exists) {
                throw ValidationException::withMessages([
                    'date' => 'วันที่ติดตามนี้มีอยู่แล้ว ห้ามซ้ำ'
                ]);
            }

            // กำหนด count อัตโนมัติ
            $lastCount = CaseOutside::where('client_id',$model->client_id)->max('count');
            $model->count = $lastCount ? $lastCount+1 : 1;
        });
    }
}

