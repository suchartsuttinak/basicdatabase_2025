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

         {{-- ข้อมูล client --}}
            <div class="card mb-1 shadow-sm mt-2">
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

        <!-- ฟอร์มซ่อน/แสดง -->
        <!-- ฟอร์มซ่อน/แสดง -->
<div id="accidentForm" class="collapse {{ isset($accident) ? 'show' : '' }}">
    <div class="card-body p-3">
        <form id="accident-form"
              action="{{ isset($accident) ? route('accident.update', $accident->id) : route('accident.store') }}"
              method="POST" class="position-relative">
            @csrf
            @if(isset($accident))
                @method('PUT')
            @endif

            <input type="hidden" name="client_id" value="{{ $client->id }}">

            <div class="row mb-2">
                <div class="col-6 col-md-3">
                    <label class="form-label fw-bold small">วันที่ตรวจ</label>
                    <input type="date" name="incident_date"
                        class="form-control @error('incident_date') is-invalid @enderror"
                        value="{{ old('incident_date', $accident->incident_date ?? '') }}">
                    @error('incident_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-4">
                    <label class="form-label fw-bold">สถานที่เกิดเหตุ</label>
                    <input type="text" name="location"
                           class="form-control form-control-sm @error('location') is-invalid @enderror"
                           value="{{ old('location', $accident->location ?? '') }}">
                    @error('location')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-4">
                    <label class="form-label fw-bold">ผู้เห็นเหตุการณ์</label>
                    <input type="text" name="eyewitness" class="form-control form-control-sm"
                           value="{{ old('eyewitness', $accident->eyewitness ?? '') }}">
                </div>
            </div>

            <div class="mb-2">
                <label class="form-label fw-bold">รายละเอียดเหตุการณ์</label>
                <textarea name="detail"
                          class="form-control form-control-sm @error('detail') is-invalid @enderror"
                          rows="2">{{ old('detail', $accident->detail ?? '') }}</textarea>
                @error('detail')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row mb-2">
                <div class="col-12 col-md-6">
                    <label class="form-label fw-bold">สาเหตุ</label>
                    <textarea name="cause"
                              class="form-control form-control-sm @error('cause') is-invalid @enderror"
                              rows="2">{{ old('cause', $accident->cause ?? '') }}</textarea>
                    @error('cause')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label fw-bold">การรักษาพยาบาล</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input @error('treat_no') is-invalid @enderror"
                               type="radio" name="treat_no" id="treat_yes" value="พบแพทย์"
                               {{ old('treat_no', $accident->treat_no ?? '') == 'พบแพทย์' ? 'checked' : '' }}>
                        <label class="form-check-label" for="treat_yes">พบแพทย์</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input @error('treat_no') is-invalid @enderror"
                               type="radio" name="treat_no" id="treat_no" value="ไม่พบแพทย์"
                               {{ old('treat_no', $accident->treat_no ?? 'ไม่พบแพทย์') == 'ไม่พบแพทย์' ? 'checked' : '' }}>
                        <label class="form-check-label" for="treat_no">ไม่พบแพทย์</label>
                    </div>
                    @error('treat_no')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
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
                    <input type="date" name="record_date"
                            class="form-control @error('record_date') is-invalid @enderror"
                            value="{{ old('record_date', $accident->record_date ?? '') }}">
                        @error('record_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

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
<!-- ตารางอุบัติเหตุ -->
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
                            <th>แพทย์นัดครั้งต่อไป</th>
                            <th>ผู้ดูแล</th>
                            <th>จัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="small">
                        @foreach ($accidents as $index => $accident)
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
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@else
    <div class="alert alert-info text-center small mt-2 ms-2 me-2">
        <i class="bi bi-info-circle"></i> ยังไม่มีข้อมูลอุบัติเหตุ
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
                medicalSection.style.display = treatYes.checked ? 'block' : 'none';
            }

            if (treatYes && treatNo && medicalSection) {
                treatYes.addEventListener('change', toggleMedicalSection);
                treatNo.addEventListener('change', toggleMedicalSection);
                toggleMedicalSection(); // set ค่าเริ่มต้น
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

    <!-- ✅ SweetAlert2 แจ้งเตือนเมื่อมี error validation -->
    @if ($errors->any())
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var collapseAccident = new bootstrap.Collapse(document.getElementById('accidentForm'), {
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

    <!-- ✅ เคลียร์ error ทันทีเมื่อกรอกข้อมูลใหม่ -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.querySelector('#accident-form'); // ต้องใส่ id="accident-form" ให้ฟอร์ม
            if(form){
                form.querySelectorAll('input, textarea, select').forEach(function(field){
                    field.addEventListener('input', function(){
                        if(field.classList.contains('is-invalid')){
                            field.classList.remove('is-invalid');
                            // ✅ ลบ invalid-feedback ที่อยู่ถัดไป
                            if(field.nextElementSibling && field.nextElementSibling.classList.contains('invalid-feedback')){
                                field.nextElementSibling.style.display = 'none'; // ซ่อนข้อความสีแดง
                            }
                        }
                    });
                });
            }
        });
    </script>
@endpush