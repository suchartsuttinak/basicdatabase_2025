@extends('admin_client.admin_client')
@section('content')

{{-- ส่วนหัวแบบราชการ --}}
    <div class="mt-4 mb-4">
        <h5 class="fw-bold text-center mb-3 ">แบบรายงานผลการเรียน</h5>
        <div class="ps-2">
            <div class="d-flex align-items-center mb-2">
                <i class="mdi mdi-account text-primary fs-5 me-2"></i>
                <span class="fw-bold text-dark">ชื่อ-นามสกุล:</span>
                <span class="ms-2 text-secondary">{{ $client->full_name }}</span>
            </div>

            <div class="d-flex align-items-center mb-2">
                <i class="mdi mdi-cake-variant text-success fs-5 me-2"></i>
                <span class="fw-bold text-dark">อายุ:</span>
                <span class="ms-2 text-secondary">{{ $client->age }} ปี</span>
            </div>
        </div>
    </div>

{{-- รายการผลการเรียนรายภาคเรียน --}}
@foreach ($educationRecords as $index => $record)
    <div class="card mb-4 shadow-sm border-0">
        {{-- ส่วนหัวโรงเรียน --}}
        <div class="card-body py-2 border-bottom">
            <h5 class="fw-bold text-dark mb-0">
                <i class="mdi mdi-school-outline text-primary me-1"></i>
                สถานศึกษา: {{ $record->school_name }}
            </h5>
           <h6 class="text-muted mb-0">
    <i class="mdi mdi-account-school-outline text-secondary me-1"></i>
    ระดับชั้นเรียน:
    {{ $record->education->education_name ? $record->education->education_name : 'ไม่ระบุระดับชั้นเรียน' }}
</h6>

        </div>

        {{-- ส่วนหัวภาคเรียนและวันที่ + ปุ่มแก้ไข --}}
             <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <div class="fw-bold">
                    <i class="mdi mdi-calendar-range text-secondary me-1"></i>
                    ภาคเรียน: {{ $record->semester }}
                    <span class="mx-2">|</span>
                    <i class="mdi mdi-calendar text-secondary me-1"></i>
                    วันที่บันทึก:
                    {{
                        \Carbon\Carbon::parse($record->record_date)->format('d/m') . '/' .
                        (\Carbon\Carbon::parse($record->record_date)->year + 543)
                    }}
                </div>
            <div>
                <a href="{{ route('education_record.edit', $record->id) }}" 
                   class="btn btn-warning btn-sm">
                   <span class="mdi mdi-pencil"></span> แก้ไขข้อมูล
                </a>
                <button class="btn btn-outline-primary btn-sm ms-2" 
                        type="button" 
                        data-bs-toggle="collapse" 
                        data-bs-target="#recordTable{{ $index }}" 
                        aria-expanded="{{ $index == 0 ? 'true' : 'false' }}" 
                        aria-controls="recordTable{{ $index }}">
                    {{ $index == 0 ? 'ซ่อนตาราง' : 'แสดงตาราง' }}
                </button>
            </div>
        </div>

        {{-- ตารางผลการเรียน --}}
        <div class="collapse {{ $index == 0 ? 'show' : '' }}" id="recordTable{{ $index }}">
            <div class="card-body">
                <table class="table table-bordered table-sm mb-0">
                    <thead class="table-secondary text-center align-middle">
                        <tr>
                            <th style="width: 50%">ชื่อวิชา</th>
                            <th style="width: 25%">คะแนน</th>
                            <th style="width: 25%">เกรด</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($record->subjects as $subject)
                            <tr>
                                <td>{{ $subject->subject_name }}</td>
                                <td class="text-center">{{ $subject->pivot->score }}</td>
                                <td class="text-center">{{ number_format($subject->pivot->grade, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2" class="text-end fw-bold">เกรดเฉลี่ยภาคเรียน</td>
                            <td class="text-center fw-bold text-primary">
                                {{ number_format($record->grade_average, 2) }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endforeach

     
@endsection

