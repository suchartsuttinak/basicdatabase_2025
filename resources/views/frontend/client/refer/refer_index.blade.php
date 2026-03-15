@extends('admin_client.admin_client')
@section('content')


<div class="container-fluid mt-2">
    <div class="card shadow-sm border-0 w-100 mb-0">
        <div class="card-header bg-light fw-bold text-dark py-2 px-3 d-flex justify-content-between align-items-center">
            <div>
                <i class="bi bi-box-arrow-right me-2"></i> ตารางการจำหน่ายผู้รับออกจากสถานสงเคราะห์
            </div>
            <!-- ปุ่มเปิด Modal -->
<button type="button" class="btn btn-sm btn-primary"
    data-bs-toggle="modal"
    data-bs-target="#createReferModal">
    <i class="bi bi-plus-circle me-1"></i> เพิ่มข้อมูลจำหน่าย
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
        

        <div class="card mt-1 shadow-sm rounded-1 border-0 ms-2 me-2">
            <div class="card-body p-2">
                <div class="table-responsive">
                    <table id="datatable-refer" class="table table-sm table-striped table-hover align-middle w-100 mb-0">
                        <thead class="table-primary text-center small">
                            <tr>
                                <th>วันที่นำส่ง</th>
                                <th>ชื่อผู้รับ</th>
                                <th>สาเหตุ</th>
                                <th>สถานที่นำส่ง</th>
                                <th>ผู้ดูแล</th>
                                <th>ผู้รับตัว</th>
                                <th>โทรศัพท์</th>
                                <th>ความสัมพันธ์</th>
                                <th>ผู้นำส่ง</th>
                                <th>หมายเหตุ</th>
                                <th>จัดการ</th>
                            </tr>
                        </thead>
                        <tbody class="small">
                            @forelse ($refers as $index => $refer)
                                <tr>
                                   
                                    <td>{{ \Carbon\Carbon::parse($refer->refer_date)->format('d/m/Y') }}</td>
                                    <td>{{ $refer->client->name ?? '-' }}</td>
                                    <td>{{ $refer->translate->translate_name ?? '-' }}</td>
                                    <td>{{ $refer->destination ?? '-' }}</td>
                                    <td>{{ $refer->guardian }}</td>
                                    <td>{{ $refer->parent_name ?? '-' }}</td>
                                    <td>{{ $refer->parent_tel ?? '-' }}</td>
                                    <td>{{ $refer->member ?? '-' }}</td>
                                    <td>{{ $refer->teacher ?? '-' }}</td>
                                    <td>{{ $refer->remark ?? '-' }}</td>
                                    <td class="text-center">
                                        <form action="{{ route('refers.restore', $refer->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-success">
                                                <i class="bi bi-arrow-counterclockwise"></i> Restore
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="12" class="text-center text-muted small">
                                        <i class="bi bi-info-circle"></i> ยังไม่มีข้อมูลการจำหน่าย
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="createReferModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg">
      
      <!-- Header -->
      <div class="modal-header bg-dark text-white border-bottom-0">
        <h5 class="modal-title fw-bold">
          <i class="bi bi-file-earmark-plus me-2"></i> แบบฟอร์มบันทึกข้อมูลการจำหน่าย
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <!-- Body -->
      <div class="modal-body bg-light">
        <form action="{{ route('refers.store') }}" method="POST" id="referForm" class="needs-validation" novalidate>
          @csrf
          <input type="hidden" name="client_id" value="{{ $client->id }}">
          <input type="hidden" name="status" value="refer">

          <!-- วันที่นำส่ง -->
          <div class="row mb-3">
            <div class="col-md-4">
              <label class="form-label fw-bold text-dark">วันที่นำส่ง <span class="text-danger">*</span></label>
              <input type="date" name="refer_date" class="form-control form-control-sm" required>
              <div class="invalid-feedback">กรุณาเลือกวันที่นำส่ง</div>
            </div>
            <div class="col-md-8">
              <label class="form-label fw-bold text-dark">สาเหตุการจำหน่าย <span class="text-danger">*</span></label>
              <select name="translate_id" class="form-select form-select-sm" required>
                <option value="">-- เลือก --</option>
                @foreach($translates as $t)
                  <option value="{{ $t->id }}">{{ $t->translate_name }}</option>
                @endforeach
              </select>
              <div class="invalid-feedback">กรุณาเลือกสาเหตุการจำหน่าย</div>
            </div>
          </div>

          <!-- สถานที่นำส่ง -->
          <div class="mb-3">
            <label class="form-label fw-bold text-dark">ชื่อสถานที่นำส่ง <span class="text-danger">*</span></label>
            <input type="text" name="destination" class="form-control form-control-sm" required>
            <div class="invalid-feedback">กรุณากรอกชื่อสถานที่นำส่ง</div>
          </div>

          <!-- ที่อยู่ -->
          <div class="mb-3">
            <label class="form-label fw-bold text-dark">ที่อยู่ <span class="text-danger">*</span></label>
            <textarea name="address" class="form-control form-control-sm" rows="2" required></textarea>
            <div class="invalid-feedback">กรุณากรอกที่อยู่</div>
          </div>

          <!-- Guardian -->
          <div class="mb-3">
            <label class="form-label fw-bold text-dark">ผู้ดูแล <span class="text-danger">*</span></label><br>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="guardian" value="มี" onclick="toggleGuardian(true)" required>
              <label class="form-check-label">มี</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="guardian" value="ไม่มี" onclick="toggleGuardian(false)" required>
              <label class="form-check-label">ไม่มี</label>
            </div>
            <div class="invalid-feedback d-block">กรุณาเลือกว่ามีผู้ดูแลหรือไม่</div>
          </div>

          <!-- Guardian Fields -->
          <div id="guardianFields" style="display:none;">
            <div class="row mb-3">
              <div class="col-md-4">
                <label class="form-label fw-bold text-dark">ชื่อผู้รับตัว</label>
                <input type="text" name="parent_name" class="form-control form-control-sm">
              </div>
              <div class="col-md-4">
                <label class="form-label fw-bold text-dark">โทรศัพท์</label>
                <input type="text" name="parent_tel" class="form-control form-control-sm">
              </div>
              <div class="col-md-4">
                <label class="form-label fw-bold text-dark">ความสัมพันธ์</label>
                <input type="text" name="member" class="form-control form-control-sm">
              </div>
            </div>
          </div>

          <!-- Teacher -->
          <div class="mb-3">
            <label class="form-label fw-bold text-dark">ชื่อผู้นำส่ง</label>
            <input type="text" name="teacher" class="form-control form-control-sm">
          </div>

          <!-- Remark -->
          <div class="mb-3">
            <label class="form-label fw-bold text-dark">หมายเหตุ</label>
            <textarea name="remark" class="form-control form-control-sm" rows="2"></textarea>
          </div>

          <!-- Footer -->
          <div class="modal-footer border-top-0 d-flex justify-content-end">
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
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const openBtn = document.querySelector('[data-bs-target="#createReferModal"]');
    const form = document.getElementById('referForm');
    const guardianFields = document.getElementById('guardianFields');
    const guardianRadios = form.querySelectorAll('input[name="guardian"]');

    // ✅ รีเซ็ตฟอร์มทุกครั้งที่เปิด Modal
    if (openBtn && form) {
        openBtn.addEventListener('click', function () {
            form.reset();
            guardianFields.style.display = 'none';
            form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
            form.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
        });
    }

    // ✅ ให้ radio ผู้ดูแลทำงานเหมือนเดิม
    guardianRadios.forEach(radio => {
        radio.addEventListener('change', function () {
            if (this.value === 'มี') {
                toggleGuardian(true);
            } else {
                toggleGuardian(false);
            }
        });
    });

    // ✅ Client-side validation
    if (form) {
        form.addEventListener('submit', function (e) {
            let valid = true;
            let messages = [];

            const dateInput = form.querySelector('input[name="refer_date"]');
            if (!dateInput.value) {
                valid = false;
                messages.push('กรุณาเลือกวันที่นำส่ง');
                dateInput.classList.add('is-invalid');
            }

            const translateSelect = form.querySelector('select[name="translate_id"]');
            if (!translateSelect.value) {
                valid = false;
                messages.push('กรุณาเลือกสาเหตุการจำหน่าย');
                translateSelect.classList.add('is-invalid');
            }

            const destinationInput = form.querySelector('input[name="destination"]');
            if (!destinationInput.value.trim()) {
                valid = false;
                messages.push('กรุณากรอกชื่อสถานที่นำส่ง');
                destinationInput.classList.add('is-invalid');
            }

             const teacherInput = form.querySelector('input[name="teacher"]');
            if (!teacherInput.value.trim()) {
                valid = false;
                messages.push('กรุณากรอกชื่อผู้นำส่ง');
                teacherInput.classList.add('is-invalid');
            }



            const addressInput = form.querySelector('textarea[name="address"]');
            if (!addressInput.value.trim()) {
                valid = false;
                messages.push('กรุณากรอกที่อยู่');
                addressInput.classList.add('is-invalid');
            }

            if (![...guardianRadios].some(r => r.checked)) {
                valid = false;
                messages.push('กรุณาเลือกว่ามีผู้ดูแลหรือไม่');
            }

            if (!valid) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด',
                    html: messages.join('<br>'),
                    confirmButtonText: 'ตกลง'
                });
            }
        });

        // ✅ ลบ error เมื่อแก้ไข input
        form.addEventListener('input', function (e) {
            if (e.target.classList.contains('is-invalid')) {
                e.target.classList.remove('is-invalid');
                const nextEl = e.target.nextElementSibling;
                if (nextEl && nextEl.classList.contains('invalid-feedback')) {
                    nextEl.remove();
                }
            }
        });
    }

    // ✅ Error จาก Laravel (server-side)
    @if ($errors->any())
        const modalEl = document.getElementById('createReferModal');
        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
        modal.show();
        Swal.fire({
            icon: 'error',
            title: 'เกิดข้อผิดพลาด',
            html: `{!! implode('<br>', $errors->all()) !!}`,
            confirmButtonText: 'ตกลง'
        });
    @endif

    // ✅ Success message
    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'สำเร็จ',
            text: '{{ session('success') }}',
            timer: 3000,
            confirmButtonText: 'ตกลง'
        });
    @endif
});

// ✅ ฟังก์ชัน toggleGuardian
function toggleGuardian(show) {
    const guardianFields = document.getElementById('guardianFields');
    if (show) {
        guardianFields.style.display = 'block';
    } else {
        guardianFields.style.display = 'none';
        guardianFields.querySelectorAll('input').forEach(el => el.value = '');
    }
}
</script>
@endpush
@endsection