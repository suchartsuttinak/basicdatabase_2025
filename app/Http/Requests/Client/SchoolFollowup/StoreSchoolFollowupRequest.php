<?php

namespace App\Http\Requests\Client\SchoolFollowup;

use Illuminate\Foundation\Http\FormRequest;

class StoreSchoolFollowupRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'client_id' => ['required', 'integer', 'exists:clients,id'],
            'education_record_id' => ['nullable', 'integer', 'exists:education_records,id'],
            'follow_date' => ['required', 'date'],
            'teacher_name' => ['nullable', 'string', 'max:255'],
            'tel' => ['nullable', 'string', 'max:20'],
            'follow_type' => ['required', 'string', 'in:self,phone,other'],
            'result' => ['required', 'string', 'max:255'],
            'remark' => ['nullable', 'string'],
            'contact_name' => ['required', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'client_id.required' => 'กรุณาเลือกเด็กนักเรียน',
            'client_id.integer' => 'รหัสนักเรียนต้องเป็นตัวเลข',
            'client_id.exists' => 'ไม่พบข้อมูลนักเรียนที่เลือก',

            'education_record_id.integer' => 'รหัสข้อมูลการศึกษาไม่ถูกต้อง',
            'education_record_id.exists' => 'ไม่พบข้อมูลการศึกษาที่เลือก',

            'follow_date.required' => 'กรุณาระบุวันที่ติดตาม',
            'follow_date.date' => 'วันที่ติดตามไม่ถูกต้อง',

            'teacher_name.max' => 'ชื่อครูต้องไม่เกิน 255 ตัวอักษร',
            'tel.max' => 'เบอร์โทรศัพท์ต้องไม่เกิน 20 ตัวอักษร',

            'follow_type.required' => 'กรุณาเลือกวิธีการติดตาม',
            'follow_type.in' => 'วิธีการติดตามไม่ถูกต้อง',

            'result.required' => 'กรุณาระบุผลการติดตาม',
            'result.max' => 'ผลการติดตามต้องไม่เกิน 255 ตัวอักษร',

            'contact_name.required' => 'กรุณาระบุชื่อผู้ติดตาม',
            'contact_name.max' => 'ชื่อผู้ติดตามต้องไม่เกิน 255 ตัวอักษร',
        ];
    }
}