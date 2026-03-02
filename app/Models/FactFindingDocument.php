<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FactFindingDocument extends Model
{
   // ⚡ กำหนดชื่อ table ให้ตรงกับฐานข้อมูล
    protected $table = 'factfinding_documents';

    protected $fillable = ['factfinding_id', 'document_id'];

    public function document()
    {
        return $this->belongsTo(Document::class, 'document_id');
    }

    public function factfinding()
    {
        return $this->belongsTo(Factfinding::class, 'factfinding_id');
    }





}
