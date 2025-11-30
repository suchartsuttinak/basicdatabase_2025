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
                    // ให้ข้อความหายไปเองหลัง 3 วินาที
                    setTimeout(function() {
                        let alertBox = document.getElementById('alert-message');
                        if (alertBox) {
                            alertBox.style.transition = "opacity 0.5s ease";
                            alertBox.style.opacity = 0;
                            setTimeout(() => alertBox.remove(), 500); // ลบออกจาก DOM หลัง fade out
                        }
                    }, 4000); // 4000ms = 4 วินาที
                </script>
                  <!--End Alert Message -->


            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">รายการสถานศึกษา</h4>
                </div>

                <!-- Modal Add Category -->
                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <button 
                        type="button" class="btn btn-primary" 
                        data-bs-toggle="modal" 
                        data-bs-target="#standard-modal">
                        เพิมรายการ
                        </button>
                    </ol>
                </div>
                <!--End Modal Add Category -->
            </div>

            <!-- Datatables Table  -->
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header">
                    <h5 class="card-title mb-0">ตารางสถานศึกษา</h5>
                </div><!-- end card header -->

                <!-- Institution Table -->
                <div class="card-body">
                    <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
                        <thead>
                        <tr>
                            <th>ลำดับที่</th>
                            <th>ชื่อสถานศึกษา</th>                
                            <th>Action</th>                                 
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ( $institution as $key => $item) 
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$item->institution_name}}</td>           
                            <td>

                            <!-- Edit Button -->
                            <button 
                            type="button" class="btn btn-success btn-sm" 
                            data-bs-toggle="modal" 
                            data-bs-target="#institution"
                            id="{{$item->id}}"
                            onclick="institutionEdit(this.id)">     
                            แก้ไข
                            </button>
                                <!--End Edit Button -->

                            <!-- Delete Button -->
                            <a href="{{ route('institution.delete', $item->id) }}"
                                    class="btn btn-danger btn-sm" id="delete">ลบ</a>
                            </td>
                            </tr>
                                @endforeach
                    </table>
                </div>
                <!--End Institution Table -->
                                </div>
                            </div>
                        </div>
                    </div> <!-- container-fluid -->
                </div> <!-- content -->

                   <!-- Form Create Institution Modal -->
                    <div class="modal fade" id="standard-modal" tabindex="-1" aria-labelledby="standard-modalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="standard-modalLabel">รายการสถานศึกษา</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                        <form action="{{ route('institution.store') }}" method="POST">
                            @csrf
                        <form method="POST" action="{{ route('institution.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="institution_name" class="form-label">ชื่อสถานศึกษา</label>
                            <input type="text" name="institution_name" id="institution_name"
                                class="form-control @error('institution_name') is-invalid @enderror"
                                value="{{ old('institution_name') }}">
                            @error('institution_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">บันทึก</button>
                            </div>
                        </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!--End Form Create Institution Modal -->

                <!-- Edit Institution Modal -->
                    <div class="modal fade" id="institution" tabindex="-1" aria-labelledby="standard-modalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="standard-modalLabel">แก้ไขรายการ</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                        <form action="{{ route('institution.update') }}" method="POST">
                            @csrf                            
                            <!-- hidden id -->
                            <input type="hidden" name="ins_id" id="ins_id">

                            <div class="form-group col-md-12">
                                <label for="institution_name" class="form-label">ชื่อสถานศึกษา</label>
                                <input type="text" class="form-control" id="ins" name="institution_name" >                              
                            </div>
                            
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Update </button>
                            </div>
                        </form>
                            </div>
                        </div>
                    </div>
                </div>
                        <!--End Edit Institution Modal -->
                <script type="text/javascript">
                    function institutionEdit(id){
                        $.ajax({
                            url: "/edit/institution/"+id,
                            type:"GET",
                            dataType:"json",
                            success:function(data){
                                $('#ins').val(data.institution_name); 
                                $('#ins_id').val(data.id); 
                            }
                        });
                    }
                </script>
        @endsection