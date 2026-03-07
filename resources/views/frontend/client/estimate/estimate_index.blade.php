@extends('admin_client.admin_client')
@section('content')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<!-- ✅ แสดงข้อผิดพลาดจากการ validate -->
@if ($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'เกิดข้อผิดพลาด',
            html: '{!! implode("<br>", $errors->all()) !!}',
            timer: 2000,              // ✅ ปิดเองใน 3 วินาที
            timerProgressBar: true    // ✅ แสดง progress bar ด้านบน
        });
        // ✅ เปิด modal กลับมาอัตโนมัติ
        var addModal = new bootstrap.Modal(document.getElementById('add-estimate-modal'));
        addModal.show();
    </script>
@endif

@if (session('message'))
    <script>
        Swal.fire({
            icon: '{{ session('alert-type') }}',
            title: '{{ session('message') }}',
            timer: 3000,              // ✅ ปิดเองใน 3 วินาที
            timerProgressBar: true
        });
    </script>
@endif
<!-- สิ้นสุด✅ แสดงข้อผิดพลาดจากการ validate -->



<div class="card shadow-sm border-0 mt-3">
    <div class="card-header bg-light fw-bold text-dark py-2 px-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="bi bi-people-fill me-2 text-primary"></i> 
            ประวัติการติดตามและประเมินครอบครัวเด็ก
        </h5>
        <!-- ✅ ปุ่มเปิด Modal -->
<button type="button"
        class="btn btn-sm btn-primary d-flex align-items-center shadow-sm px-3"
        data-bs-toggle="modal"
        data-bs-target="#add-estimate-modal"
        id="btn-add-estimate">
    <i class="bi bi-plus-circle me-1"></i>
    <span>เพิ่มข้อมูล</span>
</button>
    </div>

    <!-- ✅ แสดงชื่อและอายุ -->
    <div class="card-body border-bottom pb-2 mb-2">
        <p class="mb-0">
            <strong>ชื่อ:</strong> {{ $client->full_name }}
            <span class="mx-3">|</span>
            <strong>อายุ:</strong> {{ \Carbon\Carbon::parse($client->birth_date)->age }} ปี
        </p>
    </div>
</div>

<!-- ตาราง Estimate -->
<div class="card-body">
    @if($client->estimates->isEmpty())
        <!-- ✅ กรณีไม่มีข้อมูล -->
        <div class="alert alert-info text-center">
            ยังไม่มีข้อมูลการติดตามและประเมิน
        </div>
    @else
        <table id="datatable-estimate" class="table table-bordered table-striped align-middle">
            <thead class="table-primary">
                <tr>
                    <th scope="col">ครั้งที่</th>
                    <th scope="col">วันที่ติดตาม</th>
                    <th scope="col">การดำเนินงาน</th>
                    <th scope="col">ผลการติดตาม</th>
                    <th scope="col">ผู้ประเมิน</th>
                    <th scope="col">หมายเหตุ</th>
                    <th scope="col">รูปภาพ</th>
                    <th scope="col" class="text-center">การจัดการ</th>
                </tr>
            </thead>
            <tbody>
        @foreach ($client->estimates->sortByDesc('date') as $item)
        <tr>
            <td>{{ $item->count }}</td>
            <td>{{ \Carbon\Carbon::parse($item->date)->format('d/m/Y') }}</td>
            <td>{{ $item->follo_no }}</td>
            <td>{{ $item->results }}</td>
            <td>{{ $item->teacher }}</td>
            <td>{{ $item->remark }}</td>
            <td>
                @foreach($item->pictures as $pic)
                    <img src="{{ asset('storage/'.$pic->path) }}" 
                         class="img-thumbnail me-1 mb-1" 
                         style="width:80px; height:auto;">
                @endforeach
            </td>
            <td class="text-center">
                <!-- ปุ่มแก้ไข -->
                <button type="button"  
                        class="btn btn-success btn-sm"
                        data-bs-toggle="modal"
                        data-bs-target="#edit-estimate-modal"
                        onclick="estimateEdit({{ $item->id }})">
                    <i class="bi bi-pencil-square"></i> แก้ไข
                </button>

                <!-- ฟอร์มลบ -->
                <form id="delete-form-item-{{ $item->id }}"
                      action="{{ route('estimate.delete', $item->id) }}"
                      method="POST" style="display:none;">
                    @csrf
                    @method('DELETE')
                </form>

                <button type="button"  
                        class="btn btn-sm btn-danger d-inline-flex align-items-center ms-1"
                        onclick="confirmDelete('delete-form-item-{{ $item->id }}', 'คุณต้องการลบข้อมูลนี้ใช่หรือไม่')">
                    <i class="bi bi-trash-fill me-1"></i> ลบ
                </button>
            </td>
        </tr>
    @endforeach
</tbody>
        </table>
    @endif
</div>

<!-- ✅ Modal Add Estimate -->
<div class="modal fade" id="add-estimate-modal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="{{ route('estimate.store') }}" method="POST" enctype="multipart/form-data" id="add-estimate-form">
        @csrf
        <input type="hidden" name="client_id" value="{{ $client->id }}">

        <div class="modal-header">
          <h5 class="modal-title">เพิ่มข้อมูลการติดตาม</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3 col-4">
            <label class="form-label">วันที่ติดตาม</label>
            <input type="date" name="date"
                class="form-control @error('date') is-invalid @enderror"
                value="{{ old('date', \Carbon\Carbon::now()->format('Y-m-d')) }}">
            @error('date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
    <label class="form-label">การดำเนินงาน</label><br>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="follo_no" value="หน่วยงานไปเอง" {{ old('follo_no') == 'หน่วยงานไปเอง' ? 'checked' : '' }}>
        <label class="form-check-label">หน่วยงานไปเอง</label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="follo_no" value="โทรศัพท์" {{ old('follo_no') == 'โทรศัพท์' ? 'checked' : '' }}>
        <label class="form-check-label">โทรศัพท์</label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="follo_no" value="จดหมาย" {{ old('follo_no') == 'จดหมาย' ? 'checked' : '' }}>
        <label class="form-check-label">จดหมาย</label>
    </div>

    <!-- แสดงข้อความ error -->
    @error('follo_no')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>

            <div class="mb-3">
                <label class="form-label">ผลการติดตาม</label>
                <textarea name="results" class="form-control"></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">ผู้ติดตาม</label>
                <input type="text" name="teacher" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">หมายเหตุ</label>
                <textarea name="remark" class="form-control"></textarea>
            </div>
                <div class="mb-3">
                    <label class="form-label">เลือกรูปภาพ</label>
                    <input type="file" name="pictures[]" multiple class="form-control" id="pictures-input-add">
                </div>

                <!-- พื้นที่แสดง preview -->
                <div id="preview-area-add" class="d-flex flex-wrap gap-2 mt-2"></div>
                    </div>

         <div class="modal-footer">
            <button type="submit" class="btn btn-primary">บันทึก</button>
            <!-- ✅ ปุ่มยกเลิกปิด modal ได้ทันที -->
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
        </div>
      </form>
    </div>
  </div>
</div>
    {{-- ✅ เปิด modal อัตโนมัติเมื่อมี error --}}
    @if ($errors->any())
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        var myModal = new bootstrap.Modal(document.getElementById('add-estimate-modal'));
        myModal.show();
    });
    </script>
    @endif
    
<!-- ✅ Modal Edit Estimate -->
<div class="modal fade" id="edit-estimate-modal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="POST" id="edit-estimate-form" action="{{ route('estimate.update', 0) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title">แก้ไขข้อมูลการติดตาม</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3 col-4">
            <label class="form-label">วันที่ติดตาม</label>
            <input type="date" name="date" id="edit_date"
                   class="form-control @error('date') is-invalid @enderror"
                   value="{{ old('date') }}">
            @error('date')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label class="form-label">การดำเนินงาน</label><br>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="follo_no" value="หน่วยงานไปเอง"
                     {{ old('follo_no') == 'หน่วยงานไปเอง' ? 'checked' : '' }}>
              <label class="form-check-label">หน่วยงานไปเอง</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="follo_no" value="โทรศัพท์"
                     {{ old('follo_no') == 'โทรศัพท์' ? 'checked' : '' }}>
              <label class="form-check-label">โทรศัพท์</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="follo_no" value="จดหมาย"
                     {{ old('follo_no') == 'จดหมาย' ? 'checked' : '' }}>
              <label class="form-check-label">จดหมาย</label>
            </div>
            @error('follo_no')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>

          <div class="mb-3">
            <label class="form-label">ผลการติดตาม</label>
            <textarea name="results" id="edit_results"
                      class="form-control @error('results') is-invalid @enderror">{{ old('results') }}</textarea>
            @error('results')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label class="form-label">ผู้ติดตาม</label>
            <input type="text" name="teacher" id="edit_teacher"
                   class="form-control @error('teacher') is-invalid @enderror"
                   value="{{ old('teacher') }}">
            @error('teacher')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label class="form-label">หมายเหตุ</label>
            <textarea name="remark" id="edit_remark"
                      class="form-control @error('remark') is-invalid @enderror">{{ old('remark') }}</textarea>
            @error('remark')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label class="form-label">เลือกรูปภาพใหม่</label>
            <input type="file" name="pictures[]" multiple
                   class="form-control @error('pictures') is-invalid @enderror"
                   id="pictures-input-edit">
            @error('pictures')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div id="preview-area-edit" class="d-flex flex-wrap gap-2 mt-2"></div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">อัปเดต</button>
          <button type="button" class="btn btn-secondary btn-cancel" data-bs-dismiss="modal">ยกเลิก</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection


@push('scripts')
<script>
/**
 * ฟังก์ชัน preview ไฟล์ใหม่ (ใช้ได้ทั้ง Add และ Edit)
 */
function previewFiles(inputId, previewId) {
    const input = document.getElementById(inputId);
    const previewArea = document.getElementById(previewId);
    if(!input) return;

    input.addEventListener('change', function(event) {
        previewArea.innerHTML = "";
        const files = event.target.files;
        const dt = new DataTransfer();

        Array.from(files).forEach((file, index) => {
            if(file.type.startsWith("image/")){
                const reader = new FileReader();
                reader.onload = function(e){
                    const wrapper = document.createElement("div");
                    wrapper.className = "position-relative border rounded shadow-sm d-inline-block me-2 mb-2";
                    wrapper.style.width = "120px";

                    const img = document.createElement("img");
                    img.src = e.target.result;
                    img.className = "img-fluid rounded";

                    const btn = document.createElement("button");
                    btn.type = "button";
                    btn.textContent = "ลบ";
                    btn.className = "btn btn-sm btn-danger position-absolute";
                    btn.style.top = "4px";
                    btn.style.right = "4px";

                    btn.addEventListener("click", function(){
                        wrapper.remove();
                        const newFiles = Array.from(files).filter((_, i) => i !== index);
                        const newDt = new DataTransfer();
                        newFiles.forEach(f => newDt.items.add(f));
                        input.files = newDt.files;
                    });

                    wrapper.appendChild(img);
                    wrapper.appendChild(btn);
                    previewArea.appendChild(wrapper);
                }
                reader.readAsDataURL(file);
                dt.items.add(file);
            }
        });

        input.files = dt.files;
    });
}

// ✅ ใช้งาน preview สำหรับ Add และ Edit
previewFiles('pictures-input-add', 'preview-area-add');
previewFiles('pictures-input-edit', 'preview-area-edit');

/**
 * โหลดข้อมูลสำหรับ Edit และเติมค่าในฟอร์ม
 */
function estimateEdit(id){
    $.ajax({
        url: "/estimate/edit/" + id,
        type: "GET",
        dataType: "json",
        success: function(data){
            // เติมค่าฟอร์ม
            $('#edit_date').val(data.date);
            $('#edit_results').val(data.results ?? '');
            $('#edit_teacher').val(data.teacher ?? '');
            $('#edit_remark').val(data.remark ?? '');
            $('#edit-estimate-form').attr('action', '/estimate/update/' + data.id);

            // เซ็ตค่า radio follo_no
            $('input[name="follo_no"]').each(function(){
                $(this).prop('checked', $(this).val() === data.follo_no);
            });

            // แสดงรูปเดิมพร้อมปุ่มลบ
            const preview = $('#preview-area-edit');
            preview.html('');
            if(Array.isArray(data.pictures)){
                data.pictures.forEach(function(pic){
                    preview.append(`
                        <div class="position-relative d-inline-block me-1 mb-1" style="width:80px;">
                            <img src="${pic.url}" class="img-thumbnail" style="width:80px; height:auto;">
                            <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0"
                                    onclick="removeOldPicture(${pic.id}, this)">ลบ</button>
                        </div>
                    `);
                });
            }

            // ✅ ใช้ instance เดียว ไม่สร้างใหม่ทุกครั้ง
            const modalEl = document.getElementById('edit-estimate-modal');
            const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            modal.show();
        }
    });
}

/**
 * ฟังก์ชันลบรูปเดิม
 */
function removeOldPicture(picId, btn){
    $(btn).closest('div').remove();
    $('#edit-estimate-form').append(
        `<input type="hidden" name="remove_pictures[]" value="${picId}">`
    );
}

/**
 * ✅ เคลียร์ฟอร์มเมื่อกดปุ่มยกเลิก (ทั้ง Add และ Edit)
 */
document.querySelector('#add-estimate-modal .btn-secondary[data-bs-dismiss="modal"]')
    ?.addEventListener('click', function(){
        document.getElementById('add-estimate-form').reset();
        document.getElementById('preview-area-add').innerHTML = "";
    });

document.querySelector('#edit-estimate-modal .btn-secondary[data-bs-dismiss="modal"]')
    ?.addEventListener('click', function(){
        document.getElementById('edit-estimate-form').reset();
        document.getElementById('preview-area-edit').innerHTML = "";
    });

/**
 * ✅ reset ฟอร์มทุกครั้งที่กดปุ่ม "เพิ่มข้อมูล"
 */
document.getElementById('btn-add-estimate')?.addEventListener('click', function(){
    document.getElementById('add-estimate-form').reset();
    document.getElementById('preview-area-add').innerHTML = "";
    const today = new Date().toISOString().split('T')[0];
    document.querySelector('#add-estimate-form input[name="date"]').value = today;
});
</script>
@endpush