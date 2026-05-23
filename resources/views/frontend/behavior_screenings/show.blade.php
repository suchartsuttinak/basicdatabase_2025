@extends('admin_client.admin_client')

@section('content')
<style>

    .report-shell{
        max-width:1200px;
        margin:auto;
    }

    .report-card{
        border:none;
        border-radius:20px;
        overflow:hidden;
        box-shadow:0 10px 30px rgba(0,0,0,.06);
    }

    .report-header{
        background:linear-gradient(135deg,#1d4ed8,#2563eb);
        color:#fff;
        padding:28px;
    }

    .report-title{
        font-size:1.7rem;
        font-weight:700;
        margin-bottom:8px;
    }

    .report-subtitle{
        opacity:.9;
    }

    .report-body{
        padding:30px;
        background:#fff;
    }

    .info-grid{
        display:grid;
        grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
        gap:16px;
        margin-bottom:24px;
    }

    .info-box{
        border:1px solid #e5e7eb;
        border-radius:14px;
        padding:16px;
        background:#f8fafc;
    }

    .info-label{
        font-size:.9rem;
        color:#64748b;
        margin-bottom:6px;
    }

    .info-value{
        font-weight:700;
        color:#0f172a;
    }

    .score-grid{
        display:grid;
        grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
        gap:20px;
        margin-bottom:30px;
    }

    .score-card{
        border-radius:18px;
        color:#fff;
        padding:24px;
        position:relative;
        overflow:hidden;
    }

    .score-card h4{
        font-size:1rem;
        margin-bottom:12px;
        opacity:.95;
    }

    .score-value{
        font-size:2.3rem;
        font-weight:700;
        line-height:1;
    }

    .score-status{
        margin-top:12px;
        font-size:.95rem;
    }

    .bg-learning{
        background:#2563eb;
    }

    .bg-ld{
        background:#0891b2;
    }

    .bg-adhd{
        background:#d97706;
    }

    .bg-autism{
        background:#dc2626;
    }

    .section-box{
        border:1px solid #e5e7eb;
        border-radius:18px;
        overflow:hidden;
        margin-bottom:24px;
    }

    .section-header{
        background:#f8fafc;
        padding:16px 20px;
        font-weight:700;
        border-bottom:1px solid #e5e7eb;
    }

    .section-body{
        padding:20px;
        white-space:pre-line;
        line-height:1.8;
    }

    .table-wrap{
        overflow:auto;
    }

    .toolbar{
        display:flex;
        justify-content:space-between;
        gap:12px;
        flex-wrap:wrap;
        margin-bottom:20px;
    }

    @media print{

    body{
        background:#fff !important;
        -webkit-print-color-adjust:exact;
        print-color-adjust:exact;
    }

    .toolbar,
    .main-header,
    .left-side-bar,
    .navbar-custom,
    .footer{
        display:none !important;
    }

    .container-fluid{
        padding:0 !important;
        margin:0 !important;
    }

    .report-shell{
        max-width:100% !important;
        margin:0 !important;
    }

    .report-card{
        box-shadow:none !important;
        border:none !important;
        border-radius:0 !important;
    }

    .report-header{
        background:#fff !important;
        color:#111827 !important;
        padding:0 0 10px 0 !important;
        border-bottom:2px solid #111827;
        text-align:center;
    }

    .report-title{
        font-size:22px !important;
        font-weight:700 !important;
        color:#111827 !important;
        margin:0 0 4px 0 !important;
    }

    .report-subtitle{
        font-size:16px !important;
        color:#374151 !important;
        opacity:1 !important;
        margin:0 !important;
    }

    .report-body{
        padding:12px 0 0 0 !important;
        background:#fff !important;
    }

    .info-grid{
        display:grid !important;
        grid-template-columns:repeat(3, 1fr) !important;
        gap:4px 18px !important;
        margin:8px 0 12px 0 !important;
        border-bottom:1px solid #d1d5db;
        padding-bottom:8px;
    }

    .info-box{
        border:none !important;
        background:#fff !important;
        border-radius:0 !important;
        padding:2px 0 !important;
    }

    .info-label{
        display:inline;
        font-size:15px !important;
        color:#111827 !important;
        margin:0 !important;
        font-weight:600;
    }

    .info-label::after{
        content: " : ";
    }

    .info-value{
        display:inline;
        font-size:15px !important;
        color:#111827 !important;
        font-weight:700 !important;
    }

    .score-grid{
        display:grid !important;
        grid-template-columns:repeat(4, 1fr) !important;
        gap:8px !important;
        margin:10px 0 14px 0 !important;
    }

    .score-card{
        background:#fff !important;
        color:#111827 !important;
        border:1px solid #d1d5db !important;
        border-radius:0 !important;
        padding:8px !important;
    }

    .score-card h4{
        font-size:15px !important;
        color:#111827 !important;
        margin:0 0 4px 0 !important;
        opacity:1 !important;
    }

    .score-value{
        font-size:22px !important;
        color:#111827 !important;
        font-weight:700 !important;
    }

    .score-status{
        font-size:14px !important;
        color:#111827 !important;
        margin-top:2px !important;
    }

    .section-box{
        border:1px solid #111827 !important;
        border-radius:0 !important;
        margin-bottom:10px !important;
        page-break-inside:avoid;
    }

    .section-header{
        background:#f3f4f6 !important;
        color:#111827 !important;
        padding:6px 8px !important;
        font-size:15px !important;
        border-bottom:1px solid #111827 !important;
    }

    .section-body{
        padding:8px !important;
        font-size:15px !important;
        line-height:1.55 !important;
    }

    table{
        font-size:14px !important;
    }

    .badge{
        border:1px solid #111827 !important;
        background:#fff !important;
        color:#111827 !important;
    }

    @page{
        size:A4 portrait;
        margin:10mm;
    }
}

</style>

<div class="container-fluid py-4">

    <div class="report-shell">

        <div class="toolbar">
            <a href="{{ route('behavior-screenings.index', $client->id) }}"
               class="btn btn-light border">
                <i class="bi bi-arrow-left"></i>
                กลับ
            </a>

           <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('behavior-screenings.official-report', $screening->id) }}"
                class="btn btn-outline-primary">
                    <i class="bi bi-file-earmark-text"></i>
                    รายงานแบบฟอร์มราชการ
                </a>

                <a href="{{ route('behavior-screenings.official-report', $screening->id) }}"
   class="btn btn-primary">
    <i class="bi bi-printer"></i>
    พิมพ์รายงาน
</a>
            </div>
        </div>

        <div class="report-card">

            <div class="report-header">

                <div class="report-title">
                    รายงานแบบสังเกตพฤติกรรม 4 โรค
                </div>

                <div class="report-subtitle">
                    ระบบคัดกรองพฤติกรรมเบื้องต้น
                </div>

            </div>

            <div class="report-body">

                <div class="info-grid">

                    <div class="info-box">
                        <div class="info-label">
                            ชื่อผู้รับบริการ
                        </div>

                        <div class="info-value">
                            {{ $client->first_name }} {{ $client->last_name }}
                        </div>
                    </div>

                    <div class="info-box">
                        <div class="info-label">
                            เลขทะเบียน
                        </div>

                        <div class="info-value">
                            {{ $client->register_number ?? '-' }}
                        </div>
                    </div>

                    <div class="info-box">
                        <div class="info-label">
                            วันที่ประเมิน
                        </div>

                        <div class="info-value">
                            {{ $screening->screening_date?->format('d/m/Y') }}
                        </div>
                    </div>

                    <div class="info-box">
                        <div class="info-label">
                            ผู้ประเมิน
                        </div>

                        <div class="info-value">
                            {{ $screening->observer_name ?: '-' }}
                        </div>
                    </div>

                    <div class="info-box">
                        <div class="info-label">
                            อายุ
                        </div>

                        <div class="info-value">
                            {{ $screening->age_text ?: '-' }}
                        </div>
                    </div>

                    <div class="info-box">
                        <div class="info-label">
                            ชั้นเรียน
                        </div>

                        <div class="info-value">
                            {{ $screening->class_level ?: '-' }}
                        </div>
                    </div>

                </div>

                <div class="score-grid">

                    <div class="score-card bg-learning">

                        <h4>ภาวะเรียนรู้ช้า</h4>

                        <div class="score-value">
                            {{ $screening->learning_score }}
                        </div>

                        <div class="score-status">
                            {{ $screening->learning_risk ? 'มีความเสี่ยง' : 'ปกติ' }}
                        </div>

                    </div>

                    <div class="score-card bg-ld">

                        <h4>ภาวะแอลดี (LD)</h4>

                        <div class="score-value">
                            {{ $screening->ld_score }}
                        </div>

                        <div class="score-status">
                            {{ $screening->ld_risk ? 'มีความเสี่ยง' : 'ปกติ' }}
                        </div>

                    </div>

                    <div class="score-card bg-adhd">

                        <h4>ภาวะสมาธิสั้น</h4>

                        <div class="score-value">
                            {{ $screening->adhd_score }}
                        </div>

                        <div class="score-status">
                            {{ $screening->adhd_risk ? 'มีความเสี่ยง' : 'ปกติ' }}
                        </div>

                    </div>

                    <div class="score-card bg-autism">

                        <h4>ภาวะออทิสติก</h4>

                        <div class="score-value">
                            {{ $screening->autism_score }}
                        </div>

                        <div class="score-status">
                            {{ $screening->autism_risk ? 'มีความเสี่ยง' : 'ปกติ' }}
                        </div>

                    </div>

                </div>

                <div class="section-box">

                    <div class="section-header">
                        สรุปผลการประเมิน
                    </div>

                    <div class="section-body">
                        {{ $screening->summary }}
                    </div>

                </div>

                <div class="section-box">

                    <div class="section-header">
                        คำแนะนำ
                    </div>

                    <div class="section-body">
                        {{ $screening->recommendation }}
                    </div>

                </div>

                @if($screening->remark)

                    <div class="section-box">

                        <div class="section-header">
                            หมายเหตุเพิ่มเติม
                        </div>

                        <div class="section-body">
                            {{ $screening->remark }}
                        </div>

                    </div>

                @endif

                <div class="section-box">

                    <div class="section-header">
                        รายละเอียดรายข้อ
                    </div>

                    <div class="table-wrap">

                        <table class="table align-middle mb-0">

                            <thead class="table-light">

                                <tr>
                                    <th width="80">ข้อ</th>
                                    <th>รายการประเมิน</th>
                                    <th width="120">ผล</th>
                                </tr>

                            </thead>

                            <tbody>

                                @foreach($screening->items as $item)

                                    <tr>

                                        <td>
                                            {{ $item->item_no }}
                                        </td>

                                        <td>
                                            {{ $item->question }}
                                        </td>

                                        <td>

                                            @if($item->answer)

                                                <span class="badge bg-success">
                                                    ใช่
                                                </span>

                                            @else

                                                <span class="badge bg-secondary">
                                                    ไม่ใช่
                                                </span>

                                            @endif

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection