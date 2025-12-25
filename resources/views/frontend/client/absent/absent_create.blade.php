@extends('admin_client.admin_client')
@section('content')

 <div class="container-fluid mt-2">
    <div class="card shadow-sm border-secondary">
        <!-- Header พร้อมปุ่ม toggle -->
        <div class="card-header bg-dark text-white text-center py-2 d-flex justify-content-between align-items-center">
            <h4 class="mb-0">
                <i class="bi bi-journal-text me-2"></i>
                {{ isset($absent) ? 'แก้ไขการบันทึกการขาดเรียน' : 'บันทึกการขาดเรียนของเด็ก' }}
            </h4>
          <!-- ปุ่ม -->
                <button id="toggleAbsentBtn"
                        class="btn btn-sm btn-light d-flex align-items-center"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#absentForm"
                        aria-expanded="{{ isset($absent) ? 'true' : 'false' }}"
                        aria-controls="absentForm">
                    <i class="bi {{ isset($absent) ? 'bi-chevron-up' : 'bi-chevron-down' }}"></i>
                    <span class="ms-1">
                        {{ isset($absent) ? 'ซ่อน/ฟอร์ม' : 'เพิ่มข้อมูล' }}
                    </span>
                </button>
        </div>

        <!-- ฟอร์มซ่อน/แสดง -->
        <div id="absentForm" class="collapse {{ isset($absent) ? 'show' : '' }}">
            <div class="card-body p-3">
                <form action="{{ isset($absent) ? route('absent.update', $absent->id) : route('absent.store') }}" method="POST" class="position-relative">
                    @csrf
                    @if(isset($absent))
                        @method('PUT')
                    @endif

                     <!-- ปุ่มมุมขวาบน -->
                        <div class="d-flex justify-content-end mb-3">
                            <!-- ปุ่มบันทึก/อัปเดต -->
                            <button type="submit" class="btn btn-sm btn-success px-3 me-2">
                                <i class="bi bi-save me-1"></i>
                                {{ isset($absent) ? 'อัปเดตข้อมูล' : 'บันทึกผล' }}
                            </button>

                            <!-- ปุ่มกลับ: แสดงเฉพาะตอนแก้ไข -->
                            @if(isset($absent))
                                <a href="{{ route('absent.add', $client->id) }}" class="btn btn-sm btn-danger px-2">
                                    <i class="bi bi-arrow-left-circle me-1"></i> กลับไปหน้าเพิ่ม
                                </a>
                            @endif
                        </div>

                    <!-- hidden fields -->
                    <input type="hidden" name="client_id" value="{{ $client->id }}">
                    <input type="hidden" name="education_record_id" value="{{ optional($educationRecord)->id }}">

                    <div class="row gx-2 gy-2">
                        <!-- ✅ คอลัมน์ซ้าย: ข้อมูลเด็ก -->
                        <div class="col-md-3 d-flex">
                            <div class="card shadow-sm rounded-1 border-0 h-100 flex-fill small">
                                <div class="card-header bg-light fw-bold text-dark py-1 px-2">
                                    <i class="bi bi-person-lines-fill me-2"></i> ข้อมูลเด็ก
                                </div>
                                <div class="card-body bg-white px-2 py-1">
                                    @foreach([
                                        ['icon' => 'person-fill', 'label' => 'ชื่อ-นามสกุล', 'value' => $client->full_name],
                                        ['icon' => 'calendar3', 'label' => 'อายุ', 'value' => $client->age . ' ปี'],
                                        ['icon' => 'building', 'label' => 'สถานศึกษา', 'value' => optional($educationRecord)->school_name ?? 'ไม่พบข้อมูล'],
                                        ['icon' => 'mortarboard', 'label' => 'ระดับชั้น', 'value' => optional(optional($educationRecord)->education)->education_name ?? 'ไม่พบข้อมูล'],
                                        ['icon' => 'mortarboard', 'label' => 'ภาคเรียน', 'value' => $educationRecord->semester ?? 'ไม่พบข้อมูล'],
                                    ] as $item)
                                        <div class="row mb-1">
                                            <div class="col-5 fw-bold text-dark small">
                                                <i class="bi bi-{{ $item['icon'] }} text-primary me-1"></i>{{ $item['label'] }}:
                                            </div>
                                            <div class="col-7 small">{{ $item['value'] }}</div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- ✅ คอลัมน์ขวา: ข้อมูลการขาดเรียน -->
                        <div class="col-md-9 d-flex">
                            <div class="card shadow-sm rounded-1 border-0 h-100 flex-fill small">
                                <div class="card-header bg-light fw-bold text-dark py-1 px-2">
                                    <i class="bi bi-clipboard-check me-2"></i> ข้อมูลการขาดเรียน
                                </div>

                                <div class="card-body px-2 py-1">
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label class="form-label">วันที่ขาดเรียน</label>
                                            <input type="date" name="absent_date" class="form-control form-control-sm"
                                                value="{{ old('absent_date', $absent->absent_date ?? '') }}" required>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">สาเหตุที่ขาดเรียน</label>
                                            <textarea name="cause" class="form-control form-control-sm" rows="2">{{ old('cause', $absent->cause ?? '') }}</textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">การดำเนินงาน</label>
                                            <textarea name="operation" class="form-control form-control-sm" rows="2">{{ old('operation', $absent->operation ?? '') }}</textarea>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">หมายเหตุ</label>
                                            <textarea name="remark" class="form-control form-control-sm" rows="2">{{ old('remark', $absent->remark ?? '') }}</textarea>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">วันที่บันทึก</label>
                                            <input type="date" name="record_date" class="form-control form-control-sm"
                                                value="{{ old('record_date', $absent->record_date ?? '') }}" required>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">ชื่อ-สกุล ผู้ดูแลเด็ก</label>
                                            <input type="text" name="teacher" class="form-control form-control-sm"
                                                value="{{ old('teacher', $absent->teacher ?? '') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- row -->
                </form>
            </div>
        </div>
    </div>
</div>

@if($absents->isNotEmpty())
    <div class="card shadow-sm rounded border-0 me-2 ms-2">
        <div class="card-body p-2">
            <div class="table-responsive">
                <table id="datatable-absent" class="table table-sm table-striped table-hover align-middle w-100 mb-0">
                    <thead class="table-primary text-center small">
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
                <tbody class="small">
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
                              <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('absent.edit', $absent->id) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil-square"></i> แก้ไข
                                    </a>

                                    <button type="button" class="btn btn-sm btn-danger"
                                    onclick="confirmDelete({{ $absent->id }})">
                                <i class="bi bi-trash"></i> ลบ
                            </button>
                                    <a href="{{ route('absent.report', $absent->id) }}" class="btn btn-sm btn-info">
                                        <i class="bi bi-file-earmark-text"></i> รายงาน
                                    </a>
                                </div>
                         
                                {{-- ฟอร์มลบแบบซ่อน --}}
                                 <form id="delete-form-{{ $absent->id }}"
                                action="{{ route('absent.delete', $absent->id) }}"
                                method="POST" style="display:none;">
                                @csrf
                                @method('DELETE')
                            </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted small">
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

        <!-- Script สำหรับเปิด-ซ่อนฟอร์ม -->
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const collapseEl = document.getElementById('absentForm');
                const toggleBtn = document.getElementById('toggleAbsentBtn');

                collapseEl.addEventListener('shown.bs.collapse', function () {
                    toggleBtn.innerHTML = '<i class="bi bi-chevron-up"></i><span class="ms-1">ซ่อน/ฟอร์ม</span>';
                });

                collapseEl.addEventListener('hidden.bs.collapse', function () {
                    toggleBtn.innerHTML = '<i class="bi bi-chevron-down"></i><span class="ms-1">เพิมข้อมูล</span>';
                });
            });
        </script>


        @endpush
