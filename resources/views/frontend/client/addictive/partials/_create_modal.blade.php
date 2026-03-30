<div class="modal fade" id="createAddictiveModal" tabindex="-1" aria-labelledby="createAddictiveLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable modal-fullscreen-sm-down">
        <div class="modal-content addictive-modal">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="createAddictiveLabel">
                    <i class="bi bi-eyedropper me-2"></i>
                    เพิ่มข้อมูลการตรวจสารเสพติด
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form id="addictive-form" action="{{ route('addictive.store') }}" method="POST" novalidate>
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="client_id" value="{{ $client->id }}">

                    <div class="row g-3 mb-3">
                        <div class="col-12 col-md-4 col-lg-3">
                            <label class="form-label fw-semibold">วันที่ตรวจ <span class="text-danger">*</span></label>
                            <input type="date"
                                   name="date"
                                   class="form-control form-control-sm @error('date') is-invalid @enderror"
                                   value="{{ old('date', \Carbon\Carbon::now()->format('Y-m-d')) }}">
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-md-4 col-lg-3">
                            <label class="form-label fw-semibold">ครั้งที่</label>
                            <input type="number"
                                   name="count"
                                   class="form-control form-control-sm"
                                   value="{{ $addictives->count() + 1 }}"
                                   readonly>
                        </div>

                        <div class="col-12 col-lg-6">
                            <label class="form-label fw-semibold d-block">ผลการตรวจ <span class="text-danger">*</span></label>
                            <div class="radio-card-group">
                                <label class="radio-card">
                                    <input class="form-check-input @error('exam') is-invalid @enderror"
                                           type="radio"
                                           name="exam"
                                           value="0"
                                           id="exam_no_new"
                                           {{ old('exam', '0') == '0' ? 'checked' : '' }}>
                                    <span>ไม่พบสารเสพติด</span>
                                </label>

                                <label class="radio-card">
                                    <input class="form-check-input @error('exam') is-invalid @enderror"
                                           type="radio"
                                           name="exam"
                                           value="1"
                                           id="exam_yes_new"
                                           {{ old('exam') == '1' ? 'checked' : '' }}>
                                    <span>พบสารเสพติด</span>
                                </label>
                            </div>
                            @error('exam')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row g-3 mb-3" id="refer_field_new" style="display: {{ old('exam') == '1' ? 'flex' : 'none' }};">
                        <div class="col-12 col-lg-8">
                            <label class="form-label fw-semibold d-block">การส่งต่อ</label>
                            <div class="radio-card-group">
                                <label class="radio-card">
                                    <input class="form-check-input @error('refer') is-invalid @enderror"
                                           type="radio"
                                           name="refer"
                                           value="1"
                                           id="refer_treatment_new"
                                           {{ old('refer') == '1' ? 'checked' : '' }}>
                                    <span>ส่งต่อบำบัด</span>
                                </label>

                                <label class="radio-card">
                                    <input class="form-check-input @error('refer') is-invalid @enderror"
                                           type="radio"
                                           name="refer"
                                           value="2"
                                           id="refer_followup_new"
                                           {{ old('refer') == '2' ? 'checked' : '' }}>
                                    <span>ติดตามดูแลต่อเนื่อง</span>
                                </label>
                            </div>
                            @error('refer')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">บันทึกผล</label>
                        <textarea name="record"
                                  rows="3"
                                  class="form-control form-control-sm @error('record') is-invalid @enderror">{{ old('record') }}</textarea>
                        @error('record')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label class="form-label fw-semibold">ผู้ตรวจ <span class="text-danger">*</span></label>
                        <input type="text"
                               name="recorder"
                               class="form-control form-control-sm @error('recorder') is-invalid @enderror"
                               value="{{ old('recorder') }}">
                        @error('recorder')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="modal-footer addictive-modal-footer">
                    <button type="submit" class="btn btn-success addictive-btn-save">
                        <i class="bi bi-save me-1"></i>
                        บันทึกผล
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