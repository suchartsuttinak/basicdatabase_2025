@extends('admin.admin_master')
@section('admin')

<div class="content">
    <div class="container-fluid">

        <!-- Alert Message -->
        @if ($errors->any())
            <div class="alert alert-danger" id="alert-message">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success" id="alert-message">
                {{ session('success') }}
            </div>
        @endif

        <script>
            // ให้ข้อความหายไปเองหลัง 4 วินาที
            setTimeout(function() {
                let alertBox = document.getElementById('alert-message');
                if (alertBox) {
                    alertBox.style.transition = "opacity 0.5s ease";
                    alertBox.style.opacity = 0;
                    setTimeout(() => alertBox.remove(), 500);
                }
            }, 4000);
        </script>
        <!--End Alert Message -->

        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">รายการพ้นอุปการะ</h4>
            </div>

            <!-- Modal Add Translate Button -->
            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <button type="button" class="btn btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#add-translate-modal">
                        เพิ่มรายการ
                    </button>
                </ol>
            </div>
            <!--End Modal Add Translate Button -->
        </div>

        <!-- Datatables Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-header">
                        <h5 class="card-title mb-0">ตารางการจำหน่าย</h5>
                    </div>

                    <!-- Subject Table -->
                    <div class="card-body">
                        <table id="datatable" class="table table-bordered dt-responsive nowrap">
                            <thead>
                                <tr>
                                    <th>ลำดับที่</th>
                                    <th>ชื่อการจำหน่าย</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($translate as $key => $item)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $item->translate_name }}</td>
                                        <td>
                                            <!-- Edit Button -->
                                            <button type="button" class="btn btn-success btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#edit-translate-modal"
                                                id="{{ $item->id }}"
                                                onclick="translateEdit(this.id)">
                                                แก้ไข
                                            </button>

                                            <!-- Delete Button -->
                                            <a href="{{ route('translate.delete', $item->id) }}"
                                               class="btn btn-danger btn-sm" id="delete">ลบ</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!--End Subject Table -->

                </div>
            </div>
        </div>
    </div> <!-- container-fluid -->
</div> <!-- content -->

<!-- Form Create Translate Modal -->
<div class="modal fade" id="add-translate-modal" tabindex="-1" aria-labelledby="addTranslateLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addTranslateLabel">เพิ่มการจำหน่าย</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('translate.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="translate_name" class="form-label">ชื่อการจำหน่าย</label>
                        <input type="text" name="translate_name" id="translate_name"
                            class="form-control @error('translate_name') is-invalid @enderror"
                            value="{{ old('translate_name') }}">
                        @error('translate_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End Form Create Subject Modal -->

<!-- Edit Translate Modal -->
<div class="modal fade" id="edit-translate-modal" tabindex="-1" aria-labelledby="editTranslateLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editTranslateLabel">แก้ไขการจำหน่าย</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('translate.update') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <!-- hidden id -->
                    <input type="hidden" name="translate_id" id="translate_id">

                    <div class="mb-3">
                        <label for="edit_translate_name" class="form-label">ชื่อการจำหน่าย</label>
                        <input type="text" class="form-control" id="edit_translate_name" name="translate_name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">อัปเดต</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End Edit Translate Modal -->

<script type="text/javascript">
    function translateEdit(id){
        $.ajax({
            url: "/edit/translate/" + id,
            type:"GET",
            dataType:"json",
            success:function(data){
                $('#edit_translate_name').val(data.translate_name);
                $('#translate_id').val(data.id);
            }
        });
    }
</script>

@endsection