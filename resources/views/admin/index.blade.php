@extends('admin.admin_master')

@section('admin')

        <div class="content">
            <div class="container-fluid">
                <!-- Title -->
       <div class="mt-4 mb-4 d-flex justify-content-end">
    <!-- ปุ่มไปหน้า client.show -->
    <a href="{{ route('client.show') }}" 
       class="btn btn-primary btn-sm d-inline-flex align-items-center shadow px-3 w-auto rounded-3">
        <i data-feather="arrow-right-circle" class="me-2"></i>
        ไปยังหน้าหลัก
    </a>
</div>
   
        <!-- การ์ดแสดงการขาดเรียน การเจ็บป่วย และการออกโดยไม่ได้รับอนุญาต -->
        @php
            $thaiDate = \Carbon\Carbon::parse($today)->locale('th');
            $day = $thaiDate->translatedFormat('j'); // วัน
            $month = $thaiDate->translatedFormat('F'); // เดือนภาษาไทย
            $year = $thaiDate->year + 543; // ปี พ.ศ.
        @endphp

        <div class="row mt-4">
            <!-- การขาดเรียน -->
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm border-0 text-center">
                    <div class="card-body">
                        <h6 class="fw-semibold text-dark">การขาดเรียน</h6>
                        <p class="mb-1 text-muted">วันที่ {{ $day }} {{ $month }} {{ $year }}</p>


                        <span class="fw-bold text-danger fs-4">{{ $absentCount }} คน</span>
                        @if($absentCount > 0)
                            <ul class="list-unstyled mt-2">
                                @foreach($absentNames as $name)
                                    <li>{{ $name }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>

            <!-- การเจ็บป่วย -->
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm border-0 text-center">
                    <div class="card-body">
                        <h6 class="fw-semibold text-dark">การเจ็บป่วย</h6>
                        <p class="mb-1 text-muted">วันที่ {{ $day }} {{ $month }} {{ $year }}</p>
                        <span class="fw-bold text-warning fs-4">{{ $accidentCount }} คน</span>
                        @if($accidentCount > 0)
                            <ul class="list-unstyled mt-2">
                                @foreach($accidentNames as $name)
                                    <li>{{ $name }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>

            <!-- การออกโดยไม่ได้รับอนุญาต -->
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm border-0 text-center">
                    <div class="card-body">
                        <h6 class="fw-semibold text-dark">การออกโดยไม่ได้รับอนุญาต</h6>
                    <p class="mb-1 text-muted">วันที่ {{ $day }} {{ $month }} {{ $year }}</p>
                        <span class="fw-bold text-primary fs-4">{{ $escapeCount }} คน</span>
                        @if($escapeCount > 0)
                            <ul class="list-unstyled mt-2">
                                @foreach($escapeNames as $name)
                                    <li>{{ $name }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- สิ้นสุด การ์ดแสดงการขาดเรียน การเจ็บป่วย และการออกโดยไม่ได้รับอนุญาต -->

        <!-- Filter Form -->
        <form method="GET" action="{{ route('statistics.index') }}" class="row g-3 mb-4">

            <!-- สถานะผู้รับบริการ -->
            <div class="col-12">
                <label class="form-label fw-semibold text-dark mb-2">สถานะผู้รับบริการ</label>
                <div class="d-flex flex-wrap gap-4">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="release_status" id="statusAll" value="all"
                               {{ ($releaseStatus ?? '')=='all' ? 'checked' : '' }}>
                        <label class="form-check-label" for="statusAll">ทั้งหมด</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="release_status" id="statusShow" value="show"
                               {{ ($releaseStatus ?? '')=='show' ? 'checked' : '' }}>
                        <label class="form-check-label" for="statusShow">อยู่อาศัย</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="release_status" id="statusRefer" value="refer"
                               {{ ($releaseStatus ?? '')=='refer' ? 'checked' : '' }}>
                        <label class="form-check-label" for="statusRefer">ถูกจำหน่าย</label>
                    </div>
                </div>
            </div>

            <!-- เพศ -->
            <div class="col-md-2">
                <label class="form-label fw-semibold">เพศ</label>
                <select name="gender" class="form-select">
                    <option value="">ทั้งหมด</option>
                    <option value="male" {{ ($gender ?? '')=='male'?'selected':'' }}>ชาย</option>
                    <option value="female" {{ ($gender ?? '')=='female'?'selected':'' }}>หญิง</option>
                </select>
            </div>

            <!-- อายุ -->
            <div class="col-md-2">
                <label class="form-label fw-semibold">อายุต่ำสุด</label>
                <input type="number" name="age_min" class="form-control" value="{{ $ageMin ?? 1 }}" min="1" max="99">
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold">อายุสูงสุด</label>
                <input type="number" name="age_max" class="form-control" value="{{ $ageMax ?? 99 }}" min="1" max="99">
            </div>

            <!-- สถานศึกษา -->
            <div class="col-md-3">
                <label class="form-label fw-semibold">สถานศึกษา</label>
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
            <div class="col-md-3">
                <label class="form-label fw-semibold">ระดับการศึกษา</label>
                <select name="education" class="form-select">
                    <option value="">ทั้งหมด</option>
                    @foreach(\App\Models\Education::all() as $edu)
                        <option value="{{ $edu->id }}" {{ ($education ?? '')==$edu->id ? 'selected' : '' }}>
                            {{ $edu->education_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- สภาพปัญหา ปี พ.ศ. และ เดือน -->
            <div class="row mt-3">
                <div class="col-md-3">
                    <label class="form-label fw-semibold">สภาพปัญหา</label>
                    <select name="problem" class="form-select">
                        <option value="">ทั้งหมด</option>
                        @foreach($problems as $prob)
                            <option value="{{ $prob->id }}" {{ request('problem')==$prob->id ? 'selected' : '' }}>
                                {{ $prob->name }}   <!-- ✅ ใช้ name แทน problem_name -->
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold">ปี พ.ศ. เริ่มต้น</label>
                    <select name="year_min" class="form-select">
                        <option value="">ทั้งหมด</option>
                        @for($y = date('Y')+543; $y >= 2550; $y--)
                            <option value="{{ $y }}" {{ ($yearMin ?? '')==$y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">ปี พ.ศ. สิ้นสุด</label>
                    <select name="year_max" class="form-select">
                        <option value="">ทั้งหมด</option>
                        @for($y = date('Y')+543; $y >= 2550; $y--)
                            <option value="{{ $y }}" {{ ($yearMax ?? '')==$y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">เดือน</label>
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
    <!-- สิ้นสุด สภาพปัญหา ปี พ.ศ. และ เดือน -->

            <!-- ปุ่ม -->
            <div class="col-12 mt-4">
                <button type="submit"
                        class="btn btn-primary px-4 py-2 rounded-3 shadow-sm d-inline-flex align-items-center">
                    <i data-feather="search" class="me-2"></i>
                    <span class="fw-semibold">ประมวลผล</span>
                </button>
            </div>
        </form>
    </div>
</div>


    <!-- Card ประมวลผล-->
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
         <!--End Card ประมวลผล--> 
         

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