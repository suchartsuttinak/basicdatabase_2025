@extends('admin_client.admin_client')

@section('content')

@php
    use Carbon\Carbon;

    function thaidate($date) {
        if (!$date) return '-';
        try {
            $d = $date instanceof \Carbon\Carbon ? $date : Carbon::parse($date);
            return $d->format('d/m/') . ($d->year + 543);
        } catch (\Exception $e) {
            return '-';
        }
    }

    function thaidatetime($date) {
        if (!$date) return '-';
        try {
            $d = $date instanceof \Carbon\Carbon ? $date : Carbon::parse($date);
            return $d->format('d/m/') . ($d->year + 543) . ' ' . $d->format('H:i') . ' น.';
        } catch (\Exception $e) {
            return '-';
        }
    }

    $followCount = $escape->follows ? $escape->follows->count() : 0;
    $clientFullName = trim(($client->prefix ?? '') . ($client->first_name ?? '') . ' ' . ($client->last_name ?? '')) ?: '-';
@endphp

<div class="container-fluid escape-report-page">
    <div class="escape-report-shell">

        {{-- Header --}}
        <div class="escape-report-head">
            <div class="escape-report-head__left">
                <div class="escape-report-head__eyebrow">
                    <i class="bi bi-file-earmark-text"></i>
                    <span>รายงานข้อมูลการออกจากสถานสงเคราะห์</span>
                </div>

                <h1 class="escape-report-head__title">รายงานรายละเอียดการออกจากสถานสงเคราะห์</h1>

                <p class="escape-report-head__desc">
                    แสดงข้อมูลเหตุการณ์หลัก ประเภทการออก และประวัติการติดตามทั้งหมด
                </p>
            </div>

            <div class="escape-report-head__right no-print">
                <button type="button" onclick="window.print()" class="btn escape-report-btn escape-report-btn--primary">
                    <i class="bi bi-printer"></i>
                    <span>พิมพ์</span>
                </button>

                <a href="{{ route('escape.index', $client->id) }}" class="btn escape-report-btn escape-report-btn--light">
                    <i class="bi bi-arrow-left-circle"></i>
                    <span>กลับหน้ารายการ</span>
                </a>
            </div>
        </div>

        <div class="escape-report-card">
            <div class="escape-report-table-wrap">
                <table class="escape-report-table">
                    <tbody>
                        {{-- สรุปข้อมูล --}}
                        <tr class="escape-report-table__section">
                            <td colspan="4">สรุปข้อมูลสำคัญ</td>
                        </tr>
                        <tr>
                            <th>ชื่อ-สกุล</th>
                            <td>{{ $clientFullName }}</td>
                            <th>ประเภทการออก</th>
                            <td>{{ $escape->retire->retire_name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>วันที่ออก</th>
                            <td>{{ thaidate($escape->retire_date) }}</td>
                            <th>จำนวนครั้งที่ติดตาม</th>
                            <td>{{ $followCount }} ครั้ง</td>
                        </tr>
                        <tr>
                            <th>บันทึกเมื่อ</th>
                            <td>{{ thaidatetime($escape->created_at) }}</td>
                            <th>สถานะรายการ</th>
                            <td>{{ $followCount > 0 ? 'มีประวัติการติดตาม' : 'ยังไม่มีการติดตาม' }}</td>
                        </tr>

                        {{-- รายละเอียดเหตุการณ์ --}}
                        <tr class="escape-report-table__section">
                            <td colspan="4">รายละเอียดเหตุการณ์</td>
                        </tr>
                        <tr>
                            <th>พฤติการณ์ / สาเหตุ / เรื่องราว</th>
                            <td colspan="3" class="escape-report-text">
                                {!! nl2br(e($escape->stories ?: '-')) !!}
                            </td>
                        </tr>

                        {{-- ประวัติการติดตาม --}}
                        <tr class="escape-report-table__section">
                            <td colspan="4">ประวัติการติดตาม</td>
                        </tr>

                        @if($followCount > 0)
                            @foreach($escape->follows as $follow)
                                <tr class="escape-follow-divider">
                                    <td colspan="4">
                                        <div class="escape-follow-divider__wrap">
                                            <span class="escape-follow-divider__title">ครั้งที่ {{ $follow->count ?: '-' }}</span>
                                            <span class="escape-follow-divider__date">วันที่ติดตาม {{ thaidate($follow->trace_date) }}</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>การติดตาม</th>
                                    <td>{{ $follow->trac_no ?: '-' }}</td>
                                    <th>วันที่รายงาน</th>
                                    <td>{{ thaidate($follow->report_date) }}</td>
                                </tr>
                                <tr>
                                    <th>วันที่ยุติ</th>
                                    <td>{{ thaidate($follow->stop_date) }}</td>
                                    <th>วันที่ลงโทษ</th>
                                    <td>{{ thaidate($follow->punish_date) }}</td>
                                </tr>
                                <tr>
                                    <th>รายละเอียดการติดตาม</th>
                                    <td colspan="3" class="escape-report-text">
                                        {!! nl2br(e($follow->detail ?: '-')) !!}
                                    </td>
                                </tr>
                                <tr>
                                    <th>การลงโทษ</th>
                                    <td colspan="3" class="escape-report-text">
                                        {!! nl2br(e($follow->punish ?: '-')) !!}
                                    </td>
                                </tr>
                                <tr class="@if(!$loop->last) escape-follow-row-end @endif">
                                    <th>หมายเหตุ</th>
                                    <td colspan="3" class="escape-report-text">
                                        {!! nl2br(e($follow->remark ?: '-')) !!}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" class="escape-report-empty-row">
                                    <div class="escape-report-empty">
                                        <div class="escape-report-empty__icon">
                                            <i class="bi bi-inboxes"></i>
                                        </div>
                                        <div class="escape-report-empty__title">ยังไม่มีข้อมูลการติดตาม</div>
                                        <div class="escape-report-empty__desc">
                                            เมื่อมีการบันทึกข้อมูลติดตาม ระบบจะแสดงรายละเอียดในส่วนนี้โดยอัตโนมัติ
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<style>
.escape-report-page{
    padding:22px 12px 34px;
    background:linear-gradient(180deg, #f8fbff 0%, #f4f7fb 100%);
}

.escape-report-page .escape-report-shell{
    max-width:1200px;
    margin:0 auto;
}

.escape-report-page .escape-report-head{
    display:flex;
    align-items:flex-start;
    justify-content:space-between;
    gap:20px;
    flex-wrap:wrap;
    padding:0 0 20px;
    margin-bottom:20px;
    border-bottom:1px solid #e6edf5;
}

.escape-report-page .escape-report-head__left{
    min-width:0;
    flex:1 1 700px;
}

.escape-report-page .escape-report-head__eyebrow{
    display:inline-flex;
    align-items:center;
    gap:8px;
    padding:7px 13px;
    margin-bottom:12px;
    border-radius:999px;
    background:#edf4ff;
    color:#3558c8;
    font-size:.88rem;
    font-weight:700;
    letter-spacing:.01em;
}

.escape-report-page .escape-report-head__title{
    margin:0 0 8px;
    font-size:clamp(1.55rem, 2vw, 2rem);
    font-weight:800;
    color:#0f172a;
    letter-spacing:-0.02em;
}

.escape-report-page .escape-report-head__desc{
    margin:0;
    max-width:780px;
    color:#64748b;
    font-size:.97rem;
    line-height:1.8;
}

.escape-report-page .escape-report-head__right{
    display:flex;
    align-items:center;
    gap:10px;
    flex-wrap:wrap;
}

.escape-report-page .escape-report-btn{
    display:inline-flex;
    align-items:center;
    gap:8px;
    padding:10px 16px;
    border-radius:14px;
    font-weight:700;
    font-size:.94rem;
    white-space:nowrap;
    border:1px solid transparent;
    transition:all .2s ease;
    text-decoration:none;
}

.escape-report-page .escape-report-btn--primary{
    background:#ffffff;
    border-color:#d9e5f2;
    color:#0f172a;
    box-shadow:0 4px 14px rgba(15, 23, 42, 0.04);
}

.escape-report-page .escape-report-btn--primary:hover{
    background:#f8fbff;
    border-color:#cbd9ea;
    color:#0f172a;
}

.escape-report-page .escape-report-btn--light{
    background:#ffffff;
    border-color:#e3ebf4;
    color:#475569;
    box-shadow:0 4px 14px rgba(15, 23, 42, 0.03);
}

.escape-report-page .escape-report-btn--light:hover{
    background:#f8fbff;
    border-color:#d6e1ec;
    color:#334155;
}

.escape-report-page .escape-report-card{
    background:#ffffff;
    border:1px solid #e6edf5;
    border-radius:20px;
    overflow:hidden;
    box-shadow:0 10px 30px rgba(15, 23, 42, 0.035);
}

.escape-report-page .escape-report-table-wrap{
    width:100%;
    overflow-x:auto;
}

.escape-report-page .escape-report-table{
    width:100%;
    min-width:980px;
    border-collapse:separate;
    border-spacing:0;
    color:#1e293b;
}

.escape-report-page .escape-report-table th,
.escape-report-page .escape-report-table td{
    padding:13px 16px;
    font-size:.95rem;
    line-height:1.75;
    vertical-align:top;
    word-break:break-word;
    border-bottom:1px solid #edf2f7;
}

.escape-report-page .escape-report-table tbody th{
    width:190px;
    background:#fbfdff;
    color:#334155;
    font-weight:700;
    border-right:1px solid #edf2f7;
}

.escape-report-page .escape-report-table tbody td{
    background:#ffffff;
}

.escape-report-page .escape-report-table__section td{
    padding:11px 16px;
    background:linear-gradient(180deg, #f7faff 0%, #f3f7fc 100%);
    color:#0f172a;
    font-size:.96rem;
    font-weight:800;
    letter-spacing:-0.01em;
    border-bottom:1px solid #e5edf6;
}

.escape-report-page .escape-report-text{
    white-space:normal;
    color:#1e293b;
}

.escape-report-page .escape-follow-divider td{
    padding:12px 16px;
    background:#f8fbff !important;
    border-bottom:1px solid #e4edf6;
}

.escape-report-page .escape-follow-divider__wrap{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:12px;
    flex-wrap:wrap;
}

.escape-report-page .escape-follow-divider__title{
    color:#0f172a;
    font-size:.95rem;
    font-weight:800;
    letter-spacing:-0.01em;
}

.escape-report-page .escape-follow-divider__date{
    color:#475569;
    font-size:.86rem;
    font-weight:700;
}

.escape-report-page .escape-follow-row-end th,
.escape-report-page .escape-follow-row-end td{
    border-bottom:1px solid #dbe6f1;
}

.escape-report-page .escape-report-empty-row{
    padding:0 !important;
    background:#ffffff !important;
}

.escape-report-page .escape-report-empty{
    padding:34px 18px;
    text-align:center;
}

.escape-report-page .escape-report-empty__icon{
    width:64px;
    height:64px;
    margin:0 auto 12px;
    display:grid;
    place-items:center;
    border-radius:20px;
    background:#f8fafc;
    color:#94a3b8;
    font-size:1.5rem;
}

.escape-report-page .escape-report-empty__title{
    margin-bottom:6px;
    color:#1e293b;
    font-size:1rem;
    font-weight:800;
}

.escape-report-page .escape-report-empty__desc{
    color:#64748b;
    font-size:.92rem;
    line-height:1.7;
    max-width:460px;
    margin:0 auto;
}

@media (max-width: 991.98px){
    .escape-report-page .escape-report-table{
        min-width:900px;
    }
}

@media (max-width: 767.98px){
    .escape-report-page{
        padding:16px 8px 24px;
    }

    .escape-report-page .escape-report-head{
        gap:14px;
        margin-bottom:18px;
        padding-bottom:16px;
    }

    .escape-report-page .escape-report-head__right{
        width:100%;
        overflow-x:auto;
        flex-wrap:nowrap;
        padding-bottom:2px;
    }

    .escape-report-page .escape-report-btn{
        flex:0 0 auto;
    }

    .escape-report-page .escape-report-table{
        min-width:820px;
    }

    .escape-report-page .escape-report-table th,
    .escape-report-page .escape-report-table td{
        padding:11px 12px;
        font-size:.92rem;
    }

    .escape-report-page .escape-report-table tbody th{
        width:160px;
    }

    .escape-report-page .escape-report-card{
        border-radius:16px;
    }

    .escape-report-page .escape-follow-divider td{
        padding:10px 12px;
    }

    .escape-report-page .escape-follow-divider__wrap{
        flex-direction:column;
        align-items:flex-start;
    }
}

/* PRINT */
@media print{
    @page{
        size:A4 landscape;
        margin:10mm;
    }

    html, body{
        background:#ffffff !important;
        margin:0 !important;
        padding:0 !important;
    }

    body *{
        visibility:hidden;
    }

    .escape-report-page,
    .escape-report-page *{
        visibility:visible;
    }

    .escape-report-page{
        background:#ffffff !important;
        padding:0 !important;
        margin:0 !important;
    }

    .escape-report-page .escape-report-shell{
        max-width:100% !important;
        margin:0 !important;
        padding:0 !important;
    }

    .escape-report-page .escape-report-head{
        margin-bottom:10px !important;
        padding-bottom:10px !important;
        border-bottom:1px solid #cfd8e3 !important;
    }

    .escape-report-page .escape-report-head__eyebrow{
        background:#ffffff !important;
        border:1px solid #d9e2ec !important;
        color:#0f172a !important;
        padding:4px 10px !important;
    }

    .escape-report-page .escape-report-head__title{
        font-size:18pt !important;
        margin-bottom:4px !important;
    }

    .escape-report-page .escape-report-head__desc{
        font-size:10pt !important;
        color:#475569 !important;
        line-height:1.5 !important;
        max-width:none !important;
    }

    .no-print{
        display:none !important;
    }

    .escape-report-page .escape-report-card{
        border:1px solid #cfd8e3 !important;
        box-shadow:none !important;
        border-radius:0 !important;
    }

    .escape-report-page .escape-report-table-wrap{
        overflow:visible !important;
    }

    .escape-report-page .escape-report-table{
        min-width:0 !important;
        width:100% !important;
        table-layout:fixed;
    }

    .escape-report-page .escape-report-table th,
    .escape-report-page .escape-report-table td{
        padding:6px 8px !important;
        font-size:9.5pt !important;
        line-height:1.35 !important;
        color:#000000 !important;
        border-bottom:1px solid #d7dee8 !important;
    }

    .escape-report-page .escape-report-table tbody th{
        width:120px !important;
        background:#f7f7f7 !important;
        border-right:1px solid #d7dee8 !important;
    }

    .escape-report-page .escape-report-table__section td{
        background:#f2f4f7 !important;
        color:#000000 !important;
        font-size:10pt !important;
        font-weight:700 !important;
        padding:6px 8px !important;
        border-bottom:1px solid #cfd8e3 !important;
    }

    .escape-report-page .escape-follow-divider td{
        background:#f8f8f8 !important;
        padding:6px 8px !important;
        border-bottom:1px solid #d7dee8 !important;
    }

    .escape-report-page .escape-follow-divider__title{
        font-size:9pt !important;
        color:#000 !important;
    }

    .escape-report-page .escape-follow-divider__date{
        font-size:8pt !important;
        color:#444 !important;
    }

    .escape-report-page .escape-report-empty{
        padding:20px 10px !important;
    }

    .escape-report-page .escape-report-empty__icon{
        display:none !important;
    }

    .escape-report-page .escape-report-card,
    .escape-report-page .escape-report-table,
    .escape-report-page .escape-report-table tr,
    .escape-report-page .escape-report-table td,
    .escape-report-page .escape-report-table th{
        page-break-inside:avoid !important;
    }

    a, button{
        text-decoration:none !important;
        color:#000000 !important;
    }
}
</style>

@endsection