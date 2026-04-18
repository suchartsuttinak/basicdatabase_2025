<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>รายงานการบาดเจ็บ</title>
    <style>
        body{
            font-family:"TH Sarabun New","Sarabun",sans-serif;
            font-size:16px;
            line-height:1.4;
            color:#1f2937;
            margin:0;
            background:#f4f7fb;
        }

        .report-page{
            max-width:900px;
            margin:24px auto;
            background:#ffffff;
            border:1px solid #e5e7eb;
            border-radius:16px;
            padding:24px 26px;
            box-shadow:0 10px 28px rgba(15,23,42,0.06);
        }

        .report-toolbar{
            display:flex;
            justify-content:space-between;
            align-items:center;
            flex-wrap:wrap;
            gap:10px;
            margin-bottom:16px;
        }

        .report-toolbar-left,
        .report-toolbar-right{
            display:flex;
            align-items:center;
            gap:8px;
        }

        .btn{
            font-family:inherit;
            font-size:15px;
            border-radius:8px;
            padding:6px 14px;
            cursor:pointer;
            display:inline-flex;
            align-items:center;
            gap:6px;
            text-decoration:none;
            transition:all .2s ease;
        }

        .btn-outline{
            border:1px solid #d1d5db;
            background:#fff;
            color:#374151;
        }

        .btn-outline:hover{
            background:#f3f4f6;
        }

        .btn-primary{
            border:1px solid #1d4ed8;
            background:#1d4ed8;
            color:#fff;
        }

        .btn-primary:hover{
            background:#1e40af;
            border-color:#1e40af;
        }

        .report-header{
            text-align:center;
            margin-bottom:14px;
        }

        .report-title{
            font-size:22px;
            font-weight:700;
            margin:0;
            color:#111827;
        }

        .report-subtitle{
            font-size:15px;
            color:#6b7280;
            margin-top:4px;
        }

        .client-info{
            display:flex;
            justify-content:space-between;
            flex-wrap:wrap;
            gap:8px 16px;
            border-bottom:1px solid #e5e7eb;
            padding-bottom:8px;
            margin-bottom:14px;
        }

        .client-info span{
            font-size:16px;
        }

        .label{
            font-weight:600;
            margin-right:6px;
            color:#111827;
        }

        .report-table{
            width:100%;
            border-collapse:collapse;
            font-size:15px;
        }

        .report-table th,
        .report-table td{
            border:1px solid #e5e7eb;
            padding:8px 10px;
            vertical-align:top;
        }

        .report-table th{
            width:24%;
            background:#f9fafb;
            text-align:left;
            font-weight:600;
            white-space:nowrap;
            color:#111827;
        }

        @media (max-width:768px){
            body{
                background:#ffffff;
            }

            .report-page{
                margin:0;
                border:0;
                border-radius:0;
                padding:14px;
                box-shadow:none;
            }

            .client-info{
                flex-direction:column;
                gap:4px;
            }

            .report-table th{
                width:34%;
            }
        }

        @media print{
            @page{
                size:A4 portrait;
                margin:12mm;
            }

            body{
                background:#fff;
                font-size:15px;
            }

            .report-page{
                margin:0;
                border:0;
                border-radius:0;
                box-shadow:none;
                padding:0;
                max-width:100%;
            }

            .report-toolbar{
                display:none !important;
            }
        }
    </style>
</head>
<body>
    <div class="report-page">

        <div class="report-toolbar">
            <div class="report-toolbar-left">
                <button
                    type="button"
                    class="btn btn-outline"
                    onclick="history.length > 1 ? history.back() : window.location.href='{{ route('client.edit', $client->id) }}'">
                    ← กลับหน้าก่อน
                </button>
            </div>

            <div class="report-toolbar-right">
                <button type="button" class="btn btn-primary" onclick="window.print()">
                    🖨 พิมพ์รายงาน
                </button>
            </div>
        </div>

        <div class="report-header">
            <div class="report-title">รายงานบันทึกการบาดเจ็บ</div>
            <div class="report-subtitle">ข้อมูลผู้รับบริการและรายละเอียดเหตุการณ์</div>
        </div>

        <div class="client-info">
            <span>
                <span class="label">ชื่อผู้รับบริการ:</span>
                {{ $client->name ?? $client->fullname ?? '-' }}
            </span>

            <span>
                <span class="label">อายุ:</span>
                {{ $client->age ?? '-' }} ปี
            </span>
        </div>

        <table class="report-table">
            <tr>
                <th>วันที่เกิดเหตุ</th>
                <td>{{ $accident->incident_date ? $accident->incident_date->format('d/m/Y') : '-' }}</td>
            </tr>
            <tr>
                <th>สถานที่เกิดเหตุ</th>
                <td>{{ $accident->location ?? '-' }}</td>
            </tr>
            <tr>
                <th>ผู้พบเห็นเหตุการณ์</th>
                <td>{{ $accident->eyewitness ?? '-' }}</td>
            </tr>
            <tr>
                <th>รายละเอียดการบาดเจ็บ</th>
                <td>{{ $accident->detail ?? '-' }}</td>
            </tr>
            <tr>
                <th>สาเหตุ</th>
                <td>{{ $accident->cause ?? '-' }}</td>
            </tr>
           <tr>
            <th>การพบแพทย์</th>
                <td>{{ $accident->treat_no ?? '-' }}</td>
            </tr>

            {{-- 🔥 ถ้ามีการพบแพทย์เท่านั้น --}}
            @if(!empty($accident->treat_no) && $accident->treat_no != 'ไม่พบแพทย์')
                <tr>
                    <th>สถานพยาบาล</th>
                    <td>{{ $accident->hospital ?? '-' }}</td>
                </tr>
                <tr>
                    <th>ผลวินิจฉัย</th>
                    <td>{{ $accident->diagnosis ?? '-' }}</td>
                </tr>
                <tr>
                    <th>นัดครั้งต่อไป</th>
                    <td>{{ $accident->appointment ? $accident->appointment->format('d/m/Y') : '-' }}</td>
                </tr>
            @endif
            <tr>
                <th>การรักษา</th>
                <td>{{ $accident->treatment ?? '-' }}</td>
            </tr>
            <tr>
                <th>การป้องกัน/การแก้ไข</th>
                <td>{{ $accident->protection ?? '-' }}</td>
            </tr>
            <tr>
                <th>ผู้ดูแล</th>
                <td>{{ $accident->caretaker ?? '-' }}</td>
            </tr>
            <tr>
                <th>วันที่บันทึก</th>
                <td>{{ $accident->record_date ? $accident->record_date->format('d/m/Y') : '-' }}</td>
            </tr>
        </table>
    </div>
</body>
</html>