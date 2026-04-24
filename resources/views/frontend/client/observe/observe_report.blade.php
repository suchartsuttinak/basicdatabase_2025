@extends('admin_client.admin_client')

@section('content')

@php
    use Carbon\Carbon;

    function thai_date($date) {
        if (!$date) return '-';
        try {
            $d = $date instanceof \Carbon\Carbon ? $date : Carbon::parse($date);
            return $d->format('d/m/') . ($d->year + 543);
        } catch (\Exception $e) {
            return '-';
        }
    }

    $followCount = $observe->followups ? $observe->followups->count() : 0;
    $clientFullName = trim(($client->prefix ?? '') . ($client->first_name ?? '') . ' ' . ($client->last_name ?? '')) ?: '-';
@endphp

<div class="container-fluid report-page">
<div class="report-shell">

    {{-- Header --}}
    <div class="report-header">
        <div>
            <h1>รายงานพฤติกรรมและการติดตามผล</h1>
            <p>ข้อมูลเหตุการณ์ การดำเนินการ และการติดตามผลทั้งหมด</p>
        </div>

        <div class="report-actions">
           <a href="#" onclick="window.print()" class="btn btn-primary">
                <i class="bi bi-printer"></i> พิมพ์
            </a>
            <a href="{{ route('observe.create', $client->id) }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> กลับ
            </a>
        </div>
    </div>

    {{-- TABLE เดียว --}}
    <div class="table-responsive">
        <table class="report-table">

            {{-- SECTION: SUMMARY --}}
            <tr class="section">
                <td colspan="4">สรุปข้อมูล</td>
            </tr>
            <tr>
                <th>วันที่เกิดเหตุ</th>
                <td>{{ thai_date($observe->date) }}</td>
                <th>ประเภทพฤติกรรม</th>
                <td>{{ $observe->misbehavior->misbehavior_name ?? '-' }}</td>
            </tr>
            <tr>
                <th>จำนวนครั้งติดตาม</th>
                <td>{{ $followCount }} ครั้ง</td>
                <th>วันที่บันทึก</th>
                <td>{{ thai_date($observe->record_date) }}</td>
            </tr>

            {{-- SECTION: MAIN --}}
            <tr class="section">
                <td colspan="4">ข้อมูลเหตุการณ์</td>
            </tr>
            <tr>
                <th>ผู้รับบริการ</th>
                <td colspan="3">{{ $clientFullName }}</td>
            </tr>
            <tr>
                <th>ผู้บันทึก</th>
                <td colspan="3">{{ $observe->recorder ?: '-' }}</td>
            </tr>
            <tr>
                <th>พฤติกรรม</th>
                <td colspan="3">{!! nl2br(e($observe->behavior ?: '-')) !!}</td>
            </tr>
            <tr>
                <th>สาเหตุ</th>
                <td colspan="3">{!! nl2br(e($observe->cause ?: '-')) !!}</td>
            </tr>

            {{-- SECTION: ACTION --}}
            <tr class="section">
                <td colspan="4">การดำเนินการ</td>
            </tr>
            <tr>
                <th>แนวทางแก้ไข</th>
                <td colspan="3">{!! nl2br(e($observe->solution ?: '-')) !!}</td>
            </tr>
            <tr>
                <th>การดำเนินการ</th>
                <td colspan="3">{!! nl2br(e($observe->action ?: '-')) !!}</td>
            </tr>
            <tr>
                <th>อุปสรรค</th>
                <td colspan="3">{!! nl2br(e($observe->obstacles ?: '-')) !!}</td>
            </tr>
            <tr>
                <th>ผลการดำเนินการ</th>
                <td colspan="3">{!! nl2br(e($observe->result ?: '-')) !!}</td>
            </tr>

            {{-- SECTION: FOLLOWUP --}}
            <tr class="section">
                <td colspan="4">ประวัติการติดตามผล</td>
            </tr>

            @if($followCount > 0)
                <tr class="follow-header">
                    <th>ครั้งที่</th>
                    <th>วันที่</th>
                    <th>การติดตาม</th>
                    <th>ผล</th>
                </tr>

                @foreach($observe->followups as $followup)
                <tr>
                    <td class="center">{{ $followup->followup_count ?: $loop->iteration }}</td>
                    <td class="center">{{ thai_date($followup->followup_date) }}</td>
                    <td>{!! nl2br(e($followup->followup_action ?: '-')) !!}</td>
                    <td>{!! nl2br(e($followup->followup_result ?: '-')) !!}</td>
                </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4" class="empty">ไม่มีข้อมูลการติดตามผล</td>
                </tr>
            @endif

        </table>
    </div>

</div>
</div>

<style>
.report-page{
    padding:20px 12px;
    background:#f6f8fb;
}

.report-shell{
    max-width:1100px;
    margin:auto;
}

.report-header{
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    margin-bottom:18px;
    flex-wrap:wrap;
    gap:10px;
}

.report-header h1{
    font-size:1.5rem;
    font-weight:800;
    margin-bottom:4px;
}

.report-header p{
    color:#6b7280;
    font-size:.9rem;
}

.report-actions{
    display:flex;
    gap:8px;
}

.report-table{
    width:100%;
    border-collapse:collapse;
    background:#fff;
    border:1px solid #e5e7eb;
}

.report-table th,
.report-table td{
    border:1px solid #e5e7eb;
    padding:10px 12px;
    font-size:14px;
    vertical-align:top;
}

.report-table th{
    width:180px;
    background:#f9fafb;
    font-weight:600;
}

.report-table .section td{
    background:#eef2ff;
    font-weight:700;
    text-align:left;
    font-size:14px;
}

.report-table .follow-header th{
    background:#f3f4f6;
    text-align:center;
}

.center{
    text-align:center;
}

.empty{
    text-align:center;
    color:#9ca3af;
    padding:16px;
}

@media (max-width:768px){
    .report-table{
        display:block;
        overflow-x:auto;
        white-space:nowrap;
    }

    /* ================= PRINT ================= */
@media print {

    body{
        background:#fff !important;
    }

    .report-page{
        padding:0 !important;
        background:#fff !important;
    }

    .report-shell{
        max-width:100% !important;
        margin:0 !important;
    }

    /* ซ่อนปุ่ม */
    .report-actions{
        display:none !important;
    }

    /* ตารางเต็มหน้า */
    .report-table{
        width:100% !important;
        font-size:13px;
    }

    .report-table th,
    .report-table td{
        padding:6px 8px;
    }

    /* ไม่ให้ตารางตัดหน้า */
    .report-table tr{
        page-break-inside: avoid;
    }

}

/* A4 แนวนอนจริง */
@page {
    size: A4 landscape;
    margin: 12mm;
}
}
</style>

@endsection