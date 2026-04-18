@extends('admin_client.admin_client')

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

@php
    use Carbon\Carbon;

    if (!$client) {
        abort(404);
    }

    $clientFullName = $client->full_name ?? $client->fullname ?? trim(($client->first_name ?? '') . ' ' . ($client->last_name ?? ''));

    $nextAppointment = $healthSummary['nextAppointment'] ?? null;
    $appointmentCount = $healthSummary['appointmentCount'] ?? 0;
    $appointmentDates = $healthSummary['appointmentDates'] ?? [];

    $medicalCount = $healthSummary['medicalCount'] ?? 0;
    $medicalAppointmentsList = collect($healthSummary['medicalAppointmentsList'] ?? collect());

    $psychiatricCount = $healthSummary['psychiatricCount'] ?? 0;
    $psychiatricAppointmentsList = collect($healthSummary['psychiatricAppointmentsList'] ?? collect());

    $vaccinationCount = $healthSummary['vaccinationCount'] ?? 0;

    $accidentCount = $healthSummary['accidentCount'] ?? 0;
    $accidentAppointmentsList = collect($healthSummary['accidentAppointmentsList'] ?? collect());

    $latestTreatmentType = $healthSummary['latestTreatmentType'] ?? 'ไม่มีข้อมูล';
    $latestTreatmentDate = $healthSummary['latestTreatmentDate'] ?? null;

    $today = Carbon::today();

    $nextAppointmentText = !empty($nextAppointment['date'])
        ? Carbon::parse($nextAppointment['date'])->locale('th')->translatedFormat('d F') . ' ' . (Carbon::parse($nextAppointment['date'])->year + 543)
        : 'ไม่มีนัดหมาย';

    $appointmentDatesText = !empty($appointmentDates)
        ? implode(', ', $appointmentDates)
        : 'ไม่มีนัดหมาย';

    $latestTreatmentDateText = !empty($latestTreatmentDate)
        ? Carbon::parse($latestTreatmentDate)->locale('th')->translatedFormat('d F') . ' ' . (Carbon::parse($latestTreatmentDate)->year + 543)
        : 'ไม่มีข้อมูล';

    $latestTreatmentFullText = !empty($latestTreatmentDate) && !empty($latestTreatmentType) && $latestTreatmentType !== 'ไม่มีข้อมูล'
        ? $latestTreatmentDateText . ' ' . $latestTreatmentType
        : 'ไม่มีข้อมูล';

    $formatAppointmentItems = function ($items, $fallbackType = null) use ($today) {
        return collect($items)
            ->filter(fn ($item) => !empty($item['date']))
            ->map(function ($item) use ($today, $fallbackType) {
                $date = Carbon::parse($item['date'])->startOfDay();
                $daysDiff = $today->diffInDays($date, false);

                if ($daysDiff === 0) {
                    $badgeClass = 'appointment-badge appointment-badge-today';
                    $badgeText = 'วันนี้';
                    $priority = 1;
                } elseif ($daysDiff > 0 && $daysDiff <= 2) {
                    $badgeClass = 'appointment-badge appointment-badge-soon';
                    $badgeText = 'ใกล้นัด';
                    $priority = 2;
                } else {
                    $badgeClass = 'appointment-badge appointment-badge-normal';
                    $badgeText = 'ตามนัด';
                    $priority = 3;
                }

                return [
                    'date_text' => $date->locale('th')->translatedFormat('d F') . ' ' . ($date->year + 543),
                    'type_text' => $item['type'] ?? $fallbackType ?? 'นัดหมาย',
                    'badge_class' => $badgeClass,
                    'badge_text' => $badgeText,
                    'priority' => $priority,
                    'sort_date' => $date->format('Y-m-d'),
                ];
            })
            ->unique(fn ($item) => ($item['date_text'] ?? '') . '|' . ($item['type_text'] ?? ''))
            ->sortBy([
                ['priority', 'asc'],
                ['sort_date', 'asc'],
            ])
            ->values();
    };

    $medicalAppointmentItems = $formatAppointmentItems($medicalAppointmentsList, 'พบแพทย์');
    $psychiatricAppointmentItems = $formatAppointmentItems($psychiatricAppointmentsList, 'พบจิตแพทย์');
    $accidentAppointmentItems = $formatAppointmentItems($accidentAppointmentsList, 'นัดหมายการรักษา');

    $allAppointmentItems = collect()
        ->merge($medicalAppointmentItems)
        ->merge($psychiatricAppointmentItems)
        ->merge($accidentAppointmentItems)
        ->sortBy([
            ['priority', 'asc'],
            ['sort_date', 'asc'],
        ])
        ->values();

    $todayAppointmentItems = $allAppointmentItems->where('badge_text', 'วันนี้')->values();
    $soonAppointmentItems = $allAppointmentItems->where('badge_text', 'ใกล้นัด')->values();
@endphp

<div class="container-fluid health-page">
    <div class="health-shell">

        <div class="health-topbar">
            <div class="health-topbar-left">
                <a href="{{ route('admin.index', $client->id) }}" class="health-back-btn">
                    <span class="health-back-btn-icon">
                        <i class="bi bi-arrow-left-short"></i>
                    </span>
                    <span>ย้อนกลับ</span>
                </a>
            </div>

            <div class="health-topbar-right">
                <div class="health-page-badge">
                    <i class="bi bi-heart-pulse-fill me-2"></i>
                    <span>สุขภาพและการรักษา</span>
                </div>
            </div>
        </div>

        @if($todayAppointmentItems->count() > 0)
            <section class="health-alert-banner health-alert-banner-danger">
                <div class="health-alert-icon">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                </div>
                <div class="health-alert-content">
                    <div class="health-alert-title">มีนัดหมายวันนี้</div>
                    <div class="health-alert-text">
                        {{ $todayAppointmentItems->pluck('type_text')->unique()->implode(', ') }}
                        จำนวน {{ $todayAppointmentItems->count() }} รายการ
                    </div>
                </div>
            </section>
        @elseif($soonAppointmentItems->count() > 0)
            <section class="health-alert-banner health-alert-banner-warning">
                <div class="health-alert-icon">
                    <i class="bi bi-alarm-fill"></i>
                </div>
                <div class="health-alert-content">
                    <div class="health-alert-title">มีนัดหมายใกล้ถึง</div>
                    <div class="health-alert-text">
                        ภายใน 1–2 วันข้างหน้า จำนวน {{ $soonAppointmentItems->count() }} รายการ
                    </div>
                </div>
            </section>
        @endif

        <section class="health-hero-panel">
            <div class="health-hero-grid">
                <div class="health-hero-main">
                    <div class="health-hero-kicker">HEALTH DASHBOARD</div>
                    <h1 class="health-hero-title">สุขภาพและการรักษา</h1>
                    <p class="health-hero-subtitle">
                        สรุปข้อมูลด้านการรักษา นัดหมาย วัคซีน และเหตุการณ์ด้านสุขภาพของผู้รับบริการในหน้าเดียว
                    </p>
                </div>

                <div class="health-hero-side">
                    <div class="health-hero-date-card">
                        <div class="health-hero-date-label">นัดหมายถัดไป</div>
                        <div class="health-hero-date-value">{{ $nextAppointmentText }}</div>
                    </div>
                </div>
            </div>
        </section>

        <section class="health-client-card">
            <div class="health-client-name-wrap">
                <h2 class="health-client-name">{{ $clientFullName ?: 'ไม่ระบุชื่อ' }}</h2>
                <div class="health-client-submeta">
                    <span class="health-client-submeta-item">
                        <i class="bi bi-person-badge"></i>
                        เลขทะเบียน: {{ $client->register_number ?? '-' }}
                    </span>
                    <span class="health-client-submeta-item">
                        <i class="bi bi-clock-history"></i>
                        ล่าสุด: {{ $latestTreatmentFullText }}
                    </span>
                </div>
            </div>

            <div class="health-summary-grid">
                <div class="health-summary-card">
                    <div class="health-summary-label">จำนวนรอนัด</div>
                    <div class="health-summary-value">{{ $appointmentCount }}</div>
                    <div class="health-summary-subtext">{{ $appointmentDatesText }}</div>
                </div>

                <div class="health-summary-card">
                    <div class="health-summary-label">วันที่รักษาล่าสุด</div>
                    <div class="health-summary-value">{{ $latestTreatmentDateText }}</div>
                    <div class="health-summary-subtext">
                        {{ $latestTreatmentType !== 'ไม่มีข้อมูล' ? $latestTreatmentType : '-' }}
                    </div>
                </div>

                <div class="health-summary-card">
                    <div class="health-summary-label">ประเภทล่าสุด</div>
                    <div class="health-summary-value">{{ $latestTreatmentType }}</div>
                    <div class="health-summary-subtext">
                        {{ !empty($latestTreatmentDate) ? $latestTreatmentDateText : 'ไม่มีข้อมูล' }}
                    </div>
                </div>
            </div>
        </section>

        <section class="health-list-section">
            <div class="health-section-heading">
                <div>
                    <h3 class="health-section-title">สรุปข้อมูลสุขภาพ</h3>
                    <p class="health-section-subtitle">แสดงจำนวนข้อมูลในแต่ละหมวด พร้อมวันนัดที่เกี่ยวข้องของแต่ละส่วน</p>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-xl-3 col-md-6">
                    <div class="health-log-card h-100">
                        <div class="health-log-card-body">
                            <div class="health-log-icon">
                                <i class="bi bi-hospital"></i>
                            </div>
                            <div class="health-log-title">พบแพทย์</div>
                            <div class="health-log-number">{{ $medicalCount }}</div>
                            <div class="health-log-desc">จำนวนข้อมูลการรักษาทั่วไป</div>

                            <div class="health-log-meta">
                                <div class="health-log-meta-label">วันนัดถัดไป</div>

                                @if($medicalAppointmentItems->count() > 0)
                                    <div class="appointment-list">
                                        @foreach($medicalAppointmentItems as $appointment)
                                            <div class="appointment-item">
                                                <div class="appointment-main">
                                                    <div class="appointment-date">{{ $appointment['date_text'] }}</div>
                                                    <div class="appointment-type">{{ $appointment['type_text'] }}</div>
                                                </div>
                                                <span class="{{ $appointment['badge_class'] }}">{{ $appointment['badge_text'] }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="health-log-meta-value">ไม่มีนัดหมาย</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="health-log-card h-100">
                        <div class="health-log-card-body">
                            <div class="health-log-icon">
                                <i class="bi bi-heart-pulse"></i>
                            </div>
                            <div class="health-log-title">พบจิตแพทย์</div>
                            <div class="health-log-number">{{ $psychiatricCount }}</div>
                            <div class="health-log-desc">จำนวนข้อมูลจิตเวช</div>

                            <div class="health-log-meta">
                                <div class="health-log-meta-label">วันนัดถัดไป</div>

                                @if($psychiatricAppointmentItems->count() > 0)
                                    <div class="appointment-list">
                                        @foreach($psychiatricAppointmentItems as $appointment)
                                            <div class="appointment-item">
                                                <div class="appointment-main">
                                                    <div class="appointment-date">{{ $appointment['date_text'] }}</div>
                                                    <div class="appointment-type">{{ $appointment['type_text'] }}</div>
                                                </div>
                                                <span class="{{ $appointment['badge_class'] }}">{{ $appointment['badge_text'] }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="health-log-meta-value">ไม่มีนัดหมาย</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="health-log-card h-100">
                        <div class="health-log-card-body">
                            <div class="health-log-icon">
                                <i class="bi bi-shield-plus"></i>
                            </div>
                            <div class="health-log-title">วัคซีน</div>
                            <div class="health-log-number">{{ $vaccinationCount }}</div>
                            <div class="health-log-desc">จำนวนข้อมูลวัคซีน</div>

                            <div class="health-log-meta">
                                <div class="health-log-meta-label">สถานะ</div>
                                <div class="health-log-meta-value">
                                    {{ $vaccinationCount > 0 ? 'มีข้อมูลในระบบ' : 'ยังไม่มีข้อมูล' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="health-log-card h-100">
                        <div class="health-log-card-body">
                            <div class="health-log-icon">
                                <i class="bi bi-bandaid"></i>
                            </div>
                            <div class="health-log-title">อุบัติเหตุ/บาดเจ็บ</div>
                            <div class="health-log-number">{{ $accidentCount }}</div>
                            <div class="health-log-desc">จำนวนข้อมูลอุบัติเหตุและการบาดเจ็บ</div>

                            <div class="health-log-meta">
                                <div class="health-log-meta-label">วันนัดถัดไป</div>

                                @if($accidentAppointmentItems->count() > 0)
                                    <div class="appointment-list">
                                        @foreach($accidentAppointmentItems as $appointment)
                                            <div class="appointment-item">
                                                <div class="appointment-main">
                                                    <div class="appointment-date">{{ $appointment['date_text'] }}</div>
                                                    <div class="appointment-type">{{ $appointment['type_text'] }}</div>
                                                </div>
                                                <span class="{{ $appointment['badge_class'] }}">{{ $appointment['badge_text'] }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="health-log-meta-value">ไม่มีนัดหมาย</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
</div>

<style>
    .health-page{
        background:
            radial-gradient(circle at top left, rgba(220, 38, 38, 0.06), transparent 28%),
            linear-gradient(180deg, #f8fbff 0%, #f4f7fb 100%);
        min-height: 100vh;
        padding: 1.25rem;
        overflow-x: hidden;
    }

    .health-shell{
        max-width: 1440px;
        margin: 0 auto;
    }

    .health-topbar{
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:1rem;
        flex-wrap:wrap;
        margin-bottom:1rem;
    }

    .health-back-btn{
        display:inline-flex;
        align-items:center;
        gap:.6rem;
        padding:.72rem 1.1rem;
        border-radius:999px;
        background:#dc2626;
        color:#fff;
        text-decoration:none;
        font-weight:700;
        box-shadow:0 14px 32px rgba(220,38,38,.18);
        transition:all .2s ease;
    }

    .health-back-btn:hover{
        color:#fff;
        background:#b91c1c;
        transform:translateY(-1px);
    }

    .health-back-btn-icon{
        width:30px;
        height:30px;
        border-radius:50%;
        display:inline-flex;
        align-items:center;
        justify-content:center;
        background:rgba(255,255,255,.18);
        font-size:1.05rem;
        flex:0 0 auto;
    }

    .health-page-badge{
        display:inline-flex;
        align-items:center;
        justify-content:center;
        padding:.68rem 1rem;
        border-radius:999px;
        background:rgba(255,255,255,.92);
        border:1px solid rgba(220,38,38,.12);
        color:#dc2626;
        font-weight:700;
        box-shadow:0 12px 28px rgba(15,23,42,.05);
    }

    .health-alert-banner{
        display:flex;
        align-items:flex-start;
        gap:.9rem;
        border-radius:22px;
        padding:1rem 1.1rem;
        margin-bottom:1rem;
        border:1px solid transparent;
        box-shadow:0 16px 30px rgba(15,23,42,.05);
    }

    .health-alert-banner-danger{
        background:linear-gradient(180deg, #fff5f5 0%, #fff1f2 100%);
        border-color:rgba(220,38,38,.12);
    }

    .health-alert-banner-warning{
        background:linear-gradient(180deg, #fffaf0 0%, #fff7ed 100%);
        border-color:rgba(245,158,11,.18);
    }

    .health-alert-icon{
        width:44px;
        height:44px;
        border-radius:14px;
        display:inline-flex;
        align-items:center;
        justify-content:center;
        font-size:1.15rem;
        flex:0 0 auto;
        background:rgba(255,255,255,.8);
        color:#dc2626;
    }

    .health-alert-banner-warning .health-alert-icon{
        color:#b45309;
    }

    .health-alert-title{
        color:#0f172a;
        font-weight:900;
        line-height:1.3;
        margin-bottom:.2rem;
    }

    .health-alert-text{
        color:#475569;
        line-height:1.55;
    }

    .health-hero-panel,
    .health-client-card,
    .health-log-card{
        background:#fff;
        border:1px solid rgba(15,23,42,.06);
        border-radius:28px;
        box-shadow:0 22px 44px rgba(15,23,42,.05);
    }

    .health-hero-panel{
        padding:1.7rem 1.8rem;
        margin-bottom:1.25rem;
        background:linear-gradient(135deg, #ffffff 0%, #fff7f7 100%);
    }

    .health-hero-grid{
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:1.5rem;
        flex-wrap:wrap;
    }

    .health-hero-main{
        flex:1 1 720px;
        min-width:0;
    }

    .health-hero-side{
        flex:0 0 auto;
        margin-left:auto;
    }

    .health-hero-kicker{
        display:inline-block;
        font-size:.78rem;
        font-weight:800;
        text-transform:uppercase;
        letter-spacing:.08em;
        color:#dc2626;
        background:rgba(220,38,38,.08);
        padding:.42rem .8rem;
        border-radius:999px;
        margin-bottom:.95rem;
    }

    .health-hero-title{
        font-size:clamp(1.8rem, 2.4vw, 2.75rem);
        font-weight:900;
        color:#0f172a;
        line-height:1.18;
        margin:0 0 .55rem 0;
    }

    .health-hero-subtitle{
        color:#64748b;
        font-size:1rem;
        line-height:1.75;
        max-width:780px;
        margin:0;
    }

    .health-hero-date-card{
        min-width:250px;
        max-width:320px;
        background:#fff;
        border:1px solid rgba(15,23,42,.06);
        border-radius:20px;
        padding:1rem 1.1rem;
        box-shadow:0 12px 30px rgba(15,23,42,.05);
    }

    .health-hero-date-label{
        color:#64748b;
        font-size:.85rem;
        margin-bottom:.35rem;
    }

    .health-hero-date-value{
        color:#0f172a;
        font-weight:800;
        line-height:1.45;
        word-break:break-word;
    }

    .health-client-card{
        padding:1.3rem;
        margin-bottom:1.25rem;
    }

    .health-client-name{
        margin:0 0 .5rem 0;
        font-size:clamp(1.35rem, 2vw, 1.9rem);
        font-weight:900;
        color:#0f172a;
        line-height:1.25;
    }

    .health-client-submeta{
        display:flex;
        flex-wrap:wrap;
        gap:.55rem;
        margin-bottom:1rem;
    }

    .health-client-submeta-item{
        display:inline-flex;
        align-items:center;
        gap:.45rem;
        background:#f8fbff;
        border:1px solid rgba(220,38,38,.08);
        border-radius:999px;
        padding:.5rem .8rem;
        color:#334155;
        font-size:.9rem;
        line-height:1.4;
    }

    .health-summary-grid{
        display:grid;
        grid-template-columns:repeat(3, minmax(0, 1fr));
        gap:1rem;
    }

    .health-summary-card{
        background:linear-gradient(180deg, #fffdfd 0%, #fff7f7 100%);
        border:1px solid rgba(15,23,42,.06);
        border-radius:20px;
        padding:.95rem 1rem;
    }

    .health-summary-label{
        font-size:.82rem;
        color:#64748b;
        margin-bottom:.28rem;
    }

    .health-summary-value{
        color:#0f172a;
        font-weight:800;
        line-height:1.5;
        word-break:break-word;
    }

    .health-summary-subtext{
        margin-top:.45rem;
        color:#64748b;
        font-size:.9rem;
        line-height:1.55;
        word-break:break-word;
    }

    .health-section-heading{
        display:flex;
        align-items:flex-start;
        justify-content:space-between;
        gap:1rem;
        flex-wrap:wrap;
        margin-bottom:1rem;
    }

    .health-section-title{
        margin:0 0 .25rem 0;
        color:#0f172a;
        font-weight:900;
        font-size:1.25rem;
    }

    .health-section-subtitle{
        margin:0;
        color:#64748b;
        line-height:1.65;
    }

    .health-log-card{
        transition:transform .22s ease, box-shadow .22s ease;
        overflow:hidden;
    }

    .health-log-card:hover{
        transform:translateY(-4px);
        box-shadow:0 24px 44px rgba(15,23,42,.08);
    }

    .health-log-card-body{
        padding:1.35rem;
    }

    .health-log-icon{
        width:60px;
        height:60px;
        border-radius:18px;
        display:inline-flex;
        align-items:center;
        justify-content:center;
        font-size:1.35rem;
        margin-bottom:1rem;
        background:rgba(220,38,38,.08);
        color:#dc2626;
    }

    .health-log-title{
        color:#334155;
        font-size:.95rem;
        font-weight:800;
        margin-bottom:.35rem;
    }

    .health-log-number{
        font-size:2.15rem;
        font-weight:900;
        color:#0f172a;
        line-height:1.1;
        margin-bottom:.3rem;
    }

    .health-log-desc{
        color:#64748b;
        font-size:.92rem;
        line-height:1.6;
    }

    .health-log-meta{
        margin-top:1rem;
        padding-top:1rem;
        border-top:1px solid rgba(15,23,42,.06);
    }

    .health-log-meta-label{
        color:#64748b;
        font-size:.86rem;
        margin-bottom:.45rem;
    }

    .health-log-meta-value{
        color:#0f172a;
        font-weight:700;
        font-size:.92rem;
        line-height:1.55;
        word-break:break-word;
    }

    .appointment-list{
        display:flex;
        flex-direction:column;
        gap:.6rem;
    }

    .appointment-item{
        display:flex;
        align-items:flex-start;
        justify-content:space-between;
        gap:.75rem;
        padding:.7rem .8rem;
        border:1px solid rgba(15,23,42,.06);
        border-radius:14px;
        background:#f8fbff;
    }

    .appointment-main{
        min-width:0;
    }

    .appointment-date{
        color:#0f172a;
        font-weight:800;
        line-height:1.4;
        word-break:break-word;
    }

    .appointment-type{
        color:#64748b;
        font-size:.86rem;
        line-height:1.45;
        margin-top:.12rem;
    }

    .appointment-badge{
        display:inline-flex;
        align-items:center;
        justify-content:center;
        border-radius:999px;
        padding:.28rem .6rem;
        font-size:.74rem;
        font-weight:800;
        white-space:nowrap;
        flex:0 0 auto;
    }

    .appointment-badge-today{
        background:rgba(220,38,38,.12);
        color:#dc2626;
    }

    .appointment-badge-soon{
        background:rgba(245,158,11,.16);
        color:#b45309;
    }

    .appointment-badge-normal{
        background:rgba(59,130,246,.10);
        color:#1d4ed8;
    }

    @media (max-width: 1199.98px){
        .health-page{
            padding:1rem;
        }

        .health-hero-panel,
        .health-client-card,
        .health-log-card{
            border-radius:22px;
        }

        .health-hero-side{
            width:100%;
            margin-left:0;
        }

        .health-hero-date-card{
            max-width:100%;
            min-width:0;
        }

        .health-summary-grid{
            grid-template-columns:1fr;
        }
    }

    @media (max-width: 991.98px){
        .health-topbar{
            align-items:stretch;
        }

        .health-topbar-left,
        .health-topbar-right{
            width:100%;
        }

        .health-page-badge,
        .health-back-btn{
            width:100%;
            justify-content:center;
        }
    }

    @media (max-width: 767.98px){
        .health-page{
            padding:.85rem .75rem 1.2rem;
        }

        .health-alert-banner{
            border-radius:18px;
            padding:.9rem;
        }

        .health-hero-panel,
        .health-client-card,
        .health-log-card-body{
            padding:1rem;
        }

        .health-hero-title{
            font-size:1.6rem;
        }

        .health-hero-subtitle{
            font-size:.94rem;
            line-height:1.65;
        }

        .health-client-submeta{
            flex-direction:column;
        }

        .health-client-submeta-item{
            width:100%;
            border-radius:16px;
        }

        .health-log-number{
            font-size:1.95rem;
        }

        .health-log-icon{
            width:56px;
            height:56px;
            font-size:1.28rem;
        }

        .appointment-item{
            flex-direction:column;
            align-items:flex-start;
        }
    }

    @media (max-width: 575.98px){
        .health-page-badge,
        .health-back-btn{
            border-radius:18px;
        }

        .health-hero-kicker{
            font-size:.72rem;
        }
    }
</style>

@endsection