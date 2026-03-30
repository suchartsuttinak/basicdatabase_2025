<div class="modal fade" id="editAddictiveModal" tabindex="-1" aria-labelledby="editAddictiveLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable modal-fullscreen-sm-down">
        <div class="modal-content addictive-modal">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title fw-bold" id="editAddictiveLabel">
                    <i class="bi bi-pencil-square me-2"></i>
                    แก้ไขข้อมูลการตรวจสารเสพติด
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="addictive-edit-form" method="POST" novalidate>
                @csrf
                @method('PUT')

                <div class="modal-body">
                    <input type="hidden" name="client_id" value="{{ $client->id }}">
                    <input type="hidden" name="id" id="edit_id">

                    <div class="row g-3 mb-3">
                        <div class="col-12 col-md-4 col-lg-3">
                            <label class="form-label fw-semibold">วันที่ตรวจ <span class="text-danger">*</span></label>
                            <input type="date" name="date" id="edit_date" class="form-control form-control-sm">
                        </div>

                        <div class="col-12 col-md-4 col-lg-3">
                            <label class="form-label fw-semibold">ครั้งที่</label>
                            <input type="number" name="count" id="edit_count" class="form-control form-control-sm" readonly>
                        </div>

                        <div class="col-12 col-lg-6">
                            <label class="form-label fw-semibold d-block">ผลการตรวจ <span class="text-danger">*</span></label>
                            <div class="radio-card-group">
                                <label class="radio-card">
                                    <input class="form-check-input" type="radio" name="exam" value="0" id="edit_exam_no">
                                    <span>ไม่พบสารเสพติด</span>
                                </label>

                                <label class="radio-card">
                                    <input class="form-check-input" type="radio" name="exam" value="1" id="edit_exam_yes">
                                    <span>พบสารเสพติด</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 mb-3" id="edit_refer_field" style="display:none;">
                        <div class="col-12 col-lg-8">
                            <label class="form-label fw-semibold d-block">การส่งต่อ</label>
                            <div class="radio-card-group">
                                <label class="radio-card">
                                    <input class="form-check-input" type="radio" name="refer" value="1" id="edit_refer_treatment">
                                    <span>ส่งต่อบำบัด</span>
                                </label>

                                <label class="radio-card">
                                    <input class="form-check-input" type="radio" name="refer" value="2" id="edit_refer_followup">
                                    <span>ติดตามดูแลต่อเนื่อง</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">บันทึกผล</label>
                        <textarea name="record" id="edit_record" rows="3" class="form-control form-control-sm"></textarea>
                    </div>

                    <div class="mb-2">
                        <label class="form-label fw-semibold">ผู้ตรวจ <span class="text-danger">*</span></label>
                        <input type="text" name="recorder" id="edit_recorder" class="form-control form-control-sm">
                    </div>
                </div>

                <div class="modal-footer addictive-modal-footer">
                    <button type="submit" class="btn btn-success addictive-btn-save">
                        <i class="bi bi-save me-1"></i>
                        อัปเดตข้อมูล
                    </button>
                    <button type="button" class="btn btn-secondary addictive-btn-cancel" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>
                        ปิด
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>