<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    public function definition(): array
    {
        // running number สร้างเลขทะเบียนไม่ซ้ำ
        static $running = 1;

        return [

            /*
            |--------------------------------------------------------------------------
            | ข้อมูลทะเบียน
            |--------------------------------------------------------------------------
            */
            'register_number' =>
                'REG'.str_pad($running++,5,'0',STR_PAD_LEFT),

            /*
            |--------------------------------------------------------------------------
            | Foreign Key อ้างอิง master table
            | ปรับเลขตามข้อมูลจริงในระบบคุณได้ภายหลัง
            |--------------------------------------------------------------------------
            */
            'title_id'      => rand(1,3),
            'national_id'   => 1,
            'religion_id'   => 1,
            'marital_id'    => 1,
            'occupation_id' => 1,
            'income_id'     => 1,
            'education_id'  => 1,

            /*
            |--------------------------------------------------------------------------
            | ข้อมูลผู้รับบริการ
            |--------------------------------------------------------------------------
            */

            // ชื่อเล่นไทย
            'nick_name' => fake()->randomElement([
                'บอย','นัท','ตูน','ออม','เจ','ต้น',
                'ฝน','มด','ปุ้ย','เมย์'
            ]),

            // PATCH: เปลี่ยนจาก fake()->firstName() เป็นชื่อไทย
            'first_name' => fake()->randomElement([
                'สมชาย',
                'วิชัย',
                'ธนา',
                'ปกรณ์',
                'กิตติ',
                'สุชาติ',
                'นภา',
                'อรทัย',
                'สุดา',
                'กมล',
                'ชลธิชา',
                'พิมพ์ชนก'
            ]),

            /*
            PATCH:
            เดิม
            'last_name'=>fake()->lastNameThai(),

            ปรับใหม่ เพราะ method นี้ไม่มีใน Faker
            */
            'last_name' => fake()->randomElement([
                'ใจดี',
                'สุขสวัสดิ์',
                'พรมมา',
                'คำดี',
                'บุญส่ง',
                'วงศ์ไทย',
                'อินทร์แก้ว',
                'ศรีสุข',
                'ทองดี',
                'แสนสุข'
            ]),

            'gender' => fake()->randomElement([
                'male',
                'female'
            ]),

            'birth_date' =>
                fake()->dateTimeBetween('-18 years','-7 years'),

            // เลขบัตรจำลอง 13 หลัก
            'id_card' =>
                fake()->numerify('#############'),

            /*
            |--------------------------------------------------------------------------
            | การศึกษา / ที่อยู่ปัจจุบัน
            |--------------------------------------------------------------------------
            */
            'scholl' => 'โรงเรียน '.fake()->city(),

            'address' => 'บ้านเลขที่ '.rand(1,199),
            'moo'     => rand(1,12),
            'soi'     => 'ซอย '.rand(1,20),
            'road'    => 'ถนน'.fake()->streetName(),
            'village' => 'หมู่บ้าน '.fake()->city(),

            'province_id'      => 1,
            'district_id'      => 1,
            'sub_district_id'  => 1,
            'zipcode'          => 20150,

            'phone' => '08'.rand(10000000,99999999),

            /*
            |--------------------------------------------------------------------------
            | ภูมิลำเนาเดิม
            |--------------------------------------------------------------------------
            */
            'origin_address' => 'บ้านเดิม '.rand(1,200),
            'origin_moo'     => rand(1,10),
            'origin_soi'     => 'ซอย '.rand(1,15),
            'origin_road'    => 'ถนนเดิม',
            'origin_village' => 'หมู่บ้านเดิม',

            'origin_province_id'     => 1,
            'origin_district_id'     => 1,
            'origin_sub_district_id' => 1,
            'origin_zipcode'         => 20150,

            'origin_phone' =>
                '08'.rand(10000000,99999999),

            /*
            |--------------------------------------------------------------------------
            | การรับเข้า
            |--------------------------------------------------------------------------
            */
            'arrival_date'=>
                fake()->dateTimeBetween('-5 years','now'),

            'target_id'  => 1,
            'contact_id' => 1,
            'project_id' => 1,

            /*
            ถ้าต้องการกระจายตามบ้านหลาย house
            เปลี่ยนเป็น rand(1,5)
            */
            'house_id' => rand(1,3),

            'status_id' => 1,

            'case_resident'=>'Active',

            'image'=>null,

            /*
            กระจายสถานะให้สมจริง
            show เยอะกว่า refer
            */
            'release_status' =>
                fake()->randomElement([
                    'show',
                    'show',
                    'show',
                    'pending_refer',
                    'refer'
                ]),

            'created_at'=>now(),
            'updated_at'=>now(),
        ];
    }
}