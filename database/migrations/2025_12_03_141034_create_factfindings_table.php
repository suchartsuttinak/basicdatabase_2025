<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run migrations
     */
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | PATCH: กันสร้างตารางซ้ำ
        |--------------------------------------------------------------------------
        */
        if (!Schema::hasTable('factfindings')) {

            Schema::create('factfindings', function (Blueprint $table) {

                $table->id();

                /*
                |--------------------------------------------------------------------------
                | ข้อมูลเบื้องต้น
                |--------------------------------------------------------------------------
                */
                $table->date('date')->comment('วันที่นำส่ง');
                $table->date('receive_date')->nullable()->comment('วันที่บันทึกข้อมูล');

                $table->string('fact_name')->nullable()->comment('ชื่อผู้นำส่ง');
                $table->string('evidence')->nullable()->comment('หลักฐานเพิ่มเติม');

                /*
                |--------------------------------------------------------------------------
                | ข้อมูลร่างกาย / สุขภาพ
                |--------------------------------------------------------------------------
                */
                $table->string('appearance')->nullable()->comment('รูปพรรณสัณฐาน');
                $table->string('skin')->nullable()->comment('สีผิว');
                $table->string('scar')->nullable()->comment('ตำหนิ/แผลเป็น');
                $table->string('disability')->nullable()->comment('ลักษณะความพิการ');

                $table->boolean('sick')
                      ->default(false)
                      ->comment('ป่วย 1=yes 0=no');

                $table->text('sick_detail')->nullable()->comment('รายละเอียดการเจ็บป่วย');

                $table->string('treatment')->nullable()->comment('การรักษา');
                $table->string('hospital')->nullable()->comment('โรงพยาบาล');

                $table->decimal('weight',5,2)->nullable()->comment('น้ำหนัก');
                $table->decimal('height',5,2)->nullable()->comment('ส่วนสูง');

                $table->string('blood_group')->nullable()->comment('กรุ๊ปเลือด');
                $table->string('hygiene')->nullable()->comment('ความสะอาด');
                $table->string('oral_health')->nullable()->comment('สุขภาพช่องปาก');
                $table->string('injury')->nullable()->comment('การบาดเจ็บ');

                /*
                |--------------------------------------------------------------------------
                | สถานภาพครอบครัว
                |--------------------------------------------------------------------------
                */
                $table->unsignedBigInteger('marital_id');

                $table->text('relation_parent')
                      ->nullable()
                      ->comment('ความสัมพันธ์บิดามารดา');

                $table->text('relation_family')
                      ->nullable()
                      ->comment('ความสัมพันธ์ในครอบครัว');

                $table->text('relation_child')
                      ->nullable()
                      ->comment('ความสัมพันธ์เด็กกับครอบครัว');

                /*
                |--------------------------------------------------------------------------
                | การประเมินสภาพแวดล้อม
                |--------------------------------------------------------------------------
                */
                $table->text('ex_conditions')
                      ->nullable()
                      ->comment('สภาพที่อยู่อาศัยภายนอก');

                $table->text('in_conditions')
                      ->nullable()
                      ->comment('สภาพที่อยู่อาศัยภายใน');

                $table->text('environment')
                      ->nullable()
                      ->comment('สภาพแวดล้อม');

                $table->text('cause_problem')
                      ->nullable()
                      ->comment('สาเหตุของปัญหา');

                $table->text('need')
                      ->nullable()
                      ->comment('ความต้องการ');

                $table->text('information')
                      ->nullable()
                      ->comment('ข้อเท็จจริงอื่น');

                $table->text('diagnosis')
                      ->nullable()
                      ->comment('การวินิจฉัยปัญหา');

                $table->text('case_history')
                      ->nullable()
                      ->comment('ประวัติความเป็นมา');

                /*
                |--------------------------------------------------------------------------
                | ผู้บันทึก (รองรับ auto จาก auth user)
                |--------------------------------------------------------------------------
                */
                $table->string('recorder')
                      ->nullable()
                      ->comment('ผู้บันทึก');

                /*
                |--------------------------------------------------------------------------
                | One-to-One Client
                |--------------------------------------------------------------------------
                */
                $table->unsignedBigInteger('client_id')->unique();

                $table->foreign('client_id')
                    ->references('id')
                    ->on('clients')
                    ->onDelete('cascade');

                /*
                |--------------------------------------------------------------------------
                | FK สถานภาพสมรส
                |--------------------------------------------------------------------------
                */
                $table->foreign('marital_id')
                    ->references('id')
                    ->on('maritals')
                    ->onDelete('restrict');

                /*
                |--------------------------------------------------------------------------
                | สถานะ
                |--------------------------------------------------------------------------
                */
                $table->boolean('active')
                      ->default(true)
                      ->comment('สถานะใช้งาน');

                $table->timestamps();

            });
        }
    }

    /**
     * Reverse migrations
     */
    public function down(): void
    {
        Schema::dropIfExists('factfindings');
    }
};