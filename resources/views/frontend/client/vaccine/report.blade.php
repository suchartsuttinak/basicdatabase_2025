@extends('admin_client.admin_client')

@section('content')
@php
    use Carbon\Carbon;

    function thaiDateVaccineReport($date) {
        if (!$date) return '-';
        return Carbon::parse($date)->addYears(543)->format('d/m/Y');
    }
@endphp

<div class="container-fluid vaccine-report-page">

    <style>
        .vaccine-report-page{
            font-family: "TH Sarabun New", "Sarabun", sans-serif;
            font-size: 17px;
            line-height: 1.45;
            color: #1f2937;
        }

        .vaccine-report-page .vaccine-report-shell{
            max-width: 1380px;
            margin: 24px auto;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 18px;
            box-shadow: 0 14px 36px rgba(15, 23, 42, 0.08);
            overflow: hidden;
        }

        .vaccine-report-page .vaccine-report-body{
            padding: 24px 26px 22px;
        }

        .vaccine-report-page .vaccine-report-toolbar{
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 18px;
        }

        .vaccine-report-page .vaccine-report-toolbar-left,
        .vaccine-report-page .vaccine-report-toolbar-right{
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .vaccine-report-page .vaccine-btn{
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 46px;
            padding: .70rem 1.05rem;
            border-radius: 14px;
            font-weight: 800;
            border: 1px solid #d1d5db;
            background: #ffffff;
            color: #334155;
            text-decoration: none;
            transition: all .2s ease;
            white-space: nowrap;
        }

        .vaccine-report-page .vaccine-btn:hover{
            background: #f8fafc;
            color: #0f172a;
        }

        .vaccine-report-page .vaccine-btn-back{
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            border-color: #cbd5e1;
            box-shadow: 0 4px 14px rgba(15, 23, 42, 0.05);
        }

        .vaccine-report-page .vaccine-btn-back:hover{
            transform: translateY(-1px);
            box-shadow: 0 8px 18px rgba(15, 23, 42, 0.08);
        }

        .vaccine-report-page .vaccine-btn-print{
            background: #2563eb;
            border-color: #2563eb;
            color: #ffffff;
        }

        .vaccine-report-page .vaccine-btn-print:hover{
            background: #1d4ed8;
            border-color: #1d4ed8;
            color: #ffffff;
        }

        .vaccine-report-page .vaccine-report-header{
            text-align: center;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 12px;
            margin-bottom: 16px;
        }

        .vaccine-report-page .vaccine-report-badge{
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 12px;
            border-radius: 999px;
            background: #eff6ff;
            color: #1d4ed8;
            font-size: .88rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .vaccine-report-page .vaccine-report-title{
            font-size: 1.85rem;
            font-weight: 800;
            margin: 0;
            color: #0f172a;
        }

        .vaccine-report-page .vaccine-report-subtitle{
            font-size: .96rem;
            color: #6b7280;
            margin-top: 4px;
            line-height: 1.6;
        }

        .vaccine-report-page .vaccine-report-info{
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
            margin-bottom: 16px;
        }

        .vaccine-report-page .vaccine-report-info-box{
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            padding: 12px 14px;
            background: linear-gradient(180deg, #fbfdff 0%, #f8fafc 100%);
        }

        .vaccine-report-page .vaccine-report-info-label{
            font-size: .80rem;
            color: #64748b;
            font-weight: 700;
            margin-bottom: 2px;
        }

        .vaccine-report-page .vaccine-report-info-value{
            font-size: .98rem;
            font-weight: 700;
            color: #0f172a;
            line-height: 1.45;
            word-break: break-word;
        }

        .vaccine-report-page .vaccine-report-table-wrap{
            overflow-x: auto;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
        }

        .vaccine-report-page .vaccine-report-table{
            width: 100%;
            min-width: 980px;
            margin-bottom: 0;
        }

        .vaccine-report-page .vaccine-report-table thead th{
            background: #f8fafc;
            color: #0f172a;
            font-weight: 800;
            font-size: .86rem;
            text-align: center;
            vertical-align: middle;
            border-bottom: 1px solid #e5e7eb;
            white-space: nowrap;
        }

        .vaccine-report-page .vaccine-report-table tbody td{
            font-size: .92rem;
            vertical-align: middle;
            color: #1f2937;
        }

        .vaccine-report-page .vaccine-report-table tbody tr:nth-child(even){
            background: #fcfdff;
        }

        .vaccine-report-page .vaccine-report-table tbody tr:hover{
            background: #f8fbff;
        }

        .vaccine-report-page .vaccine-report-empty{
            text-align: center;
            padding: 42px 20px;
            color: #6b7280;
            border: 1px dashed #d1d5db;
            border-radius: 14px;
            background: #fafafa;
        }

        .vaccine-report-page .vaccine-report-empty i{
            font-size: 2rem;
            color: #94a3b8;
            display: block;
            margin-bottom: 8px;
        }

        @page{
            size: A4 landscape;
            margin: 10mm;
        }

        @media (max-width: 991.98px){
            .vaccine-report-page .vaccine-report-info{
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 767.98px){
            .vaccine-report-page .vaccine-report-body{
                padding: 16px;
            }

            .vaccine-report-page .vaccine-report-title{
                font-size: 1.45rem;
            }

            .vaccine-report-page .vaccine-report-info{
                grid-template-columns: 1fr;
            }

            .vaccine-report-page .vaccine-report-toolbar-left,
            .vaccine-report-page .vaccine-report-toolbar-right{
                width: 100%;
            }

            .vaccine-report-page .vaccine-btn{
                width: 100%;
            }
        }

        @media print{
            .vaccine-report-page .vaccine-report-toolbar{
                display: none;
            }

            .vaccine-report-page .vaccine-report-shell{
                border: none;
                box-shadow: none;
                margin: 0;
                max-width: 100%;
            }

            .vaccine-report-page .vaccine-report-body{
                padding: 0;
            }

            .vaccine-report-page .vaccine-report-table thead th,
            .vaccine-report-page .vaccine-report-table tbody td{
                font-size: 13px;
                padding: 6px;
            }
        }
    </style>

    <div class="vaccine-report-shell">
        <div class="vaccine-report-body">

            <div class="vaccine-report-toolbar">
                <div class="vaccine-report-toolbar-left">
                    <a href="{{ route('vaccine.index', [
                        'client_id'  => $client->id,
                        'start_date' => request('start_date'),
                        'end_date'   => request('end_date')
                    ]) }}" class="vaccine-btn vaccine-btn-back">
                        <i class="bi bi-arrow-left-circle"></i>
                        <span>กลับหน้าหลักวัคซีน</span>
                    </a>
                </div>

                <div class="vaccine-report-toolbar-right">
                    <button onclick="window.print()" type="button" class="vaccine-btn vaccine-btn-print">
                        <i class="bi bi-printer"></i>
                        <span>พิมพ์รายงาน</span>
                    </button>
                </div>
            </div>

            <div class="vaccine-report-header">
                

                <h1 class="vaccine-report-title">รายงานการได้รับวัคซีน</h1>
                <div class="vaccine-report-subtitle">
                   
                </div>
            </div>

            <div class="vaccine-report-info">
                <div class="vaccine-report-info-box">
                    <div class="vaccine-report-info-label">ชื่อ-สกุล</div>
                    <div class="vaccine-report-info-value">{{ $client->fullname ?? '-' }}</div>
                </div>

                <div class="vaccine-report-info-box">
                    <div class="vaccine-report-info-label">อายุ</div>
                    <div class="vaccine-report-info-value">{{ $client->age ?? '-' }} ปี</div>
                </div>

                <div class="vaccine-report-info-box">
                    <div class="vaccine-report-info-label">จำนวนรายการ</div>
                    <div class="vaccine-report-info-value">{{ $vaccinations->count() }} รายการ</div>
                </div>
            </div>

            @if($vaccinations->isNotEmpty())
                <div class="vaccine-report-table-wrap">
                    <table class="table vaccine-report-table">
                        <thead>
                            <tr>
                                <th style="width: 70px;">ลำดับ</th>
                                <th style="width: 130px;">วันเดือนปี</th>
                                <th style="min-width: 240px;">ชื่อวัคซีน</th>
                                <th style="min-width: 240px;">สถานพยาบาล</th>
                                <th style="min-width: 190px;">ผู้บันทึก</th>
                                <th style="min-width: 260px;">หมายเหตุ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($vaccinations as $key => $item)
                                <tr>
                                    <td class="text-center">{{ $key + 1 }}</td>
                                    <td class="text-center">{{ thaiDateVaccineReport($item->date) }}</td>
                                    <td>{{ $item->vaccine_name ?? '-' }}</td>
                                    <td>{{ $item->hospital ?? '-' }}</td>
                                    <td>{{ $item->recorder ?? '-' }}</td>
                                    <td>{{ $item->remark ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="vaccine-report-empty">
                    <i class="bi bi-inbox"></i>
                    <div>ไม่มีข้อมูลรายงานวัคซีน</div>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection