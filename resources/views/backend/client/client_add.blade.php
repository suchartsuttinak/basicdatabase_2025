@extends('admin.admin_master')
@section('admin')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<link rel="stylesheet" href="{{ asset('backend/assets/css/style.css') }}">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    .registry-page {
        background: #f5f6f8;
        padding: 12px;
    }

    .registry-wrapper {
        background: #fff;
        border: 1px solid #bfc7d1;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.06);
        overflow: hidden;
    }

    .registry-header {
        background: #234f87;
        color: #fff;
        text-align: center;
        font-size: 30px;
        font-weight: 700;
        line-height: 1.1;
        padding: 10px 15px;
        font-family: "TH Sarabun New", "Sarabun", Tahoma, sans-serif;
    }

    .registry-topnav {
        background: #234f87;
        border-top: 1px solid rgba(255,255,255,.15);
        border-bottom: 1px solid #c8d0da;
        display: flex;
        flex-wrap: wrap;
    }

    .registry-topnav a {
        color: #fff;
        text-decoration: none;
        padding: 8px 18px;
        font-size: 14px;
        border-right: 1px solid rgba(255,255,255,.15);
        transition: .2s ease;
    }

    .registry-topnav a:hover,
    .registry-topnav a.active {
        background: rgba(255,255,255,.12);
    }

    .registry-subnav {
        background: #f1f1f1;
        border-bottom: 1px solid #cfd5dc;
        padding: 0 8px;
        display: flex;
        flex-wrap: wrap;
        gap: 2px;
    }

    .registry-subnav a {
        color: #333;
        text-decoration: none;
        padding: 8px 10px;
        font-size: 14px;
        border-top: 2px solid transparent;
    }

    .registry-subnav a.active {
        background: #fff;
        border: 1px solid #d4d8dd;
        border-bottom-color: #fff;
        border-top: 2px solid #234f87;
        margin-bottom: -1px;
    }

    .registry-body {
        padding: 12px;
    }

    .panel-box {
        border: 1px solid #c9ced6;
        background: #fff;
        margin-bottom: 12px;
        padding: 10px 12px;
    }

    .panel-title {
        font-size: 20px;
        font-weight: 700;
        color: #486b97;
        margin-bottom: 8px;
        font-family: "TH Sarabun New", "Sarabun", Tahoma, sans-serif;
        line-height: 1;
    }

    .compact-row {
        --bs-gutter-x: 10px;
        --bs-gutter-y: 6px;
    }

    .form-label {
        font-size: 14px;
        font-weight: 600;
        color: #444;
        margin-bottom: 3px;
    }

    .form-control,
    .form-select {
        width: 100%;
        min-height: 34px;
        height: 34px;
        padding: 4px 8px;
        font-size: 14px;
        border-radius: 0;
        border-color: #bfc5cc;
        box-shadow: none !important;
    }

    textarea.form-control {
        min-height: 80px;
        height: auto;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #234f87;
    }

    .inline-radio-group {
        display: flex;
        align-items: center;
        gap: 14px;
        min-height: 34px;
        border: 1px solid #bfc5cc;
        padding: 0 10px;
        background: #fff;
        flex-wrap: wrap;
    }

    .inline-radio-group .form-check {
        margin: 0;
    }

    .inline-radio-group .form-check-label {
        font-size: 14px;
        margin-left: 2px;
    }

    .photo-box {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
        height: 100%;
    }

    .photo-preview {
        width: 110px;
        height: 130px;
        object-fit: cover;
        border: 1px solid #8e99a7;
        background: #fff;
        padding: 2px;
        display: block;
    }

    .photo-btn {
        border-radius: 0;
        font-size: 13px;
        padding: 4px 10px;
        margin-top: 8px;
        white-space: nowrap;
    }

   .problem-full-width{
    width: 100%;
}

.problem-box{
    border: 1px solid #c9ced6;
    background: #fcfcfc;
    padding: 10px;
    width: 100%;
}

.problem-grid{
    display: grid;
    grid-template-columns: repeat(3, minmax(180px, 1fr));
    gap: 10px 14px;
    width: 100%;
}

.problem-item{
    display: flex;
    align-items: flex-start;
    gap: 10px;
    padding: 8px 10px;
    border: 1px solid #e1e5ea;
    background: #fff;
    cursor: pointer;
    min-height: 48px;
    margin: 0;
    transition: all .2s ease;
}

.problem-item:hover{
    border-color: #9fb3c8;
    background: #f8fbff;
}

.problem-item input[type="checkbox"]{
    margin-top: 3px;
    flex: 0 0 auto;
}

.problem-item span{
    font-size: 14px;
    line-height: 1.45;
    color: #222;
    word-break: break-word;
}

.problem-item:has(input:checked){
    border-color: #234f87;
    background: #eef4fb;
}

@media (max-width: 991.98px){
    .problem-grid{
        grid-template-columns: repeat(2, minmax(180px, 1fr));
    }
}

@media (max-width: 575.98px){
    .problem-grid{
        grid-template-columns: 1fr;
    }

    .problem-item{
        min-height: auto;
        padding: 8px 10px;
    }

    .problem-item span{
        font-size: 13px;
        line-height: 1.4;
    }
}

    .address-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    .copy-check {
        margin-bottom: 8px;
    }

    .copy-check label {
        font-size: 14px;
        color: #234f87;
        font-weight: 600;
    }

    .action-bar {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 10px;
    }

    .btn-registry {
        min-width: 130px;
        border-radius: 0;
        font-size: 14px;
    }

    .required-star {
        color: #dc3545;
        font-weight: 700;
    }

    .error-message,
    .invalid-feedback,
    .text-danger {
        font-size: 13px;
    }

    .client-main-row {
        align-items: flex-start;
    }

    .client-form-col,
    .client-photo-col {
        width: 100%;
    }

    @media (max-width: 1199.98px) {
        .registry-header {
            font-size: 26px;
        }
    }

    @media (max-width: 991.98px) {
        .client-main-row {
            flex-direction: column;
        }

        .client-photo-col {
            margin-top: 12px;
        }

        .photo-box {
            border-top: 1px dashed #c9ced6;
            padding-top: 12px;
        }

        .address-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 767.98px) {
        .registry-page {
            padding: 6px;
        }

        .registry-body {
            padding: 8px;
        }

        .registry-header {
            font-size: 22px;
            padding: 10px;
        }

        .registry-topnav a,
        .registry-subnav a {
            width: 100%;
            border-right: 0;
            border-bottom: 1px solid rgba(255,255,255,.15);
        }

        .panel-box {
            padding: 8px;
        }

        .form-label {
            font-size: 13px;
        }

        .form-control,
        .form-select {
            font-size: 13px;
            min-height: 36px;
            height: 36px;
        }

        .inline-radio-group {
            min-height: 36px;
            gap: 10px;
        }

        .photo-preview {
            width: 120px;
            height: 140px;
        }

        .problem-box .row > div {
            width: 100%;
        }
    }
</style>

<div class="container-fluid registry-page">
    <div class="registry-wrapper">

        <div class="registry-header">
            ทะเบียนประวัติผู้รับฯ
        </div>

        <div class="registry-body">
            <form action="{{ route('client.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- ข้อมูลผู้รับ --}}
                <div class="panel-box">
                    <div class="row compact-row">
                        <div class="col-lg-10">
                            <div class="row compact-row">
                                <div class="col-md-3">
                                    <label for="register_number" class="form-label">เลขที่ผู้รับ</label>
                                    <input type="text" name="register_number" id="register_number"
                                        class="form-control @error('register_number') is-invalid @enderror"
                                        value="{{ old('register_number') }}">
                                    @error('register_number')
                                        <small class="text-danger error-message" id="error-register_number">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-5">
                                    <label for="id_card" class="form-label">เลขประจำตัวประชาชน</label>
                                    <input type="text" name="id_card" id="id_card"
                                        class="form-control @error('id_card') is-invalid @enderror"
                                        value="{{ old('id_card') }}">
                                    @error('id_card')
                                        <small class="text-danger error-message" id="error-id_card">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-2">
                                    <label for="title_id" class="form-label">คำนำหน้า</label>
                                    <select name="title_id" id="title_id"
                                        class="form-select @error('title_id') is-invalid @enderror">
                                        <option value="">--เลือก--</option>
                                        @foreach ($titles as $item)
                                            <option value="{{ $item->id }}" {{ old('title_id') == $item->id ? 'selected' : '' }}>
                                                {{ $item->title_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('title_id')
                                        <small class="text-danger error-message" id="error-title_id">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-2">
                                    <label for="nick_name" class="form-label">ชื่อเล่น</label>
                                    <input type="text" name="nick_name" id="nick_name" class="form-control"
                                        value="{{ old('nick_name') }}">
                                </div>

                                <div class="col-md-3">
                                    <label for="first_name" class="form-label">ชื่อ <span class="required-star">*</span></label>
                                    <input type="text" name="first_name" id="first_name"
                                        class="form-control @error('first_name') is-invalid @enderror"
                                        value="{{ old('first_name') }}">
                                    @error('first_name')
                                        <small class="text-danger error-message" id="error-first_name">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label for="last_name" class="form-label">นามสกุล <span class="required-star">*</span></label>
                                    <input type="text" name="last_name" id="last_name"
                                        class="form-control @error('last_name') is-invalid @enderror"
                                        value="{{ old('last_name') }}">
                                    @error('last_name')
                                        <small class="text-danger error-message" id="error-last_name">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label">เพศ <span class="required-star">*</span></label>
                                    <div class="inline-radio-group @error('gender') is-invalid @enderror">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" id="genderMale"
                                                value="male" {{ old('gender') == 'male' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="genderMale">ชาย</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" id="genderFemale"
                                                value="female" {{ old('gender') == 'female' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="genderFemale">หญิง</label>
                                        </div>
                                    </div>
                                    @error('gender')
                                        <small class="text-danger d-block error-message" id="error-gender">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-2">
                                    <label for="birth_date" class="form-label">เกิดวันที่ <span class="required-star">*</span></label>
                                    <input type="date" name="birth_date" id="birth_date"
                                        class="form-control @error('birth_date') is-invalid @enderror"
                                        value="{{ old('birth_date') }}">
                                    @error('birth_date')
                                        <small class="text-danger error-message" id="error-birth_date">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-2">
                                    <label for="national_id" class="form-label">สัญชาติ <span class="required-star">*</span></label>
                                    <select name="national_id" id="national_id"
                                        class="form-select @error('national_id') is-invalid @enderror">
                                        <option value="">--เลือก--</option>
                                        @foreach ($nations as $item)
                                            <option value="{{ $item->id }}" {{ old('national_id') == $item->id ? 'selected' : '' }}>
                                                {{ $item->national_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('national_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-2">
                                    <label for="religion_id" class="form-label">ศาสนา <span class="required-star">*</span></label>
                                    <select name="religion_id" id="religion_id"
                                        class="form-select @error('religion_id') is-invalid @enderror">
                                        <option value="">--เลือก--</option>
                                        @foreach ($religions as $item)
                                            <option value="{{ $item->id }}" {{ old('religion_id') == $item->id ? 'selected' : '' }}>
                                                {{ $item->religion_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('religion_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label for="marital_id" class="form-label">สถานภาพการสมรส <span class="required-star">*</span></label>
                                    <select name="marital_id" id="marital_id"
                                        class="form-select @error('marital_id') is-invalid @enderror">
                                        <option value="">--เลือก--</option>
                                        @foreach ($maritals as $item)
                                            <option value="{{ $item->id }}" {{ old('marital_id') == $item->id ? 'selected' : '' }}>
                                                {{ $item->marital_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('marital_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label for="occupation_id" class="form-label">ประกอบอาชีพ <span class="required-star">*</span></label>
                                    <select name="occupation_id" id="occupation_id"
                                        class="form-select @error('occupation_id') is-invalid @enderror">
                                        <option value="">--เลือก--</option>
                                        @foreach ($occupations as $item)
                                            <option value="{{ $item->id }}" {{ old('occupation_id') == $item->id ? 'selected' : '' }}>
                                                {{ $item->occupation_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('occupation_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label for="income_id" class="form-label">รายได้เฉลี่ย/เดือน <span class="required-star">*</span></label>
                                    <select name="income_id" id="income_id"
                                        class="form-select @error('income_id') is-invalid @enderror">
                                        <option value="">--เลือก--</option>
                                        @foreach ($incomes as $item)
                                            <option value="{{ $item->id }}" {{ old('income_id') == $item->id ? 'selected' : '' }}>
                                                {{ $item->income_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('income_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label for="education_id" class="form-label">ระดับการศึกษา <span class="required-star">*</span></label>
                                    <select name="education_id" id="education_id"
                                        class="form-select @error('education_id') is-invalid @enderror">
                                        <option value="">--เลือก--</option>
                                        @foreach ($educations as $item)
                                            <option value="{{ $item->id }}" {{ old('education_id') == $item->id ? 'selected' : '' }}>
                                                {{ $item->education_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('education_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="scholl" class="form-label">โรงเรียน/สถาบัน</label>
                                    <input type="text" name="scholl" id="scholl" class="form-control"
                                        value="{{ old('scholl') }}">
                                    @error('scholl')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="target_id" class="form-label">กลุ่มเป้าหมาย <span class="required-star">*</span></label>
                                    <select name="target_id" id="target_id"
                                        class="form-select @error('target_id') is-invalid @enderror">
                                        <option value="">--เลือก--</option>
                                        @foreach ($targets as $item)
                                            <option value="{{ $item->id }}" {{ old('target_id') == $item->id ? 'selected' : '' }}>
                                                {{ $item->target_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('target_id')
                                        <small class="text-danger error-message" id="error-target_id">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="contact_id" class="form-label">วิธีการติดต่อ <span class="required-star">*</span></label>
                                    <select name="contact_id" id="contact_id"
                                        class="form-select @error('contact_id') is-invalid @enderror">
                                        <option value="">--เลือก--</option>
                                        @foreach ($contacts as $item)
                                            <option value="{{ $item->id }}" {{ old('contact_id') == $item->id ? 'selected' : '' }}>
                                                {{ $item->contact_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('contact_id')
                                        <small class="text-danger error-message" id="error-contact_id">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="project_id" class="form-label">หน่วยงาน <span class="required-star">*</span></label>
                                    <select name="project_id" id="project_id"
                                        class="form-select @error('project_id') is-invalid @enderror">
                                        <option value="">--เลือก--</option>
                                        @foreach ($projects as $item)
                                            <option value="{{ $item->id }}" {{ old('project_id') == $item->id ? 'selected' : '' }}>
                                                {{ $item->project_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('project_id')
                                        <small class="text-danger error-message" id="error-project_id">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="house_id" class="form-label">สถานที่พักอาศัย <span class="required-star">*</span></label>
                                    <select name="house_id" id="house_id"
                                        class="form-select @error('house_id') is-invalid @enderror">
                                        <option value="">--เลือก--</option>
                                        @foreach ($houses as $item)
                                            <option value="{{ $item->id }}" {{ old('house_id') == $item->id ? 'selected' : '' }}>
                                                {{ $item->house_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('house_id')
                                        <small class="text-danger error-message" id="error-house_id">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="status_id" class="form-label">สถานะผู้เข้ารับ <span class="required-star">*</span></label>
                                    <select name="status_id" id="status_id"
                                        class="form-select @error('status_id') is-invalid @enderror">
                                        <option value="">--เลือก--</option>
                                        @foreach ($statuses as $item)
                                            <option value="{{ $item->id }}" {{ old('status_id') == $item->id ? 'selected' : '' }}>
                                                {{ $item->status_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('status_id')
                                        <small class="text-danger error-message" id="error-status_id">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label for="arrival_date" class="form-label">วันที่รับเข้า <span class="required-star">*</span></label>
                                    <input type="date" name="arrival_date" id="arrival_date"
                                        class="form-control @error('arrival_date') is-invalid @enderror"
                                        value="{{ old('arrival_date') }}">
                                    @error('arrival_date')
                                        <small class="text-danger error-message" id="error-arrival_date">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label for="case_resident" class="form-label">สถานะอยู่อาศัย <span class="required-star">*</span></label>
                                    <select name="case_resident" id="case_resident"
                                        class="form-select @error('case_resident') is-invalid @enderror">
                                        <option value="">--เลือกสถานะ--</option>
                                        <option value="Active" {{ old('case_resident', 'Active') == 'Active' ? 'selected' : '' }}>อยู่อาศัย</option>
                                        <option value="Inactive" {{ old('case_resident') == 'Inactive' ? 'selected' : '' }}>ไม่อยู่อาศัย</option>
                                    </select>
                                    @error('case_resident')
                                        <small class="text-danger error-message" id="error-case_resident">{{ $message }}</small>
                                    @enderror
                                </div>

                               <div class="col-12 problem-full-width">
    <label class="form-label">
        ปัญหาที่พบ <span class="required-star">* (เลือกได้มากกว่า 1 รายการ)</span>
    </label>

    <div class="problem-box">
        <div class="problem-grid">
            @foreach($problems as $problem)
                <label class="problem-item" for="problem{{ $problem->id }}">
                    <input class="form-check-input"
                        type="checkbox"
                        name="problems[]"
                        value="{{ $problem->id }}"
                        id="problem{{ $problem->id }}"
                        {{ is_array(old('problems')) && in_array($problem->id, old('problems')) ? 'checked' : '' }}>
                    <span>{{ $problem->name }}</span>
                </label>
            @endforeach
        </div>
    </div>
</div>
                            </div>
                        </div>

                     <div class="col-lg-2">
                            <div class="photo-box text-center">
                                <label class="form-label d-block text-center mb-2">ภาพถ่าย</label>

                                <img id="showImage"
                                    src="{{ !empty($profileData->image) ? asset($profileData->image) : asset('upload/no_image.jpg') }}"
                                    alt="image profile"
                                    class="photo-preview d-block mx-auto">

                                <input type="file" name="image" id="image" class="d-none" accept="image/*">

                                <button type="button"
                                    class="btn btn-light btn-sm photo-btn mt-2"
                                    onclick="document.getElementById('image').click()">
                                    เลือกรูปภาพ
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ที่อยู่ --}}
                <div class="address-grid">
                    {{-- ภูมิลำเนาเดิม --}}
                    <div class="panel-box">
                        <div class="panel-title">ภูมิลำเนาเดิม</div>

                        <div class="row compact-row">
                            <div class="col-md-6">
                                <label for="origin_address" class="form-label">เลขที่</label>
                                <input type="text" name="origin_address" id="origin_address"
                                    class="form-control"
                                    value="{{ old('origin_address', $client->origin_address ?? '') }}">
                                @error('origin_address')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="origin_moo" class="form-label">หมู่ที่</label>
                                <input type="text" name="origin_moo" id="origin_moo"
                                    class="form-control"
                                    value="{{ old('origin_moo', $client->origin_moo ?? '') }}">
                                @error('origin_moo')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="origin_soi" class="form-label">ซอย</label>
                                <input type="text" name="origin_soi" id="origin_soi"
                                    class="form-control"
                                    value="{{ old('origin_soi', $client->origin_soi ?? '') }}">
                                @error('origin_soi')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="origin_road" class="form-label">ถนน</label>
                                <input type="text" name="origin_road" id="origin_road"
                                    class="form-control"
                                    value="{{ old('origin_road', $client->origin_road ?? '') }}">
                                @error('origin_road')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="origin_village" class="form-label">ภาค/หมู่บ้าน</label>
                                <input type="text" name="origin_village" id="origin_village"
                                    class="form-control"
                                    value="{{ old('origin_village', $client->origin_village ?? '') }}">
                                @error('origin_village')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="origin_province" class="form-label">จังหวัด</label>
                                <select name="origin_province_id" id="origin_province" class="form-select">
                                    <option value="">--เลือกจังหวัด--</option>
                                    @foreach($origin_provinces as $province)
                                        <option value="{{ $province->id }}"
                                            {{ old('origin_province_id', $client->origin_province_id ?? '') == $province->id ? 'selected' : '' }}>
                                            {{ $province->prov_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="origin_district" class="form-label">อำเภอ/เขต</label>
                                <select name="origin_district_id" id="origin_district" class="form-select">
                                    <option value="">--เลือกอำเภอ--</option>
                                    @foreach($origin_districts as $district)
                                        <option value="{{ $district->id }}"
                                            {{ old('origin_district_id', $client->origin_district_id ?? '') == $district->id ? 'selected' : '' }}>
                                            {{ $district->dist_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="origin_subdistrict" class="form-label">ตำบล/แขวง</label>
                                <select name="origin_sub_district_id" id="origin_subdistrict" class="form-select">
                                    <option value="">--เลือกตำบล--</option>
                                    @foreach($origin_sub_districts as $subdistrict)
                                        <option value="{{ $subdistrict->id }}"
                                            {{ old('origin_sub_district_id', $client->origin_sub_district_id ?? '') == $subdistrict->id ? 'selected' : '' }}>
                                            {{ $subdistrict->subdist_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('origin_sub_district_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="origin_zipcode" class="form-label">รหัสไปรษณีย์</label>
                                <input type="text" name="origin_zipcode" id="origin_zipcode"
                                    class="form-control"
                                    value="{{ old('origin_zipcode', $client->origin_zipcode ?? '') }}">
                                @error('origin_zipcode')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label for="origin_phone" class="form-label">โทรศัพท์</label>
                                <input type="text" name="origin_phone" id="origin_phone"
                                    class="form-control"
                                    value="{{ old('origin_phone', $client->origin_phone ?? '') }}">
                                @error('origin_phone')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- ที่อยู่ปัจจุบัน --}}
                    <div class="panel-box">
                        <div class="panel-title">ที่อยู่ปัจจุบัน</div>

                        <div class="form-check copy-check">
                            <input class="form-check-input" type="checkbox" id="sameAsCurrentAddress">
                            <label class="form-check-label" for="sameAsCurrentAddress">
                                ที่อยู่ปัจจุบันตรงกับภูมิลำเนาเดิม
                            </label>
                        </div>

                        <div class="row compact-row">
                            <div class="col-md-6">
                                <label for="address" class="form-label">เลขที่</label>
                                <input type="text" name="address" id="address"
                                    class="form-control"
                                    value="{{ old('address') }}">
                                @error('address')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="moo" class="form-label">หมู่ที่</label>
                                <input type="text" name="moo" id="moo"
                                    class="form-control"
                                    value="{{ old('moo') }}">
                                @error('moo')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="soi" class="form-label">ซอย</label>
                                <input type="text" name="soi" id="soi"
                                    class="form-control"
                                    value="{{ old('soi') }}">
                                @error('soi')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="road" class="form-label">ถนน</label>
                                <input type="text" name="road" id="road"
                                    class="form-control"
                                    value="{{ old('road') }}">
                                @error('road')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="village" class="form-label">ภาค/หมู่บ้าน</label>
                                <input type="text" name="village" id="village"
                                    class="form-control"
                                    value="{{ old('village') }}">
                                @error('village')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="province" class="form-label">จังหวัด</label>
                                <select name="province_id" id="province" class="form-select">
                                    <option value="">--เลือกจังหวัด--</option>
                                    @foreach($provinces as $province)
                                        <option value="{{ $province->id }}"
                                            {{ old('province_id') == $province->id ? 'selected' : '' }}>
                                            {{ $province->prov_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="district" class="form-label">อำเภอ/เขต</label>
                                <select name="district_id" id="district" class="form-select">
                                    <option value="">--เลือกอำเภอ--</option>
                                    @foreach($districts as $district)
                                        <option value="{{ $district->id }}"
                                            {{ old('district_id') == $district->id ? 'selected' : '' }}>
                                            {{ $district->dist_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="subdistrict" class="form-label">ตำบล/แขวง</label>
                                <select name="sub_district_id" id="subdistrict" class="form-select">
                                    <option value="">--เลือกตำบล--</option>
                                    @foreach($sub_districts as $subdistrict)
                                        <option value="{{ $subdistrict->id }}"
                                            {{ old('sub_district_id', $recipient->sub_district_id ?? '') == $subdistrict->id ? 'selected' : '' }}>
                                            {{ $subdistrict->subdist_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('sub_district_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="zipcode" class="form-label">รหัสไปรษณีย์</label>
                                <input type="text" name="zipcode" id="zipcode"
                                    class="form-control"
                                    value="{{ old('zipcode') }}">
                                @error('zipcode')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-8">
                                <label for="phone" class="form-label">โทรศัพท์</label>
                                <input type="text" name="phone" id="phone"
                                    class="form-control"
                                    value="{{ old('phone') }}">
                                @error('phone')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="action-bar">
                    <button type="submit" class="btn btn-success btn-registry">
                        <i class="bi bi-check-circle me-1"></i> บันทึกข้อมูล
                    </button>

                    <a href="{{ route('client.show') }}" class="btn btn-danger btn-registry">
                        <i class="bi bi-x-circle me-1"></i> ยกเลิก
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {

    $('#district').empty().append('<option value="">--เลือกอำเภอ--</option>');
    $('#subdistrict').empty().append('<option value="">--เลือกตำบล--</option>');
    $('#zipcode').val('');

    $('#province').on('change', function () {
        let province_id = $(this).val();

        if (province_id) {
            $.get('/get-districts/' + province_id, function (data) {
                $('#district').empty().append('<option value="">--เลือกอำเภอ--</option>');
                $.each(data, function (key, value) {
                    $('#district').append('<option value="' + value.id + '">' + value.dist_name + '</option>');
                });

                $('#subdistrict').empty().append('<option value="">--เลือกตำบล--</option>');
                $('#zipcode').val('');
            });
        } else {
            $('#district').empty().append('<option value="">--เลือกอำเภอ--</option>');
            $('#subdistrict').empty().append('<option value="">--เลือกตำบล--</option>');
            $('#zipcode').val('');
        }
    });

    $('#district').on('change', function () {
        let district_id = $(this).val();

        if (district_id) {
            $.get('/get-subdistricts/' + district_id, function (data) {
                $('#subdistrict').empty().append('<option value="">--เลือกตำบล--</option>');
                $.each(data, function (key, value) {
                    $('#subdistrict').append('<option value="' + value.id + '">' + value.subd_name + '</option>');
                });
                $('#zipcode').val('');
            });
        } else {
            $('#subdistrict').empty().append('<option value="">--เลือกตำบล--</option>');
            $('#zipcode').val('');
        }
    });

    $('#subdistrict').on('change', function () {
        let subdistrict_id = $(this).val();

        if (subdistrict_id) {
            $.get('/get-zipcode/' + subdistrict_id, function (data) {
                $('#zipcode').val(data.zipcode);
            });
        } else {
            $('#zipcode').val('');
        }
    });

    $('#origin_district').empty().append('<option value="">--เลือกอำเภอ--</option>');
    $('#origin_subdistrict').empty().append('<option value="">--เลือกตำบล--</option>');
    $('#origin_zipcode').val('');

    $('#origin_province').on('change', function () {
        let province_id = $(this).val();
        if (province_id) {
            $.get('/get-origin-districts/' + province_id, function (data) {
                $('#origin_district').empty().append('<option value="">--เลือกอำเภอ--</option>');
                $.each(data, function (key, value) {
                    $('#origin_district').append('<option value="' + value.id + '">' + value.dist_name + '</option>');
                });
                $('#origin_subdistrict').empty().append('<option value="">--เลือกตำบล--</option>');
                $('#origin_zipcode').val('');
            });
        } else {
            $('#origin_district').empty().append('<option value="">--เลือกอำเภอ--</option>');
            $('#origin_subdistrict').empty().append('<option value="">--เลือกตำบล--</option>');
            $('#origin_zipcode').val('');
        }
    });

    $('#origin_district').on('change', function () {
        let district_id = $(this).val();
        if (district_id) {
            $.get('/get-origin-subdistricts/' + district_id, function (data) {
                $('#origin_subdistrict').empty().append('<option value="">--เลือกตำบล--</option>');
                $.each(data, function (key, value) {
                    $('#origin_subdistrict').append('<option value="' + value.id + '">' + value.subd_name + '</option>');
                });
                $('#origin_zipcode').val('');
            });
        } else {
            $('#origin_subdistrict').empty().append('<option value="">--เลือกตำบล--</option>');
            $('#origin_zipcode').val('');
        }
    });

    $('#origin_subdistrict').on('change', function () {
        let subdistrict_id = $(this).val();
        if (subdistrict_id) {
            $.get('/get-origin-zipcode/' + subdistrict_id, function (data) {
                $('#origin_zipcode').val(data.origin_zipcode);
            });
        } else {
            $('#origin_zipcode').val('');
        }
    });
});
</script>

<script>
    $(document).ready(function() {
        $('#image').change(function(e) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#showImage').attr('src', e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        });
    });
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const inputs = document.querySelectorAll('input, select, textarea');

    inputs.forEach(input => {
        input.addEventListener('input', function () {
            const errorElement = document.getElementById('error-' + input.name);
            if (errorElement) {
                errorElement.remove();
            }

            if (input.type === 'radio') {
                document.querySelectorAll('input[name="' + input.name + '"]').forEach(radio => {
                    radio.classList.remove('is-invalid');
                });
            } else {
                input.classList.remove('is-invalid');
            }
        });

        input.addEventListener('change', function () {
            const errorElement = document.getElementById('error-' + input.name);
            if (errorElement) {
                errorElement.remove();
            }

            if (input.type === 'radio') {
                document.querySelectorAll('input[name="' + input.name + '"]').forEach(radio => {
                    radio.classList.remove('is-invalid');
                });
            } else {
                input.classList.remove('is-invalid');
            }
        });
    });
});
</script>

<script>
$(function () {
    $('#sameAsCurrentAddress').on('change', function () {
        if ($(this).is(':checked')) {
            $('#origin_address').val($('#address').val());
            $('#origin_moo').val($('#moo').val());
            $('#origin_soi').val($('#soi').val());
            $('#origin_road').val($('#road').val());
            $('#origin_village').val($('#village').val());
            $('#origin_zipcode').val($('#zipcode').val());
            $('#origin_phone').val($('#phone').val());

            let province_id = $('#province').val();
            $('#origin_province').val(province_id).trigger('change');

            setTimeout(function () {
                let district_id = $('#district').val();
                $('#origin_district').val(district_id).trigger('change');
            }, 500);

            setTimeout(function () {
                let subdistrict_id = $('#subdistrict').val();
                $('#origin_subdistrict').val(subdistrict_id).trigger('change');
            }, 1000);
        } else {
            $('#origin_address').val('');
            $('#origin_moo').val('');
            $('#origin_soi').val('');
            $('#origin_road').val('');
            $('#origin_village').val('');
            $('#origin_zipcode').val('');
            $('#origin_phone').val('');
            $('#origin_province').val('').trigger('change');
            $('#origin_district').val('').trigger('change');
            $('#origin_subdistrict').val('').trigger('change');
        }
    });
});
</script>

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'สำเร็จ!',
        text: '{{ session('success') }}',
        showConfirmButton: true,
        timer: 2000
    });
</script>
@endif

@endsection