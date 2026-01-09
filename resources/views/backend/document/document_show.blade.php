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
                    data-bs-target="#add-document-modal">
                    เพิ่มรายการ
                </button>
            </div>
        </div>

        <!-- Datatables Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-header">
                        <h5 class="card-title mb-0">รายชื่อเอกสาร</h5>
                    </div>

                    <!-- Document Table -->
                    <div class="card-body">
                        @if($document->isNotEmpty())
                            <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th style="width: 10%; text-align: center;">ลำดับที่</th>
                                        <th>ชื่อเอกสาร</th>
                                        <th style="width: 10%; text-align: center;">การจัดการ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($document as $key => $item)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $item->document_name }}</td>
                                            <td>
                                                <!-- Edit Button -->
                                                <button type="button" class="btn btn-success btn-sm"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#edit-document-modal"
                                                    id="{{ $item->id }}"
                                                    onclick="documentEdit(this.id)">
                                                    แก้ไข
                                                </button>

                                                <!-- Delete Button -->
                                                <a href="{{ route('document.delete', $item->id) }}"
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
<div class="modal fade" id="add-document-modal" tabindex="-1" aria-labelledby="addDocumentLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addDocumentLabel">เพิ่มรายการ</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('document.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="document_name" class="form-label">ชื่อเอกสาร</label>
                        <input type="text" name="document_name" id="document_name"
                            class="form-control @error('document_name') is-invalid @enderror"
                            value="{{ old('document_name') }}">
                        @error('document_name')
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

<!-- Edit Document Modal -->
<div class="modal fade" id="edit-document-modal" tabindex="-1" aria-labelledby="editDocumentLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editDocumentLabel">แก้ไขรายการ</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('document.update') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <!-- hidden id -->
                    <input type="hidden" name="document_id" id="document_id">

                    <div class="mb-3">
                        <label for="edit_document_name" class="form-label">ชื่อเอกสาร</label>
                        <input type="text" class="form-control" id="edit_document_name" name="document_name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">อัปเดต</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End Edit Document Modal -->

<script type="text/javascript">
    function documentEdit(id){
        $.ajax({
            url: "/edit/document/" + id,
            type:"GET",
            dataType:"json",
            success:function(data){
                $('#edit_document_name').val(data.document_name);
                $('#document_id').val(data.id);
            }
        });
    }
</script>

@endsection