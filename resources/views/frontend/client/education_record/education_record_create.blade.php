@extends('admin_client.admin_client')
@section('content')

 {{-- ✅ แสดงข้อความแจ้งเตือน --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

            <div class="container my-4">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bi bi-journal-text me-2"></i> บันทึกผลการเรียน
                </h5>
                <!-- ปุ่มปิดฟอร์ม -->
                <a href="{{ route('admin.index', $client->id) }}" class="btn-close btn-close-white" aria-label="Close"></a>
            </div>
                    
        <div class="card-body">
            <form action="{{ route('education_record_store') }}" method="POST" novalidate>
                @csrf
                <input type="hidden" name="client_id" value="{{ $client->id }}">

                <!-- นักเรียน + ระดับการศึกษา -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">นักเรียน</label>
                        <input type="text" class="form-control bg-light"
                               value="{{ $client->full_name }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="education_id" class="form-label fw-bold">ระดับการศึกษา <span class="text-danger">*</span></label>
                        <select name="education_id" id="education_id"
                                class="form-select @error('education_id') is-invalid @enderror" required>
                            <option value="">-- เลือกการศึกษา --</option>
                            @foreach ($educations as $item)
                                <option value="{{ $item->id }}" {{ old('education_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->education_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('education_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- ภาคเรียน + โรงเรียน -->
                <div class="row mb-3">
                 <div class="col-md-4">
                        <label for="semester_id" class="form-label fw-bold">ภาคเรียน</label>
                        <select name="semester_id" id="semester_id"
                            class="form-select @error('semester_id') is-invalid @enderror"
                            required>
                            <option value="">-- เลือกภาคเรียน --</option>
                            @foreach($semesters as $sem)
                                <option value="{{ $sem->id }}"
                                    {{ old('semester_id') == $sem->id ? 'selected' : '' }}>
                                    {{ $sem->semester_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('semester_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

              <div class="col-md-8">
                        <label for="school_name" class="form-label fw-bold">สถานศึกษา</label>
                        <input type="text"
                               name="school_name"
                               id="school_name"
                               class="form-control @error('school_name') is-invalid @enderror"
                               value="{{ old('school_name') }}"
                               placeholder="เช่น โรงเรียนแมวเหมี๊ยววิทยา"
                               required>
                        @error('school_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- วันที่บันทึก -->
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="record_date" class="form-label fw-bold">วันที่บันทึก</label>
                        <input type="date"
                               name="record_date"
                               id="record_date"
                               class="form-control @error('record_date') is-invalid @enderror"
                               value="{{ old('record_date') }}"
                               required>
                        @error('record_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- รายละเอียดวิชา -->
                <div id="subject-container" class="mb-3">
                    <div class="border rounded p-3 bg-light subject-item">
                        <h6 class="fw-bold text-secondary mb-3">รายละเอียดวิชา</h6>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">วิชา</label>
                                <select name="subjects[0][subject_id]" class="form-select">
                                    <option value="">-- เลือกวิชา --</option>
                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject->id }}">{{ $subject->subject_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">คะแนน</label>
                                <input type="number" name="subjects[0][score]" class="form-control" min="0" max="100">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">เกรด</label>
                                <select name="subjects[0][grade]" class="form-select">
                                    <option value="">-- เลือกเกรด --</option>
                                    <option value="4">4</option>
                                    <option value="3">3</option>
                                    <option value="2">2</option>
                                    <option value="1">1</option>
                                    <option value="0">0</option>
                                </select>
                            </div>
                            <div class="col-md-1 d-flex align-items-end justify-content-end">
                                <button type="button" class="btn btn-outline-danger btn-sm remove-subject">
                                    <i class="bi bi-x-circle-fill"></i> ลบ
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- เกรดเฉลี่ย -->
                <div class="row mb-3">
                    <div class="col-md-2 ms-auto">
                        <label for="grade_average" class="form-label fw-bold">เกรดเฉลี่ย</label>
                        <input type="number" step="0.01" name="grade_average" id="grade_average"
                               class="form-control text-end @error('grade_average') is-invalid @enderror"
                               value="{{ old('grade_average') }}">
                        @error('grade_average')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

              <!-- ปุ่ม -->
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-outline-secondary" id="add-subject">
                                <i class="bi bi-plus-circle me-1"></i> เพิ่มวิชา
                            </button>
                            <a href="{{ route('education_record_show', ['client_id' => $client->id]) }}" 
                                class="btn btn-outline-primary">
                                    <i class="bi bi-house-door me-1"></i> กลับหน้าหลัก
                                </a>


                        </div>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-save me-1"></i> บันทึกผล
                        </button>
                    </div>
            </form>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('subject-container');
    const addBtn = document.getElementById('add-subject');

    // ✅ ฟังก์ชันคำนวณเกรดจากคะแนน
    function calculateGrade(score) {
        if (score >= 80) return 4.00;
        if (score >= 70) return 3.00;
        if (score >= 60) return 2.00;
        if (score >= 50) return 1.00;
        return 0;
    }

    // ✅ ฟังก์ชันอัปเดตเกรดอัตโนมัติ
    function updateGrade(input) {
        let score = parseInt(input.value, 10);
        if (!isNaN(score)) {
            let grade = calculateGrade(score);
            let gradeSelect = input.closest('.row').querySelector('select[name*="[grade]"]');
            if (gradeSelect) {
                gradeSelect.value = grade;
            }
        }
    }

    // ✅ เพิ่มช่องวิชาใหม่
    addBtn.addEventListener('click', function() {
        let index = container.querySelectorAll('.subject-item').length;

        let html = `
            <div class="border p-3 mb-3 subject-item">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">วิชา</label>
                        <select name="subjects[${index}][subject_id]" class="form-select" required>
                            <option value="">-- เลือกวิชา --</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->subject_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">คะแนน</label>
                        <input type="number" name="subjects[${index}][score]" class="form-control" min="0" max="100" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">เกรด</label>
                        <select name="subjects[${index}][grade]" class="form-select" required>
                            <option value="">-- เลือกเกรด --</option>
                            <option value="4">4</option>
                            <option value="3">3</option>
                            <option value="2">2</option>
                            <option value="1">1</option>
                            <option value="0">0</option>
                        </select>
                    </div>
                    <div class="col-md-1 d-flex align-items-end justify-content-end">
                        <button type="button" class="btn btn-outline-danger btn-sm remove-subject d-flex align-items-center gap-1">
                            <i class="bi bi-x-circle-fill"></i> <span>ลบ</span>
                        </button>
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
    });

    // ✅ ลบช่องวิชา
    container.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-subject') || e.target.closest('.remove-subject')) {
            e.target.closest('.subject-item').remove();
        }
    });

    // ✅ อัปเดตเกรดอัตโนมัติเมื่อกรอกคะแนน
    container.addEventListener('input', function(e) {
        if (e.target.name.includes('[score]')) {
            updateGrade(e.target);
        }
    });

    // ✅ ตรวจสอบค่า semester_id
    const semesterInput = document.getElementById('semester_id');
    if (semesterInput) {
        semesterInput.addEventListener('input', function() {
            if (this.value.length < 1) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });
    }
});
</script>
@endsection