@extends('admin_client.admin_client')
@section('content')

   <div class="container-fluid mt-2">
    <!-- ฟอร์ม -->
    <div class="card shadow-sm border-0 w-100 mb-0">
        <!-- Header พร้อมปุ่ม toggle -->
        <div class="card-header bg-light fw-bold text-dark py-2 px-3 d-flex justify-content-between align-items-center">
            <div>
                <i class="bi bi-hospital me-2"></i> บันทึกข้อมูลการบาดเจ็บ
            </div>
           <!-- ปุ่ม toggle accident -->
<button id="toggleAccidentBtn"
        class="btn btn-sm btn-primary d-flex align-items-center"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#accidentForm"
        aria-expanded="{{ isset($accident) ? 'true' : 'false' }}"
        aria-controls="accidentForm">
    <i class="bi {{ isset($accident) ? 'bi-chevron-up' : 'bi-chevron-down' }}"></i>
    <span class="ms-1">
        {{ isset($accident) ? 'ซ่อน/ฟอร์ม' : 'เพิ่มข้อมูล' }}
    </span>
</button>


        </div>

        <!-- ฟอร์มซ่อน/แสดง -->
        <div id="accidentForm" class="collapse {{ isset($accident) ? 'show' : '' }}">
            <div class="card-body p-3">
                <form action="{{ $accident ? route('accident.update', $accident->id) : route('accident.store') }}" method="POST">
                    @csrf
                    @if($accident)
                        @method('PUT')
                    @endif

                    <input type="hidden" name="client_id" value="{{ $client->id }}">

                    <div class="row mb-2">
                        <div class="col-12 col-md-4">
                            <label class="form-label fw-bold">วันที่เกิดเหตุ</label>
                            <input type="date" name="incident_date" class="form-control form-control-sm"
                                value="{{ old('incident_date', $accident->incident_date ?? '') }}" required>
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label fw-bold">สถานที่เกิดเหตุ</label>
                            <input type="text" name="location" class="form-control form-control-sm"
                                value="{{ old('location', $accident->location ?? '') }}">
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label fw-bold">ผู้เห็นเหตุการณ์</label>
                            <input type="text" name="eyewitness" class="form-control form-control-sm"
                                value="{{ old('eyewitness', $accident->eyewitness ?? '') }}">
                        </div>
                    </div>

                    <div class="mb-2">
                        <label class="form-label fw-bold">รายละเอียดเหตุการณ์</label>
                        <textarea name="detail" class="form-control form-control-sm" rows="2">{{ old('detail', $accident->detail ?? '') }}</textarea>
                    </div>

                    <div class="row mb-2">
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-bold">สาเหตุ</label>
                            <textarea name="cause" class="form-control form-control-sm" rows="2">{{ old('cause', $accident->cause ?? '') }}</textarea>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-bold">การรักษาพยาบาล</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="treat_no" id="treat_yes" value="พบแพทย์"
                                    {{ old('treat_no', $accident->treat_no ?? '') == 'พบแพทย์' ? 'checked' : '' }}>
                                <label class="form-check-label" for="treat_yes">พบแพทย์</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="treat_no" id="treat_no" value="ไม่พบแพทย์"
                                    {{ old('treat_no', $accident->treat_no ?? 'ไม่พบแพทย์') == 'ไม่พบแพทย์' ? 'checked' : '' }}>
                                <label class="form-check-label" for="treat_no">ไม่พบแพทย์</label>
                            </div>
                        </div>
                    </div>

                    {{-- ฟิลด์ที่จะแสดงเมื่อเลือก "พบแพทย์" --}}
                    <div id="medical-section" style="display: {{ old('treat_no', $accident->treat_no ?? '') == 'พบแพทย์' ? 'block' : 'none' }};">
                        <div class="row mb-2">
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-bold">ชื่อสถานพยาบาล</label>
                                <input type="text" name="hospital" class="form-control form-control-sm"
                                    value="{{ old('hospital', $accident->hospital ?? '') }}">
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-bold">การวินิจฉัย</label>
                                <textarea name="diagnosis" class="form-control form-control-sm" rows="2">{{ old('diagnosis', $accident->diagnosis ?? '') }}</textarea>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-bold">นัดครั้งต่อไป</label>
                                <input type="text" name="appointment" class="form-control form-control-sm"
                                    value="{{ old('appointment', $accident->appointment ?? '') }}">
                            </div>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-bold">การรักษา</label>
                            <textarea name="treatment" class="form-control form-control-sm" rows="2">{{ old('treatment', $accident->treatment ?? '') }}</textarea>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-bold">การแก้ไขและป้องกัน</label>
                            <textarea name="protection" class="form-control form-control-sm" rows="2">{{ old('protection', $accident->protection ?? '') }}</textarea>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-12 col-md-3">
                            <label class="form-label fw-bold">ผู้ดูแล</label>
                            <input type="text" name="caretaker" class="form-control form-control-sm"
                                value="{{ old('caretaker', $accident->caretaker ?? '') }}">
                        </div>
                        <div class="col-12 col-md-3">
                            <label class="form-label fw-bold">วันที่บันทึก</label>
                            <input type="date" name="record_date" class="form-control form-control-sm"
                                value="{{ old('record_date', $accident->record_date ?? '') }}" required>
                        </div>
                        <div class="col-12 col-md-6 d-flex justify-content align-items-end">
                            <button type="submit" class="btn btn-sm btn-success px-3">
                                <i class="bi bi-save me-1"></i>
                                {{ isset($accident) ? 'อัปเดตข้อมูล' : 'บันทึกผล' }}
                            </button>
                            @if(isset($accident))
                                <a href="{{ route('accident.add', $client->id) }}" class="btn btn-sm btn-secondary px-3 ms-1">
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

 @if($accidents->isNotEmpty())
<div class="card mt-1 shadow-sm rounded-1 border-0 ms-2 me-2">
    <div class="card-body p-2">
        <div class="table-responsive">
            <table id="datatable-accident" class="table table-sm table-striped table-hover align-middle w-100 mb-0">
                <thead class="table-primary text-center small">
                    <tr>
                        <th>วันที่เกิดเหตุ</th>
                        <th>สาเหตุ</th>
                        <th>การรักษา</th>
                        <th>การพบแพทย์</th>
                        <th>สถานพยาบาล</th>
                        <th>แพทย์นัครั้งต่อไป</th>
                        <th>ผู้ดูแล</th>
                        <th>จัดการ</th>
                    </tr>
                </thead>
                <tbody class="small">
                    @forelse ($accidents as $index => $accident)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($accident->incident_date)->format('d/m/Y') }}</td>
                            <td>{{ $accident->cause ?? '-' }}</td>
                            <td>{{ $accident->treatment ?? '-' }}</td>
                            <td>{{ $accident->treat_no ?? '-' }}</td>
                            <td>{{ $accident->hospital ?? '-' }}</td>
                            <td>{{ $accident->appointment ?? '-' }}</td>
                            <td>{{ $accident->caretaker ?? '-' }}</td>
                             
                            <td class="text-center">
                              <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('accident.edit', $accident->id) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil-square"></i> แก้ไข
                                    </a>

                                    <button type="button" class="btn btn-sm btn-danger"
                                            onclick="confirmDelete({{ $accident->id }})">
                                        <i class="bi bi-trash"></i> ลบ
                                    </button>

                                    <a href="{{ route('accident.report', $accident->id) }}" class="btn btn-sm btn-info">
                                        <i class="bi bi-file-earmark-text"></i> รายงาน
                                    </a>
                                </div>

                                {{-- ฟอร์มลบแบบซ่อน --}}
                                <form id="delete-form-{{ $accident->id }}"
                                      action="{{ route('accident.delete', $accident->id) }}"
                                      method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted small">
                                <i class="bi bi-info-circle"></i> ยังไม่มีข้อมูลการติดตาม
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif

@endsection

@push('scripts')
    <!-- ✅ Init DataTable -->
    <script>
        $(document).ready(function() {
            $('#datatable-accident').DataTable({
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

    <!-- Script toggle แสดง/ซ่อน medical section -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const treatYes = document.getElementById('treat_yes');
            const treatNo = document.getElementById('treat_no');
            const medicalSection = document.getElementById('medical-section');

            function toggleMedicalSection() {
                if (treatYes.checked) {
                    medicalSection.style.display = 'block';
                } else {
                    medicalSection.style.display = 'none';
                }
            }

            if (treatYes && treatNo && medicalSection) {
                treatYes.addEventListener('change', toggleMedicalSection);
                treatNo.addEventListener('change', toggleMedicalSection);
                // เรียกครั้งแรกเพื่อ set ค่าเริ่มต้น
                toggleMedicalSection();
            }
        });
    </script>

    <!-- Script toggle ซ่อน/แสดง accident form -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const collapseAccident = document.getElementById('accidentForm');
            const toggleAccidentBtn = document.getElementById('toggleAccidentBtn');

            if (collapseAccident && toggleAccidentBtn) {
                collapseAccident.addEventListener('shown.bs.collapse', function () {
                    toggleAccidentBtn.querySelector('i').className = 'bi bi-chevron-up';
                    toggleAccidentBtn.querySelector('span').textContent = 'ซ่อน/ฟอร์ม';
                });

                collapseAccident.addEventListener('hidden.bs.collapse', function () {
                    toggleAccidentBtn.querySelector('i').className = 'bi bi-chevron-down';
                    toggleAccidentBtn.querySelector('span').textContent = 'เพิ่มข้อมูล';
                });
            }
        });
    </script>
@endpush