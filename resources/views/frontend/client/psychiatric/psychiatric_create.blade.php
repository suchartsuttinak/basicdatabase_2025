@extends('admin_client.admin_client')
@section('content')

<div class="container-fluid mt-2">
    <!-- ฟอร์ม -->
    <div class="card shadow-sm border-0 w-100 mb-0">
        <!-- Header พร้อมปุ่ม toggle -->
       <div class="card-header d-flex justify-content-between align-items-center">
    <h6 class="mb-0 fw-bold">
      <i class="bi bi-clipboard-check me-1"></i> ข้อมูลการตรวจวินิจฉัยทางจิตวิทยา
    </h6>
   <button type="button" 
        class="btn btn-sm btn-primary"
        data-bs-toggle="modal"
        data-bs-target="#createPsychiatricModal"
        id="btn-create-psychiatric">
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

<!-- ตารางจิตเวช -->
@if($psychiatrics->isNotEmpty())
    <div class="card mt-2 shadow-sm border-0 me-2 ms-2">
        <div class="card-body p-2">
            <div class="table-responsive">
                <table id="datatable-psychiatric" class="table table-sm table-striped table-hover align-middle w-100 mb-0">
                    <thead class="table-primary text-center small">
                        <tr>
                            <th style="width:5%">ลำดับ</th>
                            <th>วันที่ส่งตรวจ</th>
                            <th>สถานพยาบาล</th>
                            <th>ผลการตรวจ</th>
                            <th>นัดครั้งต่อไป</th>
                            <th>การรักษา</th>
                            <th>การขึ้นทะเบียน</th>
                            <th style="width:15%">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="small">
                        @foreach ($psychiatrics as $index => $psychiatric)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ \Carbon\Carbon::parse($psychiatric->sent_date)->format('d/m/Y') }}</td>
                                <td>{{ $psychiatric->hotpital ?? '-' }}</td>
                                <td>{{ $psychiatric->psycho->psycho_name ?? '-' }}</td>
                                <td>{{ $psychiatric->appoin_date ? \Carbon\Carbon::parse($psychiatric->appoin_date)->format('d/m/Y') : '-' }}</td>
                                <td>
                                    @if($psychiatric->drug_no === 'yes')
                                        <span class="badge bg-success">รับยา</span>
                                    @else
                                        <span class="badge bg-secondary">ไม่รับยา</span>
                                    @endif
                                </td>
                                <td>
                                    @if($psychiatric->disa_no === 'yes')
                                        <span class="badge bg-info">ขึ้นทะเบียน</span>
                                    @else
                                        <span class="badge bg-secondary">ไม่ขึ้นทะเบียน</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                     <button type="button" 
                                            class="btn btn-sm btn-warning"
                                            onclick="openEditPsychiatric({{ $psychiatric->id }})">
                                        <i class="bi bi-pencil-square"></i> แก้ไข
                                    </button>

                                        <button type="button" class="btn btn-sm btn-danger"
                                                onclick="confirmDelete('delete-form-psychiatric-{{ $psychiatric->id }}', 'คุณต้องการลบข้อมูลจิตเวชนี้ใช่หรือไม่')">
                                            <i class="bi bi-trash"></i> ลบ
                                        </button>
                                        <a href="" class="btn btn-sm btn-info">
                                            <i class="bi bi-file-earmark-text"></i> รายงาน
                                        </a>
                                    </div>
                                    {{-- ฟอร์มลบแบบซ่อน --}}
                                    <form id="delete-form-psychiatric-{{ $psychiatric->id }}"
                                          action="{{ route('psychiatric.delete', $psychiatric->id) }}"
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
        <i class="bi bi-info-circle"></i> ยังไม่มีข้อมูลการตรวจจิตเวช
    </div>
@endif
 </div>

<!-- Modal เพิ่มข้อมูลการตรวจวินิจฉัยทางจิตเวช -->
<div class="modal fade" id="createPsychiatricModal" tabindex="-1" aria-labelledby="createPsychiatricLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Header -->
      <div class="modal-header bg-primary text-white py-2">
        <h5 class="modal-title fw-bold" id="createPsychiatricLabel">
          <i class="bi bi-clipboard-heart me-2"></i> เพิ่มข้อมูลการตรวจวินิจฉัยทางจิตเวช
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <!-- Form -->
      <form id="psychiatric-form" action="{{ route('psychiatric.store') }}" method="POST" novalidate>
        @csrf
        <div class="modal-body">
          <input type="hidden" name="client_id" value="{{ $client->id }}">

          <!-- วันที่ส่งตรวจ / สถานพยาบาล / ผลการตรวจ -->
          <div class="row mb-3">
            <div class="col-md-3">
              <label class="form-label fw-bold">วันที่ส่งตรวจ</label>
              <input type="date" name="sent_date"
                     class="form-control form-control-sm @error('sent_date') is-invalid @enderror"
                     value="{{ old('sent_date') }}" required>
              @error('sent_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-4">
              <label class="form-label fw-bold">สถานพยาบาล</label>
              <input type="text" name="hotpital"
                     class="form-control form-control-sm @error('hotpital') is-invalid @enderror"
                     value="{{ old('hotpital') }}">
              @error('hotpital') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-5">
              <label class="form-label fw-bold">ผลการตรวจวินิจฉัย</label>
              <select name="psycho_id"
                      class="form-select form-select-sm @error('psycho_id') is-invalid @enderror" required>
                <option value="">-- เลือกผลการตรวจ --</option>
                @foreach($psycho as $p)
                  <option value="{{ $p->id }}" {{ old('psycho_id') == $p->id ? 'selected' : '' }}>
                    {{ $p->psycho_name }}
                  </option>
                @endforeach
              </select>
              @error('psycho_id') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>
          </div>

          <!-- สรุปผล -->
          <div class="mb-3">
            <label class="form-label fw-bold">สรุปผลการตรวจ/การวินิจฉัย</label>
            <textarea name="diagnose"
                      class="form-control form-control-sm @error('diagnose') is-invalid @enderror"
                      rows="3">{{ old('diagnose') }}</textarea>
            @error('diagnose') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <!-- นัดครั้งต่อไป / การรักษา / ชื่อยา -->
          <div class="row mb-3">
            <div class="col-md-3">
              <label class="form-label fw-bold">นัดครั้งต่อไป</label>
              <input type="date" name="appoin_date"
                     class="form-control form-control-sm @error('appoin_date') is-invalid @enderror"
                     value="{{ old('appoin_date') }}">
              @error('appoin_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-4">
              <label class="form-label fw-bold">การรักษา</label>
              <div class="d-flex align-items-center gap-3 mt-1">
                <div class="form-check">
                  <input class="form-check-input @error('drug_no') is-invalid @enderror" type="radio" name="drug_no" value="yes"
                         {{ old('drug_no') == 'yes' ? 'checked' : '' }} id="drug_yes_new">
                  <label class="form-check-label" for="drug_yes_new">รับยา</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input @error('drug_no') is-invalid @enderror" type="radio" name="drug_no" value="no"
                         {{ old('drug_no','no') == 'no' ? 'checked' : '' }} id="drug_no_new">
                  <label class="form-check-label" for="drug_no_new">ไม่รับยา</label>
                </div>
              </div>
              @error('drug_no') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-5" id="drug_name_field_new" style="display: {{ old('drug_no') == 'yes' ? 'block' : 'none' }};">
              <label class="form-label fw-bold">ชื่อยา</label>
              <input type="text" name="drug_name"
                     class="form-control form-control-sm @error('drug_name') is-invalid @enderror"
                     value="{{ old('drug_name') }}">
              @error('drug_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
          </div>

          <!-- การขึ้นทะเบียนคนพิการ -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label fw-bold">การขึ้นทะเบียนคนพิการ</label>
              <div class="d-flex align-items-center gap-3 mt-1">
                <div class="form-check">
                  <input class="form-check-input @error('disa_no') is-invalid @enderror" type="radio" name="disa_no" value="yes"
                         {{ old('disa_no') == 'yes' ? 'checked' : '' }}>
                  <label class="form-check-label">ขึ้นทะเบียน</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input @error('disa_no') is-invalid @enderror" type="radio" name="disa_no" value="no"
                         {{ old('disa_no','no') == 'no' ? 'checked' : '' }}>
                  <label class="form-check-label">ไม่ขึ้นทะเบียน</label>
                </div>
              </div>
              @error('disa_no') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>
          </div>
        </div>

        <!-- Footer -->
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">
            <i class="bi bi-save me-1"></i> บันทึกผล
          </button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btn-cancel-psychiatric">
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
    var myModal = new bootstrap.Modal(document.getElementById('createPsychiatricModal'));
    myModal.show();
});
</script>
@endif

@foreach ($psychiatrics as $psychiatric)
<!-- Modal แก้ไขข้อมูลการตรวจวินิจฉัยทางจิตเวช -->
<div class="modal fade" id="editPsychiatricModal" tabindex="-1" aria-labelledby="editPsychiatricLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Header -->
      <div class="modal-header bg-warning text-dark py-2">
        <h5 class="modal-title fw-bold" id="editPsychiatricLabel">
          <i class="bi bi-pencil-square me-2"></i> แก้ไขข้อมูลการตรวจวินิจฉัยทางจิตเวช
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Form -->
      <form id="psychiatric-edit-form" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <input type="hidden" name="client_id" value="{{ $client->id }}">
          <input type="hidden" id="edit_id">

          <!-- วันที่ส่งตรวจ / สถานพยาบาล / ผลการตรวจ -->
          <div class="row mb-3">
           <div class="col-md-3">
                  <label class="form-label fw-bold">วันที่ส่งตรวจ</label>
                  <input type="date" name="sent_date" id="edit_sent_date" class="form-control form-control-sm">
                </div>

                <div class="col-md-4">
                  <label class="form-label fw-bold">สถานพยาบาล</label>
                  <input type="text" name="hotpital" id="edit_hotpital" class="form-control form-control-sm">
                </div>

                <div class="col-md-5">
                  <label class="form-label fw-bold">ผลการตรวจวินิจฉัย</label>
                  <select name="psycho_id" id="edit_psycho_id" class="form-select form-select-sm">
                    <option value="">-- เลือกผลการตรวจ --</option>
                    @foreach($psycho as $p)
                      <option value="{{ $p->id }}">{{ $p->psycho_name }}</option>
                    @endforeach
                  </select>
                </div>
          </div>

          <!-- สรุปผล -->
          <div class="mb-3">
            <label class="form-label fw-bold">สรุปผลการตรวจ/การวินิจฉัย</label>
            <textarea name="diagnose" id="edit_diagnose" class="form-control form-control-sm" rows="3"></textarea>
          </div>

          <!-- นัดครั้งต่อไป / การรักษา / ชื่อยา -->
          <div class="row mb-3">
            <div class="col-md-3">
              <label class="form-label fw-bold">นัดครั้งต่อไป</label>
              <input type="date" name="appoin_date" id="edit_appoin_date" class="form-control form-control-sm">
            </div>
            <div class="col-md-4">
              <label class="form-label fw-bold">การรักษา</label>
              <div class="d-flex align-items-center gap-3 mt-1">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="drug_no" value="yes" id="edit_drug_yes">
                  <label class="form-check-label" for="edit_drug_yes">รับยา</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="drug_no" value="no" id="edit_drug_no">
                  <label class="form-check-label" for="edit_drug_no">ไม่รับยา</label>
                </div>
              </div>
            </div>
            <div class="col-md-5" id="edit_drug_name_field" style="display:none;">
              <label class="form-label fw-bold">ชื่อยา</label>
              <input type="text" name="drug_name" id="edit_drug_name" class="form-control form-control-sm">
            </div>
          </div>

          <!-- การขึ้นทะเบียนคนพิการ -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label fw-bold">การขึ้นทะเบียนคนพิการ</label>
              <div class="d-flex align-items-center gap-3 mt-1">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="disa_no" value="yes" id="edit_disa_yes">
                  <label class="form-check-label" for="edit_disa_yes">ขึ้นทะเบียน</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="disa_no" value="no" id="edit_disa_no">
                  <label class="form-check-label" for="edit_disa_no">ไม่ขึ้นทะเบียน</label>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Footer -->
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">
            <i class="bi bi-save me-1"></i> อัปเดตข้อมูล
          </button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="bi bi-x-circle me-1"></i> ปิด
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endforeach

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {

  // ✅ ฟังก์ชันกลางสำหรับ reset ฟอร์มและ error
  function resetForm(modalEl) {
    const form = modalEl.querySelector('form');
    if (form) {
      form.reset();
      form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
      form.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
    }
    // ซ่อน drug_name_field ถ้ามี
    const drugField = modalEl.querySelector('[id^="drug_name_field_"]');
    if (drugField) {
      drugField.style.display = 'none';
      const drugInput = drugField.querySelector('input[name="drug_name"]');
      if (drugInput) drugInput.value = '';
    }
  }

  // ✅ ฟังก์ชันแสดง error ภาษาไทย
  function showError(el, message) {
    el.classList.add('is-invalid');
    let feedback = el.parentElement.querySelector('.invalid-feedback');
    if (!feedback) {
      feedback = document.createElement('div');
      feedback.classList.add('invalid-feedback');
      el.parentElement.appendChild(feedback);
    }
    feedback.innerText = message;
  }

  // ✅ ฟังก์ชันเคลียร์ error แบบ real-time
  function attachRealtimeValidationClear(form) {
    form.querySelectorAll('input, select').forEach(el => {
      ['input','change'].forEach(evt => {
        el.addEventListener(evt, () => {
          el.classList.remove('is-invalid');
          const feedback = el.parentElement.querySelector('.invalid-feedback');
          if (feedback) feedback.remove();
        });
      });
    });
  }

  // ✅ Validation ภาษาไทยก่อน submit
  function attachThaiValidation(form) {
    form.addEventListener('submit', function(e) {
      let valid = true;

      const sentDate = form.querySelector('[name="sent_date"]');
      if (!sentDate.value) {
        showError(sentDate, 'กรุณาระบุวันที่ส่งตรวจ');
        valid = false;
      }

      const hospital = form.querySelector('[name="hotpital"]');
      if (!hospital.value.trim()) {
        showError(hospital, 'กรุณาระบุสถานพยาบาล');
        valid = false;
      }

      const psycho = form.querySelector('[name="psycho_id"]');
      if (!psycho.value) {
        showError(psycho, 'กรุณาเลือกผลการตรวจวินิจฉัย');
        valid = false;
      }

      if (!valid) e.preventDefault();
    });
  }

  // ✅ Toggle drug_name สำหรับ modal create
  const drugYesNew   = document.getElementById('drug_yes_new');
  const drugNoNew    = document.getElementById('drug_no_new');
  const drugFieldNew = document.getElementById('drug_name_field_new');
  const drugInputNew = drugFieldNew ? drugFieldNew.querySelector('input[name="drug_name"]') : null;

  function toggleDrugFieldNew() {
    if (drugYesNew && drugYesNew.checked) {
      drugFieldNew.style.display = 'block';
    } else {
      drugFieldNew.style.display = 'none';
      if (drugInputNew) drugInputNew.value = ''; // ✅ ล้างข้อมูลเมื่อเลือก "ไม่รับยา"
    }
  }
  if (drugYesNew) drugYesNew.addEventListener('change', toggleDrugFieldNew);
  if (drugNoNew)  drugNoNew.addEventListener('change', toggleDrugFieldNew);
  toggleDrugFieldNew();

  // ✅ Reset ฟอร์มเมื่อเปิด/ปิด modal create
  const createBtn   = document.getElementById('btn-create-psychiatric');
  const createModal = document.getElementById('createPsychiatricModal');
  if (createBtn && createModal) {
    const form = createModal.querySelector('form');
    if (form) {
      attachRealtimeValidationClear(form);
      attachThaiValidation(form);
    }
    createBtn.addEventListener('click', () => resetForm(createModal));
    createModal.addEventListener('hidden.bs.modal', () => resetForm(createModal));
  }

  // ✅ โหลดข้อมูลลงฟอร์ม edit (ใช้ JSON)
  window.openEditPsychiatric = function(id) {
    fetch(`/psychiatric/edit-json/${id}`)
      .then(response => response.json())
      .then(data => {
        const modalEl = document.getElementById('editPsychiatricModal');
        const form = modalEl.querySelector('form');
        form.action = `/psychiatric/${data.id}`;

        // เติมค่าในฟอร์ม
        modalEl.querySelector('#edit_sent_date').value = data.sent_date ?? '';
        modalEl.querySelector('#edit_hotpital').value = data.hotpital ?? '';
        modalEl.querySelector('#edit_psycho_id').value = data.psycho_id ?? '';
        modalEl.querySelector('#edit_diagnose').value = data.diagnose ?? '';
        modalEl.querySelector('#edit_appoin_date').value = data.appoin_date ?? '';

        // ✅ การรักษา (รับยา/ไม่รับยา)
        const drugYes = modalEl.querySelector('#edit_drug_yes');
        const drugNo  = modalEl.querySelector('#edit_drug_no');
        const drugField = modalEl.querySelector('#edit_drug_name_field');
        const drugInput = modalEl.querySelector('#edit_drug_name');

        function toggleDrugFieldEdit() {
          if (drugYes.checked) {
            drugField.style.display = 'block';
          } else {
            drugField.style.display = 'none';
            drugInput.value = ''; // ✅ ล้างข้อมูลเมื่อเลือก "ไม่รับยา"
          }
        }

        if (data.drug_no === 'yes') {
          drugYes.checked = true;
          drugField.style.display = 'block';
          drugInput.value = data.drug_name ?? '';
        } else {
          drugNo.checked = true;
          drugField.style.display = 'none';
          drugInput.value = '';
        }

        drugYes.addEventListener('change', toggleDrugFieldEdit);
        drugNo.addEventListener('change', toggleDrugFieldEdit);

        // ✅ การขึ้นทะเบียนคนพิการ
        const disaYes = modalEl.querySelector('#edit_disa_yes');
        const disaNo  = modalEl.querySelector('#edit_disa_no');
        if (data.disa_no === 'yes') {
          disaYes.checked = true;
        } else {
          disaNo.checked = true;
        }

        // ✅ เคลียร์ error และ validation ภาษาไทยสำหรับ edit form
        attachRealtimeValidationClear(form);
        attachThaiValidation(form);

        new bootstrap.Modal(modalEl).show();
      });
  }

  // ✅ Reset ฟอร์มเมื่อปิด modal edit
  const editModal = document.getElementById('editPsychiatricModal');
  if (editModal) {
    const form = editModal.querySelector('form');
    if (form) {
      attachRealtimeValidationClear(form);
      attachThaiValidation(form);
    }
    editModal.addEventListener('hidden.bs.modal', () => resetForm(editModal));
  }

});
</script>
@endpush
@endsection