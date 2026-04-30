@extends('admin.admin_master')
@section('admin')

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<style>
    .btn.back-home {
    margin-top: -5px;   /* ยกขึ้นเล็กน้อย */
    position: relative;
    z-index: 1;         /* ให้ลอยเหนือเส้น */
}
</style>

<div class="content">
    <div class="container-fluid">

        {{-- ปุ่มย้อนกลับ --}}
        <div class="py-3 d-flex flex-sm-row flex-column">
            <div class="ms-sm-auto">
                <a href="{{ route('client.show') }}" class="btn btn-success w-100 w-sm-auto">
                    <i class="bi bi-house-door-fill me-1"></i> กลับหน้าหลัก
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
                                                            <li>{{ $problem->problem_name }}</li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    <span class="text-muted">ไม่มีข้อมูล</span>
                                                @endif
                                            </td>

                                            <!-- แสดงสถานะ release_status -->

                                              
                                            <td>
                                                @if($client->release_status === 'show')
                                                    <span class="badge bg-success">อยู่ในระบบ</span>
                                                @else
                                                    <span class="badge bg-secondary">ไม่อยู่ในระบบ</span>
                                                @endif
                                            </td>

                                            <td>
                                                <a title="Main" href="{{ route('admin.index', $client->id) }}" 
                                                    class="btn btn-primary btn-sm">
                                                    <span class="mdi mdi-eye-circle mdi-18px"></span>
                                                </a>
                                               
                                              <a title="จำหน่าย" href="{{ route('refers.index', $client->id) }}" class="btn btn-warning btn-sm">
                                                    <span class="mdi mdi-arrow-right-bold mdi-18px"></span>
                                                </a>

                                    {{-- ✅ ปุ่มปรับสถานะจาก refer → show --}}
                                        @if($client->release_status === 'refer')
                                            <form method="POST" action="{{ route('client.changeStatus', $client->id) }}" 
                                                class="d-inline-block change-status-form">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm" title="ปรับเป็น Active">
                                                    <span class="mdi mdi-check-circle mdi-18px"></span>
                                                </button>
                                            </form>
                                        @endif

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

@push('scripts')

<script>
    $(document).ready(function() {
        $('#datatable').DataTable({
            responsive: true,
            language: {
                search: "ค้นหา:",
                lengthMenu: "แสดง _MENU_ รายการ",
                info: "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                paginate: {
                    first: "หน้าแรก",
                    last: "หน้าสุดท้าย",
                    next: "ถัดไป",
                    previous: "ก่อนหน้า"
                },
                zeroRecords: "ไม่พบข้อมูลที่ค้นหา"
            }
        });
    });

 
document.addEventListener('DOMContentLoaded', function () {
    // ดักทุกฟอร์มที่มี class change-status-form
    document.querySelectorAll('.change-status-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault(); // กันการ submit ทันที

            Swal.fire({
                title: 'ยืนยันการคืนค่า?',
                text: "คุณต้องการปรับสถานะเป็น Active ใช่หรือไม่",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่, คืนค่า!',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // ถ้ากดตกลง ค่อย submit จริง
                }
            });
        });
    });
});

</script>

@endpush
@endsection

