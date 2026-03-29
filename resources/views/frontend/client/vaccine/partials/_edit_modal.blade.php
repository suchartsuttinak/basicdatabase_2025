<div class="modal fade" id="edit-vaccine-modal" tabindex="-1" aria-labelledby="editVaccineLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable modal-fullscreen-sm-down">
        <div class="modal-content vaccine-modal-content">
            <form method="POST" id="edit-vaccine-form" action="" novalidate>
                @csrf
                @method('PUT')

                <input type="hidden" name="client_id" id="edit_client_id">

                <div class="modal-header vaccine-modal-header bg-warning text-dark">
                    <div>
                        <h5 class="modal-title fw-bold mb-1" id="editVaccineLabel">
                            <i class="bi bi-pencil-square me-2"></i>แก้ไขข้อมูลวัคซีน
                        </h5>
                        <div class="small opacity-75">ปรับปรุงข้อมูลให้ถูกต้องและเป็นปัจจุบัน</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body p-3 p-md-4">
                    <div class="form-section">
                        <div class="section-title">ข้อมูลการรับวัคซีน</div>

                        <div class="row g-3">
                            <div class="col-12 col-md-4">
                                <label class="form-label required">วันที่รับวัคซีน</label>
                                <input type="date" name="date" id="edit_date" class="form-control form-control-sm">
                            </div>

                            <div class="col-12 col-md-8">
                                <label class="form-label required">ชนิดวัคซีน</label>
                                <input type="text" name="vaccine_name" id="edit_vaccine_name" class="form-control form-control-sm">
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label">สถานพยาบาล</label>
                                <input type="text" name="hospital" id="edit_hospital" class="form-control form-control-sm">
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label">ผู้บันทึก</label>
                                <input type="text" name="recorder" id="edit_recorder" class="form-control form-control-sm">
                            </div>

                            <div class="col-12">
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