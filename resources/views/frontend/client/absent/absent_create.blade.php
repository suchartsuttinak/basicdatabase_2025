@extends('admin_client.admin_client')
@section('content')

 <div class="container-fluid mt-4">
    <form action="{{ isset($absent) ? route('absent.update', $absent->id) : route('absent.store') }}" method="POST">
        @csrf
        @if(isset($absent))
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
  <div class="row gx-1 gy-1 align-items-stretch">
    {{-- ✅ คอลัมน์ซ้าย: ข้อมูลเด็ก --}}
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

    {{-- ✅ คอลัมน์ขวา: ข้อมูลการขาดเรียน --}}
    <div class="col-md-9 d-flex">
        <div class="card shadow-sm rounded-1 border-0 h-100 flex-fill small">
            <div class="card-header bg-light fw-bold text-dark d-flex justify-content-between align-items-center py-1 px-2">
                <div><i class="bi bi-clipboard-check me-2"></i> ข้อมูลการขาดเรียน</div>
                @if(isset($absent))
                    <a href="{{ route('absent.add', $client->id) }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-plus-circle"></i> เพิ่มข้อมูล
                    </a>
                @endif
            </div>

            <div class="card-body px-2 py-1">
                <div class="row mb-1">
                    <div class="col-md-3">
                        <label class="form-label fw-bold small">วันที่ขาดเรียน</label>
                        <input type="date" name="absent_date" class="form-control form-control-sm"
                            value="{{ old('absent_date', $absent->absent_date ?? '') }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-1">
                        <label class="form-label fw-bold small">สาเหตุที่ขาดเรียน</label>
                        <textarea name="cause" class="form-control form-control-sm" rows="2">{{ old('cause', $absent->cause ?? '') }}</textarea>
                    </div>
                    <div class="col-md-6 mb-1">
                        <label class="form-label fw-bold small">การดำเนินงาน</label>
                        <textarea name="operation" class="form-control form-control-sm" rows="2">{{ old('operation', $absent->operation ?? '') }}</textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-1">
                        <label class="form-label fw-bold small">หมายเหตุ</label>
                        <textarea name="remark" class="form-control form-control-sm" rows="2">{{ old('remark', $absent->remark ?? '') }}</textarea>
                    </div>
                    <div class="col-md-3 mb-1">
                        <label class="form-label fw-bold small">วันที่บันทึก</label>
                        <input type="date" name="record_date" class="form-control form-control-sm"
                            value="{{ old('record_date', $absent->record_date ?? '') }}" required>
                    </div>
                </div>

                <div class="row align-items-end">
                    <div class="col-md-6 mb-1">
                        <label class="form-label fw-bold small">ชื่อ-สกุล ผู้ดูแลเด็ก</label>
                        <input type="text" name="teacher" class="form-control form-control-sm"
                            value="{{ old('teacher', $absent->teacher ?? '') }}">
                    </div>
                    <div class="col-md-6 mb-1 ">
                        <button type="submit" class="btn btn-sm btn-success px-3">
                            <i class="bi bi-save me-1"></i>
                            {{ isset($absent) ? 'อัปเดตข้อมูล' : 'บันทึกผล' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
</div>
       @if($absents->isNotEmpty())
    <div class="card mt-2 shadow-sm rounded border-0">
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
@endpush