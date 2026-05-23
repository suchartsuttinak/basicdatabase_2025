@extends('admin_client.admin_client')

@section('content')
<style>
    .ca-report-page{
        background:#eef2f7;
        padding:18px 0;
        min-height:100vh;
        font-family:"TH Sarabun New","Sarabun",sans-serif;
    }

    .ca-report-toolbar{
        width:210mm;
        margin:0 auto 10px;
        display:flex;
        justify-content:space-between;
        gap:10px;
    }

    .ca-report-btn{
        border:0;
        border-radius:999px;
        padding:8px 14px;
        font-weight:700;
        text-decoration:none;
        display:inline-flex;
        align-items:center;
        gap:6px;
        font-size:15px;
    }

    .ca-report-btn-primary{
        background:#2563eb;
        color:#fff;
    }

    .ca-report-btn-light{
        background:#fff;
        color:#1e293b;
        border:1px solid #cbd5e1;
    }

    .ca-report-sheet{
        width:210mm;
        min-height:297mm;
        margin:0 auto;
        background:#fff;
        color:#111827;
        padding:11mm 12mm;
        box-shadow:0 10px 26px rgba(15,23,42,.13);
        font-size:15px;
        line-height:1.22;
    }

    .ca-report-head{
        text-align:center;
        border-bottom:2px solid #1f2937;
        padding-bottom:6px;
        margin-bottom:8px;
    }

    .ca-report-title{
        font-size:20px;
        font-weight:800;
        margin:0;
        line-height:1.15;
    }

    .ca-report-subtitle{
        font-size:14px;
        margin-top:2px;
        color:#475569;
    }

    .ca-client-info{
        margin-top:8px;
        border:1px solid #d1d5db;
        border-radius:8px;
        padding:7px 9px;
        display:grid;
        grid-template-columns:repeat(2, minmax(0, 1fr));
        gap:3px 16px;
        font-size:15px;
        background:#f8fafc;
    }

    .ca-client-info strong{
        font-weight:800;
        color:#111827;
    }

    .ca-section-title{
        margin-top:10px;
        margin-bottom:7px;
        font-size:16px;
        font-weight:800;
        color:#0f172a;
        display:flex;
        justify-content:space-between;
        align-items:center;
        border-bottom:1px solid #cbd5e1;
        padding-bottom:4px;
    }

    .ca-section-count{
        font-size:13px;
        color:#64748b;
        font-weight:700;
    }

    .ca-report-list{
        display:flex;
        flex-direction:column;
        gap:6px;
    }

    .ca-report-item{
        border:1px solid #e5e7eb;
        border-left:4px solid #2563eb;
        border-radius:8px;
        padding:6px 8px;
        background:#fff;
        break-inside:avoid;
        page-break-inside:avoid;
    }

    .ca-report-item.type-success{ border-left-color:#16a34a; }
    .ca-report-item.type-warning{ border-left-color:#f59e0b; }
    .ca-report-item.type-danger{ border-left-color:#dc2626; }
    .ca-report-item.type-info{ border-left-color:#2563eb; }

    .ca-report-row{
        display:grid;
        grid-template-columns:minmax(0, 1fr) auto;
        gap:8px;
        align-items:start;
    }

    .ca-report-item-title{
        font-size:15.5px;
        font-weight:800;
        margin:0;
        color:#111827;
        line-height:1.2;
        word-break:break-word;
    }

    .ca-report-date{
        white-space:nowrap;
        font-size:13.5px;
        color:#475569;
        font-weight:700;
        text-align:right;
    }

    .ca-report-desc{
        margin:3px 0 0;
        font-size:14.5px;
        color:#1f2937;
        line-height:1.25;
        word-break:break-word;
    }

    .ca-report-meta{
        margin-top:4px;
        display:flex;
        flex-wrap:wrap;
        gap:4px;
        font-size:12.8px;
        color:#475569;
    }

    .ca-chip{
        border-radius:999px;
        background:#eef2ff;
        padding:2px 7px;
        font-weight:700;
        color:#3730a3;
    }

    .ca-empty{
        text-align:center;
        padding:24px 0;
        color:#6b7280;
        font-size:15px;
    }

    .ca-signature{
        margin-top:22px;
        display:grid;
        grid-template-columns:repeat(2, minmax(0, 1fr));
        gap:32px;
        text-align:center;
        font-size:15px;
    }

    .ca-sign-line{
        margin-top:28px;
        border-top:1px solid #111827;
        padding-top:4px;
    }

    @media print{
        html,
        body{
            background:#fff !important;
            margin:0 !important;
            padding:0 !important;
        }

        body{
            -webkit-print-color-adjust:exact;
            print-color-adjust:exact;
        }

        .ca-report-page{
            background:#fff !important;
            padding:0 !important;
        }

        .ca-report-toolbar,
        .navbar,
        .sidebar,
        .footer,
        .main-header,
        .page-title,
        header,
        nav{
            display:none !important;
        }

        .ca-report-sheet{
            width:210mm !important;
            min-height:297mm !important;
            margin:0 auto !important;
            padding:10mm 11mm !important;
            box-shadow:none !important;
            font-size:14.5px !important;
        }

        .ca-report-item{
            break-inside:avoid;
            page-break-inside:avoid;
        }

        @page{
            size:A4 portrait;
            margin:0;
        }
    }

    @media(max-width:900px){
        .ca-report-toolbar,
        .ca-report-sheet{
            width:96vw;
        }

        .ca-report-sheet{
            padding:16px;
        }

        .ca-client-info,
        .ca-signature{
            grid-template-columns:1fr;
        }

        .ca-report-row{
            grid-template-columns:1fr;
        }

        .ca-report-date{
            text-align:left;
        }
    }
</style>

@php
    $moduleLabels = [
        'client'           => 'ผู้รับบริการ',
        'education_record' => 'บันทึกการศึกษา',
        'psychiatric'      => 'พบจิตแพทย์',
        'medical'          => 'พบแพทย์',
        'vaccine'          => 'วัคซีน',
        'observe'          => 'สังเกตพฤติกรรม',
        'addictive'        => 'พฤติกรรมเสพติด',
        'escape'           => 'หนีออกจากสถานสงเคราะห์',
        'school_followup'  => 'ติดตามการเรียน',
        'help_session'     => 'การช่วยเหลือ',
        'job_agency'       => 'จัดหางาน',
        'refer'            => 'จำหน่าย / ส่งต่อ',
        'absent'           => 'ขาดเรียน',
        'operation'        => 'กิจกรรมประจำวัน',
        'estimate'         => 'แบบประเมิน',
        'health_checkup'   => 'ตรวจสุขภาพ',
        'accident'         => 'อุบัติเหตุ',
    ];

    $typeLabels = [
        'info'    => 'ทั่วไป',
        'success' => 'สำเร็จ',
        'warning' => 'เฝ้าระวัง',
        'danger'  => 'เร่งด่วน',
    ];
@endphp

<div class="ca-report-page">

    <div class="ca-report-toolbar">
        <a href="{{ url()->previous() }}" class="ca-report-btn ca-report-btn-light">
            <i class="bi bi-arrow-left"></i>
            ย้อนกลับ
        </a>

        <button type="button" onclick="window.print()" class="ca-report-btn ca-report-btn-primary">
            <i class="bi bi-printer"></i>
            พิมพ์รายงาน
        </button>
    </div>

    <div class="ca-report-sheet">

        <div class="ca-report-head">
            <h1 class="ca-report-title">
                รายงานประวัติความเคลื่อนไหวของเคส
            </h1>
        </div>

        <div class="ca-client-info">
            <div>
                <strong>ชื่อ - สกุล:</strong>
                {{ $client->first_name ?? '-' }} {{ $client->last_name ?? '' }}
            </div>

            <div>
                <strong>เลขทะเบียน:</strong>
                {{ $client->register_number ?? '-' }}
            </div>

            <div>
                <strong>ชื่อเล่น:</strong>
                {{ $client->nick_name ?? '-' }}
            </div>

            <div>
                <strong>วันที่พิมพ์รายงาน:</strong>
                {{ now()->format('d/m/') }}{{ now()->year + 543 }}
            </div>
        </div>

        <div class="ca-section-title">
            <span>รายการความเคลื่อนไหว</span>
            <span class="ca-section-count">ทั้งหมด {{ $activities->count() }} รายการ</span>
        </div>

        @if($activities->count())
            <div class="ca-report-list">
                @foreach($activities as $activity)
                    @php
                        $type = $activity->type ?: 'info';
                        $moduleName = $moduleLabels[$activity->module] ?? $activity->module;
                        $typeName = $typeLabels[$activity->type] ?? $activity->type;
                    @endphp

                    <div class="ca-report-item type-{{ $type }}">
                        <div class="ca-report-row">
                            <h3 class="ca-report-item-title">
                                {{ $activity->title }}
                            </h3>

                            <div class="ca-report-date">
                                @if($activity->occurred_at)
                                    {{ $activity->occurred_at->format('d/m/') }}{{ $activity->occurred_at->year + 543 }}
                                    {{ $activity->occurred_at->format('H:i') }} น.
                                @else
                                    -
                                @endif
                            </div>
                        </div>

                        @if($activity->description)
                            <div class="ca-report-desc">
                                {{ $activity->description }}
                            </div>
                        @endif

                        <div class="ca-report-meta">
                            @if($activity->module)
                                <span class="ca-chip">หมวด: {{ $moduleName }}</span>
                            @endif

                            @if($activity->user)
                                <span class="ca-chip">ผู้บันทึก: {{ $activity->user->name }}</span>
                            @endif

                            @if($activity->type)
                                <span class="ca-chip">ระดับ: {{ $typeName }}</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="ca-empty">
                ยังไม่มีประวัติความเคลื่อนไหวของเคสนี้
            </div>
        @endif

        <div class="ca-signature">
            <div>
                <div class="ca-sign-line">
                    ผู้จัดทำรายงาน
                </div>
            </div>

            <div>
                <div class="ca-sign-line">
                    ผู้ตรวจสอบ
                </div>
            </div>
        </div>

    </div>
</div>
@endsection