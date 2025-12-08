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


<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">บันทึกผลการเรียน</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('education_record.store') }}" method="POST">
                @csrf
                <input type="hidden" name="client_id" value="{{ $client->id }}">

                <!-- แสดงชื่อ-นามสกุลนักเรียน -->
                <div class="mb-3">
                    <label class="form-label">นักเรียน</label>
                    <input type="text" class="form-control" 
                           value="{{ $client->first_name }} {{ $client->last_name }}" readonly>
                </div>

                <!-- การศึกษา -->
                <div class="form-group col-md-4 mb-3">
                    <label class="form-label" for="education_id">การศึกษา : <span class="text-danger">*</span></label>
                    <select name="education_id" id="education_id"
                            class="form-control form-select @error('education_id') is-invalid @enderror">
                        <option value="">--การศึกษา--</option>
                        @foreach ($educations as $item)
                            <option value="{{ $item->id }}"
                                {{ old('education_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->education_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('education_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- ภาคเรียน -->
                <div class="mb-3">
                    <label for="semester" class="form-label">ภาคเรียน</label>
                    <input type="text" name="semester" id="semester" class="form-control" placeholder="เช่น 1/2568" required>
                </div>

                <!-- โรงเรียน -->
                <div class="mb-3">
                    <label for="school_name" class="form-label">โรงเรียน</label>
                    <input type="text" name="school_name" id="school_name" class="form-control" required>
                </div>

                <!-- วันที่บันทึก -->
                <div class="mb-3">
                    <label for="record_date" class="form-label">วันที่บันทึก</label>
                    <input type="date" name="record_date" id="record_date" class="form-control" required>
                </div>

                <!-- เลือกวิชา + คะแนน + เกรด -->
                <div id="subject-container">
                    <div class="border p-3 mb-3">
                        <label class="form-label">เลือกวิชา</label>
                        <select name="subjects[0][subject_id]" class="form-select" required>
                            <option value="">-- เลือกวิชา --</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->subject_name }}</option>
                            @endforeach
                        </select>

                        <label class="form-label mt-2">คะแนน</label>
                        <input type="number" name="subjects[0][score]" class="form-control" min="0" max="100" required>

                        <label class="form-label mt-2">เกรด</label>
                        <select name="subjects[0][grade]" class="form-select" required>
                            <option value="">-- เลือกเกรด --</option>
                            <option value="4">4</option>
                            <option value="3">3</option>
                            <option value="2">2</option>
                            <option value="1">1</option>
                            <option value="0">0</option>
                        </select>
                    </div>
                </div>

                <!-- ปุ่มเพิ่มวิชา -->
                <button type="button" class="btn btn-secondary mb-3" id="add-subject">+ เพิ่มวิชา</button>

                <!-- ปุ่มบันทึก -->
                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-success">บันทึกผลการเรียน</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ✅ Script สำหรับเพิ่มช่องวิชา --}}
<script>
document.getElementById('add-subject').addEventListener('click', function() {
    let container = document.getElementById('subject-container');
    let index = container.children.length;

    let html = `
        <div class="border p-3 mb-3">
            <label class="form-label">เลือกวิชา</label>
            <select name="subjects[${index}][subject_id]" class="form-select" required>
                <option value="">-- เลือกวิชา --</option>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}">{{ $subject->subject_name }}</option>
                @endforeach
            </select>

            <label class="form-label mt-2">คะแนน</label>
            <input type="number" name="subjects[${index}][score]" class="form-control" min="0" max="100" required>

            <label class="form-label mt-2">เกรด</label>
            <select name="subjects[${index}][grade]" class="form-select" required>
                <option value="">-- เลือกเกรด --</option>
                <option value="4">4</option>
                <option value="3">3</option>
                <option value="2">2</option>
                <option value="1">1</option>
                <option value="0">0</option>
            </select>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
});
</script>

@endsection