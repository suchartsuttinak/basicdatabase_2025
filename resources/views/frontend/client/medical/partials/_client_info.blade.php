<div class="card border-0 shadow-sm mb-3 medical-client-summary-card">
    <div class="card-body p-3">
        <div class="row g-3 align-items-center">
            <div class="col-12 col-xl-8">
                <div class="medical-client-grid">
                    <div class="medical-summary-item">
                        <span class="medical-summary-icon bg-primary-subtle text-primary">
                            <i class="bi bi-person-fill"></i>
                        </span>
                        <div>
                            <div class="medical-summary-label">ชื่อ-สกุล</div>
                            <div class="medical-summary-value">{{ $client->fullname ?? '-' }}</div>
                        </div>
                    </div>

                    <div class="medical-summary-item">
                        <span class="medical-summary-icon bg-success-subtle text-success">
                            <i class="bi bi-calendar-heart"></i>
                        </span>
                        <div>
                            <div class="medical-summary-label">อายุ</div>
                            <div class="medical-summary-value">{{ $client->age ?? '-' }} ปี</div>
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

@push('styles')
<style>
.medical-page .medical-client-summary-card {
    border: 1px solid var(--medical-border-soft);
    box-shadow: var(--medical-shadow-sm);
}

.medical-page .medical-client-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem 1.5rem;
    align-items: stretch;
}

.medical-page .medical-summary-item {
    display: flex;
    align-items: center;
    gap: 12px;
    min-width: 220px;
    flex: 0 1 auto;
}

.medical-page .medical-summary-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    flex: 0 0 44px;
}

.medical-page .medical-summary-label {
    font-size: .78rem;
    color: var(--medical-text-soft);
    margin-bottom: 2px;
    line-height: 1.2;
}

.medical-page .medical-summary-value {
    font-weight: 700;
    color: #111827;
    line-height: 1.35;
    word-break: break-word;
}

.medical-page .medical-note-box {
    background: var(--medical-bg-soft);
    border: 1px dashed #cbd5e1;
    color: #475569;
    border-radius: 14px;
    padding: 12px 14px;
    font-size: .875rem;
}

@media (max-width: 767.98px) {
    .medical-page .medical-client-summary-card {
        border-radius: var(--medical-radius-md);
    }

    .medical-page .medical-client-grid {
        flex-direction: column;
        gap: .85rem;
    }

    .medical-page .medical-summary-item {
        width: 100%;
        min-width: 0;
    }
}
</style>
@endpush