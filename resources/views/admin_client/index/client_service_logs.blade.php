@extends('admin_client.admin_client')

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

@php
    if (!$client) {
        abort(404);
    }

    $clientFullName = $client->full_name ?? $client->fullname ?? trim(($client->first_name ?? '') . ' ' . ($client->last_name ?? ''));
@endphp

<div class="container-fluid service-logs-page">
    <div class="service-logs-shell">

        <div class="service-logs-topbar">
            <div class="service-logs-topbar-left">
                <a href="{{ route('admin.index', $client->id) }}" class="service-back-btn">
                    <span class="service-back-btn-icon">
                        <i class="bi bi-arrow-left-short"></i>
                    </span>
                    <span>ย้อนกลับ</span>
                </a>
            </div>

            <div class="service-logs-topbar-right">
                <div class="service-page-badge">
                    <i class="bi bi-clipboard2-pulse me-2"></i>
                    <span>ข้อมูลเบื้องต้นที่ควรบันทึก</span>
                </div>
            </div>
        </div>

        <section class="service-hero-panel">
            <div class="service-hero-grid">
                <div class="service-hero-main">
                    <div class="service-hero-kicker">REQUIRED DATA CHECK</div>
                    <h1 class="service-hero-title">ข้อมูลเบื้องต้นที่ยังไม่ได้บันทึก</h1>
                    <p class="service-hero-subtitle">
                        ตรวจสอบรายการข้อมูลสำคัญของผู้รับบริการที่ยังขาด หรือควรบันทึกเพิ่มเติม เพื่อให้ข้อมูลครบถ้วนและพร้อมใช้งาน
                    </p>
                </div>

                <div class="service-hero-side">
                    <div class="service-hero-date-card">
                        <div class="service-hero-date-label">รายการที่ยังขาดลำดับแรก</div>
                        <div class="service-hero-date-value">{{ $latestType ?: 'ข้อมูลเบื้องต้นครบถ้วน' }}</div>
                    </div>
                </div>
            </div>
        </section>

        <section class="service-client-card">
            <div class="service-client-name-wrap">
                <h2 class="service-client-name">{{ $clientFullName ?: 'ไม่ระบุชื่อ' }}</h2>
                <div class="service-client-submeta">
                    <span class="service-client-submeta-item">
                        <i class="bi bi-person-badge"></i>
                        เลขทะเบียน: {{ $client->register_number ?? '-' }}
                    </span>
                    <span class="service-client-submeta-item">
                        <i class="bi bi-list-check"></i>
                        รายการที่ควรตรวจสอบ: {{ $requiredTotal ?? ($services->count() ?? 0) }} ส่วน
                    </span>
                </div>
            </div>

            <div class="service-summary-grid">
                <div class="service-summary-card service-summary-card-danger">
                    <div class="service-summary-label">ข้อมูลที่ยังขาด</div>
                    <div class="service-summary-value">{{ $totalCount ?? 0 }}</div>
                </div>

                <div class="service-summary-card service-summary-card-success">
                    <div class="service-summary-label">ข้อมูลที่บันทึกแล้ว</div>
                    <div class="service-summary-value">{{ $completedCount ?? 0 }}</div>
                </div>

                <div class="service-summary-card">
                    <div class="service-summary-label">สถานะโดยรวม</div>
                    <div class="service-summary-value">
                        {{ ($totalCount ?? 0) > 0 ? 'ยังมีข้อมูลที่ควรบันทึกเพิ่มเติม' : 'ข้อมูลเบื้องต้นครบถ้วน' }}
                    </div>
                </div>
            </div>
        </section>

        <section class="service-list-section">
            <div class="service-section-heading">
                <div>
                    <h3 class="service-section-title">รายการตรวจสอบข้อมูลสำคัญ</h3>
                    <p class="service-section-subtitle">แสดงสถานะของข้อมูลแต่ละส่วนว่ามีการบันทึกแล้วหรือยัง</p>
                </div>
            </div>

            @if($services->count() > 0)
                <div class="row g-4">
                    @foreach($services as $service)
                        @php
                            $isMissing = ($service['status'] ?? 'missing') === 'missing';
                        @endphp

                        <div class="col-xl-4 col-md-6">
                            <div class="service-log-card h-100 {{ $isMissing ? 'is-missing' : 'is-complete' }}">
                                <div class="service-log-card-body">
                                    <div class="service-log-icon">
                                        <i class="bi {{ $isMissing ? 'bi-exclamation-triangle' : 'bi-check-circle' }}"></i>
                                    </div>

                                    <div class="d-flex align-items-start justify-content-between gap-2 flex-wrap mb-2">
                                        <div class="service-log-title mb-0">{{ $service['type'] ?? '-' }}</div>

                                        <span class="service-status-badge {{ $isMissing ? 'status-missing' : 'status-complete' }}">
                                            {{ $isMissing ? 'ยังไม่มีข้อมูล' : 'บันทึกแล้ว' }}
                                        </span>
                                    </div>

                                    <div class="service-log-number">{{ $service['count'] ?? 0 }}</div>

                                     @if($isMissing && !empty($service['description']))
                                        <div class="service-log-desc">{{ $service['description'] }}</div>
                                     @endif

                                    <div class="service-log-meta">
                                        <div class="service-log-meta-item">
                                            <span class="service-log-meta-label">สถานะ</span>
                                            <span class="service-log-meta-value">
                                                {{ $isMissing ? 'ควรบันทึกเพิ่มเติม' : 'พร้อมใช้งาน' }}
                                            </span>
                                        </div>

                                        <div class="service-log-meta-item">
                                            <span class="service-log-meta-label">โมดูล</span>
                                            <span class="service-log-meta-value">{{ $service['model'] ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="service-empty-box">
                    <i class="bi bi-check2-circle me-2"></i>
                    ข้อมูลเบื้องต้นครบถ้วนแล้ว
                </div>
            @endif
        </section>

    </div>
</div>

<style>
    .service-logs-page{
        background:
            radial-gradient(circle at top left, rgba(25, 135, 84, 0.06), transparent 28%),
            linear-gradient(180deg, #f8fbff 0%, #f4f7fb 100%);
        min-height: 100vh;
        padding: 1.25rem;
        overflow-x: hidden;
    }

    .service-logs-shell{
        max-width: 1440px;
        margin: 0 auto;
    }

    .service-logs-topbar{
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:1rem;
        flex-wrap:wrap;
        margin-bottom:1rem;
    }

    .service-back-btn{
        display:inline-flex;
        align-items:center;
        gap:.6rem;
        padding:.72rem 1.1rem;
        border-radius:999px;
        background:#198754;
        color:#fff;
        text-decoration:none;
        font-weight:700;
        box-shadow:0 14px 32px rgba(25,135,84,.18);
        transition:all .2s ease;
    }

    .service-back-btn:hover{
        color:#fff;
        background:#157347;
        transform:translateY(-1px);
    }

    .service-back-btn-icon{
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

    .service-page-badge{
        display:inline-flex;
        align-items:center;
        justify-content:center;
        padding:.68rem 1rem;
        border-radius:999px;
        background:rgba(255,255,255,.92);
        border:1px solid rgba(25,135,84,.12);
        color:#198754;
        font-weight:700;
        box-shadow:0 12px 28px rgba(15,23,42,.05);
    }

    .service-hero-panel,
    .service-client-card,
    .service-log-card{
        background:#fff;
        border:1px solid rgba(15,23,42,.06);
        border-radius:28px;
        box-shadow:0 22px 44px rgba(15,23,42,.05);
    }

    .service-hero-panel{
        padding:1.7rem 1.8rem;
        margin-bottom:1.25rem;
        background:linear-gradient(135deg, #ffffff 0%, #f6fffa 100%);
    }

    .service-hero-grid{
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:1.5rem;
        flex-wrap:wrap;
    }

    .service-hero-main{
        flex:1 1 720px;
        min-width:0;
    }

    .service-hero-side{
        flex:0 0 auto;
        margin-left:auto;
    }

    .service-hero-kicker{
        display:inline-block;
        font-size:.78rem;
        font-weight:800;
        text-transform:uppercase;
        letter-spacing:.08em;
        color:#198754;
        background:rgba(25,135,84,.08);
        padding:.42rem .8rem;
        border-radius:999px;
        margin-bottom:.95rem;
    }

    .service-hero-title{
        font-size:clamp(1.8rem, 2.4vw, 2.75rem);
        font-weight:900;
        color:#0f172a;
        line-height:1.18;
        margin:0 0 .55rem 0;
    }

    .service-hero-subtitle{
        color:#64748b;
        font-size:1rem;
        line-height:1.75;
        max-width:780px;
        margin:0;
    }

    .service-hero-date-card{
        min-width:250px;
        max-width:320px;
        background:#fff;
        border:1px solid rgba(15,23,42,.06);
        border-radius:20px;
        padding:1rem 1.1rem;
        box-shadow:0 12px 30px rgba(15,23,42,.05);
    }

    .service-hero-date-label{
        color:#64748b;
        font-size:.85rem;
        margin-bottom:.35rem;
    }

    .service-hero-date-value{
        color:#0f172a;
        font-weight:800;
        line-height:1.45;
        word-break:break-word;
    }

    .service-client-card{
        padding:1.3rem;
        margin-bottom:1.25rem;
    }

    .service-client-name{
        margin:0 0 .5rem 0;
        font-size:clamp(1.35rem, 2vw, 1.9rem);
        font-weight:900;
        color:#0f172a;
        line-height:1.25;
    }

    .service-client-submeta{
        display:flex;
        flex-wrap:wrap;
        gap:.55rem;
        margin-bottom:1rem;
    }

    .service-client-submeta-item{
        display:inline-flex;
        align-items:center;
        gap:.45rem;
        background:#f8fbff;
        border:1px solid rgba(25,135,84,.08);
        border-radius:999px;
        padding:.5rem .8rem;
        color:#334155;
        font-size:.9rem;
        line-height:1.4;
    }

    .service-summary-grid{
        display:grid;
        grid-template-columns:repeat(3, minmax(0, 1fr));
        gap:1rem;
    }

    .service-summary-card{
        background:linear-gradient(180deg, #fbfffd 0%, #f6fffa 100%);
        border:1px solid rgba(15,23,42,.06);
        border-radius:20px;
        padding:.95rem 1rem;
    }

    .service-summary-card-danger{
        background:linear-gradient(180deg, #fff7f7 0%, #fff1f2 100%);
        border-color:rgba(220,53,69,.12);
    }

    .service-summary-card-success{
        background:linear-gradient(180deg, #f8fff9 0%, #f2fff5 100%);
        border-color:rgba(25,135,84,.12);
    }

    .service-summary-label{
        font-size:.82rem;
        color:#64748b;
        margin-bottom:.28rem;
    }

    .service-summary-value{
        color:#0f172a;
        font-weight:800;
        line-height:1.5;
        word-break:break-word;
    }

    .service-section-heading{
        display:flex;
        align-items:flex-start;
        justify-content:space-between;
        gap:1rem;
        flex-wrap:wrap;
        margin-bottom:1rem;
    }

    .service-section-title{
        margin:0 0 .25rem 0;
        color:#0f172a;
        font-weight:900;
        font-size:1.25rem;
    }

    .service-section-subtitle{
        margin:0;
        color:#64748b;
        line-height:1.65;
    }

    .service-log-card{
        transition:transform .22s ease, box-shadow .22s ease;
        overflow:hidden;
    }

    .service-log-card:hover{
        transform:translateY(-4px);
        box-shadow:0 24px 44px rgba(15,23,42,.08);
    }

    .service-log-card.is-missing{
        border-color:rgba(220,53,69,.12);
        background:linear-gradient(180deg, #ffffff 0%, #fff8f8 100%);
    }

    .service-log-card.is-complete{
        border-color:rgba(25,135,84,.12);
        background:linear-gradient(180deg, #ffffff 0%, #f7fff9 100%);
    }

    .service-log-card-body{
        padding:1.35rem;
    }

    .service-log-icon{
        width:60px;
        height:60px;
        border-radius:18px;
        display:inline-flex;
        align-items:center;
        justify-content:center;
        font-size:1.35rem;
        margin-bottom:1rem;
        background:rgba(25,135,84,.08);
        color:#198754;
    }

    .service-log-card.is-missing .service-log-icon{
        background:rgba(220,53,69,.08);
        color:#dc3545;
    }

    .service-log-title{
        color:#334155;
        font-size:.95rem;
        font-weight:800;
        margin-bottom:.35rem;
    }

    .service-log-number{
        font-size:2.15rem;
        font-weight:900;
        color:#0f172a;
        line-height:1.1;
        margin-bottom:.3rem;
    }

    .service-log-desc{
        color:#64748b;
        font-size:.92rem;
        line-height:1.6;
    }

    .service-status-badge{
        display:inline-flex;
        align-items:center;
        justify-content:center;
        border-radius:999px;
        padding:.35rem .75rem;
        font-size:.78rem;
        font-weight:800;
        white-space:nowrap;
    }

    .status-missing{
        background:rgba(220,53,69,.10);
        color:#dc3545;
    }

    .status-complete{
        background:rgba(25,135,84,.10);
        color:#198754;
    }

    .service-log-meta{
        margin-top:1rem;
        padding-top:1rem;
        border-top:1px solid rgba(15,23,42,.06);
        display:flex;
        flex-direction:column;
        gap:.6rem;
    }

    .service-log-meta-item{
        display:flex;
        align-items:flex-start;
        justify-content:space-between;
        gap:.75rem;
    }

    .service-log-meta-label{
        color:#64748b;
        font-size:.86rem;
    }

    .service-log-meta-value{
        color:#0f172a;
        font-weight:700;
        font-size:.9rem;
        text-align:right;
        word-break:break-word;
    }

    .service-empty-box{
        background:#fff;
        border:1px dashed rgba(25,135,84,.18);
        color:#198754;
        border-radius:22px;
        padding:1.2rem 1rem;
        text-align:center;
        font-weight:700;
    }

    @media (max-width: 1199.98px){
        .service-logs-page{
            padding:1rem;
        }

        .service-hero-panel,
        .service-client-card,
        .service-log-card{
            border-radius:22px;
        }

        .service-hero-side{
            width:100%;
            margin-left:0;
        }

        .service-hero-date-card{
            max-width:100%;
            min-width:0;
        }

        .service-summary-grid{
            grid-template-columns:1fr;
        }
    }

    @media (max-width: 991.98px){
        .service-logs-topbar{
            align-items:stretch;
        }

        .service-logs-topbar-left,
        .service-logs-topbar-right{
            width:100%;
        }

        .service-page-badge,
        .service-back-btn{
            width:100%;
            justify-content:center;
        }
    }

    @media (max-width: 767.98px){
        .service-logs-page{
            padding:.85rem .75rem 1.2rem;
        }

        .service-hero-panel,
        .service-client-card,
        .service-log-card-body{
            padding:1rem;
        }

        .service-hero-title{
            font-size:1.6rem;
        }

        .service-hero-subtitle{
            font-size:.94rem;
            line-height:1.65;
        }

        .service-client-submeta{
            flex-direction:column;
        }

        .service-client-submeta-item{
            width:100%;
            border-radius:16px;
        }

        .service-log-meta-item{
            flex-direction:column;
            gap:.2rem;
        }

        .service-log-meta-value{
            text-align:left;
        }

        .service-log-number{
            font-size:1.95rem;
        }

        .service-log-icon{
            width:56px;
            height:56px;
            font-size:1.28rem;
        }
    }

    @media (max-width: 575.98px){
        .service-page-badge,
        .service-back-btn{
            border-radius:18px;
        }

        .service-hero-kicker{
            font-size:.72rem;
        }
    }
</style>

@endsection