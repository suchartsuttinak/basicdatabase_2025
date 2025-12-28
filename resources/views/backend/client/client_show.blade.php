@extends('admin.admin_master')
@section('admin')

<div class="content">
    <div class="container-fluid">

        {{-- Header --}}
        <div class="py-3 d-flex flex-sm-row flex-column">
            <div class="ms-sm-auto">
                <a href="{{ route('client.add') }}" class="btn btn-secondary w-100 w-sm-auto">
                    เพิ่มรายการ
                </a>
            </div>
        </div>

        {{-- DataTable --}}
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-header">
                        <h5 class="card-title mb-0">รายการผู้รับ</h5>
                    </div>

                    <div class="card-body">
                        @if($clients->isNotEmpty())
                            <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap w-100">
                                <thead class="table-primary">
                                    <tr>
                                        <th>ลำดับ</th>
                                        <th>ภาพ</th>
                                        <th>ชื่อ-นามสกุล</th>
                                        <th>วันที่รับเข้า</th>
                                        <th>วันเกิด</th>
                                        <th>อายุ</th>
                                        <th>ปัญหา</th>
                                        <th>สถานะ</th>
                                        <th>การจัดการ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($clients as $key => $client)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>

                                            <!-- ดึงภาพ -->
                                            <td>
                                                @php
                                                    $imagePath = public_path('upload/client_images/' . $client->image);
                                                @endphp
                                                @if(!empty($client->image) && file_exists($imagePath))
                                                    <img src="{{ asset('upload/client_images/' . $client->image) }}"
                                                        style="height: 40px; width: 40px; object-fit: cover;">
                                                @else
                                                    <img src="{{ asset('upload/no_image.jpg') }}"
                                                        style="height: 40px; width: 40px; object-fit: cover;">
                                                @endif
                                            </td>

                                            <td>{{ $client->full_name }}</td>
                                            <td>{{ $client->arrival_date }}</td>
                                            <td>{{ $client->birth_date }}</td>
                                            <td>{{ $client->age }}</td>

                                            <td>
                                                @if($client->problems->isNotEmpty())
                                                    <ul class="mb-0 ps-3">
                                                        @foreach($client->problems as $problem)
                                                            <li>{{ $problem->name }}</li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    <span class="text-muted">ไม่มีข้อมูล</span>
                                                @endif
                                            </td>

                                            <!-- แสดงสถานะ release_status -->
                                            <td>
                                                @if($client->release_status === 'show')
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-secondary">Refer</span>
                                                @endif
                                            </td>

                                            <td>
                                                <a title="Edit" href="{{ route('client.edit', $client->id) }}" 
                                                    class="btn btn-success btn-sm">
                                                    <span class="mdi mdi-book-edit-outline mdi-18px"></span>
                                                </a>

                                                <a title="Delete" href="{{ route('client.delete', $client->id) }}" 
                                                    class="btn btn-danger btn-sm" id="delete">
                                                    <span class="mdi mdi-trash-can-outline mdi-18px"></span>
                                                </a>

                                                <a title="Main" href="{{ route('admin.index', $client->id) }}" 
                                                    class="btn btn-primary btn-sm">
                                                    <span class="mdi mdi-eye-circle mdi-18px"></span>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="alert alert-info mb-0">
                                ไม่มีข้อมูลผู้รับ
                            </div>
                        @endif
                    </div> <!-- end card-body -->

                </div> <!-- end card -->
            </div> <!-- end col -->
        </div> <!-- end row -->

    </div> <!-- end container-fluid -->
</div> <!-- end content -->

@endsection