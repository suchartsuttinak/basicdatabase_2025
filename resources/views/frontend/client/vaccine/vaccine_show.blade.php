@extends('admin_client.admin_client')
@section('content')

<div class="card shadow-sm border-0 mt-3">
    <div class="card-header bg-light fw-bold text-dark py-2 px-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="bi bi-capsule-pill me-2 text-primary"></i> ประวัติการให้วัคซีน
        </h5>
        <!-- ✅ ปุ่มเปิด Modal -->
        <button type="button" 
                class="btn btn-sm btn-primary d-flex align-items-center shadow-sm px-3"
                data-bs-toggle="modal"
                data-bs-target="#add-vaccine-modal">
            <i class="bi bi-plus-circle me-1"></i>
            <span>เพิ่มข้อมูล</span>
        </button>
    </div>
</div>

<!-- ตารางวัคซีน -->
<div class="card-body">
    @if($vaccinations->isEmpty())
        <!-- ✅ กรณีไม่มีข้อมูล -->
        <div class="alert alert-info text-center">
            ยังไม่มีข้อมูลวัคซีน
        </div>
    @else
        <table id="datatable-vaccine" class="table table-bordered table-striped align-middle">
            <thead class="table-primary">
                <tr>
                    <th scope="col">วันที่</th>
                    <th scope="col">ชนิดวัคซีน</th>
                    <th scope="col">สถานพยาบาล</th>
                    <th scope="col">หมายเหตุ</th>
                    <th scope="col">ผู้บันทึก</th>
                    <th scope="col" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vaccinations as $item)
                    <tr>
                        <td>{{ $item->date }}</td>
                        <td>{{ $item->vaccine_name }}</td>
                        <td>{{ $item->hospital }}</td>
                        <td>{{ $item->remark }}</td>
                        <td>{{ $item->recorder }}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-success btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#edit-vaccine-modal"
                                onclick="vaccineEdit({{ $item->id }})">
                                <i class="bi bi-pencil-square"></i> แก้ไข
                            </button>

                            <!-- ✅ ฟอร์มลบแบบซ่อน -->
                            <form id="delete-form-{{ $item->id }}" 
                                  action="{{ route('vaccine.delete', $item->id) }}" 
                                  method="POST" style="display:none;">
                                @csrf
                                @method('DELETE')
                            </form>

                            <!-- ✅ ปุ่มลบเรียก SweetAlert -->
                            <button type="button" class="btn btn-danger btn-sm ms-1"
                                    onclick="confirmDelete({{ $item->id }})">
                                <i class="bi bi-trash"></i> ลบ
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif   <!-- ✅ ปิดเงื่อนไข -->
</div>

<!-- ✅ Modal Add Vaccine -->
<div class="modal fade" id="add-vaccine-modal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="{{ route('vaccine.store') }}" method="POST" id="add-vaccine-form">
        @csrf
        <input type="hidden" name="client_id" value="{{ $client->id }}">

        <div class="modal-header">
          <h5 class="modal-title">เพิ่มข้อมูลวัคซีน</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
        <div class="mb-3 col-4">
                    <label class="form-label">วันรับวัคซีน</label>
                    <input type="date" 
                        name="date" 
                        class="form-control @error('date') is-invalid @enderror" 
                        value="{{ old('date') }}">
                    @error('date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">ชนิดวัคซีน</label>
                    <input type="text" 
                        name="vaccine_name" 
                        class="form-control @error('vaccine_name') is-invalid @enderror" 
                        value="{{ old('vaccine_name') }}">
                    @error('vaccine_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
          <div class="mb-3">
            <label class="form-label">สถานพยาบาล</label>
            <input type="text" name="hospital" class="form-control">
          </div>
          <div class="mb-3">
            <label class="form-label">หมายเหตุ</label>
            <textarea name="remark" class="form-control"></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">ผู้บันทึก</label>
            <input type="text" name="recorder" class="form-control">
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">บันทึก</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Edit Vaccine -->
<div class="modal fade" id="edit-vaccine-modal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <!-- ✅ ให้ action มีค่า default -->
      <form method="POST" id="edit-vaccine-form" action="{{ route('vaccine.update', 0) }}">
        @csrf
        @method('PUT')

        <div class="modal-header">
          <h5 class="modal-title">แก้ไขข้อมูลวัคซีน</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
         <div class="mb-3">
    <label class="form-label">วันที่</label>
    <input type="date" 
           name="date" 
           id="edit_date" 
           class="form-control @error('date') is-invalid @enderror" 
           value="{{ old('date') }}">
    @error('date')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">ชนิดวัคซีน</label>
    <input type="text" 
           name="vaccine_name" 
           id="edit_vaccine_name" 
           class="form-control @error('vaccine_name') is-invalid @enderror" 
           value="{{ old('vaccine_name') }}">
    @error('vaccine_name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
          <div class="mb-3">
            <label class="form-label">สถานพยาบาล</label>
            <input type="text" name="hospital" id="edit_hospital" class="form-control">
          </div>
          <div class="mb-3">
            <label class="form-label">เจ้าหน้าที่</label>
            <input type="text" name="recorder" id="edit_recorder" class="form-control">
          </div>
          <div class="mb-3">
            <label class="form-label">หมายเหตุ</label>
            <textarea name="remark" id="edit_remark" class="form-control"></textarea>
          </div>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $('#datatable-vaccine').DataTable({
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/th.json'
            }
        });
    });

    function vaccineEdit(id){
        $.ajax({
            url: "/vaccine/edit/" + id,
            type:"GET",
            dataType:"json",
            success:function(data){
                $('#edit_date').val(data.date);
                $('#edit_vaccine_name').val(data.vaccine_name);
                $('#edit_hospital').val(data.hospital);
                $('#edit_recorder').val(data.recorder);
                $('#edit_remark').val(data.remark);

                // ✅ เซ็ต action ของ form ให้ถูกต้อง
                $('#edit-vaccine-form').attr('action', '/vaccine/update/' + data.id);
            }
        });
    }

    // ✅ เปิด modal edit เมื่อมี error
    $(document).ready(function() {
        @if ($errors->any() && session('edit_mode') && session('edit_id'))
            $('#edit-vaccine-modal').modal('show');
            $('#edit-vaccine-form').attr('action', '/vaccine/update/' + "{{ session('edit_id') }}");
        @endif
    });

    // ✅ SweetAlert2 สำหรับยืนยันการลบ
    function confirmDelete(id) {
        Swal.fire({
            title: 'ท่านแน่ใจ ?',
            text: 'ลบข้อมูลนี้ใช่หรือไม่ ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'ตกลง',
            cancelButtonText: 'ยกเลิก',
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>

@endpush