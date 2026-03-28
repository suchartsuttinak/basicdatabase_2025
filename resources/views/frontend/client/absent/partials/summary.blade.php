<div class="card border-0 shadow-sm rounded-4 mb-3 summary-card">
    <div class="card-body p-3 p-lg-4">
        <div class="row g-3 align-items-center">
            <div class="col-12 col-lg-8">
                <div class="d-flex gap-3 align-items-center flex-wrap flex-md-nowrap">
                    <div class="summary-avatar">
                        <img src="{{ $profileImage }}" alt="client-image">
                    </div>

                    <div class="summary-meta">
                        <h5 class="fw-bold mb-2">{{ $clientName }}</h5>

                        <div class="summary-badges d-flex flex-wrap gap-2">
                            <span class="badge rounded-pill text-bg-primary">อายุ {{ $clientAge }} ปี</span>
                            <span class="badge rounded-pill text-bg-success">{{ $schoolName }}</span>
                            <span class="badge rounded-pill text-bg-warning text-dark">{{ $educationName }}</span>
                            <span class="badge rounded-pill text-bg-info text-dark">{{ $semesterName }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="summary-stat text-lg-end">
                    <div class="small text-muted mb-1">จำนวนบันทึกการขาดเรียน</div>
                    <div class="display-6 fw-bold text-primary mb-0">{{ $absents->count() }}</div>
                </div>
            </div>
        </div>
    </div>
</div>