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
                    data-bs-target="#add-psycho-modal">
                    เพิ่มรายการ
                </button>
            </div>
        </div>

        <!-- Datatables Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-header">
                        <h5 class="card-title mb-0">ตารางชื่อโรคทางจิตเวช</h5>
                    </div>

                    <!-- Subject Table -->
                    <div class="card-body">
                        @if($psycho->isNotEmpty())
                            <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th style="width: 10%; text-align: center;">ลำดับที่</th>
                                        <th>ชื่อโรค</th>
                                        <th style="width: 10%; text-align: center;">การจัดการ</th>


                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($psycho as $key => $item)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $item->psycho_name }}</td>
                                            <td>
                                                <!-- Edit Button -->
                                                <button type="button" class="btn btn-success btn-sm"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#edit-psycho-modal"
                                                    id="{{ $item->id }}"
                                                    onclick="psychoEdit(this.id)">
                                                    แก้ไข
                                                </button>

                                                <!-- Delete Button -->
                                                <a href="{{ route('psycho.delete', $item->id) }}"
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
                    <!--End Subject Table -->

                </div>
            </div>
        </div>
    </div> <!-- container-fluid -->
</div> <!-- content -->

<!-- Form Create Subject Modal -->
<div class="modal fade" id="add-psycho-modal" tabindex="-1" aria-labelledby="addPsychoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addPsychoLabel">เพิ่มวิชาเรียน</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('psycho.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="psycho_name" class="form-label">ชื่อโรค</label>
                        <input type="text" name="psycho_name" id="psycho_name"
                            class="form-control @error('psycho_name') is-invalid @enderror"
                            value="{{ old('psycho_name') }}">
                        @error('psycho_name')
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
<div class="modal fade" id="edit-psycho-modal" tabindex="-1" aria-labelledby="editPsychoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editPsychoLabel">แก้ไขชื่อโรค</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('psycho.update') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <!-- hidden id -->
                    <input type="hidden" name="psycho_id" id="psycho_id">

                    <div class="mb-3">
                        <label for="edit_psycho_name" class="form-label">ชื่อวิชาเรียน</label>
                        <input type="text" class="form-control" id="edit_psycho_name" name="psycho_name">
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
    function psychoEdit(id){
        $.ajax({
            url: "/edit/psycho/" + id,
            type:"GET",
            dataType:"json",
            success:function(data){
                $('#edit_psycho_name').val(data.psycho_name);
                $('#psycho_id').val(data.id);
            }
        });
    }
</script>

@endsection