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
                <h4 class="fs-18 fw-semibold m-0">ประเภทการช่วยเหลือ</h4>
            </div>

            <!-- Modal Add HelpType Button -->
            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <button type="button" class="btn btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#add-help-type-modal">
                        เพิ่มรายการ
                    </button>
                </ol>
            </div>
            <!--End Modal Add HelpType Button -->
        </div>

        <!-- Datatables Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-header">
                        <h5 class="card-title mb-0">ตารางประเภทการช่วยเหลือ</h5>
                    </div>

                    <!-- HelpType Table -->
                    <div class="card-body">
                        <table id="datatable" class="table table-bordered dt-responsive nowrap">
                            <thead>
                                <tr>
                                    <th>ลำดับที่</th>
                                    <th>ชื่อประเภทการช่วยเหลือ</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($help as $key => $item)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $item->help_name }}</td>
                                        <td>
                                            <!-- Edit Button -->
                                            <button type="button" class="btn btn-success btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#edit-help-type-modal"
                                                id="{{ $item->id }}"
                                                onclick="helpTypeEdit(this.id)">
                                                แก้ไข
                                            </button>

                                            <!-- Delete Button -->
                                            <a href="{{ route('help_type.delete', $item->id) }}"
                                               class="btn btn-danger btn-sm" id="delete">ลบ</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!--End HelpType Table -->

                </div>
            </div>
        </div>
    </div> <!-- container-fluid -->
</div> <!-- content -->

<!-- Form Create HelpType Modal -->
<div class="modal fade" id="add-help-type-modal" tabindex="-1" aria-labelledby="addHelpTypeLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addHelpTypeLabel">เพิ่มประเภทการช่วยเหลือ</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('help_type.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="help_name" class="form-label">ชื่อประเภทการช่วยเหลือ</label>
                        <input type="text" name="help_name" id="help_name"
                            class="form-control @error('help_name') is-invalid @enderror"
                            value="{{ old('help_name') }}">
                        @error('help_name')
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

<!-- Edit HelpType Modal -->
<div class="modal fade" id="edit-help-type-modal" tabindex="-1" aria-labelledby="editHelpTypeLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editHelpTypeLabel">แก้ไขประเภทการช่วยเหลือ</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('help_type.update') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <!-- hidden id -->
                    <input type="hidden" name="help_id" id="help_id">

                    <div class="mb-3">
                        <label for="edit_help_name" class="form-label">ชื่อประเภทการช่วยเหลือ</label>
                        <input type="text" class="form-control" id="edit_help_name" name="help_name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">อัปเดต</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End Edit HelpType Modal -->

<script type="text/javascript">
    function helpTypeEdit(id){
        $.ajax({
            url: "/edit/help_type/" + id,
            type:"GET",
            dataType:"json",
            success:function(data){
                $('#edit_help_name').val(data.help_name);
                $('#help_id').val(data.id);
            }
        });
    }
</script>

@endsection