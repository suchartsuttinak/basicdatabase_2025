<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Factfinding extends Model
{
    protected $guarded = [];

    public function documents()
    {
        // ⚡ กำหนดชื่อ pivot table ให้ตรงกับฐานข้อมูล
        return $this->belongsToMany(Document::class, 'factfinding_documents', 'factfinding_id', 'document_id')
                    ->withTimestamps();
    }

      public function marital()   
      { return $this->belongsTo(Marital::class, 'marital_id'); 
    
    }
}
