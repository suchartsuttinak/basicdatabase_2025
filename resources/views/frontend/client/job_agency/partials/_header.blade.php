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
        <a href="{{ route('job_agencies.report', $client->id) }}"
           class="btn btn-outline-success ja-btn">
            <i class="bi bi-file-earmark-text"></i>
            <span>รายงาน</span>
        </a>

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

                <a href="{{ route('job_agencies.report', $client->id) }}?start_date={{ request('start_date') }}&end_date={{ request('end_date') }}"
                   class="btn btn-success ja-btn">
                    <i class="bi bi-printer"></i>
                    <span>ดูรายงาน</span>
                </a>
            </div>
        </div>
    </form>
</div>