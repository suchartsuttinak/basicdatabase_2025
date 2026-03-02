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
                <form action="{{ route('job_agencies.update',$job->id) }}" method="POST">
                  @csrf @method('PUT')
                  <input type="hidden" name="client_id" value="{{ $client->id }}">

                  <!-- ฟอร์มแก้ไข -->
                  <div class="row g-3">
                    <div class="col-md-4">
                      <label class="form-label fw-bold">วันที่เริ่มงาน</label>
                      <input type="date" name="job_date"
                             value="{{ \Carbon\Carbon::parse($job->job_date)->format('Y-m-d') }}"
                             class="form-control form-control-sm" required>
                    </div>

                    <div class="col-md-8">
                      <label class="form-label fw-bold">อาชีพ</label>
                      <select name="occupation_id" class="form-select form-select-sm" required>
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
                      <input type="text" name="position" value="{{ $job->position }}" class="form-control form-control-sm" required>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label fw-bold">รายได้ (บาท/เดือน)</label>
                      <input type="number" name="income" value="{{ $job->income }}" class="form-control form-control-sm" required>
                    </div>
                  </div>

                  <div class="row g-3 mt-2">
                    <div class="col-md-6">
                      <label class="form-label fw-bold">บริษัท/หน่วยงาน</label>
                      <input type="text" name="company" value="{{ $job->company }}" class="form-control form-control-sm" required>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label fw-bold">ผู้ประสานงาน</label>
                      <input type="text" name="coordinator" value="{{ $job->coordinator }}" class="form-control form-control-sm" required>
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
        <form action="{{ route('job_agencies.store') }}" method="POST">
          @csrf
          <input type="hidden" name="client_id" value="{{ $client->id }}">

          <div class="row mb-2">
            <div class="col-12 col-md-4">
              <label class="form-label fw-bold">วันที่เริ่มงาน</label>
              <input type="date" name="job_date" class="form-control form-control-sm" required>
            </div>
            <div class="col-12 col-md-6">
              <label class="form-label fw-bold">อาชีพ</label>
              <select name="occupation_id" class="form-select form-select-sm" required>
                <option value="">-- เลือกอาชีพ --</option>
                @foreach($occupations as $occ)
                  <option value="{{ $occ->id }}" {{ isset($job) && $job->occupation_id == $occ->id ? 'selected' : '' }}>
                    {{ $occ->occupation_name }}
                  </option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="row mb-2 mt-2">
            <div class="col-12 col-md-6">
              <label class="form-label fw-bold">ตำแหน่ง</label>
              <input type="text" name="position" class="form-control form-control-sm" required>
            </div>
            <div class="col-12 col-md-6">
              <label class="form-label fw-bold">รายได้ (บาท/เดือน)</label>
              <input type="number" name="income" class="form-control form-control-sm" required>
            </div>
          </div>

          <div class="row mb-2 mt-2">
            <div class="col-12 col-md-6">
              <label class="form-label fw-bold">บริษัท/หน่วยงาน</label>
              <input type="text" name="company" class="form-control form-control-sm" required>
            </div>
            <div class="col-12 col-md-6">
              <label class="form-label fw-bold">ผู้ประสานงาน</label>
              <input type="text" name="coordinator" class="form-control form-control-sm" required>
            </div>
          </div>

          <div class="mb-2 mt-2">
            <label class="form-label fw-bold">หมายเหตุ</label>
            <textarea name="remark" class="form-control form-control-sm" rows="2"></textarea>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(formId, message) {
        Swal.fire({
            title: 'ยืนยันการลบ',
            text: message,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'ใช่, ลบข้อมูล!',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(formId).submit();
            }
        });
    }

    // ✅ DataTable ภาษาไทย
    $(document).ready(function() {
        $('#datatable-jobagency').DataTable({
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/th.json'
            }
        });
    });
</script>
@endpush
@endsection