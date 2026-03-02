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

        {{-- Header --}}
        <div class="py-3 d-flex flex-sm-row flex-column">
            <div class="ms-sm-auto">
                <button type="button" class="btn btn-primary w-100 w-sm-auto"
                    data-bs-toggle="modal"
                    data-bs-target="#add-education-modal">
                    เพิ่มรายการ
                </button>
            </div>
        </div>

        <!-- Datatables Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-header">
                        <h5 class="card-title mb-0">รายชื่อระดับการศึกษา</h5>
                    </div>

                    <!-- Education Table -->
                    <div class="card-body">
                        @if($education->isNotEmpty())
                            <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th style="width: 10%; text-align: center;">ลำดับที่</th>
                                        <th>ชื่อระดับการศึกษา</th>
                                        <th style="width: 10%; text-align: center;">การจัดการ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($education as $key => $item)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $item->education_name }}</td>
                                            <td>
                                                <!-- Edit Button -->
                                                <button type="button" class="btn btn-success btn-sm"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#edit-education-modal"
                                                    id="{{ $item->id }}"
                                                    onclick="educationEdit(this.id)">
                                                    แก้ไข
                                                </button>

                                                <!-- Delete Button -->
                                                <a href="{{ route('education.delete', $item->id) }}"
                                                   class="btn btn-danger btn-sm" id="delete">ลบ</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="alert alert-info mb-0">
                                ไม่มีข้อมูลในตาราง
                            </div>
                        @endif
                    </div>
                    <!--End Document Table -->

                </div>
            </div>
        </div>
    </div> <!-- container-fluid -->
</div> <!-- content -->

<!-- Form Create Document Modal -->
<div class="modal fade" id="add-education-modal" tabindex="-1" aria-labelledby="addEducationLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addEducationLabel">เพิ่มรายการ</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('education.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="education_name" class="form-label">ชื่อระดับการศึกษา</label>
                        <input type="text" name="education_name" id="education_name"
                            class="form-control @error('education_name') is-invalid @enderror"
                            value="{{ old('education_name') }}">
                        @error('education_name')
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
<!--End Form Create Document Modal -->

<!-- Edit Education Modal -->
<div class="modal fade" id="edit-education-modal" tabindex="-1" aria-labelledby="editEducationLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editEducationLabel">แก้ไขรายการ</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('education.update') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <!-- hidden id -->
                    <input type="hidden" name="education_id" id="education_id">

                    <div class="mb-3">
                        <label for="edit_education_name" class="form-label">ชื่อระดับการศึกษา</label>
                        <input type="text" class="form-control" id="edit_education_name" name="education_name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">อัปเดต</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End Edit Education Modal -->

<script type="text/javascript">
    function educationEdit(id){
        $.ajax({
            url: "/edit/education/" + id,
            type:"GET",
            dataType:"json",
            success:function(data){
                $('#edit_education_name').val(data.education_name);
                $('#education_id').val(data.id);
            }
        });
    }
</script>

@endsection