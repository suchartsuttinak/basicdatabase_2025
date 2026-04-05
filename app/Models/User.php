<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\House;
use App\Models\Operation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public const ROLE_ADMIN = 'admin';
    public const ROLE_MANAGER = 'manager';
    public const ROLE_EXECUTIVE = 'executive';
    public const ROLE_SOCIAL_WORKER = 'social_worker';
    public const ROLE_TEACHER_CAREGIVER = 'teacher_caregiver';
    public const ROLE_GENERAL_USER = 'general_user';

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public static function roleOptions(): array
    {
        return [
            self::ROLE_ADMIN => 'ผู้ดูแลระบบ',
            self::ROLE_MANAGER => 'ผู้ใช้ / เจ้าหน้าที่',
            self::ROLE_EXECUTIVE => 'ผู้บริหาร',
            self::ROLE_SOCIAL_WORKER => 'นักสังคมสงเคราะห์',
            self::ROLE_TEACHER_CAREGIVER => 'ครู/ผู้ดูแล',
            self::ROLE_GENERAL_USER => 'ผู้ใช้ทั่วไป',
        ];
    }

    public function getRoleLabelAttribute(): string
    {
        return self::roleOptions()[$this->role] ?? 'ไม่ระบุ';
    }

    public function getStatusLabelAttribute(): string
    {
        return (string) $this->status === '1' ? 'ใช้งาน' : 'ปิดใช้งาน';
    }

    public function getPhotoUrlAttribute(): string
    {
        $path = public_path('upload/user_images/' . $this->photo);

        if (!empty($this->photo) && file_exists($path)) {
            return asset('upload/user_images/' . $this->photo);
        }

        return asset('upload/no_image.jpg');
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isManager(): bool
    {
        return $this->role === self::ROLE_MANAGER;
    }

    public function isExecutive(): bool
    {
        return $this->role === self::ROLE_EXECUTIVE;
    }

    public function isSocialWorker(): bool
    {
        return $this->role === self::ROLE_SOCIAL_WORKER;
    }

    public function isTeacherCaregiver(): bool
    {
        return $this->role === self::ROLE_TEACHER_CAREGIVER;
    }

    public function isGeneralUser(): bool
    {
        return $this->role === self::ROLE_GENERAL_USER;
    }

    public function hasRole(string|array $roles): bool
    {
        if (is_array($roles)) {
            return in_array($this->role, $roles, true);
        }

        return $this->role === $roles;
    }

    /**
     * ผู้ใช้งานสามารถดูแลได้หลายบ้าน
     */
    public function houses(): BelongsToMany
    {
        return $this->belongsToMany(House::class, 'house_user', 'user_id', 'house_id')
            ->withTimestamps();
    }

    public function operations(): HasMany
    {
        return $this->hasMany(Operation::class);
    }
}