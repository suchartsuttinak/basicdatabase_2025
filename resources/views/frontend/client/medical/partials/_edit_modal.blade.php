<div class="modal fade" id="editMedicalModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable modal-fullscreen-sm-down">
        <div class="modal-content medical-modal-content">
            <form id="editMedicalForm" method="POST" action="{{ route('medical.update', 0) }}" novalidate>
                @csrf
                @method('PUT')

                <input type="hidden" name="client_id" id="edit_client_id">
                <input type="hidden" name="id" id="edit_medical_id">

                <div class="modal-header medical-modal-header bg-warning text-dark">
                    <div>
                        <h5 class="modal-title fw-bold mb-1">
                            <i class="bi bi-pencil-square me-2"></i>แก้ไขข้อมูลการรักษาพยาบาล
                        </h5>
                        <div class="small text-dark opacity-75">ปรับปรุงข้อมูลให้เป็นปัจจุบันและถูกต้อง</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body p-3 p-md-4">
                    <div class="form-section">
                        <div class="section-title">ข้อมูลการรักษาเบื้องต้น</div>

                        <div class="row g-3">
                            <div class="col-12 col-md-4 col-lg-3">
                                <label class="form-label required">วันที่</label>
                                <input type="date" name="medical_date" id="edit_medical_date" class="form-control form-control-sm" required>
                            </div>

                            <div class="col-12 col-md-8 col-lg-4">
                                <label class="form-label">ชื่อโรค</label>
                                <input type="text" name="disease_name" id="edit_disease_name" class="form-control form-control-sm">
                            </div>

                            <div class="col-12 col-lg-5">
                                <label class="form-label">อาการป่วย</label>
                                <textarea name="illness" id="edit_illness" class="form-control form-control-sm" rows="2"></textarea>
                            </div>

                            <div class="col-12">
                                <label class="form-label">การรักษา / การปฐมพยาบาล</label>
                                <textarea name="treatment" id="edit_treatment" class="form-control form-control-sm" rows="3"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <div class="section-title">การพบแพทย์</div>

                        <div class="medical-radio-group">
                            <label class="medical-radio-card">
                                <input type="radio" name="refer" id="edit_refer_yes" value="พบแพทย์">
                                <span class="medical-radio-content">
                                    <span class="medical-radio-icon text-success"><i class="bi bi-check-circle-fill"></i></span>
                                    <span class="medical-radio-text">
                                        <strong>พบแพทย์</strong>
                                        <small>มีการตรวจ วินิจฉัย หรือรักษาโดยแพทย์</small>
                                    </span>
                                </span>
                            </label>

                            <label class="medical-radio-card">
                                <input type="radio" name="refer" id="edit_refer_no" value="ไม่พบแพทย์">
                                <span class="medical-radio-content">
                                    <span class="medical-radio-icon text-secondary"><i class="bi bi-dash-circle-fill"></i></span>
                                    <span class="medical-radio-text">
                                        <strong>ไม่พบแพทย์</strong>
                                        <small>ดูแลเบื้องต้นโดยยังไม่มีการพบแพทย์</small>
                                    </span>
                                </span>
                            </label>
                        </div>

                        <div id="edit_medical_section" class="conditional-box mt-3" style="display:none;">
                            <div class="row g-3">
                                <div class="col-12 col-lg-8">
                                    <label class="form-label">การวินิจฉัย</label>
                                    <textarea name="diagnosis" id="edit_diagnosis" class="form-control form-control-sm" rows="3"></textarea>
                                </div>

                                <div class="col-12 col-md-6 col-lg-4">
                                    <label class="form-label">วันที่แพทย์นัด</label>
                                    <input type="date" name="appt_date" id="edit_appt_date" class="form-control form-control-sm">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-section mb-0">
                        <div class="section-title">ข้อมูลเพิ่มเติม</div>

                        <div class="row g-3">
                            <div class="col-12 col-md-5">
                                <label class="form-label">ผู้ดูแล</label>
                                <input type="text" name="teacher" id="edit_teacher" class="form-control form-control-sm">
                            </div>

                            <div class="col-12 col-md-7">
                                <label class="form-label">หมายเหตุ</label>
                                <textarea name="remark" id="edit_remark" class="form-control form-control-sm" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light border-0">
                    <button type="submit" class="btn btn-success btn-sm px-3">
                        <i class="bi bi-save me-1"></i> อัปเดตข้อมูล
                    </button>
                    <button type="button" class="btn btn-outline-secondary btn-sm px-3" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i> ปิด
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>