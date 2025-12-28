<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Psychiatric extends Model
{
      protected $fillable = [
        'sent_date','hotpital','psycho_id','diagnose',
        'appoin_date','drug_no','drug_name','disa_no','client_id'
    ];

    // ความสัมพันธ์
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function psycho()
    {
        return $this->belongsTo(Psycho::class);
    }
}


