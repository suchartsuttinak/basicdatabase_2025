<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BehaviorScreening extends Model
{
    protected $fillable = [
        'client_id',
        'created_by',
        'screening_date',
        'observer_name',
        'age_text',
        'class_level',
        'learning_score',
        'ld_score',
        'adhd_score',
        'autism_score',
        'learning_risk',
        'ld_risk',
        'adhd_risk',
        'autism_risk',
        'summary',
        'recommendation',
        'remark',
    ];

    protected $casts = [
        'screening_date' => 'date',
        'learning_score' => 'integer',
        'ld_score' => 'integer',
        'adhd_score' => 'integer',
        'autism_score' => 'integer',
        'learning_risk' => 'boolean',
        'ld_risk' => 'boolean',
        'adhd_risk' => 'boolean',
        'autism_risk' => 'boolean',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function items()
    {
        return $this->hasMany(BehaviorScreeningItem::class);
    }

    public function learningItems()
    {
        return $this->hasMany(BehaviorScreeningItem::class)
            ->where('category', 'learning');
    }

    public function ldItems()
    {
        return $this->hasMany(BehaviorScreeningItem::class)
            ->where('category', 'ld');
    }

    public function adhdItems()
    {
        return $this->hasMany(BehaviorScreeningItem::class)
            ->where('category', 'adhd');
    }

    public function autismItems()
    {
        return $this->hasMany(BehaviorScreeningItem::class)
            ->where('category', 'autism');
    }
}