
<style>
    .ja-empty-card{
    margin-bottom:1rem;
    padding:52px 20px;
    border:1px solid #e7edf5;
    border-radius:22px;
    background:linear-gradient(135deg,#ffffff 0%,#f8fbff 100%);
    box-shadow:0 12px 32px rgba(15,23,42,.06);
    text-align:center;
}

.ja-empty-icon{
    width:86px;
    height:86px;
    margin:0 auto 18px;
    border-radius:50%;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    background:#ecfdf5;
    color:#16a34a;
    font-size:2.1rem;
    box-shadow:0 12px 28px rgba(22,163,74,.14);
}

.ja-empty-card h5{
    margin:0 0 8px;
    color:#0f172a;
    font-size:1.25rem;
    font-weight:800;
}

.ja-empty-card p{
    max-width:620px;
    margin:0 auto 22px;
    color:#64748b;
    line-height:1.8;
}

.ja-empty-btn{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    min-height:44px;
    padding:.68rem 1rem;
    border-radius:12px;
    font-weight:700;
}

@media (max-width:575.98px){
    .ja-empty-card{
        padding:42px 14px;
    }

    .ja-empty-icon{
        width:74px;
        height:74px;
        font-size:1.8rem;
    }

    .ja-empty-btn{
        width:100%;
    }
}
</style>


@php
    $hasJobAgencyRows = false;

    if (isset($jobAgencies)) {
        $hasJobAgencyRows = $jobAgencies->count() > 0;
    } elseif (isset($job_agencies)) {
        $hasJobAgencyRows = $job_agencies->count() > 0;
    } elseif (isset($items)) {
        $hasJobAgencyRows = $items->count() > 0;
    }

    $hasDateFilter = request()->filled('start_date') || request()->filled('end_date');

    // ✅ มีข้อมูล หรือมีการค้นหาแล้ว ค่อยแสดง header/filter
    // ✅ ถ้าไม่มีข้อมูลจริง ให้ซ่อนรายงาน/ค้นหา/หัวข้อมูล
    $showJobAgencySection = $hasJobAgencyRows || $hasDateFilter;
@endphp

@if($showJobAgencySection)
    <div class="ja-main-header">
        <div class="ja-header-left">
            <span class="ja-header-icon">
                <i class="bi bi-briefcase-fill"></i>
            </span>

            <div class="ja-header-text">
                <h6>การจัดหางานให้ผู้รับ</h6>
                <p>ออกแบบใหม่ให้ทันสมัย ใช้งานง่าย และรองรับทุกขนาดหน้าจอ</p>
            </div>
        </div>

        <div class="ja-header-actions">
            @if($hasJobAgencyRows)
                <a href="{{ route('job_agencies.report', $client->id) }}"
                   class="btn btn-outline-success ja-btn">
                    <i class="bi bi-file-earmark-text"></i>
                    <span>รายงาน</span>
                </a>
            @endif

            <button type="button"
                    class="btn btn-primary ja-btn"
                    data-bs-toggle="modal"
                    data-bs-target="#createJobAgencyModal">
                <i class="bi bi-plus-circle"></i>
                <span>เพิ่มข้อมูล</span>
            </button>
        </div>
    </div>

    <div class="ja-filter-card">
        <form method="GET" action="{{ route('job_agencies.show', $client->id) }}">
            <div class="ja-filter-row">
                <div class="ja-filter-group">
                    <label for="start_date" class="form-label">วันที่เริ่มต้น</label>
                    <input type="date"
                           id="start_date"
                           name="start_date"
                           class="form-control"
                           value="{{ request('start_date') }}">
                </div>

                <div class="ja-filter-group">
                    <label for="end_date" class="form-label">วันที่สิ้นสุด</label>
                    <input type="date"
                           id="end_date"
                           name="end_date"
                           class="form-control"
                           value="{{ request('end_date') }}">
                </div>

                <div class="ja-filter-actions">
                    <button type="submit" class="btn btn-primary ja-btn">
                        <i class="bi bi-search"></i>
                        <span>ค้นหา</span>
                    </button>

                    <a href="{{ route('job_agencies.show', $client->id) }}"
                       class="btn btn-light ja-btn ja-btn-reset">
                        <i class="bi bi-arrow-clockwise"></i>
                        <span>รีเซ็ต</span>
                    </a>

                    @if($hasJobAgencyRows)
                        <a href="{{ route('job_agencies.report', $client->id) }}?start_date={{ request('start_date') }}&end_date={{ request('end_date') }}"
                           class="btn btn-success ja-btn">
                            <i class="bi bi-printer"></i>
                            <span>ดูรายงาน</span>
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
@else
    <div class="ja-empty-card">
        <div class="ja-empty-icon">
            <i class="bi bi-briefcase"></i>
        </div>

        <h5>ยังไม่มีข้อมูลการจัดหางาน</h5>

        <p>
            เมื่อยังไม่มีข้อมูล ระบบจะซ่อนปุ่มรายงาน ช่องค้นหา และส่วนหัวรายการไว้ก่อน
            เพื่อให้หน้าจอดูสะอาดและใช้งานง่ายขึ้น
        </p>

        <button type="button"
                class="btn btn-primary ja-empty-btn"
                data-bs-toggle="modal"
                data-bs-target="#createJobAgencyModal">
            <i class="bi bi-plus-circle"></i>
            <span>เพิ่มข้อมูลการจัดหางาน</span>
        </button>
    </div>
@endif