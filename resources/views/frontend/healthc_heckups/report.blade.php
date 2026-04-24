<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>รายงานการตรวจสุขภาพ</title>
    <style>
        @page{
            size: A4 landscape;
            margin: 10mm 12mm;
        }

        body{
            font-family:"TH Sarabun New","Sarabun",sans-serif;
            font-size:14px;
            color:#1f2937;
            margin:0;
            background:#eef3f8;
            line-height:1.35;
        }

        .report-page{
            max-width:1366px;
            margin:14px auto;
            background:#ffffff;
            border:1px solid #dde5ee;
            border-radius:14px;
            box-shadow:0 8px 24px rgba(15, 23, 42, 0.06);
            padding:18px 20px;
        }

        .report-toolbar{
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap:12px;
            flex-wrap:wrap;
            margin-bottom:12px;
        }

        .report-title-wrap{
            display:flex;
            flex-direction:column;
            gap:2px;
        }

        .report-title{
            margin:0;
            font-size:22px;
            font-weight:700;
            color:#0f172a;
            line-height:1.2;
        }

        .report-subtitle{
            margin:0;
            font-size:12px;
            color:#64748b;
        }

        .btn{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            padding:6px 12px;
            border-radius:8px;
            border:1px solid #cfd8e3;
            background:#ffffff;
            text-decoration:none;
            color:#0f172a;
            cursor:pointer;
            font-size:13px;
            font-family:inherit;
            transition:.2s ease;
        }

        .btn:hover{
            background:#f8fafc;
        }

        .report-table-wrap{
            overflow-x:auto;
        }

        table{
            width:100%;
            border-collapse:collapse;
            table-layout:fixed;
        }

        th, td{
            border:1px solid #dbe3ec;
            padding:6px 8px;
            vertical-align:top;
            text-align:left;
            word-wrap:break-word;
        }

        thead th{
            background:#f8fafc;
            color:#0f172a;
            font-weight:700;
            font-size:13px;
            text-align:center;
        }

        tbody td{
            font-size:13px;
            color:#1f2937;
        }

        tbody tr:nth-child(even){
            background:#fbfdff;
        }

        .col-index{
            width:44px;
            text-align:center;
        }

        .col-name{
            width:150px;
        }

        .col-date{
            width:86px;
            text-align:center;
            white-space:nowrap;
        }

        .col-hospital{
            width:170px;
        }

        .col-result{
            width:90px;
            text-align:center;
            white-space:nowrap;
        }

        .col-recorder{
            width:110px;
        }

        .badge-normal,
        .badge-abnormal{
            display:inline-block;
            min-width:58px;
            padding:1px 8px;
            border-radius:999px;
            font-size:12px;
            font-weight:700;
            line-height:1.4;
            text-align:center;
        }

        .badge-normal{
            background:#dcfce7;
            color:#166534;
        }

        .badge-abnormal{
            background:#fee2e2;
            color:#991b1b;
        }

        .empty-row{
            text-align:center !important;
            color:#6b7280 !important;
            padding:16px 8px !important;
        }

        .report-actions{
            display:flex;
            gap:8px;
            flex-wrap:wrap;
        }

        .btn-back{
            background:#f1f5f9;
            border:1px solid #cbd5e1;
            color:#0f172a;
        }

        .btn-back:hover{
            background:#e2e8f0;
        }

        .btn-print{
            background:#2563eb;
            border:1px solid #2563eb;
            color:#fff;
        }

        .btn-print:hover{
            background:#1d4ed8;
        }

        @media screen and (max-width: 768px){
            body{
                font-size:13px;
            }

            .report-page{
                margin:10px;
                padding:14px;
                border-radius:12px;
            }

            .report-title{
                font-size:18px;
            }

            .report-subtitle{
                font-size:11px;
            }

            th, td{
                padding:6px 7px;
            }
        }

        @media print{
            body{
                background:#ffffff;
                font-size:12px;
            }

            @media print{
            .report-toolbar{
                display:none;
            }
        }

            .report-page{
                box-shadow:none;
                border:none;
                border-radius:0;
                margin:0;
                padding:0;
                max-width:none;
            }

            .report-toolbar{
                display:none;
            }

            table{
                width:100%;
            }

            th, td{
                border:1px solid #bfc9d4;
                padding:4px 6px;
                font-size:11px;
                line-height:1.25;
            }

            thead th{
                background:#f3f4f6 !important;
                -webkit-print-color-adjust:exact;
                print-color-adjust:exact;
                font-size:11px;
            }

            .badge-normal,
            .badge-abnormal{
                font-size:10px;
                padding:1px 6px;
                border:1px solid transparent;
                -webkit-print-color-adjust:exact;
                print-color-adjust:exact;
            }

            .badge-normal{
                background:#dcfce7 !important;
                color:#166534 !important;
            }

            .badge-abnormal{
                background:#fee2e2 !important;
                color:#991b1b !important;
            }
        }
    </style>
</head>
<body>
<div class="report-page">
   <div class="report-toolbar">
    <div class="report-title-wrap">
        <h1 class="report-title">รายงานการตรวจสุขภาพ</h1>
        <p class="report-subtitle">สรุปรายการข้อมูลการตรวจสุขภาพของผู้รับบริการ</p>
    </div>

    <div class="report-actions">
        <a href="{{ route('healthc_heckups.index') }}" class="btn btn-back">
            ← กลับหน้าหลัก
        </a>

        <button class="btn btn-print" onclick="window.print()">
            🖨 พิมพ์รายงาน
        </button>
    </div>
</div>

    <div class="report-table-wrap">
        <table>
            <thead>
                <tr>
                    <th class="col-index">ลำดับ</th>
                    <th class="col-name">ชื่อ-สกุล</th>
                    <th class="col-date">วันที่ตรวจ</th>
                    <th class="col-hospital">สถานพยาบาล</th>
                    <th class="col-result">ผลการตรวจ</th>
                    <th>รายละเอียด</th>
                    <th class="col-recorder">ผู้บันทึก</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $index => $item)
                    <tr>
                        <td class="col-index">{{ $index + 1 }}</td>
                        <td class="col-name">
                            {{ $item->client->fullname ?? (($item->client->first_name ?? '') . ' ' . ($item->client->last_name ?? '')) }}
                        </td>
                        <td class="col-date">{{ optional($item->checkup_date)->format('d/m/Y') }}</td>
                        <td class="col-hospital">{{ $item->hospital_name }}</td>
                        <td class="col-result">
                            @if($item->checkup_result === 'normal')
                                <span class="badge-normal">ปกติ</span>
                            @else
                                <span class="badge-abnormal">ไม่ปกติ</span>
                            @endif
                        </td>
                        <td>{{ $item->abnormal_detail ?: '-' }}</td>
                        <td class="col-recorder">{{ $item->recorder->name ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="empty-row">ไม่พบข้อมูล</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</body>
</html>