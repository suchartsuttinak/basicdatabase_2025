@extends('admin_client.admin_client')
@section('content')

  <div class="container-fluid mt-1">
    <div class="card shadow-sm border-secondary">
        <!-- Header พร้อมปุ่ม toggle -->
        <div class="card-header bg-dark text-white text-center py-2 d-flex justify-content-between align-items-center">
            <h4 class="mb-0">แบบฟอร์มบันทึกการตรวจสุขภาพเบื้องต้น</h4>
            <!-- ปุ่ม toggle health -->
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

        <!-- ฟอร์มซ่อน/แสดง -->
        <div id="healthForm" class="collapse {{ isset($checkbody) ? 'show' : '' }}">
            <div class="card-body p-3">
                <form action="{{ isset($checkbody) ? route('check_body.update', $checkbody->id) : route('check_body.store') }}" method="POST" class="position-relative">
                    @csrf
                    @if(isset($checkbody))
                        @method('PUT')
                    @endif
                <!-- ปุ่มมุมขวาบน ภายในฟอร์ม -->
                <div class="d-flex justify-content-end mb-3">
                <button type="submit" class="btn btn-sm btn-success px-3 me-2">
                    <i class="bi bi-save me-1"></i>
                    {{ isset($checkbody) ? 'อัปเดตข้อมูล' : 'บันทึกผล' }}
                </button>

                @if(isset($checkbody))
                    <a href="{{ route('check_body.add', $client->id) }}" class="btn btn-sm btn-danger px-2">
                        <i class="bi bi-arrow-left-circle me-1"></i> กลับไปหน้าเพิ่ม
                    </a>            
                @endif
            </div>
            <!-- ส่ง client_id -->
            <input type="hidden" name="client_id" value="{{ $client->id }}">
           

                <!-- วันที่ตรวจ + ผู้ตรวจ -->
                <div class="row align-items-start mb-3 g-2">
                    <div class="col-6 col-md-3">
                        <label class="form-label">วันที่ตรวจ</label>
                        <input type="date" name="assessor_date" class="form-control form-control-sm"
                               value="{{ old('assessor_date', $checkbody->assessor_date ?? '') }}">
                    </div>

                    <div class="col-6 col-md-3">
                        <label class="form-label">ผู้ตรวจ</label>
                        <input type="text" name="recorder" class="form-control form-control-sm"
                               value="{{ old('recorder', $checkbody->recorder ?? '') }}">
                    </div>

                    <!-- พัฒนาการ -->
                   <div class="col-12 col-md-5 ms-md-5">
                        <label class="form-label">พัฒนาการ</label>
                        <div class="d-flex flex-wrap gap-3 mt-1">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="development" value="สมวัย"
                                    {{ old('development', $checkbody->development ?? 'สมวัย') == 'สมวัย' ? 'checked' : '' }}
                                    onclick="toggleDetail(false)">
                                <label class="form-check-label">สมวัย</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="development" value="ไม่สมวัย"
                                    {{ old('development', $checkbody->development ?? 'สมวัย') == 'ไม่สมวัย' ? 'checked' : '' }}
                                    onclick="toggleDetail(true)">
                                <label class="form-check-label">ไม่สมวัย</label>
                            </div>
                        </div>
                    </div>
                 </div>

                <!-- รายละเอียด -->
                <div class="row mb-3" id="detailField" style="{{ old('development', $checkbody->development ?? '') == 'ไม่สมวัย' ? '' : 'display:none;' }}">
                    <div class="col-md-12">
                        <label class="form-label">รายละเอียด</label>
                        <textarea name="detail" class="form-control form-control-sm" rows="2">{{ old('detail', $checkbody->detail ?? '') }}</textarea>
                    </div>
                </div>

                <!-- น้ำหนัก / ส่วนสูง / สุขภาพช่องปาก / รูปร่าง -->
                <div class="row mb-3">
                    <div class="col-md-2">
                        <label class="form-label">น้ำหนัก (กก.)</label>
                        <input type="text" name="weight" class="form-control form-control-sm"
                               value="{{ old('weight', $checkbody->weight ?? '') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">ส่วนสูง (ซม.)</label>
                        <input type="text" name="height" class="form-control form-control-sm"
                               value="{{ old('height', $checkbody->height ?? '') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">สุขภาพช่องปาก</label>
                        <input type="text" name="oral" class="form-control form-control-sm"
                               value="{{ old('oral', $checkbody->oral ?? '') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">รูปร่าง / ลักษณะ</label>
                        <input type="text" name="appearance" class="form-control form-control-sm"
                               value="{{ old('appearance', $checkbody->appearance ?? '') }}">
                    </div>
                </div>

                <!-- บาดแผล / โรคประจำตัว / สุขภาพอนามัย -->
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

                <!-- สุขภาพ / การปลูกฝี / การฉีดยา -->
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

                <!-- วัคซีน / โรคติดต่อ / การเจ็บป่วยอื่นๆ -->
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

                <!-- แพ้ยา / หมายเหตุ -->
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
        </div> <!-- ปิด card-body -->
    </div> <!-- ปิด card -->
</div> <!-- ปิด container -->
</div>
  @if($checkbodies->isNotEmpty())
<!-- ตารางติดกับฟอร์ม -->
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
                    @forelse ($checkbodies as $index => $checkbody)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ \Carbon\Carbon::parse($checkbody->assessor_date)->format('d/m/Y') }}</td>
                            <td>{{ $checkbody->weight ?? '-' }}</td>
                            <td>{{ $checkbody->height ?? '-' }}</td>
                            <td>{{ $checkbody->health ?? '-' }}</td>
                            <td class="text-center">
                              <div class="d-flex justify-content-end gap-1">
                        <div class="d-flex justify-content-end me-3">
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
                                {{-- ฟอร์มลบแบบซ่อน --}}
                                <form id="delete-form-{{ $checkbody->id }}"
                                      action="{{ route('check_body.delete', $checkbody->id) }}"
                                      method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted small">
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
            $('#datatable-checkbody').DataTable({
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

    <!-- toggleDetail สำหรับฟิลด์พัฒนาการ -->
    <script>
        function toggleDetail(show) {
            document.getElementById('detailField').style.display = show ? 'block' : 'none';
        }
    </script>

        <!-- Script toggle ซ่อน/แสดง form สุขภาพ -->
        <script>
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
            });
        </script>


@endpush