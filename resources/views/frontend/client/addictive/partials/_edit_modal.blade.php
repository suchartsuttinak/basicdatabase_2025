<div class="modal fade" id="editAddictiveModal" tabindex="-1" aria-labelledby="editAddictiveLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable modal-fullscreen-sm-down">
        <div class="modal-content addictive-modal">
            <div class="modal-header addictive-modal-header">
                <div class="addictive-modal-title-wrap">
                    <div class="addictive-modal-icon">
                        <i class="bi bi-pencil-square"></i>
                    </div>
                    <div>
                        <h5 class="modal-title addictive-modal-title mb-0" id="editAddictiveLabel">
                            แก้ไขข้อมูลการตรวจสารเสพติด
                        </h5>
                        <div class="addictive-modal-subtitle">
                            ปรับปรุงข้อมูลผลการตรวจและการดำเนินการต่ออย่างเป็นระบบ
                        </div>
                    </div>
                </div>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="addictive-edit-form" method="POST" novalidate>
                @csrf
                @method('PUT')

                <div class="modal-body addictive-modal-body">
                    <input type="hidden" name="client_id" value="{{ $client->id }}">
                    <input type="hidden" name="id" id="edit_id">

                    <div class="form-section">
                        <div class="form-section-title">
                            <i class="bi bi-clipboard2-pulse"></i>
                            ข้อมูลการตรวจ
                        </div>

                        <div class="row g-3">
                            <div class="col-12 col-md-4 col-lg-3">
                                <label class="form-label form-label-modern">
                                    วันที่ตรวจ <span class="text-danger">*</span>
                                </label>
                                <input type="date"
                                       name="date"
                                       id="edit_date"
                                       class="form-control form-control-modern">
                            </div>

                            <div class="col-12 col-md-4 col-lg-3">
                                <label class="form-label form-label-modern">ครั้งที่</label>
                                <input type="number"
                                       name="count"
                                       id="edit_count"
                                       class="form-control form-control-modern"
                                       readonly>
                            </div>

                            <div class="col-12 col-lg-6">
                                <label class="form-label form-label-modern d-block">
                                    ผลการตรวจ <span class="text-danger">*</span>
                                </label>

                                <div class="radio-card-group">
                                    <label class="radio-card">
                                        <input class="form-check-input"
                                               type="radio"
                                               name="exam"
                                               value="0"
                                               id="edit_exam_no">
                                        <span class="radio-card-content">
                                            <span class="radio-card-title">ไม่พบสารเสพติด</span>
                                            <span class="radio-card-desc">ผลการตรวจเป็นปกติ</span>
                                        </span>
                                    </label>

                                    <label class="radio-card">
                                        <input class="form-check-input"
                                               type="radio"
                                               name="exam"
                                               value="1"
                                               id="edit_exam_yes">
                                        <span class="radio-card-content">
                                            <span class="radio-card-title">พบสารเสพติด</span>
                                            <span class="radio-card-desc">ต้องระบุแนวทางดำเนินการต่อ</span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-section" id="edit_refer_field" style="display:none;">
                        <div class="form-section-title">
                            <i class="bi bi-arrow-left-right"></i>
                            การดำเนินการต่อ
                        </div>

                        <div class="row g-3">
                            <div class="col-12 col-lg-8">
                                <label class="form-label form-label-modern d-block">การส่งต่อ</label>

                                <div class="radio-card-group">
                                    <label class="radio-card">
                                        <input class="form-check-input"
                                               type="radio"
                                               name="refer"
                                               value="1"
                                               id="edit_refer_treatment">
                                        <span class="radio-card-content">
                                            <span class="radio-card-title">ส่งต่อบำบัด</span>
                                            <span class="radio-card-desc">ส่งต่อเข้ารับการบำบัดรักษา</span>
                                        </span>
                                    </label>

                                    <label class="radio-card">
                                        <input class="form-check-input"
                                               type="radio"
                                               name="refer"
                                               value="2"
                                               id="edit_refer_followup">
                                        <span class="radio-card-content">
                                            <span class="radio-card-title">ติดตามดูแลต่อเนื่อง</span>
                                            <span class="radio-card-desc">เฝ้าระวังและติดตามผลต่อเนื่อง</span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <div class="form-section-title">
                            <i class="bi bi-journal-text"></i>
                            รายละเอียดเพิ่มเติม
                        </div>

                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label form-label-modern">บันทึกผล</label>
                                <textarea name="record"
                                          id="edit_record"
                                          rows="4"
                                          class="form-control form-control-modern"
                                          placeholder="ระบุผลการตรวจ รายละเอียด หรือข้อสังเกตเพิ่มเติม"></textarea>
                            </div>

                            <div class="col-12 col-lg-6">
                                <label class="form-label form-label-modern">
                                    ผู้ตรวจ <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       name="recorder"
                                       id="edit_recorder"
                                       class="form-control form-control-modern"
                                       placeholder="ชื่อผู้ตรวจ / ผู้บันทึกข้อมูล">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer addictive-modal-footer">
                    <button type="button" class="btn btn-cancel-modern" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i>
                        ปิด
                    </button>

                    <button type="submit" class="btn btn-save-modern">
                        <i class="bi bi-save"></i>
                        อัปเดตข้อมูล
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>