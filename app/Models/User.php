<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\House;
use App\Models\Operation;
use App\Models\Project;
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
    public const ROLE_NURSE = 'nurse';
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
            self::ROLE_NURSE => 'พยาบาล',
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

   public function isNurse(): bool
{
    return $this->role === self::ROLE_NURSE;
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
     * ใช้แทน hasRole() แบบหลายค่า อ่านง่ายขึ้น
     */
    public function hasAnyRole(array $roles): bool
    {
        return in_array($this->role, $roles, true);
    }

    /**
     * ผู้ใช้งานสามารถดูแลได้หลายบ้าน
     */
    public function houses(): BelongsToMany
    {
        return $this->belongsToMany(House::class, 'house_user', 'user_id', 'house_id')
            ->withTimestamps();
    }

    /**
     * เผื่อใช้กรณีต้องการเฉพาะบ้านที่เปิดใช้งาน
     * ถ้า table houses ไม่มีคอลัมน์ status/release_status ก็ไม่ต้องใช้เมธอดนี้
     */
    public function activeHouses(): BelongsToMany
    {
        return $this->belongsToMany(House::class, 'house_user', 'user_id', 'house_id')
            ->withTimestamps()
            ->where(function ($query) {
                $query->whereNull('houses.status')
                    ->orWhere('houses.status', 1)
                    ->orWhere('houses.status', '1');
            });
    }

    public function operations(): HasMany
    {
        return $this->hasMany(Operation::class);
    }

    /**
     * คืนค่า id บ้านทั้งหมดที่ user มีสิทธิ์
     * admin = เห็นทุกบ้าน
     */
    public function accessibleHouseIds(): array
    {
        if ($this->isAdmin()) {
            return House::query()
                ->pluck('id')
                ->map(fn ($id) => (int) $id)
                ->toArray();
        }

        $this->loadMissing('houses');

        return $this->houses
            ->pluck('id')
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->values()
            ->toArray();
    }

    /**
     * ตรวจว่าผู้ใช้มีสิทธิ์เข้าถึงบ้านนี้หรือไม่
     */
    public function canAccessHouse(int|string|null $houseId): bool
    {
        if (empty($houseId)) {
            return false;
        }

        if ($this->isAdmin()) {
            return true;
        }

        return in_array((int) $houseId, $this->accessibleHouseIds(), true);
    }

    /**
     * ตรวจว่าผู้ใช้มีบ้านในความดูแลหรือไม่
     */
    public function hasAssignedHouses(): bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        $this->loadMissing('houses');

        return $this->houses->isNotEmpty();
    }

    public function project()
{
    return $this->belongsTo(Project::class);
}

    public function healthcHeckups()
{
    return $this->hasMany(\App\Models\HealthcHeckup::class, 'recorded_by');
}
}