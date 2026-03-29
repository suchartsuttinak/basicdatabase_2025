<div class="modal fade" id="add-vaccine-modal" tabindex="-1" aria-labelledby="addVaccineLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable modal-fullscreen-sm-down">
        <div class="modal-content vaccine-modal-content">
            <form action="{{ route('vaccine.store') }}" method="POST" id="add-vaccine-form" novalidate>
                @csrf
                <input type="hidden" name="client_id" value="{{ $client->id }}">

                <div class="modal-header vaccine-modal-header bg-primary text-white">
                    <div>
                        <h5 class="modal-title fw-bold mb-1" id="addVaccineLabel">
                            <i class="bi bi-capsule-pill me-2"></i>เพิ่มข้อมูลวัคซีน
                        </h5>
                        <div class="small opacity-75">กรอกข้อมูลให้ครบถ้วนเพื่อใช้ติดตามประวัติการรับวัคซีน</div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body p-3 p-md-4">
                    <div class="form-section">
                        <div class="section-title">ข้อมูลการรับวัคซีน</div>

                        <div class="row g-3">
                            <div class="col-12 col-md-4">
                                <label class="form-label required">วันที่รับวัคซีน</label>
                                <input type="date" name="date"
                                       class="form-control form-control-sm @error('date') is-invalid @enderror"
                                       value="{{ old('date') }}">
                                @error('date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12 col-md-8">
                                <label class="form-label required">ชนิดวัคซีน</label>
                                <input type="text" name="vaccine_name"
                                       class="form-control form-control-sm @error('vaccine_name') is-invalid @enderror"
                                       value="{{ old('vaccine_name') }}"
                                       placeholder="ระบุชนิดวัคซีน">
                                @error('vaccine_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label">สถานพยาบาล</label>
                                <input type="text" name="hospital"
                                       class="form-control form-control-sm @error('hospital') is-invalid @enderror"
                                       value="{{ old('hospital') }}"
                                       placeholder="ระบุสถานพยาบาล">
                                @error('hospital') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label">ผู้บันทึก</label>
                                <input type="text" name="recorder"
                                       class="form-control form-control-sm @error('recorder') is-invalid @enderror"
                                       value="{{ old('recorder') }}"
                                       placeholder="ระบุชื่อผู้บันทึก">
                                @error('recorder') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">หมายเหตุ</label>
                                <textarea name="remark"
                                          class="form-control form-control-sm @error('remark') is-invalid @enderror"
                                          rows="3"
                                          placeholder="รายละเอียดเพิ่มเติม">{{ old('remark') }}</textarea>
                                @error('remark') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light border-0">
                    <button type="submit" class="btn btn-primary btn-sm px-3">
                        <i class="bi bi-save me-1"></i> บันทึกข้อมูล
                    </button>
                    <button type="button" class="btn btn-outline-secondary btn-sm px-3" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i> ปิด
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>