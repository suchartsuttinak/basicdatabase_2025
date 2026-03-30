 <div class="client-summary">
            <div class="summary-grid">
                <div class="summary-card name-card">
                    <div class="summary-icon">
                        <i class="bi bi-person-vcard"></i>
                    </div>
                    <div class="summary-content">
                        <span class="summary-label">ชื่อ-สกุล</span>
                        <span class="summary-value">{{ $client->fullname ?? $client->name ?? '-' }}</span>
                    </div>
                </div>

                <div class="summary-card age-card">
                    <div class="summary-icon">
                        <i class="bi bi-calendar2-heart"></i>
                    </div>
                    <div class="summary-content">
                        <span class="summary-label">อายุ</span>
                        <span class="summary-value">{{ $client->age ?? '-' }} ปี</span>
                    </div>
                </div>
            </div>
        </div>