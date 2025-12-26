@extends('admin_client.admin_client')
@section('content')

  <div class="container-fluid mt-2">
    <!-- ฟอร์ม -->
    <div class="card shadow-sm border-0 w-100 mb-0">
        <!-- Header พร้อมปุ่ม toggle -->
        <div class="card-header bg-light fw-bold text-dark py-2 px-3 d-flex justify-content-between align-items-center">
            <div>
                <i class="bi bi-hospital me-2"></i> บันทึกข้อมูลการรักษาพยาบาลเด็ก
            </div>
            <!-- ปุ่ม toggle medical -->
            <button id="toggleMedicalBtn"
                    class="btn btn-sm btn-primary d-flex align-items-center"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#medicalForm"
                    aria-expanded="{{ isset($medical) ? 'true' : 'false' }}"
                    aria-controls="medicalForm">
                <i class="bi {{ isset($medical) ? 'bi-chevron-up' : 'bi-chevron-down' }}"></i>
                <span class="ms-1">
                    {{ isset($medical) ? 'ซ่อน/ฟอร์ม' : 'เพิ่มข้อมูล' }}
                </span>
            </button>
        </div>

        <!-- ฟอร์มซ่อน/แสดง -->
        <div id="medicalForm" class="collapse {{ isset($medical) ? 'show' : '' }}">
            <div class="card-body p-3">
                <form action="{{ $medical ? route('medical.update', $medical->id) : route('medical.store') }}" method="POST">
                    @csrf
                    @if($medical)
                        @method('PUT')
                    @endif

                    <input type="hidden" name="client_id" value="{{ $client->id }}">

                    <div class="row mb-2">
                        <div class="col-12 col-md-2">
                            <label class="form-label fw-bold">วันที่</label>
                            <input type="date" name="medical_date" class="form-control form-control-sm"
                                   value="{{ old('medical_date', $medical->medical_date ?? '') }}" required>
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label fw-bold">ชื่อโรค</label>
                            <input type="text" name="disease_name" class="form-control form-control-sm"
                                   value="{{ old('disease_name', $medical->disease_name ?? '') }}">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-bold">อาการป่วย</label>
                            <textarea name="illness" class="form-control form-control-sm" rows="2">{{ old('illness', $medical->illness ?? '') }}</textarea>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label class="form-label fw-bold">การรักษา/การปฐมพยาบาล</label>
                        <textarea name="treatment" class="form-control form-control-sm" rows="2">{{ old('treatment', $medical->treatment ?? '') }}</textarea>
                    </div>

                    <div class="row mb-2">
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-bold">การพบแพทย์</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="refer" id="refer_yes" value="พบแพทย์"
                                    {{ old('refer', $medical->refer ?? 'ไม่พบแพทย์') == 'พบแพทย์' ? 'checked' : '' }}>
                                <label class="form-check-label" for="refer_yes">พบแพทย์</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="refer" id="refer_no" value="ไม่พบแพทย์"
                                    {{ old('refer', $medical->refer ?? 'ไม่พบแพทย์') == 'ไม่พบแพทย์' ? 'checked' : '' }}>
                                <label class="form-check-label" for="refer_no">ไม่พบแพทย์</label>
                            </div>
                        </div>
                    </div>

                    {{-- ฟิลด์ diagnosis และ appt_date จะแสดงเฉพาะเมื่อเลือก "พบแพทย์" --}}
                    <div id="medical-section" style="display: {{ old('refer', $medical->refer ?? 'ไม่พบแพทย์') == 'พบแพทย์' ? 'block' : 'none' }};">
                        <div class="row mb-2">
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-bold">การวินิจฉัย</label>
                                <textarea name="diagnosis" class="form-control form-control-sm" rows="2">{{ old('diagnosis', $medical->diagnosis ?? '') }}</textarea>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-bold">วันที่แพทย์นัด</label>
                                <input type="date" name="appt_date" class="form-control form-control-sm"
                                       value="{{ old('appt_date', $medical->appt_date ?? '') }}">
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label class="form-label fw-bold">ผู้ดูแล</label>
                            <input type="text" name="teacher" class="form-control form-control-sm"
                                   value="{{ old('teacher', $medical->teacher ?? '') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">หมายเหตุ</label>
                            <textarea name="remark" class="form-control form-control-sm" rows="2">{{ old('remark', $medical->remark ?? '') }}</textarea>
                        </div>
                     <div class="col-12 col-md-3 d-flex flex-column flex-md-row justify-content-md-start align-items-md-end gap-2">
                            <button type="submit" class="btn btn-success btn-sm d-inline-flex align-items-center w-auto px-2 py-1">
                                <i class="bi bi-save me-1"></i>
                                {{ isset($medical) ? 'อัปเดตข้อมูล' : 'บันทึกผล' }}
                            </button>
                            @if(isset($medical))
                                <a href="{{ route('medical.add', $client->id) }}" class="btn btn-secondary btn-sm d-inline-flex align-items-center w-auto px-2 py-1">
                                    <i class="bi bi-arrow-left-circle me-1"></i> กลับไปหน้าก่อน
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

        @if($medicals->isNotEmpty())
        <div class="card mt-1 shadow-sm rounded-1 border-0 ms-2 me-2">

        {{-- กรณีซ่อนฟอร์ม → แสดงหัวข้อไว้เหมือนเดิม --}}
                {{-- @if(!isset($medical))
                <div class="card-header bg-light fw-bold text-dark py-2 px-3">
                    <i class="bi bi-hospital me-2"></i> ข้อมูลการรักษาพยาบาลเด็ก
                </div>
                @endif --}}

            <div class="card-body p-2">
                <div class="table-responsive">
                    <table id="datatable-medical" class="table table-sm table-striped table-hover align-middle w-100 mb-0">
                        <thead class="table-primary text-center small">
                            <tr>
                                <th>ลำดับ</th>
                                <th>วันที่</th>
                                <th>อาการป่วย</th>
                                <th>การรักษา</th>
                                <th>การพบแพทย์</th>
                                <th>วันที่แพทย์นัด</th>
                                <th>จัดการ</th>
                            </tr>
                        </thead>
                        <tbody class="small">
                    @forelse ($medicals as $index => $medical)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ \Carbon\Carbon::parse($medical->medical_date)->format('d/m/Y') }}</td>
                            <td>{{ $medical->illness ?? '-' }}</td>
                            <td>{{ $medical->treatment ?? '-' }}</td>
                            <td>{{ $medical->refer ?? '-' }}</td>
                            <td>{{ $medical->appt_date ? \Carbon\Carbon::parse($medical->appt_date)->format('d/m/Y') : '-' }}</td>

                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('medical.edit', $medical->id) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil-square"></i> แก้ไข
                                    </a>

                                    <button type="button" class="btn btn-sm btn-danger"
                                            onclick="confirmDelete({{ $medical->id }})">
                                        <i class="bi bi-trash"></i> ลบ
                                    </button>

                                    <a href="{{ route('medical.report', $medical->id) }}" class="btn btn-sm btn-info">
                                        <i class="bi bi-file-earmark-text"></i> รายงาน
                                    </a>
                                </div>

                                {{-- ฟอร์มลบแบบซ่อน --}}
                                <form id="delete-form-{{ $medical->id }}"
                                      action="{{ route('medical.delete', $medical->id) }}"
                                      method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted small">
                                <i class="bi bi-info-circle"></i> ยังไม่มีข้อมูลการรักษาพยาบาล
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif


@push('scripts')
    <!-- ✅ Init DataTable -->
    <script>
        $(document).ready(function() {
            $('#datatable-medical').DataTable({
                responsive: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/th.json'
                }
            });
        });
    </script>

    <!-- SweetAlert2 สำหรับยืนยันการลบ -->
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
@endpush

{{-- Script toggle --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const referYes = document.getElementById('refer_yes');   // พบแพทย์
        const referNo  = document.getElementById('refer_no');    // ไม่พบแพทย์
        const medicalSection = document.getElementById('medical-section'); // div ที่ห่อ diagnosis + appt_date

        function toggleMedicalSection() {
            if (referYes && referYes.checked) {
                medicalSection.style.display = 'block';
            } else {
                medicalSection.style.display = 'none';
            }
        }

        if (referYes) referYes.addEventListener('change', toggleMedicalSection);
        if (referNo)  referNo.addEventListener('change', toggleMedicalSection);

        // เรียกครั้งแรกเพื่อ set ค่าเริ่มต้น
        toggleMedicalSection();
    });
</script>

{{-- Script toggle ซ่อนฟอร์ม --}}
<script>
function toggleMedicalForm() {
    const form = document.getElementById('medical-form');
    form.style.display = (form.style.display === 'none') ? 'block' : 'none';
}
</script>

<!-- Script toggle ซ่อน/แสดง medical form -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const collapseMedical = document.getElementById('medicalForm');
    const toggleMedicalBtn = document.getElementById('toggleMedicalBtn');

    if (collapseMedical && toggleMedicalBtn) {
        // สลับเมื่อเปิด
        collapseMedical.addEventListener('shown.bs.collapse', function () {
            toggleMedicalBtn.querySelector('i').className = 'bi bi-dash-circle me-1';
            toggleMedicalBtn.querySelector('span').textContent = 'ซ่อน/ฟอร์ม';
        });
        // สลับเมื่อปิด
        collapseMedical.addEventListener('hidden.bs.collapse', function () {
            toggleMedicalBtn.querySelector('i').className = 'bi bi-plus-circle me-1';
            toggleMedicalBtn.querySelector('span').textContent = 'เพิ่มข้อมูล';
        });
    }
});
</script>





@endsection