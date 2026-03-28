<?php

namespace App\Http\Requests\Client\Absent;

use Illuminate\Foundation\Http\FormRequest;

class StoreAbsentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'client_id'           => 'required|integer|exists:clients,id',
            'education_record_id' => 'nullable|integer',
            'absent_date'         => 'required|date',
            'record_date'         => 'required|date',
            'cause'               => 'required|string|max:255',
            'operation'           => 'nullable|string|max:255',
            'remark'              => 'nullable|string|max:500',
            'teacher'             => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'client_id.required'   => 'กรุณาระบุรหัสเด็ก',
            'client_id.exists'     => 'ไม่พบข้อมูลเด็กในระบบ',
            'absent_date.required' => 'กรุณาเลือกวันที่ขาดเรียน',
            'record_date.required' => 'กรุณาเลือกวันที่บันทึกข้อมูล',
            'cause.required'       => 'กรุณาระบุสาเหตุที่ขาดเรียน',
            'teacher.required'     => 'กรุณากรอกชื่อผู้ดูแลเด็ก',
        ];
    }
}