<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $table = 'images';

    protected $fillable = [
        'file_path',
        'file_name',
        'mime_type',
        'size',
        'visit_family_id',
        'client_id',
    ];

    // ความสัมพันธ์กับ VisitFamily
    public function visitFamily()
    {
        return $this->belongsTo(VisitFamily::class);
    }

    // ความสัมพันธ์กับ Client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}