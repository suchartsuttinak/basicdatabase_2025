<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'user_id',
        'module',
        'type',
        'title',
        'description',
        'occurred_at',
        'icon',
        'url',
    ];

    protected $casts = [
        'occurred_at' => 'datetime',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function record(array $data): self
    {
        return self::create([
            'client_id'    => $data['client_id'],
            'user_id'      => $data['user_id'] ?? auth()->id(),
            'module'       => $data['module'] ?? null,
            'type'         => $data['type'] ?? 'info',
            'title'        => $data['title'],
            'description'  => $data['description'] ?? null,
            'occurred_at'  => $data['occurred_at'] ?? now(),
            'icon'         => $data['icon'] ?? 'bi-clock-history',
            'url'          => $data['url'] ?? null,
        ]);
    }
}