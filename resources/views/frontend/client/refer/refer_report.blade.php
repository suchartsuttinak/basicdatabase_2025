@php
    use Carbon\Carbon;
@endphp
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>รายงานการจำหน่าย / ส่งต่อ</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        .refer-print-page,
        .refer-print-page *{
            box-sizing:border-box;
        }

        body{
            margin:0;
            background:#f6f8fb;
            color:#0f172a;
            font-family:"TH Sarabun New","Sarabun",sans-serif;
        }

        .refer-print-page{
            max-width:1120px;
            margin:0 auto;
            padding:30px 22px 42px;
            background:#ffffff;
            min-height:100vh;
            color:#1e293b;
            font-size:15px;
            line-height:1.72;
        }

        .refer-print-toolbar{
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap:12px;
            flex-wrap:wrap;
            margin-bottom:22px;
            padding-bottom:15px;
            border-bottom:1px solid #e2e8f0;
        }

        .refer-print-toolbar-left,
        .refer-print-toolbar-right{
            display:flex;
            align-items:center;
            gap:10px;
            flex-wrap:wrap;
        }

        .refer-print-btn{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            gap:8px;
            min-height:42px;
            padding:9px 16px;
            border-radius:12px;
            border:1px solid #d7e0ea;
            background:#ffffff;
            color:#0f172a;
            text-decoration:none;
            font-size:14px;
            font-weight:700;
            line-height:1;
            cursor:pointer;
            transition:all .2s ease;
            white-space:nowrap;
            box-shadow:0 4px 14px rgba(15,23,42,.04);
        }

        .refer-print-btn:hover{
            background:#f8fbff;
            border-color:#bfd0e3;
            color:#0f172a;
            transform:translateY(-1px);
        }

        .refer-print-btn-print{
            background:linear-gradient(135deg,#2563eb 0%,#1d4ed8 100%);
            color:#ffffff;
            border-color:#1d4ed8;
            box-shadow:0 10px 24px rgba(37,99,235,.18);
        }

        .refer-print-btn-print:hover{
            background:linear-gradient(135deg,#1d4ed8 0%,#1e40af 100%);
            color:#ffffff;
            border-color:#1e40af;
        }

        .refer-print-header{
            margin-bottom:20px;
        }

        .refer-print-title{
            text-align:center;
            padding-bottom:14px;
            border-bottom:2px solid #e7edf5;
            margin-bottom:16px;
        }

        .refer-print-title h1{
            margin:0;
            font-size:25px;
            font-weight:800;
            line-height:1.2;
            color:#0f172a;
            letter-spacing:.2px;
        }

        .refer-print-title p{
            margin:5px 0 0;
            font-size:14px;
            color:#64748b;
        }

        .refer-print-meta{
            display:grid;
            grid-template-columns:repeat(2, minmax(0, 1fr));
            gap:8px 30px;
            margin-bottom:10px;
            padding-bottom:12px;
            border-bottom:1px solid #e8eef5;
        }

        .refer-print-meta-item{
            display:flex;
            align-items:flex-start;
            gap:8px;
            min-width:0;
        }

        .refer-print-meta-label{
            flex:0 0 112px;
            font-weight:700;
            color:#475569;
        }

        .refer-print-meta-value{
            flex:1 1 auto;
            min-width:0;
            font-weight:700;
            color:#0f172a;
            word-break:break-word;
        }

        .refer-print-summary{
            display:flex;
            justify-content:space-between;
            align-items:flex-end;
            gap:14px;
            flex-wrap:wrap;
            margin-bottom:2px;
            padding-bottom:12px;
            border-bottom:1px solid #e8eef5;
        }

        .refer-print-summary-title{
            font-size:19px;
            font-weight:800;
            color:#0f172a;
            line-height:1.2;
        }

        .refer-print-summary-subtitle{
            margin-top:2px;
            font-size:13px;
            color:#64748b;
        }

        .refer-print-count{
            font-size:14px;
            font-weight:700;
            color:#1d4ed8;
            white-space:nowrap;
        }

        .refer-print-list{
            width:100%;
        }

        .refer-print-item{
            padding:18px 0 16px;
            border-bottom:1px solid #e7edf5;
            page-break-inside:avoid;
        }

        .refer-print-item:first-child{
            padding-top:12px;
        }

        .refer-print-item-head{
            display:flex;
            justify-content:space-between;
            align-items:flex-start;
            gap:12px;
            flex-wrap:wrap;
            margin-bottom:10px;
        }

        .refer-print-item-title{
            display:flex;
            align-items:center;
            gap:12px;
            flex-wrap:wrap;
        }

        .refer-print-date{
            font-size:16px;
            font-weight:800;
            color:#1e293b;
            letter-spacing:.1px;
        }

        .refer-print-status{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            min-height:30px;
            padding:4px 13px;
            border-radius:999px;
            font-size:13px;
            font-weight:700;
            line-height:1.1;
            white-space:nowrap;
            border:1px solid transparent;
        }

        .refer-print-status-approved{
            background:#ecfdf3;
            color:#166534;
            border-color:#bbf7d0;
        }

        .refer-print-status-pending{
            background:#fff7ed;
            color:#b45309;
            border-color:#fed7aa;
        }

        .refer-print-status-cancelled{
            background:#fef2f2;
            color:#b91c1c;
            border-color:#fecaca;
        }

        .refer-print-status-default{
            background:#f1f5f9;
            color:#475569;
            border-color:#e2e8f0;
        }

        .refer-print-grid{
            display:grid;
            grid-template-columns:minmax(0,1fr) minmax(0,1fr);
            gap:6px 34px;
        }

        .refer-print-row{
            display:flex;
            align-items:flex-start;
            gap:8px;
            min-width:0;
            padding:1px 0;
        }

        .refer-print-row-full{
            grid-column:1 / -1;
        }

        .refer-print-row-emphasis{
            grid-column:1 / -1;
            padding:0 0 2px;
        }

        .refer-print-label{
            flex:0 0 120px;
            max-width:120px;
            font-weight:700;
            color:#475569;
            line-height:1.65;
        }

        .refer-print-value{
            flex:1 1 auto;
            min-width:0;
            color:#0f172a;
            font-weight:600;
            line-height:1.65;
            word-break:break-word;
            white-space:normal;
        }

        .refer-print-value-strong{
            font-weight:700;
            color:#0f172a;
        }

        .refer-print-value-muted{
            color:#64748b;
            font-weight:500;
        }

        .refer-print-empty{
            padding:18px 0 10px;
            color:#64748b;
            text-align:center;
            font-size:15px;
        }

        .refer-print-footer{
            margin-top:18px;
            padding-top:10px;
            border-top:1px solid #e2e8f0;
            text-align:right;
            font-size:14px;
            color:#64748b;
        }

        @media (min-width: 992px){
            .refer-print-row-emphasis .refer-print-label{
                flex-basis:145px;
                max-width:145px;
            }

            .refer-print-row-emphasis .refer-print-value{
                white-space:nowrap;
                overflow:hidden;
                text-overflow:ellipsis;
            }
        }

        @media (max-width: 991.98px){
            .refer-print-grid{
                gap:6px 22px;
            }

            .refer-print-row-emphasis .refer-print-value{
                white-space:normal;
                overflow:visible;
                text-overflow:unset;
            }
        }

        @media (max-width: 768px){
            .refer-print-page{
                padding:20px 14px 28px;
                font-size:14px;
            }

            .refer-print-toolbar{
                align-items:flex-start;
            }

            .refer-print-toolbar-left,
            .refer-print-toolbar-right{
                width:100%;
            }

            .refer-print-toolbar-right{
                justify-content:flex-start;
            }

            .refer-print-title h1{
                font-size:21px;
            }

            .refer-print-title p,
            .refer-print-summary-subtitle,
            .refer-print-footer{
                font-size:13px;
            }

            .refer-print-meta,
            .refer-print-grid{
                grid-template-columns:1fr;
                gap:5px 0;
            }

            .refer-print-meta-label,
            .refer-print-label{
                flex:0 0 102px;
                max-width:102px;
            }

            .refer-print-date{
                font-size:15px;
            }
        }

        @media (max-width: 576px){
            .refer-print-toolbar-left,
            .refer-print-toolbar-right{
                display:grid;
                grid-template-columns:1fr;
            }

            .refer-print-btn{
                width:100%;
            }

            .refer-print-item-head{
                align-items:flex-start;
            }

            .refer-print-meta-item,
            .refer-print-row{
                display:block;
            }

            .refer-print-meta-label,
            .refer-print-label{
                display:block;
                margin-bottom:1px;
                max-width:none;
            }

            .refer-print-row-emphasis .refer-print-value{
                white-space:normal;
                overflow:visible;
                text-overflow:unset;
            }
        }

        @media print{
            @page{
                size:A4 portrait;
                margin:12mm;
            }

            body{
                margin:0;
                background:#ffffff;
            }

            .refer-print-page{
                max-width:100%;
                min-height:auto;
                margin:0;
                padding:0;
                background:#ffffff;
                font-size:13px;
                line-height:1.48;
            }

            .refer-print-toolbar{
                display:none !important;
            }

            .refer-print-title{
                margin-bottom:10px;
                padding-bottom:8px;
            }

            .refer-print-title h1{
                font-size:18px;
            }

            .refer-print-title p{
                font-size:11px;
                margin-top:2px;
            }

            .refer-print-meta{
                gap:4px 16px;
                margin-bottom:8px;
                padding-bottom:8px;
            }

            .refer-print-summary{
                margin-bottom:2px;
                padding-bottom:7px;
            }

            .refer-print-summary-title{
                font-size:15px;
            }

            .refer-print-summary-subtitle,
            .refer-print-count,
            .refer-print-footer{
                font-size:11px;
            }

            .refer-print-item{
                padding:10px 0 8px;
            }

            .refer-print-date{
                font-size:13px;
            }

            .refer-print-status{
                min-height:22px;
                font-size:11px;
                padding:2px 8px;
            }

            .refer-print-grid{
                gap:2px 18px;
            }

            .refer-print-label{
                flex:0 0 104px;
                max-width:104px;
            }

            .refer-print-row-emphasis .refer-print-label{
                flex-basis:128px;
                max-width:128px;
            }

            .refer-print-row-emphasis .refer-print-value{
                white-space:nowrap;
                overflow:hidden;
                text-overflow:ellipsis;
            }

            .refer-print-footer{
                margin-top:10px;
                padding-top:6px;
            }
        }
    </style>
</head>
<body>
    <div class="refer-print-page">
        <div class="refer-print-toolbar">
            <div class="refer-print-toolbar-left">
                <a href="{{ route('refers.index', $client->id) }}" class="refer-print-btn">
                    <i class="bi bi-arrow-left"></i>
                    <span>กลับหน้ารายการ</span>
                </a>
            </div>

            <div class="refer-print-toolbar-right">
                <button type="button" class="refer-print-btn refer-print-btn-print" onclick="window.print()">
                    <i class="bi bi-printer"></i>
                    <span>พิมพ์รายงาน</span>
                </button>
            </div>
        </div>

        <div class="refer-print-header">
            <div class="refer-print-title">
                <h1>รายงานการจำหน่าย</h1>
                <p>สรุปรายละเอียดการจำหน่าย / ส่งต่อผู้รับบริการ</p>
            </div>

            <div class="refer-print-meta">
                <div class="refer-print-meta-item">
                    <div class="refer-print-meta-label">ชื่อ-สกุล</div>
                    <div class="refer-print-meta-value">{{ $client->fullname ?? '-' }}</div>
                </div>
                <div class="refer-print-meta-item">
                    <div class="refer-print-meta-label">รหัสผู้รับบริการ</div>
                    <div class="refer-print-meta-value">{{ $client->id ?? '-' }}</div>
                </div>
            </div>
        </div>

        <div class="refer-print-summary">
            <div>
                <div class="refer-print-summary-title">รายละเอียดรายการจำหน่าย</div>
                <div class="refer-print-summary-subtitle">จัดเรียงข้อมูลแบบอ่านต่อเนื่อง เพื่อให้ตรวจสอบย้อนหลังได้สะดวกและครบถ้วน</div>
            </div>
            <div class="refer-print-count">ทั้งหมด {{ $refers->count() }} รายการ</div>
        </div>

        <div class="refer-print-list">
            @forelse($refers as $index => $item)
                <div class="refer-print-item">
                    <div class="refer-print-item-head">
                        <div class="refer-print-item-title">
                            <div class="refer-print-date">
                                วันที่ส่งต่อ :
                                {{ !empty($item->refer_date) ? Carbon::parse($item->refer_date)->addYears(543)->format('d/m/Y') : '-' }}
                            </div>
                        </div>

                        <div>
                            @if(($item->approve_status ?? '') === 'approved')
                                <span class="refer-print-status refer-print-status-approved">อนุมัติแล้ว</span>
                            @elseif(($item->approve_status ?? '') === 'pending')
                                <span class="refer-print-status refer-print-status-pending">รออนุมัติ</span>
                            @elseif(($item->approve_status ?? '') === 'cancelled')
                                <span class="refer-print-status refer-print-status-cancelled">ยกเลิกแล้ว</span>
                            @else
                                <span class="refer-print-status refer-print-status-default">{{ $item->approve_status ?? '-' }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="refer-print-grid">
                        <div class="refer-print-row refer-print-row-emphasis">
                            <div class="refer-print-label">สาเหตุการจำหน่าย</div>
                            <div class="refer-print-value refer-print-value-strong">
                                {{ $item->translate->name ?? $item->translate->translate_name ?? '-' }}
                            </div>
                        </div>

                        <div class="refer-print-row">
                            <div class="refer-print-label">ผลคณะกรรมการ</div>
                            <div class="refer-print-value">{{ $item->committee_result ?? '-' }}</div>
                        </div>

                        <div class="refer-print-row">
                            <div class="refer-print-label">ข้อมูลผู้ดูแล</div>
                            <div class="refer-print-value">{{ $item->guardian ?? '-' }}</div>
                        </div>

                        <div class="refer-print-row refer-print-row-full">
                            <div class="refer-print-label">สถานที่ส่งต่อ</div>
                            <div class="refer-print-value">{{ $item->destination ?? '-' }}</div>
                        </div>

                        <div class="refer-print-row refer-print-row-full">
                            <div class="refer-print-label">ที่อยู่</div>
                            <div class="refer-print-value">{{ $item->address ?? '-' }}</div>
                        </div>

                        <div class="refer-print-row">
                            <div class="refer-print-label">ชื่อผู้ดูแล</div>
                            <div class="refer-print-value">{{ $item->parent_name ?? '-' }}</div>
                        </div>

                        <div class="refer-print-row">
                            <div class="refer-print-label">ความสัมพันธ์</div>
                            <div class="refer-print-value">{{ $item->member ?? '-' }}</div>
                        </div>

                        <div class="refer-print-row">
                            <div class="refer-print-label">เบอร์โทร</div>
                            <div class="refer-print-value">{{ $item->parent_tel ?? '-' }}</div>
                        </div>

                        <div class="refer-print-row">
                            <div class="refer-print-label">ผู้นำส่ง</div>
                            <div class="refer-print-value">{{ $item->teacher ?? '-' }}</div>
                        </div>

                        <div class="refer-print-row">
                            <div class="refer-print-label">ไฟล์การประชุม</div>
                            <div class="refer-print-value">
                                @if(!empty($item->meeting_report_file))
                                    มีไฟล์แนบ
                                @else
                                    -
                                @endif
                            </div>
                        </div>

                        <div class="refer-print-row refer-print-row-full">
                            <div class="refer-print-label">หมายเหตุ</div>
                            <div class="refer-print-value {{ empty($item->remark) ? 'refer-print-value-muted' : '' }}">
                                {{ $item->remark ?? '-' }}
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="refer-print-empty">
                    ไม่พบข้อมูลการจำหน่าย / ส่งต่อ
                </div>
            @endforelse
        </div>

        <div class="refer-print-footer">
            เอกสารนี้สร้างจากระบบรายงานการจำหน่าย / ส่งต่อ
        </div>
    </div>
</body>
</html>