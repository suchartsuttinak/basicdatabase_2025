            <div class="co-info-card">
                <div class="co-info-grid">
                    <div class="co-info-item">
                        <span class="co-info-item-icon">
                            <i class="bi bi-person-fill"></i>
                        </span>
                        <div>
                            <span class="co-info-item-label">ชื่อ-สกุล</span>
                            <div class="co-info-item-value">{{ $client->fullname ?? '-' }}</div>
                        </div>
                    </div>

                    <div class="co-info-item">
                        <span class="co-info-item-icon">
                            <i class="bi bi-calendar-heart"></i>
                        </span>
                        <div>
                            <span class="co-info-item-label">อายุ</span>
                            <div class="co-info-item-value">{{ $client->age ?? '-' }} ปี</div>
                        </div>
                    </div>
                </div>
            </div>