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
            <button type="button" class="btn btn-sm btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#createMedicalModal">
      <i class="bi bi-plus-circle me-1"></i> เพิ่มข้อมูล
    </button>
        </div>

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
                    @forelse ($medicals as $index => $medical)
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
                                                data-bs-toggle="modal"
                                                data-bs-target="#editMedicalModal{{ $medical->id }}">
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
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted small">
                                <i class="bi bi-info-circle"></i> ยังไม่มีข้อมูลการรักษาพยาบาล
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif
</div>

<!-- Modal เพิ่มข้อมูลการรักษาพยาบาล -->
<div class="modal fade" id="createMedicalModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">เพิ่มข้อมูลการรักษาพยาบาล</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('medical.store') }}" method="POST">
          @csrf
          <input type="hidden" name="client_id" value="{{ $client->id }}">

          <div class="row mb-2">
            <div class="col-12 col-md-2">
              <label class="form-label fw-bold">วันที่</label>
              <input type="date" name="medical_date" class="form-control form-control-sm" required>
            </div>
            <div class="col-12 col-md-4">
              <label class="form-label fw-bold">ชื่อโรค</label>
              <input type="text" name="disease_name" class="form-control form-control-sm">
            </div>
            <div class="col-12 col-md-6">
              <label class="form-label fw-bold">อาการป่วย</label>
              <textarea name="illness" class="form-control form-control-sm" rows="2"></textarea>
            </div>
          </div>

          <div class="mb-2">
            <label class="form-label fw-bold">การรักษา/การปฐมพยาบาล</label>
            <textarea name="treatment" class="form-control form-control-sm" rows="2"></textarea>
          </div>

          <div class="row mb-2">
            <div class="col-12 col-md-6">
              <label class="form-label fw-bold">การพบแพทย์</label><br>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="refer" id="refer_yes_new" value="พบแพทย์">
                <label class="form-check-label" for="refer_yes_new">พบแพทย์</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="refer" id="refer_no_new" value="ไม่พบแพทย์" checked>
                <label class="form-check-label" for="refer_no_new">ไม่พบแพทย์</label>
              </div>
            </div>
          </div>

          <!-- ฟิลด์ diagnosis และ appt_date จะแสดงเฉพาะเมื่อเลือก "พบแพทย์" -->
          <div id="medical-section-new" style="display:none;">
            <div class="row mb-2">
              <div class="col-12 col-md-9">
                <label class="form-label fw-bold">การวินิจฉัย</label>
                <textarea name="diagnosis" class="form-control form-control-sm" rows="2"></textarea>
              </div>
              <div class="col-12 col-md-3">
                <label class="form-label fw-bold">วันที่แพทย์นัด</label>
                <input type="date" name="appt_date" class="form-control form-control-sm">
              </div>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-4">
              <label class="form-label fw-bold">ผู้ดูแล</label>
              <input type="text" name="teacher" class="form-control form-control-sm">
            </div>
            <div class="col-md-8">
              <label class="form-label fw-bold">หมายเหตุ</label>
              <textarea name="remark" class="form-control form-control-sm" rows="2"></textarea>
            </div>
          </div>

          <div class="d-flex justify-content-end gap-2">
            <button type="submit" class="btn btn-success btn-sm">
              <i class="bi bi-save me-1"></i> บันทึกผล
            </button>
            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
              <i class="bi bi-x-circle me-1"></i> ปิด
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@foreach ($medicals as $medical)
<div class="modal fade" id="editMedicalModal{{ $medical->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">แก้ไขข้อมูลการรักษาพยาบาล</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('medical.update', $medical->id) }}" method="POST">
          @csrf
          @method('PUT')
          <input type="hidden" name="client_id" value="{{ $client->id }}">

          <div class="row mb-2">
            <div class="col-12 col-md-2">
              <label class="form-label fw-bold">วันที่</label>
              <input type="date" name="medical_date" class="form-control form-control-sm"
                     value="{{ old('medical_date', $medical->medical_date) }}" required>
            </div>
            <div class="col-12 col-md-4">
              <label class="form-label fw-bold">ชื่อโรค</label>
              <input type="text" name="disease_name" class="form-control form-control-sm"
                     value="{{ old('disease_name', $medical->disease_name) }}">
            </div>
            <div class="col-12 col-md-6">
              <label class="form-label fw-bold">อาการป่วย</label>
              <textarea name="illness" class="form-control form-control-sm" rows="2">{{ old('illness', $medical->illness) }}</textarea>
            </div>
          </div>

          <div class="mb-2">
            <label class="form-label fw-bold">การรักษา/การปฐมพยาบาล</label>
            <textarea name="treatment" class="form-control form-control-sm" rows="2">{{ old('treatment', $medical->treatment) }}</textarea>
          </div>

          <div class="row mb-2">
            <div class="col-12 col-md-6">
              <label class="form-label fw-bold">การพบแพทย์</label><br>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="refer" id="refer_yes_{{ $medical->id }}" value="พบแพทย์"
                       {{ old('refer', $medical->refer) == 'พบแพทย์' ? 'checked' : '' }}>
                <label class="form-check-label" for="refer_yes_{{ $medical->id }}">พบแพทย์</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="refer" id="refer_no_{{ $medical->id }}" value="ไม่พบแพทย์"
                       {{ old('refer', $medical->refer) == 'ไม่พบแพทย์' ? 'checked' : '' }}>
                <label class="form-check-label" for="refer_no_{{ $medical->id }}">ไม่พบแพทย์</label>
              </div>
            </div>
          </div>

          <div id="medical-section-{{ $medical->id }}" style="display: {{ old('refer', $medical->refer) == 'พบแพทย์' ? 'block' : 'none' }};">
            <div class="row mb-2">
              <div class="col-12 col-md-9">
                <label class="form-label fw-bold">การวินิจฉัย</label>
                <textarea name="diagnosis" class="form-control form-control-sm" rows="2">{{ old('diagnosis', $medical->diagnosis) }}</textarea>
              </div>
              <div class="col-12 col-md-3">
                <label class="form-label fw-bold">วันที่แพทย์นัด</label>
                <input type="date" name="appt_date" class="form-control form-control-sm"
                       value="{{ old('appt_date', $medical->appt_date) }}">
              </div>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-4">
              <label class="form-label fw-bold">ผู้ดูแล</label>
              <input type="text" name="teacher" class="form-control form-control-sm"
                     value="{{ old('teacher', $medical->teacher) }}">
            </div>
            <div class="col-md-8">
              <label class="form-label fw-bold">หมายเหตุ</label>
              <textarea name="remark" class="form-control form-control-sm" rows="2">{{ old('remark', $medical->remark) }}</textarea>
            </div>
          </div>

          <div class="d-flex justify-content-end gap-2">
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
</div>
@endforeach

@push('scripts')
<script>


  // ✅ Toggle ฟิลด์การวินิจฉัย/วันที่แพทย์นัด สำหรับ Create
  const referYesNew   = document.getElementById('refer_yes_new');
  const referNoNew    = document.getElementById('refer_no_new');
  const sectionNew    = document.getElementById('medical-section-new');

  function toggleMedicalSectionNew() {
    if (referYesNew && referYesNew.checked) {
      sectionNew.style.display = 'block';
    } else {
      sectionNew.style.display = 'none';
      const inputs = sectionNew.querySelectorAll('input, textarea');
      inputs.forEach(el => el.value = '');
    }
  }
  if (referYesNew) referYesNew.addEventListener('change', toggleMedicalSectionNew);
  if (referNoNew)  referNoNew.addEventListener('change', toggleMedicalSectionNew);
  toggleMedicalSectionNew();

  // ✅ Toggle ฟิลด์การวินิจฉัย/วันที่แพทย์นัด สำหรับ Edit
  document.querySelectorAll('.modal[id^="editMedicalModal"]').forEach(function(modalEl) {
    modalEl.addEventListener('shown.bs.modal', function () {
      const id = modalEl.getAttribute('id').replace('editMedicalModal','');
      const referYes = document.getElementById('refer_yes_' + id);
      const referNo  = document.getElementById('refer_no_' + id);
      const section  = document.getElementById('medical-section-' + id);

      function toggleMedicalSection() {
        if (referYes && referYes.checked) {
          section.style.display = 'block';
        } else {
          section.style.display = 'none';
          const inputs = section.querySelectorAll('input, textarea');
          inputs.forEach(el => el.value = '');
        }
      }

      toggleMedicalSection();
      if (referYes) referYes.addEventListener('change', toggleMedicalSection);
      if (referNo)  referNo.addEventListener('change', toggleMedicalSection);
    });
  });

</script>
@endpush


@endsection