  <div class="modal fade ja-modal"
         id="createJobAgencyModal"
         tabindex="-1"
         aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable modal-fullscreen-sm-down">
            <div class="modal-content">
                <form id="createJobAgencyForm"
                      action="{{ route('job_agencies.store') }}"
                      method="POST"
                      class="ja-modal-form jobagency-validate-form"
                      novalidate>
                    @csrf
                    <input type="hidden" name="client_id" value="{{ $client->id }}">

                    <div class="modal-header">
                        <h5 class="modal-title ja-modal-title">
                            <i class="bi bi-plus-circle"></i>
                            <span>เพิ่มข้อมูลการจัดหางาน</span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="ja-modal-body">
                        <div class="ja-section">
                            <div class="ja-section-title">
                                <i class="bi bi-ui-checks-grid"></i>
                                <span>ข้อมูลการทำงาน</span>
                            </div>

                            <div class="row g-3">
                                <div class="col-12 col-md-4">
                                    <label class="ja-label">วันที่เริ่มงาน <span class="text-danger">*</span></label>
                                    <input type="date"
                                           name="job_date"
                                           value="{{ old('job_date') }}"
                                           class="form-control ja-control"
                                           required>
                                </div>

                                <div class="col-12 col-md-8">
                                    <label class="ja-label">อาชีพ <span class="text-danger">*</span></label>
                                    <select name="occupation_id" class="form-select ja-select" required>
                                        <option value="">-- เลือกอาชีพ --</option>
                                        @foreach($occupations as $occ)
                                            <option value="{{ $occ->id }}" {{ old('occupation_id') == $occ->id ? 'selected' : '' }}>
                                                {{ $occ->occupation_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="ja-label">ตำแหน่ง <span class="text-danger">*</span></label>
                                    <input type="text"
                                           name="position"
                                           value="{{ old('position') }}"
                                           class="form-control ja-control"
                                           required>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="ja-label">รายได้ (บาท/เดือน) <span class="text-danger">*</span></label>
                                    <input type="number"
                                           name="income"
                                           value="{{ old('income') }}"
                                           class="form-control ja-control"
                                           min="0"
                                           step="0.01"
                                           required>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="ja-label">บริษัท/หน่วยงาน <span class="text-danger">*</span></label>
                                    <input type="text"
                                           name="company"
                                           value="{{ old('company') }}"
                                           class="form-control ja-control"
                                           required>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="ja-label">ผู้ประสานงาน <span class="text-danger">*</span></label>
                                    <input type="text"
                                           name="coordinator"
                                           value="{{ old('coordinator') }}"
                                           class="form-control ja-control"
                                           required>
                                </div>

                                <div class="col-12">
                                    <label class="ja-label">หมายเหตุ</label>
                                    <textarea name="remark"
                                              class="form-control ja-textarea"
                                              rows="3">{{ old('remark') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ja-modal-footer">
                        <button type="button" class="btn btn-outline-secondary ja-btn" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle"></i>
                            <span>ปิด</span>
                        </button>
                        <button type="submit" class="btn btn-success ja-btn">
                            <i class="bi bi-save"></i>
                            <span>บันทึกข้อมูล</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>