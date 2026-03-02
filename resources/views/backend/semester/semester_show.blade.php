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
                <h4 class="fs-18 fw-semibold m-0">รายการวิชาเรียน</h4>
            </div>

            <!-- Modal Add Semester Button -->
            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <button type="button" class="btn btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#add-semester-modal">
                        เพิ่มรายการ
                    </button>
                </ol>
            </div>
            <!--End Modal Add Semester Button -->
        </div>

        <!-- Datatables Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-header">
                        <h5 class="card-title mb-0">ตารางปีการศึกษา</h5>
                    </div>

                    <!-- Semester Table -->
                    <div class="card-body">
                        <table id="datatable" class="table table-bordered dt-responsive nowrap">
                            <thead>
                                <tr>
                                    <th>ลำดับที่</th>
                                    <th>ปีการศึกษา</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($semester as $key => $item)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $item->semester_name }}</td>
                                        <td>
                                            <!-- Edit Button -->
                                            <button type="button" class="btn btn-success btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#edit-semester-modal"
                                                id="{{ $item->id }}"
                                                onclick="semesterEdit(this.id)">
                                                แก้ไข
                                            </button>

                                            <!-- Delete Button -->
                                            <a href="{{ route('semester.delete', $item->id) }}"
                                               class="btn btn-danger btn-sm" id="delete">ลบ</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!--End Semester Table -->

                </div>
            </div>
        </div>
    </div> <!-- container-fluid -->
</div> <!-- content -->

<!-- Form Create Semester Modal -->
<div class="modal fade" id="add-semester-modal" tabindex="-1" aria-labelledby="addSemesterLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addSemesterLabel">เพิ่มปีการศึกษา</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('semester.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="semester_name" class="form-label">ชื่อปีการศึกษา</label>
                        <input type="text" name="semester_name" id="semester_name"
                            class="form-control @error('semester_name') is-invalid @enderror"
                            value="{{ old('semester_name') }}">
                        @error('semester_name')
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

<!-- Edit Semester Modal -->
<div class="modal fade" id="edit-semester-modal" tabindex="-1" aria-labelledby="editSemesterLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editSemesterLabel">แก้ไขปีการศึกษา</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('semester.update') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <!-- hidden id -->
                    <input type="hidden" name="semester_id" id="semester_id">

                    <div class="mb-3">
                        <label for="edit_semester_name" class="form-label">ชื่อปีการศึกษา</label>
                        <input type="text" class="form-control" id="edit_semester_name" name="semester_name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">อัปเดต</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End Edit Semester Modal -->

<script type="text/javascript">
    function semesterEdit(id){
        $.ajax({
            url: "/edit/semester/" + id,
            type:"GET",
            dataType:"json",
            success:function(data){
                $('#edit_semester_name').val(data.semester_name);
                $('#semester_id').val(data.id);
            }
        });
    }
</script>

@endsection