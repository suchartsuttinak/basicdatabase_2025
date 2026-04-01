 @foreach ($caseoutsides as $case)
        <div class="modal fade co-modal co-modal-edit"
             id="editCaseOutsideModal{{ $case->id }}"
             tabindex="-1"
             aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable modal-fullscreen-sm-down">
                <div class="modal-content">
                    <form action="{{ route('case_outside.update', $case->id) }}"
                          method="POST"
                          class="co-modal-form">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="client_id" value="{{ $client->id }}">
                        <input type="hidden" name="case_id" value="{{ $case->id }}">

                        <div class="modal-header">
                            <h5 class="modal-title co-modal-title">
                                <i class="bi bi-pencil-square"></i>
                                <span>แก้ไขข้อมูลการติดตาม</span>
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
                                               value="{{ \Carbon\Carbon::parse($case->date)->format('Y-m-d') }}"
                                               class="form-control co-control"
                                               required>
                                    </div>

                                    <div class="col-12 col-md-8">
                                        <label class="co-label">สาเหตุที่พักอาศัยอยู่ภายนอก <span class="text-danger">*</span></label>
                                        <select name="outside_id" class="form-select co-select" required>
                                            <option value="">-- เลือกสาเหตุ --</option>
                                            @foreach($outside as $o)
                                                <option value="{{ $o->id }}" {{ $case->outside_id == $o->id ? 'selected' : '' }}>
                                                    {{ $o->outside_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-12">
                                        <label class="co-label">สถานที่พัก <span class="text-danger">*</span></label>
                                        <input type="text"
                                               name="dormitory"
                                               value="{{ $case->dormitory }}"
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
                                            $editOptionId = 'edit_follo_no_' . $case->id . '_' . md5($option);
                                        @endphp
                                        <div class="co-option">
                                            <input class="co-option-input"
                                                   type="radio"
                                                   name="follo_no"
                                                   id="{{ $editOptionId }}"
                                                   value="{{ $option }}"
                                                   {{ $case->follo_no == $option ? 'checked' : '' }}
                                                   required>
                                            <label class="co-option-label" for="{{ $editOptionId }}">
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
                                                  required>{{ $case->results }}</textarea>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label class="co-label">ผู้ติดตาม</label>
                                        <input type="text"
                                               name="teacher"
                                               value="{{ $case->teacher }}"
                                               class="form-control co-control">
                                    </div>

                                    <div class="col-12">
                                        <label class="co-label">หมายเหตุ</label>
                                        <textarea name="remerk"
                                                  class="form-control co-textarea"
                                                  rows="3">{{ $case->remerk }}</textarea>
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
                                <span>บันทึกการแก้ไข</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach