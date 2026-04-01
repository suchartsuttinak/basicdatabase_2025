<div class="escape-info-card">
            <div class="escape-info-card__body">
                <div class="row g-3 align-items-center">
                    <div class="col-12 col-lg-8">
                        <div class="escape-client-info">
                            <div class="escape-client-info__item">
                                <span class="escape-client-info__icon">
                                    <i class="bi bi-person-circle"></i>
                                </span>
                                <div>
                                    <div class="escape-client-info__label">ชื่อ-สกุล</div>
                                    <div class="escape-client-info__value">{{ $client->fullname ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-4">
                        <div class="escape-client-info escape-client-info--compact">
                            <div class="escape-client-info__item">
                                <span class="escape-client-info__icon escape-client-info__icon--success">
                                    <i class="bi bi-calendar-heart"></i>
                                </span>
                                <div>
                                    <div class="escape-client-info__label">อายุ</div>
                                    <div class="escape-client-info__value">{{ $client->age ?? '-' }} ปี</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
