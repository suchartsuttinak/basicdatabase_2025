<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BehaviorScreeningItem extends Model
{
    protected $fillable = [
        'behavior_screening_id',
        'category',
        'item_no',
        'question',
        'answer',
    ];

    protected $casts = [
        'item_no' => 'integer',
        'answer' => 'boolean',
    ];

    public function screening()
    {
        return $this->belongsTo(BehaviorScreening::class, 'behavior_screening_id');
    }
}