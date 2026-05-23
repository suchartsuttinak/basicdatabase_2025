@extends('admin_client.admin_client')

@section('content')
@php
    use Carbon\Carbon;

    function thaiDateMedicalReport($date) {
        if (!$date) return '-';
        return Carbon::parse($date)->addYears(543)->format('d/m/Y');
    }
@endphp

<div class="container-fluid medical-report-page">

    <style>
        .medical-report-page{
            font-family: "TH Sarabun New", "Sarabun", sans-serif;
            font-size: 17px;
            line-height: 1.45;
            color: #1f2937;
        }

        .medical-report-page .medical-report-shell{
            max-width: 1320px;
            margin: 24px auto;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            box-shadow: 0 10px 28px rgba(15, 23, 42, 0.06);
            overflow: hidden;
        }

        .medical-report-page .medical-report-body{
            padding: 24px 24px 22px;
        }

        .medical-report-page .medical-report-toolbar{
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 18px;
        }

        .medical-report-page .medical-report-toolbar-left,
        .medical-report-page .medical-report-toolbar-right{
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .medical-report-page .medical-btn{
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 44px;
            padding: .66rem 1rem;
            border-radius: 12px;
            font-weight: 700;
            border: 1px solid transparent;
            text-decoration: none;
            transition: all .2s ease;
            white-space: nowrap;
        }

        .medical-report-page .medical-btn-back{
            background: #334155;
            border-color: #334155;
            color: #ffffff;
        }

        .medical-report-page .medical-btn-back:hover{
            background: #1f2937;
            border-color: #1f2937;
            color: #ffffff;
        }

        .medical-report-page .medical-btn-print{
            background: #2563eb;
            border-color: #2563eb;
            color: #ffffff;
        }

        .medical-report-page .medical-btn-print:hover{
            background: #1d4ed8;
            border-color: #1d4ed8;
            color: #ffffff;
        }

        .medical-report-page .medical-report-header{
            text-align: center;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 12px;
            margin-bottom: 14px;
        }

        .medical-report-page .medical-report-title{
            font-size: 1.8rem;
            font-weight: 800;
            margin: 0;
            color: #0f172a;
        }

        .medical-report-page .medical-report-subtitle{
            font-size: .95rem;
            color: #6b7280;
            margin-top: 4px;
            line-height: 1.6;
        }

        .medical-report-page .medical-report-meta{
            display: flex;
            flex-wrap: wrap;
            gap: 18px 28px;
            align-items: center;
            margin-bottom: 16px;
            padding: 10px 0 2px;
            border-bottom: 1px dashed #e2e8f0;
        }

        .medical-report-page .medical-report-meta-item{
            display: flex;
            align-items: baseline;
            gap: 8px;
            min-width: 0;
        }

        .medical-report-page .medical-report-meta-label{
            font-size: .88rem;
            font-weight: 700;
            color: #64748b;
            white-space: nowrap;
        }

        .medical-report-page .medical-report-meta-value{
            font-size: 1rem;
            font-weight: 700;
            color: #0f172a;
            word-break: break-word;
        }

        .medical-report-page .medical-report-table-wrap{
            overflow-x: auto;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
        }

        .medical-report-page .medical-report-table{
            width: 100%;
            min-width: 1200px;
            margin-bottom: 0;
        }

        .medical-report-page .medical-report-table thead th{
            background: #f8fafc;
            color: #0f172a;
            font-weight: 800;
            font-size: .86rem;
            text-align: center;
            vertical-align: middle;
            border-bottom: 1px solid #e5e7eb;
            white-space: nowrap;
        }

        .medical-report-page .medical-report-table tbody td{
            font-size: .92rem;
            vertical-align: middle;
            color: #1f2937;
        }

        .medical-report-page .medical-report-table tbody tr:nth-child(even){
            background: #fcfcfd;
        }

        .medical-report-page .medical-report-table tbody tr:hover{
            background: #f8fafc;
        }

        .medical-report-page .medical-status{
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 90px;
            padding: 4px 10px;
            border-radius: 999px;
            font-weight: 700;
            font-size: .82rem;
        }

        .medical-report-page .medical-status--yes{
            background: #dcfce7;
            color: #166534;
        }

        .medical-report-page .medical-status--no{
            background: #fee2e2;
            color: #991b1b;
        }

        .medical-report-page .medical-report-empty{
            text-align: center;
            padding: 42px 20px;
            color: #6b7280;
            border: 1px dashed #d1d5db;
            border-radius: 12px;
            background: #fafafa;
        }

        .medical-report-page .medical-report-empty i{
            font-size: 2rem;
            color: #94a3b8;
            display: block;
            margin-bottom: 8px;
        }

        @page{
            size: A4 landscape;
            margin: 10mm;
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
    .medical-report-page .medical-report-toolbar,
    header,
    footer{
        display:none !important;
    }

    .container-fluid,
    .medical-report-page{
        width:100% !important;
        max-width:100% !important;
        margin:0 auto !important;
        padding:0 !important;
        background:#fff !important;
        overflow:visible !important;
    }

    .medical-report-page .medical-report-shell{
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

    .medical-report-page .medical-report-body{
        padding:0 !important;
        margin:0 !important;
    }

    .medical-report-page .medical-report-header{
        text-align:center !important;
        border-bottom:1px solid #cbd5e1 !important;
        padding:0 0 5px !important;
        margin:0 0 6px !important;
    }

    .medical-report-page .medical-report-title{
        font-size:20px !important;
        font-weight:900 !important;
        line-height:1.1 !important;
        color:#0f172a !important;
        margin:0 !important;
    }

    .medical-report-page .medical-report-subtitle{
        font-size:11px !important;
        color:#64748b !important;
        margin-top:2px !important;
        line-height:1.1 !important;
        font-weight:600 !important;
    }

    .medical-report-page .medical-report-meta{
        display:flex !important;
        align-items:center !important;
        justify-content:flex-start !important;
        flex-wrap:wrap !important;
        flex-direction:row !important;
        gap:4px 22px !important;
        margin:0 0 6px !important;
        padding:0 0 5px 4px !important;
        border-bottom:1px solid #dbe4f0 !important;
    }

    .medical-report-page .medical-report-meta > *{
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

    .medical-report-page .medical-report-table-wrap{
        width:100% !important;
        max-width:100% !important;
        overflow:visible !important;
        border:none !important;
        border-radius:0 !important;
        margin:0 !important;
        padding:0 !important;
    }

    .medical-report-page .medical-report-table{
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

    .medical-report-page .medical-report-table thead{
        display:table-header-group !important;
    }

    .medical-report-page .medical-report-table tr{
        page-break-inside:avoid !important;
        break-inside:avoid !important;
    }

    .medical-report-page .medical-report-table thead th{
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

    .medical-report-page .medical-report-table tbody td{
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

    .medical-report-page .medical-report-table tbody tr:nth-child(even){
        background:#fcfdff !important;
    }

    .medical-report-page .medical-report-empty{
        border:1px dashed #94a3b8 !important;
        border-radius:0 !important;
        padding:14px !important;
        text-align:center !important;
        color:#475569 !important;
        font-size:12px !important;
    }
}
    </style>

    <div class="medical-report-shell">
        <div class="medical-report-body">

            <div class="medical-report-toolbar">
                <div class="medical-report-toolbar-left">
                    <a href="{{ route('medical.add', $client->id) }}" class="medical-btn medical-btn-back">
                        <i class="bi bi-arrow-left-circle"></i>
                        <span>กลับหน้าหลัก</span>
                    </a>
                </div>

                <div class="medical-report-toolbar-right">
                    <button onclick="window.print()" type="button" class="medical-btn medical-btn-print">
                        <i class="bi bi-printer"></i>
                        <span>พิมพ์รายงาน</span>
                    </button>
                </div>
            </div>

            <div class="medical-report-header">
                <h1 class="medical-report-title">รายงานการรักษาพยาบาลในหน่วยงาน</h1>
                <div class="medical-report-subtitle">
                    แสดงข้อมูลสุขภาพ การรักษา การส่งต่อ และการนัดหมายของผู้รับบริการในรูปแบบที่อ่านง่ายและพร้อมสำหรับการพิมพ์
                </div>
            </div>

            <div class="medical-report-meta">
                <div class="medical-report-meta-item">
                    <span class="medical-report-meta-label">ชื่อ-สกุล :</span>
                    <span class="medical-report-meta-value">{{ $client->fullname ?? '-' }}</span>
                </div>

                <div class="medical-report-meta-item">
                    <span class="medical-report-meta-label">อายุ :</span>
                    <span class="medical-report-meta-value">{{ $client->age ?? '-' }} ปี</span>
                </div>

                <div class="medical-report-meta-item">
                    <span class="medical-report-meta-label">จำนวนรายการ :</span>
                    <span class="medical-report-meta-value">{{ $medicals->count() }} รายการ</span>
                </div>
            </div>

            @if($medicals->isNotEmpty())
                <div class="medical-report-table-wrap">
                    <table class="table medical-report-table">
                        <thead>
                            <tr>
                                <th style="width: 120px;">วันที่รักษา</th>
                                <th style="min-width: 180px;">ชื่อโรค</th>
                                <th style="min-width: 220px;">อาการเจ็บป่วย</th>
                                <th style="min-width: 220px;">การรักษา</th>
                                <th style="width: 120px;">การส่งต่อ</th>
                                <th style="min-width: 180px;">การวินิจฉัย</th>
                                <th style="width: 120px;">วันนัด</th>
                                <th style="min-width: 160px;">ครูผู้ดูแล</th>
                                <th style="min-width: 220px;">หมายเหตุ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($medicals as $key => $item)
                                <tr>
                                   
                                    <td class="text-center">{{ thaiDateMedicalReport($item->medical_date) }}</td>
                                    <td>{{ $item->disease_name ?? '-' }}</td>
                                    <td>{{ $item->illness ?? '-' }}</td>
                                    <td>{{ $item->treatment ?? '-' }}</td>
                                    <td class="text-center">
                                        @if($item->refer === 'พบแพทย์')
                                            <span class="medical-status medical-status--yes">{{ $item->refer }}</span>
                                        @else
                                            <span class="medical-status medical-status--no">{{ $item->refer ?? '-' }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->diagnosis ?? '-' }}</td>
                                    <td class="text-center">{{ thaiDateMedicalReport($item->appt_date) }}</td>
                                    <td>{{ $item->teacher ?? '-' }}</td>
                                    <td>{{ $item->remark ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="medical-report-empty">
                    <i class="bi bi-inbox"></i>
                    <div>ไม่มีข้อมูลรายงานการรักษาพยาบาล</div>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection