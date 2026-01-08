@extends('admin_client.admin_client')
@section('content')

<div class="card shadow-sm mt-4">
  <div class="card-header bg-light d-flex justify-content-between align-items-center">
    <h5 class="mb-0 fw-bold text-dark">
      <i class="bi bi-person-lines-fill me-2 text-primary"></i>
      ข้อมูลการออกจากสถานสงเคราะห์
    </h5>
    <div>
      

     <!-- ปุ่มย้อนกลับไปหน้าก่อนหน้า -->
<a href="{{ route('escape.index', $client->id) }}"
   class="btn btn-sm btn-outline-secondary rounded-pill shadow-sm">
  <i class="bi bi-arrow-left-circle me-1"></i> ย้อนกลับ
</a>
    </div>
  </div>

  <div class="card-body pt-0">
    <table class="table table-striped table-hover align-middle">
      <thead class="table-primary text-center">
        <tr>
          <th>ID</th>
          <th>วันที่ออก</th>
          <th>ประเภทการออก</th>
          <th>เรื่องราว/สาเหตุ</th>
          <th>Client ID</th>
          <th>วันที่สร้าง</th>
          <th>วันที่แก้ไขล่าสุด</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>{{ $escape->id }}</td>
          <td>{{ $escape->retire_date ? $escape->retire_date->format('d/m/Y') : '-' }}</td>
          <td>{{ $escape->retire->retire_name ?? '-' }}</td>
          <td>{{ $escape->stories ?? '-' }}</td>
          <td>{{ $escape->client_id }}</td>
          <td>{{ $escape->created_at ? $escape->created_at->format('d/m/Y H:i:s') : '-' }}</td>
          <td>{{ $escape->updated_at ? $escape->updated_at->format('d/m/Y H:i:s') : '-' }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>



<!-- Follow list -->
<div class="card mt-4 shadow-sm">
  <div class="card-header bg-light border-bottom d-flex justify-content-between align-items-center">
    <h6 class="mb-0 fw-bold text-dark">
      <i class="bi bi-list-check me-2 text-secondary"></i> รายการติดตาม
    </h6>
    <button type="button"
            class="btn btn-sm btn-outline-primary d-inline-flex align-items-center px-3"
            data-bs-toggle="modal"
            data-bs-target="#addFollowModal{{ $escape->id }}">
      <i class="bi bi-plus-circle me-1"></i> เพิ่มการติดตาม
    </button>
  </div>

  <div class="card-body">
    <table class="table table-striped table-hover text-center">
      <thead class="table-dark">
        <tr>
          <th>วันที่ติดตาม</th>
          <th>ครั้งที่</th>
          <th>พบ/ไม่พบ</th>
          <th>รายละเอียด</th>
          <th>แจ้งความ</th>
          <th>ยุติการติดตาม</th>
          <th>การลงโทษ</th>
          <th>หมายเหตุ</th>
          <th class="text-center">จัดการ</th>
        </tr>
      </thead>
      <tbody>
        @forelse($escape->follows as $f)
          <tr>
            <td>{{ $f->trace_date ? $f->trace_date->format('d/m/Y') : '-' }}</td>
            <td>{{ $f->count }}</td>
            <td>{{ $f->trac_no }}</td>
            <td>{{ $f->detail ?? '-' }}</td>
            <td>{{ $f->report_date ? $f->report_date->format('d/m/Y') : '-' }}</td>
            <td>{{ $f->stop_date ? $f->stop_date->format('d/m/Y') : '-' }}</td>
            <td>
              {{ $f->punish ?? '-' }}
              @if($f->punish_date)
                <br>{{ $f->punish_date->format('d/m/Y') }}
              @endif
            </td>
            <td>{{ $f->remark ?? '-' }}</td>
            <td class="text-center">
              <button type="button" class="btn btn-sm btn-warning"
                      data-bs-toggle="modal"
                      data-bs-target="#editFollowModal{{ $f->id }}">
                แก้ไข
              </button>
              <form id="delete-form-follow-{{ $f->id }}"
                    action="{{ route('escape_follows.delete', $f->id) }}"
                    method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-sm btn-danger"
                        onclick="confirmDelete('delete-form-follow-{{ $f->id }}','คุณต้องการลบข้อมูลการติดตามนี้ใช่หรือไม่')">
                  ลบ
                </button>
              </form>
            </td>
          </tr>

          <!-- Edit follow modal -->
          <div class="modal fade" id="editFollowModal{{ $f->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
              <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-warning text-dark">
                  <h5 class="modal-title fw-bold">
                    <i class="bi bi-pencil-square me-1"></i> แก้ไขการติดตาม (ครั้งที่ {{ $f->count }})
                  </h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                  <form action="{{ route('escape_follows.update', $f->id) }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="escape_id" value="{{ $escape->id }}">

                    <div class="row mb-3">
                      <div class="col-md-3">
                        <label class="form-label fw-bold">วันที่ติดตาม</label>
                        <input type="date" name="trace_date" class="form-control form-control-sm"
                               value="{{ old('trace_date', $f->trace_date?->format('Y-m-d')) }}" required>
                      </div>
                      <div class="col-md-2">
                        <label class="form-label fw-bold">ครั้งที่</label>
                        <input type="number" name="count" class="form-control form-control-sm"
                               value="{{ old('count', $f->count) }}" min="1" required>
                      </div>
                      <div class="col-md-3">
                        <label class="form-label fw-bold">พบ/ไม่พบ</label>
                        <select name="trac_no" class="form-select form-select-sm" required>
                          <option value="พบ" {{ $f->trac_no == 'พบ' ? 'selected' : '' }}>พบ</option>
                          <option value="ไม่พบ" {{ $f->trac_no == 'ไม่พบ' ? 'selected' : '' }}>ไม่พบ</option>
                        </select>
                      </div>
                      <div class="col-md-4">
                        <label class="form-label fw-bold">รายละเอียด</label>
                        <input type="text" name="detail" class="form-control form-control-sm"
                               value="{{ old('detail', $f->detail) }}">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <div class="col-md-3">
                        <label class="form-label fw-bold">วันที่แจ้งความ</label>
                        <input type="date" name="report_date" class="form-control form-control-sm"
                               value="{{ old('report_date', $f->report_date?->format('Y-m-d')) }}">
                      </div>
                      <div class="col-md-3">
                        <label class="form-label fw-bold">วันที่ยุติการติดตาม</label>
                        <input type="date" name="stop_date" class="form-control form-control-sm"
                               value="{{ old('stop_date', $f->stop_date?->format('Y-m-d')) }}">
                      </div>
                      <div class="col-md-3">
                        <label class="form-label fw-bold">การลงโทษ</label>
                        <input type="text" name="punish" class="form-control form-control-sm"
                               value="{{ old('punish', $f->punish) }}">
                      </div>
                      <div class="col-md-3">
                        <label class="form-label fw-bold">วันที่ลงโทษ</label>
                        <input type="date" name="punish_date" class="form-control form-control-sm"
                               value="{{ old('punish_date', $f->punish_date?->format('Y-m-d')) }}">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <div class="col-md-12">
                        <label class="form-label fw-bold">หมายเหตุ</label>
                        <input type="text" name="remark" class="form-control form-control-sm"
                               value="{{ old('remark', $f->remark) }}">
                      </div>
                    </div>

                    <div class="modal-footer d-flex justify-content-between">
                      <button type="submit" class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil-square me-1"></i> อัปเดตการติดตาม
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
        @empty
          <tr>
            <td colspan="9" class="text-center text-muted">ยังไม่มีข้อมูลการติดตาม</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<div class="modal fade" id="addFollowModal{{ $escape->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-fullscreen-sm-down">
    <div class="modal-content border-0 shadow-sm">
      <div class="modal-header bg-info text-white">
        <h5 class="modal-title fw-bold">
          <i class="bi bi-plus-circle me-1"></i> เพิ่มการติดตาม
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('escape_follows.store', $escape->id) }}" method="POST" class="needs-validation" novalidate>
          @csrf

          <div class="row mb-3">
            <div class="col-12 col-sm-6 col-md-3">
              <label class="form-label fw-bold">วันที่ติดตาม</label>
              <input type="date" name="trace_date" class="form-control form-control-sm" required>
            </div>
            <div class="col-12 col-sm-6 col-md-2">
              <label class="form-label fw-bold">ครั้งที่</label>
              <input type="number" name="count" class="form-control form-control-sm" min="1" required readonly>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-12 col-sm-6 col-md-3">
              <label class="form-label fw-bold">พบ/ไม่พบ</label>
              <select name="trac_no" class="form-select form-select-sm" required>
                <option value="พบ">พบ</option>
                <option value="ไม่พบ">ไม่พบ</option>
              </select>
            </div>
            <div class="col-12 col-sm-6 col-md-9">
              <label class="form-label fw-bold">รายละเอียด</label>
              <input type="text" name="detail" class="form-control form-control-sm">
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-12 col-sm-6 col-md-3">
              <label class="form-label fw-bold">วันที่แจ้งความ</label>
              <input type="date" name="report_date" class="form-control form-control-sm">
            </div>
            <div class="col-12 col-sm-6 col-md-3">
              <label class="form-label fw-bold">วันที่ยุติการติดตาม</label>
              <input type="date" name="stop_date" class="form-control form-control-sm">
            </div>
            <div class="col-12 col-md-6">
              <label class="form-label fw-bold">การลงโทษ</label>
              <input type="text" name="punish" class="form-control form-control-sm">
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-12 col-sm-6 col-md-3">
              <label class="form-label fw-bold">วันที่ลงโทษ</label>
              <input type="date" name="punish_date" class="form-control form-control-sm">
            </div>
            <div class="col-12 col-sm-6 col-md-9">
              <label class="form-label fw-bold">หมายเหตุ</label>
              <input type="text" name="remark" class="form-control form-control-sm">
            </div>
          </div>

          <div class="d-flex flex-wrap justify-content-end gap-2 mt-3">
            <button type="submit" class="btn btn-success btn-sm">
              <i class="bi bi-save me-1"></i> บันทึก
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

@if (session('success'))
  <div class="alert alert-success text-center fw-bold py-2 mb-3">
    {{ session('success') }}
  </div>
@endif

@endsection