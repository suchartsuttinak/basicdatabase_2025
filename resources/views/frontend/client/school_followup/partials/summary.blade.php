<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4 client-summary-card">
    <div class="card-body p-0">
        <div class="row g-0 align-items-stretch">
            <div class="col-xl-3 summary-side">
                <div class="summary-side-inner">
                    <div class="summary-avatar-image-wrap">
                        <img src="{{ $profileImage }}" alt="รูปผู้รับบริการ" class="summary-avatar-image">
                    </div>
                    <h4 class="summary-name">{{ $clientName }}</h4>
                    <div class="summary-caption">ข้อมูลผู้รับบริการสำหรับติดตามผลการเรียน</div>
                </div>
            </div>

            <div class="col-xl-9">
                <div class="p-4 p-lg-4">
                    <div class="summary-section-title mb-3">
                        <i class="bi bi-person-vcard me-2 text-primary"></i>ข้อมูลพื้นฐาน
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6 col-xl-3">
                            <div class="info-box">
                                <div class="info-label">ชื่อ - สกุล</div>
                                <div class="info-value">{{ $clientName }}</div>
                            </div>
                        </div>

                        <div class="col-md-6 col-xl-3">
                            <div class="info-box">
                                <div class="info-label">อายุ</div>
                                <div class="info-value">{{ $clientAge }} ปี</div>
                            </div>
                        </div>

                        <div class="col-md-6 col-xl-3">
                            <div class="info-box">
                                <div class="info-label">สถานศึกษา</div>
                                <div class="info-value">{{ $schoolName }}</div>
                            </div>
                        </div>

                        <div class="col-md-6 col-xl-3">
                            <div class="info-box">
                                <div class="info-label">ระดับชั้น</div>
                                <div class="info-value">{{ $educationName }}</div>
                            </div>
                        </div>

                        <div class="col-md-6 col-xl-3">
                            <div class="info-box">
                                <div class="info-label">ภาคเรียน</div>
                                <div class="info-value">{{ $semesterName }}</div>
                            </div>
                        </div>

                        <div class="col-md-6 col-xl-3">
                            <div class="info-box">
                                <div class="info-label">จำนวนรายการติดตาม</div>
                                <div class="info-value">{{ $followups->count() }}</div>
                            </div>
                        </div>

                        <div class="col-md-6 col-xl-3">
                            <div class="info-box">
                                <div class="info-label">วันที่เข้าดูข้อมูล</div>
                                <div class="info-value">{{ now()->locale('th')->translatedFormat('d F') }} {{ now()->year + 543 }}</div>
                            </div>
                        </div>

                        <div class="col-md-6 col-xl-3">
                            <div class="info-box">
                                <div class="info-label">สถานะข้อมูล</div>
                                <div class="info-value text-success">พร้อมใช้งาน</div>
                            </div>
                        </div>
                    </div>

                    <div class="summary-note mt-3">
                        <i class="bi bi-info-circle me-2"></i>
                        หน้านี้ใช้สำหรับบันทึกและติดตามผลการเรียนของผู้รับบริการ พร้อมรองรับการแก้ไขและออกรายงานภายหลัง
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>