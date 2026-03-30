<div class="modal fade" id="createAddictiveModal" tabindex="-1" aria-labelledby="createAddictiveLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable modal-fullscreen-sm-down">
        <div class="modal-content addictive-modal">
            <div class="modal-header addictive-modal-header">
                <div class="addictive-modal-title-wrap">
                    <div class="addictive-modal-icon">
                        <i class="bi bi-eyedropper"></i>
                    </div>
                    <div>
                        <h5 class="modal-title addictive-modal-title mb-0" id="createAddictiveLabel">
                            เพิ่มข้อมูลการตรวจสารเสพติด
                        </h5>
                        <div class="addictive-modal-subtitle">
                            บันทึกผลการตรวจและข้อมูลการติดตามอย่างเป็นระบบ
                        </div>
                    </div>
                </div>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="addictive-form" action="{{ route('addictive.store') }}" method="POST" novalidate>
                @csrf

                <div class="modal-body addictive-modal-body">
                    <input type="hidden" name="client_id" value="{{ $client->id }}">

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
                                       class="form-control form-control-modern @error('date') is-invalid @enderror"
                                       value="{{ old('date', \Carbon\Carbon::now()->format('Y-m-d')) }}">
                                @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-4 col-lg-3">
                                <label class="form-label form-label-modern">ครั้งที่</label>
                                <input type="number"
                                       name="count"
                                       class="form-control form-control-modern"
                                       value="{{ $addictives->count() + 1 }}"
                                       readonly>
                            </div>

                            <div class="col-12 col-lg-6">
                                <label class="form-label form-label-modern d-block">
                                    ผลการตรวจ <span class="text-danger">*</span>
                                </label>

                                <div class="radio-card-group">
                                    <label class="radio-card">
                                        <input class="@error('exam') is-invalid @enderror"
                                               type="radio"
                                               name="exam"
                                               value="0"
                                               id="exam_no_new"
                                               {{ old('exam', '0') == '0' ? 'checked' : '' }}>
                                        <span class="radio-card-content">
                                            <span class="radio-card-title">ไม่พบสารเสพติด</span>
                                            <span class="radio-card-desc">ผลการตรวจเป็นปกติ</span>
                                        </span>
                                    </label>

                                    <label class="radio-card">
                                        <input class="@error('exam') is-invalid @enderror"
                                               type="radio"
                                               name="exam"
                                               value="1"
                                               id="exam_yes_new"
                                               {{ old('exam') == '1' ? 'checked' : '' }}>
                                        <span class="radio-card-content">
                                            <span class="radio-card-title">พบสารเสพติด</span>
                                            <span class="radio-card-desc">ต้องระบุแนวทางดำเนินการต่อ</span>
                                        </span>
                                    </label>
                                </div>

                                @error('exam')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-section" id="refer_field_new" style="display: {{ old('exam') == '1' ? 'block' : 'none' }};">
                        <div class="form-section-title">
                            <i class="bi bi-arrow-left-right"></i>
                            การดำเนินการต่อ
                        </div>

                        <div class="row g-3">
                            <div class="col-12 col-lg-8">
                                <label class="form-label form-label-modern d-block">การส่งต่อ</label>

                                <div class="radio-card-group">
                                    <label class="radio-card">
                                        <input class="@error('refer') is-invalid @enderror"
                                               type="radio"
                                               name="refer"
                                               value="1"
                                               id="refer_treatment_new"
                                               {{ old('refer') == '1' ? 'checked' : '' }}>
                                        <span class="radio-card-content">
                                            <span class="radio-card-title">ส่งต่อบำบัด</span>
                                            <span class="radio-card-desc">ส่งต่อเข้ารับการบำบัดรักษา</span>
                                        </span>
                                    </label>

                                    <label class="radio-card">
                                        <input class="@error('refer') is-invalid @enderror"
                                               type="radio"
                                               name="refer"
                                               value="2"
                                               id="refer_followup_new"
                                               {{ old('refer') == '2' ? 'checked' : '' }}>
                                        <span class="radio-card-content">
                                            <span class="radio-card-title">ติดตามดูแลต่อเนื่อง</span>
                                            <span class="radio-card-desc">เฝ้าระวังและติดตามผลต่อเนื่อง</span>
                                        </span>
                                    </label>
                                </div>

                                @error('refer')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
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
                                          rows="4"
                                          class="form-control form-control-modern @error('record') is-invalid @enderror"
                                          placeholder="ระบุผลการตรวจ รายละเอียด หรือข้อสังเกตเพิ่มเติม">{{ old('record') }}</textarea>
                                @error('record')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-lg-6">
                                <label class="form-label form-label-modern">
                                    ผู้ตรวจ <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       name="recorder"
                                       class="form-control form-control-modern @error('recorder') is-invalid @enderror"
                                       value="{{ old('recorder') }}"
                                       placeholder="ชื่อผู้ตรวจ / ผู้บันทึกข้อมูล">
                                @error('recorder')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
                        บันทึกผล
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>