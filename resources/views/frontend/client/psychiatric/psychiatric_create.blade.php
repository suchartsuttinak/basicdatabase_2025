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
    <button type="button" class="btn btn-sm btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#createPsychiatricModal">
      <i class="bi bi-plus-circle me-1"></i> เพิ่มข้อมูล
    </button>
  </div>

       

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
                                        {{-- <small class="d-block text-muted">{{ $psychiatric->drug_name }}</small> --}}
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
                                        <button type="button" class="btn btn-sm btn-warning"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editPsychiatricModal{{ $psychiatric->id }}">
                                        <i class="bi bi-pencil-square"></i> แก้ไข
                                        </button>

                                      <form id="delete-form-psychiatric-{{ $psychiatric->id }}" 
                                          action="{{ route('psychiatric.delete', $psychiatric->id) }}" 
                                          method="POST" class="d-inline">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger"
                                                onclick="confirmDelete('delete-form-psychiatric-{{ $psychiatric->id }}', 'คุณต้องการลบข้อมูลจิตเวชนี้ใช่หรือไม่')">
                                            <i class="bi bi-trash"></i> ลบ
                                        </button>
                                    </form>

                                        <a href="" class="btn btn-sm btn-info">
                                            <i class="bi bi-file-earmark-text"></i> รายงาน
                                        </a>
                                    </div>

                                    {{-- ฟอร์มลบแบบซ่อน --}}
                                    <form id="delete-form-psychiatric-{{ $psychiatric->id }}" 
                                          action="{{ route('psychiatric.delete', $psychiatric->id) }}" 
                                          method="POST" style="display:none;">
                                        @csrf
                                        @method('DELETE') {{-- ใช้ได้ถ้า Route เป็น DELETE --}}
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif
 </div>


<!-- Modal เพิ่มข้อมูลการตรวจวินิจฉัยทางจิตเวช -->
<div class="modal fade" id="createPsychiatricModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">เพิ่มข้อมูลการตรวจวินิจฉัยทางจิตเวช</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('psychiatric.store') }}" method="POST">
          @csrf
          <input type="hidden" name="client_id" value="{{ $client->id }}">

          <div class="row mb-2">
            <div class="col-12 col-md-3">
              <label class="form-label fw-bold">วันที่ส่งตรวจ</label>
              <input type="date" name="sent_date" class="form-control form-control-sm" required>
            </div>
            <div class="col-12 col-md-4">
              <label class="form-label fw-bold">สถานพยาบาล</label>
              <input type="text" name="hotpital" class="form-control form-control-sm">
            </div>
            <div class="col-12 col-md-5">
              <label class="form-label fw-bold">ผลการตรวจวินิจฉัย</label>
              <select name="psycho_id" class="form-select form-select-sm" required>
                <option value="">-- เลือกผลการตรวจ --</option>
                @foreach($psycho as $p)
                  <option value="{{ $p->id }}">{{ $p->psycho_name }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="mb-2">
            <label class="form-label fw-bold">สรุปผลการตรวจ/การวินิจฉัย</label>
            <textarea name="diagnose" class="form-control form-control-sm" rows="2"></textarea>
          </div>

          <div class="row mb-2">
            <div class="col-12 col-md-3">
              <label class="form-label fw-bold">นัดครั้งต่อไป</label>
              <input type="date" name="appoin_date" class="form-control form-control-sm">
            </div>
            <div class="col-12 col-md-3 ms-md-3">
              <label class="form-label fw-bold">การรักษา</label><br>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="drug_no" value="yes" id="drug_yes_new">
                <label class="form-check-label" for="drug_yes_new">รับยา</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="drug_no" value="no" id="drug_no_new" checked>
                <label class="form-check-label" for="drug_no_new">ไม่รับยา</label>
              </div>
            </div>
            <div class="col-12 col-md-5" id="drug_name_field_new" style="display:none;">
              <label class="form-label fw-bold">ชื่อยา</label>
              <input type="text" name="drug_name" class="form-control form-control-sm">
            </div>
          </div>

          <div class="row mb-2">
            <div class="col-12 col-md-6">
              <label class="form-label fw-bold">การขึ้นทะเบียนคนพิการ</label><br>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="disa_no" value="yes">
                <label class="form-check-label">ขึ้นทะเบียน</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="disa_no" value="no" checked>
                <label class="form-check-label">ไม่ขึ้นทะเบียน</label>
              </div>
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

@foreach ($psychiatrics as $psychiatric)
<div class="modal fade" id="editPsychiatricModal{{ $psychiatric->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">แก้ไขข้อมูลการตรวจวินิจฉัยทางจิตเวช</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('psychiatric.update', $psychiatric->id) }}" method="POST">
          @csrf
          @method('PUT')
          <input type="hidden" name="client_id" value="{{ $client->id }}">

          <div class="row mb-2">
            <div class="col-12 col-md-3">
              <label class="form-label fw-bold">วันที่ส่งตรวจ</label>
              <input type="date" name="sent_date" class="form-control form-control-sm"
                     value="{{ old('sent_date', $psychiatric->sent_date) }}" required>
            </div>
            <div class="col-12 col-md-4">
              <label class="form-label fw-bold">สถานพยาบาล</label>
              <input type="text" name="hotpital" class="form-control form-control-sm"
                     value="{{ old('hotpital', $psychiatric->hotpital) }}">
            </div>
            <div class="col-12 col-md-5">
              <label class="form-label fw-bold">ผลการตรวจวินิจฉัย</label>
              <select name="psycho_id" class="form-select form-select-sm" required>
                <option value="">-- เลือกผลการตรวจ --</option>
                @foreach($psycho as $p)
                  <option value="{{ $p->id }}" {{ old('psycho_id', $psychiatric->psycho_id) == $p->id ? 'selected' : '' }}>
                    {{ $p->psycho_name }}
                  </option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="mb-2">
            <label class="form-label fw-bold">สรุปผลการตรวจ/การวินิจฉัย</label>
            <textarea name="diagnose" class="form-control form-control-sm" rows="2">{{ old('diagnose', $psychiatric->diagnose) }}</textarea>
          </div>

          <div class="row mb-2">
            <div class="col-12 col-md-3">
              <label class="form-label fw-bold">นัดครั้งต่อไป</label>
              <input type="date" name="appoin_date" class="form-control form-control-sm"
                     value="{{ old('appoin_date', $psychiatric->appoin_date) }}">
            </div>
            <div class="col-12 col-md-3 ms-md-3">
              <label class="form-label fw-bold">การรักษา</label><br>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="drug_no" value="yes"
                       {{ old('drug_no', $psychiatric->drug_no) == 'yes' ? 'checked' : '' }}
                       id="drug_yes_{{ $psychiatric->id }}">
                <label class="form-check-label" for="drug_yes_{{ $psychiatric->id }}">รับยา</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="drug_no" value="no"
                       {{ old('drug_no', $psychiatric->drug_no) == 'no' ? 'checked' : '' }}
                       id="drug_no_{{ $psychiatric->id }}">
                <label class="form-check-label" for="drug_no_{{ $psychiatric->id }}">ไม่รับยา</label>
              </div>
            </div>
            <div class="col-12 col-md-5" id="drug_name_field_{{ $psychiatric->id }}"
                 style="display: {{ old('drug_no', $psychiatric->drug_no) == 'yes' ? 'block' : 'none' }};">
              <label class="form-label fw-bold">ชื่อยา</label>
              <input type="text" name="drug_name" class="form-control form-control-sm"
                     value="{{ old('drug_name', $psychiatric->drug_name) }}">
            </div>
          </div>

          <div class="row mb-2">
            <div class="col-12 col-md-6">
              <label class="form-label fw-bold">การขึ้นทะเบียนคนพิการ</label><br>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="disa_no" value="yes"
                       {{ old('disa_no', $psychiatric->disa_no) == 'yes' ? 'checked' : '' }}>
                <label class="form-check-label">ขึ้นทะเบียน</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="disa_no" value="no"
                       {{ old('disa_no', $psychiatric->disa_no) == 'no' ? 'checked' : '' }}>
                <label class="form-check-label">ไม่ขึ้นทะเบียน</label>
              </div>
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


  // ✅ Toggle การรักษา (รับยา/ไม่รับยา) สำหรับ Create
  const drugYesNew   = document.getElementById('drug_yes_new');
  const drugNoNew    = document.getElementById('drug_no_new');
  const drugFieldNew = document.getElementById('drug_name_field_new');
  const drugInputNew = document.querySelector('#drug_name_field_new input[name="drug_name"]');

  function toggleDrugFieldNew() {
    if (drugYesNew && drugYesNew.checked) {
      drugFieldNew.style.display = 'block';
    } else {
      drugFieldNew.style.display = 'none';
      if (drugInputNew) drugInputNew.value = '';
    }
  }
  if (drugYesNew) drugYesNew.addEventListener('change', toggleDrugFieldNew);
  if (drugNoNew)  drugNoNew.addEventListener('change', toggleDrugFieldNew);
  toggleDrugFieldNew();

  // ✅ Toggle การรักษา (รับยา/ไม่รับยา) สำหรับ Edit
  document.querySelectorAll('.modal[id^="editPsychiatricModal"]').forEach(function(modalEl) {
    modalEl.addEventListener('shown.bs.modal', function () {
      const id = modalEl.getAttribute('id').replace('editPsychiatricModal','');
      const drugYes = document.getElementById('drug_yes_' + id);
      const drugNo  = document.getElementById('drug_no_' + id);
      const drugField = document.getElementById('drug_name_field_' + id);
      const drugInput = drugField ? drugField.querySelector('input[name="drug_name"]') : null;

      function toggleDrugField() {
        if (drugYes && drugYes.checked) {
          drugField.style.display = 'block';
        } else {
          drugField.style.display = 'none';
          if (drugInput) drugInput.value = '';
        }
      }

      toggleDrugField();
      if (drugYes) drugYes.addEventListener('change', toggleDrugField);
      if (drugNo)  drugNo.addEventListener('change', toggleDrugField);
    });
  });

  // ✅ Toggle ปุ่มเปิด/ปิดฟอร์ม (ถ้าใช้ collapse)
  const collapsePsychiatric = document.getElementById('psychiatricForm');
  const togglePsychiatricBtn = document.getElementById('togglePsychiatricBtn');
  if (collapsePsychiatric && togglePsychiatricBtn) {
    const icon = togglePsychiatricBtn.querySelector('i');
    const text = togglePsychiatricBtn.querySelector('span');
    collapsePsychiatric.addEventListener('shown.bs.collapse', function () {
      icon.className = 'bi bi-dash-circle me-1';
      text.textContent = 'ซ่อน/ฟอร์ม';
    });
    collapsePsychiatric.addEventListener('hidden.bs.collapse', function () {
      icon.className = 'bi bi-plus-circle me-1';
      text.textContent = 'เพิ่มข้อมูล';
    });
  }

</script>
@endpush
@endsection