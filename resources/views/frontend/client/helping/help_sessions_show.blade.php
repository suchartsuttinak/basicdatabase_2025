@extends('admin_client.admin_client')
@section('content')
<div class="container">
     <h4 class="fw-bold text-primary mb-3 border-bottom pb-2 text-center pt-4">
            รายการให้ความช่วยเหลือผู้รับ
        </h4>
    {{-- แสดงยอดรวมทั้งหมด --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <span class="fw-bold text-primary fs-6">
                <i class="bi bi-person-fill me-2 text-primary"></i>
                ชื่อ-สกุล :  <span class="ms-2">{{ $client->fullname ?? '-' }} </span>
                <i class="bi bi-calendar-heart me-2 text-success"></i>
                <span class="fw-bold">อายุ :</span> {{ $client->age ?? '-' }} ปี
            </span>

         {{-- ยอดรวมทั้งหมด ชิดขวา (แสดงเฉพาะเมื่อมีข้อมูล) --}}
             @if($sessions->isNotEmpty() && $grandTotal > 0)
        <div class="alert alert-info fw-bold shadow-sm rounded px-4 py-2 mb-0 small">
            <i class="bi bi-cash-stack me-2"></i>
            ยอดรวมทั้งสิ้น:
            <span class="text-primary">{{ number_format($grandTotal, 2) }} บาท</span>
        </div>
            @endif
      </div>

  <div class="mb-3">
    <a href="{{ route('help_sessions.create', $client->id) }}" class="btn btn-primary btn-sm">
        + เพิ่มการช่วยเหลือใหม่
    </a>
  </div>

  @if($sessions->isNotEmpty())
  <table class="table table-bordered">
      <thead class="table-light">
          <tr>
              <th style="width: 15%">วันที่</th>
              <th style="width: 20%">ยอดรวม</th>
              <th style="width: 45%">รายละเอียด</th>
              <th style="width: 20%" class="text-end">จัดการ</th>
          </tr>
      </thead>
      <tbody>
          @foreach($sessions as $session)
              <tr>
                  <td>{{ $session->help_date }}</td>
                  <td>
                      <span class="badge bg-success">
                          {{ number_format($session->total_amount, 2) }} บาท
                      </span>
                  </td>
                  <td>
                      <button class="btn btn-sm btn-info"
                              type="button"
                              data-bs-toggle="collapse"
                              data-bs-target="#session-{{ $session->id }}"
                              aria-expanded="false"
                              aria-controls="session-{{ $session->id }}">
                          แสดงรายการ
                      </button>
                  </td>
                  <td class="text-end">
                      <a href="{{ route('help_sessions.edit', ['client' => $client->id, 'session' => $session->id]) }}"
                         class="btn btn-warning btn-sm me-1">
                          <i class="bi bi-pencil-square me-1"></i> แก้ไข
                      </a>
                      <form id="delete-form-{{ $session->id }}" 
                            action="{{ route('help_sessions.destroy', ['client' => $client->id, 'session' => $session->id]) }}" 
                            method="POST" class="d-inline">
                          @csrf
                          @method('DELETE')
                          <button type="button" 
                                  class="btn btn-danger btn-sm"
                                  onclick="confirmDelete('delete-form-{{ $session->id }}', 'คุณแน่ใจหรือไม่ที่จะลบการช่วยเหลือครั้งนี้?')">
                              <i class="bi bi-trash me-1"></i> ลบ
                          </button>
                      </form>
                  </td>
              </tr>
              <tr id="session-{{ $session->id }}" class="collapse">
                  <td colspan="4">
                      <table class="table table-sm table-bordered mb-0">
                          <thead class="table-light">
                              <tr>
                                  <th>รายการ</th>
                                  <th>จำนวน</th>
                                  <th>ราคา/หน่วย</th>
                                  <th>ราคารวม</th>
                              </tr>
                          </thead>
                          <tbody>
                              @foreach($session->items as $item)
                                  <tr>
                                      <td>{{ $item->item_name }}</td>
                                      <td>{{ $item->quantity }}</td>
                                      <td>{{ number_format($item->unit_price, 2) }}</td>
                                      <td>{{ number_format($item->total_price, 2) }}</td>
                                  </tr>
                              @endforeach
                          </tbody>
                      </table>
                  </td>
              </tr>
          @endforeach
      </tbody>
  </table>
        @else
        <div class="alert alert-warning text-center fw-bold">
            ยังไม่มีข้อมูลการช่วยเหลือ
        </div>
        @endif
</div>

<!-- ฟังก์ชัน JavaScript สำหรับการแสดง/ซ่อนรายการ -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const collapseElements = document.querySelectorAll('.collapse');
    collapseElements.forEach(function (collapseEl) {
        collapseEl.addEventListener('show.bs.collapse', function () {
            const button = document.querySelector(
                `[data-bs-target="#${collapseEl.id}"]`
            );
            if (button) button.textContent = 'ซ่อนรายการ';
        });
        collapseEl.addEventListener('hide.bs.collapse', function () {
            const button = document.querySelector(
                `[data-bs-target="#${collapseEl.id}"]`
            );
            if (button) button.textContent = 'แสดงรายการ';
        });
    });
});
</script>
@endsection