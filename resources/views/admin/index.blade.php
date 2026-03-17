@extends('admin.admin_master')

@section('admin')
<div class="content">
    <div class="container-fluid">

        <!-- Title -->
       <div class="text-center mt-4 mb-4">
    <h2 class="fw-bold text-primary d-inline-flex align-items-center" style="font-size: 32px;">
        <i data-feather="users" class="me-2 text-primary"></i>
        ข้อมูลผู้รับบริการ
    </h2>
    <hr class="mx-auto mt-2" style="width: 180px; border-top: 3px solid #0d6efd; border-radius: 2px;">
</div>

        <!-- Filter Form -->
        <form method="GET" action="{{ route('statistics.index') }}" class="row g-3 mb-4">
     <div class="row g-3">
    <div class="col-md-4">
        <label class="form-label fw-semibold text-dark d-block mb-2">สถานะผู้รับบริการ</label>
        <div class="btn-group w-100" role="group" aria-label="สถานะ">

            <!-- ทั้งหมด -->
            <input type="radio" class="btn-check" name="release_status" id="statusAll" value="all"
                   {{ ($releaseStatus ?? '')=='all' ? 'checked' : '' }}>
            <label class="btn btn-outline-secondary rounded-3 shadow-sm d-flex align-items-center justify-content-center" for="statusAll">
                <i data-feather="list" class="me-2"></i> ทั้งหมด
            </label>

            <!-- อยู่อาศัย -->
            <input type="radio" class="btn-check" name="release_status" id="statusShow" value="show"
                   {{ ($releaseStatus ?? '')=='show' ? 'checked' : '' }}>
            <label class="btn btn-outline-success rounded-3 shadow-sm d-flex align-items-center justify-content-center" for="statusShow">
                <i data-feather="home" class="me-2"></i> อยู่อาศัย
            </label>

            <!-- ถูกจำหน่าย -->
            <input type="radio" class="btn-check" name="release_status" id="statusRefer" value="refer"
                   {{ ($releaseStatus ?? '')=='refer' ? 'checked' : '' }}>
            <label class="btn btn-outline-danger rounded-3 shadow-sm d-flex align-items-center justify-content-center" for="statusRefer">
                <i data-feather="x-circle" class="me-2"></i> ถูกจำหน่าย
            </label>
        </div>
    </div>
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

              <div class="col-md-3">
                    <label>สถานศึกษา</label>
                    <select name="institution_id" class="form-select">
                        <option value="">ทั้งหมด</option>
                        @foreach(\App\Models\Institution::all() as $inst)
                            <option value="{{ $inst->id }}" {{ ($institution_id ?? '')==$inst->id ? 'selected' : '' }}>
                                {{ $inst->institution_name }}
                            </option>
                        @endforeach
                    </select>
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

             {{-- <!-- ปี พ.ศ. -->
            <div class="col-md-2">
                <label>ปี พ.ศ.</label>
                <select name="year" class="form-select">
                    <option value="">ทั้งหมด</option>
                    @for($y=2550; $y<=date('Y')+543; $y++)
                        <option value="{{ $y }}" {{ ($year ?? '')==$y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div> --}}

         <div class="row mb-3 mt-3">
    <!-- ปี พ.ศ. เริ่มต้น -->
    <div class="col-md-2">
        <label>ปี พ.ศ. เริ่มต้น</label>
        <select name="year_min" class="form-select">
            <option value="">ทั้งหมด</option>
            @for($y = date('Y')+543; $y >= 2550; $y--)
                <option value="{{ $y }}" {{ ($yearMin ?? '')==$y ? 'selected' : '' }}>{{ $y }}</option>
            @endfor
        </select>
    </div>

    <!-- ปี พ.ศ. สิ้นสุด -->
    <div class="col-md-2">
        <label>ปี พ.ศ. สิ้นสุด</label>
        <select name="year_max" class="form-select">
            <option value="">ทั้งหมด</option>
            @for($y = date('Y')+543; $y >= 2550; $y--)
                <option value="{{ $y }}" {{ ($yearMax ?? '')==$y ? 'selected' : '' }}>{{ $y }}</option>
            @endfor
        </select>
    </div>

    <!-- เดือน -->
    <div class="col-md-2">
        <label>เดือน</label>
        <select name="month" class="form-select">
            <option value="">ทั้งหมด</option>
            @php
                $months = [
                    1 => 'มกราคม', 2 => 'กุมภาพันธ์', 3 => 'มีนาคม',
                    4 => 'เมษายน', 5 => 'พฤษภาคม', 6 => 'มิถุนายน',
                    7 => 'กรกฎาคม', 8 => 'สิงหาคม', 9 => 'กันยายน',
                    10 => 'ตุลาคม', 11 => 'พฤศจิกายน', 12 => 'ธันวาคม'
                ];
            @endphp
            @foreach($months as $num => $name)
                <option value="{{ $num }}" {{ ($month ?? '')==$num ? 'selected' : '' }}>
                    {{ $name }}
                </option>
            @endforeach
        </select>
    </div>
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
    </div>
</div>

    <!-- Card -->
        <div class="row g-3">
            <!-- จำนวนทั้งหมด -->
            <div class="col-md-4">
                <div class="card text-white shadow-sm border-0 rounded-4"  
                    style="background: linear-gradient(135deg, #90caf9 0%, #42a5f5 100%);">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i data-feather="users" class="feather-36"></i>
                        </div>
                        <h6 class="fw-semibold">จำนวนทั้งหมด</h6>
                        <p class="fs-28 fw-bold mb-0">{{ $clients->count() ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <!-- ชาย -->
            <div class="col-md-4">
                <div class="card text-white shadow-sm border-0 rounded-4"  
                    style="background: linear-gradient(135deg, #a5d6a7 0%, #66bb6a 100%);">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i data-feather="user" class="feather-36"></i>
                        </div>
                        <h6 class="fw-semibold">ชาย</h6>
                        <p class="fs-28 fw-bold mb-0">{{ $maleCount ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <!-- หญิง -->
            <div class="col-md-4">
                <div class="card text-white shadow-sm border-0 rounded-4"  
                    style="background: linear-gradient(135deg, #f48fb1 0%, #f06292 100%);">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i data-feather="user-check" class="feather-36"></i>
                        </div>
                        <h6 class="fw-semibold">หญิง</h6>
                        <p class="fs-28 fw-bold mb-0">{{ $femaleCount ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>
         <!--End Card -->
         

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