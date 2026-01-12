@extends('admin.admin_master')
@section('admin')

<div class="container-fluid mt-2">
    <div class="card shadow-sm border-0 w-100 mb-0">
        <div class="card-header bg-light fw-bold text-dark py-2 px-3 d-flex justify-content-between align-items-center">
            <div>
                <i class="bi bi-box-arrow-right me-2"></i> ตารางการจำหน่ายผู้รับออกจากสถานสงเคราะห์
            </div>
            <button type="button" class="btn btn-sm btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#createReferModal">
                <i class="bi bi-plus-circle me-1"></i> เพิ่มข้อมูลจำหน่าย
            </button>
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

<!-- Modal เพิ่มข้อมูลการจำหน่าย -->
<div class="modal fade" id="createReferModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content shadow">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i> เพิ่มข้อมูลการจำหน่าย</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('refers.store') }}" method="POST">
          @csrf

          {{-- ต้องเลือก client --}}
          <div class="mb-3">
            <label class="form-label fw-bold">เลือกผู้รับ</label>
            <select name="client_id" class="form-select form-select-sm" required>
              <option value="">-- เลือกผู้รับ --</option>
              @foreach(App\Models\Client::where('release_status', '!=', 'refer')->get() as $c)
                <option value="{{ $c->id }}">{{ $c->fullname }}</option>
              @endforeach
            </select>
          </div>

          <div class="row mb-3">
            <div class="col-md-4">
              <label class="form-label fw-bold">วันที่นำส่ง</label>
              <input type="date" name="refer_date" class="form-control form-control-sm" required>
            </div>
            <div class="col-md-8">
              <label class="form-label fw-bold">สาเหตุการจำหน่าย</label>
              <select name="translate_id" class="form-select form-select-sm" required>
                <option value="">-- เลือก --</option>
                @foreach($translates as $t)
                    <option value="{{ $t->id }}">{{ $t->translate_name }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold">ชื่อสถานที่นำส่ง</label>
            <input type="text" name="destination" class="form-control form-control-sm">
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold">ที่อยู่</label>
            <textarea name="address" class="form-control form-control-sm" rows="2"></textarea>
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold">ผู้ดูแล</label><br>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="guardian" value="มี" onclick="toggleGuardian(true)">
              <label class="form-check-label">มี</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="guardian" value="ไม่มี" onclick="toggleGuardian(false)">
              <label class="form-check-label">ไม่มี</label>
            </div>
          </div>

          <div id="guardianFields" style="display:none;">
            <div class="row mb-3">
              <div class="col-md-4">
                <label class="form-label fw-bold">ชื่อผู้รับตัว</label>
                <input type="text" name="parent_name" class="form-control form-control-sm">
              </div>
              <div class="col-md-4">
                <label class="form-label fw-bold">โทรศัพท์</label>
                <input type="text" name="parent_tel" class="form-control form-control-sm">
              </div>
              <div class="col-md-4">
                <label class="form-label fw-bold">ความสัมพันธ์</label>
                <input type="text" name="member" class="form-control form-control-sm">
              </div>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold">ชื่อผู้นำส่ง</label>
            <input type="text" name="teacher" class="form-control form-control-sm">
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold">หมายเหตุ</label>
            <textarea name="remark" class="form-control form-control-sm" rows="2"></textarea>
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

<script>
$(document).ready(function() {
    var table = $('#datatable-refer').DataTable({
        responsive: true,
        autoWidth: false,
        pageLength: 10,
        ordering: true,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/th.json'
        }
    });

    // ตั้งค่า CSRF สำหรับทุก Ajax
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    // ✅ ให้ปุ่ม Restore ทำงานแม้ DataTables re-render
    $('#datatable-refer').on('submit', 'form', function(e) {
        e.preventDefault();
        var form = this;
        $.ajax({
            url: form.action,
            type: 'POST', // Laravel จะอ่าน _method=PUT จาก form
            data: $(form).serialize(),
            success: function(res) {
                alert(res.message || 'Restore สำเร็จ');
                location.reload(); // รีโหลดทั้งหน้าเพื่อให้ข้อมูลใหม่แสดง
            },
            error: function(xhr) {
                alert('Restore ไม่สำเร็จ: ' + (xhr.responseJSON?.message || 'เกิดข้อผิดพลาด'));
            }
        });
    });
});
</script>

<script>
function toggleGuardian(show) {
    const guardianFields = document.getElementById('guardianFields');
    if (show) {
        guardianFields.style.display = 'block';
    } else {
        guardianFields.style.display = 'none';
        // เคลียร์ค่าฟิลด์เมื่อเลือก "ไม่มี"
        guardianFields.querySelectorAll('input').forEach(el => el.value = '');
    }
}
</script>
@endsection