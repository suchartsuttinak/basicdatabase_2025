@extends('admin_client.admin_client')
@section('content')

<div class="card-body pt-3">
  {{-- หัวข้อ --}}
  <div class="mb-3">
    <h5 class="fw-bold text-primary text-center">ข้อมูลการออกจากสถานสงเคราะห์</h5>
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

  {{-- ตาราง responsive (แสดงเฉพาะเมื่อมีข้อมูล) --}}
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
                <a href="{{ route('escape.copy', $escape->id) }}" class="btn btn-sm btn-info me-1">
                    <i class="bi bi-files me-1"></i> แก้ไข
                </a>

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
          @endforeach
        </tbody>
      </table>
    </div>
  @endif
</div>
@endsection