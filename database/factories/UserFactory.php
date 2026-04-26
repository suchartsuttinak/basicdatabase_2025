<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /*
    |--------------------------------------------------------------------------
    | เก็บ password เดียวกัน
    |--------------------------------------------------------------------------
    */
    protected static ?string $password;


    /*
    |--------------------------------------------------------------------------
    | user จำลอง default
    |--------------------------------------------------------------------------
    */
    public function definition(): array
    {
        return [

            // ชื่อจำลอง
            'name' => fake()->name(),

            // email ไม่ซ้ำ
            'email' => fake()->unique()->safeEmail(),

            'email_verified_at' => now(),

            /*
            PATCH:
            เดิมใช้ password
            login = password
            */
            'password' =>
                static::$password ??= Hash::make('password'),

            'remember_token' => Str::random(10),


            /*
            PATCH เพิ่มให้ตรงระบบคุณ
            ---------------------------------
            role ต้องมี ไม่งั้น middleware role พัง
            */
            'role' => 'general_user',

            /*
            active user
            */
            'status' => 1,

            /*
            ถ้าตาราง users มี house_id บังคับ
            เอาคอมเมนต์ออก
            */
            // 'house_id'=>1,
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | PATCH สร้าง admin ได้โดยตรง
    |--------------------------------------------------------------------------
    */
    public function admin(): static
    {
        return $this->state(fn(array $attributes)=>[
            'name' => 'Admin',
            'email'=> 'admin@gmail.com',
            'password'=>Hash::make('11111111'),
            'role'=>'admin',
            'status'=>1,

            // ถ้ามี house_id required ให้เปิดใช้
            // 'house_id'=>1,
        ]);
    }



    /*
    |--------------------------------------------------------------------------
    | email ไม่ verify
    |--------------------------------------------------------------------------
    */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes)=>[
            'email_verified_at'=>null,
        ]);
    }
}