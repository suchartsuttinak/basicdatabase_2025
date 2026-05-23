@extends('admin.admin_master')

@section('admin')
<div class="container-fluid py-4 user-form-page">
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white border-0 py-3 px-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <h4 class="mb-1 fw-bold">
                        <i class="bi bi-pencil-square text-warning me-2"></i>
                        แก้ไขผู้ใช้งาน
                    </h4>
                    <div class="text-muted small">ปรับปรุงข้อมูลผู้ใช้งานและสิทธิ์การดูแลบ้าน</div>
                </div>

                <a href="{{ route('users.index') }}" class="btn btn-light border rounded-pill px-4">
                    <i class="bi bi-arrow-left me-1"></i>
                    กลับหน้ารายการ
                </a>
            </div>
        </div>

                    <div class="card-body p-4 p-lg-5">
                    @php
                            $selectedHouseIds = old('house_ids', $user->houses->pluck('id')->toArray());
                        @endphp

                        <form action="{{ route('users.update', $user->id) }}"
                    method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                <div class="row g-4">
                    <div class="col-lg-6">
                        <label class="form-label fw-semibold">ชื่อผู้ใช้งาน</label>
                        <input type="text" name="name" class="form-control form-control-modern" value="{{ old('name', $user->name) }}">
                        @error('name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-lg-6">
                        <label class="form-label fw-semibold">อีเมล</label>
                        <input type="email" name="email" class="form-control form-control-modern" value="{{ old('email', $user->email) }}">
                        @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-lg-6">
                        <label class="form-label fw-semibold">รหัสผ่านใหม่</label>
                        <input type="password" name="password" class="form-control form-control-modern">
                        <div class="small text-muted mt-1">ถ้าไม่เปลี่ยนรหัสผ่าน ให้เว้นว่างไว้</div>
                        @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-lg-6">
                        <label class="form-label fw-semibold">ยืนยันรหัสผ่านใหม่</label>
                        <input type="password" name="password_confirmation" class="form-control form-control-modern">
                    </div>

                    <div class="col-lg-6">
                        <label class="form-label fw-semibold">สิทธิ์ผู้ใช้งาน</label>
                       <select name="role" class="form-select form-control-modern">
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>ผู้ดูแลระบบ</option>
                            <option value="manager" {{ old('role', $user->role) == 'manager' ? 'selected' : '' }}>ผู้ใช้ / เจ้าหน้าที่</option>
                            <option value="executive" {{ old('role', $user->role) == 'executive' ? 'selected' : '' }}>ผู้บริหาร</option>
                            <option value="social_worker" {{ old('role', $user->role) == 'social_worker' ? 'selected' : '' }}>นักสังคมสงเคราะห์</option>
                            <option value="teacher_caregiver" {{ old('role', $user->role) == 'teacher_caregiver' ? 'selected' : '' }}>ครู/ผู้ดูแล</option>
                            <option value="nurse" {{ old('role', $user->role) == 'nurse' ? 'selected' : '' }}>พยาบาล</option>
                            <option value="general_user" {{ old('role', $user->role) == 'general_user' ? 'selected' : '' }}>ผู้ใช้ทั่วไป</option>
                        </select>
                        @error('role')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-lg-6">
                        <label class="form-label fw-semibold">สถานะ</label>
                        <select name="status" class="form-select form-control-modern">
                            <option value="1" {{ old('status', $user->status) == '1' ? 'selected' : '' }}>ใช้งาน</option>
                            <option value="0" {{ old('status', $user->status) == '0' ? 'selected' : '' }}>ปิดใช้งาน</option>
                        </select>
                        @error('status')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-lg-6">
                            <label class="form-label fw-semibold">
                                หน่วยงาน / โครงการ
                            </label>

                            <select name="project_id" class="form-select form-control-modern">
                                <option value="">-- ไม่กำหนดหน่วยงาน --</option>

                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}"
                                        {{ old('project_id', $user->project_id) == $project->id ? 'selected' : '' }}>
                                        {{ $project->project_name ?? $project->name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('project_id')
                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>
                            @enderror

                            <div class="text-muted small mt-1">
                                ใช้กำหนดสิทธิ์ให้เห็นเฉพาะผู้รับบริการของหน่วยงานนี้
                            </div>
                        </div>

                    <div class="col-12">
                        <div class="house-box">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                                <div>
                                    <div class="fw-bold">
                                        <i class="bi bi-house-check-fill text-primary me-2"></i>
                                        เลือกบ้านที่ดูแล
                                    </div>
                                  <div class="text-muted small">
                                        ใช้จำกัดเพิ่มเติมตามบ้านที่ดูแล ภายใต้หน่วยงาน/โครงการที่เลือก
                                    </div>
                                </div>

                                <div class="form-check m-0">
                                    <input type="checkbox" class="form-check-input" id="checkAllHouses">
                                    <label class="form-check-label fw-semibold" for="checkAllHouses">เลือกทั้งหมด</label>
                                </div>
                            </div>

                            <div class="row g-3">
                                @foreach($houses as $house)
                                    <div class="col-md-6 col-xl-4">
                                      <label class="house-option" for="house_{{ $house->id }}">
                                            <input
                                                type="checkbox"
                                                class="form-check-input house-checkbox"
                                                name="house_ids[]"
                                                value="{{ $house->id }}"
                                                id="house_{{ $house->id }}"
                                                {{ in_array($house->id, $selectedHouseIds) ? 'checked' : '' }}
                                            >

                                            <span class="house-option-text">
                                                <i class="bi bi-house-door-fill text-primary me-1"></i>
                                                {{ $house->house_name ?? $house->name ?? 'บ้านเลขที่ '.$house->id }}
                                            </span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                          @error('house_ids')
                                    <div class="text-danger small mt-2">{{ $message }}</div>
                                @enderror

                                @error('house_ids.*')
                                    <div class="text-danger small mt-2">{{ $message }}</div>
                                @enderror
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="d-flex justify-content-end flex-wrap gap-2">
                            <a href="{{ route('users.index') }}" class="btn btn-light border rounded-pill px-4">ยกเลิก</a>
                            <button type="submit" class="btn btn-warning rounded-pill px-4 shadow-sm">
                                <i class="bi bi-save2-fill me-1"></i>
                                บันทึกการแก้ไข
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.user-form-page .form-control-modern{
    min-height:48px;
    border-radius:14px;
    border:1px solid #dbe3ee;
    box-shadow:none;
}
.user-form-page .form-control-modern:focus{
    border-color:#86b7fe;
    box-shadow:0 0 0 .2rem rgba(13,110,253,.10);
}
.user-form-page .house-box{
    border:1px solid #e9eef5;
    border-radius:22px;
    padding:1.25rem;
    background:#fbfdff;
}
.user-form-page .house-option{
    display:flex;
    align-items:center;
    gap:.75rem;
    width:100%;
    border:1px solid #e5e7eb;
    border-radius:18px;
    padding:1rem;
    background:#fff;
    cursor:pointer;
    transition:all .2s ease;
}
.user-form-page .house-option:hover{
    border-color:#86b7fe;
    transform:translateY(-1px);
    box-shadow:0 10px 24px rgba(15, 23, 42, 0.05);
}
.user-form-page .house-option-text{
    font-weight:600;
    color:#1f2937;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const checkAll = document.getElementById('checkAllHouses');
    const houseCheckboxes = document.querySelectorAll('.house-checkbox');

    function syncCheckAll() {
        if (!checkAll) return;
        checkAll.checked = houseCheckboxes.length > 0 &&
            [...houseCheckboxes].every(item => item.checked);
    }

    if (checkAll) {
        checkAll.addEventListener('change', function () {
            houseCheckboxes.forEach(cb => cb.checked = this.checked);
        });
    }

    houseCheckboxes.forEach(cb => {
        cb.addEventListener('change', syncCheckAll);
    });

    syncCheckAll();
});
</script>
@endsection