<div class="modal fade" id="edit-vaccine-modal" tabindex="-1" aria-labelledby="editVaccineLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable modal-fullscreen-sm-down">
        <div class="modal-content vaccine-modal-content">
            <form method="POST" id="edit-vaccine-form" action="" novalidate>
                @csrf
                @method('PUT')

                <input type="hidden" name="client_id" id="edit_client_id">

                <div class="modal-header vaccine-modal-header vaccine-modal-header--warning">
                    <div>
                        <h5 class="modal-title fw-bold mb-1" id="editVaccineLabel">
                            <i class="bi bi-pencil-square me-2"></i>แก้ไขข้อมูลวัคซีน
                        </h5>
                        <div class="small opacity-75">
                            ปรับปรุงข้อมูลให้ถูกต้องและเป็นปัจจุบัน
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="vaccine-form-body p-3 p-md-4">
                        <div class="vaccine-form-section">
                            <div class="vaccine-section-title">ข้อมูลการรับวัคซีน</div>

                            <div class="row g-3">
                                <div class="col-12 col-md-4">
                                    <label class="form-label required">วันที่รับวัคซีน</label>
                                    <input type="date" name="date" id="edit_date" class="form-control">
                                </div>

                                <div class="col-12 col-md-8">
                                    <label class="form-label required">ชนิดวัคซีน</label>
                                    <input type="text" name="vaccine_name" id="edit_vaccine_name" class="form-control" placeholder="ระบุชนิดวัคซีน">
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label">สถานพยาบาล</label>
                                    <input type="text" name="hospital" id="edit_hospital" class="form-control" placeholder="ระบุสถานพยาบาล">
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label">ผู้บันทึก</label>
                                    <input type="text" name="recorder" id="edit_recorder" class="form-control" placeholder="ระบุชื่อผู้บันทึก">
                                </div>

                                <div class="col-12">
                                    <label class="form-label">หมายเหตุ</label>
                                    <textarea name="remark" id="edit_remark" class="form-control" rows="4" placeholder="รายละเอียดเพิ่มเติม"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer vaccine-modal-footer">
                    <button type="submit" class="btn btn-success vaccine-btn vaccine-btn-success">
                        <i class="bi bi-save"></i>
                        <span>อัปเดตข้อมูล</span>
                    </button>
                    <button type="button" class="btn btn-outline-secondary vaccine-btn vaccine-btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i>
                        <span>ปิด</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
.vaccine-page #edit-vaccine-modal .vaccine-modal-content {
    border: 0;
    border-radius: var(--vaccine-radius);
    overflow: hidden;
}

.vaccine-page #edit-vaccine-modal .vaccine-modal-content > form {
    display: flex;
    flex-direction: column;
    height: 100%;
    min-height: 0;
}

.vaccine-page #edit-vaccine-modal .vaccine-modal-header {
    border-bottom: 0;
    padding: 1rem 1.25rem;
    flex: 0 0 auto;
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    color: #78350f;
}

.vaccine-page #edit-vaccine-modal .modal-body {
    flex: 1 1 auto;
    min-height: 0;
    overflow-y: auto;
    -webkit-overflow-scrolling: touch;
    background: #fffcf5;
}

.vaccine-page #edit-vaccine-modal .vaccine-form-section {
    background: #fff;
    border: 1px solid #f3ead7;
    border-radius: 16px;
    padding: 1rem;
}

.vaccine-page #edit-vaccine-modal .vaccine-section-title {
    font-size: .95rem;
    font-weight: 700;
    color: var(--vaccine-text);
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: .5rem;
}

.vaccine-page #edit-vaccine-modal .vaccine-section-title::before {
    content: "";
    width: 6px;
    height: 18px;
    border-radius: 999px;
    background: var(--vaccine-warning);
    display: inline-block;
}

.vaccine-page #edit-vaccine-modal .form-label {
    font-size: .86rem;
    font-weight: 600;
    color: #334155;
    margin-bottom: .45rem;
}

.vaccine-page #edit-vaccine-modal .form-label.required::after {
    content: " *";
    color: var(--vaccine-danger);
}

.vaccine-page #edit-vaccine-modal .form-control,
.vaccine-page #edit-vaccine-modal .form-select {
    border-radius: 12px;
    border: 1px solid #dbe2ea;
    min-height: 42px;
    padding: .6rem .85rem;
    font-size: .92rem;
}

.vaccine-page #edit-vaccine-modal textarea.form-control {
    min-height: 110px;
}

.vaccine-page #edit-vaccine-modal .form-control:focus,
.vaccine-page #edit-vaccine-modal .form-select:focus {
    border-color: #fcd34d;
    box-shadow: 0 0 0 .2rem rgba(245, 158, 11, .14);
}

.vaccine-page #edit-vaccine-modal .vaccine-modal-footer {
    flex: 0 0 auto;
    border-top: 1px solid var(--vaccine-border);
    background: #fff;
    padding: .9rem 1.25rem;
    display: flex;
    justify-content: flex-end;
    gap: .75rem;
    flex-wrap: wrap;
}

.vaccine-page #edit-vaccine-modal .vaccine-btn-success,
.vaccine-page #edit-vaccine-modal .vaccine-btn-secondary {
    min-width: 148px;
}

.vaccine-page #edit-vaccine-modal.modal .modal-dialog-scrollable .modal-content {
    max-height: calc(100vh - 2rem);
}

@media (max-width: 767.98px) {
    .vaccine-page #edit-vaccine-modal .vaccine-modal-footer {
        flex-direction: column-reverse;
    }

    .vaccine-page #edit-vaccine-modal .vaccine-modal-footer .vaccine-btn {
        width: 100%;
        min-width: 0;
    }
}

@media (max-width: 575.98px) {
    .vaccine-page #edit-vaccine-modal.modal.modal-fullscreen-sm-down .modal-content {
        height: 100vh;
        border-radius: 0;
    }

    .vaccine-page #edit-vaccine-modal.modal.modal-fullscreen-sm-down .vaccine-modal-content > form {
        height: 100vh;
    }

    .vaccine-page #edit-vaccine-modal.modal.modal-fullscreen-sm-down .modal-header {
        position: sticky;
        top: 0;
        z-index: 20;
    }

    .vaccine-page #edit-vaccine-modal.modal.modal-fullscreen-sm-down .modal-footer {
        position: sticky;
        bottom: 0;
        z-index: 20;
        background: #fff;
        border-top: 1px solid var(--vaccine-border);
        padding: .85rem 1rem;
    }
}
</style>
@endpush