<div class="card border-0 shadow-sm mb-3 client-summary-card">
    <div class="card-body p-3">
        <div class="row g-3 align-items-center">
            <div class="col-12 col-xl-8">
                <div class="d-flex flex-column flex-md-row flex-wrap gap-3 gap-md-4">
                    <div class="summary-item">
                        <span class="summary-icon bg-primary-subtle text-primary">
                            <i class="bi bi-person-fill"></i>
                        </span>
                        <div>
                            <div class="summary-label">ชื่อ-สกุล</div>
                            <div class="summary-value">{{ $client->fullname ?? '-' }}</div>
                        </div>
                    </div>

                    <div class="summary-item">
                        <span class="summary-icon bg-success-subtle text-success">
                            <i class="bi bi-calendar-heart"></i>
                        </span>
                        <div>
                            <div class="summary-label">อายุ</div>
                            <div class="summary-value">{{ $client->age ?? '-' }} ปี</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-4">
                <div class="medical-note-box">
                    <i class="bi bi-shield-check me-1"></i>
                    ข้อมูลสุขภาพควรบันทึกอย่างถูกต้อง ครบถ้วน และติดตามต่อเนื่อง
                </div>
            </div>
        </div>
    </div>
</div>