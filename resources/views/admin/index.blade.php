@extends('admin.admin_master')

@section('admin')
<div class="content">
    <div class="container-fluid">

        <!-- Title -->
        <h4 class="fs-18 fw-semibold mb-4">Dashboard สถิติ</h4>

        <!-- Filter Form -->
        <form method="GET" action="{{ route('statistics.index') }}" class="row g-3 mb-4">
            <!-- ปี พ.ศ. -->
            <div class="col-md-2">
                <label>ปี พ.ศ.</label>
                <select name="year" class="form-select">
                    <option value="">ทั้งหมด</option>
                    @for($y=2550; $y<=date('Y')+543; $y++)
                        <option value="{{ $y }}" {{ ($year ?? '')==$y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <!-- เพศ -->
            <div class="col-md-2">
                <label>เพศ</label>
                <select name="gender" class="form-select">
                    <option value="">ทั้งหมด</option>
                    <option value="male" {{ ($gender ?? '')=='male'?'selected':'' }}>ชาย</option>
                    <option value="female" {{ ($gender ?? '')=='female'?'selected':'' }}>หญิง</option>
                </select>
            </div>
            <!-- อายุ -->
            <div class="col-md-2">
                <label>อายุต่ำสุด</label>
                <input type="number" name="age_min" class="form-control" value="{{ $ageMin ?? 1 }}" min="1" max="99">
            </div>
            <div class="col-md-2">
                <label>อายุสูงสุด</label>
                <input type="number" name="age_max" class="form-control" value="{{ $ageMax ?? 99 }}" min="1" max="99">
            </div>
            <!-- การศึกษา -->
            <div class="col-md-2">
                <label>ระดับการศึกษา</label>
                <select name="education" class="form-select">
                    <option value="">ทั้งหมด</option>
                    @foreach(\App\Models\Education::all() as $edu)
                        <option value="{{ $edu->id }}" {{ ($education ?? '')==$edu->id ? 'selected' : '' }}>
                            {{ $edu->education_name }}
                        </option>
                    @endforeach
                </select>
            </div>
          
          <!-- ปุ่ม -->
                <div class="col-12">
                    <button type="submit" 
                            class="btn btn-primary px-2py-2 rounded-3 shadow-sm d-inline-flex align-items-center">
                        <i data-feather="search" class="me-2"></i>
                        <span class="fw-semibold">ประมวลผล</span>
                    </button>
                </div>
        </form>

 <!-- Cards -->
<div class="row g-3">
    <!-- จำนวนทั้งหมด -->
    <div class="col-md-4">
        <div class="card text-dark shadow-sm border-0 rounded-4" 
             style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);">
            <div class="card-body text-center">
                <div class="mb-3 text-primary">
                    <i data-feather="users" class="feather-36"></i>
                </div>
                <h6 class="fw-semibold">จำนวนทั้งหมด</h6>
                <p class="fs-28 fw-bold mb-0 text-primary">{{ $clients->count() ?? 0 }}</p>
            </div>
        </div>
    </div>

    <!-- ชาย -->
    <div class="col-md-4">
        <div class="card text-dark shadow-sm border-0 rounded-4" 
             style="background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);">
            <div class="card-body text-center">
                <div class="mb-3 text-success">
                    <i data-feather="user" class="feather-36"></i>
                </div>
                <h6 class="fw-semibold">ชาย</h6>
                <p class="fs-28 fw-bold mb-0 text-success">{{ $maleCount ?? 0 }}</p>
            </div>
        </div>
    </div>

    <!-- หญิง -->
    <div class="col-md-4">
        <div class="card text-dark shadow-sm border-0 rounded-4" 
             style="background: linear-gradient(135deg, #fce4ec 0%, #f8bbd0 100%);">
            <div class="card-body text-center">
                <div class="mb-3 text-danger">
                    <i data-feather="user-check" class="feather-36"></i>
                </div>
                <h6 class="fw-semibold">หญิง</h6>
                <p class="fs-28 fw-bold mb-0 text-danger">{{ $femaleCount ?? 0 }}</p>
            </div>
        </div>
    </div>
</div>

        <!-- Charts Row -->
        <div class="row mt-4">
            <!-- Pie Chart -->
            <div class="col-md-6 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-header bg-light">
                        <div class="d-flex align-items-center">
                            <div class="border border-dark rounded-2 me-2 widget-icons-sections">
                                <i data-feather="pie-chart" class="widgets-icons"></i>
                            </div>
                            <h5 class="card-title mb-0">กราฟสถิติ (ชาย/หญิง)</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="chartGender" class="apex-charts"></div>
                    </div>
                </div>
            </div>

            <!-- Bar Chart -->
            <div class="col-md-6 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-header bg-light">
                        <div class="d-flex align-items-center">
                            <div class="border border-dark rounded-2 me-2 widget-icons-sections">
                                <i data-feather="bar-chart" class="widgets-icons"></i>
                            </div>
                            <h5 class="card-title mb-0">กราฟระดับการศึกษา</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="chartEducation" class="apex-charts"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- DataTable -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="mb-3">ตารางข้อมูล</h5>
                        <table id="clientsTable" class="table table-bordered table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th style="width:15%">ชื่อ</th>
                                    <th>เพศ</th>
                                    <th>อายุ</th>
                                    <th>ระดับการศึกษา</th>
                                    <th>ภาคเรียน</th>
                                    <th>สถานศึกษา</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($clients as $c)
                                <tr>
                                    <td>{{ $c->fullname }}</td>
                                    <td>
                                        @if($c->gender === 'male') ชาย
                                        @elseif($c->gender === 'female') หญิง
                                        @else - @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($c->birth_date)->age }}</td>
                                    @if($c->educationRecords->isNotEmpty())
                                        <td>{{ $c->educationRecords->first()->education->education_name ?? '-' }}</td>
                                        <td>{{ $c->educationRecords->first()->semester->semester_name ?? '-' }}</td>
                                        <td>{{ $c->educationRecords->first()->school_name ?? '-' }}</td>
                                    @else
                                        <td>-</td><td>-</td><td>-</td>
                                    @endif
                                </tr>
                                @empty
                                <tr><td colspan="6" class="text-center">ไม่มีข้อมูล</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    // ✅ Pie Chart (ชาย/หญิง)
    var optionsGender = {
        chart: { type: 'pie', height: 350 },
        series: [{{ $maleCount ?? 0 }}, {{ $femaleCount ?? 0 }}],
        labels: ['ชาย','หญิง'],
        colors: ['#28a745','#dc3545'],
        legend: { position: 'bottom' }
    };
    new ApexCharts(document.querySelector("#chartGender"), optionsGender).render();

    // ✅ Bar Chart (ระดับการศึกษา)
    var optionsEducation = {
        chart: { type: 'bar', height: 350 },
        series: [{
            name: 'จำนวน',
            data: [
                @foreach($educationCounts as $eduName => $count)
                    {{ $count }},
                @endforeach
            ]
        }],
        xaxis: {
            categories: [
                @foreach($educationCounts as $eduName => $count)
                    '{{ $eduName }}',
                @endforeach
            ]
        },
        colors: ['#007bff','#28a745','#dc3545','#ffc107','#17a2b8'],
        plotOptions: { bar: { horizontal: false, columnWidth: '50%' } },
        dataLabels: { enabled: true }
    };
    new ApexCharts(document.querySelector("#chartEducation"), optionsEducation).render();

    // ✅ DataTable ภาษาไทย + Scroll + Destroy
    $('#clientsTable').DataTable({
        destroy: true,          // ป้องกัน error reinitialise
        scrollY: "400px",       // เพิ่ม scroll ด้านล่าง
        scrollCollapse: true,
        paging: true,
        language: {
            search: "ค้นหา:",
            lengthMenu: "แสดง _MENU_ รายการต่อหน้า",
            info: "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
            infoEmpty: "ไม่มีข้อมูลให้แสดง",
            infoFiltered: "(กรองจากทั้งหมด _MAX_ รายการ)",
            zeroRecords: "ไม่พบข้อมูลที่ค้นหา",
            paginate: {
                first: "หน้าแรก",
                last: "หน้าสุดท้าย",
                next: "ถัดไป",
                previous: "ก่อนหน้า"
            }
        }
    });

    // ✅ Datepicker Thai
    $('.datepicker-th').datepicker({
        format: 'dd/mm/yyyy',
        language: 'th',
        thaiyear: true,
        autoclose: true,
        todayHighlight: true
    });
});
</script>

<!-- ✅ Toastr Alert -->
<script>
@if(Session::has('message'))
    var type = "{{ Session::get('alert-type','info') }}";
    switch(type){
        case 'info': toastr.info("{{ Session::get('message') }}"); break;
        case 'success': toastr.success("{{ Session::get('message') }}"); break;
        case 'warning': toastr.warning("{{ Session::get('message') }}"); break;
        case 'error': toastr.error("{{ Session::get('message') }}"); break;
    }
@endif
</script>
@endpush