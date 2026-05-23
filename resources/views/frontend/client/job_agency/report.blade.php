@extends('admin_client.admin_client')
@section('content')

@php
    use Carbon\Carbon;

    if (!function_exists('thaiDateJobReportOfficial')) {
        function thaiDateJobReportOfficial($date) {
            if (!$date) return '-';

            try {
                $d = Carbon::parse($date);
                $months = [
                    1 => 'ม.ค.',
                    2 => 'ก.พ.',
                    3 => 'มี.ค.',
                    4 => 'เม.ย.',
                    5 => 'พ.ค.',
                    6 => 'มิ.ย.',
                    7 => 'ก.ค.',
                    8 => 'ส.ค.',
                    9 => 'ก.ย.',
                    10 => 'ต.ค.',
                    11 => 'พ.ย.',
                    12 => 'ธ.ค.',
                ];

                return $d->day . ' ' . $months[(int) $d->month] . ' ' . ($d->year + 543);
            } catch (\Exception $e) {
                return $date;
            }
        }
    }

    $printedAt = now();
    $printedAtThai = thaiDateJobReportOfficial($printedAt) . ' เวลา ' . $printedAt->format('H:i') . ' น.';
@endphp

<div class="container-fluid jr-official-page">
    <div class="jr-official-shell">
        <div class="jr-official-card">

            <div class="jr-official-toolbar">
                <a href="{{ route('job_agencies.show', $client->id) }}" class="btn btn-outline-secondary jr-official-btn">
                    <i class="bi bi-arrow-left-circle"></i>
                    <span>กลับหน้ารายการ</span>
                </a>

                <button type="button" onclick="window.print()" class="btn btn-primary jr-official-btn">
                    <i class="bi bi-printer"></i>
                    <span>พิมพ์รายงาน</span>
                </button>
            </div>

            <div class="jr-official-header">
               

                <h1 class="jr-official-title">รายงานการจัดหางาน</h1>
                

                <div class="jr-official-meta">
                    <div class="jr-official-meta-row">
                       
                        <div class="jr-official-meta-value">{{ $client->fullname ?? $client->name ?? '-' }}</div>
                    </div>

                   
                </div>
            </div>

            <div class="jr-official-body">
                <div class="jr-official-section-head">
                    <div class="jr-official-section-title">รายละเอียดรายการจัดหางาน</div>
                </div>

                <div class="jr-official-table-wrap">
                    <table class="jr-official-table">
                        <thead>
                            <tr>
                                <th style="width: 64px;">ลำดับ</th>
                                <th style="width: 128px;">วันที่เริ่มงาน</th>
                                <th style="width: 150px;">อาชีพ</th>
                                <th style="width: 170px;">ตำแหน่ง</th>
                                <th style="width: 120px;">รายได้/เดือน</th>
                                <th style="width: 190px;">บริษัท</th>
                                <th style="width: 150px;">ผู้ประสานงาน</th>
                                <th>หมายเหตุ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($jobAgencies as $index => $job)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td class="text-center">{{ thaiDateJobReportOfficial($job->job_date) }}</td>
                                    <td>{{ $job->occupation->occupation_name ?? '-' }}</td>
                                    <td>{{ $job->position ?? '-' }}</td>
                                    <td class="text-end">{{ number_format($job->income ?? 0, 2) }}</td>
                                    <td>{{ $job->company ?? '-' }}</td>
                                    <td>{{ $job->coordinator ?? '-' }}</td>
                                    <td>{{ $job->remark ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">
                                        <div class="jr-official-empty">
                                            <div class="jr-official-empty-icon">
                                                <i class="bi bi-inbox"></i>
                                            </div>
                                            <div class="jr-official-empty-title">ไม่พบข้อมูลรายการจัดหางาน</div>
                                            <div class="jr-official-empty-text">
                                                เมื่อมีการบันทึกข้อมูล ระบบจะแสดงรายละเอียดในรายงานส่วนนี้โดยอัตโนมัติ
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="jr-official-signature">
                    <div class="jr-official-sign-box">
                        <div class="jr-official-sign-line"></div>
                        <div class="jr-official-sign-label">ผู้จัดทำรายงาน</div>
                    </div>

                    <div class="jr-official-sign-box">
                        <div class="jr-official-sign-line"></div>
                        <div class="jr-official-sign-label">ผู้ตรวจสอบ</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    @page {
        size: A4 landscape;
        margin: 10mm 12mm;
    }

    .jr-official-page{
        padding: 14px 0 28px;
    }

    .jr-official-shell{
        width: min(97vw, 1500px);
        margin: 0 auto;
    }

    .jr-official-card{
        background: #ffffff;
        border: 1px solid #dfe5ec;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.05);
        overflow: hidden;
    }

    .jr-official-toolbar{
        padding: 18px 22px 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .jr-official-btn{
        min-height: 42px;
        padding: .65rem 1rem;
        border-radius: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        line-height: 1.2;
        white-space: nowrap;
    }

    .jr-official-header{
        padding: 22px 22px 18px;
        border-bottom: 1px solid #e5e7eb;
    }

    .jr-official-header-top{
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 8px;
    }

    .jr-official-kicker{
        font-size: .82rem;
        font-weight: 700;
        color: #475569;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .jr-official-code{
        font-size: .82rem;
        font-weight: 600;
        color: #64748b;
        letter-spacing: .06em;
        text-transform: uppercase;
    }

    .jr-official-title{
        margin: 0;
        font-size: 1.5rem;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.4;
    }

    .jr-official-subtitle{
        margin: 8px 0 0;
        font-size: .96rem;
        color: #64748b;
        line-height: 1.7;
        max-width: 900px;
    }

    .jr-official-meta{
        margin-top: 18px;
        border-top: 1px solid #eef2f7;
        padding-top: 14px;
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 10px 24px;
    }

    .jr-official-meta-row{
        min-width: 0;
    }

    .jr-official-meta-label{
        font-size: .84rem;
        font-weight: 600;
        color: #64748b;
        margin-bottom: 4px;
    }

    .jr-official-meta-value{
        font-size: .97rem;
        font-weight: 600;
        color: #111827;
        line-height: 1.6;
        word-break: break-word;
    }

    .jr-official-body{
        padding: 22px;
    }

    .jr-official-section-head{
        margin-bottom: 12px;
    }

    .jr-official-section-title{
        font-size: 1rem;
        font-weight: 700;
        color: #111827;
    }

    .jr-official-table-wrap{
        border: 1px solid #dbe2ea;
        border-radius: 14px;
        overflow-x: auto;
        background: #fff;
    }

    .jr-official-table{
        width: 100%;
        min-width: 1160px;
        border-collapse: collapse;
        table-layout: fixed;
        margin: 0;
    }

    .jr-official-table thead th{
        background: #f8fafc;
        color: #1f2937;
        font-size: .92rem;
        font-weight: 700;
        text-align: center;
        vertical-align: middle;
        padding: 12px 10px;
        border-bottom: 1px solid #dbe2ea;
        border-right: 1px solid #e5e7eb;
        line-height: 1.45;
    }

    .jr-official-table thead th:last-child{
        border-right: none;
    }

    .jr-official-table tbody td{
        padding: 12px 10px;
        border-bottom: 1px solid #edf1f5;
        border-right: 1px solid #edf1f5;
        vertical-align: top;
        color: #111827;
        font-size: .93rem;
        line-height: 1.65;
        word-break: break-word;
    }

    .jr-official-table tbody td:last-child{
        border-right: none;
    }

    .jr-official-table tbody tr:last-child td{
        border-bottom: none;
    }

    .jr-official-empty{
        padding: 34px 18px;
        text-align: center;
        color: #6b7280;
    }

    .jr-official-empty-icon{
        width: 58px;
        height: 58px;
        border-radius: 999px;
        margin: 0 auto 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #e2e8f0;
        color: #475569;
        font-size: 1.35rem;
    }

    .jr-official-empty-title{
        margin-bottom: 6px;
        font-size: 1.05rem;
        font-weight: 700;
        color: #0f172a;
    }

    .jr-official-empty-text{
        font-size: .94rem;
        line-height: 1.7;
    }

    .jr-official-signature{
        margin-top: 26px;
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 40px;
    }

    .jr-official-sign-box{
        text-align: center;
        color: #374151;
    }

    .jr-official-sign-line{
        border-top: 1px solid #9ca3af;
        margin-top: 38px;
        padding-top: 8px;
    }

    .jr-official-sign-label{
        font-size: .92rem;
        font-weight: 600;
    }

  @page{
    size:A4 landscape;
    margin:10mm 14mm;
}

@media print{

    html,
    body{
        width:297mm !important;
        min-height:210mm !important;
        margin:0 !important;
        padding:0 !important;
        background:#fff !important;
        font-family:"TH Sarabun New","Sarabun",sans-serif !important;
        overflow:visible !important;
        -webkit-print-color-adjust:exact !important;
        print-color-adjust:exact !important;
    }

    .navbar-custom,
    .leftside-menu,
    .footer,
    .topbar,
    .page-title-box,
    .jr-official-toolbar,
    header,
    footer{
        display:none !important;
    }

    .content-page,
    .content,
    .container-fluid{
        width:100% !important;
        max-width:100% !important;
        margin:0 auto !important;
        padding:0 !important;
        overflow:visible !important;
        background:#fff !important;
    }

    .jr-official-page{
        width:100% !important;
        max-width:100% !important;
        margin:0 auto !important;
        padding:0 !important;
        overflow:visible !important;
        background:#fff !important;
    }

    .jr-official-shell{
        width:100% !important;
        max-width:100% !important;
        min-height:auto !important;
        margin:0 auto !important;
        padding:0 !important;
        overflow:visible !important;
        page-break-after:avoid !important;
        break-after:avoid !important;
    }

    .jr-official-card{
        border:none !important;
        border-radius:0 !important;
        box-shadow:none !important;
        overflow:visible !important;
        background:#fff !important;
    }

    .jr-official-header{
        text-align:center !important;
        padding:0 0 6px !important;
        margin:0 0 6px !important;
        border-bottom:1px solid #cbd5e1 !important;
    }

    .jr-official-title{
        font-size:20px !important;
        font-weight:900 !important;
        line-height:1.1 !important;
        color:#0f172a !important;
        margin:0 !important;
    }

    .jr-official-subtitle{
        font-size:11px !important;
        color:#64748b !important;
        margin-top:2px !important;
        line-height:1.1 !important;
        font-weight:600 !important;
    }

    .jr-official-body{
        padding:0 !important;
        margin:0 !important;
    }

    .jr-official-meta{
        display:flex !important;
        align-items:center !important;
        justify-content:flex-start !important;
        flex-wrap:wrap !important;
        gap:4px 22px !important;
        margin:0 0 6px !important;
        padding:0 0 5px 4px !important;
        border-bottom:1px solid #dbe4f0 !important;
    }

    .jr-official-meta > *{
        border:none !important;
        background:none !important;
        box-shadow:none !important;
        padding:0 !important;
        margin:0 !important;
        min-width:auto !important;
        width:auto !important;
        flex:none !important;
        font-size:12.5px !important;
        font-weight:800 !important;
        color:#2563eb !important;
        line-height:1.1 !important;
    }

    .jr-official-table-wrap{
        width:100% !important;
        max-width:100% !important;
        overflow:visible !important;
        border:none !important;
        border-radius:0 !important;
        margin:0 !important;
        padding:0 !important;
    }

    .jr-official-table{
        width:100% !important;
        min-width:0 !important;
        max-width:100% !important;
        margin:0 !important;
        table-layout:fixed !important;
        border-collapse:collapse !important;
        border-spacing:0 !important;
        background:#fff !important;
        page-break-inside:auto !important;
    }

    .jr-official-table thead{
        display:table-header-group !important;
    }

    .jr-official-table tr{
        page-break-inside:avoid !important;
        break-inside:avoid !important;
    }

    .jr-official-table thead th{
        background:#eef4ff !important;
        color:#0f172a !important;
        border:1px solid #111827 !important;
        text-align:center !important;
        vertical-align:middle !important;
        padding:3px 3px !important;
        font-size:10px !important;
        font-weight:900 !important;
        line-height:1.08 !important;
        white-space:normal !important;
    }

    .jr-official-table tbody td,
    .jr-official-table tfoot td{
        border:1px solid #111827 !important;
        padding:3px 3px !important;
        font-size:9.8px !important;
        font-weight:600 !important;
        color:#111827 !important;
        line-height:1.08 !important;
        vertical-align:middle !important;
        white-space:normal !important;
        word-break:break-word !important;
        overflow-wrap:anywhere !important;
        text-align:center !important;
    }

    .jr-official-table tbody tr:nth-child(even){
        background:#fcfdff !important;
    }

    .jr-official-table tfoot td{
        background:#f8fafc !important;
        font-weight:900 !important;
    }

    .jr-official-signature{
        display:grid !important;
        grid-template-columns:repeat(2,minmax(0,1fr)) !important;
        gap:20px !important;
        margin-top:16px !important;
        page-break-inside:avoid !important;
        break-inside:avoid !important;
    }

    .jr-official-signature *{
        font-size:11px !important;
        line-height:1.15 !important;
    }

    .jr-official-sign-line{
        margin-top:18px !important;
    }

    .jr-official-empty{
        border:1px dashed #94a3b8 !important;
        border-radius:0 !important;
        padding:14px !important;
        text-align:center !important;
        color:#475569 !important;
        font-size:12px !important;
    }
}
</style>
@endsection