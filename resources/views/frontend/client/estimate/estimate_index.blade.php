@extends('admin_client.admin_client')
@section('content')


@if ($errors->any() && session('form') === 'add-estimate')
<script>
document.addEventListener("DOMContentLoaded", function() {
    // เปิด modal Add Estimate
    bootstrap.Modal.getOrCreateInstance(document.getElementById('add-estimate-modal')).show();

    // SweetAlert แจ้งเตือน error
    Swal.fire({
        icon: 'error',
        title: 'เกิดข้อผิดพลาด',
        html: `{!! implode('<br>', $errors->all()) !!}`,
        confirmButtonText: 'ตกลง'
    });
});
</script>
@endif

@if ($errors->any() && session('form') === 'edit-estimate')
<script>
document.addEventListener("DOMContentLoaded", function() {
    // เปิด modal Edit Estimate
    bootstrap.Modal.getOrCreateInstance(document.getElementById('edit-estimate-modal')).show();

    // SweetAlert แจ้งเตือน error
    Swal.fire({
        icon: 'error',
        title: 'เกิดข้อผิดพลาด',
        html: `{!! implode('<br>', $errors->all()) !!}`,
        confirmButtonText: 'ตกลง'
    });
});
</script>
@endif

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
        <!-- ✅ ครอบด้วย table-responsive -->
        <div class="table-responsive">
            <table id="datatable-estimate" class="table table-bordered table-striped align-middle w-100">
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
                                <div class="d-flex flex-wrap align-items-start gap-2">
                                    @foreach($item->pictures as $pic)
                                        <div style="width:80px;">
                                            <img src="{{ asset('storage/'.$pic->path) }}"
                                                 class="img-thumbnail"
                                                 style="width:100%; height:auto;">
                                        </div>
                                    @endforeach
                                </div>
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
        </div>
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
                <!-- ส่วนฟอร์ม follo_no -->
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
                            <span id="follo_no-error" class="text-danger">{{ $message }}</span>
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
    {{-- ✅ เปิด modal Add เมื่อ error มาจาก Add --}}
@if ($errors->any() && session('form') === 'add')
<script> ... เปิด add-estimate-modal ... </script>
@endif

{{-- ✅ เปิด modal Edit เมื่อ error มาจาก Edit --}}
@if ($errors->any() && session('form') === 'edit')
<script> ... เปิด edit-estimate-modal ... </script>
@endif
    
<!-- ✅ Modal Edit Estimate -->
<div class="modal fade" id="edit-estimate-modal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <!-- ใช้ placeholder 0 แต่ JS จะเปลี่ยนเป็น id จริง -->
      <form method="POST" id="edit-estimate-form" action="{{ route('estimate.update', 0) }}" enctype="multipart/form-data" data-id="">
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
           class="form-control"
           value="{{ old('date') }}">
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
            {{-- @error('follo_no')
              <div class="text-danger" id="follo_no-error">{{ $message }}</div>
            @enderror --}}
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
          <!-- ปุ่มอัปเดตจะถูก disable/enable โดย JS -->
          <button type="submit" class="btn btn-primary" id="btn-update-estimate">อัปเดต</button>
          <button type="button" class="btn btn-secondary btn-cancel" data-bs-dismiss="modal">ยกเลิก</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- ✅ เปิด modal Add เมื่อ error มาจาก Add --}}
@if ($errors->any() && session('form') === 'add')
<script>
document.addEventListener("DOMContentLoaded", function() {
    var myModal = new bootstrap.Modal(document.getElementById('add-estimate-modal'));
    myModal.show();
});
</script>
@endif

{{-- ✅ ตรวจสอบวันที่ซ้ำ ปิด/เปิดปุ่มอัปเดต --}}
<script>
async function checkDuplicateDate(clientId, date, estimateId) {
    const response = await fetch(`/estimate/check-duplicate?client_id=${clientId}&date=${date}&id=${estimateId}`);
    const result = await response.json();
    return result.duplicate;
}

document.addEventListener("DOMContentLoaded", function(){
    const dateInput = document.getElementById('edit_date');
    const updateBtn = document.getElementById('btn-update-estimate');

    dateInput.addEventListener('change', async function() {
        const date = this.value;
        const clientId = document.querySelector('#edit-estimate-form input[name="client_id"]')?.value;
        const estimateId = document.querySelector('#edit-estimate-form').getAttribute('data-id');

        if (!date || !clientId || !estimateId) return;

        const duplicate = await checkDuplicateDate(clientId, date, estimateId);

        if (duplicate) {
            let errorEl = this.closest('.mb-3').querySelector('.invalid-feedback');
            if (!errorEl) {
                errorEl = document.createElement('div');
                errorEl.className = 'invalid-feedback';
                this.closest('.mb-3').appendChild(errorEl);
            }
            errorEl.textContent = 'วันที่นี้ถูกบันทึกไว้แล้ว กรุณาเลือกวันอื่น';
            errorEl.style.display = 'block';
            this.classList.add('is-invalid');
            updateBtn.disabled = true;
        } else {
            const errorEl = this.closest('.mb-3').querySelector('.invalid-feedback');
            if (errorEl) errorEl.style.display = 'none';
            this.classList.remove('is-invalid');
            updateBtn.disabled = false;
        }
    });
});
</script>

{{-- ✅ เปิด modal Edit เมื่อ error มาจาก Edit --}}
@if ($errors->any() && session('form') === 'edit')
<script>
document.addEventListener("DOMContentLoaded", function() {
    var myModal = new bootstrap.Modal(document.getElementById('edit-estimate-modal'));
    myModal.show();
});
</script>
@endif


@push('scripts')
<script>
/** ฟังก์ชัน preview ไฟล์ใหม่ (ใช้ได้ทั้ง Add และ Edit) */
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

// ✅ preview สำหรับ Add และ Edit
previewFiles('pictures-input-add', 'preview-area-add');
previewFiles('pictures-input-edit', 'preview-area-edit');

/** โหลดข้อมูลสำหรับ Edit */
function estimateEdit(id){
    $.ajax({
        url: "/estimate/edit/" + id,
        type: "GET",
        dataType: "json",
        success: function(data){
            $('#edit-estimate-form').attr('action', '/estimate/update/' + data.id);
            $('#edit-estimate-form').attr('data-id', data.id);

            $('#edit_date').val(data.date);
            $('#edit_results').val(data.results ?? '');
            $('#edit_teacher').val(data.teacher ?? '');
            $('#edit_remark').val(data.remark ?? '');

            $('input[name="follo_no"]').each(function(){
                $(this).prop('checked', $(this).val() === data.follo_no);
            });

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

            const modalEl = document.getElementById('edit-estimate-modal');
            bootstrap.Modal.getOrCreateInstance(modalEl).show();
        }
    });
}

/** ลบรูปเดิม */
function removeOldPicture(picId, btn){
    $(btn).closest('div').remove();
    $('#edit-estimate-form').append(
        `<input type="hidden" name="remove_pictures[]" value="${picId}">`
    );
}

/** ฟังก์ชัน reset ฟอร์ม + เคลียร์ error + เคลียร์ preview + เคลียร์ไฟล์ */
function resetForm(formId, previewId, setToday = false) {
    const form = document.getElementById(formId);
    if (!form) return;

    form.reset();

    form.querySelectorAll(".is-invalid").forEach(el => {
        el.classList.remove("is-invalid");
    });

    form.querySelectorAll(".invalid-feedback, .text-danger").forEach(el => {
        el.style.display = "none";
        el.textContent = "";
    });

    const previewArea = document.getElementById(previewId);
    if (previewArea) previewArea.innerHTML = "";

    // เคลียร์ไฟล์ input
    const fileInputs = form.querySelectorAll('input[type="file"]');
    fileInputs.forEach(fi => fi.value = "");

    if (setToday) {
        const dateInput = form.querySelector('input[name="date"]');
        if (dateInput) {
            dateInput.value = new Date().toISOString().split('T')[0];
        }
    }
}

/** เคลียร์ฟอร์มเมื่อกดปุ่มยกเลิก */
document.querySelector('#add-estimate-modal .btn-secondary[data-bs-dismiss="modal"]')
    ?.addEventListener('click', () => resetForm('add-estimate-form','preview-area-add'));

document.querySelector('#edit-estimate-modal .btn-secondary[data-bs-dismiss="modal"]')
    ?.addEventListener('click', () => resetForm('edit-estimate-form','preview-area-edit'));

/** reset ฟอร์มทุกครั้งที่กดปุ่ม "เพิ่มข้อมูล" */
document.getElementById('btn-add-estimate')
    ?.addEventListener('click', () => resetForm('add-estimate-form','preview-area-add',true));

/** ✅ ซ่อนข้อความ error เมื่อเลือก radio follo_no และเมื่อเปลี่ยนวันที่ */
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll('input[name="follo_no"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const errorEl = document.getElementById('follo_no-error');
            if (errorEl) errorEl.style.display = "none";
        });
    });

    document.querySelectorAll('input[name="date"]').forEach(dateInput => {
        dateInput.addEventListener('change', function() {
            const errorEl = dateInput.closest('.mb-3').querySelector('.invalid-feedback');
            if (errorEl) errorEl.style.display = "none";
            dateInput.classList.remove('is-invalid');
        });
    });
});

/** ตรวจสอบวันที่ซ้ำก่อนอัปเดต */
async function checkDuplicateDate(clientId, date, estimateId) {
    const response = await fetch(`/estimate/check-duplicate?client_id=${clientId}&date=${date}&id=${estimateId}`);
    const result = await response.json();
    return result.duplicate;
}

document.addEventListener("DOMContentLoaded", function(){
    const dateInput = document.getElementById('edit_date');
    const updateBtn = document.querySelector('#edit-estimate-form button[type="submit"]');

    dateInput.addEventListener('change', async function() {
        const date = this.value;
        const clientId = document.querySelector('#edit-estimate-form input[name="client_id"]').value;
        const estimateId = document.querySelector('#edit-estimate-form').getAttribute('data-id');

        const duplicate = await checkDuplicateDate(clientId, date, estimateId);

        if (duplicate) {
            let errorEl = this.closest('.mb-3').querySelector('.invalid-feedback');
            if (!errorEl) {
                errorEl = document.createElement('div');
                errorEl.className = 'invalid-feedback';
                this.closest('.mb-3').appendChild(errorEl);
            }
            errorEl.textContent = 'วันที่นี้ถูกบันทึกไว้แล้ว กรุณาเลือกวันอื่น';
            errorEl.style.display = 'block';
            this.classList.add('is-invalid');
            updateBtn.disabled = true;
        } else {
            const errorEl = this.closest('.mb-3').querySelector('.invalid-feedback');
            if (errorEl) errorEl.style.display = 'none';
            this.classList.remove('is-invalid');
            updateBtn.disabled = false;
        }
    });
});
</script>
@endpush
@endsection