@extends('admin_client.admin_client')

@section('content')
<style>
    .report-container {
        font-family: "TH Sarabun New", "Sarabun", sans-serif;
        font-size: 14px;
        line-height: 1.8;
        color: #000;
        background-color: #fff;
        padding: 40px;
        border: 1px solid #ccc;
        border-radius: 8px;
        position: relative;
    }

    .report-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .report-header h2 {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 10px;
        text-decoration: underline;
    }

    .report-section {
        margin-bottom: 25px;
    }

    .report-section p {
        margin: 0 0 6px;
    }

    .report-label {
        display: inline-block;
        width: 180px;
        font-weight: bold;
    }

    .report-body {
        border-top: 1px dashed #999;
        padding-top: 20px;
    }

    .signature-area {
        margin-top: 40px;
        text-align: right;
    }

    /* ปุ่มกลับหน้าหลัก */
    .back-button {
        position: absolute;
        top: 20px;
        right: 20px;
    }
</style>

<div class="report-container">
    {{-- ปุ่มกลับหน้าหลัก --}}
    <div class="back-button">
        <a href="{{ route('school_followup_add', $client->id) }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-arrow-left-circle"></i> กลับหน้าหลัก
        </a>
    </div>

    {{-- ส่วนหัวรายงาน --}}
    <div class="report-header">
        <h2>รายงานการติดตามเด็กในโรงเรียน</h2>
    </div>

    <div class="report-section">
        <p><span class="report-label">ชื่อ–นามสกุล:</span> {{ $client->full_name }}</p>
        <p><span class="report-label">อายุ:</span> {{ $age }} ปี</p>
        <p><span class="report-label">ระดับการศึกษา:</span> {{ $education_name }}</p>
        <p><span class="report-label">โรงเรียน:</span> {{ $school_name }}</p>
        <p><span class="report-label">ภาคเรียน:</span> {{ $term }}</p>
    </div>

    {{-- ส่วนเนื้อหา: การติดตาม --}}
    <div class="report-body">
        <h4 style="font-weight: bold;">รายละเอียดการติดตาม</h4>

        <div class="report-section">
            <p><span class="report-label">วันที่ติดตาม:</span> {{ $followup->follow_date }}</p>
            <p><span class="report-label">ครั้งที่:</span> {{ $followup->follo_no ?? '-' }}</p>
            <p><span class="report-label">ครูผู้สอน:</span> {{ $followup->teacher_name ?? '-' }}</p>
            <p><span class="report-label">เบอร์โทร:</span> {{ $followup->tel ?? '-' }}</p>
            <p><span class="report-label">ประเภทการติดตาม:</span>
                @switch($followup->follow_type)
                    @case('self') ติดตามด้วยตนเอง @break
                    @case('phone') โทรศัพท์ @break
                    @case('other') อื่นๆ @break
                    @default -
                @endswitch
            </p>
            <p><span class="report-label">ผลการติดตาม:</span> {{ $followup->result ?? '-' }}</p>
            <p><span class="report-label">ผู้ติดต่อ:</span> {{ $followup->contact_name ?? '-' }}</p>
            <p><span class="report-label">หมายเหตุ:</span> {{ $followup->remark ?? '-' }}</p>
        </div>
    </div>

    {{-- ลายเซ็น --}}
    <div class="signature-area">
        <p>.......................................................</p>
        <p>ผู้จัดทำรายงาน</p>
    </div>
</div>
@endsection