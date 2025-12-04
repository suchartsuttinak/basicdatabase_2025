<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
     protected $guarded = [];


     public function factfindings()
{
    return $this->belongsToMany(Factfinding::class, 'factfinding_document')
                ->withTimestamps();
}
}
