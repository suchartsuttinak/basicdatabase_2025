<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientHouseTransfer extends Model
{
    protected $fillable = [
        'client_id',
        'old_house_id',
        'new_house_id',
        'project_id',
        'caregiver_id',
        'changed_by',
        'transfer_date',
        'remark',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function oldHouse()
    {
        return $this->belongsTo(House::class, 'old_house_id');
    }

    public function newHouse()
    {
        return $this->belongsTo(House::class, 'new_house_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function caregiver()
    {
        return $this->belongsTo(User::class, 'caregiver_id');
    }

    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}