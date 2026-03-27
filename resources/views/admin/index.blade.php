@extends('admin.admin_master')

@section('admin')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<style>
    .dashboard-page {
        padding: 1.25rem 0 1.5rem;
    }

    .dashboard-hero {
        position: relative;
        overflow: hidden;
        border-radius: 24px;
        padding: 1.5rem 1.5rem;
        margin-bottom: 1.25rem;
        background:
            radial-gradient(circle at top right, rgba(255,255,255,.22), transparent 28%),
            linear-gradient(135deg, #0f4c81 0%, #1368aa 48%, #1e88e5 100%);
        color: #fff;
        box-shadow: 0 18px 40px rgba(15, 76, 129, .18);
    }

    .dashboard-hero::after {
        content: "";
        position: absolute;
        right: -60px;
        top: -60px;
        width: 220px;
        height: 220px;
        background: rgba(255,255,255,.08);
        border-radius: 50%;
    }

    .dashboard-hero::before {
        content: "";
        position: absolute;
        left: -40px;
        bottom: -60px;
        width: 180px;
        height: 180px;
        background: rgba(255,255,255,.06);
        border-radius: 50%;
    }

    .dashboard-hero-content {
        position: relative;
        z-index: 1;
    }

    .dashboard-hero-badge {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        background: rgba(255,255,255,.14);
        border: 1px solid rgba(255,255,255,.18);
        border-radius: 999px;
        padding: .45rem .8rem;
        font-size: .9rem;
        font-weight: 500;
        margin-bottom: .8rem;
    }

    .dashboard-hero-title {
        margin: 0;
        font-size: 2rem;
        font-weight: 700;
        line-height: 1.2;
        letter-spacing: -.02em;
    }

    .dashboard-hero-subtitle {
        margin: .55rem 0 0;
        color: rgba(255,255,255,.88);
        max-width: 820px;
        font-size: .98rem;
    }

    .dashboard-hero-actions {
        position: relative;
        z-index: 1;
        display: flex;
        justify-content: flex-end;
        align-items: flex-start;
        height: 100%;
    }

    .dashboard-btn-pill {
        display: inline-flex;
        align-items: center;
        gap: .55rem;
        border-radius: 999px;
        padding: .8rem 1.15rem;
        font-weight: 600;
        box-shadow: 0 10px 20px rgba(0,0,0,.12);
    }

    .dashboard-card {
        border: 1px solid #e9eef5;
        border-radius: 20px;
        box-shadow: 0 10px 28px rgba(15, 23, 42, .05);
        overflow: hidden;
        background: #fff;
    }

    .dashboard-card .card-header {
        border-bottom: 1px solid #edf1f5;
        background: #fff;
        padding: 1rem 1.15rem;
    }

    .dashboard-card .card-body {
        padding: 1.1rem 1.15rem;
    }

    .section-title {
        margin: 0;
        font-size: 1.05rem;
        font-weight: 700;
        color: #172b4d;
    }

    .section-subtitle {
        margin: .15rem 0 0;
        color: #6b7280;
        font-size: .88rem;
    }

    .alert-appointment-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .alert-chip {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        border-radius: 999px;
        background: #eff6ff;
        color: #1d4ed8;
        padding: .35rem .7rem;
        font-size: .84rem;
        font-weight: 600;
    }

    .appointment-table {
        margin-bottom: 0;
    }

    .appointment-table thead th {
        background: #f8fafc;
        color: #334155;
        font-weight: 700;
        border-bottom-color: #e5e7eb;
        white-space: nowrap;
    }

    .appointment-table tbody td {
        vertical-align: middle;
    }

    .appointment-date {
        color: #b91c1c;
        font-weight: 700;
    }

    .mini-stat-card {
        height: 100%;
        border: 1px solid #e8edf3;
        border-radius: 20px;
        padding: 1rem;
        background: linear-gradient(180deg, #ffffff 0%, #fbfdff 100%);
        box-shadow: 0 8px 22px rgba(15, 23, 42, .04);
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .mini-stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 14px 28px rgba(15, 23, 42, .08);
    }

    .mini-stat-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: .75rem;
        margin-bottom: .85rem;
    }

    .mini-stat-icon {
        width: 52px;
        height: 52px;
        border-radius: 16px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        color: #fff;
        flex: 0 0 52px;
    }

    .mini-stat-icon.absent { background: linear-gradient(135deg, #ef4444, #f97316); }
    .mini-stat-icon.accident { background: linear-gradient(135deg, #f59e0b, #fbbf24); }
    .mini-stat-icon.escape { background: linear-gradient(135deg, #2563eb, #38bdf8); }

    .mini-stat-label {
        margin: 0;
        color: #111827;
        font-size: .98rem;
        font-weight: 700;
    }

    .mini-stat-date {
        margin: .15rem 0 0;
        color: #6b7280;
        font-size: .82rem;
    }

    .mini-stat-number {
        font-size: 2rem;
        font-weight: 800;
        line-height: 1;
        margin-bottom: .7rem;
    }

    .mini-stat-number.absent { color: #dc2626; }
    .mini-stat-number.accident { color: #d97706; }
    .mini-stat-number.escape { color: #1d4ed8; }

    .name-list {
        display: flex;
        flex-wrap: wrap;
        gap: .45rem;
    }

    .name-pill {
        display: inline-flex;
        align-items: center;
        padding: .32rem .65rem;
        border-radius: 999px;
        background: #f3f4f6;
        color: #374151;
        font-size: .84rem;
        font-weight: 500;
    }

    .filter-card {
        border: 1px solid #e8edf3;
        border-radius: 22px;
        background: linear-gradient(180deg, #ffffff 0%, #fcfdff 100%);
        box-shadow: 0 12px 26px rgba(15, 23, 42, .05);
        margin-top: 1.25rem;
        margin-bottom: 1.25rem;
    }

    .filter-card .card-body {
        padding: 1.2rem;
    }

    .filter-title {
        font-size: 1.02rem;
        font-weight: 700;
        color: #172b4d;
        margin-bottom: .2rem;
    }

    .filter-subtitle {
        color: #6b7280;
        font-size: .88rem;
        margin-bottom: 1rem;
    }

    .filter-section-label {
        font-size: .92rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: .55rem;
    }

    .filter-card .form-label {
        font-weight: 600;
        color: #334155;
        margin-bottom: .4rem;
    }

    .filter-card .form-control,
    .filter-card .form-select {
        min-height: 44px;
        border-radius: 12px;
        border-color: #dbe3ec;
        box-shadow: none !important;
    }

    .filter-card .form-control:focus,
    .filter-card .form-select:focus {
        border-color: #60a5fa;
    }

    .status-radio-group {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem 1.5rem;
        padding: .25rem 0;
    }

    .status-radio-group .form-check {
        margin: 0;
    }

    .status-radio-group .form-check-input {
        box-shadow: none;
    }

    .status-radio-group .form-check-label {
        font-weight: 500;
        color: #334155;
    }

    .filter-divider {
        border-top: 1px dashed #dbe3ec;
        margin: 1rem 0 1.1rem;
    }

    .filter-actions {
        display: flex;
        flex-wrap: wrap;
        gap: .75rem;
        align-items: center;
    }

    .filter-submit-btn {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        padding: .8rem 1.15rem;
        border-radius: 14px;
        font-weight: 700;
    }

    .metric-card {
        position: relative;
        overflow: hidden;
        border-radius: 22px;
        padding: 1.15rem 1rem;
        color: #fff;
        box-shadow: 0 16px 30px rgba(15, 23, 42, .08);
        height: 100%;
    }

    .metric-card::after {
        content: "";
        position: absolute;
        top: -30px;
        right: -30px;
        width: 120px;
        height: 120px;
        background: rgba(255,255,255,.12);
        border-radius: 50%;
    }

    .metric-card .metric-icon {
        width: 56px;
        height: 56px;
        border-radius: 18px;
        background: rgba(255,255,255,.18);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
    }

    .metric-card .metric-label {
        margin: 0 0 .3rem;
        font-size: .95rem;
        font-weight: 600;
        opacity: .95;
    }

    .metric-card .metric-value {
        margin: 0;
        font-size: 2rem;
        font-weight: 800;
        line-height: 1;
    }

    .metric-card.metric-total {
        background: linear-gradient(135deg, #3b82f6, #60a5fa);
    }

    .metric-card.metric-male {
        background: linear-gradient(135deg, #16a34a, #4ade80);
    }

    .metric-card.metric-female {
        background: linear-gradient(135deg, #ec4899, #f472b6);
    }

    .chart-card .card-header,
    .table-card .card-header {
        padding: 1rem 1.15rem;
    }

    .chart-card .card-body,
    .table-card .card-body {
        padding: 1.15rem;
    }

    .widget-icon-box {
        width: 42px;
        height: 42px;
        border-radius: 14px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #eff6ff;
        color: #2563eb;
        border: 1px solid #dbeafe;
        flex: 0 0 42px;
    }

    .chart-title-wrap {
        display: flex;
        align-items: center;
        gap: .75rem;
    }

    .chart-panel {
        min-height: 360px;
    }

    .table-card .table {
        margin-bottom: 0;
    }

    .table-card .table thead th {
        background: #f8fafc;
        color: #334155;
        font-weight: 700;
        border-bottom-color: #e5e7eb;
        white-space: nowrap;
    }

    .table-card .table tbody td {
        vertical-align: middle;
    }

    .table-student-name {
        font-weight: 600;
        color: #111827;
    }

    .table-muted {
        color: #6b7280;
    }

    .dashboard-empty {
        padding: 1rem;
        text-align: center;
        color: #6b7280;
    }

    #clientsTable_wrapper .dataTables_length select,
    #clientsTable_wrapper .dataTables_filter input {
        border-radius: 10px;
        border: 1px solid #dbe3ec;
        min-height: 38px;
        padding: .35rem .65rem;
        box-shadow: none !important;
    }

    #clientsTable_wrapper .dataTables_info,
    #clientsTable_wrapper .dataTables_paginate,
    #clientsTable_wrapper .dataTables_filter,
    #clientsTable_wrapper .dataTables_length {
        font-size: .88rem;
        color: #475569;
        margin-top: .55rem;
    }

    @media (max-width: 991.98px) {
        .dashboard-hero {
            padding: 1.25rem;
        }

        .dashboard-hero-title {
            font-size: 1.6rem;
        }

        .dashboard-hero-actions {
            justify-content: flex-start;
            margin-top: 1rem;
        }
    }

    @media (max-width: 767.98px) {
        .dashboard-page {
            padding-top: .85rem;
        }

        .dashboard-hero {
            border-radius: 20px;
            padding: 1rem;
        }

        .dashboard-hero-title {
            font-size: 1.35rem;
        }

        .dashboard-hero-subtitle {
            font-size: .92rem;
        }

        .dashboard-btn-pill {
            width: 100%;
            justify-content: center;
        }

        .filter-card .card-body,
        .dashboard-card .card-body,
        .chart-card .card-body,
        .table-card .card-body {
            padding: 1rem;
        }

        .status-radio-group {
            gap: .85rem 1rem;
        }

        .metric-card .metric-value {
            font-size: 1.7rem;
        }

        .chart-panel {
            min-height: 300px;
        }
    }
</style>

<div class="content">
    <div class="container-fluid dashboard-page">

        @php
            $thaiDate = \Carbon\Carbon::parse($today)->locale('th');
            $day = $thaiDate->translatedFormat('j');
            $month = $thaiDate->translatedFormat('F');
            $year = $thaiDate->year + 543;
        @endphp

        <div class="dashboard-hero">
            <div class="row align-items-center g-3">
                <div class="col-lg-8">
                    <div class="dashboard-hero-content">
                        <div class="dashboard-hero-badge">
                            <i class="bi bi-shield-check"></i>
                            <span>Social Welfare Intelligence Dashboard</span>
                        </div>
                        <h1 class="dashboard-hero-title">
                            ระบบฐานข้อมูลเด็กและสวัสดิการสังคม
                        </h1>
                        <p class="dashboard-hero-subtitle">
                            ศูนย์กลางสำหรับติดตามสถานะผู้รับบริการ การนัดหมายทางการแพทย์ สถิติการศึกษา
                            และข้อมูลเชิงวิเคราะห์เพื่อการดูแลอย่างเป็นระบบ
                        </p>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="dashboard-hero-actions">
                        <a href="{{ route('client.show') }}"
                           class="btn btn-light dashboard-btn-pill">
                            <i data-feather="arrow-right-circle"></i>
                            <span>แสดงรายชื่อผู้รับบริการ</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card dashboard-card mb-4">
            <div class="card-header">
                <div class="alert-appointment-header">
                    <div>
                        <h5 class="section-title mb-1">การแจ้งเตือนการพบแพทย์</h5>
                        <p class="section-subtitle mb-0">แสดงนัดหมายล่วงหน้า 5 วัน เพื่อเตรียมการดูแลและติดตามอย่างต่อเนื่อง</p>
                    </div>
                    <div class="alert-chip">
                        <i class="bi bi-calendar2-check"></i>
                        <span>{{ $appointmentCount }} รายการ</span>
                    </div>
                </div>
            </div>

            <div class="card-body">
                @if($appointmentCount > 0)
                    <div class="table-responsive">
                        <table class="table appointment-table align-middle">
                            <thead>
                                <tr>
                                    <th class="text-center">ชื่อ - สกุล</th>
                                    <th class="text-center">อายุ</th>
                                    <th class="text-center">ประเภทการนัด</th>
                                    <th class="text-center">วันที่นัด</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($appointments as $record)
                                    @php
                                        $dateObj  = \Carbon\Carbon::parse($record['date']);
                                        $daysDiff = $dateObj->diffInDays(\Carbon\Carbon::today());

                                        if ($daysDiff === 0) {
                                            $rowClass = 'table-danger fw-bold';
                                        } elseif ($daysDiff === 1) {
                                            $rowClass = 'table-warning fw-semibold';
                                        } else {
                                            $rowClass = 'table-success';
                                        }
                                    @endphp
                                    <tr class="{{ $rowClass }}">
                                        <td>{{ $record['fullname'] }}</td>
                                        <td class="text-center">{{ $record['age'] }} ปี</td>
                                        <td class="text-center">{{ $record['type'] }}</td>
                                        <td class="text-center appointment-date">
                                            {{ $dateObj->locale('th')->translatedFormat('d F') }}
                                            {{ $dateObj->year + 543 }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="dashboard-empty">
                        ไม่มีนัดหมายใน 5 วันถัดไป
                    </div>
                @endif
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-lg-4">
                <div class="mini-stat-card">
                    <div class="mini-stat-top">
                        <div>
                            <h6 class="mini-stat-label">การขาดเรียน</h6>
                            <p class="mini-stat-date">วันที่ {{ $day }} {{ $month }} {{ $year }}</p>
                        </div>
                        <div class="mini-stat-icon absent">
                            <i class="bi bi-journal-x"></i>
                        </div>
                    </div>

                    <div class="mini-stat-number absent">{{ $absentCount }} คน</div>

                    @if($absentCount > 0)
                        <div class="name-list">
                            @foreach($absentNames as $name)
                                <span class="name-pill">{{ $name }}</span>
                            @endforeach
                        </div>
                    @else
                        <div class="text-muted small">ไม่มีรายการในวันนี้</div>
                    @endif
                </div>
            </div>

            <div class="col-lg-4">
                <div class="mini-stat-card">
                    <div class="mini-stat-top">
                        <div>
                            <h6 class="mini-stat-label">การเจ็บป่วย</h6>
                            <p class="mini-stat-date">วันที่ {{ $day }} {{ $month }} {{ $year }}</p>
                        </div>
                        <div class="mini-stat-icon accident">
                            <i class="bi bi-heart-pulse"></i>
                        </div>
                    </div>

                    <div class="mini-stat-number accident">{{ $accidentCount }} คน</div>

                    @if($accidentCount > 0)
                        <div class="name-list">
                            @foreach($accidentNames as $name)
                                <span class="name-pill">{{ $name }}</span>
                            @endforeach
                        </div>
                    @else
                        <div class="text-muted small">ไม่มีรายการในวันนี้</div>
                    @endif
                </div>
            </div>

            <div class="col-lg-4">
                <div class="mini-stat-card">
                    <div class="mini-stat-top">
                        <div>
                            <h6 class="mini-stat-label">การออกโดยไม่ได้รับอนุญาต</h6>
                            <p class="mini-stat-date">วันที่ {{ $day }} {{ $month }} {{ $year }}</p>
                        </div>
                        <div class="mini-stat-icon escape">
                            <i class="bi bi-door-open"></i>
                        </div>
                    </div>

                    <div class="mini-stat-number escape">{{ $escapeCount }} คน</div>

                    @if($escapeCount > 0)
                        <div class="name-list">
                            @foreach($escapeNames as $name)
                                <span class="name-pill">{{ $name }}</span>
                            @endforeach
                        </div>
                    @else
                        <div class="text-muted small">ไม่มีรายการในวันนี้</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="card filter-card">
            <div class="card-body">
                <div class="filter-title">แผงตัวกรองข้อมูลเชิงสถิติ</div>
                <div class="filter-subtitle">เลือกช่วงข้อมูลที่ต้องการ เพื่อประมวลผลผลลัพธ์ให้ตรงตามวัตถุประสงค์</div>

                <form method="GET" action="{{ route('statistics.index') }}">
                    <div class="filter-section-label">สถานะผู้รับบริการ</div>

                    <div class="status-radio-group">
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

                    <div class="filter-divider"></div>

                    <div class="row g-3">
                        <div class="col-md-3 col-lg-2">
                            <label class="form-label">เพศ</label>
                            <select name="gender" class="form-select">
                                <option value="">ทั้งหมด</option>
                                <option value="male" {{ ($gender ?? '')=='male'?'selected':'' }}>ชาย</option>
                                <option value="female" {{ ($gender ?? '')=='female'?'selected':'' }}>หญิง</option>
                            </select>
                        </div>

                        <div class="col-md-3 col-lg-2">
                            <label class="form-label">อายุต่ำสุด</label>
                            <input type="number" name="age_min" class="form-control" value="{{ $ageMin ?? 1 }}" min="1" max="99">
                        </div>

                        <div class="col-md-3 col-lg-2">
                            <label class="form-label">อายุสูงสุด</label>
                            <input type="number" name="age_max" class="form-control" value="{{ $ageMax ?? 99 }}" min="1" max="99">
                        </div>

                        <div class="col-md-6 col-lg-3">
                            <label class="form-label">สถานศึกษา</label>
                            <select name="institution_id" class="form-select">
                                <option value="">ทั้งหมด</option>
                                @foreach(\App\Models\Institution::all() as $inst)
                                    <option value="{{ $inst->id }}" {{ ($institution_id ?? '')==$inst->id ? 'selected' : '' }}>
                                        {{ $inst->institution_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 col-lg-3">
                            <label class="form-label">ระดับการศึกษา</label>
                            <select name="education" class="form-select">
                                <option value="">ทั้งหมด</option>
                                @foreach(\App\Models\Education::all() as $edu)
                                    <option value="{{ $edu->id }}" {{ ($education ?? '')==$edu->id ? 'selected' : '' }}>
                                        {{ $edu->education_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="filter-divider"></div>

                    @php
                        $months = [
                            1 => 'มกราคม', 2 => 'กุมภาพันธ์', 3 => 'มีนาคม',
                            4 => 'เมษายน', 5 => 'พฤษภาคม', 6 => 'มิถุนายน',
                            7 => 'กรกฎาคม', 8 => 'สิงหาคม', 9 => 'กันยายน',
                            10 => 'ตุลาคม', 11 => 'พฤศจิกายน', 12 => 'ธันวาคม'
                        ];
                    @endphp

                    <div class="row g-3">
                        <div class="col-md-6 col-lg-4">
                            <label class="form-label">สภาพปัญหา</label>
                            <select name="problem" class="form-select">
                                <option value="">ทั้งหมด</option>
                                @foreach($problems as $prob)
                                    <option value="{{ $prob->id }}" {{ request('problem')==$prob->id ? 'selected' : '' }}>
                                        {{ $prob->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3 col-lg-2">
                            <label class="form-label">เดือนเริ่มต้น</label>
                            <select name="start_month" class="form-select">
                                <option value="">ทั้งหมด</option>
                                @foreach($months as $num => $name)
                                    <option value="{{ $num }}" {{ ($startMonth ?? '')==$num ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3 col-lg-2">
                            <label class="form-label">ปี พ.ศ. เริ่มต้น</label>
                            <select name="start_year" class="form-select">
                                <option value="">ทั้งหมด</option>
                                @for($y = date('Y')+543; $y >= 2550; $y--)
                                    <option value="{{ $y }}" {{ ($startYear ?? '')==$y ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="col-md-3 col-lg-2">
                            <label class="form-label">เดือนสิ้นสุด</label>
                            <select name="end_month" class="form-select">
                                <option value="">ทั้งหมด</option>
                                @foreach($months as $num => $name)
                                    <option value="{{ $num }}" {{ ($endMonth ?? '')==$num ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3 col-lg-2">
                            <label class="form-label">ปี พ.ศ. สิ้นสุด</label>
                            <select name="end_year" class="form-select">
                                <option value="">ทั้งหมด</option>
                                @for($y = date('Y')+543; $y >= 2550; $y--)
                                    <option value="{{ $y }}" {{ ($endYear ?? '')==$y ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="filter-actions mt-4">
                        <button type="submit" class="btn btn-primary filter-submit-btn shadow-sm">
                            <i data-feather="search"></i>
                            <span>ประมวลผลข้อมูล</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="metric-card metric-total">
                    <div class="metric-icon">
                        <i data-feather="users" class="feather-36"></i>
                    </div>
                    <p class="metric-label">จำนวนทั้งหมด</p>
                    <p class="metric-value">{{ $clients->count() ?? 0 }}</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="metric-card metric-male">
                    <div class="metric-icon">
                        <i data-feather="user" class="feather-36"></i>
                    </div>
                    <p class="metric-label">ชาย</p>
                    <p class="metric-value">{{ $maleCount ?? 0 }}</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="metric-card metric-female">
                    <div class="metric-icon">
                        <i data-feather="user-check" class="feather-36"></i>
                    </div>
                    <p class="metric-label">หญิง</p>
                    <p class="metric-value">{{ $femaleCount ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="row g-4 mt-1">
            <div class="col-xl-6">
                <div class="card dashboard-card chart-card h-100">
                    <div class="card-header">
                        <div class="chart-title-wrap">
                            <div class="widget-icon-box">
                                <i data-feather="pie-chart"></i>
                            </div>
                            <div>
                                <h5 class="section-title mb-1">กราฟสัดส่วนเพศ</h5>
                                <p class="section-subtitle mb-0">แสดงสัดส่วนผู้รับบริการชายและหญิง</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body chart-panel">
                        <div id="chartGender" class="apex-charts"></div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6">
                <div class="card dashboard-card chart-card h-100">
                    <div class="card-header">
                        <div class="chart-title-wrap">
                            <div class="widget-icon-box">
                                <i data-feather="bar-chart"></i>
                            </div>
                            <div>
                                <h5 class="section-title mb-1">กราฟระดับการศึกษา</h5>
                                <p class="section-subtitle mb-0">สรุปจำนวนผู้รับบริการตามระดับการศึกษา</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body chart-panel">
                        <div id="chartEducation" class="apex-charts"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card dashboard-card table-card">
                    <div class="card-header">
                        <div>
                            <h5 class="section-title mb-1">ตารางข้อมูลผู้รับบริการ</h5>
                            <p class="section-subtitle mb-0">ข้อมูลเชิงรายละเอียดสำหรับการตรวจสอบและวิเคราะห์</p>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="clientsTable" class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th style="width:18%">ชื่อ</th>
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
                                            <td>
                                                <div class="table-student-name">{{ $c->fullname }}</div>
                                            </td>
                                            <td>
                                                @if($c->gender === 'male')
                                                    ชาย
                                                @elseif($c->gender === 'female')
                                                    หญิง
                                                @else
                                                    <span class="table-muted">-</span>
                                                @endif
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($c->birth_date)->age }}</td>

                                            @if($c->educationRecords->isNotEmpty())
                                                <td>{{ $c->educationRecords->first()->education->education_name ?? '-' }}</td>
                                                <td>{{ $c->educationRecords->first()->semester->semester_name ?? '-' }}</td>
                                                <td>{{ $c->educationRecords->first()->school_name ?? '-' }}</td>
                                            @else
                                                <td class="table-muted">-</td>
                                                <td class="table-muted">-</td>
                                                <td class="table-muted">-</td>
                                            @endif
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">ไม่มีข้อมูล</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
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
    if (document.querySelector("#chartGender")) {
        var optionsGender = {
            chart: { type: 'donut', height: 360, toolbar: { show: false } },
            series: [{{ $maleCount ?? 0 }}, {{ $femaleCount ?? 0 }}],
            labels: ['ชาย','หญิง'],
            colors: ['#16a34a','#ec4899'],
            legend: {
                position: 'bottom',
                fontFamily: 'Kanit, sans-serif'
            },
            dataLabels: { enabled: true },
            stroke: { width: 0 }
        };
        new ApexCharts(document.querySelector("#chartGender"), optionsGender).render();
    }

    if (document.querySelector("#chartEducation")) {
        var optionsEducation = {
            chart: { type: 'bar', height: 360, toolbar: { show: false } },
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
                ],
                labels: {
                    style: { fontFamily: 'Kanit, sans-serif' }
                }
            },
            yaxis: {
                labels: {
                    style: { fontFamily: 'Kanit, sans-serif' }
                }
            },
            colors: ['#2563eb'],
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '48%',
                    borderRadius: 8
                }
            },
            dataLabels: { enabled: true },
            grid: { borderColor: '#e5e7eb' }
        };
        new ApexCharts(document.querySelector("#chartEducation"), optionsEducation).render();
    }

    $('#clientsTable').DataTable({
        destroy: true,
        responsive: true,
        autoWidth: false,
        pageLength: 10,
        order: [[0, 'asc']],
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

    if ($.fn.datepicker && $('.datepicker-th').length) {
        $('.datepicker-th').datepicker({
            format: 'dd/mm/yyyy',
            language: 'th',
            thaiyear: true,
            autoclose: true,
            todayHighlight: true
        });
    }

    if (window.feather) {
        feather.replace();
    }
});
</script>

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