@extends('admin_client.admin_client')

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

@php
    use Carbon\Carbon;

    $profileImage = asset('upload/no_image.jpg');
    $imagePath = !empty($client->image) ? public_path('upload/client_images/' . $client->image) : null;

    if (!empty($client->image) && $imagePath && file_exists($imagePath)) {
        $profileImage = asset('upload/client_images/' . $client->image);
    }

    $birthDate = !empty($client->birth_date) ? Carbon::parse($client->birth_date) : null;
    $arrivalDate = !empty($client->arrival_date) ? Carbon::parse($client->arrival_date) : null;

    $educationRecord = $client->educationRecords->first();
    $educationName = $educationRecord->education->education_name ?? 'ไม่ระบุ';
    $institutionName = $educationRecord->institution->institution_name ?? 'ไม่ระบุ';

    $observeLatestCount = !empty($observeLatest) ? 1 : 0;
    $observeDateText = !empty($observeDate)
        ? Carbon::parse($observeDate)->locale('th')->translatedFormat('d F') . ' ' . (Carbon::parse($observeDate)->year + 543)
        : 'ไม่ระบุ';

    $todayText = ($day ?? '-') . ' ' . ($month ?? '-') . ' ' . ($year ?? '-');
@endphp

<div class="container-fluid client-page">

    {{-- Top Navigation / Back --}}
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <a href="{{ route('client.show') }}" class="btn btn-primary btn-back shadow-sm">
                <span class="btn-back-icon">
                    <i class="bi bi-arrow-left-short"></i>
                </span>
                <span>กลับหน้าหลัก</span>
            </a>
        </div>

        <div class="text-md-end">
            <div class="page-badge">
                <i class="bi bi-person-vcard me-2"></i>ข้อมูลผู้รับบริการ
            </div>
        </div>
    </div>

    {{-- Page Header --}}
    <div class="page-header-card mb-4">
        <div class="row align-items-center g-4">
            <div class="col-lg-8">
                <div class="section-kicker">Client Profile</div>
                <h1 class="page-title mb-2">ข้อมูลผู้รับบริการ</h1>
                <p class="page-subtitle mb-0">
                    แสดงรายละเอียดเฉพาะราย ข้อมูลพื้นฐาน และเมนูบริการที่เกี่ยวข้องอย่างเป็นระบบ
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="header-mini-stat">
                    <div class="mini-stat-label">วันที่เปิดดูข้อมูล</div>
                    <div class="mini-stat-value">{{ now()->locale('th')->translatedFormat('d F') }} {{ now()->year + 543 }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Profile Card --}}
    <div class="card profile-card border-0 shadow-sm mb-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="row g-0">
                <div class="col-xl-4 profile-left-panel text-center">
                    <div class="profile-avatar-wrap">
                        <img src="{{ $profileImage }}"
                             alt="โปรไฟล์ผู้รับบริการ"
                             class="profile-avatar">
                    </div>

                    <h3 class="profile-name mb-2">{{ $client->fullname ?? 'ไม่ระบุชื่อ' }}</h3>

                    <div class="profile-meta">
                        @if($birthDate)
                            อายุ {{ $birthDate->age }} ปี
                        @else
                            ไม่ระบุอายุ
                        @endif
                    </div>

                  <div class="profile-quick-tags mt-3">

                        {{-- 🔥 เลขทะเบียน --}}
                        <span class="quick-tag">
                            <i class="bi bi-person-badge me-1"></i>
                            เลขทะเบียน: {{ $client->register_number ?? '-' }}
                        </span>

                        {{-- 🔥 ระยะเวลาอยู่อาศัย --}}
                    <span class="quick-tag">
                        <i class="bi bi-calendar-check me-1"></i>ระยะเวลาอยู่อาศัย:

                        {{ $client->residence_duration ?? 'ไม่มีข้อมูลวันที่เข้าระบบ' }}
                    </span>

                    </div>
                </div>

                <div class="col-xl-8">
                    <div class="p-4 p-lg-5">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
                            <h5 class="detail-title mb-0">รายละเอียดข้อมูลพื้นฐาน</h5>
                            <span class="detail-status">
                                <i class="bi bi-check-circle-fill me-1"></i> อัปเดตข้อมูลแล้ว
                            </span>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label">ชื่อ - สกุล</div>
                                    <div class="info-value">{{ $client->fullname ?? 'ไม่ระบุ' }}</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label">วันเกิด</div>
                                    <div class="info-value">
                                        @if($birthDate)
                                            {{ $birthDate->locale('th')->translatedFormat('d F') }} {{ $birthDate->year + 543 }}
                                        @else
                                            ไม่ระบุ
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label">อายุ</div>
                                    <div class="info-value">
                                        @if($birthDate)
                                            {{ $birthDate->age }} ปี
                                        @else
                                            ไม่ระบุ
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label">วันที่รับเข้า</div>
                                    <div class="info-value">
                                        @if($arrivalDate)
                                            {{ $arrivalDate->locale('th')->translatedFormat('d F') }} {{ $arrivalDate->year + 543 }}
                                        @else
                                            ไม่ระบุ
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label">ระดับการศึกษา</div>
                                    <div class="info-value">{{ $educationName }}</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label">สถานศึกษา</div>
                                    <div class="info-value">{{ $institutionName }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="profile-note mt-4">
                            <i class="bi bi-info-circle me-2"></i>
                            ข้อมูลส่วนนี้ใช้สำหรับสรุปภาพรวมผู้รับบริการก่อนเข้าสู่เมนูรายละเอียดเชิงลึก
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Daily Stats --}}
    <div class="section-head mb-3">
        <div>
            <h4 class="section-title mb-1">สรุปข้อมูลล่าสุด</h4>
            <p class="section-subtitle mb-0">ภาพรวมกิจกรรมสำคัญของผู้รับบริการในระบบ</p>
        </div>
    </div>

    <div class="row g-4 mb-5">
        {{-- Appointment --}}
        <div class="col-lg-4">
            <div class="card stat-card stat-card-success border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="stat-icon">
                        <i class="bi bi-calendar2-check"></i>
                    </div>

                    <div class="stat-label">การพบแพทย์</div>
                    <div class="stat-number">{{ $appointmentCount ?? 0 }}</div>
                    <div class="stat-desc">จำนวนรายการนัดหมายที่เกี่ยวข้อง</div>

                    <div class="stat-list mt-4">
                        @if(!empty($appointmentCount) && $appointmentCount > 0)
                            <ul class="list-unstyled mb-0">
                                @foreach($appointments as $record)
                                    <li>
                                        <i class="bi bi-dot"></i>
                                        {{ $record['type'] ?? 'นัดหมาย' }}
                                        วันที่
                                        {{ Carbon::parse($record['date'])->locale('th')->translatedFormat('d F') }}
                                        {{ Carbon::parse($record['date'])->year + 543 }}
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="empty-text">ไม่มีนัดหมาย</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Behavior --}}
        <div class="col-lg-4">
            <div class="card stat-card stat-card-warning border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="stat-icon">
                        <i class="bi bi-clipboard2-pulse"></i>
                    </div>

                    <div class="stat-label">พฤติกรรม</div>
                    <div class="stat-number">{{ $observeLatestCount }}</div>
                    <div class="stat-desc">บันทึกพฤติกรรมล่าสุดในระบบ</div>

                    <div class="stat-list mt-4">
                        <div class="single-line-info">
                            <strong>บันทึกล่าสุด:</strong> {{ $observeDateText }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Accident --}}
        <div class="col-lg-4">
            <div class="card stat-card stat-card-danger border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="stat-icon">
                        <i class="bi bi-heart-pulse"></i>
                    </div>

                    <div class="stat-label">การบาดเจ็บ</div>
                    <div class="stat-number">{{ $accidentCount ?? 0 }}</div>
                    <div class="stat-desc">ข้อมูลการบาดเจ็บที่บันทึกในระบบ</div>

                    <div class="stat-list mt-4">
                        <div class="single-line-info mb-2">
                            <strong>อ้างอิงวันที่:</strong> {{ $todayText }}
                        </div>

                        @if(!empty($accidentCount) && $accidentCount > 0)
                            <ul class="list-unstyled mb-0">
                                @foreach($accidents as $accident)
                                    <li>
                                        <i class="bi bi-dot"></i>
                                        บันทึกการบาดเจ็บวันที่
                                        {{ Carbon::parse($accident->incident_date)->locale('th')->translatedFormat('d F') }}
                                        {{ Carbon::parse($accident->incident_date)->year + 543 }}
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="empty-text">ไม่มีข้อมูลการบาดเจ็บ</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Services --}}
    <div class="section-head mb-3">
        <div>
            <h4 class="section-title mb-1">เลือกบริการ</h4>
            <p class="section-subtitle mb-0">เมนูหลักสำหรับเข้าถึงบริการและข้อมูลที่เกี่ยวข้องกับผู้รับบริการ</p>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-xl-4 col-md-6">
            <div class="card service-card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="service-icon bg-primary-subtle text-primary">
                        <i class="bi bi-grid-1x2-fill"></i>
                    </div>
                    <h5 class="service-title">ข้อมูลภาพรวม</h5>
                    <p class="service-text">ดูรายละเอียดเบื้องต้นของผู้รับบริการ ประวัติ และข้อมูลสรุปในระบบ</p>
                    <a href="javascript:void(0)" class="service-link">
                        เข้าสู่เมนู <i class="bi bi-arrow-right-short"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="card service-card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="service-icon bg-success-subtle text-success">
                        <i class="bi bi-journal-text"></i>
                    </div>
                    <h5 class="service-title">บันทึกการให้บริการ</h5>
                    <p class="service-text">ติดตามข้อมูลการให้บริการ การประเมิน และประวัติการดูแลแต่ละรายการ</p>
                    <a href="javascript:void(0)" class="service-link">
                        เข้าสู่เมนู <i class="bi bi-arrow-right-short"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="card service-card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="service-icon bg-danger-subtle text-danger">
                        <i class="bi bi-heart-pulse-fill"></i>
                    </div>
                    <h5 class="service-title">สุขภาพและการรักษา</h5>
                    <p class="service-text">ตรวจสอบข้อมูลด้านสุขภาพ การนัดหมาย และประวัติการรักษาที่เกี่ยวข้อง</p>
                    <a href="javascript:void(0)" class="service-link">
                        เข้าสู่เมนู <i class="bi bi-arrow-right-short"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="card service-card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="service-icon bg-warning-subtle text-warning">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <h5 class="service-title">ครอบครัวและผู้เกี่ยวข้อง</h5>
                    <p class="service-text">รวมข้อมูลผู้ปกครอง ญาติ บุคคลอ้างอิง และความสัมพันธ์ที่เกี่ยวข้อง</p>
                    <a href="javascript:void(0)" class="service-link">
                        เข้าสู่เมนู <i class="bi bi-arrow-right-short"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="card service-card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="service-icon bg-info-subtle text-info">
                        <i class="bi bi-file-earmark-bar-graph-fill"></i>
                    </div>
                    <h5 class="service-title">รายงานและสรุปผล</h5>
                    <p class="service-text">จัดทำรายงานผล รายละเอียดการติดตาม และเอกสารสรุปสำหรับใช้งานต่อ</p>
                    <a href="javascript:void(0)" class="service-link">
                        เข้าสู่เมนู <i class="bi bi-arrow-right-short"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="card service-card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="service-icon bg-secondary-subtle text-secondary">
                        <i class="bi bi-gear-fill"></i>
                    </div>
                    <h5 class="service-title">จัดการข้อมูล</h5>
                    <p class="service-text">แก้ไข ปรับปรุง และดูแลข้อมูลผู้รับบริการให้ถูกต้องและเป็นปัจจุบันอยู่เสมอ</p>
                    <a href="javascript:void(0)" class="service-link">
                        เข้าสู่เมนู <i class="bi bi-arrow-right-short"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .client-page {
        background: linear-gradient(180deg, #f8fbff 0%, #f4f7fb 100%);
        min-height: 100vh;
    }

    .btn-back {
        border-radius: 999px;
        padding: 0.65rem 1.15rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: .55rem;
    }

    .btn-back-icon {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: rgba(255,255,255,.18);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
    }

    .page-badge {
        display: inline-flex;
        align-items: center;
        padding: .55rem 1rem;
        border-radius: 999px;
        background: #ffffff;
        border: 1px solid rgba(13,110,253,.12);
        color: #0d6efd;
        font-weight: 600;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.05);
    }

    .page-header-card {
        background: linear-gradient(135deg, #ffffff 0%, #f7faff 100%);
        border: 1px solid rgba(13,110,253,.08);
        border-radius: 24px;
        padding: 2rem;
        box-shadow: 0 20px 45px rgba(15, 23, 42, 0.06);
    }

    .section-kicker {
        display: inline-block;
        font-size: .8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .08em;
        color: #0d6efd;
        background: rgba(13,110,253,.08);
        padding: .45rem .8rem;
        border-radius: 999px;
        margin-bottom: 1rem;
    }

    .page-title {
        font-size: clamp(1.7rem, 2vw, 2.4rem);
        font-weight: 800;
        color: #1e293b;
    }

    .page-subtitle {
        color: #64748b;
        font-size: 1rem;
        line-height: 1.75;
        max-width: 700px;
    }

    .header-mini-stat {
        background: #fff;
        border-radius: 18px;
        padding: 1rem 1.25rem;
        border: 1px solid rgba(15, 23, 42, .06);
        display: inline-block;
        min-width: 220px;
    }

    .mini-stat-label {
        color: #64748b;
        font-size: .85rem;
        margin-bottom: .3rem;
    }

    .mini-stat-value {
        color: #0f172a;
        font-weight: 700;
    }

    .profile-card {
        border-radius: 26px;
    }

    .profile-left-panel {
        background: linear-gradient(180deg, #0d6efd 0%, #0b5ed7 100%);
        color: #fff;
        padding: 2.5rem 1.5rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .profile-avatar-wrap {
        margin-bottom: 1.25rem;
    }

    .profile-avatar {
        width: 160px;
        height: 160px;
        object-fit: cover;
        border-radius: 50%;
        border: 5px solid rgba(255,255,255,.25);
        box-shadow: 0 20px 40px rgba(0,0,0,.18);
    }

    .profile-name {
        font-weight: 800;
        font-size: 1.5rem;
    }

    .profile-meta {
        color: rgba(255,255,255,.88);
        font-size: .98rem;
    }

    .profile-quick-tags {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: .6rem;
    }

    .quick-tag {
        background: rgba(255,255,255,.14);
        border: 1px solid rgba(255,255,255,.18);
        color: #fff;
        border-radius: 999px;
        padding: .5rem .85rem;
        font-size: .85rem;
    }

    .detail-title {
        font-weight: 800;
        color: #0f172a;
    }

    .detail-status {
        background: #ecfdf3;
        color: #198754;
        border: 1px solid #cdebd8;
        padding: .45rem .75rem;
        border-radius: 999px;
        font-size: .85rem;
        font-weight: 600;
    }

    .info-item {
        background: #fff;
        border: 1px solid rgba(15, 23, 42, .06);
        border-radius: 18px;
        padding: 1rem 1.1rem;
        height: 100%;
        transition: all .25s ease;
    }

    .info-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 14px 30px rgba(15, 23, 42, .06);
    }

    .info-label {
        color: #64748b;
        font-size: .88rem;
        margin-bottom: .35rem;
    }

    .info-value {
        color: #0f172a;
        font-weight: 700;
        line-height: 1.6;
    }

    .profile-note {
        background: #f8fafc;
        border: 1px dashed #cbd5e1;
        color: #475569;
        border-radius: 16px;
        padding: .95rem 1rem;
    }

    .section-head {
        display: flex;
        align-items: end;
        justify-content: space-between;
        gap: 1rem;
    }

    .section-title {
        font-weight: 800;
        color: #0f172a;
    }

    .section-subtitle {
        color: #64748b;
    }

    .stat-card {
        border-radius: 24px;
        overflow: hidden;
        transition: transform .25s ease, box-shadow .25s ease;
    }

    .stat-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 40px rgba(15, 23, 42, .08) !important;
    }

    .stat-card-success {
        background: linear-gradient(180deg, #ffffff 0%, #f3fcf7 100%);
    }

    .stat-card-warning {
        background: linear-gradient(180deg, #ffffff 0%, #fffaf0 100%);
    }

    .stat-card-danger {
        background: linear-gradient(180deg, #ffffff 0%, #fff5f5 100%);
    }

    .stat-icon {
        width: 58px;
        height: 58px;
        border-radius: 18px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        background: rgba(13,110,253,.08);
        color: #0d6efd;
        margin-bottom: 1rem;
    }

    .stat-label {
        color: #334155;
        font-size: .95rem;
        font-weight: 700;
        margin-bottom: .35rem;
    }

    .stat-number {
        font-size: 2.2rem;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.1;
    }

    .stat-desc {
        color: #64748b;
        font-size: .92rem;
        margin-top: .35rem;
    }

    .stat-list {
        border-top: 1px solid rgba(15, 23, 42, .06);
        padding-top: 1rem;
        color: #475569;
        font-size: .92rem;
        line-height: 1.75;
    }

    .stat-list li {
        position: relative;
        padding-left: 0;
        margin-bottom: .35rem;
    }

    .stat-list li i {
        color: #0d6efd;
        font-size: 1rem;
        vertical-align: middle;
    }

    .empty-text {
        color: #94a3b8;
    }

    .single-line-info {
        color: #475569;
    }

    .service-card {
        border-radius: 24px;
        transition: transform .25s ease, box-shadow .25s ease;
        background: #fff;
    }

    .service-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 22px 44px rgba(15, 23, 42, .08) !important;
    }

    .service-icon {
        width: 66px;
        height: 66px;
        border-radius: 18px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 1rem;
    }

    .service-title {
        font-weight: 800;
        color: #0f172a;
        margin-bottom: .6rem;
    }

    .service-text {
        color: #64748b;
        line-height: 1.7;
        min-height: 72px;
    }

    .service-link {
        display: inline-flex;
        align-items: center;
        gap: .25rem;
        font-weight: 700;
        color: #0d6efd;
        text-decoration: none;
    }

    .service-link:hover {
        color: #0a58ca;
    }

    @media (max-width: 991.98px) {
        .page-header-card,
        .profile-left-panel,
        .card-body {
            border-radius: 20px;
        }

        .profile-left-panel {
            padding: 2rem 1.25rem;
        }

        .service-text {
            min-height: auto;
        }
    }
</style>

@endsection