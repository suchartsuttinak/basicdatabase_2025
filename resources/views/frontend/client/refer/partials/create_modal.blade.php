<div class="modal fade rf-modal" id="createReferModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable modal-fullscreen-sm-down">
        <div class="modal-content">
            <form action="{{ route('refers.store') }}"
                  method="POST"
                  id="referForm"
                  class="rf-modal-form refer-validate-form"
                  enctype="multipart/form-data"
                  novalidate>
                @csrf
                <input type="hidden" name="client_id" value="{{ $client->id }}">

                <div class="modal-header">
                    <h5 class="modal-title rf-modal-title">
                        <i class="bi bi-file-earmark-plus"></i>
                        <span>แบบฟอร์มบันทึกข้อมูลการจำหน่ายเพื่อส่งรออนุมัติ</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="rf-modal-body">

                    <div class="alert alert-warning border-0 mb-3" style="border-radius: 14px;">
                        <div class="d-flex align-items-start gap-2">
                            <i class="bi bi-exclamation-triangle-fill mt-1"></i>
                            <div>
                                <div class="fw-bold">การบันทึกครั้งนี้จะยังไม่อนุมัติทันที</div>
                                <div class="small mb-0">
                                    เมื่อบันทึกแล้ว รายการจะถูกส่งเข้าสถานะ <strong>รออนุมัติ</strong>
                                    และต้องให้ <strong>admin หรือผู้บริหาร</strong> เป็นผู้อนุมัติการจำหน่าย
                                </div>
                            </div>
                        </div>
                    </div>

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

                            <div class="col-12 col-md-6">
                                <label class="rf-label d-block mb-2">คณะกรรมการฯ <span class="text-danger">*</span></label>

                                <div class="rf-committee-group">
                                    <label class="rf-committee-option">
                                        <input type="radio"
                                               name="committee_result"
                                               value="ไม่ผ่าน"
                                               {{ old('committee_result', 'ไม่ผ่าน') === 'ไม่ผ่าน' ? 'checked' : '' }}>
                                        <span>ไม่ผ่าน</span>
                                    </label>

                                    <label class="rf-committee-option">
                                        <input type="radio"
                                               name="committee_result"
                                               value="ผ่าน"
                                               {{ old('committee_result') === 'ผ่าน' ? 'checked' : '' }}>
                                        <span>ผ่าน</span>
                                    </label>
                                </div>

                                @error('committee_result')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12"
                                 id="meeting-report-upload-wrapper"
                                 style="{{ old('committee_result', 'ไม่ผ่าน') === 'ผ่าน' ? '' : 'display:none;' }}">
                                <label class="rf-label">แนบรายงานการประชุม</label>
                                <input type="file"
                                       name="meeting_report_file"
                                       class="form-control rf-control"
                                       accept="application/pdf">
                                <div class="form-text">รองรับเฉพาะไฟล์ PDF ขนาดไม่เกิน 10 MB</div>

                                @error('meeting_report_file')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
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

                    @if($client->release_status === 'pending_refer')
                        <button type="button" class="btn btn-secondary rf-btn" disabled>
                            <i class="bi bi-hourglass-split"></i>
                            <span>รออนุมัติแล้ว</span>
                        </button>
                    @else
                        <button type="submit" class="btn btn-success rf-btn">
                            <i class="bi bi-send-check"></i>
                            <span>บันทึกและส่งรออนุมัติ</span>
                        </button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.rf-committee-group{
    display:flex;
    flex-wrap:wrap;
    gap:10px;
    margin-top:2px;
}

.rf-committee-option{
    display:inline-flex;
    align-items:center;
    gap:8px;
    min-height:42px;
    padding:9px 14px;
    border:1px solid #d8e0ea;
    border-radius:12px;
    background:#ffffff;
    color:#0f172a;
    font-size:14px;
    font-weight:600;
    cursor:pointer;
    transition:all .2s ease;
    user-select:none;
}

.rf-committee-option:hover{
    border-color:#b8c7d9;
    background:#f8fbff;
}

.rf-committee-option input[type="radio"]{
    width:16px;
    height:16px;
    margin:0;
    accent-color:#2563eb;
}

#meeting-report-upload-wrapper{
    margin-top:2px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const radios = document.querySelectorAll('input[name="committee_result"]');
    const uploadWrapper = document.getElementById('meeting-report-upload-wrapper');
    const uploadInput = document.querySelector('input[name="meeting_report_file"]');

    function toggleMeetingReportUpload() {
        const checked = document.querySelector('input[name="committee_result"]:checked');

        if (checked && checked.value === 'ผ่าน') {
            uploadWrapper.style.display = '';
        } else {
            uploadWrapper.style.display = 'none';
            if (uploadInput) {
                uploadInput.value = '';
            }
        }
    }

    radios.forEach(function (radio) {
        radio.addEventListener('change', toggleMeetingReportUpload);
    });

    toggleMeetingReportUpload();
});
</script>