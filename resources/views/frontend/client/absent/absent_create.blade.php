@extends('admin_client.admin_client')
@section('content')
<div class="container-fluid mt-2">
    <div class="card shadow-sm border-secondary">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-2">
            <h5 class="mb-0">
                <i class="bi bi-journal-text me-2"></i> การบันทึกการขาดเรียน
            </h5>
            <!-- ปุ่มเปิด Modal -->
            <button class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#absentModal">
                <i class="bi bi-plus-circle"></i> {{ isset($absent) ? 'แก้ไขข้อมูล' : 'เพิ่มข้อมูล' }}
            </button>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="absentModal" tabindex="-1" aria-labelledby="absentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header bg-primary text-white py-2">
                <h5 class="modal-title" id="absentModalLabel">
                    {{ isset($absent) ? 'แก้ไขการบันทึกการขาดเรียน' : 'บันทึกการขาดเรียนของเด็ก' }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ isset($absent) ? route('absent.update', $absent->id) : route('absent.store') }}" method="POST">
                @csrf
                @if(isset($absent)) @method('PUT') @endif

                <div class="modal-body">
                    <input type="hidden" name="client_id" value="{{ $client->id }}">
                    <input type="hidden" name="education_record_id" value="{{ optional($educationRecord)->id }}">

                    <div class="row gx-3 gy-2">
                        <!-- ข้อมูลเด็ก -->
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm h-100 small">
                                <div class="card-header bg-light fw-bold py-1">
                                    <i class="bi bi-person-lines-fill me-2"></i> ข้อมูลเด็ก
                                </div>
                                <div class="card-body py-2">
                                    @foreach([
                                        ['icon'=>'person-fill','label'=>'ชื่อ-นามสกุล','value'=>$client->full_name],
                                        ['icon'=>'calendar3','label'=>'อายุ','value'=>$client->age.' ปี'],
                                        ['icon'=>'building','label'=>'สถานศึกษา','value'=>optional($educationRecord)->school_name ?? 'ไม่พบข้อมูล'],
                                        ['icon'=>'mortarboard','label'=>'ระดับชั้น','value'=>optional(optional($educationRecord)->education)->education_name ?? 'ไม่พบข้อมูล'],
                                        ['icon'=>'mortarboard','label'=>'ภาคเรียน','value'=>optional($educationRecord->semester)->semester_name ?? 'ไม่พบข้อมูล'],
                                    ] as $item)
                                        <div class="row mb-1">
                                            <div class="col-5 fw-bold">
                                                <i class="bi bi-{{ $item['icon'] }} text-primary me-1"></i>{{ $item['label'] }}:
                                            </div>
                                            <div class="col-7">{{ $item['value'] }}</div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- ฟอร์มการขาดเรียน -->
                        <div class="col-md-8">
                            <div class="card border-0 shadow-sm h-100 small">
                                <div class="card-header bg-light fw-bold py-1">
                                    <i class="bi bi-clipboard-check me-2"></i> ข้อมูลการขาดเรียน
                                </div>
                                <div class="card-body py-2">
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label">วันที่ขาดเรียน</label>
                                            <input type="date" name="absent_date" class="form-control form-control-sm"
                                                value="{{ old('absent_date', $absent->absent_date ?? '') }}" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">วันที่บันทึก</label>
                                            <input type="date" name="record_date" class="form-control form-control-sm"
                                                value="{{ old('record_date', $absent->record_date ?? '') }}" required>
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
                                        <div class="col-md-6">
                                            <label class="form-label">ชื่อ-สกุล ผู้ดูแลเด็ก</label>
                                            <input type="text" name="teacher" class="form-control form-control-sm"
                                                value="{{ old('teacher', $absent->teacher ?? '') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- row -->
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save me-1"></i> {{ isset($absent) ? 'อัปเดตข้อมูล' : 'บันทึกผล' }}
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i> ปิด
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

        <!-- ตาราง absents -->
        @if($absents->isNotEmpty())
            <div class="card shadow-sm rounded border-0 mt-3 me-2 ms-2">
                <div class="card-body p-2">
                    <div class="table-responsive">
                        <table id="datatable-absent" class="table table-sm table-striped table-hover align-middle w-100 mb-0">
                            <thead class="table-primary text-center small">
                                <tr>
                                    <th style="width:15%">วันที่ขาดเรียน</th>
                                    <th style="width:30%">สาเหตุ</th>
                                    <th style="width:20%">สถานศึกษา</th>
                                    <th style="width:15%">ระดับชั้น</th>
                                    <th style="width:20%">การจัดการ</th>
                                </tr>
                            </thead>
                            <tbody class="small">
                                @foreach ($absents as $absent)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($absent->absent_date)->format('d/m/Y') }}</td>
                                        <td title="{{ $absent->cause }}">{{ \Illuminate\Support\Str::limit($absent->cause ?? '-', 30) }}</td>
                                        <td>{{ optional($absent->educationRecord)->school_name ?? 'ไม่พบข้อมูล' }}</td>
                                        <td>{{ optional(optional($absent->educationRecord)->education)->education_name ?? 'ไม่พบข้อมูล' }}</td>
                                        <td class="text-center">
                                            <div class="d-flex flex-wrap justify-content-center gap-1">
                                                <!-- ปุ่มแก้ไข เปิด Modal -->
                                                <button type="button" class="btn btn-sm btn-warning"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#absentEditModal-{{ $absent->id }}">
                                                    <i class="bi bi-pencil-square"></i> แก้ไข
                                                </button>

                                                <!-- ปุ่มลบ -->
                                                <button type="button" class="btn btn-sm btn-danger"
                                                        onclick="confirmDelete({{ $absent->id }})">
                                                    <i class="bi bi-trash"></i> ลบ
                                                </button>

                                                <!-- ปุ่มรายงาน -->
                                                <a href="{{ route('absent.report', $absent->id) }}" class="btn btn-sm btn-info">
                                                    <i class="bi bi-file-earmark-text"></i> รายงาน
                                                </a>
                                            </div>

                                            <!-- ฟอร์มลบแบบซ่อน -->
                                            <form id="delete-form-{{ $absent->id }}"
                                                action="{{ route('absent.delete', $absent->id) }}"
                                                method="POST" style="display:none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- ✅ Modal Edit สำหรับแต่ละ absent -->
                                    <div class="modal fade" id="absentEditModal-{{ $absent->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content shadow-sm border-0">
                                                <form method="POST" action="{{ route('absent.update', $absent->id) }}">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="modal-header bg-primary text-white py-2">
                                                        <h5 class="modal-title">
                                                            <i class="bi bi-pencil-square"></i> แก้ไขการบันทึกการขาดเรียน
                                                        </h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <div class="modal-body small">
                                                        <input type="hidden" name="client_id" value="{{ $client->id }}">
                                                        <input type="hidden" name="education_record_id" value="{{ $educationRecord->id ?? '' }}">

                                                        <div class="row mb-3">
                                                            <div class="col-md-4">
                                                                <label class="form-label fw-bold small">วันที่ขาดเรียน</label>
                                                                <input type="date" name="absent_date" class="form-control form-control-sm"
                                                                    value="{{ old('absent_date', $absent->absent_date) }}" required>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-label fw-bold small">วันที่บันทึก</label>
                                                                <input type="date" name="record_date" class="form-control form-control-sm"
                                                                    value="{{ old('record_date', $absent->record_date) }}" required>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold small">สาเหตุที่ขาดเรียน</label>
                                                                <textarea name="cause" class="form-control form-control-sm" rows="2">{{ old('cause', $absent->cause) }}</textarea>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold small">การดำเนินงาน</label>
                                                                <textarea name="operation" class="form-control form-control-sm" rows="2">{{ old('operation', $absent->operation) }}</textarea>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold small">หมายเหตุ</label>
                                                                <textarea name="remark" class="form-control form-control-sm" rows="2">{{ old('remark', $absent->remark) }}</textarea>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold small">ชื่อ-สกุล ผู้ดูแลเด็ก</label>
                                                                <input type="text" name="teacher" class="form-control form-control-sm"
                                                                    value="{{ old('teacher', $absent->teacher) }}">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Footer -->
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                            <i class="bi bi-x-circle"></i> ยกเลิก
                                                        </button>
                                                        <button type="submit" class="btn btn-success">
                                                            <i class="bi bi-save"></i> อัปเดตข้อมูล
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div> <!-- ปิด table-responsive -->
                </div> <!-- ปิด card-body -->
            </div> <!-- ปิด card -->
        @endif
    @endsection

  <!-- SweetAlert2 สำหรับยืนยันการลบ -->
        @push('scripts')
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

        // ✅ DataTable สำหรับ absents
        $(document).ready(function() {
            $('#datatable-absent').DataTable({
                responsive: true,
                language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/th.json' }
            });
        });
    </script>
@endpush