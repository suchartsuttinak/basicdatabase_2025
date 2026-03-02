@extends('admin_client.admin_client')
@section('content')
<div class="container">
    <h4 class="fw-bold text-primary mb-3 border-bottom pb-2 text-center pt-4">
        แบบรายงานผลการเรียน
    </h4>

    {{-- ข้อมูลผู้เรียน --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <span class="fw-bold text-primary fs-6">
            <i class="bi bi-person-fill me-2 text-primary"></i>
            ชื่อ-สกุล : {{ $client->full_name ?? '-' }}
        </span>
    </div>

    {{-- ปุ่มเพิ่มข้อมูล --}}
    <div class="mb-3">
        <a href="{{ route('education_record_add', $client->id) }}" class="btn btn-primary btn-sm">
            + เพิ่มผลการเรียนใหม่
        </a>
    </div>

    @if($educationRecords->isNotEmpty())
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th style="width: 12%">วันที่บันทึก</th>
                <th style="width: 20%">ระดับชั้น</th>
                <th style="width: 8%">ภาคเรียน</th>
                <th style="width: 25%">ชื่อสถานศึกษา</th>
                <th style="width: 10%">เกรดเฉลี่ย</th>
                <th style="width: 25%" class="text-end">จัดการ</th>
            </tr>
        </thead>
        <tbody>
            @foreach($educationRecords as $record)
                <tr>
                    <td>
                        {{ \Carbon\Carbon::parse($record->record_date)->format('d/m') }}/
                        {{ \Carbon\Carbon::parse($record->record_date)->year + 543 }}
                        <td>{{ $record->education->education_name ?? '-' }}</td>
                    </td>
                    <td>{{ $record->semester->semester_name ?? '-' }}</td>
                    <td>{{ $record->school_name }}</td>
                    <td>
                        @if(empty($record->grade_average) || $record->grade_average == 0)
                        <span class="badge bg-warning">รอผล</span>
                    @else
                        <span class="badge bg-success">
                            {{ number_format($record->grade_average, 2) }}
                        </span>
                    @endif

                    </td>
                    <td class="text-end">
                        <a href="{{ route('education_record_edit', $record->id) }}"
                           class="btn btn-warning btn-sm me-1">
                            <i class="bi bi-pencil-square me-1"></i> แก้ไข
                        </a>
                        <form id="delete-form-{{ $record->id }}"
                              action="{{ route('education_record_delete', $record->id) }}"
                              method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="button"
                                    class="btn btn-danger btn-sm"
                                    onclick="confirmDelete('delete-form-{{ $record->id }}', 'คุณแน่ใจหรือไม่ที่จะลบข้อมูลผลการเรียนนี้?')">
                                <i class="bi bi-trash me-1"></i> ลบ
                            </button>
                        </form>
                        <button class="btn btn-info btn-sm ms-1"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#record-{{ $record->id }}"
                                aria-expanded="false"
                                aria-controls="record-{{ $record->id }}">
                            แสดงรายวิชา
                        </button>
                    </td>
                </tr>
                <tr id="record-{{ $record->id }}" class="collapse">
                    <td colspan="6">
                        <table class="table table-sm table-bordered mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>ชื่อวิชา</th>
                                    <th>คะแนน</th>
                                    <th>เกรด</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($record->subjects as $subject)
                                    <tr>
                                        <td>{{ $subject->subject_name }}</td>
                                        <td class="text-center">{{ $subject->pivot->score }}</td>
                                        <td class="text-center">{{ number_format($subject->pivot->grade, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="alert alert-warning text-center fw-bold">
        ยังไม่มีข้อมูลผลการเรียน
    </div>
    @endif
</div>

{{-- JS สำหรับเปลี่ยนข้อความปุ่ม --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const collapseElements = document.querySelectorAll('.collapse');
    collapseElements.forEach(function (collapseEl) {
        collapseEl.addEventListener('show.bs.collapse', function () {
            const button = document.querySelector(`[data-bs-target="#${collapseEl.id}"]`);
            if (button) button.textContent = 'ซ่อนรายวิชา';
        });
        collapseEl.addEventListener('hide.bs.collapse', function () {
            const button = document.querySelector(`[data-bs-target="#${collapseEl.id}"]`);
            if (button) button.textContent = 'แสดงรายวิชา';
        });
    });
});
</script>
@endsection