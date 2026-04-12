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
    .help-report-page{
        padding: 12px 0 24px;
    }

    .help-report-box{
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        padding: 24px;
    }

    .help-report-header{
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 16px;
        flex-wrap: wrap;
        margin-bottom: 20px;
        padding-bottom: 16px;
        border-bottom: 1px solid #e5e7eb;
    }

    .help-report-title{
        margin: 0;
        font-size: 1.35rem;
        font-weight: 700;
        color: #111827;
        line-height: 1.4;
    }

    .help-report-subtitle{
        margin: 6px 0 0;
        font-size: .95rem;
        color: #6b7280;
        line-height: 1.6;
    }

    .help-report-actions{
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        align-items: center;
    }

    .help-report-actions .btn{
        border-radius: 10px;
        font-weight: 600;
        min-height: 42px;
        padding: .6rem 1rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        line-height: 1.2;
        white-space: nowrap;
    }

    .help-report-meta{
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 12px;
        margin-bottom: 20px;
    }

    .help-report-meta-item{
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 14px;
        background: #fafafa;
    }

    .help-report-meta-label{
        font-size: .85rem;
        color: #6b7280;
        margin-bottom: 6px;
    }

    .help-report-meta-value{
        font-size: 1rem;
        font-weight: 700;
        color: #111827;
        line-height: 1.5;
        word-break: break-word;
    }

    .help-report-table-wrap{
        overflow-x: auto;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
    }

    .help-report-table{
        width: 100%;
        min-width: 860px;
        border-collapse: collapse;
        background: #fff;
        table-layout: fixed;
    }

    .help-report-table thead th{
        background: #f9fafb;
        color: #374151;
        font-size: .93rem;
        font-weight: 700;
        text-align: center;
        vertical-align: middle;
        padding: 14px 12px;
        border-bottom: 1px solid #e5e7eb;
        line-height: 1.45;
    }

    .help-report-table tbody td,
    .help-report-table tfoot th{
        padding: 13px 12px;
        border-bottom: 1px solid #edf0f2;
        color: #111827;
        vertical-align: middle;
        font-size: .94rem;
        line-height: 1.55;
    }

    .help-col-date{
        text-align: center;
        white-space: nowrap;
    }

    .help-col-item{
        text-align: left;
        word-break: break-word;
    }

    .help-col-qty{
        text-align: center;
        white-space: nowrap;
    }

    .help-col-unit,
    .help-col-total{
        text-align: right;
        white-space: nowrap;
        font-variant-numeric: tabular-nums;
    }

    .help-report-empty{
        padding: 32px 16px;
        text-align: center;
        color: #6b7280;
    }

    .help-report-sign{
        margin-top: 28px;
        display: flex;
        justify-content: flex-end;
    }

    .help-report-sign-box{
        width: 280px;
        max-width: 100%;
        text-align: center;
        color: #374151;
    }

    .help-report-sign-line{
        margin-top: 56px;
        border-top: 1px solid #9ca3af;
        padding-top: 8px;
    }

    @media (max-width: 991.98px){
        .help-report-meta{
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 767.98px){
        .help-report-box{
            padding: 16px;
        }

        .help-report-title{
            font-size: 1.15rem;
        }

        .help-report-meta{
            grid-template-columns: 1fr;
        }

        .help-report-actions{
            width: 100%;
        }

        .help-report-actions .btn{
            width: 100%;
        }

        .help-report-table{
            min-width: 760px;
        }
    }

    @media print{
        .navbar-custom,
        .leftside-menu,
        .page-title-box,
        .footer,
        .help-report-actions{
            display: none !important;
        }

        .help-report-page{
            padding: 0 !important;
        }

        .help-report-box{
            border: none !important;
            box-shadow: none !important;
            border-radius: 0 !important;
            padding: 0 !important;
        }

        body{
            background: #fff !important;
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