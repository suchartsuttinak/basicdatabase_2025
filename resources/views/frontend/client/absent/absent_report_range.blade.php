@php
    use App\Helpers\ThaiDateHelper;
@endphp
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>รายงานการขาดเรียน</title>
    <style>
        body{
            font-family:"TH Sarabun New","Sarabun",sans-serif;
            font-size:15px;
            line-height:1.4;
            color:#1f2937;
            margin:0;
            background:#eef2f7;
        }

        .report-page{
            width:100%;
            max-width:1200px;
            margin:20px auto;
            background:#ffffff;
            border:1px solid #e5e7eb;
            border-radius:16px;
            box-shadow:0 10px 28px rgba(15,23,42,0.06);
            overflow:hidden;
        }

        .report-toolbar{
            display:flex;
            justify-content:space-between;
            align-items:center;
            flex-wrap:wrap;
            gap:10px;
            padding:16px 20px 0;
        }

        .toolbar-left,
        .toolbar-right{
            display:flex;
            align-items:center;
            gap:8px;
            flex-wrap:wrap;
        }

        .btn{
            font-family:inherit;
            font-size:14px;
            border-radius:8px;
            padding:7px 14px;
            cursor:pointer;
            display:inline-flex;
            align-items:center;
            gap:6px;
            text-decoration:none;
            border:1px solid transparent;
            transition:all .2s ease;
        }

        .btn-outline{
            border-color:#d1d5db;
            background:#fff;
            color:#374151;
        }

        .btn-outline:hover{
            background:#f9fafb;
        }

        .btn-primary{
            border-color:#1d4ed8;
            background:#1d4ed8;
            color:#fff;
        }

        .btn-primary:hover{
            background:#1e40af;
            border-color:#1e40af;
        }

        .report-wrap{
            padding:16px 20px 22px;
        }

        .report-header{
            text-align:center;
            margin-bottom:14px;
            padding-bottom:10px;
            border-bottom:1px solid #e5e7eb;
        }

        .report-title{
            margin:0;
            font-size:24px;
            font-weight:700;
            color:#111827;
            line-height:1.2;
        }

        .report-subtitle{
            margin:4px 0 0;
            font-size:14px;
            color:#6b7280;
        }

        .client-info{
            display:grid;
            grid-template-columns:repeat(2, minmax(0, 1fr));
            gap:8px 18px;
            margin-bottom:12px;
        }

        .client-info-item{
            font-size:15px;
        }

        .client-info-label{
            font-weight:700;
            color:#111827;
            margin-right:6px;
        }

        .report-meta{
            display:flex;
            justify-content:space-between;
            align-items:center;
            flex-wrap:wrap;
            gap:10px;
            margin-bottom:12px;
            padding:8px 12px;
            background:#f8fafc;
            border:1px solid #e5e7eb;
            border-radius:12px;
        }

        .report-meta-item{
            font-size:14px;
            color:#374151;
        }

        .report-meta-item strong{
            color:#111827;
        }

        .report-table-wrap{
            overflow-x:auto;
            -webkit-overflow-scrolling:touch;
        }

        .report-table{
            width:100%;
            border-collapse:collapse;
            min-width:1000px;
        }

        .report-table th,
        .report-table td{
            border:1px solid #dfe5ec;
            padding:7px 8px;
            vertical-align:top;
            font-size:14px;
            line-height:1.35;
        }

        .report-table thead th{
            background:#f8fafc;
            color:#334155;
            font-weight:700;
            text-align:center;
            white-space:nowrap;
        }

        .text-center{
            text-align:center;
        }

        .empty-state{
            border:1px dashed #d9e2ef;
            border-radius:18px;
            padding:2rem 1rem;
            text-align:center;
            background:linear-gradient(180deg, #ffffff 0%, #fbfdff 100%);
        }

        .empty-icon{
            width:60px;
            height:60px;
            margin:0 auto 1rem;
            border-radius:16px;
            display:flex;
            align-items:center;
            justify-content:center;
            background:#eef4ff;
            color:#2563eb;
            font-size:1.5rem;
        }

        .empty-title{
            font-size:1.05rem;
            font-weight:700;
            margin-bottom:.35rem;
            color:#1f2937;
        }

        .empty-subtitle{
            font-size:.9rem;
            color:#6b7280;
            margin:0;
        }

        @media (max-width: 768px){
            .report-page{
                margin:0;
                border:0;
                border-radius:0;
                box-shadow:none;
            }

            .report-toolbar,
            .report-wrap{
                padding-left:14px;
                padding-right:14px;
            }

            .client-info{
                grid-template-columns:1fr;
            }
        }

        @media print{
            @page{
                size:A4 landscape;
                margin:8mm;
            }

            html, body{
                width:297mm;
                height:210mm;
                background:#fff;
                font-size:13px;
            }

            body{
                margin:0;
            }

            .report-page{
                width:100%;
                max-width:100%;
                margin:0;
                border:0;
                border-radius:0;
                box-shadow:none;
            }

            .report-toolbar{
                display:none !important;
            }

            .report-wrap{
                padding:0;
            }

            .report-header{
                margin-bottom:10px;
                padding-bottom:8px;
            }

            .report-title{
                font-size:22px;
            }

            .report-subtitle{
                font-size:13px;
            }

            .client-info-item,
            .report-meta-item{
                font-size:13px;
            }

            .report-table{
                min-width:unset;
            }

            .report-table th,
            .report-table td{
                font-size:13px;
                padding:6px 7px;
            }
        }
    </style>
</head>
<body>
    <div class="report-page">
        <div class="report-toolbar">
            <div class="toolbar-left">
                <button
                    type="button"
                    class="btn btn-outline"
                    onclick="history.length > 1 ? history.back() : window.location.href='{{ route('absent.add', $client->id) }}'">
                    ← กลับหน้าก่อน
                </button>
            </div>

            <div class="toolbar-right">
                <button type="button" class="btn btn-primary" onclick="window.print()">
                    🖨 พิมพ์รายงาน
                </button>
            </div>
        </div>

        <div class="report-wrap">
            <div class="report-header">
                <h1 class="report-title">รายงานการขาดเรียน</h1>
                <p class="report-subtitle">รายงานสรุปรายการขาดเรียนของผู้รับบริการ</p>
            </div>

            <div class="client-info">
                <div class="client-info-item">
                    <span class="client-info-label">ชื่อผู้รับบริการ:</span>
                    {{ $client->fullname ?? $client->name ?? '-' }}
                </div>
                <div class="client-info-item">
                    <span class="client-info-label">อายุ:</span>
                    {{ $age ?? '-' }} ปี
                </div>
                <div class="client-info-item">
                    <span class="client-info-label">สถานศึกษา:</span>
                    {{ $school_name ?? '-' }}
                </div>
                <div class="client-info-item">
                    <span class="client-info-label">ระดับการศึกษา / ภาคเรียน:</span>
                    {{ $education_name ?? '-' }} / {{ $term ?? '-' }}
                </div>
            </div>

            <div class="report-meta">
                <div class="report-meta-item">
                    <strong>ช่วงวันที่:</strong>
                    {{ $start_date ? ThaiDateHelper::formatThaiDate($start_date) : 'ทั้งหมด' }}
                    -
                    {{ $end_date ? ThaiDateHelper::formatThaiDate($end_date) : 'ทั้งหมด' }}
                </div>

                <div class="report-meta-item">
                    <strong>จำนวนรายการทั้งหมด:</strong>
                    {{ $absents->count() }} รายการ
                </div>
            </div>

            @if($absents->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon">📄</div>
                    <div class="empty-title">ไม่พบข้อมูลการขาดเรียน</div>
                    <p class="empty-subtitle">
                        ยังไม่มีข้อมูลสำหรับจัดทำรายงานในช่วงวันที่ที่เลือก
                    </p>
                </div>
            @else
                <div class="report-table-wrap">
                    <table class="report-table">
                        <thead>
                            <tr>
                                <th style="width: 52px;">ลำดับ</th>
                                <th style="width: 110px;">วันที่ขาดเรียน</th>
                                <th style="width: 170px;">สถานศึกษา</th>
                                <th style="width: 110px;">ระดับการศึกษา</th>
                                <th style="width: 110px;">ภาคเรียน</th>
                                <th style="width: 180px;">สาเหตุการขาดเรียน</th>
                                <th style="width: 180px;">การดำเนินการ</th>
                                <th style="width: 150px;">หมายเหตุ</th>
                                <th style="width: 110px;">ครูผู้บันทึก</th>
                                <th style="width: 110px;">วันที่บันทึก</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($absents as $index => $item)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td class="text-center">
                                        {{ $item->absent_date ? ThaiDateHelper::formatThaiDate($item->absent_date) : '-' }}
                                    </td>
                                    <td>
                                        {{ optional($item->educationRecord)->school_name ?? '-' }}
                                    </td>
                                    <td>
                                        {{ optional(optional($item->educationRecord)->education)->education_name ?? '-' }}
                                    </td>
                                    <td>
                                        {{ optional(optional($item->educationRecord)->semester)->semester_name ?? '-' }}
                                    </td>
                                    <td>{{ $item->cause ?? '-' }}</td>
                                    <td>{{ $item->operation ?? '-' }}</td>
                                    <td>{{ $item->remark ?? '-' }}</td>
                                    <td>{{ $item->teacher ?? '-' }}</td>
                                    <td class="text-center">
                                        {{ $item->record_date ? ThaiDateHelper::formatThaiDate($item->record_date) : '-' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</body>
</html>