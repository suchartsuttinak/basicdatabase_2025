<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publicize extends Model
{
      protected $fillable = [
        'recorded_at',
        'category',
        'title',
        'file_path',
        'file_name',
    ];

    protected $casts = [
        'recorded_at' => 'date',
    ];

  public const CATEGORIES = [
    'project'           => 'โครงการ',
    'law'               => 'กฎหมาย',
    'nationality_law'   => 'การทะเบียนราษฎร/สัญชาติ',
    'book'              => 'หนังสือสั่งการ',
    'policy'            => 'นโยบาย',
    'mou'               => 'บันทึกข้อตกลง',
    'form'              => 'แบบฟอร์ม',
    'manual'            => 'คู่มือ',
];

    public function getCategoryLabelAttribute(): string
    {
        return self::CATEGORIES[$this->category] ?? $this->category;
    }
}
