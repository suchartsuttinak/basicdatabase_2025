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
            box-shadow: 0 14px 36px rgba(15, 23, 42, 0.08);
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

        @media print{
            .report-toolbar{
                display:none;
            }

            .report-page{
                border:none;
                box-shadow:none;
                margin:0;
            }

            .report-body{
                padding:0;
            }

            .report-table th,
            .report-table td{
                font-size:13px;
                padding:6px;
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