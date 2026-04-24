@extends('admin_client.admin_client')
@section('content')

<div class="container-fluid mt-1">
    <div class="card shadow-sm border-secondary">
        <div class="card-header bg-primary text-white text-center py-2 d-flex justify-content-between align-items-center">
            <h4 class="mb-0">แบบฟอร์มบันทึกการตรวจสุขภาพเบื้องต้น</h4>

            <button id="toggleHealthBtn"
                    class="btn btn-sm btn-light d-flex align-items-center"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#healthForm"
                    aria-expanded="{{ isset($checkbody) ? 'true' : 'false' }}"
                    aria-controls="healthForm">
                <i class="bi {{ isset($checkbody) ? 'bi-chevron-up' : 'bi-chevron-down' }}"></i>
                <span class="ms-1">
                    {{ isset($checkbody) ? 'ซ่อน/ฟอร์ม' : 'เพิ่มข้อมูล' }}
                </span>
            </button>
        </div>

        {{-- ข้อมูล client --}}
        <div class="card mb-0 shadow-sm">
            <div class="card-body">
                <div class="row mb-0">
                    <div class="col-12 col-md-8">
                        <p class="mb-1 d-flex align-items-center flex-wrap">
                            <i class="bi bi-person-fill me-2 text-primary"></i>
                            <span class="fw-bold">ชื่อ-สกุล :</span>
                            <span class="ms-2">{{ $client->fullname ?? '-' }}</span>
                            <span class="ms-4">
                                <i class="bi bi-calendar-heart me-2 text-success"></i>
                                <span class="fw-bold">อายุ :</span> {{ $client->age ?? '-' }} ปี
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div id="healthForm" class="collapse {{ isset($checkbody) ? 'show' : '' }}">
            <div class="card-body p-3">
                <form id="checkbody-form"
                      action="{{ isset($checkbody) ? route('check_body.update', $checkbody->id) : route('check_body.store') }}"
                      method="POST"
                      class="position-relative">
                    @csrf
                    @if(isset($checkbody))
                        @method('PUT')
                    @endif

                    <div class="d-flex justify-content-end flex-wrap gap-2 mb-3">
                        <button type="submit" class="btn btn-sm btn-success px-3">
                            <i class="bi bi-save me-1"></i>
                            {{ isset($checkbody) ? 'อัปเดตข้อมูล' : 'บันทึกผล' }}
                        </button>

                        @if(isset($checkbody))
                            <a href="{{ route('check_body.add', $client->id) }}" class="btn btn-sm btn-danger px-2">
                                <i class="bi bi-arrow-left-circle me-1"></i> กลับไปหน้าเพิ่ม
                            </a>
                        @endif
                    </div>

                    <input type="hidden" name="client_id" value="{{ $client->id }}">

                    <div class="row align-items-start mb-3 g-2">
                        <div class="col-12 col-sm-6 col-md-3">
                            <label class="form-label fw-bold small">วันที่ตรวจ</label>
                            <input type="date"
                                   name="assessor_date"
                                   class="form-control form-control-sm @error('assessor_date') is-invalid @enderror"
                                   value="{{ old('assessor_date', $checkbody->assessor_date ?? '') }}">
                            @error('assessor_date')
                                <div class="invalid-feedback text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-sm-6 col-md-3">
                            <label class="form-label fw-bold small">ผู้ตรวจ</label>
                            <input type="text"
                                   name="recorder"
                                   class="form-control form-control-sm @error('recorder') is-invalid @enderror"
                                   value="{{ old('recorder', $checkbody->recorder ?? '') }}">
                            @error('recorder')
                                <div class="invalid-feedback text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label">พัฒนาการ</label>
                            <div class="d-flex flex-wrap gap-3 mt-1">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input"
                                           type="radio"
                                           name="development"
                                           value="สมวัย"
                                           {{ old('development', $checkbody->development ?? 'สมวัย') == 'สมวัย' ? 'checked' : '' }}
                                           onclick="toggleDetail(false)">
                                    <label class="form-check-label">สมวัย</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input"
                                           type="radio"
                                           name="development"
                                           value="ไม่สมวัย"
                                           {{ old('development', $checkbody->development ?? 'สมวัย') == 'ไม่สมวัย' ? 'checked' : '' }}
                                           onclick="toggleDetail(true)">
                                    <label class="form-check-label">ไม่สมวัย</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3" id="detailField" style="{{ old('development', $checkbody->development ?? '') == 'ไม่สมวัย' ? '' : 'display:none;' }}">
                        <div class="col-md-12">
                            <label class="form-label">รายละเอียด</label>
                            <textarea name="detail" class="form-control form-control-sm" rows="2">{{ old('detail', $checkbody->detail ?? '') }}</textarea>
                        </div>
                    </div>

                    {{-- PATCH: ฟิลด์ใหม่ การพัฒนา --}}
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label fw-bold"></label>

                            <div class="d-flex flex-wrap gap-3 mt-1">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input"
                                           type="radio"
                                           name="development_type"
                                           id="development_type_normal"
                                           value="เด็กทั่วไป"
                                           {{ old('development_type', $checkbody->development_type ?? 'เด็กทั่วไป') == 'เด็กทั่วไป' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="development_type_normal">เด็กทั่วไป</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input"
                                           type="radio"
                                           name="development_type"
                                           id="development_type_special"
                                           value="เด็กกลุ่มพิเศษ"
                                           {{ old('development_type', $checkbody->development_type ?? '') == 'เด็กกลุ่มพิเศษ' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="development_type_special">เด็กกลุ่มพิเศษ</label>
                                </div>
                            </div>

                            @error('development_type')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3" id="specialSupportWrapper" style="{{ old('development_type', $checkbody->development_type ?? 'เด็กทั่วไป') == 'เด็กกลุ่มพิเศษ' ? '' : 'display:none;' }}">
                        <div class="col-12 col-lg-8">
                            <label class="form-label fw-bold">ประเภทการสนับสนุน</label>
                            <select name="special_support_type"
                                    id="special_support_type"
                                    class="form-select form-select-sm @error('special_support_type') is-invalid @enderror">
                                <option value="">-- กรุณาเลือก --</option>
                                <option value="ต้องการการสนับสนุนด้านการเรียนรู้ (อ่าน เขียน คำนวณ)"
                                    {{ old('special_support_type', $checkbody->special_support_type ?? '') == 'ต้องการการสนับสนุนด้านการเรียนรู้ (อ่าน เขียน คำนวณ)' ? 'selected' : '' }}>
                                    ต้องการการสนับสนุนด้านการเรียนรู้ (อ่าน เขียน คำนวณ)
                                </option>
                                <option value="ต้องการการสนับสนุนด้านพฤติกรรมและอารมณ์ (การควบคุมอารมณ์, สมาธิ)"
                                    {{ old('special_support_type', $checkbody->special_support_type ?? '') == 'ต้องการการสนับสนุนด้านพฤติกรรมและอารมณ์ (การควบคุมอารมณ์, สมาธิ)' ? 'selected' : '' }}>
                                    ต้องการการสนับสนุนด้านพฤติกรรมและอารมณ์ (การควบคุมอารมณ์, สมาธิ)
                                </option>
                                <option value="ต้องการการสนับสนุนด้านสังคม (การเข้าสังคม, ทำงานร่วมกับเพื่อน)"
                                    {{ old('special_support_type', $checkbody->special_support_type ?? '') == 'ต้องการการสนับสนุนด้านสังคม (การเข้าสังคม, ทำงานร่วมกับเพื่อน)' ? 'selected' : '' }}>
                                    ต้องการการสนับสนุนด้านสังคม (การเข้าสังคม, ทำงานร่วมกับเพื่อน)
                                </option>
                                <option value="ต้องการการสนับสนุนด้านร่างกาย (การเคลื่อนไหว, สุขภาพ)"
                                    {{ old('special_support_type', $checkbody->special_support_type ?? '') == 'ต้องการการสนับสนุนด้านร่างกาย (การเคลื่อนไหว, สุขภาพ)' ? 'selected' : '' }}>
                                    ต้องการการสนับสนุนด้านร่างกาย (การเคลื่อนไหว, สุขภาพ)
                                </option>
                                <option value="มีศักยภาพพิเศษที่ควรส่งเสริม (ดนตรี, กีฬา, ศิลปะ)"
                                    {{ old('special_support_type', $checkbody->special_support_type ?? '') == 'มีศักยภาพพิเศษที่ควรส่งเสริม (ดนตรี, กีฬา, ศิลปะ)' ? 'selected' : '' }}>
                                    มีศักยภาพพิเศษที่ควรส่งเสริม (ดนตรี, กีฬา, ศิลปะ)
                                </option>
                                <option value="อื่น ๆ"
                                    {{ old('special_support_type', $checkbody->special_support_type ?? '') == 'อื่น ๆ' ? 'selected' : '' }}>
                                    อื่น ๆ
                                </option>
                            </select>
                            @error('special_support_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-lg-4 mt-2 mt-lg-0" id="specialSupportOtherWrapper" style="{{ old('special_support_type', $checkbody->special_support_type ?? '') == 'อื่น ๆ' ? '' : 'display:none;' }}">
                            <label class="form-label fw-bold">อื่น ๆ (ระบุ)</label>
                            <input type="text"
                                   name="special_support_other"
                                   id="special_support_other"
                                   class="form-control form-control-sm @error('special_support_other') is-invalid @enderror"
                                   value="{{ old('special_support_other', $checkbody->special_support_other ?? '') }}">
                            @error('special_support_other')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-md-6 col-lg-2">
                            <label class="form-label fw-bold small">น้ำหนัก (กก.)</label>
                            <input type="text"
                                   name="weight"
                                   class="form-control form-control-sm @error('weight') is-invalid @enderror"
                                   value="{{ old('weight', $checkbody->weight ?? '') }}">
                            @error('weight')
                                <div class="invalid-feedback text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-md-6 col-lg-2">
                            <label class="form-label fw-bold small">ส่วนสูง (ซม.)</label>
                            <input type="text"
                                   name="height"
                                   class="form-control form-control-sm @error('height') is-invalid @enderror"
                                   value="{{ old('height', $checkbody->height ?? '') }}">
                            @error('height')
                                <div class="invalid-feedback text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-lg-4">
                            <label class="form-label">สุขภาพช่องปาก</label>
                            <input type="text" name="oral" class="form-control form-control-sm"
                                   value="{{ old('oral', $checkbody->oral ?? '') }}">
                        </div>

                        <div class="col-12 col-lg-4">
                            <label class="form-label">รูปร่าง / ลักษณะ</label>
                            <input type="text" name="appearance" class="form-control form-control-sm"
                                   value="{{ old('appearance', $checkbody->appearance ?? '') }}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">ร่องรอย บาดแผล</label>
                            <input type="text" name="wound" class="form-control form-control-sm"
                                   value="{{ old('wound', $checkbody->wound ?? '') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">โรคประจำตัว</label>
                            <input type="text" name="disease" class="form-control form-control-sm"
                                   value="{{ old('disease', $checkbody->disease ?? '') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">สุขอนามัย (ความสะอาดตามร่างกาย)</label>
                            <input type="text" name="hygiene" class="form-control form-control-sm"
                                   value="{{ old('hygiene', $checkbody->hygiene ?? '') }}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">สุขภาพ</label>
                            <input type="text" name="health" class="form-control form-control-sm"
                                   value="{{ old('health', $checkbody->health ?? '') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">การปลูกฝี</label>
                            <input type="text" name="inoculation" class="form-control form-control-sm"
                                   value="{{ old('inoculation', $checkbody->inoculation ?? '') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">การฉีดยา</label>
                            <input type="text" name="injection" class="form-control form-control-sm"
                                   value="{{ old('injection', $checkbody->injection ?? '') }}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">การให้วัคซีน</label>
                            <input type="text" name="vaccination" class="form-control form-control-sm"
                                   value="{{ old('vaccination', $checkbody->vaccination ?? '') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">โรคติดต่อ</label>
                            <input type="text" name="contagious" class="form-control form-control-sm"
                                   value="{{ old('contagious', $checkbody->contagious ?? '') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">การเจ็บป่วยอื่นๆ</label>
                            <input type="text" name="other" class="form-control form-control-sm"
                                   value="{{ old('other', $checkbody->other ?? '') }}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">ประวัติการแพ้ยา</label>
                            <input type="text" name="drug_allergy" class="form-control form-control-sm"
                                   value="{{ old('drug_allergy', $checkbody->drug_allergy ?? '') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">หมายเหตุ</label>
                            <textarea name="remark" class="form-control form-control-sm" rows="2">{{ old('remark', $checkbody->remark ?? '') }}</textarea>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@if($checkbodies->isNotEmpty())
    <div class="card mt-1 shadow-sm rounded-1 border-0 ms-2 me-2">
        <div class="card-body p-2">
            <div class="table-responsive">
                <table id="datatable-checkbody" class="table table-sm table-striped table-hover align-middle w-100 mb-0">
                    <thead class="table-primary text-center small">
                        <tr>
                            <th style="width: 5%;">ลำดับ</th>
                            <th style="width: 12%;">วันที่ตรวจ</th>
                            <th style="width: 10%;">น้ำหนัก</th>
                            <th style="width: 10%;">ส่วนสูง</th>
                            <th style="width: 25%;">สุขภาพอนามัย</th>
                            <th style="width: 18%;">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="small">
                        @foreach ($checkbodies as $index => $checkbody)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ \Carbon\Carbon::parse($checkbody->assessor_date)->format('d/m/Y') }}</td>
                                <td>{{ $checkbody->weight ?? '-' }}</td>
                                <td>{{ $checkbody->height ?? '-' }}</td>
                                <td>{{ $checkbody->health ?? '-' }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-end flex-wrap gap-1">
                                        <a href="{{ route('check_body.edit', $checkbody->id) }}" class="btn btn-sm btn-warning me-2">
                                            <i class="bi bi-pencil-square"></i> แก้ไข
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger me-2"
                                                onclick="confirmDelete({{ $checkbody->id }})">
                                            <i class="bi bi-trash"></i> ลบ
                                        </button>
                                        <a href="{{ route('check_body.report', $checkbody->id) }}" class="btn btn-sm btn-info">
                                            <i class="bi bi-file-earmark-text"></i> รายงาน
                                        </a>
                                    </div>

                                    <form id="delete-form-{{ $checkbody->id }}"
                                          action="{{ route('check_body.delete', $checkbody->id) }}"
                                          method="POST"
                                          style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@else
    <div class="alert alert-info text-center small mt-2 ms-2 me-2">
        <i class="bi bi-info-circle"></i> ยังไม่มีข้อมูลการติดตาม
    </div>
@endif
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#datatable-checkbody').DataTable({
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/th.json'
            }
        });
    });
</script>

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'ท่านแน่ใจ ?',
            text: 'ลบข้อมูลนี้ใช่หรือไม่ ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'ตกลง',
            cancelButtonText: 'ยกเลิก',
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>

<script>
    function toggleDetail(show) {
        const detailField = document.getElementById('detailField');
        if (detailField) {
            detailField.style.display = show ? 'block' : 'none';
        }
    }

    function toggleSpecialSupportSection() {
        const checkedType = document.querySelector('input[name="development_type"]:checked');
        const wrapper = document.getElementById('specialSupportWrapper');
        const otherWrapper = document.getElementById('specialSupportOtherWrapper');
        const supportType = document.getElementById('special_support_type');
        const otherInput = document.getElementById('special_support_other');

        if (!wrapper || !supportType || !otherWrapper || !otherInput) {
            return;
        }

        if (checkedType && checkedType.value === 'เด็กกลุ่มพิเศษ') {
            wrapper.style.display = '';
        } else {
            wrapper.style.display = 'none';
            supportType.value = '';
            otherWrapper.style.display = 'none';
            otherInput.value = '';
        }

        toggleSpecialSupportOther();
    }

    function toggleSpecialSupportOther() {
        const supportType = document.getElementById('special_support_type');
        const otherWrapper = document.getElementById('specialSupportOtherWrapper');
        const otherInput = document.getElementById('special_support_other');

        if (!supportType || !otherWrapper || !otherInput) {
            return;
        }

        if (supportType.value === 'อื่น ๆ') {
            otherWrapper.style.display = '';
        } else {
            otherWrapper.style.display = 'none';
            otherInput.value = '';
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const collapseHealth = document.getElementById('healthForm');
        const toggleHealthBtn = document.getElementById('toggleHealthBtn');

        if (collapseHealth && toggleHealthBtn) {
            collapseHealth.addEventListener('shown.bs.collapse', function () {
                toggleHealthBtn.querySelector('i').className = 'bi bi-chevron-up';
                toggleHealthBtn.querySelector('span').textContent = 'ซ่อน/ฟอร์ม';
            });

            collapseHealth.addEventListener('hidden.bs.collapse', function () {
                toggleHealthBtn.querySelector('i').className = 'bi bi-chevron-down';
                toggleHealthBtn.querySelector('span').textContent = 'เพิ่มข้อมูล';
            });
        }

        document.querySelectorAll('input[name="development_type"]').forEach(function(radio) {
            radio.addEventListener('change', toggleSpecialSupportSection);
        });

        const supportType = document.getElementById('special_support_type');
        if (supportType) {
            supportType.addEventListener('change', toggleSpecialSupportOther);
        }

        toggleSpecialSupportSection();
    });
</script>

@if ($errors->any())
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var collapseHealth = new bootstrap.Collapse(document.getElementById('healthForm'), {
            show: true
        });

        let errorMessages = `{!! implode('<br>', $errors->all()) !!}`;

        Swal.fire({
            title: 'พบข้อผิดพลาด',
            html: errorMessages,
            icon: 'error',
            confirmButtonText: 'ตกลง'
        });
    });
</script>
@endif

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.querySelector('#checkbody-form');
        if(form){
            form.querySelectorAll('input, textarea, select').forEach(function(field){
                const eventType = field.tagName.toLowerCase() === 'select' || field.type === 'radio' ? 'change' : 'input';

                field.addEventListener(eventType, function(){
                    if(field.classList.contains('is-invalid')){
                        field.classList.remove('is-invalid');
                    }

                    const feedback = field.parentElement.querySelector('.invalid-feedback');
                    if(feedback){
                        feedback.remove();
                    }
                });
            });
        }
    });
</script>
@endpush