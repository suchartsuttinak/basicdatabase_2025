@extends('admin_client.admin_client')
@section('content')

 <div class="container-fluid mt-4">
     <form action="{{ isset($absent) && $absent instanceof \App\Models\Absent 
    ? route('absent.update', $absent->id) 
    : route('absent.store') }}" method="POST">
    @csrf
    @if(isset($absent) && $absent instanceof \App\Models\Absent)
        @method('PUT')
    @endif



        {{-- ✅ hidden fields --}}
        <input type="hidden" name="client_id" value="{{ $client->id }}">
        <input type="hidden" name="education_record_id" value="{{ optional($educationRecord)->id }}">

       {{-- 🏫 หัวฟอร์ม --}}
            <div class="mb-4 text-center">
                <h4 class="fw-bold text-dark">
                    <i class="bi bi-journal-text me-2"></i>
                    {{ isset($absent) ? 'แก้ไขการบันทึกการขาดเรียน' : 'บันทึกการขาดเรียนของเด็ก' }}
                </h4>
            </div>

        {{-- 🔒 Layout 2 คอลัมน์ --}}
       <div class="row gx-2 align-items-stretch">
            {{-- ✅ คอลัมน์ซ้าย: ข้อมูลเด็ก --}}
            <div class="col-md-3">
                <div class="card shadow-sm rounded-0 border-0 h-100">
                    <div class="card-header bg-light fw-bold text-dark">
                        <i class="bi bi-person-lines-fill me-2"></i> ข้อมูลเด็ก
                    </div>

                    <div class="card-body bg-white">
                        <div class="row mb-2">
                            <div class="col-5 fw-bold text-dark">
                                <i class="bi bi-person-fill text-primary me-2"></i>ชื่อ-นามสกุล:
                            </div>
                            <div class="col-7">{{ $client->full_name }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 fw-bold text-dark">
                                <i class="bi bi-calendar3 text-primary me-2"></i>อายุ:
                            </div>
                            <div class="col-7">{{ $client->age }} ปี</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 fw-bold text-dark">
                                <i class="bi bi-building text-primary me-2"></i>สถานศึกษา:
                            </div>
                            <div class="col-7">{{ optional($educationRecord)->school_name ?? 'ไม่พบข้อมูล' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 fw-bold text-dark">
                                <i class="bi bi-mortarboard text-primary me-2"></i>ระดับชั้น:
                            </div>
                            <div class="col-7">{{ optional(optional($educationRecord)->education)->education_name ?? 'ไม่พบข้อมูล' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 fw-bold text-dark">
                                <i class="bi bi-mortarboard text-primary me-2"></i>ภาคเรียน:
                            </div>
                            <div class="col-7">{{ $educationRecord->semester ?? 'ไม่พบข้อมูล' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ✅ คอลัมน์ขวา: ข้อมูลการติดตาม --}}
            <div class="col-md-9">
                <div class="card shadow-sm rounded-0 border-0 h-100">
                    <div class="card-header bg-light fw-bold text-dark d-flex justify-content-between align-items-center">
                        <div>
                            <i class="bi bi-clipboard-check me-2"></i> ข้อมูลการขาดเรียน
                        </div>
                        @if(isset($absent))
                     <a href="{{ route('absent.add', $client->id) }}" class="btn btn-primary btn-md">
                        <i class="bi bi-plus-circle"></i> เพิ่มข้อมูล
                    </a>
                        @endif
                    </div>

                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label fw-bold">วันที่ขาดเรียน</label>
                                <input type="date" name="absent_date" class="form-control"
                                    value="{{ old('absent_date', $absent->absent_date ?? '') }}" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mt-3">
                                <label class="form-label fw-bold">สาเหตุที่ขาดเรียน</label>
                                <textarea name="cause" class="form-control" rows="2">{{ old('cause', $absent->cause ?? '') }}</textarea>
                            </div>
                            <div class="col-md-6 mt-3">
                                <label class="form-label fw-bold">การดำเนินงาน</label>
                                <textarea name="operation" class="form-control" rows="2">{{ old('operation', $absent->operation ?? '') }}</textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 mt-3">
                                <label class="form-label fw-bold">หมายเหตุ</label>
                                <textarea name="remark" class="form-control" rows="2">{{ old('remark', $absent->remark ?? '') }}</textarea>
                            </div>

                            <div class="col-md-3 mt-3">
                                <label class="form-label fw-bold">วันที่บันทึก</label>
                                <input type="date" name="record_date" class="form-control"
                                    value="{{ old('record_date', $absent->record_date ?? '') }}" required>
                            </div>
                        </div>

                         <div class="row mb-3">
                            <div class="col-md-6 mt-3">
                                <label class="form-label fw-bold">ชื่อ-สกุล ผู้ดูแลเด็ก</label>
                                <input type="text" name="teacher" class="form-control"
                                    value="{{ old('teacher', $absent->teacher ?? '') }}">
                            </div>
                            <div class="col-md-6 mt-3 d-flex justify-content align-items-end">
                                <button type="submit" class="btn btn-success px-3">
                                    <i class="bi bi-save me-1"></i>
                                    {{ isset($absent) ? 'อัปเดตข้อมูล' : 'บันทึกผล' }}
                                </button>
                            </div>
                        </div>
                            
                   
                </div> {{-- end card --}}
            </div> {{-- end col-md-9 --}}
        </div> {{-- end row --}}
    </form>
</div>
           @if($absents->isNotEmpty())
    <div class="card mt-4 shadow-sm rounded border-0">
      
        <div class="card-body">
            <div class="table-responsive">
                <table id="datatable-absent" class="table table-striped table-hover align-middle w-100">
                    <thead class="table-primary text-center">
                        <tr>
                            <th>ลำดับ</th>
                            <th>วันที่ขาดเรียน</th>
                            <th>สาเหตุ</th>
                            <th>การดำเนินงาน</th>
                            <th>สถานศึกษา</th>
                            <th>ระดับชั้น</th>
                            <th>การจัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($absents as $index => $absent)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ \Carbon\Carbon::parse($absent->absent_date)->format('d/m/Y') }}</td>
                               <td title="{{ $absent->cause }}">
                                    {{ \Illuminate\Support\Str::limit($absent->cause ?? '-', 20) }}
                                </td>
                                <td title="{{ $absent->operation }}">
                                    {{ \Illuminate\Support\Str::limit($absent->operation ?? '-', 20) }}
                                </td>
                                <td>{{ optional($absent->educationRecord)->school_name ?? 'ไม่พบข้อมูล' }}</td>
                                <td>{{ optional(optional($absent->educationRecord)->education)->education_name ?? 'ไม่พบข้อมูล' }}</td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('absent.edit', $absent->id) }}" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil-square"></i> แก้ไข
                                        </a>

                                        <button type="button" class="btn btn-danger btn-sm"
                                                onclick="confirmDelete({{ $absent->id }})">
                                            <i class="bi bi-trash"></i> ลบ
                                        </button>

                                        <a href="{{ route('absent.report', $absent->id) }}" class="btn btn-info btn-sm">
                                            <i class="bi bi-file-earmark-text"></i> รายงาน
                                        </a>
                                    </div>

                                    <form id="delete-form-{{ $absent->id }}"
                                          action="{{ route('absent.delete', $absent->id) }}"
                                          method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">
                                    <i class="bi bi-info-circle"></i> ยังไม่มีข้อมูลการติดตาม
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif
@endsection

@push('scripts')
    <!-- ✅ Init DataTable -->
    <script>
        $(document).ready(function() {
            $('#datatable-absent').DataTable({
                responsive: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/th.json'
                }
            });
        });
    </script>

    <!-- SweetAlert2 สำหรับยืนยันการลบ -->
            <script>
            function confirmDelete(id) {
                Swal.fire({
                    title: 'ท่านแน่ใจ ?',
                    text: 'ลบข้อมูลนี้ใช่หรือไม่ ?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'ตกลง',
                    cancelButtonText: 'ยกเลิก',
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete-form-' + id).submit();
                    }
                });
            }
            </script>

@endpush