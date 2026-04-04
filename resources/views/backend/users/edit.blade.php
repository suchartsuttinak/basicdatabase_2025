@extends('admin.admin_master')

@section('admin')
<div class="container-fluid py-3 user-form-page">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <div>
            <h2 class="mb-1 fw-bold user-form-title">แก้ไขผู้ใช้งาน</h2>
            <div class="text-muted">ปรับปรุงข้อมูลบัญชีและสิทธิ์การใช้งาน</div>
        </div>

        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary user-back-btn">
            <i class="bi bi-arrow-left-circle me-1"></i> กลับหน้ารายการ
        </a>
    </div>

    <div class="card border-0 shadow-sm user-form-card">
        <div class="card-body p-3 p-lg-4">
            <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-4">
                    <div class="col-lg-4">
                        <div class="user-profile-upload-box">
                            <div class="user-upload-preview-wrap">
                                <img src="{{ $user->photo_url }}" id="showImage" class="user-upload-preview" alt="preview">
                            </div>

                            <label class="form-label fw-semibold mt-3">รูปผู้ใช้งาน</label>
                            <input type="file" name="photo" id="image" class="form-control user-input-modern @error('photo') is-invalid @enderror">
                            @error('photo')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror

                            <div class="form-text mt-2">อัปโหลดใหม่เมื่อต้องการเปลี่ยนรูปเท่านั้น</div>
                        </div>
                    </div>

                    <div class="col-lg-8">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label user-label">ชื่อผู้ใช้งาน <span class="text-danger">*</span></label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                    class="form-control user-input-modern @error('name') is-invalid @enderror">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label user-label">อีเมล <span class="text-danger">*</span></label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                    class="form-control user-input-modern @error('email') is-invalid @enderror">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label user-label">รหัสผ่านใหม่</label>
                                <input type="password" name="password"
                                    class="form-control user-input-modern @error('password') is-invalid @enderror">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">เว้นว่างไว้หากไม่ต้องการเปลี่ยนรหัสผ่าน</div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label user-label">ยืนยันรหัสผ่านใหม่</label>
                                <input type="password" name="password_confirmation" class="form-control user-input-modern">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label user-label">เบอร์โทร</label>
                                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                                    class="form-control user-input-modern @error('phone') is-invalid @enderror">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label user-label">สิทธิ์ผู้ใช้งาน <span class="text-danger">*</span></label>
                                <select name="role" class="form-select user-input-modern @error('role') is-invalid @enderror">
                                    <option value="">-- เลือกสิทธิ์ผู้ใช้งาน --</option>
                                    @foreach($roles as $value => $label)
                                        <option value="{{ $value }}" {{ old('role', $user->role) == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label user-label">ที่อยู่</label>
                                <textarea name="address" rows="4"
                                    class="form-control user-input-modern @error('address') is-invalid @enderror">{{ old('address', $user->address) }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label user-label">สถานะ <span class="text-danger">*</span></label>
                                <select name="status" class="form-select user-input-modern @error('status') is-invalid @enderror">
                                    <option value="1" {{ old('status', $user->status) == '1' ? 'selected' : '' }}>ใช้งาน</option>
                                    <option value="0" {{ old('status', $user->status) == '0' ? 'selected' : '' }}>ปิดใช้งาน</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <div class="d-flex justify-content-end flex-wrap gap-2 pt-2">
                                    <a href="{{ route('users.index') }}" class="btn btn-light user-cancel-btn">ยกเลิก</a>
                                    <button type="submit" class="btn btn-primary user-save-btn">
                                        <i class="bi bi-save me-1"></i> อัปเดตข้อมูล
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<style>
.user-form-page{
    --uf-border: #e2e8f0;
    --uf-soft: #f8fafc;
    --uf-dark: #0f172a;
}

.user-form-title{
    color: var(--uf-dark);
    letter-spacing: -.02em;
}

.user-form-card{
    border-radius: 22px;
    overflow: hidden;
}

.user-profile-upload-box{
    background: linear-gradient(180deg, #f8fbff 0%, #ffffff 100%);
    border: 1px solid var(--uf-border);
    border-radius: 18px;
    padding: 1rem;
    height: 100%;
}

.user-upload-preview-wrap{
    display: flex;
    justify-content: center;
    align-items: center;
}

.user-upload-preview{
    width: 190px;
    height: 190px;
    object-fit: cover;
    border-radius: 20px;
    border: 4px solid #fff;
    box-shadow: 0 10px 25px rgba(15,23,42,.12);
    background: #fff;
}

.user-label{
    font-weight: 700;
    color: #334155;
    margin-bottom: .5rem;
}

.user-input-modern{
    min-height: 48px;
    border-radius: 14px;
    border: 1px solid #cbd5e1;
    box-shadow: none;
}

textarea.user-input-modern{
    min-height: 120px;
}

.user-input-modern:focus{
    border-color: #60a5fa;
    box-shadow: 0 0 0 .2rem rgba(37,99,235,.12);
}

.user-save-btn,
.user-back-btn,
.user-cancel-btn{
    border-radius: 12px;
    font-weight: 600;
    min-height: 44px;
    padding: .65rem 1rem;
}

@media (max-width: 767.98px){
    .user-save-btn,
    .user-back-btn,
    .user-cancel-btn{
        width: 100%;
        justify-content: center;
    }

    .user-upload-preview{
        width: 150px;
        height: 150px;
    }
}
</style>
@endsection

@push('scripts')
<script>
    $(document).ready(function(){
        $('#image').change(function(e){
            const reader = new FileReader();
            reader.onload = function(e){
                $('#showImage').attr('src', e.target.result);
            }
            reader.readAsDataURL(e.target.files[0]);
        });
    });
</script>
@endpush