@extends('admin_client.admin_client')

@section('content')

<style>
.co-filter-page {
    --co-border:#dbe3ef;
    --co-text:#0f172a;
    --co-muted:#64748b;
    --co-bg:#f8fbff;
}

.co-filter-page .co-filter-card{
    background:#fff;
    border:1px solid var(--co-border);
    border-radius:20px;
    box-shadow:0 8px 24px rgba(15,23,42,.06);
    overflow:hidden;
}

.co-filter-page .co-filter-head{
    padding:1.25rem 1.25rem 1rem;
    border-bottom:1px solid var(--co-border);
    background:linear-gradient(135deg,#ffffff 0%,#f8fbff 100%);
}

.co-filter-page .co-filter-title{
    margin:0;
    font-size:1.35rem;
    font-weight:800;
    color:var(--co-text);
}

.co-filter-page .co-filter-subtitle{
    margin:.4rem 0 0;
    color:var(--co-muted);
    line-height:1.7;
}

.co-filter-page .co-filter-body{
    padding:1.25rem;
}

.co-filter-page .co-label{
    font-weight:700;
    margin-bottom:.45rem;
    color:#334155;
}

.co-filter-page .form-control,
.co-filter-page .form-select{
    min-height:46px;
    border-radius:14px;
    border:1px solid #dbe3ef;
    box-shadow:none;
}

.co-filter-page .form-control:focus,
.co-filter-page .form-select:focus{
    border-color:#93c5fd;
    box-shadow:0 0 0 .2rem rgba(37,99,235,.10);
}

.co-filter-page .co-btn{
    min-height:46px;
    border-radius:14px;
    font-weight:700;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:.45rem;
    padding:.7rem 1rem;
}

@media (max-width: 767.98px){
    .co-filter-page .co-filter-head,
    .co-filter-page .co-filter-body{
        padding:1rem;
    }
}
</style>

<div class="container-fluid mt-2 co-filter-page">
    <div class="co-filter-card">
        <div class="co-filter-head">
            <h1 class="co-filter-title">ค้นหารายงานติดตามเด็กที่อยู่นอกสถานสงเคราะห์</h1>
            <p class="co-filter-subtitle">
                กำหนดเงื่อนไขช่วงวันที่ ประเภทสาเหตุที่พักภายนอก และรูปแบบการติดตาม
                เพื่อเปิดหน้ารายงานแบบพร้อมพิมพ์
            </p>
        </div>

        <div class="co-filter-body">
            <form action="{{ route('case_outside.report', $client->id) }}" method="GET" target="_blank">
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label class="co-label">วันที่เริ่มต้น</label>
                        <input type="date" name="date_start" class="form-control" value="{{ request('date_start') }}">
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="co-label">วันที่สิ้นสุด</label>
                        <input type="date" name="date_end" class="form-control" value="{{ request('date_end') }}">
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="co-label">สาเหตุที่พักอาศัยอยู่ภายนอก</label>
                        <select name="outside_id" class="form-select">
                            <option value="">-- ทั้งหมด --</option>
                            @foreach($outside as $o)
                                <option value="{{ $o->id }}">
                                    {{ $o->outside_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="co-label">การดำเนินงาน</label>
                        <select name="follo_no" class="form-select">
                            <option value="">-- ทั้งหมด --</option>
                            <option value="หน่วยงานไปเอง">หน่วยงานไปเอง</option>
                            <option value="โทรศัพท์">โทรศัพท์</option>
                            <option value="จดหมาย">จดหมาย</option>
                        </select>
                    </div>

                    <div class="col-12 pt-2">
                        <div class="d-flex flex-wrap gap-2">
                            <button type="submit" class="btn btn-success co-btn">
                                <i class="bi bi-printer"></i>
                                <span>แสดงรายงาน</span>
                            </button>

                            <a href="{{ route('case_outside.show', $client->id) }}" class="btn btn-outline-secondary co-btn">
                                <i class="bi bi-arrow-left-circle"></i>
                                <span>กลับหน้าหลัก</span>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection