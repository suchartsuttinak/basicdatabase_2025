<div class="modal fade" id="add-vaccine-modal" tabindex="-1" aria-labelledby="addVaccineLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable modal-fullscreen-sm-down">
        <div class="modal-content vaccine-modal-content">
            <form action="{{ route('vaccine.store') }}" method="POST" id="add-vaccine-form" novalidate>
                @csrf
                <input type="hidden" name="client_id" value="{{ $client->id }}">

                <div class="modal-header vaccine-modal-header vaccine-modal-header--primary">
                    <div>
                        <h5 class="modal-title fw-bold mb-1" id="addVaccineLabel">
                            <i class="bi bi-capsule-pill me-2"></i>เพิ่มข้อมูลวัคซีน
                        </h5>
                        <div class="small opacity-75">
                            กรอกข้อมูลให้ครบถ้วนเพื่อใช้ติดตามประวัติการรับวัคซีน
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="vaccine-form-body p-3 p-md-4">
                        <div class="vaccine-form-section">
                            <div class="vaccine-section-title">ข้อมูลการรับวัคซีน</div>

                            <div class="row g-3">
                                <div class="col-12 col-md-4">
                                    <label class="form-label required">วันที่รับวัคซีน</label>
                                    <input type="date"
                                           name="date"
                                           class="form-control @error('date') is-invalid @enderror"
                                           value="{{ old('date') }}">
                                    @error('date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-8">
                                    <label class="form-label required">ชนิดวัคซีน</label>
                                    <input type="text"
                                           name="vaccine_name"
                                           class="form-control @error('vaccine_name') is-invalid @enderror"
                                           value="{{ old('vaccine_name') }}"
                                           placeholder="ระบุชนิดวัคซีน">
                                    @error('vaccine_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label">สถานพยาบาล</label>
                                    <input type="text"
                                           name="hospital"
                                           class="form-control @error('hospital') is-invalid @enderror"
                                           value="{{ old('hospital') }}"
                                           placeholder="ระบุสถานพยาบาล">
                                    @error('hospital')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label">ผู้บันทึก</label>
                                    <input type="text"
                                           name="recorder"
                                           class="form-control @error('recorder') is-invalid @enderror"
                                           value="{{ old('recorder') }}"
                                           placeholder="ระบุชื่อผู้บันทึก">
                                    @error('recorder')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label">หมายเหตุ</label>
                                    <textarea name="remark"
                                              class="form-control @error('remark') is-invalid @enderror"
                                              rows="4"
                                              placeholder="รายละเอียดเพิ่มเติม">{{ old('remark') }}</textarea>
                                    @error('remark')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer vaccine-modal-footer">
                    <button type="submit" class="btn btn-primary vaccine-btn vaccine-btn-primary">
                        <i class="bi bi-save"></i>
                        <span>บันทึกข้อมูล</span>
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
.vaccine-page #add-vaccine-modal .vaccine-modal-content {
    border: 0;
    border-radius: var(--vaccine-radius);
    overflow: hidden;
}

.vaccine-page #add-vaccine-modal .vaccine-modal-content > form {
    display: flex;
    flex-direction: column;
    height: 100%;
    min-height: 0;
}

.vaccine-page #add-vaccine-modal .vaccine-modal-header {
    border-bottom: 0;
    padding: 1rem 1.25rem;
    flex: 0 0 auto;
    background: linear-gradient(135deg, var(--vaccine-primary) 0%, var(--vaccine-primary-dark) 100%);
    color: #fff;
}

.vaccine-page #add-vaccine-modal .modal-body {
    flex: 1 1 auto;
    min-height: 0;
    overflow-y: auto;
    -webkit-overflow-scrolling: touch;
    background: #fbfdff;
}

.vaccine-page #add-vaccine-modal .vaccine-form-section {
    background: #fff;
    border: 1px solid var(--vaccine-border-soft);
    border-radius: 16px;
    padding: 1rem;
}

.vaccine-page #add-vaccine-modal .vaccine-section-title {
    font-size: .95rem;
    font-weight: 700;
    color: var(--vaccine-text);
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: .5rem;
}

.vaccine-page #add-vaccine-modal .vaccine-section-title::before {
    content: "";
    width: 6px;
    height: 18px;
    border-radius: 999px;
    background: var(--vaccine-primary);
    display: inline-block;
}

.vaccine-page #add-vaccine-modal .form-label {
    font-size: .86rem;
    font-weight: 600;
    color: #334155;
    margin-bottom: .45rem;
}

.vaccine-page #add-vaccine-modal .form-label.required::after {
    content: " *";
    color: var(--vaccine-danger);
}

.vaccine-page #add-vaccine-modal .form-control,
.vaccine-page #add-vaccine-modal .form-select {
    border-radius: 12px;
    border: 1px solid #dbe2ea;
    min-height: 42px;
    padding: .6rem .85rem;
    font-size: .92rem;
}

.vaccine-page #add-vaccine-modal textarea.form-control {
    min-height: 110px;
}

.vaccine-page #add-vaccine-modal .form-control:focus,
.vaccine-page #add-vaccine-modal .form-select:focus {
    border-color: #93c5fd;
    box-shadow: 0 0 0 .2rem rgba(37, 99, 235, .12);
}

.vaccine-page #add-vaccine-modal .invalid-feedback {
    font-size: .8rem;
}

.vaccine-page #add-vaccine-modal .vaccine-modal-footer {
    flex: 0 0 auto;
    border-top: 1px solid var(--vaccine-border);
    background: #fff;
    padding: .9rem 1.25rem;
    display: flex;
    justify-content: flex-end;
    gap: .75rem;
    flex-wrap: wrap;
}

.vaccine-page #add-vaccine-modal .vaccine-btn-secondary {
    min-width: 120px;
}

.vaccine-page #add-vaccine-modal.modal .modal-dialog-scrollable .modal-content {
    max-height: calc(100vh - 2rem);
}

@media (max-width: 767.98px) {
    .vaccine-page #add-vaccine-modal .vaccine-modal-footer {
        flex-direction: column-reverse;
    }

    .vaccine-page #add-vaccine-modal .vaccine-modal-footer .vaccine-btn {
        width: 100%;
        min-width: 0;
    }
}

@media (max-width: 575.98px) {
    .vaccine-page #add-vaccine-modal.modal.modal-fullscreen-sm-down .modal-content {
        height: 100vh;
        border-radius: 0;
    }

    .vaccine-page #add-vaccine-modal.modal.modal-fullscreen-sm-down .vaccine-modal-content > form {
        height: 100vh;
    }

    .vaccine-page #add-vaccine-modal.modal.modal-fullscreen-sm-down .modal-header {
        position: sticky;
        top: 0;
        z-index: 20;
    }

    .vaccine-page #add-vaccine-modal.modal.modal-fullscreen-sm-down .modal-footer {
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