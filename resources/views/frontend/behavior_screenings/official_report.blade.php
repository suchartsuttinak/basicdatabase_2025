@extends('admin_client.admin_client')

@section('content')

@php
    $groups = [
        'learning' => [
            'title' => 'ภาวะเรียนรู้ช้า',
            'score' => $screening->learning_score,
            'risk' => $screening->learning_risk,
        ],
        'ld' => [
            'title' => 'ภาวะแอลดี',
            'score' => $screening->ld_score,
            'risk' => $screening->ld_risk,
        ],
        'adhd' => [
            'title' => 'ภาวะสมาธิสั้น',
            'score' => $screening->adhd_score,
            'risk' => $screening->adhd_risk,
        ],
        'autism' => [
            'title' => 'ภาวะออทิสติก',
            'score' => $screening->autism_score,
            'risk' => $screening->autism_risk,
        ],
    ];

    $itemsByCategory = $screening->items->groupBy('category');
@endphp

<style>
    .official-page{
        background:#f1f5f9;
        padding:24px 0;
    }

    .official-sheet{
        width:210mm;
        min-height:297mm;
        margin:auto;
        background:#fff;
        padding:11mm 12mm 14mm;
        color:#111827;
        font-family:"TH Sarabun New","Sarabun",sans-serif;
        font-size:18px;
        line-height:1.28;
        box-shadow:0 10px 30px rgba(15,23,42,.12);
    }

    .official-toolbar{
        width:210mm;
        margin:0 auto 12px;
        display:flex;
        justify-content:space-between;
        gap:10px;
    }

    .official-report-head{
        margin-top:0;
        margin-bottom:8px;
        text-align:center;
    }

    .official-title{
        text-align:center;
        font-size:23px;
        font-weight:800;
        margin:0 0 2px;
        line-height:1.12;
    }

    .official-subtitle{
        text-align:center;
        font-size:19px;
        font-weight:600;
        margin:0;
        line-height:1.12;
    }

   .official-info{
    gap:3px 14px;
    margin-top:12px !important;   /* เพิ่มระยะห่างจากหัวข้อ */
    margin-bottom:4px !important;
    line-height:1.12;
}

    .official-info > div{
        min-height:25px;
    }

    .official-line{
        border-bottom:1px dotted #111;
        display:inline-block;
        min-width:120px;
        padding:0 8px 1px;
        line-height:1.05;
    }

    .official-table{
        width:100%;
        border-collapse:collapse;
        margin-top:6px;
    }

    .official-table th,
    .official-table td{
        border:1px solid #111;
        padding:4px 7px;
        vertical-align:top;
    }

    .official-table th{
        text-align:center;
        font-weight:700;
        background:#f8fafc;
    }

    .official-section-row td{
        background:#e5e7eb;
        font-weight:700;
    }

    .text-center{
        text-align:center;
    }

    .check-cell{
        font-size:20px;
        font-weight:700;
        text-align:center;
        width:44px;
        line-height:1;
    }

    .official-summary{
        margin-top:12px;
        border:1px solid #111;
    }

    .official-summary-title{
        padding:5px 8px;
        font-weight:700;
        border-bottom:1px solid #111;
        background:#f8fafc;
    }

    .official-summary-body{
        padding:7px 10px;
        white-space:pre-line;
        min-height:38px;
    }

    .official-score-table{
        width:100%;
        border-collapse:collapse;
        margin-top:10px;
    }

    .official-score-table th,
    .official-score-table td{
        border:1px solid #111;
        padding:4px 8px;
    }

    .official-sign{
        margin-top:22px;
        display:flex;
        justify-content:flex-end;
    }

    .official-sign-box{
        width:260px;
        text-align:center;
    }

  @media print{

    html,
    body{
        background:#fff !important;
        margin:0 !important;
        padding:0 !important;
    }

    body{
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    .official-page{
        padding:0 !important;
        margin:0 !important;
        background:#fff !important;
    }

    .official-toolbar,
    .main-header,
    .left-side-bar,
    .navbar-custom,
    .footer{
        display:none !important;
    }

    .official-sheet{
        width:100% !important;
        min-height:auto !important;

        margin:0 !important;
        padding:0 !important;

        box-shadow:none !important;
        border:none !important;

        font-size:17px;
        line-height:1.18;

        position:static !important; /* สำคัญ */
    }

  .official-report-head{
    margin:0 0 14px 0 !important;
    padding:0 !important;
}

    .official-title{
        font-size:22px;
        line-height:1.02;
        margin:0 !important;
    }

    .official-subtitle{
        font-size:18px;
        line-height:1.02;
        margin:0 !important;
    }

    .official-info{
        gap:2px 14px;
        margin-top:1px !important;
        margin-bottom:4px !important;
        line-height:1.08;
    }

    .official-table{
        margin-top:3px !important;
    }

    @page{
        size:A4 portrait;
        margin:6mm 10mm 6mm 10mm;
    }
}
</style>

<div class="official-page">

    <div class="official-toolbar">
        <a href="{{ route('behavior-screenings.show', $screening->id) }}"
           class="btn btn-light border">
            <i class="bi bi-arrow-left"></i>
            กลับ
        </a>

        <button onclick="window.print()" class="btn btn-primary">
            <i class="bi bi-printer"></i>
            พิมพ์รายงาน
        </button>
    </div>

    <div class="official-sheet">

        <div class="official-title">
            แบบสังเกตพฤติกรรม 4 โรค
        </div>

        <div class="official-subtitle">
            สำหรับคัดกรองพฤติกรรมเบื้องต้น
        </div>

        <div class="official-info">
            <div>
                ชื่อ - สกุล
                <span class="official-line">
                    {{ $client->first_name }} {{ $client->last_name }}
                </span>
            </div>

            <div>
                อายุ
                <span class="official-line">
                    {{ $screening->age_text ?: '-' }}
                </span>
            </div>

            <div>
                ชั้นเรียน
                <span class="official-line">
                    {{ $screening->class_level ?: '-' }}
                </span>
            </div>

            <div>
                เลขทะเบียน
                <span class="official-line">
                    {{ $client->register_number ?? '-' }}
                </span>
            </div>

            <div>
                วันที่ประเมิน
                <span class="official-line">
                    {{ $screening->screening_date?->format('d/m/Y') }}
                </span>
            </div>

            <div>
                ผู้ประเมิน
                <span class="official-line">
                    {{ $screening->observer_name ?: '-' }}
                </span>
            </div>
        </div>

        <table class="official-table">
            <thead>
                <tr>
                    <th style="width:55px;">ข้อ</th>
                    <th>รายการสังเกตพฤติกรรม</th>
                    <th style="width:55px;">ใช่</th>
                    <th style="width:65px;">ไม่ใช่</th>
                </tr>
            </thead>

            <tbody>
                @foreach($groups as $category => $group)
                    <tr class="official-section-row">
                        <td colspan="4">
                            {{ $group['title'] }}
                        </td>
                    </tr>

                    @foreach(($itemsByCategory[$category] ?? collect()) as $item)
                        <tr>
                            <td class="text-center">{{ $item->item_no }}</td>
                            <td>{{ $item->question }}</td>
                            <td class="check-cell">{{ $item->answer ? '✓' : '' }}</td>
                            <td class="check-cell">{{ ! $item->answer ? '✓' : '' }}</td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>

        <table class="official-score-table">
            <thead>
                <tr>
                    <th>ด้านที่ประเมิน</th>
                    <th style="width:100px;">คะแนนรวม</th>
                    <th style="width:180px;">ผลการประเมิน</th>
                </tr>
            </thead>

            <tbody>
                @foreach($groups as $group)
                    <tr>
                        <td>{{ $group['title'] }}</td>
                        <td class="text-center">{{ $group['score'] }}</td>
                        <td class="text-center">
                            {{ $group['risk'] ? 'มีความเสี่ยง' : 'ไม่พบความเสี่ยง' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="official-summary">
            <div class="official-summary-title">
                สรุปผลการประเมิน
            </div>
            <div class="official-summary-body">
                {{ $screening->summary }}
            </div>
        </div>

        <div class="official-summary">
            <div class="official-summary-title">
                คำแนะนำ
            </div>
            <div class="official-summary-body">
                {{ $screening->recommendation }}
            </div>
        </div>

        @if($screening->remark)
            <div class="official-summary">
                <div class="official-summary-title">
                    หมายเหตุ
                </div>
                <div class="official-summary-body">
                    {{ $screening->remark }}
                </div>
            </div>
        @endif

        <div class="official-sign">
            <div class="official-sign-box">
                ลงชื่อ........................................ผู้ประเมิน<br>
                (................................................)<br>
                วันที่........../........../..........
            </div>
        </div>

    </div>
</div>

@endsection