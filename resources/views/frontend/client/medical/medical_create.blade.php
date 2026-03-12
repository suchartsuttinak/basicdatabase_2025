@extends('admin_client.admin_client')
@section('content')

  <div class="container-fluid mt-2">
    <!-- ฟอร์ม -->
    <div class="card shadow-sm border-0 w-100 mb-0">
        <!-- Header พร้อมปุ่ม toggle -->
        <div class="card-header bg-light fw-bold text-dark py-2 px-3 d-flex justify-content-between align-items-center">
            <div>
                <i class="bi bi-hospital me-2"></i> บันทึกข้อมูลการรักษาพยาบาลเด็ก
            </div>
            <!-- ปุ่ม toggle medical -->
            <button type="button" id="btn-add-medical"
                  class="btn btn-primary btn-sm"
                  data-bs-toggle="modal"
                  data-bs-target="#add-medical-modal">
              <i class="bi bi-plus-circle me-1"></i> เพิ่มข้อมูล
          </button>
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

      <!-- ตารางการรักษาพยาบาล -->
@if($medicals->isNotEmpty())
    <div class="card mt-1 shadow-sm rounded-1 border-0 ms-2 me-2">
        <div class="card-body p-2">
            <div class="table-responsive">
                <table id="datatable-medical" class="table table-sm table-striped table-hover align-middle w-100 mb-0">
                    <thead class="table-primary text-center small">
                        <tr>
                            <th>ลำดับ</th>
                            <th>วันที่</th>
                            <th>อาการป่วย</th>
                            <th>การรักษา</th>
                            <th>การพบแพทย์</th>
                            <th>วันที่แพทย์นัด</th>
                            <th>จัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="small">
                        @foreach ($medicals as $index => $medical)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ \Carbon\Carbon::parse($medical->medical_date)->format('d/m/Y') }}</td>
                                <td>{{ $medical->illness ?? '-' }}</td>
                                <td>{{ $medical->treatment ?? '-' }}</td>
                                <td>{{ $medical->refer ?? '-' }}</td>
                                <td>{{ $medical->appt_date ? \Carbon\Carbon::parse($medical->appt_date)->format('d/m/Y') : '-' }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <button type="button" class="btn btn-sm btn-warning"
                                            onclick="openEditMedical({{ $medical->id }})">
                                      <i class="bi bi-pencil-square"></i> แก้ไข
                                    </button>
                                        <button type="button" class="btn btn-sm btn-danger"
                                                onclick="confirmDelete('delete-form-medical-{{ $medical->id }}', 'คุณต้องการลบข้อมูลทางการแพทย์นี้ใช่หรือไม่')">
                                            <i class="bi bi-trash"></i> ลบ
                                        </button>
                                        <a href="{{ route('medical.report', $medical->id) }}" class="btn btn-sm btn-info">
                                            <i class="bi bi-file-earmark-text"></i> รายงาน
                                        </a>
                                    </div>
                                    {{-- ฟอร์มลบแบบซ่อน --}}
                                    <form id="delete-form-medical-{{ $medical->id }}"
                                          action="{{ route('medical.delete', $medical->id) }}"
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
        <i class="bi bi-info-circle"></i> ยังไม่มีข้อมูลการรักษาพยาบาล
    </div>
@endif
</div>

{{-- ✅ Modal Add Medical --}}
<div class="modal fade" id="add-medical-modal" tabindex="-1" aria-labelledby="addMedicalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="{{ route('medical.store') }}" method="POST" id="add-medical-form" novalidate>
        @csrf
        <input type="hidden" name="client_id" value="{{ $client->id }}">

        <!-- Header -->
        <div class="modal-header bg-success text-white py-2">
          <h5 class="modal-title fw-bold" id="addMedicalLabel">
            <i class="bi bi-hospital me-2"></i> เพิ่มข้อมูลการรักษาพยาบาล
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>

        <!-- Body -->
        <div class="modal-body">
          <div class="row mb-3">
            <div class="col-md-3">
              <label class="form-label fw-bold">วันที่</label>
              <input type="date" name="medical_date"
                     class="form-control form-control-sm @error('medical_date') is-invalid @enderror"
                     value="{{ old('medical_date') }}">
              @error('medical_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-4">
              <label class="form-label fw-bold">ชื่อโรค</label>
              <input type="text" name="disease_name"
                     class="form-control form-control-sm @error('disease_name') is-invalid @enderror"
                     value="{{ old('disease_name') }}">
              @error('disease_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-5">
              <label class="form-label fw-bold">อาการป่วย</label>
              <textarea name="illness"
                        class="form-control form-control-sm @error('illness') is-invalid @enderror"
                        rows="2">{{ old('illness') }}</textarea>
              @error('illness') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold">การรักษา/การปฐมพยาบาล</label>
            <textarea name="treatment"
                      class="form-control form-control-sm @error('treatment') is-invalid @enderror"
                      rows="2">{{ old('treatment') }}</textarea>
            @error('treatment') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label fw-bold">การพบแพทย์</label><br>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="refer" id="refer_yes_new" value="พบแพทย์"
                       {{ old('refer') == 'พบแพทย์' ? 'checked' : '' }}>
                <label class="form-check-label" for="refer_yes_new">พบแพทย์</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="refer" id="refer_no_new" value="ไม่พบแพทย์"
                       {{ old('refer','ไม่พบแพทย์') == 'ไม่พบแพทย์' ? 'checked' : '' }}>
                <label class="form-check-label" for="refer_no_new">ไม่พบแพทย์</label>
              </div>
              @error('refer') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>
          </div>

          <div id="medical-section-new" style="display:none;">
            <div class="row mb-3">
              <div class="col-md-9">
                <label class="form-label fw-bold">การวินิจฉัย</label>
                <textarea name="diagnosis"
                          class="form-control form-control-sm @error('diagnosis') is-invalid @enderror"
                          rows="2">{{ old('diagnosis') }}</textarea>
                @error('diagnosis') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
              <div class="col-md-3">
                <label class="form-label fw-bold">วันที่แพทย์นัด</label>
                <input type="date" name="appt_date"
                       class="form-control form-control-sm @error('appt_date') is-invalid @enderror"
                       value="{{ old('appt_date') }}">
                @error('appt_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-4">
              <label class="form-label fw-bold">ผู้ดูแล</label>
              <input type="text" name="teacher"
                     class="form-control form-control-sm @error('teacher') is-invalid @enderror"
                     value="{{ old('teacher') }}">
              @error('teacher') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-8">
              <label class="form-label fw-bold">หมายเหตุ</label>
              <textarea name="remark"
                        class="form-control form-control-sm @error('remark') is-invalid @enderror"
                        rows="2">{{ old('remark') }}</textarea>
              @error('remark') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
          </div>
        </div>

        <!-- Footer -->
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">
            <i class="bi bi-save me-1"></i> บันทึกผล
          </button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="bi bi-x-circle me-1"></i> ปิด
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- ✅ เปิด modal อัตโนมัติเมื่อมี error --}}
@if ($errors->any() && !session('edit_mode'))
<script>
document.addEventListener("DOMContentLoaded", function() {
    const addModal = new bootstrap.Modal(document.getElementById('add-medical-modal'));
    addModal.show();
});
</script>
@endif

<!-- ✅ Modal Edit Medical -->
<div class="modal fade" id="editMedicalModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <!-- ✅ ให้ action มีค่า default -->
      <form id="editMedicalForm" method="POST" action="{{ route('medical.update', 0) }}">
        @csrf
        @method('PUT')
        <input type="hidden" name="client_id" id="edit_client_id" value="{{ old('client_id') }}">
        <input type="hidden" name="id" id="edit_medical_id" value="{{ old('id') }}">

        <!-- Header -->
        <div class="modal-header bg-warning text-dark">
          <h5 class="modal-title fw-bold">
            <i class="bi bi-pencil-square me-2"></i> แก้ไขข้อมูลการรักษาพยาบาล
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <!-- Body -->
        <div class="modal-body">
          <div class="row mb-2">
            <div class="col-md-2">
              <label class="form-label fw-bold">วันที่</label>
              <input type="date" name="medical_date" id="edit_medical_date"
                     class="form-control form-control-sm @error('medical_date') is-invalid @enderror"
                     value="{{ old('medical_date') }}" required>
              @error('medical_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-4">
              <label class="form-label fw-bold">ชื่อโรค</label>
              <input type="text" name="disease_name" id="edit_disease_name"
                     class="form-control form-control-sm @error('disease_name') is-invalid @enderror"
                     value="{{ old('disease_name') }}">
              @error('disease_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold">อาการป่วย</label>
              <textarea name="illness" id="edit_illness"
                        class="form-control form-control-sm @error('illness') is-invalid @enderror"
                        rows="2">{{ old('illness') }}</textarea>
              @error('illness') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
          </div>

          <div class="mb-2">
            <label class="form-label fw-bold">การรักษา/การปฐมพยาบาล</label>
            <textarea name="treatment" id="edit_treatment"
                      class="form-control form-control-sm">{{ old('treatment') }}</textarea>
          </div>

          <div class="row mb-2">
            <div class="col-md-6">
              <label class="form-label fw-bold">การพบแพทย์</label><br>
              <input type="radio" name="refer" id="edit_refer_yes" value="พบแพทย์"
                     {{ old('refer') === 'พบแพทย์' ? 'checked' : '' }}> พบแพทย์
              <input type="radio" name="refer" id="edit_refer_no" value="ไม่พบแพทย์"
                     {{ old('refer') === 'ไม่พบแพทย์' ? 'checked' : '' }}> ไม่พบแพทย์
              @error('refer') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>
          </div>

          <div id="edit_medical_section" style="display:none;">
            <div class="row mb-2">
              <div class="col-md-9">
                <label class="form-label fw-bold">การวินิจฉัย</label>
                <textarea name="diagnosis" id="edit_diagnosis"
                          class="form-control form-control-sm" rows="2">{{ old('diagnosis') }}</textarea>
              </div>
              <div class="col-md-3">
                <label class="form-label fw-bold">วันที่แพทย์นัด</label>
                <input type="date" name="appt_date" id="edit_appt_date"
                       class="form-control form-control-sm"
                       value="{{ old('appt_date') }}">
              </div>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-4">
              <label class="form-label fw-bold">ผู้ดูแล</label>
              <input type="text" name="teacher" id="edit_teacher"
                     class="form-control form-control-sm"
                     value="{{ old('teacher') }}">
            </div>
            <div class="col-md-8">
              <label class="form-label fw-bold">หมายเหตุ</label>
              <textarea name="remark" id="edit_remark"
                        class="form-control form-control-sm" rows="2">{{ old('remark') }}</textarea>
            </div>
          </div>
        </div>

        <!-- Footer -->
        <div class="modal-footer">
          <button type="submit" class="btn btn-success btn-sm">
            <i class="bi bi-save me-1"></i> อัปเดตข้อมูล
          </button>
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
            <i class="bi bi-x-circle me-1"></i> ปิด
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- ✅ เปิด modal ที่ถูกต้องตามสถานการณ์ -->
@if ($errors->any() && session('edit_mode') && session('edit_id'))
<script>
document.addEventListener("DOMContentLoaded", function() {
    openEditMedical({{ session('edit_id') }});
});
</script>
@elseif ($errors->any() && !session('edit_mode'))
<script>
document.addEventListener("DOMContentLoaded", function() {
    const addModal = document.getElementById('add-medical-modal');
    if (addModal) {
        bootstrap.Modal.getOrCreateInstance(addModal).show();
    }
});
</script>
@endif
@endsection


@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
  // reset form
  function resetForm(modalEl) {
    const form = modalEl.querySelector('form');
    if (form) form.reset();
    const invalids = modalEl.querySelectorAll('.is-invalid');
    invalids.forEach(el => el.classList.remove('is-invalid'));
  }

  // toggle section
  function toggleSection(sectionEl, referYesEl, referNoEl) {
    if (referYesEl.checked) sectionEl.style.display = "block";
    else sectionEl.style.display = "none";
  }

  // realtime clear
  function attachRealtimeValidationClear(form) {
    form.querySelectorAll('input, textarea, select').forEach(el => {
      el.addEventListener('input', () => {
        if (el.classList.contains('is-invalid')) {
          el.classList.remove('is-invalid');
          const feedback = el.nextElementSibling;
          if (feedback && feedback.classList.contains('invalid-feedback')) {
            feedback.remove();
          }
        }
      });
    });
  }

  // ✅ Add Modal
  const addModal = document.getElementById('add-medical-modal');
  if (addModal) {
    addModal.addEventListener('hidden.bs.modal', () => resetForm(addModal));
    const addForm = addModal.querySelector('form');
    if (addForm) attachRealtimeValidationClear(addForm);

    // toggle พบแพทย์/ไม่พบแพทย์
    const sectionNew  = document.getElementById('medical-section-new');
    const referYesNew = document.getElementById('refer_yes_new');
    const referNoNew  = document.getElementById('refer_no_new');
    if (referYesNew && referNoNew && sectionNew) {
      toggleSection(sectionNew, referYesNew, referNoNew);
      referYesNew.addEventListener('change', () => toggleSection(sectionNew, referYesNew, referNoNew));
      referNoNew.addEventListener('change', () => toggleSection(sectionNew, referYesNew, referNoNew));
    }
  }

  // ✅ Edit Modal
  const editModal = document.getElementById('editMedicalModal');
  if (editModal) {
    editModal.addEventListener('hidden.bs.modal', () => resetForm(editModal));
    editModal.addEventListener('shown.bs.modal', function () {
      const section  = document.getElementById('edit_medical_section');
      const referYes = document.getElementById('edit_refer_yes');
      const referNo  = document.getElementById('edit_refer_no');
      if (referYes && referNo && section) {
        toggleSection(section, referYes, referNo);
        referYes.addEventListener('change', () => toggleSection(section, referYes, referNo));
        referNo.addEventListener('change', () => toggleSection(section, referYes, referNo));
      }
      const form = editModal.querySelector('form');
      if (form) attachRealtimeValidationClear(form);
    });
  }
});

// ✅ ฟังก์ชัน global สำหรับเปิด modal edit
function openEditMedical(id) {
  fetch(`/medical/json/${id}`)
    .then(res => res.json())
    .then(data => {
      const form = document.getElementById('editMedicalForm');
      form.action = `/medical/update/${data.id}`;
      document.getElementById('edit_medical_id').value   = data.id;
      document.getElementById('edit_client_id').value    = data.client_id;
      document.getElementById('edit_medical_date').value = data.medical_date ?? '';
      document.getElementById('edit_disease_name').value = data.disease_name ?? '';
      document.getElementById('edit_illness').value      = data.illness ?? '';
      document.getElementById('edit_treatment').value    = data.treatment ?? '';
      document.getElementById('edit_diagnosis').value    = data.diagnosis ?? '';
      document.getElementById('edit_appt_date').value    = data.appt_date ?? '';
      document.getElementById('edit_teacher').value      = data.teacher ?? '';
      document.getElementById('edit_remark').value       = data.remark ?? '';

      const referYes = document.getElementById('edit_refer_yes');
      const referNo  = document.getElementById('edit_refer_no');
      const section  = document.getElementById('edit_medical_section');
      if (data.refer === "พบแพทย์") {
        referYes.checked = true;
        section.style.display = "block";
      } else {
        referNo.checked = true;
        section.style.display = "none";
      }

      bootstrap.Modal.getOrCreateInstance(document.getElementById('editMedicalModal')).show();
    })
    .catch(err => console.error(err));
}
</script>
@endpush