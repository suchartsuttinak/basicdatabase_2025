<div class="card border-0 shadow-sm h-100 section-card">
    <div class="card-header fw-bold">
        <i class="bi bi-person-lines-fill me-2 text-primary"></i>ข้อมูลเด็ก
    </div>
    <div class="card-body small">
        <div class="info-row">
            <div class="info-label">ชื่อ-นามสกุล</div>
            <div class="info-value">{{ $clientName }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">อายุ</div>
            <div class="info-value">{{ $clientAge }} ปี</div>
        </div>
        <div class="info-row">
            <div class="info-label">สถานศึกษา</div>
            <div class="info-value">{{ $schoolName }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">ระดับชั้น</div>
            <div class="info-value">{{ $educationName }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">ภาคเรียน</div>
            <div class="info-value">{{ $semesterName }}</div>
        </div>
    </div>
</div>