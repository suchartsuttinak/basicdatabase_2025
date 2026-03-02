<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class CheckBody extends Model
{
    use HasFactory;

    protected $table = 'check_bodies';

    protected $fillable = [
        'assessor_date','development','detail','weight','height','oral','appearance',
        'wound','disease','hygiene','health','inoculation','injection','vaccination',
        'contagious','other','drug_allergy','recorder','remark','client_id'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

}
