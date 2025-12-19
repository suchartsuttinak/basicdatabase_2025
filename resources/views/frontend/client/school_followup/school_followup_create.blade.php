@extends('admin_client.admin_client')
@section('content')

<div class="container-fluid mt-4">
 <form action="{{ route('school_followup_store') }}" method="POST">


        @csrf
        <input type="hidden" name="client_id" value="{{ $client->id }}">
        <input type="hidden" name="education_record_id" value="{{ optional($educationRecord)->id ?? '' }}">
        <input type="hidden" name="follo_no" value="{{ old('follo_no', 1) }}">

        {{-- 🏫 หัวฟอร์ม --}}
        <div class="mb-4 text-center">
            <h4 class="fw-bold text-dark">
                <i class="bi bi-journal-text me-2"></i> บันทึกติดตามผลการศึกษาเด็กในโรงเรียน
            </h4>
        </div>

        {{-- 🔒 Layout 2 คอลัมน์ ติดกัน --}}
        <div class="row g-0">
            {{-- คอลัมน์ซ้าย: ข้อมูลเด็ก --}}
           <div class="col-md-3">
    <div class="card shadow-sm rounded-0 border-0 h-100">
        <div class="card-header bg-light fw-bold text-dark">
            <i class="bi bi-person-lines-fill me-2"></i> ข้อมูลเด็ก
        </div>
        <div class="card-body bg-white">
            <div class="row mb-2">
                <div class="col-5 fw-bold text-dark">
                    <i class="bi bi-person-fill text-primary me-2"></i>ชื่อ-นามสกุล:
                </div>
                <div class="col-7">{{ $client->full_name }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-5 fw-bold text-dark">
                    <i class="bi bi-calendar3 text-primary me-2"></i>อายุ:
                </div>
                <div class="col-7">{{ $client->age }} ปี</div>
            </div>
            <div class="row mb-2">
                <div class="col-5 fw-bold text-dark">
                    <i class="bi bi-building text-primary me-2"></i>สถานศึกษา:
                </div>
                <div class="col-7">{{ optional($educationRecord)->school_name ?? 'ไม่พบข้อมูล' }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-5 fw-bold text-dark">
                    <i class="bi bi-mortarboard text-primary me-2"></i>ระดับชั้น:
                </div>
                <div class="col-7">{{ optional(optional($educationRecord)->education)->education_name ?? 'ไม่พบข้อมูล' }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-5 fw-bold text-dark">
                    <i class="bi bi-mortarboard text-primary me-2"></i>ภาคเรียน:
                </div>
                <div class="col-7">{{ $educationRecord->semester ?? 'ไม่พบข้อมูล' }}</div>
            </div>
        </div>
    </div>
</div>

            {{-- คอลัมน์ขวา: ข้อมูลการติดตาม --}}
            <div class="col-md-9">
                <div class="card shadow-sm rounded-0 border-0 h-100">
                    <div class="card-header bg-light fw-bold text-dark">
                        <i class="bi bi-clipboard-check me-2"></i> ข้อมูลการติดตาม
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold">วันที่ติดตาม</label>
                                <input type="date" name="follow_date" class="form-control" value="{{ old('follow_date') }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">ชื่อ-สกุล ครูประจำชั้น</label>
                                <input type="text" name="teacher_name" class="form-control" value="{{ old('teacher_name') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">โทรศัพท์</label>
                                <input type="text" name="tel" class="form-control" value="{{ old('tel') }}">
                            </div>
                        </div>

                        <div class="mt-3">
                            <label class="form-label fw-bold">การดำเนินงาน</label>
                            <div class="d-flex flex-wrap">
                                <div class="form-check me-3">
                                    <input class="form-check-input" type="radio" name="follow_type" value="self" {{ old('follow_type') == 'self' ? 'checked' : '' }}>
                                    <label class="form-check-label">ติดตามด้วยตนเอง</label>
                                </div>
                                <div class="form-check me-3">
                                    <input class="form-check-input" type="radio" name="follow_type" value="phone" {{ old('follow_type') == 'phone' ? 'checked' : '' }}>
                                    <label class="form-check-label">โทรศัพท์</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="follow_type" value="other" {{ old('follow_type') == 'other' ? 'checked' : '' }}>
                                    <label class="form-check-label">อื่นๆ</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mt-3">
                                <label class="form-label fw-bold">ผลการติดตาม</label>
                                <textarea name="result" class="form-control" rows="2">{{ old('result') }}</textarea>
                            </div>
                            <div class="col-md-6 mt-3">
                                <label class="form-label fw-bold">หมายเหตุ</label>
                                <textarea name="remark" class="form-control" rows="2">{{ old('remark') }}</textarea>
                            </div>
                        </div>

                      <div class="row">
                            {{-- ช่องกรอกชื่อผู้ติดตาม --}}
                            <div class="col-md-6 mt-3">
                                <label class="form-label fw-bold">ชื่อ-สกุล ผู้ติดตาม</label>
                                <input type="text" name="contact_name" class="form-control" value="{{ old('contact_name') }}">
                            </div>

                            {{-- ✅ ปุ่มบันทึก: อยู่ชิดขวาและแนวเดียวกัน --}}
                            <div class="col-md-6 mt-3 d-flex justify-content align-items-end">
                                <button type="submit" class="btn btn-success px-4">
                                    <i class="bi bi-save me-1"></i> บันทึกผล
                                </button>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
        </div>  
    </form>
</div>


<div class="card mt-4 shadow-sm">
    <div class="card-body">
        <table id="datatable-followup" class="table table-bordered dt-responsive table-responsive nowrap w-100">
            <thead class="table-primary text-center">
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
            <tbody>
                @forelse ($followups as $index => $followup)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($followup->follow_date)->format('d/m/Y') }}</td>
                        <td>{{ $followup->teacher_name }}</td>
                        <td>{{ $followup->tel }}</td>
                        <td>
                            @switch($followup->follow_type)
                                @case('self') ติดตามด้วยตนเอง @break
                                @case('phone') โทรศัพท์ @break
                                @case('other') อื่นๆ @break
                                @default -
                            @endswitch
                        </td>
                        <td>{{ $followup->result }}</td>
                        <td>{{ optional($followup->educationRecord)->school_name ?? 'ไม่พบข้อมูล' }}</td>
                        <td>{{ optional(optional($followup->educationRecord)->education)->education_name ?? 'ไม่พบข้อมูล' }}</td>
                        <td class="text-center">
                            <a href="{{ route('school_followup.edit', $followup->id) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil-square"></i> แก้ไข
                            </a>
                            <form action="{{ route('school_followup.delete', $followup->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('ยืนยันการลบข้อมูลนี้?')">
                                    <i class="bi bi-trash"></i> ลบ
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted">ยังไม่มีข้อมูลการติดตาม</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
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
@endpush