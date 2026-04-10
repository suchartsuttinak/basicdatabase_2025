<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class House extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * บ้านนี้มี User อะไรบ้าง (Many-to-Many)
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'house_user', 'house_id', 'user_id')
            ->withTimestamps();
    }

    /**
     * บ้านนี้มี Client อะไรบ้าง (One-to-Many)
     */
    public function clients(): HasMany
    {
        return $this->hasMany(Client::class, 'house_id');
    }

    /**
     * เฉพาะ client ที่ยังแสดงผลอยู่
     */
    public function activeClients(): HasMany
    {
        return $this->hasMany(Client::class, 'house_id')
            ->where('release_status', 'show');
    }

    /**
     * เฉพาะ client ที่อยู่ในสถานะ show หรือ refer
     */
    public function visibleClients(): HasMany
    {
        return $this->hasMany(Client::class, 'house_id')
            ->whereIn('release_status', ['show', 'refer']);
    }

    /**
     * Scope สำหรับค้นหาตามชื่อบ้าน ถ้าจะใช้ในอนาคต
     */
    public function scopeSearch(Builder $query, ?string $keyword): Builder
    {
        if (blank($keyword)) {
            return $query;
        }

        return $query->where(function (Builder $q) use ($keyword) {
            $q->where('name', 'like', "%{$keyword}%")
              ->orWhere('house_name', 'like', "%{$keyword}%");
        });
    }

    /**
     * จำนวนผู้ใช้ที่ผูกกับบ้านนี้
     */
    public function getUsersCountAttribute(): int
    {
        return $this->relationLoaded('users')
            ? $this->users->count()
            : $this->users()->count();
    }

    /**
     * จำนวน client ทั้งหมดในบ้านนี้
     */
    public function getClientsCountAttribute(): int
    {
        return $this->relationLoaded('clients')
            ? $this->clients->count()
            : $this->clients()->count();
    }

    /**
     * จำนวน client ที่ยัง active/show
     */
    public function getActiveClientsCountAttribute(): int
    {
        return $this->activeClients()->count();
    }
}