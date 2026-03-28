<div class="modal fade" id="editAbsentModal" tabindex="-1" aria-labelledby="editAbsentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-fullscreen-sm-down absent-mobile-dialog">
        <div class="modal-content border-0 shadow-lg custom-modal absent-mobile-content">
            <div class="modal-header modal-header-warning">
                <div>
                    <h5 class="modal-title fw-bold mb-1" id="editAbsentModalLabel">
                        <i class="bi bi-pencil-square me-2"></i>แก้ไขข้อมูลการขาดเรียน
                    </h5>
                    <div class="modal-subtitle">
                        ตรวจสอบและปรับปรุงข้อมูลให้ถูกต้องก่อนบันทึกการเปลี่ยนแปลง
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="edit-absent-form" method="POST">
                @csrf
                @method('PUT')

                <input type="hidden" name="client_id" value="{{ $client->id }}">
                <input type="hidden" name="education_record_id" id="edit_education_record_id" value="">

                <div class="modal-body p-4">
                    <div class="row g-4">
                        <div class="col-lg-4">
                            <div class="form-side-card h-100">
                                <div class="form-side-header">
                                    <i class="bi bi-person-lines-fill me-2"></i>ข้อมูลเด็ก
                                </div>
                                <div class="form-side-body">
                                    <div class="side-info-item">
                                        <span class="side-info-label">ชื่อ - นามสกุล</span>
                                        <span class="side-info-value">{{ $clientName }}</span>
                                    </div>
                                    <div class="side-info-item">
                                        <span class="side-info-label">อายุ</span>
                                        <span class="side-info-value">{{ $clientAge }} ปี</span>
                                    </div>
                                    <div class="side-info-item">
                                        <span class="side-info-label">สถานศึกษา</span>
                                        <span class="side-info-value" id="edit_school_name">-</span>
                                    </div>
                                    <div class="side-info-item">
                                        <span class="side-info-label">ระดับชั้น</span>
                                        <span class="side-info-value" id="edit_education_name">-</span>
                                    </div>
                                    <div class="side-info-item">
                                        <span class="side-info-label">ภาคเรียน</span>
                                        <span class="side-info-value" id="edit_semester_name">-</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-8">
                            <div class="form-main-card h-100">
                                <div class="form-side-header">
                                    <i class="bi bi-pencil-square me-2"></i>ข้อมูลสำหรับแก้ไข
                                </div>

                                <div class="form-side-body">
                                    @include('frontend.client.absent.partials.form-fields', [
                                        'prefix' => 'edit_',
                                        'absentDate' => '',
                                        'recordDate' => '',
                                        'cause' => '',
                                        'operation' => '',
                                        'remark' => '',
                                        'teacher' => '',
                                    ])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer px-4 py-3 border-0">
                    <button type="button" class="btn btn-light btn-cancel" data-bs-dismiss="modal" id="btn-cancel-edit-absent">
                        <i class="bi bi-x-circle me-2"></i>ยกเลิก
                    </button>
                    <button type="submit" class="btn btn-success btn-save">
                        <i class="bi bi-check-circle-fill me-2"></i>อัปเดตข้อมูล
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>