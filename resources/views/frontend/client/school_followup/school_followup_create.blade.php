@extends('admin_client.admin_client')
@section('content')

      <div class="container-fluid mt-4">
    <form action="{{ isset($followup) ? route('school_followup.update', $followup->id) : route('school_followup_store') }}" method="POST">
        @csrf
        @if(isset($followup))
            @method('PUT')
        @endif

        {{-- ✅ hidden fields --}}
        <input type="hidden" name="client_id" value="{{ $client->id }}">
        <input type="hidden" name="education_record_id" value="{{ optional($educationRecord)->id }}">

       {{-- 🏫 หัวฟอร์ม --}}
            <div class="mb-4 text-center">
                <h4 class="fw-bold text-dark">
                    <i class="bi bi-journal-text me-2"></i>
                    {{ isset($followup) ? 'แก้ไขการติดตามผลการศึกษาเด็กในโรงเรียน' : 'บันทึกติดตามผลการศึกษาเด็กในโรงเรียน' }}
                </h4>
            </div>

        {{-- 🔒 Layout 2 คอลัมน์ --}}
 <div class="row gx-1 gy-1 align-items-stretch">
    {{-- ✅ คอลัมน์ซ้าย: ข้อมูลเด็ก --}}
    <div class="col-md-3 d-flex">
        <div class="card shadow-sm rounded-1 border-0 h-100 flex-fill small ">
            <div class="card-header bg-light fw-bold text-dark py-1 px-2">
                <i class="bi bi-person-lines-fill me-2"></i> ข้อมูลเด็ก
            </div>
            <div class="card-body bg-white px-2 py-1">
                <div class="row mb-1">
                    <div class="col-5 fw-bold text-dark small">
                        <i class="bi bi-person-fill text-primary me-1"></i>ชื่อ-นามสกุล:
                    </div>
                    <div class="col-7 small">{{ $client->full_name }}</div>
                </div>
                <div class="row mb-1">
                    <div class="col-5 fw-bold text-dark small">
                        <i class="bi bi-calendar3 text-primary me-1"></i>อายุ:
                    </div>
                    <div class="col-7 small">{{ $client->age }} ปี</div>
                </div>
                <div class="row mb-1">
                    <div class="col-5 fw-bold text-dark small">
                        <i class="bi bi-building text-primary me-1"></i>สถานศึกษา:
                    </div>
                    <div class="col-7 small">{{ optional($educationRecord)->school_name ?? 'ไม่พบข้อมูล' }}</div>
                </div>
                <div class="row mb-1">
                    <div class="col-5 fw-bold text-dark small">
                        <i class="bi bi-mortarboard text-primary me-1"></i>ระดับชั้น:
                    </div>
                    <div class="col-7 small">{{ optional(optional($educationRecord)->education)->education_name ?? 'ไม่พบข้อมูล' }}</div>
                </div>
                <div class="row mb-1">
                    <div class="col-5 fw-bold text-dark small">
                        <i class="bi bi-mortarboard text-primary me-1"></i>ภาคเรียน:
                    </div>
                    <div class="col-7 small">{{ $educationRecord->semester ?? 'ไม่พบข้อมูล' }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ✅ คอลัมน์ขวา: ข้อมูลการติดตาม --}}
    <div class="col-md-9 d-flex">
        <div class="card shadow-sm rounded-1 border-0 h-100 flex-fill small">
            <div class="card-header bg-light fw-bold text-dark d-flex justify-content-between align-items-center py-1 px-2">
                <div><i class="bi bi-clipboard-check me-2"></i> ข้อมูลการติดตาม</div>
                @if(isset($followup))
                    <a href="{{ route('school_followup_add', $client->id) }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-plus-circle"></i> เพิ่มข้อมูล
                    </a>
                @endif
            </div>

            <div class="card-body px-2 py-1">
                <div class="row mb-1">
                    <div class="col-md-4">
                        <label class="form-label fw-bold small">วันที่ติดตาม</label>
                        <input type="date" name="follow_date" class="form-control form-control-sm"
                            value="{{ old('follow_date', $followup->follow_date ?? '') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold small">ชื่อ-สกุล ครูประจำชั้น</label>
                        <input type="text" name="teacher_name" class="form-control form-control-sm"
                            value="{{ old('teacher_name', $followup->teacher_name ?? '') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold small">โทรศัพท์</label>
                        <input type="text" name="tel" class="form-control form-control-sm"
                            value="{{ old('tel', $followup->tel ?? '') }}">
                    </div>
                </div>

                <div class="mt-2">
                    <label class="form-label fw-bold small">การดำเนินงาน</label>
                    <div class="d-flex flex-wrap small">
                        <div class="form-check me-3">
                            <input class="form-check-input" type="radio" name="follow_type" value="self"
                                {{ old('follow_type', $followup->follow_type ?? '') == 'self' ? 'checked' : '' }}>
                            <label class="form-check-label">ติดตามด้วยตนเอง</label>
                        </div>
                        <div class="form-check me-3">
                            <input class="form-check-input" type="radio" name="follow_type" value="phone"
                                {{ old('follow_type', $followup->follow_type ?? '') == 'phone' ? 'checked' : '' }}>
                            <label class="form-check-label">โทรศัพท์</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="follow_type" value="other"
                                {{ old('follow_type', $followup->follow_type ?? '') == 'other' ? 'checked' : '' }}>
                            <label class="form-check-label">อื่นๆ</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mt-2">
                        <label class="form-label fw-bold small">ผลการติดตาม</label>
                        <textarea name="result" class="form-control form-control-sm" rows="2">{{ old('result', $followup->result ?? '') }}</textarea>
                    </div>
                    <div class="col-md-6 mt-2">
                        <label class="form-label fw-bold small">หมายเหตุ</label>
                        <textarea name="remark" class="form-control form-control-sm" rows="2">{{ old('remark', $followup->remark ?? '') }}</textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mt-2">
                        <label class="form-label fw-bold small">ชื่อ-สกุล ผู้ติดตาม</label>
                        <input type="text" name="contact_name" class="form-control form-control-sm"
                            value="{{ old('contact_name', $followup->contact_name ?? '') }}">
                    </div>
                    <div class="col-md-6 mt-2 d-flex justify-content align-items-end">
                        <button type="submit" class="btn btn-sm btn-success px-3">
                            <i class="bi bi-save me-1"></i>
                            {{ isset($followup) ? 'อัปเดตข้อมูล' : 'บันทึกผล' }}
                        </button>
                    </div>
                </div>
            </div> {{-- end card-body --}}
        </div> {{-- end card --}}
    </div> {{-- end col-md-9 --}}
</div> {{-- end row --}}
</form>
</div>
           @if($followups->isNotEmpty())
<div class="card mt-2 shadow-sm rounded-1 border-0 ms-2 me-2">
    <div class="card-body p-2">
        <div class="table-responsive">
            <table id="datatable-followup" class="table table-sm table-striped table-hover align-middle w-100 mb-0">
                <thead class="table-primary text-center small">
                    <tr>
                        <th>ลำดับ</th>
                        <th>วันที่ติดตาม</th>
                        <th>ครูประจำชั้น</th>
                        <th>โทรศัพท์</th>
                        <th>การดำเนินงาน</th>
                        <th>ผลการติดตาม</th>
                        <th>สถานศึกษา</th>
                        <th>ระดับชั้น</th>
                        <th>จัดการ</th>
                    </tr>
                </thead>
                <tbody class="small">
                    @forelse ($followups as $index => $followup)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ \Carbon\Carbon::parse($followup->follow_date)->format('d/m/Y') }}</td>
                            <td>{{ $followup->teacher_name ?? '-' }}</td>
                            <td>{{ $followup->tel ?? '-' }}</td>
                            <td>
                                @switch($followup->follow_type)
                                    @case('self') ติดตามด้วยตนเอง @break
                                    @case('phone') โทรศัพท์ @break
                                    @case('other') อื่นๆ @break
                                    @default -
                                @endswitch
                            </td>
                            <td title="{{ $followup->result }}">
                                {{ \Illuminate\Support\Str::limit($followup->result ?? '-', 20) }}
                            </td>
                            <td>{{ optional($followup->educationRecord)->school_name ?? 'ไม่พบข้อมูล' }}</td>
                            <td>{{ optional(optional($followup->educationRecord)->education)->education_name ?? 'ไม่พบข้อมูล' }}</td>
                            <td class="text-center">
                              <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('school_followup.edit', $followup->id) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil-square"></i> แก้ไข
                                    </a>

                                    <button type="button" class="btn btn-sm btn-danger"
                                            onclick="confirmDelete({{ $followup->id }})">
                                        <i class="bi bi-trash"></i> ลบ
                                    </button>

                                    <a href="{{ route('school_followup.report', $followup->id) }}" class="btn btn-sm btn-info">
                                        <i class="bi bi-file-earmark-text"></i> รายงาน
                                    </a>
                                </div>

                                {{-- ฟอร์มลบแบบซ่อน --}}
                                <form id="delete-form-{{ $followup->id }}"
                                      action="{{ route('school_followup.delete', $followup->id) }}"
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
            $('#datatable-followup').DataTable({
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