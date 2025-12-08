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

            <!-- Modal Add Subject Button -->
            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <button type="button" class="btn btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#add-subject-modal">
                        เพิ่มรายการ
                    </button>
                </ol>
            </div>
            <!--End Modal Add Subject Button -->
        </div>

        <!-- Datatables Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-header">
                        <h5 class="card-title mb-0">ตารางวิชาเรียน</h5>
                    </div>

                    <!-- Subject Table -->
                    <div class="card-body">
                        <table id="datatable" class="table table-bordered dt-responsive nowrap">
                            <thead>
                                <tr>
                                    <th>ลำดับที่</th>
                                    <th>ชื่อวิชาเรียน</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subject as $key => $item)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $item->subject_name }}</td>
                                        <td>
                                            <!-- Edit Button -->
                                            <button type="button" class="btn btn-success btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#edit-subject-modal"
                                                id="{{ $item->id }}"
                                                onclick="subjectEdit(this.id)">
                                                แก้ไข
                                            </button>

                                            <!-- Delete Button -->
                                            <a href="{{ route('subject.delete', $item->id) }}"
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

<!-- Form Create Subject Modal -->
<div class="modal fade" id="add-subject-modal" tabindex="-1" aria-labelledby="addSubjectLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addSubjectLabel">เพิ่มวิชาเรียน</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('subject.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="subject_name" class="form-label">ชื่อวิชาเรียน</label>
                        <input type="text" name="subject_name" id="subject_name"
                            class="form-control @error('subject_name') is-invalid @enderror"
                            value="{{ old('subject_name') }}">
                        @error('subject_name')
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

<!-- Edit Subject Modal -->
<div class="modal fade" id="edit-subject-modal" tabindex="-1" aria-labelledby="editSubjectLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editSubjectLabel">แก้ไขวิชาเรียน</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('subject.update') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <!-- hidden id -->
                    <input type="hidden" name="sub_id" id="sub_id">

                    <div class="mb-3">
                        <label for="edit_subject_name" class="form-label">ชื่อวิชาเรียน</label>
                        <input type="text" class="form-control" id="edit_subject_name" name="subject_name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">อัปเดต</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End Edit Subject Modal -->

<script type="text/javascript">
    function subjectEdit(id){
        $.ajax({
            url: "/edit/subject/" + id,
            type:"GET",
            dataType:"json",
            success:function(data){
                $('#edit_subject_name').val(data.subject_name);
                $('#sub_id').val(data.id);
            }
        });
    }
</script>

@endsection