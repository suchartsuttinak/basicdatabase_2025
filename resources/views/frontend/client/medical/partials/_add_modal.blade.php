<div class="modal fade" id="add-medical-modal" tabindex="-1" aria-labelledby="addMedicalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable modal-fullscreen-sm-down">
        <div class="modal-content medical-modal-content">
            <form action="{{ route('medical.store') }}" method="POST" id="add-medical-form" novalidate>
                @csrf
                <input type="hidden" name="client_id" value="{{ $client->id }}">

                <div class="modal-header medical-modal-header bg-primary text-white">
                    <div>
                        <h5 class="modal-title fw-bold mb-1" id="addMedicalLabel">
                            <i class="bi bi-hospital me-2"></i>เพิ่มข้อมูลการรักษาพยาบาล
                        </h5>
                        <div class="small opacity-75">กรอกข้อมูลให้ครบถ้วนเพื่อการติดตามผลที่ถูกต้อง</div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body p-3 p-md-4">
                    <div class="form-section">
                        <div class="section-title">ข้อมูลการรักษาเบื้องต้น</div>

                        <div class="row g-3">
                            <div class="col-12 col-md-4 col-lg-3">
                                <label class="form-label required">วันที่</label>
                                <input type="date" name="medical_date"
                                       class="form-control form-control-sm @error('medical_date') is-invalid @enderror"
                                       value="{{ old('medical_date') }}">
                                @error('medical_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12 col-md-8 col-lg-4">
                                <label class="form-label">ชื่อโรค</label>
                                <input type="text" name="disease_name"
                                       class="form-control form-control-sm @error('disease_name') is-invalid @enderror"
                                       value="{{ old('disease_name') }}"
                                       placeholder="ระบุชื่อโรค">
                                @error('disease_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12 col-lg-5">
                                <label class="form-label">อาการป่วย</label>
                                <textarea name="illness"
                                          class="form-control form-control-sm @error('illness') is-invalid @enderror"
                                          rows="2"
                                          placeholder="ระบุอาการป่วย">{{ old('illness') }}</textarea>
                                @error('illness') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">การรักษา / การปฐมพยาบาล</label>
                                <textarea name="treatment"
                                          class="form-control form-control-sm @error('treatment') is-invalid @enderror"
                                          rows="3"
                                          placeholder="ระบุการรักษา การปฐมพยาบาล หรือการดูแลเบื้องต้น">{{ old('treatment') }}</textarea>
                                @error('treatment') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <div class="section-title">การพบแพทย์</div>

                        <div class="medical-radio-group">
                            <label class="medical-radio-card">
                                <input class="form-check-input" type="radio" name="refer" id="refer_yes_new" value="พบแพทย์" {{ old('refer') == 'พบแพทย์' ? 'checked' : '' }}>
                                <span class="medical-radio-content">
                                    <span class="medical-radio-icon text-success"><i class="bi bi-check-circle-fill"></i></span>
                                    <span class="medical-radio-text">
                                        <strong>พบแพทย์</strong>
                                        <small>มีการตรวจ วินิจฉัย หรือรักษาโดยแพทย์</small>
                                    </span>
                                </span>
                            </label>

                            <label class="medical-radio-card">
                                <input class="form-check-input" type="radio" name="refer" id="refer_no_new" value="ไม่พบแพทย์" {{ old('refer', 'ไม่พบแพทย์') == 'ไม่พบแพทย์' ? 'checked' : '' }}>
                                <span class="medical-radio-content">
                                    <span class="medical-radio-icon text-secondary"><i class="bi bi-dash-circle-fill"></i></span>
                                    <span class="medical-radio-text">
                                        <strong>ไม่พบแพทย์</strong>
                                        <small>ดูแลเบื้องต้นโดยยังไม่มีการพบแพทย์</small>
                                    </span>
                                </span>
                            </label>
                        </div>

                        @error('refer') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror

                        <div id="medical-section-new" class="conditional-box mt-3" style="display:none;">
                            <div class="row g-3">
                                <div class="col-12 col-lg-8">
                                    <label class="form-label">การวินิจฉัย</label>
                                    <textarea name="diagnosis"
                                              class="form-control form-control-sm @error('diagnosis') is-invalid @enderror"
                                              rows="3">{{ old('diagnosis') }}</textarea>
                                    @error('diagnosis') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12 col-md-6 col-lg-4">
                                    <label class="form-label">วันที่แพทย์นัด</label>
                                    <input type="date" name="appt_date"
                                           class="form-control form-control-sm @error('appt_date') is-invalid @enderror"
                                           value="{{ old('appt_date') }}">
                                    @error('appt_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-section mb-0">
                        <div class="section-title">ข้อมูลเพิ่มเติม</div>

                        <div class="row g-3">
                            <div class="col-12 col-md-5">
                                <label class="form-label">ผู้ดูแล</label>
                                <input type="text" name="teacher"
                                       class="form-control form-control-sm @error('teacher') is-invalid @enderror"
                                       value="{{ old('teacher') }}">
                                @error('teacher') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12 col-md-7">
                                <label class="form-label">หมายเหตุ</label>
                                <textarea name="remark"
                                          class="form-control form-control-sm @error('remark') is-invalid @enderror"
                                          rows="3">{{ old('remark') }}</textarea>
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