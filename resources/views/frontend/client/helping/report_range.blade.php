@extends('admin_client.admin_client')

@section('content')

@php
    use Carbon\Carbon;

    if (!function_exists('thaiDateHelpingRangeReport')) {
        function thaiDateHelpingRangeReport($date) {
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

    $fromDate = request('from');
    $toDate   = request('to');
@endphp

<style>
    /* ============================= */
    /* REPORT LAYOUT (A4 LANDSCAPE) */
    /* ============================= */

    @page {
        size: A4 landscape;
        margin: 10mm 12mm;
    }

    body {
        font-size: 13px;
        color: #111;
    }

    .help-report-page{
        padding: 8px 0;
    }

    .help-report-box{
        background: #fff;
        border: none;
        border-radius: 0;
        padding: 0;
    }

    /* ============================= */
    /* HEADER */
    /* ============================= */

    .help-report-header{
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 12px;
        padding-bottom: 8px;
        border-bottom: 1px solid #ccc;
    }

    .help-report-title{
        margin: 0;
        font-size: 16px;
        font-weight: 700;
    }

    .help-report-subtitle{
        margin: 2px 0 0;
        font-size: 12px;
        color: #555;
    }

    /* ============================= */
    /* META */
    /* ============================= */

    .help-report-meta{
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 6px;
        margin-bottom: 10px;
    }

    .help-report-meta-item{
        border: 1px solid #ddd;
        padding: 6px 8px;
    }

    .help-report-meta-label{
        font-size: 11px;
        color: #666;
    }

    .help-report-meta-value{
        font-size: 13px;
        font-weight: 600;
    }

    /* ============================= */
    /* TABLE */
    /* ============================= */

    .help-report-table-wrap{
        border: 1px solid #000;
    }

    .help-report-table{
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
    }

    .help-report-table th,
    .help-report-table td{
        border: 1px solid #000;
        padding: 6px 6px;
        font-size: 12px;
    }

    .help-report-table thead th{
        background: #f2f2f2;
        font-weight: 700;
        text-align: center;
    }

    .help-col-date{
        text-align: center;
        width: 14%;
    }

    .help-col-item{
        text-align: left;
        width: 36%;
    }

    .help-col-qty{
        text-align: center;
        width: 10%;
    }

    .help-col-unit{
        text-align: right;
        width: 20%;
    }

    .help-col-total{
        text-align: right;
        width: 20%;
        font-weight: 600;
    }

    tfoot th{
        font-weight: 700;
        background: #fafafa;
    }

    /* ============================= */
    /* SIGN */
    /* ============================= */

    .help-report-sign{
        margin-top: 20px;
        display: flex;
        justify-content: flex-end;
    }

    .help-report-sign-box{
        width: 240px;
        text-align: center;
        font-size: 12px;
    }

    .help-report-sign-line{
        margin-top: 40px;
        border-top: 1px solid #000;
        padding-top: 4px;
    }

    /* ============================= */
    /* PRINT ONLY */
    /* ============================= */

    @media print{
        .navbar-custom,
        .leftside-menu,
        .page-title-box,
        .footer,
        .help-report-actions{
            display: none !important;
        }

        body{
            background: #fff;
        }
    }
</style>

<div class="container-fluid help-report-page">
    <div class="help-report-box">
        <div class="help-report-header">
            <div>
                <h1 class="help-report-title">รายงานการช่วยเหลือผู้รับบริการตามช่วงวันที่</h1>
                <p class="help-report-subtitle">
                    @if($fromDate && $toDate)
                        ช่วงวันที่ {{ thaiDateHelpingRangeReport($fromDate) }} ถึง {{ thaiDateHelpingRangeReport($toDate) }}
                    @elseif($fromDate)
                        ตั้งแต่วันที่ {{ thaiDateHelpingRangeReport($fromDate) }}
                    @elseif($toDate)
                        ถึงวันที่ {{ thaiDateHelpingRangeReport($toDate) }}
                    @else
                        แสดงข้อมูลทั้งหมด
                    @endif
                </p>
            </div>

            <div class="help-report-actions">
                <a href="{{ route('help_sessions.show', [
                    'client' => $client->id,
                    'from' => request('from'),
                    'to' => request('to')
                ]) }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left-circle"></i>
                    <span>กลับหน้ารายการ</span>
                </a>

                <button type="button" onclick="window.print()" class="btn btn-primary">
                    <i class="bi bi-printer"></i>
                    <span>พิมพ์รายงาน</span>
                </button>
            </div>
        </div>

        <div class="help-report-meta">
            <div class="help-report-meta-item">
                <div class="help-report-meta-label">ชื่อผู้รับบริการ</div>
                <div class="help-report-meta-value">{{ $client->fullname ?? $client->full_name ?? '-' }}</div>
            </div>

            <div class="help-report-meta-item">
                <div class="help-report-meta-label">จำนวนครั้งที่ช่วยเหลือ</div>
                <div class="help-report-meta-value">{{ number_format($sessions->count()) }} ครั้ง</div>
            </div>

            <div class="help-report-meta-item">
                <div class="help-report-meta-label">จำนวนรายการทั้งหมด</div>
                <div class="help-report-meta-value">
                    {{ number_format($sessions->sum(fn($session) => $session->items->count())) }} รายการ
                </div>
            </div>

            <div class="help-report-meta-item">
                <div class="help-report-meta-label">ยอดรวมทั้งหมด</div>
                <div class="help-report-meta-value">{{ number_format($grandTotal, 2) }} บาท</div>
            </div>
        </div>

        <div class="help-report-table-wrap">
            <table class="help-report-table">
                <thead>
                    <tr>
                        <th style="width: 18%;">วันที่</th>
                        <th style="width: 34%;">รายการ</th>
                        <th style="width: 12%;">จำนวน</th>
                        <th style="width: 18%;">ราคา/หน่วย</th>
                        <th style="width: 18%;">ราคารวม</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $hasRows = false;
                    @endphp

                    @foreach($sessions as $session)
                        @foreach($session->items as $item)
                            @php
                                $hasRows = true;
                                $rowTotal = (float) $item->quantity * (float) $item->unit_price;
                            @endphp
                            <tr>
                                <td class="help-col-date">{{ thaiDateHelpingRangeReport($session->help_date) }}</td>
                                <td class="help-col-item">{{ $item->item_name ?? '-' }}</td>
                                <td class="help-col-qty">{{ number_format($item->quantity ?? 0) }}</td>
                                <td class="help-col-unit">{{ number_format($item->unit_price ?? 0, 2) }}</td>
                                <td class="help-col-total">{{ number_format($rowTotal, 2) }}</td>
                            </tr>
                        @endforeach
                    @endforeach

                    @if(!$hasRows)
                        <tr>
                            <td colspan="5">
                                <div class="help-report-empty">
                                    ยังไม่พบข้อมูลการช่วยเหลือในช่วงวันที่ที่เลือก
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>

                @if($hasRows)
                    <tfoot>
                        <tr>
                            <th colspan="4" class="text-end">รวมทั้งสิ้น</th>
                            <th class="help-col-total">{{ number_format($grandTotal, 2) }} บาท</th>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>

        <div class="help-report-sign">
            <div class="help-report-sign-box">
                <div>ผู้จัดทำรายงาน</div>
                <div class="help-report-sign-line">
                    (.............................................)
                </div>
            </div>
        </div>
    </div>
</div>
@endsection