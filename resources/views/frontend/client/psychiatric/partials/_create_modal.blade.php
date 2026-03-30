<div class="modal fade" id="createPsychiatricModal" tabindex="-1" aria-labelledby="createPsychiatricLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable modal-fullscreen-sm-down">
        <div class="modal-content psychiatric-modal">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="createPsychiatricLabel">
                    <i class="bi bi-clipboard-heart me-2"></i> เพิ่มข้อมูลการตรวจวินิจฉัยทางจิตเวช
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form id="psychiatric-form" action="{{ route('psychiatric.store') }}" method="POST" novalidate>
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="client_id" value="{{ $client->id }}">

                    <div class="row g-3 mb-3">
                        <div class="col-12 col-md-4 col-lg-3">
                            <label class="form-label fw-semibold">วันที่ส่งตรวจ <span class="text-danger">*</span></label>
                            <input type="date"
                                   name="sent_date"
                                   class="form-control form-control-sm @error('sent_date') is-invalid @enderror"
                                   value="{{ old('sent_date') }}">
                            @error('sent_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-md-8 col-lg-4">
                            <label class="form-label fw-semibold">สถานพยาบาล <span class="text-danger">*</span></label>
                            <input type="text"
                                   name="hotpital"
                                   class="form-control form-control-sm @error('hotpital') is-invalid @enderror"
                                   value="{{ old('hotpital') }}">
                            @error('hotpital')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-lg-5">
                            <label class="form-label fw-semibold">ผลการตรวจวินิจฉัย <span class="text-danger">*</span></label>
                            <select name="psycho_id" class="form-select form-select-sm @error('psycho_id') is-invalid @enderror">
                                <option value="">-- เลือกผลการตรวจ --</option>
                                @foreach($psycho as $p)
                                    <option value="{{ $p->id }}" {{ old('psycho_id') == $p->id ? 'selected' : '' }}>
                                        {{ $p->psycho_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('psycho_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">สรุปผลการตรวจ / การวินิจฉัย</label>
                        <textarea name="diagnose"
                                  rows="3"
                                  class="form-control form-control-sm @error('diagnose') is-invalid @enderror">{{ old('diagnose') }}</textarea>
                        @error('diagnose')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-12 col-md-4 col-lg-3">
                            <label class="form-label fw-semibold">นัดครั้งต่อไป</label>
                            <input type="date"
                                   name="appoin_date"
                                   class="form-control form-control-sm @error('appoin_date') is-invalid @enderror"
                                   value="{{ old('appoin_date') }}">
                            @error('appoin_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-md-8 col-lg-4">
                            <label class="form-label fw-semibold d-block">การรักษา</label>
                            <div class="radio-card-group">
                                <label class="radio-card">
                                    <input class="form-check-input @error('drug_no') is-invalid @enderror"
                                           type="radio"
                                           name="drug_no"
                                           value="yes"
                                           id="drug_yes_new"
                                           {{ old('drug_no') == 'yes' ? 'checked' : '' }}>
                                    <span>รับยา</span>
                                </label>

                                <label class="radio-card">
                                    <input class="form-check-input @error('drug_no') is-invalid @enderror"
                                           type="radio"
                                           name="drug_no"
                                           value="no"
                                           id="drug_no_new"
                                           {{ old('drug_no', 'no') == 'no' ? 'checked' : '' }}>
                                    <span>ไม่รับยา</span>
                                </label>
                            </div>
                            @error('drug_no')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-lg-5" id="drug_name_field_new" style="display: {{ old('drug_no') == 'yes' ? 'block' : 'none' }};">
                            <label class="form-label fw-semibold">ชื่อยา</label>
                            <input type="text"
                                   name="drug_name"
                                   class="form-control form-control-sm @error('drug_name') is-invalid @enderror"
                                   value="{{ old('drug_name') }}">
                            @error('drug_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-12 col-lg-6">
                            <label class="form-label fw-semibold d-block">การขึ้นทะเบียนคนพิการ</label>
                            <div class="radio-card-group">
                                <label class="radio-card">
                                    <input class="form-check-input @error('disa_no') is-invalid @enderror"
                                           type="radio"
                                           name="disa_no"
                                           value="yes"
                                           {{ old('disa_no') == 'yes' ? 'checked' : '' }}>
                                    <span>ขึ้นทะเบียน</span>
                                </label>

                                <label class="radio-card">
                                    <input class="form-check-input @error('disa_no') is-invalid @enderror"
                                           type="radio"
                                           name="disa_no"
                                           value="no"
                                           {{ old('disa_no', 'no') == 'no' ? 'checked' : '' }}>
                                    <span>ไม่ขึ้นทะเบียน</span>
                                </label>
                            </div>
                            @error('disa_no')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="modal-footer psychiatric-modal-footer">
                    <button type="submit" class="btn btn-success psychiatric-btn-save">
                        <i class="bi bi-save me-1"></i> บันทึกผล
                    </button>
                    <button type="button" class="btn btn-secondary psychiatric-btn-cancel" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i> ปิด
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>