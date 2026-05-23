<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientTransfer extends Model
{
    protected $fillable = [
        'client_id',
        'from_project_id',
        'to_project_id',
        'transfer_date',
        'status',
        'requested_by',
        'approved_by',
        'approved_at',
        'remark',
    ];

    protected $casts = [
        'transfer_date' => 'date',
        'approved_at' => 'datetime',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function fromProject()
    {
        return $this->belongsTo(Project::class, 'from_project_id');
    }

    public function toProject()
    {
        return $this->belongsTo(Project::class, 'to_project_id');
    }

    public function requestedBy()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}