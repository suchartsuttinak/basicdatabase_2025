@extends('admin.admin_master')
@section('admin')

<div class="container-fluid operation-report-page">

    <style>
        .operation-report-page{
            background:#f8fafc;
            color:#111827;
            font-family:"Sarabun","TH Sarabun New",Arial,sans-serif;
            padding:18px;
        }

        .report-wrapper{
            width:100%;
            max-width:1280px;
            margin:0 auto;
        }

        .report-toolbar{
            display:flex;
            justify-content:space-between;
            align-items:flex-end;
            gap:14px;
            margin-bottom:16px;
            flex-wrap:wrap;
            background:#fff;
            border:1px solid #e5e7eb;
            border-radius:14px;
            padding:14px;
        }

        .report-filter-form{
            display:flex;
            align-items:flex-end;
            gap:10px;
            flex-wrap:wrap;
        }

        .report-filter-item{
            width:160px;
        }

        .report-filter-item.user-filter{
            width:220px;
        }

        .report-filter-label{
            display:block;
            font-size:13px;
            font-weight:700;
            color:#374151;
            margin-bottom:5px;
        }

        .report-input,
        .report-select{
            width:100%;
            height:40px;
            border-radius:8px;
            border:1px solid #d1d5db;
            padding:6px 10px;
            font-size:14px;
            background:#fff;
            color:#111827;
        }

        .report-input:focus,
        .report-select:focus{
            border-color:#2563eb;
            box-shadow:0 0 0 .18rem rgba(37,99,235,.10);
            outline:0;
        }

        .report-actions{
            display:flex;
            gap:10px;
            flex-wrap:wrap;
            justify-content:flex-end;
        }

        .report-btn{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            gap:7px;
            height:40px;
            border-radius:8px;
            padding:0 14px;
            font-size:14px;
            font-weight:700;
            text-decoration:none;
            border:1px solid #d1d5db;
            background:#fff;
            color:#374151;
            cursor:pointer;
            white-space:nowrap;
        }

        .report-btn:hover{
            background:#f3f4f6;
            color:#111827;
        }

        .report-btn-search{
            background:#111827;
            border-color:#111827;
            color:#fff;
        }

        .report-btn-search:hover{
            background:#030712;
            color:#fff;
        }

        .report-btn-print{
            background:#1d4ed8;
            border-color:#1d4ed8;
            color:#fff;
        }

        .report-btn-print:hover{
            background:#1e40af;
            color:#fff;
        }

        .report-paper{
            width:100%;
            background:#fff;
            border:1px solid #e5e7eb;
            border-radius:14px;
            padding:24px 28px;
            box-shadow:0 8px 24px rgba(15,23,42,.06);
        }

        .report-header{
            text-align:center;
            margin-bottom:16px;
            padding-bottom:10px;
            border-bottom:2px solid #111827;
        }

        .report-title{
            font-size:25px;
            font-weight:800;
            margin:0;
            line-height:1.45;
            color:#111827;
        }

        .report-subtitle{
            font-size:15px;
            color:#4b5563;
            margin-top:4px;
        }

        .report-meta{
            width:100%;
            border-collapse:collapse;
            margin-bottom:14px;
            font-size:14px;
        }

        .report-meta td{
            padding:5px 8px;
            vertical-align:top;
        }

        .report-meta .label{
            width:130px;
            font-weight:800;
            color:#111827;
            white-space:nowrap;
        }

        .report-meta .value{
            color:#1f2937;
        }

        .table-responsive-report{
            width:100%;
            overflow-x:auto;
            -webkit-overflow-scrolling:touch;
        }

        .report-table{
            width:100%;
            border-collapse:collapse;
            table-layout:fixed;
            font-size:13.4px;
        }

        .report-table th,
        .report-table td{
            border:1px solid #9ca3af;
            padding:7px 8px;
            vertical-align:middle;
            line-height:1.5;
        }

        .report-table th{
            background:#f3f4f6;
            color:#111827;
            font-weight:800;
            text-align:center;
            vertical-align:middle;
        }

        .report-table td{
            color:#111827;
            vertical-align:middle;
        }

        .report-table td.text-pretty{
            vertical-align:middle;
        }

        .text-pretty{
            white-space:normal;
    word-break:break-word;
}

        .empty-text{
            text-align:center;
            color:#6b7280;
            padding:36px 10px;
            font-size:15px;
            border:1px solid #d1d5db;
            margin-top:8px;
        }

        .report-summary{
            margin-top:12px;
            font-size:13.5px;
            color:#374151;
            text-align:right;
        }

        .signature-section{
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:70px;
            margin-top:42px;
            font-size:14px;
        }

        .signature-box{
            text-align:center;
        }

        .signature-line{
            height:34px;
            border-bottom:1px solid #111827;
            margin-bottom:7px;
        }

        .signature-role{
            color:#374151;
        }

        .signature-name{
            margin-top:4px;
            font-weight:700;
            color:#111827;
        }

        @media (max-width:991.98px){
            .report-toolbar{
                align-items:stretch;
            }

            .report-filter-form,
            .report-actions{
                width:100%;
            }

            .report-filter-item,
            .report-filter-item.user-filter{
                flex:1 1 180px;
                width:auto;
            }

            .report-actions{
                justify-content:flex-start;
            }
        }

        @media (max-width:767.98px){
            .operation-report-page{
                padding:10px;
            }

            .report-toolbar{
                padding:12px;
            }

            .report-filter-form{
                display:grid;
                grid-template-columns:1fr;
                gap:10px;
            }

            .report-filter-item,
            .report-filter-item.user-filter,
            .report-btn{
                width:100%;
            }

            .report-actions{
                display:grid;
                grid-template-columns:1fr;
            }

            .report-paper{
                padding:16px 14px;
                border-radius:12px;
            }

            .report-title{
                font-size:19px;
            }

            .report-meta{
                font-size:13px;
            }

            .report-table{
                min-width:1080px;
                font-size:13px;
            }

            .signature-section{
                grid-template-columns:1fr;
                gap:24px;
            }
        }

        @media print{
            @page{
                size:A4 landscape;
                margin:9mm;
            }

            html,
            body{
                background:#fff !important;
                margin:0 !important;
                padding:0 !important;
            }

            .no-print,
            .report-toolbar,
            .sidebar,
            .navbar,
            .footer,
            .page-title-box{
                display:none !important;
            }

            .container-fluid,
            .operation-report-page,
            .report-wrapper{
                width:100% !important;
                max-width:none !important;
                margin:0 !important;
                padding:0 !important;
                background:#fff !important;
            }

            .report-paper{
                width:100% !important;
                max-width:none !important;
                margin:0 !important;
                padding:0 !important;
                border:0 !important;
                border-radius:0 !important;
                box-shadow:none !important;
            }

            .report-header{
                margin-bottom:8px;
                padding-bottom:6px;
            }

            .report-title{
                font-size:20px;
            }

            .report-subtitle{
                font-size:12.5px;
            }

            .report-meta{
                font-size:12px;
                margin-bottom:7px;
            }

            .report-meta td{
                padding:3px 5px;
            }

            .table-responsive-report{
                overflow:visible !important;
            }

            .report-table{
                width:100% !important;
                min-width:0 !important;
                font-size:10.8px;
                table-layout:fixed;
                page-break-inside:auto;
            }

            .report-table th,
            .report-table td{
                padding:4px 5px;
                line-height:1.35;
                vertical-align:middle;
            }
            .report-table tr{
                page-break-inside:avoid;
                page-break-after:auto;
            }

            .report-summary{
                font-size:11.5px;
                margin-top:8px;
            }

            .signature-section{
                margin-top:22px;
                gap:60px;
                font-size:12px;
                page-break-inside:avoid;
            }

            .signature-line{
                height:26px;
            }
        }
    </style>

    @php
    $reportUserName = auth()->user()->name ?? '-';

    $reportRangeText = 'ทั้งหมด';

    if(request('start_date') && request('end_date')){
        $reportRangeText =
            \Carbon\Carbon::parse(request('start_date'))->addYears(543)->format('d/m/Y')
            . ' - ' .
            \Carbon\Carbon::parse(request('end_date'))->addYears(543)->format('d/m/Y');
    } elseif(request('start_date')) {
        $reportRangeText =
            'ตั้งแต่ ' . \Carbon\Carbon::parse(request('start_date'))->addYears(543)->format('d/m/Y');
    } elseif(request('end_date')) {
        $reportRangeText =
            'ถึง ' . \Carbon\Carbon::parse(request('end_date'))->addYears(543)->format('d/m/Y');
    }

    $generatedAt = now()->addYears(543)->format('d/m/Y H:i');

    $totalItems = $operations->count();

    $totalDays = $operations
        ->pluck('operation_date')
        ->map(fn($date) => \Carbon\Carbon::parse($date)->format('Y-m-d'))
        ->unique()
        ->count();
@endphp

<div class="report-wrapper">

    <div class="report-toolbar no-print">
        <div></div>

        <div class="report-actions">
            <a href="{{ route('operations.index') }}" class="report-btn">
                <i class="bi bi-arrow-left"></i>
                กลับหน้ารายการ
            </a>

            <button type="button" class="report-btn report-btn-print" onclick="window.print()">
                <i class="bi bi-printer"></i>
                พิมพ์รายงาน
            </button>
        </div>
    </div>

    <div class="report-paper">

        <div class="report-header">
            <h1 class="report-title">รายงานการปฏิบัติงานประจำวันของพนักงาน</h1>
            <div class="report-subtitle">แบบสรุปรายงานผลการปฏิบัติงานประจำวัน</div>
        </div>

        <table class="report-meta">
            <tr>
                <td class="label">ชื่อ - สกุล</td>
                <td class="value">{{ $reportUserName }}</td>

                <td class="label">ช่วงวันที่รายงาน</td>
                <td class="value">{{ $reportRangeText }}</td>
            </tr>
            <tr>
                <td class="label">วันที่ออกรายงาน</td>
                <td class="value">{{ $generatedAt }} น.</td>

                <td class="label">ผู้จัดทำรายงาน</td>
                <td class="value">{{ auth()->user()->name ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">จำนวนวัน</td>
                <td class="value">{{ number_format($totalDays) }} วัน</td>

                <td class="label">จำนวนรายการ</td>
                <td class="value">{{ number_format($totalItems) }} รายการ</td>
            </tr>
        </table>

        @if($operations->count() > 0)
            <div class="table-responsive-report">
                <table class="report-table">
                    <thead>
                        <tr>
                            <th style="width:9%;">วันที่</th>
                            <th style="width:7%;">ครั้งที่</th>
                            <th style="width:25%;">เรื่องที่ดำเนินงาน</th>
                            <th style="width:29%;">ผลการดำเนินงาน</th>
                            <th style="width:18%;">หมายเหตุ</th>
                            <th style="width:12%;">ผู้ดำเนินงาน</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($operations as $item)
                            <tr>
                                <td class="text-center">
                                    {{ \Carbon\Carbon::parse($item->operation_date)->addYears(543)->format('d/m/Y') }}
                                </td>

                                <td class="text-center">
                                    {{ $item->sequence_no ?? '-' }}
                                </td>

                                <td class="text-pretty">
                                    {{ $item->subject ?: '-' }}
                                </td>

                                <td class="text-pretty">
                                    {{ $item->result ?: '-' }}
                                </td>

                                <td class="text-pretty">
                                    {{ $item->remark ?: '-' }}
                                </td>

                                <td class="text-center">
                                    {{ $item->user->name ?? '-' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-text">
                ไม่พบข้อมูลรายงานในช่วงวันที่ที่เลือก
            </div>
        @endif

        <div class="report-summary">
            รวมทั้งสิ้น {{ number_format($totalItems) }} รายการ
        </div>

        <div class="signature-section">
            <div class="signature-box">
                <div class="signature-line"></div>
                <div class="signature-role">ผู้จัดทำรายงาน</div>
                <div class="signature-name">{{ auth()->user()->name ?? '-' }}</div>
            </div>

            <div class="signature-box">
                <div class="signature-line"></div>
                <div class="signature-role">ผู้ตรวจสอบ / ผู้บังคับบัญชา</div>
                <div class="signature-name">..........................................</div>
            </div>
        </div>

    </div>
</div>

@endsection