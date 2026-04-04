<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Operation extends Model
{
    protected $guarded = [];

    protected $casts = [
        'operation_date' => 'date',
    ];

    /**
     * ผู้ดำเนินงาน
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}