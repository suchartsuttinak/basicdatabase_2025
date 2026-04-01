<div class="card border-0 shadow-sm mb-3 vaccine-summary-card">
    <div class="card-body p-3">
        <div class="row g-3 align-items-center">
            <div class="col-12 col-xl-8">
                <div class="vaccine-client-grid">
                    <div class="vaccine-client-item">
                        <span class="vaccine-client-icon vaccine-client-icon--primary">
                            <i class="bi bi-person-fill"></i>
                        </span>
                        <div class="vaccine-client-text">
                            <div class="vaccine-client-label">ชื่อ-สกุล</div>
                            <div class="vaccine-client-value">{{ $client->fullname ?? '-' }}</div>
                        </div>
                    </div>

                    <div class="vaccine-client-item">
                        <span class="vaccine-client-icon vaccine-client-icon--success">
                            <i class="bi bi-calendar-heart"></i>
                        </span>
                        <div class="vaccine-client-text">
                            <div class="vaccine-client-label">อายุ</div>
                            <div class="vaccine-client-value">{{ $client->age ?? '-' }} ปี</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-4">
                <div class="vaccine-note-box">
                    <i class="bi bi-shield-check me-1"></i>
                    ควรบันทึกข้อมูลวัคซีนให้ครบถ้วน เพื่อใช้ติดตามและอ้างอิงในอนาคต
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.vaccine-page .vaccine-summary-card {
    border: 1px solid var(--vaccine-border-soft);
    box-shadow: var(--vaccine-shadow-sm);
}

.vaccine-page .vaccine-client-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem 1.5rem;
    align-items: stretch;
}

.vaccine-page .vaccine-client-item {
    display: flex;
    align-items: center;
    gap: 12px;
    min-width: 220px;
    flex: 0 1 auto;
}

.vaccine-page .vaccine-client-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    flex: 0 0 44px;
}

.vaccine-page .vaccine-client-icon--primary {
    background: #dbeafe;
    color: #1d4ed8;
}

.vaccine-page .vaccine-client-icon--success {
    background: #dcfce7;
    color: #15803d;
}

.vaccine-page .vaccine-client-text {
    min-width: 0;
    display: flex;
    flex-direction: column;
}

.vaccine-page .vaccine-client-label {
    font-size: .78rem;
    color: var(--vaccine-text-soft);
    margin-bottom: 2px;
    line-height: 1.2;
}

.vaccine-page .vaccine-client-value {
    font-weight: 700;
    color: #111827;
    line-height: 1.35;
    word-break: break-word;
}

.vaccine-page .vaccine-note-box {
    background: var(--vaccine-bg-soft);
    border: 1px dashed #cbd5e1;
    color: #475569;
    border-radius: 14px;
    padding: 12px 14px;
    font-size: .875rem;
}

@media (max-width: 767.98px) {
    .vaccine-page .vaccine-summary-card {
        border-radius: var(--vaccine-radius-md);
    }

    .vaccine-page .vaccine-client-grid {
        flex-direction: column;
        gap: .85rem;
    }

    .vaccine-page .vaccine-client-item {
        width: 100%;
        min-width: 0;
    }
}
</style>
@endpush