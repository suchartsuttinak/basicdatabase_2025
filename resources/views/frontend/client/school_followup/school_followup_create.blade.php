@extends('admin_client.admin_client')
@section('content')

<!-- ปุ่มเปิด Modal สำหรับเพิ่มข้อมูล -->
<button type="button" class="btn btn-primary btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#followupModal">
    <i class="bi bi-plus-circle"></i> เพิ่มการติดตามใหม่
</button>

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

<!-- Modal ฟอร์มติดตาม -->
<div class="modal fade" id="followupModal" tabindex="-1" aria-labelledby="followupModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered modal-fullscreen-sm-down">
    <div class="modal-content border-0 shadow-sm">

      <!-- Header -->
      <div class="modal-header bg-primary text-white py-2">
        <h5 class="modal-title fw-bold" id="followupModalLabel">
          <i class="bi bi-clipboard-check me-2"></i> แบบฟอร์มการติดตามผลการเรียน
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <!-- Form -->
      <form method="POST" action="{{ isset($followup) ? route('school_followup.update', $followup->id) : route('school_followup_store') }}">
        @csrf
        @if(isset($followup)) @method('PUT') @endif

        <input type="hidden" name="client_id" value="{{ $client->id }}">
        <input type="hidden" name="education_record_id" value="{{ $educationRecord->id ?? '' }}">

        <!-- Body -->
        <div class="modal-body">
          <div class="row gx-3 gy-3">

            <!-- ข้อมูลเด็ก -->
            <div class="col-md-3">
              <div class="card border-0 shadow-sm h-100 small">
                <div class="card-header bg-light fw-bold text-dark py-1 px-2">
                  <i class="bi bi-person-lines-fill me-2"></i> ข้อมูลเด็ก
                </div>
                <div class="card-body px-2 py-2">
                  <p class="mb-1"><strong>ชื่อ-นามสกุล:</strong> {{ $client->full_name }}</p>
                  <p class="mb-1"><strong>อายุ:</strong> {{ $client->age }} ปี</p>
                  <p class="mb-1"><strong>สถานศึกษา:</strong> {{ optional($educationRecord)->school_name ?? 'ไม่พบข้อมูล' }}</p>
                  <p class="mb-1"><strong>ระดับชั้น:</strong> {{ optional(optional($educationRecord)->education)->education_name ?? 'ไม่พบข้อมูล' }}</p>
                  <p class="mb-1"><strong>ภาคเรียน:</strong> {{ optional($educationRecord->semester)->semester_name ?? 'ไม่พบข้อมูล' }}</p>
                </div>
              </div>
            </div>

            <!-- ข้อมูลการติดตาม -->
            <div class="col-md-9">
              <div class="card border-0 shadow-sm h-100 small">
                <div class="card-header bg-light fw-bold text-dark py-1 px-2">
                  <i class="bi bi-clipboard-check me-2"></i> ข้อมูลการติดตาม
                </div>
                <div class="card-body px-2 py-2">

                  <!-- วันที่ / ครู / โทรศัพท์ -->
                  <div class="row mb-2">
                   <div class="col-4 mb-3">
  <label class="form-label fw-bold small">วันที่ตรวจ</label>
  <input type="date" name="date"
         class="form-control form-control-sm @error('date') is-invalid @enderror"
         value="{{ old('date', \Carbon\Carbon::now()->format('Y-m-d')) }}" required>
  @error('date')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>
                    <div class="col-4 mb-3">
                      <label class="form-label fw-bold small">ครูประจำชั้น</label>
                      <input type="text" name="teacher_name"
                             class="form-control form-control-sm @error('teacher_name') is-invalid @enderror"
                             value="{{ old('teacher_name', $followup->teacher_name ?? '') }}">
                      @error('teacher_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-4 mb-3">
                      <label class="form-label fw-bold small">โทรศัพท์</label>
                      <input type="text" name="tel"
                             class="form-control form-control-sm @error('tel') is-invalid @enderror"
                             value="{{ old('tel', $followup->tel ?? '') }}">
                      @error('tel') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                  </div>

                  <!-- การดำเนินงาน -->
                  <div class="mb-3">
                    <label class="form-label fw-bold small">การดำเนินงาน</label>
                    <div class="d-flex flex-wrap small">
                      <div class="form-check me-3">
                        <input class="form-check-input" type="radio" name="follow_type" value="self"
                               {{ old('follow_type', $followup->follow_type ?? '') == 'self' ? 'checked' : '' }}>
                        <label class="form-check-label">ติดตามด้วยตนเอง</label>
                      </div>
                      <div class="form-check me-3">
                        <input class="form-check-input" type="radio" name="follow_type" value="phone"
                               {{ old('follow_type', $followup->follow_type ?? '') == 'phone' ? 'checked' : '' }}>
                        <label class="form-check-label">โทรศัพท์</label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="follow_type" value="other"
                               {{ old('follow_type', $followup->follow_type ?? '') == 'other' ? 'checked' : '' }}>
                        <label class="form-check-label">อื่นๆ</label>
                      </div>
                    </div>
                    @error('follow_type') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                  </div>

                  <!-- ผลการติดตาม / หมายเหตุ -->
                  <div class="row mt-2">
                    <div class="col-md-6 mb-3">
                      <label class="form-label fw-bold small">ผลการติดตาม</label>
                      <textarea name="result"
                                class="form-control form-control-sm @error('result') is-invalid @enderror"
                                rows="2">{{ old('result', $followup->result ?? '') }}</textarea>
                      @error('result') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                      <label class="form-label fw-bold small">หมายเหตุ</label>
                      <textarea name="remark"
                                class="form-control form-control-sm @error('remark') is-invalid @enderror"
                                rows="2">{{ old('remark', $followup->remark ?? '') }}</textarea>
                      @error('remark') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                  </div>

                  <!-- ชื่อผู้ติดตาม -->
                  <div class="row mt-2">
                    <div class="col-md-6 mb-3">
                      <label class="form-label fw-bold small">ชื่อผู้ติดตาม</label>
                      <input type="text" name="contact_name"
                             class="form-control form-control-sm @error('contact_name') is-invalid @enderror"
                             value="{{ old('contact_name', $followup->contact_name ?? '') }}">
                      @error('contact_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                  </div>

                </div>
              </div>
            </div>

          </div>
        </div>

        <!-- Footer -->
        <div class="modal-footer justify-content-between py-2">
          <button type="button" class="btn btn-outline-secondary btn-sm px-3" id="btn-cancel-followup" data-bs-dismiss="modal">
            <i class="bi bi-x-circle me-1"></i> ยกเลิกการบันทึกข้อมูล
          </button>
          <button type="submit" class="btn btn-success btn-sm px-4 fw-bold">
            <i class="bi bi-save me-1"></i> {{ isset($followup) ? 'อัปเดตข้อมูล' : 'บันทึกผล' }}
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
    var myModal = new bootstrap.Modal(document.getElementById('followupModal'));
    myModal.show();
});
</script>
@endif

{{-- ตารางแสดงข้อมูล --}}
@if($followups->isNotEmpty())
<div class="card mt-2 shadow-sm rounded-1 border-0 ms-2 me-2">
    <div class="card-body p-2">
        <div class="table-responsive">
            <table id="datatable-followup" class="table table-sm table-striped table-hover align-middle w-100 mb-0">
                <thead class="table-primary text-center small">
                    <tr>
                        <th>วันที่ติดตาม</th>
                        <th>สถานศึกษา</th>
                        <th>ระดับชั้น</th>
                        <th>ครูประจำชั้น</th>
                        <th>โทรศัพท์</th>
                        <th>จัดการ</th>             
                    </tr>
                </thead>
                <tbody class="small">
                    @foreach ($followups as $followup)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($followup->follow_date)->format('d/m/Y') }}</td>
                            <td>{{ optional($followup->educationRecord)->school_name ?? 'ไม่พบข้อมูล' }}</td>
                            <td>{{ optional(optional($followup->educationRecord)->education)->education_name ?? 'ไม่พบข้อมูล' }}</td>
                            <td>{{ $followup->teacher_name ?? '-' }}</td>
                            <td>{{ $followup->tel ?? '-' }}</td>
                            <td class="text-center">
                                <div class="d-flex flex-wrap justify-content-center gap-1">
                                    <!-- ปุ่มแก้ไข -->
                                    <button type="button" class="btn btn-sm btn-warning"
                                            onclick="openEditFollowup({{ $followup->id }})">
                                        <i class="bi bi-pencil-square"></i> แก้ไข
                                    </button>

                                    <!-- ปุ่มลบ -->
                                    <button type="button" class="btn btn-sm btn-danger"
                                            onclick="confirmDelete({{ $followup->id }})">
                                        <i class="bi bi-trash"></i> ลบ
                                    </button>

                                    <!-- ปุ่มรายงาน -->
                                    <a href="{{ route('school_followup.report', $followup->id) }}" class="btn btn-sm btn-info">
                                        <i class="bi bi-file-earmark-text"></i> รายงาน
                                    </a>
                                </div>

                                <!-- ฟอร์มลบแบบซ่อน -->
                                <form id="delete-form-{{ $followup->id }}"
                                      action="{{ route('school_followup.delete', $followup->id) }}"
                                      method="POST" style="display:none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@else
<div class="alert alert-info text-center small mt-2 ms-2 me-2">
    <i class="bi bi-info-circle"></i> ยังไม่มีข้อมูลการติดตามผลการเรียน
</div>
@endif

<!-- ✅ Modal Edit ตัวเดียว -->
<div class="modal fade" id="editFollowupModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="edit-followup-form" method="POST">
        @csrf
        @method('PUT')

        <div class="modal-header bg-warning text-dark">
          <h5 class="modal-title"><i class="bi bi-pencil-square"></i> แก้ไขการติดตาม</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <input type="hidden" name="client_id" value="{{ $client->id }}">
          <input type="hidden" name="education_record_id" value="{{ $educationRecord->id ?? '' }}">

          <div class="row mb-3">
            <div class="col-md-4">
              <label class="form-label">วันที่ติดตาม</label>
              <input type="date" id="edit_follow_date" name="follow_date" class="form-control form-control-sm" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">ครูประจำชั้น</label>
              <input type="text" id="edit_teacher_name" name="teacher_name" class="form-control form-control-sm">
            </div>
            <div class="col-md-4">
              <label class="form-label">โทรศัพท์</label>
              <input type="text" id="edit_tel" name="tel" class="form-control form-control-sm">
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">การดำเนินงาน</label>
            <div class="d-flex flex-wrap small">
              <div class="form-check me-3">
                <input class="form-check-input" type="radio" name="follow_type" value="self" id="edit_follow_self">
                <label class="form-check-label" for="edit_follow_self">ติดตามด้วยตนเอง</label>
              </div>
              <div class="form-check me-3">
                <input class="form-check-input" type="radio" name="follow_type" value="phone" id="edit_follow_phone">
                <label class="form-check-label" for="edit_follow_phone">โทรศัพท์</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="follow_type" value="other" id="edit_follow_other">
                <label class="form-check-label" for="edit_follow_other">อื่นๆ</label>
              </div>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">ผลการติดตาม</label>
              <textarea id="edit_result" name="result" class="form-control form-control-sm" rows="3"></textarea>
            </div>
            <div class="col-md-6">
              <label class="form-label">หมายเหตุ</label>
              <textarea id="edit_remark" name="remark" class="form-control form-control-sm" rows="3"></textarea>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">ชื่อผู้ติดตาม</label>
              <input type="text" id="edit_contact_name" name="contact_name" class="form-control form-control-sm">
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
          <button type="submit" class="btn btn-warning">อัปเดตข้อมูล</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // ✅ DataTable สำหรับ followups
    $('#datatable-followup').DataTable({
        responsive: true,
        language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/th.json' }
    });
});

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

document.addEventListener("DOMContentLoaded", function() {
    // ====== Followup (Add modal) ======
    const followupModal = document.getElementById('followupModal');
    const cancelFollowupBtn = document.getElementById('btn-cancel-followup');
    const followupForm = followupModal?.querySelector('form');

    function resetFollowupForm(){
        if(followupForm){
            followupForm.reset();
            followupForm.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
            followupForm.querySelectorAll('.invalid-feedback').forEach(el => el.innerText = '');
        }
    }

    cancelFollowupBtn?.addEventListener('click', resetFollowupForm);
    followupModal?.addEventListener('hidden.bs.modal', resetFollowupForm);
});

// ====== ฟังก์ชันเปิด Edit modal (Followup) ======
function openEditFollowup(id){
    const form = $('#edit-followup-form');
    form[0].reset();
    form.find('.is-invalid').removeClass('is-invalid');
    form.find('.invalid-feedback').remove();

    $.ajax({
        url: "/school_followup/edit/" + id,
        type: "GET",
        dataType: "json",
        success: function(data){
            $('#edit_follow_date').val(data.follow_date ?? '');
            $('#edit_teacher_name').val(data.teacher_name ?? '');
            $('#edit_tel').val(data.tel ?? '');
            $('#edit_result').val(data.result ?? '');
            $('#edit_remark').val(data.remark ?? '');
            $('#edit_contact_name').val(data.contact_name ?? '');

            $('input[name="follow_type"]').prop('checked', false);
            $('input[name="follow_type"][value="'+data.follow_type+'"]').prop('checked', true);

            $('#edit-followup-form').attr('action', '/school_followup/update/' + data.id);

            const modalEl = document.getElementById('editFollowupModal');
            const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            modal.show();
        }
    });
}

</script>

@endpush