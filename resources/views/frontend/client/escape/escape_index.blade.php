@extends('admin_client.admin_client')
@section('content')

<div class="card-body pt-3">
  {{-- หัวข้อ + ปุ่ม --}}
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold text-primary text-center flex-grow-1 mb-0">
      ข้อมูลการออกจากสถานสงเคราะห์
    </h5>
    <button type="button" class="btn btn-primary rounded-pill shadow-sm ms-3"
            data-bs-toggle="modal" data-bs-target="#escapeModal">
      <i class="bi bi-plus-circle me-1"></i> เพิ่มข้อมูล
    </button>
  </div>

  {{-- ข้อมูล client --}}
  <div class="card mb-3 shadow-sm">
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

  {{-- ตาราง --}}
  @if($escapes->count() > 0)
    <div class="table-responsive">
      <table class="table table-striped table-hover align-middle">
        <thead class="table-primary text-center">
          <tr>
            <th scope="col">ลำดับ</th>
            <th scope="col">วันที่ออก</th>
            <th scope="col">ประเภทการออก</th>
            <th scope="col">พฤติการณ์/สาเหตุ</th>
            <th scope="col" class="text-end text-md-center">การจัดการ</th>
          </tr>
        </thead>
        <tbody>
          @foreach($escapes as $escape)
            <tr>
              <td class="text-center">{{ $loop->iteration }}</td>
              <td class="text-center">
                {{ $escape->retire_date ? $escape->retire_date->format('d/m/Y') : '-' }}
              </td>
              <td class="text-center">{{ $escape->retire->retire_name ?? '-' }}</td>
              <td>{{ $escape->stories ?? '-' }}</td>
              <td class="text-center text-md-center">
                <a href="{{ route('escape.edit', $escape->id) }}" class="btn btn-sm btn-warning me-1">
                  <i class="bi bi-pencil-square me-1"></i> ติดตาม
                </a>
                <button type="button" class="btn btn-sm btn-info me-1"
                        data-bs-toggle="modal"
                        data-bs-target="#editEscapeModal{{ $escape->id }}">
                  <i class="bi bi-pencil-square me-1"></i> แก้ไข
                </button>
                <form id="delete-form-{{ $escape->id }}"
                      action="{{ route('escape.delete', $escape->id) }}"
                      method="POST" class="d-inline">
                  @csrf
                  @method('DELETE')
                  <button type="button" class="btn btn-sm btn-danger"
                          onclick="confirmDelete('delete-form-{{ $escape->id }}','คุณต้องการลบข้อมูล Escape นี้ใช่หรือไม่')">
                    <i class="bi bi-trash me-1"></i> ลบ
                  </button>
                </form>
              </td>
            </tr>

            <!-- Modal Edit (ภายใน loop) -->
            <div class="modal fade" id="editEscapeModal{{ $escape->id }}" tabindex="-1" aria-labelledby="editEscapeLabel{{ $escape->id }}" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">

                  <div class="modal-header">
                    <h5 class="modal-title fw-bold text-primary" id="editEscapeLabel{{ $escape->id }}">
                      แก้ไขข้อมูลการออกของ {{ $client->fullname }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="ปิด"></button>
                  </div>

                  <div class="modal-body">
                    <form action="{{ route('escape.update', $escape->id) }}" method="POST">
                      @csrf
                      @method('PUT')

                      <input type="hidden" name="client_id" value="{{ $client->id }}">

                      <div class="row g-3">
                        <div class="col-md-3">
                          <label class="form-label">วันที่ออก</label>
                          <input type="date" name="retire_date" class="form-control" required
                                 value="{{ old('retire_date', $escape->retire_date?->format('Y-m-d')) }}">
                        </div>

                        <div class="col-md-4">
                          <label class="form-label">ประเภทการออกจากหน่วยงาน</label>
                          <select name="retire_id" class="form-select" required>
                            <option value="">-- เลือก --</option>
                            @foreach ($retires as $ret)
                              <option value="{{ $ret->id }}" {{ old('retire_id', $escape->retire_id) == $ret->id ? 'selected' : '' }}>
                                {{ $ret->retire_name }}
                              </option>
                            @endforeach
                          </select>
                        </div>

                        <div class="col-md-12">
                          <label class="form-label">เรื่องราว/สาเหตุ</label>
                          <textarea name="stories" class="form-control" rows="3">{{ old('stories', $escape->stories) }}</textarea>
                        </div>
                      </div>

                      <div class="mt-3 d-flex justify-content-between">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                          <i class="bi bi-x-circle me-1"></i> ปิด
                        </button>
                        <button type="submit" class="btn btn-success">
                          <i class="bi bi-pencil-square me-1"></i> อัปเดทข้อมูล
                        </button>
                      </div>
                    </form>
                  </div>

                </div>
              </div>
            </div>
          @endforeach
        </tbody>
      </table>
    </div>
  @endif
</div>

<!-- Modal Create -->
<div class="modal fade" id="escapeModal" tabindex="-1" aria-labelledby="escapeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Header -->
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title fw-bold" id="escapeModalLabel">
          <i class="bi bi-plus-circle me-2"></i> เพิ่มข้อมูลการออกจากสถานสงเคราะห์ของ {{ $client->fullname }}
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="ปิด"></button>
      </div>

      <!-- Body -->
      <div class="modal-body">
        <form action="{{ route('escape.store') }}" method="POST">
          @csrf
          <input type="hidden" name="client_id" value="{{ $client->id }}">

          <div class="row g-3">
            <!-- วันที่ออก -->
            <div class="col-md-3">
              <label class="form-label fw-bold">วันที่ออก</label>
              <input type="date" name="retire_date" class="form-control" required value="{{ old('retire_date') }}">
            </div>

            <!-- ประเภทการออก -->
            <div class="col-md-4">
              <label class="form-label fw-bold">ประเภทการออกจากหน่วยงาน</label>
              <select name="retire_id" class="form-select" required>
                <option value="">-- เลือก --</option>
                @foreach ($retires as $ret)
                  <option value="{{ $ret->id }}" {{ old('retire_id') == $ret->id ? 'selected' : '' }}>
                    {{ $ret->retire_name }}
                  </option>
                @endforeach
              </select>
            </div>

            <!-- เรื่องราว/สาเหตุ -->
            <div class="col-md-12">
              <label class="form-label fw-bold">เรื่องราว/สาเหตุ</label>
              <textarea name="stories" class="form-control" rows="3" placeholder="บันทึกสาเหตุหรือรายละเอียดเพิ่มเติม">{{ old('stories') }}</textarea>
            </div>
          </div>

          <!-- Footer -->
          <div class="mt-4 d-flex justify-content-between">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
              <i class="bi bi-x-circle me-1"></i> ปิด
            </button>
            <button type="submit" class="btn btn-success">
              <i class="bi bi-save me-1"></i> บันทึกข้อมูล
            </button>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>

@endsection