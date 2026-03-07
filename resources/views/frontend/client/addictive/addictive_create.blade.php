@extends('admin_client.admin_client')
@section('content')

<div class="card mt-2 shadow-sm border-0 me-2 ms-2">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h6 class="mb-0 fw-bold">
      <i class="bi bi-clipboard-check me-1"></i> ข้อมูลการตรวจสารเสพติด
    </h6>
    <button type="button" class="btn btn-sm btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#createAddictiveModal">
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

  <div class="card-body p-2">
    @if($addictives->isNotEmpty())
      <div class="table-responsive">
        <table id="datatable-addictive" class="table table-striped table-hover align-middle mb-0">
          <thead class="table-primary text-center">
            <tr>
              <th style="width:6%">ลำดับ</th>
              <th style="width:12%">วันที่ตรวจ</th>
              <th style="width:8%">ครั้งที่</th>
              <th style="width:12%">ผลการตรวจ</th>
              <th style="width:12%">การส่งต่อ</th>
              <th>บันทึกผล</th>
              <th style="width:12%">ผู้ตรวจ</th>
              <th style="width:18%">จัดการ</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($addictives as $index => $addictive)
              <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($addictive->date)->format('d/m/Y') }}</td>
                <td class="text-center">{{ $addictive->count }}</td>
                <td>
                  @if($addictive->exam == 0)
                    <span class="badge bg-success">ไม่พบสารเสพติด</span>
                  @else
                    <span class="badge bg-danger">พบสารเสพติด</span>
                  @endif
                </td>
                <td>
                  @if($addictive->exam == 1)
                    @if($addictive->refer == 1)
                      <span class="badge bg-warning text-dark">ส่งต่อบำบัด</span>
                    @elseif($addictive->refer == 2)
                      <span class="badge bg-info">ติดตามดูแลต่อเนื่อง</span>
                    @else
                      <span class="badge bg-secondary">-</span>
                    @endif
                  @else
                    <span class="badge bg-secondary">-</span>
                  @endif
                </td>
                <td>{{ $addictive->record ?? '-' }}</td>
                <td>{{ $addictive->recorder ?? '-' }}</td>
                <td class="text-center">
                  <div class="d-flex flex-wrap justify-content-center gap-1">
               
                  <!-- ปุ่มแก้ไข -->
                  <button type="button" class="btn btn-sm btn-warning"
                          onclick="openEditAddictive({{ $addictive->id }})">
                      <i class="bi bi-pencil-square"></i> แก้ไข
                  </button>         
                  <form id="delete-form-addictive-{{ $addictive->id }}" 
                        action="{{ route('addictive.delete', $addictive->id) }}" 
                        method="POST" class="d-inline">
                      @csrf 
                      @method('DELETE')
                      <button type="button" class="btn btn-sm btn-danger"
                              onclick="confirmDelete('delete-form-addictive-{{ $addictive->id }}', 'คุณต้องการลบข้อมูลการเสพติดนี้ใช่หรือไม่')">
                          <i class="bi bi-trash"></i> ลบ
                      </button>
                  </form>
                    <a href="#" class="btn btn-sm btn-info">
                      <i class="bi bi-file-earmark-text"></i> รายงาน
                    </a>
                  </div>
                  <form id="delete-form-addictive-{{ $addictive->id }}"
                        action="{{ route('addictive.delete', $addictive->id) }}"
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
    @else
      <div class="alert alert-warning mb-0">ยังไม่มีข้อมูลการตรวจสารเสพติด</div>
    @endif
  </div>
</div>

<!-- Modal เพิ่มข้อมูล -->
<div class="modal fade" id="createAddictiveModal" tabindex="-1" aria-labelledby="createAddictiveLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Header -->
      <div class="modal-header bg-primary text-white py-2">
        <h5 class="modal-title fw-bold" id="createAddictiveLabel">
          <i class="bi bi-eyedropper me-2"></i> เพิ่มข้อมูลการตรวจสารเสพติด
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <!-- Form -->
      <form id="addictive-form" action="{{ route('addictive.store') }}" method="POST" novalidate>
        @csrf
        <div class="modal-body">
          <input type="hidden" name="client_id" value="{{ $client->id }}">

          <div class="row gx-3 gy-2">
            <div class="col-md-4">
              <label class="form-label">วันที่ตรวจ</label>
              <input type="date" name="date"
                     class="form-control form-control-sm @error('date') is-invalid @enderror"
                     value="{{ old('date', \Carbon\Carbon::now()->format('Y-m-d')) }}" required>
              @error('date') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-4">
              <label class="form-label">ครั้งที่</label>
              <input type="number" name="count" class="form-control form-control-sm"
                     value="{{ $addictives->count() + 1 }}" readonly>
            </div>

            <div class="col-md-4">
              <label class="form-label">ผลการตรวจ</label><br>
              <div class="form-check form-check-inline">
                <input class="form-check-input @error('exam') is-invalid @enderror" type="radio" name="exam" value="0"
                       {{ old('exam','0') == '0' ? 'checked' : '' }} id="exam_no_new">
                <label class="form-check-label" for="exam_no_new">ไม่พบสารเสพติด</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input @error('exam') is-invalid @enderror" type="radio" name="exam" value="1"
                       {{ old('exam') == '1' ? 'checked' : '' }} id="exam_yes_new">
                <label class="form-check-label" for="exam_yes_new">พบสารเสพติด</label>
              </div>
              @error('exam') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>
          </div>

          <div class="row mb-3" id="referField_new" style="display: {{ old('exam') == '1' ? 'flex' : 'none' }};">
            <div class="col-md-6">
              <label class="form-label">การส่งต่อ</label><br>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="refer" value="1"
                       {{ old('refer') == '1' ? 'checked' : '' }} id="refer_treatment_new">
                <label class="form-check-label" for="refer_treatment_new">ส่งต่อบำบัด</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="refer" value="2"
                       {{ old('refer') == '2' ? 'checked' : '' }} id="refer_followup_new">
                <label class="form-check-label" for="refer_followup_new">ติดตามดูแลต่อเนื่อง</label>
              </div>
              @error('refer') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">บันทึกผล</label>
            <textarea name="record"
                      class="form-control form-control-sm @error('record') is-invalid @enderror"
                      rows="2">{{ old('record') }}</textarea>
            @error('record') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="mb-2">
            <label class="form-label fw-bold">ผู้ตรวจ</label>
            <input type="text" name="recorder"
                   class="form-control form-control-sm @error('recorder') is-invalid @enderror"
                   value="{{ old('recorder') }}" required>
            @error('recorder') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>
        </div>

        <!-- Footer -->
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">
            <i class="bi bi-save me-1"></i> บันทึกผล
          </button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btn-cancel-addictive">
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
        var myModal = new bootstrap.Modal(document.getElementById('createAddictiveModal'));
        myModal.show();
    });
    </script>
    @endif

      @foreach ($addictives as $addictive)
      <div class="modal fade" id="editAddictiveModal{{ $addictive->id }}" tabindex="-1" aria-hidden="true" data-addictive-id="{{ $addictive->id }}">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">

            <!-- Header -->
            <div class="modal-header bg-warning text-dark py-2">
              <h5 class="modal-title fw-bold">
                <i class="bi bi-pencil-square me-2"></i> แก้ไขข้อมูลการตรวจสารเสพติด
              </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Form -->
            <form action="{{ route('addictive.update', $addictive->id) }}" method="POST" novalidate>
              @csrf
              @method('PUT')
              <input type="hidden" name="client_id" value="{{ $client->id }}">

              <div class="modal-body">
                <div class="row mb-2">
                  <div class="col-md-3">
                    <label class="form-label fw-bold">วันที่ตรวจ</label>
                    <input type="date" name="date"
                          class="form-control form-control-sm @error('date') is-invalid @enderror"
                          value="{{ old('date', $addictive->date) }}" required>
                    @error('date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                  </div>

                  <div class="col-md-3">
                    <label class="form-label fw-bold">ครั้งที่</label>
                    <input type="number" name="count" class="form-control form-control-sm"
                          value="{{ old('count', $addictive->count) }}" readonly>
                  </div>

                  <div class="col-md-6">
                    <label class="form-label fw-bold">ผลการตรวจ</label><br>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input @error('exam') is-invalid @enderror" type="radio" name="exam" value="0"
                            {{ old('exam', $addictive->exam) == 0 ? 'checked' : '' }} id="exam_no_{{ $addictive->id }}">
                      <label class="form-check-label" for="exam_no_{{ $addictive->id }}">ไม่พบสารเสพติด</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input @error('exam') is-invalid @enderror" type="radio" name="exam" value="1"
                            {{ old('exam', $addictive->exam) == 1 ? 'checked' : '' }} id="exam_yes_{{ $addictive->id }}">
                      <label class="form-check-label" for="exam_yes_{{ $addictive->id }}">พบสารเสพติด</label>
                    </div>
                    @error('exam') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                  </div>
                </div>

                <div class="row mb-2" id="referField_{{ $addictive->id }}"
                    style="display: {{ old('exam', $addictive->exam) == 1 ? 'flex' : 'none' }};">
                  <div class="col-md-6">
                    <label class="form-label fw-bold">การส่งต่อ</label><br>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="refer" value="1"
                            {{ old('refer', $addictive->refer) == 1 ? 'checked' : '' }} id="refer_treatment_{{ $addictive->id }}">
                      <label class="form-check-label" for="refer_treatment_{{ $addictive->id }}">ส่งต่อบำบัด</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="refer" value="2"
                            {{ old('refer', $addictive->refer) == 2 ? 'checked' : '' }} id="refer_followup_{{ $addictive->id }}">
                      <label class="form-check-label" for="refer_followup_{{ $addictive->id }}">ติดตามดูแลต่อเนื่อง</label>
                    </div>
                    @error('refer') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                  </div>
                </div>

                <div class="mb-2">
                  <label class="form-label fw-bold">บันทึกผล</label>
                  <textarea name="record"
                            class="form-control form-control-sm @error('record') is-invalid @enderror"
                            rows="2">{{ old('record', $addictive->record) }}</textarea>
                  @error('record') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-2">
                    <label class="form-label fw-bold">ผู้ตรวจ</label>
                    <input type="text" name="recorder"
                          class="form-control form-control-sm"
                          value="{{ old('recorder', $addictive->recorder ?? 'ไม่ระบุ') }}">
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
      @endforeach
      @endsection

 
@push('scripts')
<script>
  // ✅ ฟังก์ชันกลางสำหรับ reset ฟอร์มและ error
  function resetForm(modalEl) {
    const form = modalEl.querySelector('form');
    if (form) {
      form.reset();
      form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
      form.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
    }
    // ซ่อน referField ถ้ามี
    const referField = modalEl.querySelector('[id^="referField_"]');
    if (referField) referField.style.display = 'none';
  }

  // ✅ Toggle referField สำหรับ modal create
  const examNoNew = document.getElementById('exam_no_new');
  const examYesNew = document.getElementById('exam_yes_new');
  const referFieldNew = document.getElementById('referField_new');

  function toggleReferNew() {
    if (!referFieldNew) return;
    referFieldNew.style.display = (examYesNew && examYesNew.checked) ? 'flex' : 'none';
  }
  if (examNoNew && examYesNew) {
    toggleReferNew();
    examNoNew.addEventListener('change', toggleReferNew);
    examYesNew.addEventListener('change', toggleReferNew);
  }

  // ✅ Reset ฟอร์มเมื่อเปิด/ปิด modal create
  const createModal = document.getElementById('addictiveModal');
  if (createModal) {
    createModal.addEventListener('shown.bs.modal', () => resetForm(createModal));
    createModal.addEventListener('hidden.bs.modal', () => resetForm(createModal));
  }

  // ✅ Toggle referField สำหรับ modal edit
  document.querySelectorAll('.modal[id^="editAddictiveModal"]').forEach(function(modalEl) {
    modalEl.addEventListener('shown.bs.modal', function () {
      const id = modalEl.getAttribute('data-addictive-id');
      const referField = document.getElementById('referField_' + id);
      const examNo = document.getElementById('exam_no_' + id);
      const examYes = document.getElementById('exam_yes_' + id);

      function toggleRefer() {
        if (!referField) return;
        referField.style.display = (examYes && examYes.checked) ? 'flex' : 'none';
      }

      toggleRefer();
      if (examNo) examNo.addEventListener('change', toggleRefer);
      if (examYes) examYes.addEventListener('change', toggleRefer);
    });

    // ✅ Reset ฟอร์มเมื่อปิด modal edit
    modalEl.addEventListener('hidden.bs.modal', () => resetForm(modalEl));
  });

  // ✅ โหลดข้อมูลลงฟอร์ม edit
  function openEditAddictive(id) {
    fetch(`/addictive/json/${id}`)
      .then(response => response.json())
      .then(data => {
        const modalSel = `#editAddictiveModal${id}`;
        document.querySelector(`${modalSel} input[name="date"]`).value = data.date;
        document.querySelector(`${modalSel} input[name="count"]`).value = data.count;
        document.querySelector(`${modalSel} textarea[name="record"]`).value = data.record ?? '';
        document.querySelector(`${modalSel} input[name="recorder"]`).value = data.recorder ?? '';

        if (data.exam == 1) {
          document.querySelector(`#exam_yes_${id}`).checked = true;
          document.querySelector(`#referField_${id}`).style.display = 'flex';
        } else {
          document.querySelector(`#exam_no_${id}`).checked = true;
          document.querySelector(`#referField_${id}`).style.display = 'none';
        }

        if (data.refer == 1) {
          document.querySelector(`#refer_treatment_${id}`).checked = true;
        } else if (data.refer == 2) {
          document.querySelector(`#refer_followup_${id}`).checked = true;
        }

        new bootstrap.Modal(document.getElementById(`editAddictiveModal${id}`)).show();
      });
  }
  </script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const createBtn = document.querySelector('button[data-bs-target="#createAddictiveModal"]');
    const createModal = document.getElementById('createAddictiveModal');
    const createForm = createModal?.querySelector('form');

    function resetCreateForm(){
        if(createForm){
            createForm.reset();
            // ตั้งค่า default วันที่เป็นวันนี้ ถ้ามี field date
            const today = new Date().toISOString().split('T')[0];
            const dateInput = createForm.querySelector('input[name="date"]');
            if(dateInput) dateInput.value = today;

            // เคลียร์ error feedback
            createForm.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
            createForm.querySelectorAll('.invalid-feedback').forEach(el => el.innerText = '');
        }
        // ซ่อน referField ถ้ามี
        const referFieldNew = document.getElementById('referField_new');
        if(referFieldNew) referFieldNew.style.display = 'none';
    }

    // ✅ กดปุ่ม "เพิ่มข้อมูล" → reset ฟอร์ม
    createBtn?.addEventListener('click', resetCreateForm);

    // ✅ เมื่อ modal ถูกปิด → reset ฟอร์ม
    createModal?.addEventListener('hidden.bs.modal', resetCreateForm);
});
</script>


@endpush