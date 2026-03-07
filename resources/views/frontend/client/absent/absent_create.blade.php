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

      {{-- ข้อมูล client --}}
            <div class="card mb-0 shadow-sm">
                <div class="card-body">
                <div class="row mb-0">
                    <div class="col-12 col-md-8">
                    <p class="mb-1 d-flex align-items-center flex-wrap">
                        <i class="bi bi-person-fill me-2 text-primary"></i>
                        <span class="fw-bold">ชื่อ-สกุล :</span>
                        <span class="ms-2">{{ $client->fullname ?? '-' }}</span>
                        <span class="ms-4">
                        <i class="bi bi-calendar-heart me-2 text-success"></i>
                        <span class="fw-bold">อายุ :</span> {{ $client->age ?? '-' }} ปี
                        </span>
                    </p>
                    </div>
                </div>
                </div>
            </div>
</div>

<div class="modal fade" id="absentModal" tabindex="-1" aria-labelledby="absentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header bg-primary text-white py-2">
                <h5 class="modal-title" id="absentModalLabel">
                    {{ isset($absent) ? 'แก้ไขการบันทึกการขาดเรียน' : 'บันทึกการขาดเรียนของเด็ก' }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form id="absent-form"
                  action="{{ isset($absent) ? route('absent.update', $absent->id) : route('absent.store') }}"
                  method="POST">
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
                                            <input type="date" name="absent_date"
                                                class="form-control form-control-sm @error('absent_date') is-invalid @enderror"
                                                value="{{ old('absent_date', $absent->absent_date ?? \Carbon\Carbon::now()->format('Y-m-d')) }}" required>
                                            @error('absent_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label">วันที่บันทึก</label>
                                            <input type="date" name="record_date"
                                                class="form-control form-control-sm @error('record_date') is-invalid @enderror"
                                                value="{{ old('record_date', $absent->record_date ?? \Carbon\Carbon::now()->format('Y-m-d')) }}" required>
                                            @error('record_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                 <div class="row mb-3">
                                      <div class="col-md-6">
                                            <label class="form-label">สาเหตุที่ขาดเรียน</label>
                                            <textarea name="cause"
                                                    class="form-control form-control-sm @error('cause') is-invalid @enderror"
                                                    rows="2">{{ old('cause', $absent->cause ?? '') }}</textarea>
                                            @error('cause')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                 <div class="col-md-6">
                                            <label class="form-label">การดำเนินงาน</label>
                                            <textarea name="operation"
                                                    class="form-control form-control-sm @error('operation') is-invalid @enderror"
                                                    rows="2">{{ old('operation', $absent->operation ?? '') }}</textarea>
                                            @error('operation')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">หมายเหตุ</label>
                                            <textarea name="remark" class="form-control form-control-sm" rows="2">{{ old('remark', $absent->remark ?? '') }}</textarea>
                                        </div>
                                       <div class="col-md-6">
                                            <label class="form-label">ชื่อ-สกุล ผู้ดูแลเด็ก</label>
                                            <input type="text" name="teacher"
                                                class="form-control form-control-sm @error('teacher') is-invalid @enderror"
                                                value="{{ old('teacher', $absent->teacher ?? '') }}">
                                            @error('teacher')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
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
                    <!-- ปุ่มปิด -->
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btn-cancel-absent">
                        <i class="bi bi-x-circle me-1"></i> ปิด
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ✅ เปิด modal อัตโนมัติเมื่อมี error --}}
@if ($errors->any())
<script>
document.addEventListener("DOMContentLoaded", function() {
    var myModal = new bootstrap.Modal(document.getElementById('absentModal'));
    myModal.show();
});
</script>
@endif



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
                                    <!-- ปุ่มแก้ไข -->
                                    <button type="button" class="btn btn-sm btn-warning"
                                            onclick="openEditAbsent({{ $absent->id }})">
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
                    @endforeach
                </tbody>
            </table>
        </div> <!-- ปิด table-responsive -->
    </div> <!-- ปิด card-body -->
</div> <!-- ปิด card -->
@else
<div class="alert alert-info text-center small mt-2 ms-2 me-2">
    <i class="bi bi-info-circle"></i> ยังไม่มีข้อมูลการขาดเรียน       
</div>
@endif

<!-- ✅ Modal Edit ตัวเดียว -->
<div class="modal fade" id="editAbsentModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content shadow-sm border-0">
            <form id="edit-absent-form" method="POST">
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
                            <input type="date" id="edit_absent_date" name="absent_date" class="form-control form-control-sm" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small">วันที่บันทึก</label>
                            <input type="date" id="edit_record_date" name="record_date" class="form-control form-control-sm" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">สาเหตุที่ขาดเรียน</label>
                            <textarea id="edit_cause" name="cause" class="form-control form-control-sm" rows="2"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">การดำเนินงาน</label>
                            <textarea id="edit_operation" name="operation" class="form-control form-control-sm" rows="2"></textarea>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">หมายเหตุ</label>
                            <textarea id="edit_remark" name="remark" class="form-control form-control-sm" rows="2"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">ชื่อ-สกุล ผู้ดูแลเด็ก</label>
                            <input type="text" id="edit_teacher" name="teacher" class="form-control form-control-sm">
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
    @endsection

@push('scripts')
<script>
    // ✅ SweetAlert2 สำหรับยืนยันการลบ
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

    $(document).ready(function() {
        // ✅ DataTable สำหรับ absents
        $('#datatable-absent').DataTable({
            responsive: true,
            language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/th.json' }
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        const absentModal = document.getElementById('absentModal');  
        const addBtn = document.getElementById('btn-add-absent');
        const cancelBtn = document.getElementById('btn-cancel-absent');
        const absentForm = absentModal?.querySelector('form');

        // ✅ reset ฟอร์ม Add modal
        function resetAbsentForm(){
            if(absentForm){
                absentForm.reset();
                const today = new Date().toISOString().split('T')[0];
                absentForm.querySelector('input[name="absent_date"]').value = today;
                absentForm.querySelector('input[name="record_date"]').value = today;
                absentForm.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                absentForm.querySelectorAll('.invalid-feedback').forEach(el => el.innerText = '');
            }
        }

        // ✅ กดปุ่ม "เพิ่มการขาดเรียน"
        addBtn?.addEventListener('click', resetAbsentForm);

        // ✅ กดปุ่ม "ปิด/ยกเลิก" → reset input (ไม่ refresh หน้า)
        cancelBtn?.addEventListener('click', resetAbsentForm);

        // ✅ เมื่อ Add modal ถูกปิด → reset input (ไม่ refresh หน้า)
        absentModal?.addEventListener('hidden.bs.modal', resetAbsentForm);
    });

    // ✅ ฟังก์ชันเปิด Edit modal
    function openEditAbsent(id){
        const form = $('#edit-absent-form');
        // เคลียร์ค่าเก่า + error feedback ก่อน
        form[0].reset();
        form.find('.is-invalid').removeClass('is-invalid');
        form.find('.invalid-feedback').remove();

        $.ajax({
            url: "/absent/edit/" + id,
            type: "GET",
            dataType: "json",
            success: function(data){
                // เติมค่าฟอร์ม Edit
                $('#edit_absent_date').val(data.absent_date ?? '');
                $('#edit_record_date').val(data.record_date ?? '');
                $('#edit_cause').val(data.cause ?? '');
                $('#edit_operation').val(data.operation ?? '');
                $('#edit_remark').val(data.remark ?? '');
                $('#edit_teacher').val(data.teacher ?? '');
                $('#edit-absent-form').attr('action', '/absent/update/' + data.id);

                // เปิด Edit modal
                const modalEl = document.getElementById('editAbsentModal');
                const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                modal.show();
            }
        });
    }

    // ✅ reset ฟอร์ม Edit modal เมื่อกดปุ่มยกเลิกหรือ modal ถูกปิด
    document.addEventListener("DOMContentLoaded", function() {
        const editModal = document.getElementById('editAbsentModal');
        const editForm = document.getElementById('edit-absent-form');
        const cancelEditBtn = editModal?.querySelector('.btn-secondary[data-bs-dismiss="modal"]');

        function resetEditForm(){
            if(editForm){
                editForm.reset();
                editForm.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                editForm.querySelectorAll('.invalid-feedback').forEach(el => el.innerText = '');
            }
        }

        cancelEditBtn?.addEventListener('click', resetEditForm);
        editModal?.addEventListener('hidden.bs.modal', resetEditForm);
    });
</script>

{{-- ✅ เปิด Add modal อัตโนมัติเมื่อมี error --}}
@if ($errors->any())
<script>
document.addEventListener("DOMContentLoaded", function() {
    const myModal = bootstrap.Modal.getOrCreateInstance(document.getElementById('absentModal'));
    myModal.show();
});
</script>
@endif
@endpush