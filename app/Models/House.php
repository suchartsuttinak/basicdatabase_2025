<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class House extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * 🔥 บ้านนี้มี User อะไรบ้าง (Many-to-Many)
     */
    public function users()
    {
        return $this->belongsToMany(User::class)
                    ->withTimestamps();
    }

    /**
     * 🔥 บ้านนี้มี Client อะไรบ้าง (One-to-Many)
     */
    public function clients()
    {
        return $this->hasMany(Client::class);
    }
}