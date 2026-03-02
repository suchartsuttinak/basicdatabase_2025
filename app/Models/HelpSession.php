<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HelpSession extends Model
{
    protected $fillable = ['client_id', 'help_date', 'total_amount'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function items()
    {
        return $this->hasMany(HelpItem::class);
    }

    // ✅ ระบุ foreign key ให้ชัดเจน

}