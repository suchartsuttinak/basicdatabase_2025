<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    protected $signature = 'user:create-admin';
    protected $description = 'Create admin user';

    public function handle()
    {
        $name = 'suchart';
        $email = 'suchart@gmail.com';
        $password = '11111111';

        // ป้องกันซ้ำ
        if (User::where('email', $email)->exists()) {
            $this->error('อีเมลนี้มีอยู่แล้ว');
            return;
        }

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'admin',
            'status' => '1',
        ]);

        $this->info('สร้าง admin สำเร็จ: ' . $user->email);
    }
}