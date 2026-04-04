<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Role constants
     */
    public const ROLE_ADMIN = 'admin';
    public const ROLE_MANAGER = 'manager';
    public const ROLE_EXECUTIVE = 'executive';
    public const ROLE_SOCIAL_WORKER = 'social_worker';
    public const ROLE_TEACHER_CAREGIVER = 'teacher_caregiver';
    public const ROLE_GENERAL_USER = 'general_user';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * รายการสิทธิ์ผู้ใช้งาน
     */
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

    /**
     * แสดงชื่อสิทธิ์เป็นภาษาไทย
     */
    public function getRoleLabelAttribute(): string
    {
        return self::roleOptions()[$this->role] ?? 'ไม่ระบุ';
    }

    /**
     * แสดงสถานะเป็นข้อความ
     */
    public function getStatusLabelAttribute(): string
    {
        return (string) $this->status === '1' ? 'ใช้งาน' : 'ปิดใช้งาน';
    }

    /**
     * ลิงก์รูปภาพผู้ใช้งาน
     */
    public function getPhotoUrlAttribute(): string
    {
        $path = public_path('upload/user_images/' . $this->photo);

        if (!empty($this->photo) && file_exists($path)) {
            return asset('upload/user_images/' . $this->photo);
        }

        return asset('upload/no_image.jpg');
    }

    /**
     * ตรวจสอบ role
     */
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

    /**
     * ตรวจสอบว่ามี role ตรงกับที่กำหนดหรือไม่
     */
    public function hasRole(string|array $roles): bool
    {
        if (is_array($roles)) {
            return in_array($this->role, $roles);
        }

        return $this->role === $roles;
    }
    
}