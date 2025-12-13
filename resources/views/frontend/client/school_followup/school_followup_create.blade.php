@extends('admin_client.admin_client')
@section('content')

<div class="container-fluid mt-4">
<form action="{{ route('school_followup.store') }}" method="POST">
    @csrf
    <input type="hidden" name="client_id" value="{{ $client->id }}">
    <input type="hidden" name="education_record_id" value="{{ optional($educationRecord)->id ?? '' }}">
    <input type="hidden" name="follo_no" value="{{ old('follo_no', 1) }}"> {{-- ✅ เพิ่ม follo_no --}}

    {{-- 🏫 หัวฟอร์ม --}}
    <div class="mb-4 text-center">
        <h4 class="fw-bold text-dark">
            <i class="bi bi-journal-text me-2"></i> บันทึกติดตามผลการศึกษาเด็กในโรงเรียน
        </h4>
    </div>

    {{-- 🔒 ข้อมูลเด็ก --}}
    <div class="card mb-4 border-0">
        <div class="card-header bg-light fw-bold text-dark">
            <i class="bi bi-person-lines-fill me-2"></i> ข้อมูลเด็ก
        </div>
        <div class="card-body bg-white">
            <div class="mb-2">
                <i class="bi bi-person-fill text-primary me-2"></i>
                <span class="fw-bold text-dark">ชื่อ-นามสกุล:</span>
                <span class="ms-2">{{ $client->full_name }}</span>
            </div>
            <div class="mb-2">
                <i class="bi bi-calendar3 text-primary me-2"></i>
                <span class="fw-bold text-dark">อายุ:</span>
                <span class="ms-2">{{ $client->age }} ปี</span>
            </div>
            <div class="mb-2">
                <i class="bi bi-building text-primary me-2"></i>
                <span class="fw-bold text-dark">ชื่อสถานศึกษา:</span>
                <span class="ms-2">{{ optional($educationRecord)->school_name ?? 'ไม่พบข้อมูล' }}</span>
            </div>
            <div>
            <div class="mb-2">
                <i class="bi bi-mortarboard text-primary me-2"></i>
                <span class="fw-bold text-dark">ระดับชั้น:</span>
                <span class="ms-2">{{ optional(optional($educationRecord)->education)->education_name ?? 'ไม่พบข้อมูล' }}</span>
            </div>
             <div class="mb-2">
                <i class="bi bi-mortarboard text-primary me-2"></i>
                <span class="fw-bold text-dark">ภาคเรียน:</span>
                {{ $educationRecord->semester ?? 'ไม่พบข้อมูล' }}
            </div>
            </div>
        </div>
    </div>

    {{-- 📝 ข้อมูลการติดตาม --}}
    <div class="card mb-4 border-0">
        <div class="card-header bg-light fw-bold text-dark">ข้อมูลการติดตาม</div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold">วันที่ติดตาม</label>
                    <input type="date" name="follow_date" class="form-control" value="{{ old('follow_date') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">ชื่อ-สกุล ครูประจำชั้น</label>
                    <input type="text" name="teacher_name" class="form-control" value="{{ old('teacher_name') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">โทรศัพท์</label>
                    <input type="text" name="tel" class="form-control" value="{{ old('tel') }}">
                </div>
            </div>

            <div class="mt-3">
                <label class="form-label fw-bold">การดำเนินงาน</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="follow_type" value="self" {{ old('follow_type') == 'self' ? 'checked' : '' }}>
                    <label class="form-check-label">ติดตามด้วยตนเอง</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="follow_type" value="phone" {{ old('follow_type') == 'phone' ? 'checked' : '' }}>
                    <label class="form-check-label">โทรศัพท์</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="follow_type" value="other" {{ old('follow_type') == 'other' ? 'checked' : '' }}>
                    <label class="form-check-label">อื่นๆ</label>
                </div>
            </div>

            <div class="mt-3">
                <label class="form-label fw-bold">ผลการติดตาม</label>
                <textarea name="result" class="form-control" rows="4">{{ old('result') }}</textarea>
            </div>
        </div>
    </div>

    {{-- 👤 ผู้ติดตาม --}}
    <div class="card mb-4 border-0">
        <div class="card-header bg-light fw-bold text-dark">ข้อมูลผู้ติดตาม</div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-12">
                    <label class="form-label fw-bold">หมายเหตุ</label>
                    <textarea name="remark" class="form-control" rows="4">{{ old('remark') }}</textarea>
                </div>
                <div class="col-md-3 mt-3">
                    <label class="form-label fw-bold">ชื่อ-สกุล ผู้ติดตาม</label>
                    <input type="text" name="contact_name" class="form-control" value="{{ old('contact_name') }}">
                </div>
            </div>
        </div>
    </div>

    {{-- ✅ ปุ่มบันทึก --}}
    <div class="text-end">
        <button type="submit" class="btn btn-success">
            <i class="bi bi-save me-1"></i> บันทึกผล
        </button>
    </div>
</form>
</div>
@endsection