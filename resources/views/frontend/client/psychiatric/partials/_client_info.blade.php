<div class="card border-0 shadow-sm psychiatric-client-card mb-3">
    <div class="card-body py-3">
        <div class="row g-2 align-items-center">
            <div class="col-12 col-lg-8">
                <div class="psychiatric-client-info">
                    <div class="psychiatric-client-item">
                        <i class="bi bi-person-fill text-primary"></i>
                        <span class="label">ชื่อ-สกุล :</span>
                        <span class="value">{{ $client->fullname ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="psychiatric-client-info justify-content-lg-end">
                    <div class="psychiatric-client-item">
                        <i class="bi bi-calendar-heart text-success"></i>
                        <span class="label">อายุ :</span>
                        <span class="value">{{ $client->age ?? '-' }} ปี</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>