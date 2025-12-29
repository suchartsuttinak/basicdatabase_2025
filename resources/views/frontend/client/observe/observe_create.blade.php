@extends('admin_client.admin_client')

@section('content')
    <div class="container-fluid mt-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-primary text-white py-2">
                <h5 class="mb-0 text-center">
                    แบบฟอร์มบันทึก/แก้ไขพฤติกรรมของ {{ $client->name }}
                </h5>
            </div>
            <div class="card-body p-3">

                <!-- Alert -->
                @if (session('success'))
                    <div class="alert alert-success text-center fw-bold">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <h6 class="fw-bold">พบข้อผิดพลาด:</h6>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- ฟอร์มบันทึกพฤติกรรม -->
                <form action="{{ isset($observe) ? route('observe.update', $observe->id) : route('observe.store') }}"
                    method="POST" class="needs-validation" novalidate>
                    @csrf
                    @if (isset($observe))
                        @method('PUT')
                    @endif

                    <input type="hidden" name="client_id" value="{{ $client->id }}">

                    <!-- วันที่ -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="date" class="form-label fw-bold">วันที่เกิดเหตุ</label>
                            <input type="date" name="date" id="date" class="form-control"
                                value="{{ old('date', $observe->date ?? '') }}" required>
                        </div>
                        <div class="col-md-4">
                            <label for="record_date" class="form-label fw-bold">วันที่บันทึก</label>
                            <input type="date" name="record_date" id="record_date" class="form-control"
                                value="{{ old('record_date', $observe->record_date ?? '') }}">
                        </div>
                        <div class="col-md-4">
                            <label for="recorder" class="form-label fw-bold">ผู้บันทึก</label>
                            <input type="text" name="recorder" id="recorder" class="form-control"
                                value="{{ old('recorder', $observe->recorder ?? '') }}" placeholder="ชื่อผู้บันทึก">
                        </div>
                    </div>

                    <!-- พฤติกรรม/สาเหตุ/วิธีแก้ไข -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="behavior" class="form-label fw-bold">พฤติกรรม</label>
                            <textarea name="behavior" id="behavior" class="form-control" rows="2">{{ old('behavior', $observe->behavior ?? '') }}</textarea>
                        </div>
                        <div class="col-md-4">
                            <label for="cause" class="form-label fw-bold">สาเหตุ</label>
                            <textarea name="cause" id="cause" class="form-control" rows="2">{{ old('cause', $observe->cause ?? '') }}</textarea>
                        </div>
                        <div class="col-md-4">
                            <label for="solution" class="form-label fw-bold">วิธีแก้ไข</label>
                            <textarea name="solution" id="solution" class="form-control" rows="2">{{ old('solution', $observe->solution ?? '') }}</textarea>
                        </div>
                    </div>

                    <!-- การดำเนินการ/อุปสรรค/ผลลัพธ์ -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="action" class="form-label fw-bold">การดำเนินการ</label>
                            <textarea name="action" id="action" class="form-control" rows="2">{{ old('action', $observe->action ?? '') }}</textarea>
                        </div>
                        <div class="col-md-4">
                            <label for="obstacles" class="form-label fw-bold">อุปสรรค</label>
                            <textarea name="obstacles" id="obstacles" class="form-control" rows="2">{{ old('obstacles', $observe->obstacles ?? '') }}</textarea>
                        </div>
                        <div class="col-md-4">
                            <label for="result" class="form-label fw-bold">ผลลัพธ์</label>
                            <textarea name="result" id="result" class="form-control" rows="2">{{ old('result', $observe->result ?? '') }}</textarea>
                        </div>
                    </div>

                    <!-- พฤติกรรมที่ผิด -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="misbehavior_id" class="form-label fw-bold">พฤติกรรมที่ผิด</label>
                            <select name="misbehavior_id" id="misbehavior_id" class="form-select" required>
                                <option value="">-- เลือกพฤติกรรมที่ผิด --</option>
                                @foreach ($misbehaviors as $m)
                                    <option value="{{ $m->id }}"
                                        {{ old('misbehavior_id', $observe->misbehavior_id ?? '') == $m->id ? 'selected' : '' }}>
                                        {{ $m->misbehavior_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <!-- ปุ่มบันทึก -->
                        <div class="text-center mt-4 col-2">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-save"></i> {{ isset($observe) ? 'อัปเดตข้อมูล' : 'บันทึกข้อมูล' }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- ตารางแสดงผล -->
    <div class="card mt-5 shadow-sm">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0">รายการพฤติกรรมที่บันทึก</h5>
        </div>
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>วันที่</th>
                        <th>พฤติกรรม</th>
                        <th>ผลลัพธ์</th>
                        <th>ผู้บันทึก</th>
                        <th>การติดตามผล</th>
                        <th class="text-center">จัดการ</th>
                    </tr>
                </thead>
<tbody>
    @forelse($observes as $obs)
        <tr>
            <td>{{ $obs->date }}</td>
            <td>{{ $obs->behavior }}</td>
            <td>{{ $obs->result }}</td>
            <td>{{ $obs->recorder }}</td>
            <td>
                @forelse($obs->followups as $f)
                    <div>
                        {{ $f->followup_date }} (ครั้งที่ {{ $f->followup_count }}) -
                        {{ $f->followup_result }}
                    </div>
                @empty
                    <span class="text-muted">ยังไม่มีการติดตามผล</span>
                @endforelse
            </td>

            <td class="text-center">
                <!-- ปุ่มแก้ไขพฤติกรรม -->
                <a href="{{ route('observe.edit', $obs->id) }}" class="btn btn-sm btn-warning">แก้ไข</a>

                <!-- ปุ่มลบพฤติกรรม -->
                <form action="{{ route('observe.delete', $obs->id) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger"
                        onclick="return confirm('ยืนยันการลบ?')">ลบ</button>
                </form>

                <!-- ปุ่มติดตามผล -->
                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal"
                    data-bs-target="#addFollowupModal{{ $obs->id }}">
                    ติดตามผล
                </button>

    <!-- Modal สำหรับเพิ่มการติดตามผล -->
    <div class="modal fade" id="addFollowupModal{{ $obs->id }}" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-sm">

                <!-- Header -->
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title fw-bold">
                        <i class="bi bi-plus-circle me-1"></i> เพิ่มการติดตามผล (พฤติกรรมวันที่
                        {{ $obs->date }})
                    </h5>
                    <button type="button" class="btn-close btn-close-white"
                        data-bs-dismiss="modal"></button>
                </div>

                <!-- Body -->
                <div class="modal-body">
                    <form action="{{ route('followup.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="observe_id" value="{{ $obs->id }}">

                        <!-- วันที่ติดตาม -->
                        <div class="mb-3 col-6">
                            <label class="form-label fw-bold">วันที่ติดตาม</label>
                            <input type="date" name="followup_date"
                                class="form-control form-control-sm" required>
                        </div>

                        <!-- ครั้งที่ -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">ครั้งที่</label>
                            <input type="number" name="followup_count"
                                class="form-control form-control-sm" min="1" required>
                        </div>

                        <!-- การดำเนินการ -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">การดำเนินการ</label>
                            <textarea name="followup_action" class="form-control form-control-sm" rows="2"></textarea>
                        </div>

                        <!-- ผลลัพธ์ -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">ผลลัพธ์</label>
                            <textarea name="followup_result" class="form-control form-control-sm" rows="2"></textarea>
                        </div>

                        <!-- Footer -->
                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="bi bi-save me-1"></i> บันทึกการติดตามผล
                            </button>
                            <button type="button" class="btn btn-secondary btn-sm"
                                data-bs-dismiss="modal">
                                <i class="bi bi-x-circle me-1"></i> ปิด
                            </button>
                        </div>
                    </form>
                </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="6" class="text-center text-muted">ยังไม่มีบันทึกพฤติกรรม</td>
        </tr>
    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- ถ้าต้องการ loop ทุก observe
        ถ้ามี followup อยู่แล้ว ให้แสดงปุ่มแก้ไข -->
            {{-- @foreach ($observes as $obs)
                @foreach ($obs->followups as $f)
                    <!-- ปุ่มเปิด Modal แก้ไข -->
                    <button type="button" class="btn btn-sm btn-secondary mt-1" data-bs-toggle="modal"
                        data-bs-target="#editFollowupModal{{ $f->id }}">
                        แก้ไขติดตามผลครั้งที่ {{ $f->followup_count }}
                    </button> --}}


    <!-- ถ้าต้องการใช้ observe เดียว (เช่นหน้าแก้ไข)-->
    @if($observe)
        @foreach($observe->followups as $f)
            <button type="button" class="btn btn-sm btn-secondary mt-1"
                    data-bs-toggle="modal" data-bs-target="#editFollowupModal{{ $f->id }}">
                แก้ไขติดตามผลครั้งที่ {{ $f->followup_count }}
            </button>
            <!-- Modal สำหรับแก้ไขการติดตามผล -->
            <div class="modal fade" id="editFollowupModal{{ $f->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content border-0 shadow-lg">

                        <!-- Header -->
                        <div class="modal-header bg-warning text-dark">
                            <h5 class="modal-title fw-bold">
                                <i class="bi bi-pencil-square me-1"></i> แก้ไขการติดตามผล (ครั้งที่
                                {{ $f->followup_count }})
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <!-- Body -->
                        <div class="modal-body">
                            <!-- ฟอร์มอัปเดต -->
                            <form action="{{ route('followup.update', $f->id) }}" method="POST"
                                class="needs-validation" novalidate>
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="observe_id" value="{{ $obs->id }}">

                                <!-- วันที่ และ ครั้งที่ -->
                                <div class="row mb-3">
                                    <div class="col-6 col-md-3">
                                        <label class="form-label fw-bold text-start w-100 small">วันที่ติดตาม</label>
                                        <input type="date" name="followup_date" class="form-control form-control-sm"
                                            value="{{ old('followup_date', $f->followup_date) }}" required>
                                    </div>
                                    <div class="col-6 col-md-2">
                                        <label class="form-label fw-bold text-start w-100 small">ครั้งที่</label>
                                        <input type="number" name="followup_count" class="form-control form-control-sm"
                                            min="1" value="{{ old('followup_count', $f->followup_count) }}"
                                            required>
                                    </div>
                                </div>

                                <!-- การดำเนินการ -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-start w-100">การดำเนินการ</label>
                                    <textarea name="followup_action" class="form-control form-control-sm" rows="2">{{ old('followup_action', $f->followup_action) }}</textarea>
                                </div>

                                <!-- ผลลัพธ์ -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-start w-100">ผลลัพธ์</label>
                                    <textarea name="followup_result" class="form-control form-control-sm" rows="2">{{ old('followup_result', $f->followup_result) }}</textarea>
                                </div>

                                <!-- Footer -->
                                <div class="modal-footer d-flex justify-content-between">
                                    <!-- ปุ่มลบ -->


                                    <!-- ปุ่มอัปเดต -->
                                    <button type="submit" class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil-square me-1"></i> อัปเดตการติดตามผล
                                    </button>
                                </div>
                            </form>
                            <!-- ปุ่มลบ -->
                            <div class="d-flex justify-content-end">
                                <form action="{{ route('followup.delete', $f->id) }}" method="POST"
                                    onsubmit="return confirm('ยืนยันการลบการติดตามผล?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                        <i class="bi bi-trash me-1"></i> ลบการติดตามผล
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @endforeach
    @endif

    @if (isset($observe))
        <div class="card mt-4 shadow-sm">
            <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">รายการติดตามผล</h5>
                <!-- ปุ่มเพิ่มการติดตามผล -->
                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                    data-bs-target="#addFollowupModal{{ $observe->id }}">
                    + เพิ่มการติดตามผล
                </button>
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>วันที่ติดตาม</th>
                            <th>ครั้งที่</th>
                            <th>การดำเนินการ</th>
                            <th>ผลลัพธ์</th>
                            <th class="text-center">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($observe->followups as $f)
                            <tr>
                                <td>{{ $f->followup_date }}</td>
                                <td>{{ $f->followup_count }}</td>
                                <td>{{ $f->followup_action }}</td>
                                <td>{{ $f->followup_result }}</td>
                                <td class="text-center">
                                    <!-- ปุ่มแก้ไข เปิด modal -->
                                    <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#editFollowupModal{{ $f->id }}">
                                        แก้ไข
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">ยังไม่มีการติดตามผล</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection
