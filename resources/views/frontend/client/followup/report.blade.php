@extends('admin_client.admin_client')

@section('content')
<div class="followup-report-page">
    <style>
        .followup-report-page {
            padding-bottom: 1.5rem;
        }

        .followup-report-page .report-card {
            background: #fff;
            border: 1px solid #e8edf4;
            border-radius: 22px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.05);
            overflow: hidden;
        }

        .followup-report-page .report-header {
            padding: 1.5rem;
            border-bottom: 1px solid #eef2f7;
        }

        .followup-report-page .report-title {
            margin: 0;
            font-size: 1.4rem;
            font-weight: 700;
            color: #1e293b;
        }

        .followup-report-page .report-subtitle {
            margin-top: .5rem;
            color: #64748b;
            line-height: 1.7;
        }

        .followup-report-page .report-meta {
            margin-top: 1rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: .75rem;
        }

        .followup-report-page .report-meta-item {
            padding: .8rem 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            background: #f8fafc;
        }

        .followup-report-page .report-actions {
            display: flex;
            justify-content: space-between;
            gap: .75rem;
            flex-wrap: wrap;
            padding: 1rem 1.5rem 0;
        }

        .followup-report-page .report-body {
            padding: 1.5rem;
        }

        .followup-report-page .table-wrap {
            overflow-x: auto;
        }

        .followup-report-page .report-table {
            min-width: 820px;
        }

        .followup-report-page .text-preline {
            white-space: pre-line;
            line-height: 1.7;
        }

        .followup-report-page .report-empty {
            padding: 2rem 1.25rem;
            border: 1px dashed #cbd5e1;
            border-radius: 18px;
            background: #f8fafc;
            text-align: center;
        }

        .followup-report-page .report-empty-icon {
            width: 64px;
            height: 64px;
            margin: 0 auto 1rem;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #e2e8f0;
            color: #475569;
            font-size: 1.5rem;
        }

        .followup-report-page .report-empty h4 {
            margin: 0 0 .5rem;
            font-size: 1.1rem;
            font-weight: 700;
            color: #1e293b;
        }

        .followup-report-page .report-empty p {
            margin: 0;
            color: #64748b;
            line-height: 1.7;
        }

        @media print {
            .btn,
            .navbar,
            .leftside-menu,
            .footer,
            .topbar,
            .report-actions {
                display: none !important;
            }

            .content-page,
            .content,
            .container-fluid {
                padding: 0 !important;
                margin: 0 !important;
            }

            .followup-report-page .report-card {
                border: none;
                box-shadow: none;
                border-radius: 0;
            }

            .followup-report-page .report-body,
            .followup-report-page .report-header {
                padding: 0;
            }

            .followup-report-page .report-empty {
                border: 1px dashed #cbd5e1 !important;
                box-shadow: none !important;
            }
        }
    </style>

  @php
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

    $printedAt = now();
    $printedAtThai = $printedAt->day . ' ' . $thaiMonths[$printedAt->month] . ' ' . ($printedAt->year + 543) . ' เวลา ' . $printedAt->format('H:i') . ' น.';

    $dateRangeThai = 'ทั้งหมด';
    if (!empty($dateFrom) || !empty($dateTo)) {
        $fromText = !empty($dateFrom)
            ? \Carbon\Carbon::parse($dateFrom)->day . ' ' . $thaiMonths[\Carbon\Carbon::parse($dateFrom)->month] . ' ' . (\Carbon\Carbon::parse($dateFrom)->year + 543)
            : 'ไม่กำหนด';

        $toText = !empty($dateTo)
            ? \Carbon\Carbon::parse($dateTo)->day . ' ' . $thaiMonths[\Carbon\Carbon::parse($dateTo)->month] . ' ' . (\Carbon\Carbon::parse($dateTo)->year + 543)
            : 'ไม่กำหนด';

        $dateRangeThai = $fromText . ' ถึง ' . $toText;
    }
@endphp

    <div class="report-card">
        <div class="report-actions">
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('followup.index', $client->id) }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left-circle me-1"></i>
                    กลับหน้ารายการ
                </a>
            </div>

            <div class="d-flex gap-2 flex-wrap">
                <button type="button" onclick="window.print();" class="btn btn-primary">
                    <i class="bi bi-printer me-1"></i>
                    พิมพ์รายงาน
                </button>
            </div>
        </div>

        <div class="report-header">
            <h2 class="report-title">รายงานการช่วยเหลือและติดตามผล</h2>
            <p class="report-subtitle">
                เอกสารสรุปข้อมูลการช่วยเหลือและติดตามผลของผู้รับบริการ สำหรับตรวจสอบและพิมพ์รายงาน
            </p>

            <div class="report-meta">
                <div class="report-meta-item">
                    <strong>รหัสผู้รับบริการ:</strong>
                    <div>{{ $client->id }}</div>
                </div>

                <div class="report-meta-item">
                    <strong>ชื่อผู้รับบริการ:</strong>
                    <div>{{ $client->fullname ?? $client->name ?? '-' }}</div>
                </div>

                <div class="report-meta-item">
                    <strong>จำนวนรายการ:</strong>
                    <div>{{ $followups->count() }} รายการ</div>
                </div>

                <div class="report-meta-item">
                    <strong>วันที่พิมพ์:</strong>
                    <div>{{ $printedAtThai }}</div>
                </div>
            </div>
        </div>

        <div class="report-body">
            @if($followups->count() > 0)
                <div class="table-wrap">
                    <table class="table table-bordered align-middle report-table">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 180px;">วันเดือนปี</th>
                                <th>การช่วยเหลือและติดตามผล</th>
                                <th>หมายเหตุ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($followups as $item)
                                @php
                                    $date = \Carbon\Carbon::parse($item->followup_date);
                                    $thaiDate = $date->day . ' ' . $thaiMonths[$date->month] . ' ' . ($date->year + 543);
                                @endphp
                                <tr>
                                    <td>{{ $thaiDate }}</td>
                                    <td class="text-preline">{{ $item->assistance_detail }}</td>
                                    <td class="text-preline">{{ $item->note ?: '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="report-empty">
                    <div class="report-empty-icon">
                        <i class="bi bi-inbox"></i>
                    </div>
                    <h4>ยังไม่มีข้อมูลติดตามผล</h4>
                    <p>เมื่อมีการบันทึกข้อมูล ระบบจะแสดงข้อมูลในรายงานส่วนนี้โดยอัตโนมัติ</p>
                </div>
            @endif

            <div class="mt-4 pt-3">
                <div class="row g-4">
                    <div class="col-md-6 text-center">
                        <div class="border-top pt-2">ผู้จัดทำรายงาน</div>
                    </div>
                    <div class="col-md-6 text-center">
                        <div class="border-top pt-2">ผู้ตรวจสอบ</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection