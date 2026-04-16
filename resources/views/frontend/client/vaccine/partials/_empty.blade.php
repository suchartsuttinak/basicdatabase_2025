<div class="card border-0 shadow-sm vaccine-table-card">
    <div class="card-body">
        <div class="vaccine-empty-state text-center py-5 px-3">
            <div class="vaccine-empty-state-icon mb-3">
                <i class="bi bi-capsule"></i>
            </div>
            <h6 class="fw-bold mb-2">ยังไม่มีข้อมูลวัคซีน</h6>
            <p class="text-muted mb-3 small">
                เริ่มต้นเพิ่มข้อมูลวัคซีนเพื่อให้ระบบติดตามได้ครบถ้วน
            </p>
            <button type="button"
                    class="btn btn-primary vaccine-btn vaccine-btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#add-vaccine-modal">
                <i class="bi bi-plus-circle"></i>
                <span>เพิ่มข้อมูล</span>
            </button>
        </div>
    </div>
</div>

@push('styles')
<style>
.vaccine-page .vaccine-empty-state-icon {
    width: 72px;
    height: 72px;
    margin: 0 auto;
    border-radius: 18px;
    background: #eff6ff;
    color: var(--vaccine-primary);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
}
</style>
@endpush