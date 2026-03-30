<div class="modal fade" id="editPsychiatricModal" tabindex="-1" aria-labelledby="editPsychiatricLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable modal-fullscreen-sm-down">
        <div class="modal-content psychiatric-modal">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title fw-bold" id="editPsychiatricLabel">
                    <i class="bi bi-pencil-square me-2"></i> แก้ไขข้อมูลการตรวจวินิจฉัยทางจิตเวช
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="psychiatric-edit-form" method="POST" novalidate>
                @csrf
                @method('PUT')

                <div class="modal-body">
                    <input type="hidden" name="client_id" value="{{ $client->id }}">
                    <input type="hidden" name="id" id="edit_id">

                    <div class="row g-3 mb-3">
                        <div class="col-12 col-md-4 col-lg-3">
                            <label class="form-label fw-semibold">วันที่ส่งตรวจ <span class="text-danger">*</span></label>
                            <input type="date" name="sent_date" id="edit_sent_date" class="form-control form-control-sm">
                        </div>

                        <div class="col-12 col-md-8 col-lg-4">
                            <label class="form-label fw-semibold">สถานพยาบาล <span class="text-danger">*</span></label>
                            <input type="text" name="hotpital" id="edit_hotpital" class="form-control form-control-sm">
                        </div>

                        <div class="col-12 col-lg-5">
                            <label class="form-label fw-semibold">ผลการตรวจวินิจฉัย <span class="text-danger">*</span></label>
                            <select name="psycho_id" id="edit_psycho_id" class="form-select form-select-sm">
                                <option value="">-- เลือกผลการตรวจ --</option>
                                @foreach($psycho as $p)
                                    <option value="{{ $p->id }}">{{ $p->psycho_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">สรุปผลการตรวจ / การวินิจฉัย</label>
                        <textarea name="diagnose" id="edit_diagnose" rows="3" class="form-control form-control-sm"></textarea>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-12 col-md-4 col-lg-3">
                            <label class="form-label fw-semibold">นัดครั้งต่อไป</label>
                            <input type="date" name="appoin_date" id="edit_appoin_date" class="form-control form-control-sm">
                        </div>

                        <div class="col-12 col-md-8 col-lg-4">
                            <label class="form-label fw-semibold d-block">การรักษา</label>
                            <div class="radio-card-group">
                                <label class="radio-card">
                                    <input class="form-check-input" type="radio" name="drug_no" value="yes" id="edit_drug_yes">
                                    <span>รับยา</span>
                                </label>

                                <label class="radio-card">
                                    <input class="form-check-input" type="radio" name="drug_no" value="no" id="edit_drug_no">
                                    <span>ไม่รับยา</span>
                                </label>
                            </div>
                        </div>

                        <div class="col-12 col-lg-5" id="edit_drug_name_field" style="display:none;">
                            <label class="form-label fw-semibold">ชื่อยา</label>
                            <input type="text" name="drug_name" id="edit_drug_name" class="form-control form-control-sm">
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-12 col-lg-6">
                            <label class="form-label fw-semibold d-block">การขึ้นทะเบียนคนพิการ</label>
                            <div class="radio-card-group">
                                <label class="radio-card">
                                    <input class="form-check-input" type="radio" name="disa_no" value="yes" id="edit_disa_yes">
                                    <span>ขึ้นทะเบียน</span>
                                </label>

                                <label class="radio-card">
                                    <input class="form-check-input" type="radio" name="disa_no" value="no" id="edit_disa_no">
                                    <span>ไม่ขึ้นทะเบียน</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer psychiatric-modal-footer">
                    <button type="submit" class="btn btn-success psychiatric-btn-save">
                        <i class="bi bi-save me-1"></i> อัปเดตข้อมูล
                    </button>
                    <button type="button" class="btn btn-secondary psychiatric-btn-cancel" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i> ปิด
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>