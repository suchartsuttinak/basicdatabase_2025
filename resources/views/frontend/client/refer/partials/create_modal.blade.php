 <div class="modal fade rf-modal" id="createReferModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable modal-fullscreen-sm-down">
            <div class="modal-content">
                <form action="{{ route('refers.store') }}"
                      method="POST"
                      id="referForm"
                      class="rf-modal-form refer-validate-form"
                      novalidate>
                    @csrf
                    <input type="hidden" name="client_id" value="{{ $client->id }}">
                    <input type="hidden" name="status" value="refer">

                    <div class="modal-header">
                        <h5 class="modal-title rf-modal-title">
                            <i class="bi bi-file-earmark-plus"></i>
                            <span>แบบฟอร์มบันทึกข้อมูลการจำหน่าย</span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="rf-modal-body">
                        <div class="rf-section">
                            <div class="rf-section-title">
                                <i class="bi bi-ui-checks-grid"></i>
                                <span>ข้อมูลการนำส่ง</span>
                            </div>

                            <div class="row g-3">
                                <div class="col-12 col-md-4">
                                    <label class="rf-label">วันที่นำส่ง <span class="text-danger">*</span></label>
                                    <input type="date"
                                           name="refer_date"
                                           value="{{ old('refer_date') }}"
                                           class="form-control rf-control"
                                           required>
                                </div>

                                <div class="col-12 col-md-8">
                                    <label class="rf-label">สาเหตุการจำหน่าย <span class="text-danger">*</span></label>
                                    <select name="translate_id" class="form-select rf-select" required>
                                        <option value="">-- เลือก --</option>
                                        @foreach($translates as $t)
                                            <option value="{{ $t->id }}" {{ old('translate_id') == $t->id ? 'selected' : '' }}>
                                                {{ $t->translate_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12">
                                    <label class="rf-label">ชื่อสถานที่นำส่ง <span class="text-danger">*</span></label>
                                    <input type="text"
                                           name="destination"
                                           value="{{ old('destination') }}"
                                           class="form-control rf-control"
                                           required>
                                </div>

                                <div class="col-12">
                                    <label class="rf-label">ที่อยู่ <span class="text-danger">*</span></label>
                                    <textarea name="address"
                                              class="form-control rf-textarea"
                                              rows="2"
                                              required>{{ old('address') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="rf-section" id="guardianSection">
                            <div class="rf-section-title">
                                <i class="bi bi-people"></i>
                                <span>ข้อมูลผู้ดูแล</span>
                            </div>

                            <label class="rf-label d-block mb-2">มีผู้ดูแลหรือไม่ <span class="text-danger">*</span></label>
                            <div class="rf-option-grid">
                                <div class="rf-option">
                                    <input class="rf-option-input"
                                           type="radio"
                                           name="guardian"
                                           id="guardian_yes"
                                           value="มี"
                                           {{ old('guardian') == 'มี' ? 'checked' : '' }}
                                           required>
                                    <label class="rf-option-label" for="guardian_yes">
                                        <span>มีผู้ดูแล / มีผู้มารับตัว</span>
                                    </label>
                                </div>

                                <div class="rf-option">
                                    <input class="rf-option-input"
                                           type="radio"
                                           name="guardian"
                                           id="guardian_no"
                                           value="ไม่มี"
                                           {{ old('guardian') == 'ไม่มี' ? 'checked' : '' }}
                                           required>
                                    <label class="rf-option-label" for="guardian_no">
                                        <span>ไม่มีผู้ดูแล</span>
                                    </label>
                                </div>
                            </div>

                            <div id="guardianFields" class="rf-guardian-panel {{ old('guardian') == 'มี' ? 'is-active' : '' }}">
                                <div class="row g-3">
                                    <div class="col-12 col-md-4">
                                        <label class="rf-label">ชื่อผู้รับตัว</label>
                                        <input type="text"
                                               name="parent_name"
                                               value="{{ old('parent_name') }}"
                                               class="form-control rf-control">
                                    </div>

                                    <div class="col-12 col-md-4">
                                        <label class="rf-label">โทรศัพท์</label>
                                        <input type="text"
                                               name="parent_tel"
                                               value="{{ old('parent_tel') }}"
                                               class="form-control rf-control">
                                    </div>

                                    <div class="col-12 col-md-4">
                                        <label class="rf-label">ความสัมพันธ์</label>
                                        <input type="text"
                                               name="member"
                                               value="{{ old('member') }}"
                                               class="form-control rf-control">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="rf-section">
                            <div class="rf-section-title">
                                <i class="bi bi-person-workspace"></i>
                                <span>ข้อมูลเพิ่มเติม</span>
                            </div>

                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label class="rf-label">ชื่อผู้นำส่ง <span class="text-danger">*</span></label>
                                    <input type="text"
                                           name="teacher"
                                           value="{{ old('teacher') }}"
                                           class="form-control rf-control"
                                           required>
                                </div>

                                <div class="col-12">
                                    <label class="rf-label">หมายเหตุ</label>
                                    <textarea name="remark"
                                              class="form-control rf-textarea"
                                              rows="2">{{ old('remark') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="rf-modal-footer">
                        <button type="button" class="btn btn-outline-secondary rf-btn" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle"></i>
                            <span>ปิด</span>
                        </button>
                        <button type="submit" class="btn btn-success rf-btn">
                            <i class="bi bi-save"></i>
                            <span>บันทึกผล</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>