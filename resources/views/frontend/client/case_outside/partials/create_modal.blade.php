
<style>
    /* validation เฉพาะหน้านี้ */
    .co-page .is-invalid {
        border-color: #dc3545 !important;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.12) !important;
    }

    .co-page .co-invalid-text {
        display: block;
        width: 100%;
        margin-top: .4rem;
        font-size: .82rem;
        font-weight: 600;
        color: #dc3545;
    }

    .co-page .co-option.is-invalid-wrap .co-option-label {
        border-color: #dc3545 !important;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.08) !important;
        background: #fff8f8;
    }

    .co-page .co-section-error {
        border-color: #dc3545 !important;
    }
</style>



<div class="modal fade co-modal co-modal-create"
         id="createCaseOutsideModal"
         tabindex="-1"
         aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable modal-fullscreen-sm-down">
            <div class="modal-content">
                <form id="createCaseOutsideForm"
                      action="{{ route('case_outside.store') }}"
                      method="POST"
                      class="co-modal-form">
                    @csrf
                    <input type="hidden" name="client_id" value="{{ $client->id }}">

                    <div class="modal-header">
                        <h5 class="modal-title co-modal-title">
                            <i class="bi bi-plus-circle"></i>
                            <span>เพิ่มข้อมูลการติดตาม</span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="co-modal-body">
                        <div class="co-section">
                            <div class="co-section-title">
                                <i class="bi bi-ui-checks-grid"></i>
                                <span>ข้อมูลพื้นฐาน</span>
                            </div>

                            <div class="row g-3">
                                <div class="col-12 col-md-4">
                                    <label class="co-label">วันที่ติดตาม <span class="text-danger">*</span></label>
                                    <input type="date"
                                           name="date"
                                           value="{{ old('date') }}"
                                           class="form-control co-control"
                                           required>
                                </div>

                                <div class="col-12 col-md-8">
                                    <label class="co-label">สาเหตุที่พักอาศัยอยู่ภายนอก <span class="text-danger">*</span></label>
                                    <select name="outside_id" class="form-select co-select" required>
                                        <option value="">-- เลือกสาเหตุ --</option>
                                        @foreach($outside as $o)
                                            <option value="{{ $o->id }}" {{ old('outside_id') == $o->id ? 'selected' : '' }}>
                                                {{ $o->outside_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12">
                                    <label class="co-label">สถานที่พัก <span class="text-danger">*</span></label>
                                    <input type="text"
                                           name="dormitory"
                                           value="{{ old('dormitory') }}"
                                           class="form-control co-control"
                                           required>
                                </div>
                            </div>
                        </div>

                        <div class="co-section">
                            <div class="co-section-title">
                                <i class="bi bi-check2-square"></i>
                                <span>การดำเนินงาน</span>
                            </div>

                            <div class="co-option-grid">
                                @foreach(['หน่วยงานไปเอง','โทรศัพท์','จดหมาย'] as $option)
                                    @php
                                        $createOptionId = 'create_follo_no_' . md5($option);
                                    @endphp
                                    <div class="co-option">
                                        <input class="co-option-input"
                                               type="radio"
                                               name="follo_no"
                                               id="{{ $createOptionId }}"
                                               value="{{ $option }}"
                                               {{ old('follo_no') == $option ? 'checked' : '' }}
                                               required>
                                        <label class="co-option-label" for="{{ $createOptionId }}">
                                            <span>{{ $option }}</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="co-section">
                            <div class="co-section-title">
                                <i class="bi bi-card-text"></i>
                                <span>ผลการติดตามและรายละเอียดเพิ่มเติม</span>
                            </div>

                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="co-label">ผลการติดตาม <span class="text-danger">*</span></label>
                                    <textarea name="results"
                                              class="form-control co-textarea"
                                              rows="4"
                                              required>{{ old('results') }}</textarea>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="co-label">ผู้ติดตาม</label>
                                    <input type="text"
                                           name="teacher"
                                           value="{{ old('teacher') }}"
                                           class="form-control co-control">
                                </div>

                                <div class="col-12">
                                    <label class="co-label">หมายเหตุ</label>
                                    <textarea name="remerk"
                                              class="form-control co-textarea"
                                              rows="3">{{ old('remerk') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="co-modal-footer">
                        <button type="button" class="btn btn-outline-secondary co-btn" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle"></i>
                            <span>ปิด</span>
                        </button>
                        <button type="submit" class="btn btn-success co-btn">
                            <i class="bi bi-save"></i>
                            <span>บันทึกข้อมูล</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>