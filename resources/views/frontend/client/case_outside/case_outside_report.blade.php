<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>รายงานติดตามเด็กที่อยู่นอกสถานสงเคราะห์</title>

   <style>
    body{
        font-family: "TH Sarabun New", "Sarabun", sans-serif;
        font-size: 17px;
        line-height: 1.45;
        color:#1f2937;
        margin: 0;
        background:#f4f7fb;
    }

    .report-page{
        max-width: 1120px;
        margin: 24px auto;
        background:#ffffff;
        border:1px solid #e5e7eb;
        border-radius: 20px;
        padding: 28px 30px 24px;
        box-shadow: 0 14px 38px rgba(15, 23, 42, 0.08);
    }

    .report-toolbar{
        display:flex;
        justify-content:space-between;
        align-items:center;
        flex-wrap:wrap;
        gap:12px;
        margin-bottom:20px;
    }

    .report-toolbar-left,
    .report-toolbar-right{
        display:flex;
        align-items:center;
        gap:10px;
        flex-wrap:wrap;
    }

    .btn{
        appearance:none;
        border:none;
        text-decoration:none;
        padding:10px 16px;
        border-radius:14px;
        font-size:16px;
        font-weight:700;
        cursor:pointer;
        display:inline-flex;
        align-items:center;
        gap:8px;
        transition:all .2s ease;
    }

    .btn:hover{
        transform:translateY(-1px);
    }

    .btn-back{
        background:#ffffff;
        color:#0f172a;
        border:1px solid #dbe3ef;
        box-shadow: 0 6px 16px rgba(15, 23, 42, 0.05);
    }

    .btn-back .btn-icon{
        width:28px;
        height:28px;
        display:inline-flex;
        align-items:center;
        justify-content:center;
        border-radius:999px;
        background:#eff6ff;
        color:#2563eb;
        font-size:15px;
        font-weight:700;
        flex:0 0 28px;
    }

    .btn-print{
        background:#16a34a;
        color:#ffffff;
        box-shadow: 0 8px 18px rgba(22, 163, 74, 0.22);
    }

    .report-header{
        text-align:center;
        margin-bottom:20px;
        padding-bottom:12px;
        border-bottom:1px solid #e5e7eb;
    }

    .report-title{
        font-size:26px;
        font-weight:800;
        color:#111827;
        letter-spacing:.2px;
        margin-bottom:4px;
    }

    .report-sub{
        font-size:19px;
        font-weight:700;
        color:#334155;
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
        border:1px solid #374151;
        padding:8px 9px;
        vertical-align:top;
        word-wrap:break-word;
    }

    th{
        background:#f8fafc;
        text-align:center;
        font-size:17px;
        font-weight:800;
        color:#111827;
    }

    td{
        font-size:17px;
        color:#1f2937;
    }

    .text-center{
        text-align:center;
    }

    .no-data{
        text-align:center;
        padding:20px;
        border:1px solid #374151;
        border-radius:12px;
        font-size:18px;
        background:#fafafa;
    }

    .report-footer{
        margin-top:12px;
        display:flex;
        justify-content:flex-end;
    }

    .report-print-date{
        font-size:15px;
        color:#475569;
        text-align:right;
    }

    @media (max-width: 768px){
        .report-page{
            margin: 12px;
            padding: 18px 16px 16px;
            border-radius:16px;
        }

        .report-title{
            font-size:22px;
        }

        .report-sub{
            font-size:17px;
        }

        .btn{
            width:100%;
            justify-content:center;
            font-size:15px;
        }

        .report-toolbar-left,
        .report-toolbar-right{
            width:100%;
        }

        th{
            font-size:15px;
        }

        td{
            font-size:15px;
        }

        .report-footer{
            justify-content:flex-start;
        }

        .report-print-date{
            text-align:left;
            font-size:14px;
        }
    }

    @media print{
        body{
            background:#ffffff;
            font-size:16px;
        }

        .report-page{
            max-width:none;
            margin:0;
            padding:0;
            border:none;
            border-radius:0;
            box-shadow:none;
        }

        .report-toolbar{
            display:none;
        }

        .report-title{
            font-size:24px;
        }

        .report-sub{
            font-size:18px;
        }

        th, td{
            font-size:15px;
            padding:6px 7px;
        }

        .report-print-date{
            font-size:14px;
        }

        .no-data{
            font-size:16px;
            padding:16px;
        }
    }
</style>
</head>
<body>

@php
    $printedDate = \Carbon\Carbon::now();
    $printedDateThai = $printedDate->format('d/m/') . ($printedDate->year + 543);
@endphp

<div class="report-page">

    <div class="report-toolbar">
        <div class="report-toolbar-left">
            <a href="{{ route('case_outside.show', $client->id) }}" class="btn btn-back">
                <span class="btn-icon">←</span>
                <span>กลับหน้าหลัก</span>
            </a>
        </div>

        <div class="report-toolbar-right">
            <button type="button" onclick="window.print()" class="btn btn-print">
                <span>🖨️</span>
                <span>พิมพ์รายงาน</span>
            </button>
        </div>
    </div>

    <div class="report-header">
        <div class="report-title">
            รายงานติดตามเด็กที่อยู่นอกสถานสงเคราะห์
        </div>

        <div class="report-sub">
            ผู้รับบริการ:
            {{ $client->fullname ?? $client->name ?? ('ID '.$client->id) }}
        </div>
    </div>

    @if($caseoutsides->count())
        <div class="report-table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:8%;">ลำดับ</th>
                        <th style="width:12%;">วันที่</th>
                        <th style="width:18%;">สาเหตุ</th>
                        <th style="width:16%;">สถานที่พัก</th>
                        <th style="width:14%;">การดำเนินงาน</th>
                        <th>ผลการติดตาม</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($caseoutsides as $case)
                        @php
                            $caseDate = \Carbon\Carbon::parse($case->date);
                            $caseDateThai = $caseDate->format('d/m/') . ($caseDate->year + 543);
                        @endphp
                        <tr>
                            <td class="text-center">{{ $case->count }}</td>
                            <td class="text-center">{{ $caseDateThai }}</td>
                            <td>{{ $case->outside->outside_name ?? '-' }}</td>
                            <td>{{ $case->dormitory ?? '-' }}</td>
                            <td>{{ $case->follo_no ?? '-' }}</td>
                            <td>{{ $case->results ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="report-footer">
            <div class="report-print-date">
                วันที่พิมพ์ {{ $printedDateThai }}
            </div>
        </div>
    @else
        <div class="no-data">
            ไม่พบข้อมูลตามเงื่อนไข
        </div>

        <div class="report-footer">
            <div class="report-print-date">
                วันที่พิมพ์ {{ $printedDateThai }}
            </div>
        </div>
    @endif

</div>

</body>
</html>