<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ObserveFollowup extends Model
{
   use HasFactory;

    protected $table = 'observe_followups';

    protected $fillable = [
        'observe_id',
        'followup_date',
        'followup_count',
        'followup_action',
        'followup_result',
    ];

    /**
     * ความสัมพันธ์: Followup เป็นของ Observe
     */
    public function observeRelation()
    {
        return $this->belongsTo(Observe::class, 'observe_id');
    }
}

