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
                    <button type="button" class="btn btn-sm btn-warning"
                            data-bs-toggle="modal"
                            data-bs-target="#editAddictiveModal{{ $addictive->id }}">
                      <i class="bi bi-pencil-square"></i> แก้ไข
                    </button>
                    <button type="button" class="btn btn-sm btn-danger"
                            onclick="confirmDeleteAddictive({{ $addictive->id }})">
                      <i class="bi bi-trash"></i> ลบ
                    </button>
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
<div class="modal fade" id="createAddictiveModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">เพิ่มข้อมูลการตรวจสารเสพติด</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('addictive.store') }}" method="POST">
          @csrf
          <input type="hidden" name="client_id" value="{{ $client->id }}">

          <div class="row mb-2">
            <div class="col-12 col-md-3">
              <label class="form-label fw-bold">วันที่ตรวจ</label>
              <input type="date" name="date" class="form-control form-control-sm" required>
            </div>
            <div class="col-12 col-md-3">
              <label class="form-label fw-bold">ครั้งที่</label>
              <input type="number" name="count" class="form-control form-control-sm"
                     value="{{ $addictives->count() + 1 }}" readonly>
            </div>
            <div class="col-12 col-md-6">
              <label class="form-label fw-bold">ผลการตรวจ</label><br>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="exam" value="0" checked id="exam_no_new">
                <label class="form-check-label" for="exam_no_new">ไม่พบสารเสพติด</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="exam" value="1" id="exam_yes_new">
                <label class="form-check-label" for="exam_yes_new">พบสารเสพติด</label>
              </div>
            </div>
          </div>

          <div class="row mb-2" id="referField_new" style="display:none;">
            <div class="col-12 col-md-6">
              <label class="form-label fw-bold">การส่งต่อ</label><br>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="refer" value="1" id="refer_treatment_new">
                <label class="form-check-label" for="refer_treatment_new">ส่งต่อบำบัด</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="refer" value="2" id="refer_followup_new">
                <label class="form-check-label" for="refer_followup_new">ติดตามดูแลต่อเนื่อง</label>
              </div>
            </div>
          </div>

          <div class="mb-2">
            <label class="form-label fw-bold">บันทึกผล</label>
            <textarea name="record" class="form-control form-control-sm" rows="2"></textarea>
          </div>

          <div class="mb-2">
            <label class="form-label fw-bold">ผู้ตรวจ</label>
            <input type="text" name="recorder" class="form-control form-control-sm" required>
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

<!-- Modal แก้ไข -->
@foreach ($addictives as $addictive)
  <div class="modal fade" id="editAddictiveModal{{ $addictive->id }}" tabindex="-1" aria-hidden="true" data-addictive-id="{{ $addictive->id }}">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">แก้ไขข้อมูลการตรวจสารเสพติด</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <form action="{{ route('addictive.update', $addictive->id) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="client_id" value="{{ $client->id }}">

            <div class="row mb-2">
              <div class="col-12 col-md-3">
                <label class="form-label fw-bold">วันที่ตรวจ</label>
                <input type="date" name="date" class="form-control form-control-sm"
                       value="{{ old('date', $addictive->date) }}" required>
              </div>
              <div class="col-12 col-md-3">
                <label class="form-label fw-bold">ครั้งที่</label>
                <input type="number" name="count" class="form-control form-control-sm"
                       value="{{ old('count', $addictive->count) }}" readonly>
              </div>
              <div class="col-12 col-md-6">
                <label class="form-label fw-bold">ผลการตรวจ</label><br>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="exam" value="0"
                      {{ old('exam', $addictive->exam) == 0 ? 'checked' : '' }} id="exam_no_{{ $addictive->id }}">
                  <label class="form-check-label" for="exam_no_{{ $addictive->id }}">ไม่พบสารเสพติด</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="exam" value="1"
                      {{ old('exam', $addictive->exam) == 1 ? 'checked' : '' }} id="exam_yes_{{ $addictive->id }}">
                  <label class="form-check-label" for="exam_yes_{{ $addictive->id }}">พบสารเสพติด</label>
                </div>
              </div>
            </div>

            <div class="row mb-2" id="referField_{{ $addictive->id }}"
                 style="display: {{ old('exam', $addictive->exam) == 1 ? 'flex' : 'none' }};">
              <div class="col-12 col-md-6">
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
              </div>
            </div>

            <div class="mb-2">
              <label class="form-label fw-bold">บันทึกผล</label>
              <textarea name="record" class="form-control form-control-sm" rows="2">{{ old('record', $addictive->record) }}</textarea>
            </div>

            <div class="mb-2">
              <label class="form-label fw-bold">ผู้ตรวจ</label>
              <input type="text" name="recorder" class="form-control form-control-sm"
                     value="{{ old('recorder', $addictive->recorder) }}" required>
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
document.addEventListener('DOMContentLoaded', function () {
  // ✅ DataTable init
  $('#datatable-addictive').DataTable({
    responsive: true,
    autoWidth: false,
    pageLength: 10,
    ordering: true,
    language: {
      url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/th.json'
    },
    columnDefs: [
      { targets: 0, width: '6%', className: 'text-center' },   // ลำดับ
      { targets: 2, width: '8%', className: 'text-center' },   // ครั้งที่
      { targets: 6, width: '12%', className: 'text-center' },  // ผู้ตรวจ
      { targets: 7, width: '18%', className: 'text-center' }   // จัดการ
    ]
  });

  // ✅ SweetAlert delete confirm
  window.confirmDeleteAddictive = function(id) {
    Swal.fire({
      title: 'ท่านแน่ใจ ?',
      text: 'คุณต้องการลบข้อมูลนี้ใช่หรือไม่',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#6c757d',
      confirmButtonText: 'ตกลง',
      cancelButtonText: 'ยกเลิก',
    }).then((result) => {
      if (result.isConfirmed) {
        document.getElementById('delete-form-addictive-' + id).submit();
      }
    });
  };

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
  });
});
</script>
@endpush

@endsection