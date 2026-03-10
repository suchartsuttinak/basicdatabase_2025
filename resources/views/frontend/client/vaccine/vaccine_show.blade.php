@extends('admin_client.admin_client')
@section('content')

<div class="card shadow-sm border-0 mt-3">
    <div class="card-header bg-light fw-bold text-dark py-2 px-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="bi bi-capsule-pill me-2 text-primary"></i> ประวัติการให้วัคซีน
        </h5>
        <!-- ✅ ปุ่มเปิด Modal -->
      <button type="button" 
        id="btn-add-vaccine"
        class="btn btn-sm btn-primary d-flex align-items-center shadow-sm px-3"
        data-bs-toggle="modal"
        data-bs-target="#add-vaccine-modal">
        <i class="bi bi-plus-circle me-1"></i>
        <span>เพิ่มข้อมูล</span>
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
        </div>

        <!-- ตารางวัคซีน -->
        <div class="card-body">
            @if($vaccinations->isEmpty())
                <!-- ✅ กรณีไม่มีข้อมูล -->
                <div class="alert alert-info text-center">
                    ยังไม่มีข้อมูลวัคซีน
                </div>
            @else
        <table id="datatable-vaccine" class="table table-bordered table-striped align-middle">
            <thead class="table-primary">
                <tr>
                    <th scope="col">วันที่รับวัคซีน</th>
                    <th scope="col">ชนิดวัคซีน</th>
                    <th scope="col">สถานพยาบาล</th>
                    <th scope="col">หมายเหตุ</th>
                    <th scope="col">ผู้บันทึก</th>
                    <th scope="col" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vaccinations as $item)
                    <tr>
                        <td>{{ $item->date }}</td>
                        <td>{{ $item->vaccine_name }}</td>
                        <td>{{ $item->hospital }}</td>
                        <td>{{ $item->remark }}</td>
                        <td>{{ $item->recorder }}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-success btn-sm"
                                 onclick="vaccineEdit({{ $item->id }})">
                                <i class="bi bi-pencil-square"></i>
                                <span>แก้ไข</span>


                            </button>

                            <!-- ✅ ฟอร์มลบแบบซ่อน -->
                            <form id="delete-form-{{ $item->id }}" 
                                  action="{{ route('vaccine.delete', $item->id) }}" 
                                  method="POST" style="display:none;">
                                @csrf
                                @method('DELETE')
                            </form>

                           <!-- ✅ ฟอร์มลบแบบ hidden -->
                                <form id="delete-form-item-{{ $item->id }}" 
                                    action="{{ route('vaccine.delete', $item->id) }}" 
                                    method="POST" style="display:none;">
                                    @csrf 
                                    @method('DELETE')
                                </form>

                                <!-- ✅ ปุ่มลบเรียก SweetAlert -->
                                <button type="button" class="btn btn-danger btn-sm ms-1"
                                        onclick="confirmDelete('delete-form-item-{{ $item->id }}', 'คุณต้องการลบข้อมูลนี้ใช่หรือไม่')">
                                    <i class="bi bi-trash"></i> ลบ
                                </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif   <!-- ✅ ปิดเงื่อนไข -->
</div>


{{-- ✅ Modal Add Vaccine --}}
<div class="modal fade" id="add-vaccine-modal" tabindex="-1" aria-labelledby="addVaccineLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="{{ route('vaccine.store') }}" method="POST" id="add-vaccine-form" novalidate>
        @csrf
        <input type="hidden" name="client_id" value="{{ $client->id }}">

        <!-- Header -->
        <div class="modal-header bg-primary text-white py-2">
          <h5 class="modal-title fw-bold" id="addVaccineLabel">
            <i class="bi bi-capsule-pill me-2"></i> เพิ่มข้อมูลวัคซีน
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>

        <!-- Body -->
        <div class="modal-body">
          <div class="row mb-3">
            <div class="col-md-4">
              <label class="form-label fw-bold">วันรับวัคซีน</label>
              <input type="date" name="date"
                     class="form-control form-control-sm @error('date') is-invalid @enderror"
                     value="{{ old('date') }}">
              @error('date') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-8">
              <label class="form-label fw-bold">ชนิดวัคซีน</label>
              <input type="text" name="vaccine_name"
                     class="form-control form-control-sm @error('vaccine_name') is-invalid @enderror"
                     value="{{ old('vaccine_name') }}">
              @error('vaccine_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold">สถานพยาบาล</label>
            <input type="text" name="hospital" class="form-control form-control-sm" value="{{ old('hospital') }}">
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold">หมายเหตุ</label>
            <textarea name="remark" class="form-control form-control-sm" rows="2">{{ old('remark') }}</textarea>
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold">ผู้บันทึก</label>
            <input type="text" name="recorder" class="form-control form-control-sm" value="{{ old('recorder') }}">
          </div>
        </div>

        <!-- Footer -->
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">
            <i class="bi bi-save me-1"></i> บันทึก
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
    const addModal = new bootstrap.Modal(document.getElementById('add-vaccine-modal'));
    addModal.show();
});
</script>
@endif
<!-- ✅ Modal Edit Vaccine -->
<div class="modal fade" id="edit-vaccine-modal" tabindex="-1" aria-labelledby="editVaccineLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <!-- ✅ ให้ action มีค่า default -->
      <form method="POST" id="edit-vaccine-form" action="{{ route('vaccine.update', 0) }}">
        @csrf
        @method('PUT')

        <!-- Header -->
        <div class="modal-header bg-warning text-dark py-2">
          <h5 class="modal-title fw-bold" id="editVaccineLabel">
            <i class="bi bi-pencil-square me-2"></i> แก้ไขข้อมูลวัคซีน
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <!-- Body -->
        <div class="modal-body">
          <div class="row mb-3">
            <div class="col-md-4">
              <label class="form-label fw-bold">วันที่รับวัคซีน</label>
              <input type="date" name="date" id="edit_date"
                     class="form-control form-control-sm @error('date') is-invalid @enderror"
                     value="">
              @error('date') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-8">
              <label class="form-label fw-bold">ชนิดวัคซีน</label>
              <input type="text" name="vaccine_name" id="edit_vaccine_name"
                     class="form-control form-control-sm @error('vaccine_name') is-invalid @enderror"
                     value="">
              @error('vaccine_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold">สถานพยาบาล</label>
            <input type="text" name="hospital" id="edit_hospital" class="form-control form-control-sm">
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold">เจ้าหน้าที่</label>
            <input type="text" name="recorder" id="edit_recorder" class="form-control form-control-sm">
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold">หมายเหตุ</label>
            <textarea name="remark" id="edit_remark" class="form-control form-control-sm" rows="2"></textarea>
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
    // ✅ ตั้งค่า default วันที่เป็นวันนี้ ถ้ามี field date
    const dateInput = form?.querySelector('input[name="date"]');
    if (dateInput) {
      const today = new Date().toISOString().split('T')[0];
      dateInput.value = today;
    }
  }

  // ✅ เคลียร์ error ทันทีเมื่อผู้ใช้เริ่มกรอกใหม่
  function attachRealtimeValidationClear(form) {
    form.querySelectorAll('input, select, textarea').forEach(el => {
      el.addEventListener('input', () => {
        el.classList.remove('is-invalid');
        const feedback = el.nextElementSibling;
        if (feedback && feedback.classList.contains('invalid-feedback')) {
          feedback.remove();
        }
      });
    });
  }

  document.addEventListener("DOMContentLoaded", function() {
    // ✅ DataTable
    $('#datatable-vaccine').DataTable({
      responsive: true,
      language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/th.json' }
    });

    const createModal = document.getElementById('add-vaccine-modal');
    const editModal   = document.getElementById('edit-vaccine-modal');
    const addBtn      = document.getElementById('btn-add-vaccine');

    // ✅ กดปุ่ม “เพิ่มข้อมูล” → reset ฟอร์มก่อนเปิด modal
    addBtn?.addEventListener('click', () => {
      if (createModal) resetForm(createModal);
    });

    // ✅ ปิด modal → reset ฟอร์ม
    if (createModal) {
      createModal.addEventListener('hidden.bs.modal', () => resetForm(createModal));
      attachRealtimeValidationClear(createModal.querySelector('form'));
    }
    if (editModal) {
      editModal.addEventListener('hidden.bs.modal', () => resetForm(editModal));
      attachRealtimeValidationClear(editModal.querySelector('form'));
    }

    // ✅ เปิด modal edit อัตโนมัติเมื่อมี error
    @if ($errors->any() && session('edit_mode') && session('edit_id'))
      const editInstance = bootstrap.Modal.getOrCreateInstance(editModal);
      editInstance.show();
      const form = document.getElementById('edit-vaccine-form');
      form.setAttribute('action', '/vaccine/update/' + "{{ session('edit_id') }}");

      // เติมค่า old() กลับไปในช่อง input
      document.getElementById('edit_date').value         = "{{ old('date') }}";
      document.getElementById('edit_vaccine_name').value = "{{ old('vaccine_name') }}";
      document.getElementById('edit_hospital').value     = "{{ old('hospital') }}";
      document.getElementById('edit_recorder').value     = "{{ old('recorder') }}";
      document.getElementById('edit_remark').value       = "{{ old('remark') }}";
    @endif

    // ✅ เปิด modal create อัตโนมัติเมื่อมี error
    @if ($errors->any() && !session('edit_mode'))
      const addInstance = bootstrap.Modal.getOrCreateInstance(createModal);
      addInstance.show();
    @endif
  });

  // ✅ โหลดข้อมูลลงฟอร์ม edit (ใช้ JSON)
  function vaccineEdit(id){
    fetch(`/vaccine/edit/${id}`)
      .then(response => response.json())
      .then(data => {
        const modalEl = document.getElementById('edit-vaccine-modal');
        const form = modalEl.querySelector('form');

        // ✅ เคลียร์ error ที่ค้างจาก create ก่อน
        form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        form.querySelectorAll('.invalid-feedback').forEach(el => el.remove());

        // ✅ เติมข้อมูลลงฟอร์ม
        modalEl.querySelector('#edit_date').value         = data.date ?? '';
        modalEl.querySelector('#edit_vaccine_name').value = data.vaccine_name ?? '';
        modalEl.querySelector('#edit_hospital').value     = data.hospital ?? 'ไม่ระบุ';
        modalEl.querySelector('#edit_recorder').value     = data.recorder ?? '';
        modalEl.querySelector('#edit_remark').value       = data.remark ?? '';

        form.action = `/vaccine/update/${data.id}`;
        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
        modal.show();

        // ✅ ผูก event เคลียร์ error แบบ real-time
        attachRealtimeValidationClear(form);
      })
      .catch(err => console.error(err));
  }
</script>
@endpush
@endsection