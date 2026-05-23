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
        font-family:"TH Sarabun New","Sarabun",sans-serif;
        font-size:17px;
        line-height:1.4;
        color:#1f2937;
    }

    .vaccine-report-shell{
        max-width:1380px;
        margin:24px auto;
        background:#fff;
        border:1px solid #e5e7eb;
        border-radius:18px;
        box-shadow:0 14px 36px rgba(15,23,42,.08);
        overflow:hidden;
    }

    .vaccine-report-body{
        padding:24px 26px 22px;
    }

    .vaccine-report-toolbar{
        display:flex;
        justify-content:space-between;
        align-items:center;
        gap:12px;
        flex-wrap:wrap;
        margin-bottom:18px;
    }

    .vaccine-report-toolbar-left,
    .vaccine-report-toolbar-right{
        display:flex;
        align-items:center;
        gap:10px;
        flex-wrap:wrap;
    }

    .vaccine-btn{
        display:inline-flex;
        align-items:center;
        justify-content:center;
        gap:8px;
        min-height:46px;
        padding:.70rem 1.05rem;
        border-radius:14px;
        font-weight:800;
        border:1px solid #d1d5db;
        background:#fff;
        color:#334155;
        text-decoration:none;
        transition:all .2s ease;
        white-space:nowrap;
    }

    .vaccine-btn:hover{
        background:#f8fafc;
        color:#0f172a;
    }

    .vaccine-btn-back{
        background:linear-gradient(180deg,#ffffff 0%,#f8fafc 100%);
        border-color:#cbd5e1;
        color:#334155;
        box-shadow:0 4px 14px rgba(15,23,42,.06);
    }

    .vaccine-btn-back:hover{
        background:#f1f5f9;
        border-color:#94a3b8;
        color:#0f172a;
        transform:translateY(-1px);
    }

    .vaccine-btn-print{
        background:linear-gradient(135deg,#2563eb 0%,#1d4ed8 100%);
        border-color:#2563eb;
        color:#fff;
        box-shadow:0 8px 18px rgba(37,99,235,.22);
    }

    .vaccine-btn-print:hover{
        background:linear-gradient(135deg,#1d4ed8 0%,#1e40af 100%);
        border-color:#1d4ed8;
        color:#fff;
        transform:translateY(-1px);
    }

    .vaccine-report-header{
        text-align:center;
        border-bottom:1px solid #dbe4f0;
        padding-bottom:12px;
        margin-bottom:14px;
    }

    .vaccine-report-title{
        font-size:2rem;
        font-weight:900;
        margin:0;
        color:#0f172a;
        letter-spacing:.2px;
        line-height:1.2;
    }

    .vaccine-report-info{
        display:flex;
        align-items:center;
        justify-content:flex-start;
        flex-wrap:wrap;
        gap:10px 28px;
        margin:0 0 16px;
        padding:0 0 12px 14px;
        border-bottom:1px solid #dbe4f0;
    }

    .vaccine-report-info-item{
        display:inline-flex;
        align-items:center;
        gap:7px;
        white-space:nowrap;
        position:relative;
    }

    .vaccine-report-info-item::after{
        content:"";
        position:absolute;
        right:-15px;
        top:50%;
        transform:translateY(-50%);
        width:1px;
        height:16px;
        background:#dbe4f0;
    }

    .vaccine-report-info-item:last-child::after{
        display:none;
    }

    .vaccine-report-info-label,
    .vaccine-report-info-value{
        font-size:1.02rem;
        font-weight:800;
        color:#2563eb;
        line-height:1.25;
        letter-spacing:.15px;
    }

    .vaccine-report-table-wrap{
        width:100%;
        overflow-x:auto;
        border:1px solid #e2e8f0;
        border-radius:14px;
        background:#fff;
    }

    .vaccine-report-table{
        width:100%;
        min-width:0;
        margin-bottom:0;
        table-layout:fixed;
        border-collapse:separate;
        border-spacing:0;
    }

    .vaccine-report-table thead th{
        background:#f8fafc;
        color:#0f172a;
        font-weight:900;
        font-size:.92rem;
        text-align:center !important;
        vertical-align:middle !important;
        padding:13px 10px;
        border-bottom:1px solid #e2e8f0;
        white-space:nowrap;
    }

    .vaccine-report-table tbody td{
        font-size:.96rem;
        font-weight:700;
        vertical-align:middle !important;
        color:#111827;
        padding:13px 10px;
        border-bottom:1px solid #eef2f7;
        word-break:break-word;
        text-align:center !important;
    }

    .vaccine-report-table tbody tr:last-child td{
        border-bottom:none;
    }

    .vaccine-report-table tbody tr:nth-child(even){
        background:#fcfdff;
    }

    .vaccine-report-table th:nth-child(1),
    .vaccine-report-table td:nth-child(1){
        width:6%;
    }

    .vaccine-report-table th:nth-child(2),
    .vaccine-report-table td:nth-child(2){
        width:12%;
    }

    .vaccine-report-table th:nth-child(3),
    .vaccine-report-table td:nth-child(3){
        width:24%;
    }

    .vaccine-report-table th:nth-child(4),
    .vaccine-report-table td:nth-child(4){
        width:23%;
    }

    .vaccine-report-table th:nth-child(5),
    .vaccine-report-table td:nth-child(5){
        width:16%;
    }

    .vaccine-report-table th:nth-child(6),
    .vaccine-report-table td:nth-child(6){
        width:19%;
    }

    .vaccine-report-empty{
        text-align:center;
        padding:42px 20px;
        color:#64748b;
        border:1px dashed #cbd5e1;
        border-radius:14px;
        background:linear-gradient(180deg,#ffffff 0%,#f8fafc 100%);
    }

    .vaccine-report-empty i{
        font-size:2rem;
        color:#94a3b8;
        display:block;
        margin-bottom:8px;
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
    .vaccine-report-toolbar,
    header,
    footer{
        display:none !important;
    }

    .container-fluid,
    .vaccine-report-page{
        width:100% !important;
        max-width:100% !important;
        margin:0 auto !important;
        padding:0 !important;
        background:#fff !important;
        overflow:visible !important;
    }

    .vaccine-report-shell{
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

    .vaccine-report-body{
        padding:0 !important;
        margin:0 !important;
    }

    .vaccine-report-header{
        text-align:center !important;
        border-bottom:1px solid #cbd5e1 !important;
        padding:0 0 5px !important;
        margin:0 0 6px !important;
    }

    .vaccine-report-title{
        font-size:20px !important;
        font-weight:900 !important;
        line-height:1.1 !important;
        color:#0f172a !important;
        margin:0 !important;
    }

    .vaccine-report-info{
        display:flex !important;
        align-items:center !important;
        justify-content:flex-start !important;
        flex-wrap:wrap !important;
        gap:4px 22px !important;
        margin:0 0 6px !important;
        padding:0 0 5px 4px !important;
        border-bottom:1px solid #dbe4f0 !important;
    }

    .vaccine-report-info-item{
        display:inline-flex !important;
        align-items:center !important;
        gap:5px !important;
        white-space:nowrap !important;
        position:relative !important;
        margin:0 !important;
        padding:0 !important;
    }

    .vaccine-report-info-item::after{
        content:"";
        position:absolute;
        right:-12px;
        top:50%;
        transform:translateY(-50%);
        width:1px;
        height:12px;
        background:#cbd5e1;
    }

    .vaccine-report-info-item:last-child::after{
        display:none !important;
    }

    .vaccine-report-info-label,
    .vaccine-report-info-value{
        font-size:12.5px !important;
        font-weight:800 !important;
        color:#2563eb !important;
        line-height:1.1 !important;
    }

    .vaccine-report-table-wrap{
        width:100% !important;
        max-width:100% !important;
        overflow:visible !important;
        border:none !important;
        border-radius:0 !important;
        margin:0 !important;
        padding:0 !important;
    }

    .vaccine-report-table{
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

    .vaccine-report-table thead{
        display:table-header-group !important;
    }

    .vaccine-report-table tr{
        page-break-inside:avoid !important;
        break-inside:avoid !important;
    }

    .vaccine-report-table thead th{
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

    .vaccine-report-table tbody td{
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

    .vaccine-report-table tbody tr:nth-child(even){
        background:#fcfdff !important;
    }

    .vaccine-report-table th:nth-child(1),
    .vaccine-report-table td:nth-child(1){
        width:5% !important;
    }

    .vaccine-report-table th:nth-child(2),
    .vaccine-report-table td:nth-child(2){
        width:10% !important;
    }

    .vaccine-report-table th:nth-child(3),
    .vaccine-report-table td:nth-child(3){
        width:24% !important;
    }

    .vaccine-report-table th:nth-child(4),
    .vaccine-report-table td:nth-child(4){
        width:24% !important;
    }

    .vaccine-report-table th:nth-child(5),
    .vaccine-report-table td:nth-child(5){
        width:15% !important;
    }

    .vaccine-report-table th:nth-child(6),
    .vaccine-report-table td:nth-child(6){
        width:22% !important;
    }

    .vaccine-report-empty{
        border:1px dashed #94a3b8 !important;
        border-radius:0 !important;
        padding:14px !important;
        text-align:center !important;
        color:#475569 !important;
        font-size:12px !important;
    }

    .vaccine-report-empty i{
        font-size:20px !important;
        margin-bottom:4px !important;
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
            </div>

            <div class="vaccine-report-info">
                <div class="vaccine-report-info-item">
                    <span class="vaccine-report-info-label">ชื่อ-สกุล :</span>
                    <span class="vaccine-report-info-value">{{ $client->fullname ?? '-' }}</span>
                </div>

                <div class="vaccine-report-info-item">
                    <span class="vaccine-report-info-label">อายุ :</span>
                    <span class="vaccine-report-info-value">{{ $client->age ?? '-' }} ปี</span>
                </div>

               
            </div>

            @if($vaccinations->isNotEmpty())
                <div class="vaccine-report-table-wrap">
                    <table class="table vaccine-report-table">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>วันเดือนปี</th>
                                <th>ชื่อวัคซีน</th>
                                <th>สถานพยาบาล</th>
                                <th>ผู้บันทึก</th>
                                <th>หมายเหตุ</th>
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