@extends('admin_client.admin_client')

@section('content')
<div class="container-fluid py-4">

    <!-- หัวข้อ -->
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h2 class="fw-bold text-primary">ข้อมูลผู้รับบริการ</h2>
            <p class="text-muted">รายละเอียดเฉพาะรายของผู้รับบริการ</p>
            <hr class="w-25 mx-auto border-primary">
        </div>
    </div>

    <!-- การ์ดข้อมูลผู้รับบริการ -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <div class="row g-4 align-items-center">
                <div class="col-md-4 text-center">
                    <!-- รูปโปรไฟล์ -->
                    @php
                        $imagePath = public_path('upload/client_images/' . $client->image);
                    @endphp
                    @if(!empty($client->image) && file_exists($imagePath))
                        <img src="{{ asset('upload/client_images/' . $client->image) }}"
                             alt="โปรไฟล์ผู้รับบริการ"
                             class="rounded-circle shadow-sm mb-3"
                             style="width:150px; height:150px; object-fit:cover;">
                    @else
                        <img src="{{ asset('upload/no_image.jpg') }}"
                             alt="ไม่มีภาพ"
                             class="rounded-circle shadow-sm mb-3"
                             style="width:150px; height:150px; object-fit:cover;">
                    @endif

                    <h4 class="fw-bold text-dark">{{ $client->fullname ?? 'ไม่ระบุ' }}</h4>

                 <p class="text-muted">
                    {{-- วันเกิด:  --}}
                    @if(!empty($client->birth_date))
                        {{-- {{ \Carbon\Carbon::parse($client->birth_date)->locale('th')->translatedFormat('d F') }}
                        {{ \Carbon\Carbon::parse($client->birth_date)->year + 543 }} --}}
                        (อายุ {{ \Carbon\Carbon::parse($client->birth_date)->age }} ปี)
                    @else
                        ไม่ระบุ
                    @endif
                </p>

                </div>
                <div class="col-md-8">
                    <h5 class="fw-semibold text-secondary mb-3">รายละเอียด</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                    วันที่รับเข้า: 
                    <span class="fw-bold">
                        @if(!empty($client->arrival_date))
                        {{ \Carbon\Carbon::parse($client->arrival_date)->locale('th')->translatedFormat('d F') }}
                        {{ \Carbon\Carbon::parse($client->arrival_date)->year + 543 }}
                    @else
                        ไม่ระบุ
                    @endif


                    </span>
                </li>

            <li class="list-group-item">
                วันเกิด: 
                <span class="fw-bold">
                    @if(!empty($client->birth_date))
                        {{ \Carbon\Carbon::parse($client->birth_date)->locale('th')->translatedFormat('d F') }}
                        {{ \Carbon\Carbon::parse($client->birth_date)->year + 543 }}
                    @else
                        ไม่ระบุ
                    @endif
                </span>
            </li>
            <li class="list-group-item">
                ระดับการศึกษา:
                <span class="fw-bold">
                    {{ $client->educationRecords->first()->education->education_name ?? 'ไม่ระบุ' }}
                </span>
            </li>

            <li class="list-group-item">
                สถานศึกษา:
                <span class="fw-bold">
                    {{ $client->educationRecords->first()->institution->institution_name ?? 'ไม่ระบุ' }}
                </span>
            </li>
        </ul>
                        </div>
                    </div>
                </div>
            </div>
<!-- สิ้นสุด การ์ดข้อมูลผู้รับบริการ -->
           
    <!-- การ์ดสถิติรายวัน -->
        <div class="row g-4">

        <!-- การพบแพทย์ -->
            <div class="col-md-4">
            <div class="card h-100 text-center shadow-sm border-0 bg-success-subtle">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title text-success fw-semibold">การพบแพทย์</h5>
                    <h2 class="fw-bold text-success">{{ $appointmentCount ?? 0 }}</h2>
                    <div class="mt-auto">
                        <p class="text-muted small">
                            @if($appointmentCount > 0)
                                <ul class="list-unstyled mt-2">
                                    @foreach($appointments as $record)
                                        <li>
                                            {{ $record['type'] }} นัดวันที่ 
                                            {{ \Carbon\Carbon::parse($record['date'])->locale('th')->translatedFormat('d F') }}
                                            {{ \Carbon\Carbon::parse($record['date'])->year + 543 }}
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                ไม่มีนัดหมาย
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

      <!-- พฤติกรรม -->
<div class="col-md-4">
    <div class="card h-100 text-center shadow-sm border-0 bg-warning-subtle">
        <div class="card-body d-flex flex-column">
            <h5 class="card-title text-warning fw-semibold">พฤติกรรม</h5>
            <h2 class="fw-bold text-danger">{{ $observeDate ? 1 : 0 }}</h2>
            <div class="mt-auto">
                <p class="text-muted small">
                    @php
                        // ถ้าไม่มีข้อมูล ให้ใช้วันที่ปัจจุบัน
                        $displayDate = $observeDate ?? $today;
                        $carbonDate  = \Carbon\Carbon::parse($displayDate)->locale('th');
                    @endphp

                    บันทึกล่าสุดวันที่ 
                    {{ $carbonDate->translatedFormat('d F') }}
                    {{ $carbonDate->year + 543 }}
                </p>
            </div>
        </div>
    </div>
</div>

        <!-- การบาดเจ็บ -->
        <div class="col-md-4">
            <div class="card h-100 text-center shadow-sm border-0 bg-danger-subtle">
                <div class="card-body d-flex flex-column">
                    <h6 class="fw-semibold text-dark">การบาดเจ็บ</h6>
                    <h2 class="fw-bold text-dark">{{ $accidentCount ?? 0 }}</h2>
                    <div class="mt-auto">
                        <p class="text-muted small">วันที่ {{ $day }} {{ $month }} {{ $year }}</p>
                        @if($accidentCount > 0)
                            <ul class="list-unstyled mt-2">
                                @foreach($accidents as $accident)
                                    <li>
                                        บันทึกการบาดเจ็บวันที่ 
                                        {{ \Carbon\Carbon::parse($accident->incident_date)->locale('th')->translatedFormat('d F') }}
                                        {{ \Carbon\Carbon::parse($accident->incident_date)->year + 543 }}
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            ไม่มีข้อมูลการบาดเจ็บ
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
   <!--สิ้นสุด การ์ดสถิติรายวัน -->

        <div class="container-fluid mt-5">
            <div class="row mb-4">
                <div class="col-12 text-center">
                    <h3 class="fw-bold text-primary">เลือกบริการ</h3>
                    <p class="text-muted">รายละเอียดเฉพาะรายของผู้รับบริการ</p>
                    <hr class="w-25 mx-auto border-primary">
                </div>
            </div>

            <div class="row g-4">
                <!-- การ์ด 1 -->
                <div class="col-md-4 col-sm-6">
                    <div class="card h-100 text-center shadow-lg border-0 rounded-5 hover-card">
                        <div class="card-body">
                            <div class="icon-circle bg-primary text-white mx-auto mb-3">
                                <i class="bi bi-grid-fill fs-2"></i>
                            </div>
                            <h6 class="fw-bold">รวมบริการทางภาษี</h6>
                            <p class="text-muted small">One Portal รวมทุกบริการภาษีในที่เดียว</p>
                        </div>
                    </div>
                </div>

                <!-- การ์ด 2 -->
                <div class="col-md-4 col-sm-6">
                    <div class="card h-100 text-center shadow-lg border-0 rounded-5 hover-card">
                        <div class="card-body">
                            <div class="icon-circle bg-success text-white mx-auto mb-3">
                                <i class="bi bi-file-earmark-text-fill fs-2"></i>
                            </div>
                            <h6 class="fw-bold">รายละเอียดบริการ</h6>
                            <p class="text-muted small">บริการยื่นแบบภาษีออนไลน์ ครบทุกประเภท</p>
                        </div>
                    </div>
                </div>

                <!-- การ์ด 3 -->
                <div class="col-md-4 col-sm-6">
                    <div class="card h-100 text-center shadow-lg border-0 rounded-5 hover-card">
                        <div class="card-body">
                            <div class="icon-circle bg-danger text-white mx-auto mb-3">
                                <i class="bi bi-heart-fill fs-2"></i>
                            </div>
                            <h6 class="fw-bold">ตรวจสอบเงินบริจาค</h6>
                            <p class="text-muted small">ตรวจสอบข้อมูลการบริจาคเพื่อสิทธิประโยชน์ทางภาษี</p>
                        </div>
                    </div>
                </div>

                <!-- การ์ด 4 -->
                <div class="col-md-4 col-sm-6">
                    <div class="card h-100 text-center shadow-lg border-0 rounded-5 hover-card">
                        <div class="card-body">
                            <div class="icon-circle bg-warning text-white mx-auto mb-3">
                                <i class="bi bi-cash-stack fs-2"></i>
                            </div>
                            <h6 class="fw-bold">คืนภาษีนักท่องเที่ยว</h6>
                            <p class="text-muted small">บริการตรวจสอบและคืนภาษีสำหรับนักท่องเที่ยว</p>
                        </div>
                    </div>
                </div>

                <!-- การ์ด 5 -->
                <div class="col-md-4 col-sm-6">
                    <div class="card h-100 text-center shadow-lg border-0 rounded-5 hover-card">
                        <div class="card-body">
                            <div class="icon-circle bg-info text-white mx-auto mb-3">
                                <i class="bi bi-pencil-square fs-2"></i>
                            </div>
                            <h6 class="fw-bold">ลงทะเบียนยื่นแบบ</h6>
                            <p class="text-muted small">ลงทะเบียนเพื่อใช้งานระบบยื่นแบบภาษีออนไลน์</p>
                        </div>
                    </div>
                </div>

                <!-- การ์ด 6 -->
                <div class="col-md-4 col-sm-6">
                    <div class="card h-100 text-center shadow-lg border-0 rounded-5 hover-card">
                        <div class="card-body">
                            <div class="icon-circle bg-secondary text-white mx-auto mb-3">
                                <i class="bi bi-receipt-cutoff fs-2"></i>
                            </div>
                            <h6 class="fw-bold">ใบกำกับภาษีและใบรับ</h6>
                            <p class="text-muted small">ออกใบกำกับภาษีและใบรับออนไลน์อย่างเป็นทางการ</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<!-- CSS เสริมสำหรับ hover effect และวงกลม -->
<style>
    .hover-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .hover-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    }
    .icon-circle {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
</style>

        @endsection