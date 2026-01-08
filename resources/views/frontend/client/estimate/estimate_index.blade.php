@extends('admin_client.admin_client')
@section('content')

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
                data-bs-target="#add-estimate-modal">
            <i class="bi bi-plus-circle me-1"></i>
            <span>เพิ่มข้อมูล</span>
        </button>
    </div>

    <!-- ✅ แสดงชื่อและอายุ -->
    <div class="card-body border-bottom pb-2 mb-2">
        <p class="mb-1">
            <strong>ชื่อ:</strong> {{ $client->full_name }}
        </p>
        <p class="mb-0">
            <strong>อายุ:</strong> 
            {{ \Carbon\Carbon::parse($client->birth_date)->age }} ปี
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
                <input type="date" name="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date') }}">
                @error('date') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">การดำเนินงาน</label><br>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="follo_no" value="หน่วยงานไปเอง" required>
                    <label class="form-check-label">หน่วยงานไปเอง</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="follo_no" value="โทรศัพท์">
                    <label class="form-check-label">โทรศัพท์</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="follo_no" value="จดหมาย">
                    <label class="form-check-label">จดหมาย</label>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">ผลการติดตาม</label>
                <textarea name="results" class="form-control"></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">ผู้ประเมิน</label>
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
        </div>
      </form>
    </div>
  </div>
</div>

<!-- ✅ Modal Edit Estimate -->
<div class="modal fade" id="edit-estimate-modal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="POST" id="edit-estimate-form" action="{{ route('estimate.update', 0) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="modal-header">
          <h5 class="modal-title">แก้ไขข้อมูลการติดตาม</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
    <div class="mb-3 col-4">
        <label class="form-label">วันที่ติดตาม</label>
        <input type="date" name="date" id="edit_date" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">การดำเนินงาน</label>
        <input type="text" name="follo_no" id="edit_follo_no" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">ผลการติดตาม</label>
        <textarea name="results" id="edit_results" class="form-control"></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">ผู้ประเมิน</label>
        <input type="text" name="teacher" id="edit_teacher" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">หมายเหตุ</label>
        <textarea name="remark" id="edit_remark" class="form-control"></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">เลือกรูปภาพใหม่</label>
        <input type="file" name="pictures[]" multiple class="form-control" id="pictures-input-edit">
    </div>

    <div id="preview-area-edit" class="d-flex flex-wrap gap-2 mt-2"></div>
</div>



        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">อัปเดต</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection


@push('scripts')
<script>
// Preview ไฟล์ใหม่ใน Edit Modal
document.getElementById('pictures-input-edit').addEventListener('change', function(event) {
    const previewArea = document.getElementById('preview-area-edit');
    previewArea.innerHTML = "";

    const files = event.target.files;
    const dt = new DataTransfer();

    Array.from(files).forEach((file, index) => {
        if(file.type.startsWith("image/")){
            const reader = new FileReader();
            reader.onload = function(e){
                const wrapper = document.createElement("div");
                wrapper.className = "position-relative border rounded shadow-sm";
                wrapper.style.width = "120px";

                const img = document.createElement("img");
                img.src = e.target.result;
                img.className = "img-fluid rounded";
                img.style.height = "auto";

                const btn = document.createElement("button");
                btn.type = "button";
                btn.textContent = "ลบ";
                btn.className = "btn btn-sm btn-danger position-absolute";
                btn.style.top = "4px";
                btn.style.right = "4px";
                btn.style.padding = "2px 6px";
                btn.style.fontSize = "0.75rem";

                btn.addEventListener("click", function(){
                    wrapper.remove();
                    const newFiles = Array.from(files).filter((_, i) => i !== index);
                    const newDt = new DataTransfer();
                    newFiles.forEach(f => newDt.items.add(f));
                    document.getElementById('pictures-input-edit').files = newDt.files;
                });

                wrapper.appendChild(img);
                wrapper.appendChild(btn);
                previewArea.appendChild(wrapper);
            }
            reader.readAsDataURL(file);
            dt.items.add(file);
        }
    });

    document.getElementById('pictures-input-edit').files = dt.files;
});

// โหลดข้อมูลสำหรับ Edit และเติมรูปเดิม
function estimateEdit(id){
    $.ajax({
        url: "/estimate/edit/" + id,
        type: "GET",
        dataType: "json",
        success: function(data){
            // เติมค่าฟอร์ม
            $('#edit_date').val(data.date);
            $('#edit_follo_no').val(data.follo_no ?? '');
            $('#edit_results').val(data.results ?? '');
            $('#edit_teacher').val(data.teacher ?? '');
            $('#edit_remark').val(data.remark ?? '');

            // เซ็ต action ให้ชี้ไป update/{id}
            $('#edit-estimate-form').attr('action', '/estimate/update/' + data.id);

            // แสดงรูปเดิมพร้อมปุ่มลบ
            const preview = $('#preview-area-edit');
            preview.html('');
            if(Array.isArray(data.pictures)){
                data.pictures.forEach(function(pic){
                    preview.append(`
                        <div class="position-relative d-inline-block me-1 mb-1" style="width:80px;">
                            <img src="/storage/${pic.path}" class="img-thumbnail" style="width:80px; height:auto;">
                            <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0"
                                    onclick="removeOldPicture(${pic.id}, this)">
                                ลบ
                            </button>
                        </div>
                    `);
                });
            }
        }
    });
}

// ฟังก์ชันลบรูปเดิม
</script>

<script>
document.getElementById('pictures-input-add').addEventListener('change', function(event) {
    const previewArea = document.getElementById('preview-area-add');
    previewArea.innerHTML = "";

    const files = event.target.files;
    const dt = new DataTransfer();

    Array.from(files).forEach((file, index) => {
        if(file.type.startsWith("image/")){
            const reader = new FileReader();
            reader.onload = function(e){
                const wrapper = document.createElement("div");
                wrapper.className = "position-relative border rounded shadow-sm";
                wrapper.style.width = "120px";

                const img = document.createElement("img");
                img.src = e.target.result;
                img.className = "img-fluid rounded";
                img.style.height = "auto";

                const btn = document.createElement("button");
                btn.type = "button";
                btn.textContent = "ลบ";
                btn.className = "btn btn-sm btn-danger position-absolute";
                btn.style.top = "4px";
                btn.style.right = "4px";
                btn.style.padding = "2px 6px";
                btn.style.fontSize = "0.75rem";

                btn.addEventListener("click", function(){
                    wrapper.remove();
                    const newFiles = Array.from(files).filter((_, i) => i !== index);
                    const newDt = new DataTransfer();
                    newFiles.forEach(f => newDt.items.add(f));
                    document.getElementById('pictures-input-add').files = newDt.files;
                });

                wrapper.appendChild(img);
                wrapper.appendChild(btn);
                previewArea.appendChild(wrapper);
            }
            reader.readAsDataURL(file);
            dt.items.add(file);
        }
    });

    document.getElementById('pictures-input-add').files = dt.files;
});

function removeOldPicture(picId, btn){
    // เอา preview ออก
    $(btn).closest('div').remove();

    // เพิ่ม hidden input เพื่อบอก server ให้ลบรูปนี้
    $('#edit-estimate-form').append(
        `<input type="hidden" name="remove_pictures[]" value="${picId}">`
    );
}
</script>



@endpush
