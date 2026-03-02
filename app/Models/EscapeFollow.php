<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EscapeFollow extends Model
{
    protected $fillable = [
        'escape_id',
        'trace_date',
        'count',
        'trac_no',
        'detail',
        'report_date',
        'stop_date',
        'punish',
        'punish_date',
        'remark',
    ];

    // Cast ให้ฟิลด์วันที่เป็น Carbon object
    protected $casts = [
        'trace_date'  => 'date',
        'report_date' => 'date',
        'stop_date'   => 'date',
        'punish_date' => 'date',
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
    ];

    public function escape()
    {
        return $this->belongsTo(Escape::class);
    }
}