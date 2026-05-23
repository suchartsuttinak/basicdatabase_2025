@extends('admin_client.admin_client')

@section('content')
<div class="container-fluid psychiatric-report-page">

    <style>
        .psychiatric-report-page{
            font-family: "TH Sarabun New", "Sarabun", sans-serif;
            font-size: 17px;
            line-height: 1.45;
            color: #1f2937;
        }

        .report-page{
            max-width: 1480px;
            margin: 24px auto;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 18px;
            box-shadow: 0 14px 36px rgba(64, 70, 83, 0.08);
        }

        .report-body{
            padding: 24px 26px 22px;
        }

        .report-toolbar{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:16px;
        }

        .report-btn{
            display:inline-flex;
            align-items:center;
            gap:6px;
            padding:.55rem .9rem;
            border-radius:10px;
            font-weight:700;
            border:1px solid #d1d5db;
            background:#fff;
            color:#334155;
            text-decoration:none;
        }

        .report-btn-print{
            background:#2563eb;
            border-color:#2563eb;
            color:#fff;
        }

        .report-header{
            text-align:center;
            border-bottom:2px solid #e5e7eb;
            padding-bottom:10px;
            margin-bottom:14px;
        }

        .report-title{
            font-size:1.8rem;
            font-weight:800;
            margin:0;
        }

        .report-subtitle{
            font-size:.95rem;
            color:#6b7280;
            margin-top:4px;
        }

        .report-info{
            display:flex;
            gap:12px;
            margin-bottom:14px;
            flex-wrap:wrap;
        }

        .report-info-box{
            flex:1;
            min-width:220px;
            border:1px solid #e5e7eb;
            border-radius:12px;
            padding:10px 12px;
            background:#f8fafc;
        }

        .report-info-label{
            font-size:.8rem;
            color:#64748b;
            font-weight:700;
        }

        .report-info-value{
            font-size:.95rem;
            font-weight:700;
        }

        .report-table-wrap{
            overflow-x:auto;
            border:1px solid #e5e7eb;
            border-radius:12px;
        }

        .report-table{
            width:100%;
            min-width:1200px;
        }

        .report-table th{
            background:#f8fafc;
            font-weight:800;
            font-size:.85rem;
            text-align:center;
        }

        .report-table td{
            font-size:.9rem;
        }

        .status-yes{
            background:#dcfce7;
            color:#166534;
            padding:2px 8px;
            border-radius:999px;
            font-weight:700;
        }

        .status-no{
            background:#fee2e2;
            color:#991b1b;
            padding:2px 8px;
            border-radius:999px;
            font-weight:700;
        }

        @page{
            size: A4 landscape;
            margin: 10mm;
        }

      @page{
    size:A4 landscape;
    margin:8mm 10mm;
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

    .navbar,
    .sidebar,
    .footer,
    .page-title-box,
    .report-toolbar,
    header,
    footer{
        display:none !important;
    }

    .container-fluid,
    .psychiatric-report-page{
        width:100% !important;
        max-width:100% !important;
        margin:0 auto !important;
        padding:0 !important;
        background:#fff !important;
        overflow:visible !important;
    }

    .report-page{
        width:100% !important;
        max-width:100% !important;
        min-height:auto !important;
        margin:0 auto !important;
        padding:0 !important;
        border:none !important;
        border-radius:0 !important;
        box-shadow:none !important;
        background:#fff !important;
        overflow:visible !important;
        page-break-after:avoid !important;
        break-after:avoid !important;
    }

    .report-body{
        padding:0 !important;
        margin:0 !important;
    }

    .report-header{
        text-align:center !important;
        border-bottom:1px solid #cbd5e1 !important;
        padding:0 0 5px !important;
        margin:0 0 6px !important;
    }

    .report-title{
        font-size:20px !important;
        font-weight:900 !important;
        line-height:1.1 !important;
        color:#0f172a !important;
        margin:0 !important;
    }

    .report-subtitle{
        font-size:11px !important;
        color:#64748b !important;
        margin-top:2px !important;
        line-height:1.1 !important;
        font-weight:600 !important;
    }

    .report-info{
        display:flex !important;
        align-items:center !important;
        justify-content:flex-start !important;
        flex-wrap:wrap !important;
        gap:4px 22px !important;
        margin:0 0 6px !important;
        padding:0 0 5px 4px !important;
        border-bottom:1px solid #dbe4f0 !important;
    }

    .report-info-box{
        border:none !important;
        background:none !important;
        padding:0 !important;
        margin:0 !important;
        min-width:auto !important;
        flex:none !important;
        border-radius:0 !important;
        position:relative !important;
    }

    .report-info-box::after{
        content:"";
        position:absolute;
        right:-12px;
        top:50%;
        transform:translateY(-50%);
        width:1px;
        height:12px;
        background:#cbd5e1;
    }

    .report-info-box:last-child::after{
        display:none !important;
    }

    .report-info-label,
    .report-info-value{
        display:inline !important;
        font-size:12.5px !important;
        font-weight:800 !important;
        color:#2563eb !important;
        line-height:1.1 !important;
    }

    .report-info-label{
        margin-right:3px !important;
    }

    .report-table-wrap{
        width:100% !important;
        max-width:100% !important;
        overflow:visible !important;
        border:none !important;
        border-radius:0 !important;
        margin:0 !important;
        padding:0 !important;
    }

    .report-table{
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

    .report-table thead{
        display:table-header-group !important;
    }

    .report-table tr{
        page-break-inside:avoid !important;
        break-inside:avoid !important;
    }

    .report-table thead th{
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

    .report-table tbody td{
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

    .report-table tbody tr:nth-child(even){
        background:#fcfdff !important;
    }

    .report-table th:nth-child(1),
    .report-table td:nth-child(1){
        width:9% !important;
    }

    .report-table th:nth-child(2),
    .report-table td:nth-child(2){
        width:16% !important;
    }

    .report-table th:nth-child(3),
    .report-table td:nth-child(3){
        width:14% !important;
    }

    .report-table th:nth-child(4),
    .report-table td:nth-child(4){
        width:25% !important;
    }

    .report-table th:nth-child(5),
    .report-table td:nth-child(5){
        width:9% !important;
    }

    .report-table th:nth-child(6),
    .report-table td:nth-child(6){
        width:7% !important;
    }

    .report-table th:nth-child(7),
    .report-table td:nth-child(7){
        width:13% !important;
    }

    .report-table th:nth-child(8),
    .report-table td:nth-child(8){
        width:7% !important;
    }

    .status-yes,
    .status-no{
        display:inline-flex !important;
        align-items:center !important;
        justify-content:center !important;
        min-width:28px !important;
        padding:1px 5px !important;
        border-radius:999px !important;
        font-size:9.5px !important;
        font-weight:900 !important;
        line-height:1.05 !important;
    }

    .status-yes{
        background:#dcfce7 !important;
        color:#166534 !important;
    }

    .status-no{
        background:#fee2e2 !important;
        color:#991b1b !important;
    }

    .text-center.py-4.text-muted{
        padding:14px !important;
        font-size:12px !important;
        border:1px dashed #94a3b8 !important;
        color:#475569 !important;
    }
}
    </style>

    <div class="report-page">
        <div class="report-body">

            <div class="report-toolbar">
                <a href="{{ route('psychiatric.create', $client->id) }}" class="report-btn">
                    ← กลับหน้าบันทึก
                </a>

                <button onclick="window.print()" class="report-btn report-btn-print">
                    🖨 พิมพ์
                </button>
            </div>

            <div class="report-header">
                <h1 class="report-title">รายงานการตรวจวินิจฉัยทางจิตเวช</h1>
                <div class="report-subtitle">
                    แสดงข้อมูลการส่งพบจิตเวช การวินิจฉัย และการติดตามผล
                </div>
            </div>

            <div class="report-info">
                <div class="report-info-box">
                    <div class="report-info-label">ชื่อ-สกุล</div>
                    <div class="report-info-value">{{ $client->fullname ?? '-' }}</div>
                </div>

                <div class="report-info-box">
                    <div class="report-info-label">อายุ</div>
                    <div class="report-info-value">{{ $client->age ?? '-' }} ปี</div>
                </div>
            </div>

            @if($psychiatrics->isNotEmpty())
                <div class="report-table-wrap">
                    <table class="table report-table">
                        <thead>
                            <tr>
                                <th>วันที่ส่ง</th>
                                <th>สถานพยาบาล</th>
                                <th>นักจิตวิทยา</th>
                                <th>การวินิจฉัย</th>
                                <th>วันที่นัด</th>
                                <th>ใช้ยา</th>
                                <th>ชื่อยา</th>
                                <th>ความพิการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($psychiatrics as $item)
                                <tr>
                                    <td class="text-center">
                                        {{ \Carbon\Carbon::parse($item->sent_date)->addYears(543)->format('d/m/Y') }}
                                    </td>

                                    <td>{{ $item->hotpital ?? '-' }}</td>

                                    <td>{{ optional($item->psycho)->psycho_name ?? '-' }}</td>

                                    <td>{{ $item->diagnose ?? '-' }}</td>

                                    <td class="text-center">
                                        @if($item->appoin_date)
                                            {{ \Carbon\Carbon::parse($item->appoin_date)->addYears(543)->format('d/m/Y') }}
                                        @else
                                            -
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <span class="{{ $item->drug_no === 'yes' ? 'status-yes' : 'status-no' }}">
                                            {{ $item->drug_no === 'yes' ? 'มี' : 'ไม่มี' }}
                                        </span>
                                    </td>

                                    <td>{{ $item->drug_name ?? '-' }}</td>

                                    <td class="text-center">
                                        <span class="{{ $item->disa_no === 'yes' ? 'status-yes' : 'status-no' }}">
                                            {{ $item->disa_no === 'yes' ? 'มี' : 'ไม่มี' }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4 text-muted">
                    ไม่มีข้อมูลรายงาน
                </div>
            @endif

        </div>
    </div>
</div>
@endsection