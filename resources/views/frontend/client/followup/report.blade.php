@extends('admin_client.admin_client')

@section('content')
@php
    use Carbon\Carbon;

    $thaiMonths = [
        1 => 'มกราคม',
        2 => 'กุมภาพันธ์',
        3 => 'มีนาคม',
        4 => 'เมษายน',
        5 => 'พฤษภาคม',
        6 => 'มิถุนายน',
        7 => 'กรกฎาคม',
        8 => 'สิงหาคม',
        9 => 'กันยายน',
        10 => 'ตุลาคม',
        11 => 'พฤศจิกายน',
        12 => 'ธันวาคม',
    ];

    $dateRangeThai = 'ทั้งหมด';
    if (!empty($dateFrom) || !empty($dateTo)) {
        $fromText = !empty($dateFrom)
            ? Carbon::parse($dateFrom)->day . ' ' . $thaiMonths[Carbon::parse($dateFrom)->month] . ' ' . (Carbon::parse($dateFrom)->year + 543)
            : 'ไม่กำหนด';

        $toText = !empty($dateTo)
            ? Carbon::parse($dateTo)->day . ' ' . $thaiMonths[Carbon::parse($dateTo)->month] . ' ' . (Carbon::parse($dateTo)->year + 543)
            : 'ไม่กำหนด';

        $dateRangeThai = $fromText . ' ถึง ' . $toText;
    }
@endphp

<style>
/* ============================= */
/* BASE + PAGE */
/* ============================= */

@page {
    size: A4 portrait;
    margin: 14mm 12mm;
}

.followup-report-page{
    padding: 16px 0 28px;
}

/* ✅ แก้ปัญหาหน้าแคบ */
.followup-report-shell{
    width: min(96vw, 1400px);
    margin: 0 auto;
}

/* ============================= */
/* CARD */
/* ============================= */

.followup-report-card{
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 18px;
    box-shadow: 0 10px 28px rgba(15, 23, 42, 0.05);
    overflow: hidden;
}

/* ============================= */
/* TOOLBAR */
/* ============================= */

.followup-report-toolbar{
    padding: 18px 22px 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
}

.followup-report-toolbar-group{
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.followup-report-toolbar .btn{
    min-height: 42px;
    padding: .65rem 1rem;
    border-radius: 12px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

/* ============================= */
/* HEADER */
/* ============================= */

.followup-report-header{
    padding: 22px;
    border-bottom: 1px solid #e5e7eb;
}

.followup-report-title{
    font-size: 1.4rem;
    font-weight: 700;
    margin: 0;
}

.followup-report-subtitle{
    margin-top: 6px;
    font-size: .95rem;
    color: #6b7280;
}

/* ============================= */
/* INFO LINE (ใหม่) */
/* ============================= */

.followup-report-info{
    margin-top: 14px;
    padding-top: 12px;
    border-top: 1px solid #eef2f7;

    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px 20px;
}

.followup-report-info-item{
    display: flex;
    gap: 6px;
    font-size: .95rem;
}

.followup-report-info-label{
    font-weight: 600;
    color: #374151;
}

.followup-report-info-value{
    color: #111827;
}

/* ============================= */
/* BODY */
/* ============================= */

.followup-report-body{
    padding: 22px;
}

.followup-report-section-title{
    font-size: 1rem;
    font-weight: 700;
    margin-bottom: 12px;
}

/* ============================= */
/* TABLE */
/* ============================= */

.followup-report-table-wrap{
    border: 1px solid #dbe2ea;
    border-radius: 14px;
    overflow: hidden;
}

.followup-report-table{
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed;
}

.followup-report-table thead th{
    background: #f8fafc;
    font-weight: 700;
    text-align: center;
    padding: 12px;
    border-bottom: 1px solid #dbe2ea;
    border-right: 1px solid #e5e7eb;
    font-size: .93rem;
}

.followup-report-table thead th:last-child{
    border-right: none;
}

.followup-report-table td{
    padding: 12px;
    border-bottom: 1px solid #edf1f5;
    border-right: 1px solid #edf1f5;
    vertical-align: top;
    font-size: .94rem;
}

.followup-report-table td:last-child{
    border-right: none;
}

.followup-report-table tr:last-child td{
    border-bottom: none;
}

/* column */
.followup-col-date{
    width: 18%;
    text-align: center;
    white-space: nowrap;
}

.followup-col-detail{
    width: 52%;
}

.followup-col-note{
    width: 30%;
}

.text-preline{
    white-space: pre-line;
}

/* ============================= */
/* EMPTY */
/* ============================= */

.followup-report-empty{
    border: 1px dashed #cbd5e1;
    border-radius: 16px;
    padding: 32px;
    text-align: center;
}

/* ============================= */
/* RESPONSIVE */
/* ============================= */

/* Tablet */
@media (max-width: 1200px){
    .followup-report-shell{
        width: min(96vw, 1100px);
    }
}

/* Mobile */
@media (max-width: 768px){

    .followup-report-page{
        padding: 10px 0;
    }

    .followup-report-toolbar,
    .followup-report-header,
    .followup-report-body{
        padding-left: 16px;
        padding-right: 16px;
    }

    .followup-report-toolbar-group{
        width: 100%;
    }

    .followup-report-toolbar .btn{
        width: 100%;
        justify-content: center;
    }

    .followup-report-info{
        grid-template-columns: 1fr;
    }

    .followup-report-table-wrap{
        overflow-x: auto;
    }

    .followup-report-table{
        min-width: 700px;
    }
}

/* ============================= */
/* PRINT */
/* ============================= */

@media print{

    @page {
        size: A4 portrait;
        margin: 12mm;
    }

    .navbar-custom,
    .leftside-menu,
    .footer,
    .topbar,
    .page-title-box,
    .followup-report-toolbar{
        display: none !important;
    }

    .content-page,
    .content,
    .container-fluid{
        padding: 0 !important;
        margin: 0 !important;
    }

    .followup-report-shell{
        width: 100% !important;
        max-width: 100% !important;
        margin: 0 !important;
    }

    .followup-report-card{
        border: none !important;
        border-radius: 0 !important;
        box-shadow: none !important;
    }

    .followup-report-body{
        padding: 10px 0 !important;
    }
}
</style>

<div class="container-fluid followup-report-page">
    <div class="followup-report-shell">
        <div class="followup-report-card">
            <div class="followup-report-toolbar">
                <div class="followup-report-toolbar-group">
                    <a href="{{ route('followup.index', $client->id) }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left-circle"></i>
                        <span>กลับหน้ารายการ</span>
                    </a>
                </div>

                <div class="followup-report-toolbar-group">
                    <button type="button" onclick="window.print();" class="btn btn-primary">
                        <i class="bi bi-printer"></i>
                        <span>พิมพ์รายงาน</span>
                    </button>
                </div>
            </div>

            <div class="followup-report-header">
                <h1 class="followup-report-title">รายงานการช่วยเหลือและติดตามผล</h1>
                <p class="followup-report-subtitle">
                    เอกสารสรุปข้อมูลการช่วยเหลือและติดตามผลของผู้รับบริการ สำหรับตรวจสอบและพิมพ์รายงาน
                </p>

                <div class="followup-report-info">
                    <div class="followup-report-info-item">
                        <div class="followup-report-info-label">รหัสผู้รับบริการ:</div>
                        <div class="followup-report-info-value">{{ $client->id }}</div>
                    </div>

                    <div class="followup-report-info-item">
                        <div class="followup-report-info-label">ชื่อผู้รับบริการ:</div>
                        <div class="followup-report-info-value">{{ $client->fullname ?? $client->name ?? '-' }}</div>
                    </div>

                    <div class="followup-report-info-item">
                        <div class="followup-report-info-label">ช่วงวันที่:</div>
                        <div class="followup-report-info-value">{{ $dateRangeThai }}</div>
                    </div>
                </div>
            </div>

            <div class="followup-report-body">
                <h2 class="followup-report-section-title">รายละเอียดรายการ</h2>

                @if($followups->count() > 0)
                    <div class="followup-report-table-wrap">
                        <table class="followup-report-table">
                            <thead>
                                <tr>
                                    <th class="followup-col-date">วันเดือนปี</th>
                                    <th class="followup-col-detail">การช่วยเหลือและติดตามผล</th>
                                    <th class="followup-col-note">หมายเหตุ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($followups as $item)
                                    @php
                                        $date = Carbon::parse($item->followup_date);
                                        $thaiDate = $date->day . ' ' . $thaiMonths[$date->month] . ' ' . ($date->year + 543);
                                    @endphp
                                    <tr>
                                        <td class="followup-col-date">{{ $thaiDate }}</td>
                                        <td class="followup-col-detail text-preline">{{ $item->assistance_detail }}</td>
                                        <td class="followup-col-note text-preline">{{ $item->note ?: '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="followup-report-empty">
                        <div class="followup-report-empty-icon">
                            <i class="bi bi-inbox"></i>
                        </div>
                        <h4>ยังไม่มีข้อมูลติดตามผล</h4>
                        <p>เมื่อมีการบันทึกข้อมูล ระบบจะแสดงรายการในส่วนนี้โดยอัตโนมัติ</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection