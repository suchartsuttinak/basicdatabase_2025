@extends('admin_client.admin_client')
@section('content')

<link rel="stylesheet" href="{{ asset('backend/assets/css/style.css') }}">

<style>
    .factfinding-page {
        background: #f4f6f9;
        padding: 12px;
    }

    .factfinding-wrapper {
        background: #fff;
        border: 1px solid #cfd6de;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .05);
        overflow: hidden;
    }

    .factfinding-content {
        padding: 12px;
    }

    .ff-alert {
        margin-bottom: 12px;
        border-radius: 0;
    }

    .ff-main-row {
        --bs-gutter-x: 14px;
        --bs-gutter-y: 14px;
    }

    .ff-card {
        border: 1px solid #cfd6de;
        box-shadow: 0 1px 4px rgba(0, 0, 0, .04);
        border-radius: 0;
        height: 100%;
    }

    .ff-card .card-header {
        background: #f8fafc;
        border-bottom: 1px solid #d9e0e7;
        padding: 10px 12px;
    }

    .ff-card .card-title {
        margin: 0;
        font-size: 19px;
        font-weight: 700;
        color: #355d8c;
    }

    .ff-card .card-body {
        padding: 14px 12px 12px;
    }

    .ff-form-row {
        --bs-gutter-x: 12px;
        --bs-gutter-y: 10px;
    }

    .ff-form-label {
        font-size: 14px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 4px;
        display: inline-block;
    }

    .ff-form-control,
    .ff-form-select,
    .ff-input-group .input-group-text {
        border-radius: 0;
        min-height: 38px;
        font-size: 14px;
    }

    .ff-form-control:focus,
    .ff-form-select:focus {
        border-color: #1d4f91;
        box-shadow: none;
    }

    textarea.ff-form-control {
        min-height: 96px;
        resize: vertical;
    }

    .ff-textarea-sm {
        min-height: 84px;
    }

    .ff-textarea-md {
        min-height: 110px;
    }

    .ff-textarea-lg {
        min-height: 130px;
    }

    .ff-inline-radio {
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
        align-items: center;
        min-height: 38px;
        border: 1px solid #ced4da;
        padding: 6px 10px;
        background: #fff;
    }

    .ff-inline-radio .form-check {
        margin: 0;
    }

    .ff-inline-radio .form-check-label {
        font-size: 14px;
    }

    .ff-detail-box {
        background: #fafbfc;
        border: 1px dashed #cfd6de;
        padding: 10px;
    }

    .ff-unit-input {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .ff-unit-input .unit-text {
        white-space: nowrap;
        font-size: 14px;
        color: #4b5563;
    }

    .ff-checklist-box {
        border: 1px solid #d7dde4;
        background: #fbfcfd;
        padding: 10px;
    }

    .ff-checklist-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(180px, 1fr));
        gap: 10px 14px;
    }

    .ff-check-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 8px 10px;
        border: 1px solid #e5e7eb;
        background: #fff;
        min-height: 48px;
        cursor: pointer;
        margin: 0;
        transition: .15s ease;
    }

    .ff-check-item:hover {
        background: #f7fbff;
        border-color: #b7c8da;
    }

    .ff-check-item input[type="checkbox"] {
        margin-top: 3px;
        flex: 0 0 auto;
    }

    .ff-check-item span {
        font-size: 14px;
        line-height: 1.45;
        color: #1f2937;
        word-break: break-word;
    }

    .ff-submit-wrap {
        display: flex;
        justify-content: flex-start;
        margin-top: 6px;
    }

    .ff-submit-btn {
        min-width: 150px;
        border-radius: 0;
        font-size: 14px;
        font-weight: 600;
    }

    .required-star {
        color: #dc3545;
        font-weight: 700;
    }

    .text-danger,
    .invalid-feedback,
    small.text-danger {
        font-size: 13px;
    }

    @media (max-width: 1199.98px) {
        .ff-checklist-grid {
            grid-template-columns: repeat(2, minmax(180px, 1fr));
        }
    }

    @media (max-width: 991.98px) {
        .factfinding-content {
            padding: 10px;
        }

        .ff-card .card-title {
            font-size: 18px;
        }
    }

    @media (max-width: 767.98px) {
        .factfinding-page {
            padding: 6px;
        }

        .factfinding-content {
            padding: 8px;
        }

        .ff-card .card-header {
            padding: 9px 10px;
        }

        .ff-card .card-body {
            padding: 10px;
        }

        .ff-card .card-title {
            font-size: 16px;
        }

        .ff-form-label {
            font-size: 13px;
        }

        .ff-form-control,
        .ff-form-select,
        .ff-input-group .input-group-text {
            font-size: 13px;
            min-height: 40px;
        }

        .ff-inline-radio {
            gap: 10px;
        }

        .ff-checklist-grid {
            grid-template-columns: 1fr;
        }

        .ff-submit-wrap {
            display: block;
        }

        .ff-submit-btn {
            width: 100%;
        }
    }
</style>

<div class="container-fluid factfinding-page">
    <div class="factfinding-wrapper">

        @if(session('error'))
            <div class="alert alert-danger ff-alert m-3 mb-0">{{ session('error') }}</div>
        @endif

        @if(session('success'))
            <div class="alert alert-success ff-alert m-3 mb-0">{{ session('success') }}</div>
        @endif

        @include('admin_client.include.tabs')

        <div class="factfinding-content">
            <form action="{{ route('factfinding.store') }}" method="POST">
                @csrf
                <input type="hidden" name="client_id" value="{{ $client->id }}">

                <div class="row ff-main-row">
                    {{-- ซ้าย --}}
                    <div class="col-12 col-xl-6">
                        <div class="card ff-card">
                            <div class="card-header">
                                <h4 class="card-title">ข้อมูลการสอบข้อเท็จจริงเบื้องต้น</h4>
                            </div>

                            <div class="card-body">
                                <div class="row ff-form-row">
                                    <div class="col-12 col-md-4">
                                        <label for="date" class="ff-form-label">วันที่นำส่ง <span class="required-star">*</span></label>
                                        <input type="date" name="date" id="date"
                                            class="form-control ff-form-control @error('date') is-invalid @enderror"
                                            value="{{ old('date') }}">
                                        @error('date')
                                            <small class="text-danger" id="date-error">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-12 col-md-8">
                                        <label for="fact_name" class="ff-form-label">ผู้นำส่ง <span class="required-star">*</span></label>
                                        <input type="text" name="fact_name" id="fact_name"
                                            class="form-control ff-form-control @error('fact_name') is-invalid @enderror"
                                            value="{{ old('fact_name') }}">
                                        @error('fact_name')
                                            <div class="invalid-feedback d-block" id="fact_name-error">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label for="appearance" class="ff-form-label">รูปพรรณสัณฐาน</label>
                                        <input type="text" name="appearance" id="appearance"
                                            class="form-control ff-form-control @error('appearance') is-invalid @enderror"
                                            value="{{ old('appearance') }}">
                                        @error('appearance')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label for="skin" class="ff-form-label">สีผิว</label>
                                        <input type="text" name="skin" id="skin"
                                            class="form-control ff-form-control @error('skin') is-invalid @enderror"
                                            value="{{ old('skin') }}">
                                        @error('skin')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label for="scar" class="ff-form-label">ตำหนิ/แผลเป็น</label>
                                        <input type="text" name="scar" id="scar"
                                            class="form-control ff-form-control @error('scar') is-invalid @enderror"
                                            value="{{ old('scar') }}">
                                        @error('scar')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label for="disability" class="ff-form-label">ลักษณะความพิการ</label>
                                        <input type="text" name="disability" id="disability"
                                            class="form-control ff-form-control @error('disability') is-invalid @enderror"
                                            value="{{ old('disability') }}">
                                        @error('disability')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="ff-form-label d-block">ประวัติการเจ็บป่วย <span class="required-star">*</span></label>
                                        <div class="ff-inline-radio">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input @error('sick') is-invalid @enderror"
                                                    type="radio" name="sick" id="sickYes"
                                                    value="1" {{ old('sick') === '1' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="sickYes">มี</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input @error('sick') is-invalid @enderror"
                                                    type="radio" name="sick" id="sickNo"
                                                    value="0" {{ old('sick') === '0' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="sickNo">ไม่มี</label>
                                            </div>
                                        </div>
                                        @error('sick')
                                            <div class="text-danger small mt-1" id="sick-error">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12" id="sickDetailGroup" style="{{ old('sick') == 1 ? '' : 'display:none;' }}">
                                        <div class="ff-detail-box">
                                            <label for="sick_detail" class="ff-form-label">รายละเอียดการเจ็บป่วย <span class="required-star">*</span></label>
                                            <textarea name="sick_detail" id="sick_detail"
                                                class="form-control ff-form-control ff-textarea-sm @error('sick_detail') is-invalid @enderror"
                                                rows="4"
                                                {{ old('sick') == 1 ? 'required' : '' }}>{{ old('sick_detail') }}</textarea>
                                            @error('sick_detail')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label for="treatment" class="ff-form-label">การรักษาพยาบาล</label>
                                        <input type="text" name="treatment" id="treatment"
                                            class="form-control ff-form-control @error('treatment') is-invalid @enderror"
                                            value="{{ old('treatment') }}">
                                        @error('treatment')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label for="hospital" class="ff-form-label">สถานพยาบาล</label>
                                        <input type="text" name="hospital" id="hospital"
                                            class="form-control ff-form-control @error('hospital') is-invalid @enderror"
                                            value="{{ old('hospital') }}">
                                        @error('hospital')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12 col-md-4">
                                        <label for="blood_group" class="ff-form-label">กรุ๊ปเลือด</label>
                                        <select name="blood_group" id="blood_group"
                                            class="form-select ff-form-select @error('blood_group') is-invalid @enderror">
                                            <option value="">-- กรุณาเลือกกรุ๊ปเลือด --</option>
                                            <option value="A" {{ old('blood_group') == 'A' ? 'selected' : '' }}>A</option>
                                            <option value="B" {{ old('blood_group') == 'B' ? 'selected' : '' }}>B</option>
                                            <option value="AB" {{ old('blood_group') == 'AB' ? 'selected' : '' }}>AB</option>
                                            <option value="O" {{ old('blood_group') == 'O' ? 'selected' : '' }}>O</option>
                                            <option value="ไม่ระบุ" {{ old('blood_group') == 'ไม่ระบุ' ? 'selected' : '' }}>ไม่ระบุ</option>
                                        </select>
                                        @error('blood_group')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12 col-md-4">
                                        <label for="weight" class="ff-form-label">น้ำหนัก</label>
                                        <div class="ff-unit-input">
                                            <input type="text" name="weight" id="weight"
                                                class="form-control ff-form-control @error('weight') is-invalid @enderror"
                                                value="{{ old('weight') }}">
                                            <span class="unit-text">กิโลกรัม</span>
                                        </div>
                                        @error('weight')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12 col-md-4">
                                        <label for="height" class="ff-form-label">ส่วนสูง</label>
                                        <div class="ff-unit-input">
                                            <input type="text" name="height" id="height"
                                                class="form-control ff-form-control @error('height') is-invalid @enderror"
                                                value="{{ old('height') }}">
                                            <span class="unit-text">เซนติเมตร</span>
                                        </div>
                                        @error('height')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label for="hygiene" class="ff-form-label">ความสะอาดร่างกาย</label>
                                        <input type="text" name="hygiene" id="hygiene"
                                            class="form-control ff-form-control @error('hygiene') is-invalid @enderror"
                                            value="{{ old('hygiene') }}">
                                        @error('hygiene')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label for="oral_health" class="ff-form-label">สุขภาพช่องปาก</label>
                                        <input type="text" name="oral_health" id="oral_health"
                                            class="form-control ff-form-control @error('oral_health') is-invalid @enderror"
                                            value="{{ old('oral_health') }}">
                                        @error('oral_health')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label for="injury" class="ff-form-label">การบาดเจ็บ/บาดแผล</label>
                                        <input type="text" name="injury" id="injury"
                                            class="form-control ff-form-control @error('injury') is-invalid @enderror"
                                            value="{{ old('injury') }}">
                                        @error('injury')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label for="marital_id" class="ff-form-label">สถานะการสมรส <span class="required-star">*</span></label>
                                        <select name="marital_id" id="marital_id"
                                            class="form-select ff-form-select @error('marital_id') is-invalid @enderror">
                                            <option value="">--สถานะการสมรส--</option>
                                            @foreach ($maritals as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ old('marital_id') == $item->id ? 'selected' : '' }}>
                                                    {{ $item->marital_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('marital_id')
                                            <div class="invalid-feedback d-block" id="marital_id-error">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="relation_parent" class="ff-form-label">ความสัมพันธ์ระหว่างบิดา/มารดา</label>
                                        <textarea name="relation_parent" id="relation_parent"
                                            class="form-control ff-form-control ff-textarea-sm @error('relation_parent') is-invalid @enderror"
                                            rows="3">{{ old('relation_parent') }}</textarea>
                                        @error('relation_parent')
                                            <div class="invalid-feedback d-block" id="relation_parent-error">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="relation_family" class="ff-form-label">ความสัมพันธ์ระหว่างบุคคลในครอบครัว</label>
                                        <textarea name="relation_family" id="relation_family"
                                            class="form-control ff-form-control ff-textarea-sm @error('relation_family') is-invalid @enderror"
                                            rows="3">{{ old('relation_family') }}</textarea>
                                        @error('relation_family')
                                            <div class="invalid-feedback d-block" id="relation_family-error">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="relation_child" class="ff-form-label">ความสัมพันธ์ระหว่างเด็กกับบุคคลในครอบครัว</label>
                                        <textarea name="relation_child" id="relation_child"
                                            class="form-control ff-form-control ff-textarea-sm @error('relation_child') is-invalid @enderror"
                                            rows="3">{{ old('relation_child') }}</textarea>
                                        @error('relation_child')
                                            <div class="invalid-feedback d-block" id="relation_child-error">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="evidence" class="ff-form-label">เอกสารเพิ่มเติม</label>
                                        <input type="text" name="evidence" id="evidence"
                                            class="form-control ff-form-control @error('evidence') is-invalid @enderror"
                                            value="{{ old('evidence') }}">
                                        @error('evidence')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="ff-form-label fw-bold text-dark">
                                            เอกสารที่เกี่ยวข้อง
                                            <span class="required-star">* (เลือกได้มากกว่า 1 รายการ)</span>
                                        </label>

                                        <div class="ff-checklist-box">
                                            <div class="ff-checklist-grid">
                                                @foreach($documents as $document)
                                                    <label for="document{{ $document->id }}" class="ff-check-item">
                                                        <input type="checkbox"
                                                            name="documents[]"
                                                            value="{{ $document->id }}"
                                                            id="document{{ $document->id }}"
                                                            {{ is_array(old('documents')) && in_array($document->id, old('documents')) ? 'checked' : '' }}>
                                                        <span>{{ $document->document_name }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ขวา --}}
                    <div class="col-12 col-xl-6">
                        <div class="card ff-card">
                            <div class="card-header">
                                <h4 class="card-title">การประเมินสภาวะเด็กและครอบครัว</h4>
                            </div>

                            <div class="card-body">
                                <div class="row ff-form-row">
                                    <div class="col-12">
                                        <label for="ex_conditions" class="ff-form-label">สภาพที่อยู่อาศัยภายนอก</label>
                                        <textarea name="ex_conditions" id="ex_conditions"
                                            class="form-control ff-form-control ff-textarea-sm @error('ex_conditions') is-invalid @enderror"
                                            rows="3">{{ old('ex_conditions') }}</textarea>
                                        @error('ex_conditions')
                                            <div class="invalid-feedback d-block" id="ex_conditions-error">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="in_conditions" class="ff-form-label">สภาพที่อยู่อาศัยภายใน</label>
                                        <textarea name="in_conditions" id="in_conditions"
                                            class="form-control ff-form-control ff-textarea-sm @error('in_conditions') is-invalid @enderror"
                                            rows="3">{{ old('in_conditions') }}</textarea>
                                        @error('in_conditions')
                                            <div class="invalid-feedback d-block" id="in_conditions-error">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="environment" class="ff-form-label">สภาพแวดล้อม</label>
                                        <textarea name="environment" id="environment"
                                            class="form-control ff-form-control ff-textarea-md @error('environment') is-invalid @enderror"
                                            rows="4">{{ old('environment') }}</textarea>
                                        @error('environment')
                                            <div class="invalid-feedback d-block" id="environment-error">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="cause_problem" class="ff-form-label">สาเหตุที่เข้ารับการสงเคราะห์</label>
                                        <textarea name="cause_problem" id="cause_problem"
                                            class="form-control ff-form-control ff-textarea-sm @error('cause_problem') is-invalid @enderror"
                                            rows="3">{{ old('cause_problem') }}</textarea>
                                        @error('cause_problem')
                                            <div class="invalid-feedback d-block" id="cause_problem-error">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="need" class="ff-form-label">ความต้องการความช่วยเหลือ</label>
                                        <textarea name="need" id="need"
                                            class="form-control ff-form-control ff-textarea-sm @error('need') is-invalid @enderror"
                                            rows="3">{{ old('need') }}</textarea>
                                        @error('need')
                                            <div class="invalid-feedback d-block" id="need-error">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="case_history" class="ff-form-label">ประวัติความเป็นมา</label>
                                        <textarea name="case_history" id="case_history"
                                            class="form-control ff-form-control ff-textarea-md @error('case_history') is-invalid @enderror"
                                            rows="4">{{ old('case_history') }}</textarea>
                                        @error('case_history')
                                            <div class="invalid-feedback d-block" id="case_history-error">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="information" class="ff-form-label">ข้อเท็จจริงอื่นๆ</label>
                                        <textarea name="information" id="information"
                                            class="form-control ff-form-control ff-textarea-md @error('information') is-invalid @enderror"
                                            rows="4">{{ old('information') }}</textarea>
                                        @error('information')
                                            <div class="invalid-feedback d-block" id="information-error">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="diagnosis" class="ff-form-label">การวินิจฉัยปัญหา</label>
                                        <textarea name="diagnosis" id="diagnosis"
                                            class="form-control ff-form-control ff-textarea-md @error('diagnosis') is-invalid @enderror"
                                            rows="4">{{ old('diagnosis') }}</textarea>
                                        @error('diagnosis')
                                            <div class="invalid-feedback d-block" id="diagnosis-error">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12 col-md-4">
                                        <label for="receive_date" class="ff-form-label">วันที่บันทึก <span class="required-star">*</span></label>
                                        <input type="date" name="receive_date" id="receive_date"
                                            class="form-control ff-form-control @error('receive_date') is-invalid @enderror"
                                            value="{{ old('receive_date') }}">
                                        @error('receive_date')
                                            <small class="text-danger" id="receive_date-error">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-12 col-md-8">
                                        <label for="recorder" class="ff-form-label">ชื่อผู้บันทึก <span class="required-star">*</span></label>
                                        <input type="text" name="recorder" id="recorder"
                                            class="form-control ff-form-control @error('recorder') is-invalid @enderror"
                                            value="{{ old('recorder') }}">
                                        @error('recorder')
                                            <small class="text-danger" id="recorder-error">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <div class="ff-submit-wrap">
                                            <button type="submit" class="btn btn-success ff-submit-btn">บันทึกข้อมูล</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>{{-- end right --}}
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const yes = document.getElementById('sickYes');
    const no = document.getElementById('sickNo');
    const detail = document.getElementById('sickDetailGroup');
    const detailField = document.getElementById('sick_detail');

    function toggleDetail() {
        if (yes.checked) {
            detail.style.display = '';
            detailField.setAttribute('required', 'required');
        } else {
            detail.style.display = 'none';
            detailField.removeAttribute('required');
            detailField.value = '';
        }
    }

    yes.addEventListener('change', toggleDetail);
    no.addEventListener('change', toggleDetail);
    toggleDetail();
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('input[name="sick"]').forEach(function(radio) {
        radio.addEventListener('change', function() {
            const errorMsg = document.getElementById('sick-error');
            if (errorMsg) errorMsg.remove();
            document.querySelectorAll('input[name="sick"]').forEach(function(r) {
                r.classList.remove('is-invalid');
            });
        });
    });

    const fieldMap = [
        ['date', 'date-error'],
        ['receive_date', 'receive_date-error'],
        ['recorder', 'recorder-error'],
        ['fact_name', 'fact_name-error'],
        ['case_history', 'case_history-error'],
        ['marital_id', 'marital_id-error']
    ];

    fieldMap.forEach(function(item) {
        const input = document.getElementById(item[0]);
        if (!input) return;

        input.addEventListener('input', function() {
            const errorMsg = document.getElementById(item[1]);
            if (errorMsg) errorMsg.remove();
            this.classList.remove('is-invalid');
        });

        input.addEventListener('change', function() {
            const errorMsg = document.getElementById(item[1]);
            if (errorMsg) errorMsg.remove();
            this.classList.remove('is-invalid');
        });
    });

    const sickDetail = document.getElementById('sick_detail');
    if (sickDetail) {
        sickDetail.addEventListener('input', function() {
            const errorMsg = this.parentElement.querySelector('.text-danger');
            if (errorMsg) errorMsg.remove();
            this.classList.remove('is-invalid');
        });
    }
});
</script>

@endsection