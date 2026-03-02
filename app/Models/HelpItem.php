<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HelpItem extends Model
{
    protected $fillable = ['help_session_id', 'item_name', 'quantity', 'unit_price', 'total_price'];

    public function helpSession()
    {
        return $this->belongsTo(HelpSession::class);
    }
}

