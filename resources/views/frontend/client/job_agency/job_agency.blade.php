@extends('admin_client.admin_client')
@section('content')

<div class="container-fluid mt-2">
    <!-- ฟอร์ม JobAgency -->
    <div class="card shadow-sm border-0 w-100 mb-0">
        <!-- Header พร้อมปุ่ม toggle -->
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="mb-0 fw-bold">
                <i class="bi bi-briefcase-fill me-1"></i> การจัดหางานให้ผู้รับ
            </h6>
            <button type="button" class="btn btn-sm btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#createJobAgencyModal">
                <i class="bi bi-plus-circle me-1"></i> เพิ่มข้อมูล
            </button>
        </div>

        {{-- ข้อมูล client --}}
        <div class="card mb-1 shadow-sm">
            <div class="card-body">
                <div class="row mb-2">
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

        @if($jobAgencies->isNotEmpty())
        <div class="card mt-1 shadow-sm border-0 me-2 ms-2">
            <div class="card-body p-2">
                <div class="table-responsive">
               <table id="datatable-jobagency" class="table table-sm table-striped table-hover align-middle w-100 mb-0">
    <thead>
        <tr>
            <th>วันที่เริ่มงาน</th>
            <th>อาชีพ</th>
            <th>ตำแหน่ง</th>
            <th>รายได้/เดือน</th>
            <th>บริษัท</th>
            <th>ผู้ประสานงาน</th>
            <th>หมายเหตุ</th>
            <th style="width:15%">จัดการ</th>
        </tr>
    </thead>
    <tbody class="small">
        @foreach ($jobAgencies as $job)
        <tr>
            <td >{{ \Carbon\Carbon::parse($job->job_date)->format('d/m/Y') }}</td>
            <td>{{ $job->occupation->occupation_name ?? '-' }}</td>
            <td>{{ $job->position }}</td>
            <td>{{ number_format($job->income, 2) }}</td>
            <td>{{ $job->company }}</td>
            <td>{{ $job->coordinator }}</td>
            <td>{{ $job->remark ?? '-' }}</td>
            <td class="text-center">
                <!-- ปุ่มแก้ไข -->
                <button type="button" class="btn btn-success btn-sm"
                        data-bs-toggle="modal"
                        data-bs-target="#editJobAgencyModal{{ $job->id }}">
                    <i class="bi bi-pencil-square"></i> แก้ไข
                </button>

                <!-- ฟอร์มลบ -->
                <form id="delete-form-job-{{ $job->id }}" 
                      action="{{ route('job_agencies.delete', $job->id) }}" 
                      method="POST" style="display:none;">
                    @csrf 
                    @method('DELETE')
                </form>

                <!-- ปุ่มลบ -->
                <button type="button" class="btn btn-danger btn-sm ms-1"
                        onclick="confirmDelete('delete-form-job-{{ $job->id }}', 'คุณต้องการลบข้อมูลนี้ใช่หรือไม่?')">
                    <i class="bi bi-trash"></i> ลบ
                </button>
            </td>
        </tr>

        <!-- Modal Edit -->
<div class="modal fade" id="editJobAgencyModal{{ $job->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content shadow-lg border-0 rounded-3">
      <div class="modal-header bg-warning bg-opacity-25">
        <h5 class="modal-title fw-bold">
          <i class="bi bi-pencil-square me-2"></i> แก้ไขข้อมูลการจัดหางาน
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <form id="editJobAgencyForm{{ $job->id }}" action="{{ route('job_agencies.update',$job->id) }}" method="POST">
          @csrf @method('PUT')
          <input type="hidden" name="client_id" value="{{ $client->id }}">

          <div class="row g-3">
            <div class="col-md-4">
              <label class="form-label fw-bold">วันที่เริ่มงาน</label>
              <input type="date" name="job_date"
                     value="{{ \Carbon\Carbon::parse($job->job_date)->format('Y-m-d') }}"
                     class="form-control form-control-sm">
            </div>

            <div class="col-md-8">
              <label class="form-label fw-bold">อาชีพ</label>
              <select name="occupation_id" class="form-select form-select-sm">
                <option value="">-- เลือกอาชีพ --</option>
                @foreach($occupations as $occ)
                  <option value="{{ $occ->id }}" {{ $job->occupation_id == $occ->id ? 'selected' : '' }}>
                    {{ $occ->occupation_name }}
                  </option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="row g-3 mt-2">
            <div class="col-md-6">
              <label class="form-label fw-bold">ตำแหน่ง</label>
              <input type="text" name="position" value="{{ $job->position }}" class="form-control form-control-sm">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold">รายได้ (บาท/เดือน)</label>
              <input type="number" name="income" value="{{ $job->income }}" class="form-control form-control-sm">
            </div>
          </div>

          <div class="row g-3 mt-2">
            <div class="col-md-6">
              <label class="form-label fw-bold">บริษัท/หน่วยงาน</label>
              <input type="text" name="company" value="{{ $job->company }}" class="form-control form-control-sm">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold">ผู้ประสานงาน</label>
              <input type="text" name="coordinator" value="{{ $job->coordinator }}" class="form-control form-control-sm">
            </div>
          </div>

          <div class="mt-3">
            <label class="form-label fw-bold">หมายเหตุ</label>
            <textarea name="remark" class="form-control form-control-sm" rows="2">{{ $job->remark }}</textarea>
          </div>

          <div class="d-flex justify-content-end gap-2 mt-3">
            <button type="submit" class="btn btn-success btn-sm">
              <i class="bi bi-save me-1"></i> บันทึกการแก้ไข
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
<!-- End Modal Edit -->

        <!-- End Modal Edit -->
        @endforeach
    </tbody>
</table>
          </div>
      </div>
  </div>
  @else
            <!-- ✅ กรณีไม่มีข้อมูล -->
            <div class="alert alert-info text-center">
                ยังไม่มีข้อมูลการจัดหางาน
            </div>
        @endif
    </div>
</div>

<!-- Modal เพิ่มข้อมูล JobAgency -->
<div class="modal fade" id="createJobAgencyModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content shadow-sm border-0">
      <div class="modal-header bg-primary bg-opacity-25">
        <h5 class="modal-title fw-bold">
          <i class="bi bi-plus-circle me-1"></i> เพิ่มข้อมูลการจัดหางาน
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="createJobAgencyForm" action="{{ route('job_agencies.store') }}" method="POST">
          @csrf
          <input type="hidden" name="client_id" value="{{ $client->id }}">

          <div class="row mb-2">
            <div class="col-12 col-md-4">
              <label class="form-label fw-bold">
                วันที่เริ่มงาน <span class="text-danger">*</span>
              </label>
              <input type="date" name="job_date"
                    class="form-control form-control-sm @error('job_date') is-invalid @enderror"
                    value="{{ old('job_date') }}">
              @error('job_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-12 col-md-6">
              <label class="form-label fw-bold">
                อาชีพ <span class="text-danger">*</span>
              </label>
              <select name="occupation_id"
                      class="form-select form-select-sm @error('occupation_id') is-invalid @enderror">
                <option value="">-- เลือกอาชีพ --</option>
                @foreach($occupations as $occ)
                  <option value="{{ $occ->id }}" {{ old('occupation_id') == $occ->id ? 'selected' : '' }}>
                    {{ $occ->occupation_name }}
                  </option>
                @endforeach
              </select>
              @error('occupation_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
          </div>

          <div class="row mb-2 mt-2">
            <div class="col-12 col-md-6">
              <label class="form-label fw-bold">
                ตำแหน่ง <span class="text-danger">*</span>
              </label>
              <input type="text" name="position"
                    class="form-control form-control-sm @error('position') is-invalid @enderror"
                    value="{{ old('position') }}">
              @error('position') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-12 col-md-6">
              <label class="form-label fw-bold">
                รายได้ (บาท/เดือน) <span class="text-danger">*</span>
              </label>
              <input type="number" name="income"
                    class="form-control form-control-sm @error('income') is-invalid @enderror"
                    value="{{ old('income') }}">
              @error('income') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
          </div>

          <div class="row mb-2 mt-2">
            <div class="col-12 col-md-6">
              <label class="form-label fw-bold">
                บริษัท/หน่วยงาน <span class="text-danger">*</span>
              </label>
              <input type="text" name="company"
                    class="form-control form-control-sm @error('company') is-invalid @enderror"
                    value="{{ old('company') }}">
              @error('company') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-12 col-md-6">
              <label class="form-label fw-bold">
                ผู้ประสานงาน <span class="text-danger">*</span>
              </label>
              <input type="text" name="coordinator"
                    class="form-control form-control-sm @error('coordinator') is-invalid @enderror"
                    value="{{ old('coordinator') }}">
              @error('coordinator') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
          </div>

          <div class="mb-2 mt-2">
            <label class="form-label fw-bold">หมายเหตุ</label>
            <textarea name="remark"
                      class="form-control form-control-sm @error('remark') is-invalid @enderror"
                      rows="2">{{ old('remark') }}</textarea>
            @error('remark') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="d-flex justify-content-end gap-2">
            <button type="submit" class="btn btn-success btn-sm">
              <i class="bi bi-save me-1"></i> บันทึกข้อมูล
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const openBtn = document.querySelector('[data-bs-target="#createJobAgencyModal"]');
    const form = document.getElementById('createJobAgencyForm');

    // ✅ รีเซ็ตฟอร์ม create ทุกครั้งที่กดปุ่ม "เพิ่มข้อมูล"
    if (openBtn && form) {
        openBtn.addEventListener('click', function () {
            form.reset();
            form.querySelectorAll('select').forEach(sel => sel.selectedIndex = 0);
            form.querySelectorAll('input[type=radio]').forEach(r => r.checked = false);
        });
    }

    // ✅ ตรวจสอบฟอร์ม create แบบ client-side
    if (form) {
        form.addEventListener('submit', function (e) {
            let valid = true;
            let messages = [];

            if (!form.querySelector('input[name="job_date"]').value) {
                valid = false; messages.push('กรุณาเลือกวันที่เริ่มงาน');
            }
            if (!form.querySelector('select[name="occupation_id"]').value) {
                valid = false; messages.push('กรุณาเลือกอาชีพ');
            }
            if (!form.querySelector('input[name="position"]').value.trim()) {
                valid = false; messages.push('กรุณากรอกตำแหน่งงาน');
            }
            if (!form.querySelector('input[name="income"]').value.trim()) {
                valid = false; messages.push('กรุณากรอกรายได้');
            }
            if (!form.querySelector('input[name="company"]').value.trim()) {
                valid = false; messages.push('กรุณากรอกชื่อบริษัท/หน่วยงาน');
            }
            if (!form.querySelector('input[name="coordinator"]').value.trim()) {
                valid = false; messages.push('กรุณากรอกชื่อผู้ประสานงาน');
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
    }

    // ✅ ตรวจสอบ error จาก Laravel
    @if ($errors->any())
        @if (old('job_id'))
            // กรณี error จาก edit → เปิด modal edit ของ record นั้น
            const modalId = 'editJobAgencyModal' + {{ old('job_id') }};
            const modalEl = document.getElementById(modalId);
            if (modalEl) {
                const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                modal.show();
            }
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                confirmButtonText: 'ตกลง'
            });
        @else
            // กรณี error จาก create → เปิด modal create
            const modalEl = document.getElementById('createJobAgencyModal');
            const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            modal.show();
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                confirmButtonText: 'ตกลง'
            });
        @endif
    @endif

    // ✅ success message
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
</script>
@endpush
@endsection