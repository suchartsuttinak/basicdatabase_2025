@extends('admin.admin_master')

@section('admin')

<div class="page-content">

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-white border-0 py-3">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                <div>
                    <h4 class="mb-1 fw-bold text-primary">
                        <i class="bi bi-house-door me-1"></i> จัดการย้ายบ้านเด็ก
                    </h4>
                    <div class="text-muted small">
                        เปลี่ยนบ้านปัจจุบันของเด็ก โดยระบบจะอัปเดตไปที่ข้อมูลเด็กโดยตรง
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success rounded-3">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('info'))
                <div class="alert alert-info rounded-3">
                    {{ session('info') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger rounded-3">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger rounded-3">
                    <div class="fw-semibold mb-1">กรุณาตรวจสอบข้อมูล</div>
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="table-responsive">
                <table id="houseTransferTable" class="table table-hover align-middle w-100">
                    <thead class="table-light">
                        <tr>
                            <th width="60">#</th>
                            <th>ชื่อ-สกุลเด็ก</th>
                            <th>บ้านปัจจุบัน</th>
                            <th>หน่วยงาน</th>
                            <th>ผู้ดูแลบ้าน</th>
                            <th width="130" class="text-center">จัดการ</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($clients as $index => $client)
                            @php
                                $currentHouseId = $client->house_id;
                                $caregiverName = $caregivers[$currentHouseId] ?? '-';
                            @endphp

                            <tr>
                                <td>{{ $index + 1 }}</td>

                                <td>
                                    <div class="fw-semibold">
                                        {{ $client->fullname ?? (($client->first_name ?? '') . ' ' . ($client->last_name ?? '')) }}
                                    </div>
                                    <div class="text-muted small">
                                        เลขทะเบียน: {{ $client->register_number ?? '-' }}
                                    </div>
                                </td>

                                <td>
                                    @if($client->house)
                                        <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2">
                                            {{ $client->house->house_name ?? '-' }}
                                        </span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3 py-2">
                                            ยังไม่ระบุบ้าน
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    {{ auth()->user()->project?->name ?? '-' }}
                                </td>

                                <td>
                                    {{ $caregiverName }}
                                </td>

                                <td class="text-center">
                                    <button type="button"
                                            class="btn btn-sm btn-outline-primary rounded-pill px-3"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editHouseModal{{ $client->id }}">
                                        <i class="bi bi-pencil-square me-1"></i> แก้ไข
                                    </button>
                                </td>
                            </tr>

                            <div class="modal fade"
                                 id="editHouseModal{{ $client->id }}"
                                 tabindex="-1"
                                 aria-labelledby="editHouseModalLabel{{ $client->id }}"
                                 aria-hidden="true">

                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 rounded-4 shadow">

                                        <form method="POST"
                                              action="{{ route('client-house-transfers.update', $client->id) }}"
                                              class="house-transfer-form">
                                            @csrf
                                            @method('PUT')

                                            <div class="modal-header border-0 pb-0">
                                                <div>
                                                    <h5 class="modal-title fw-bold text-primary"
                                                        id="editHouseModalLabel{{ $client->id }}">
                                                        <i class="bi bi-house-gear me-1"></i> แก้ไขบ้านเด็ก
                                                    </h5>
                                                    <div class="text-muted small">
                                                        ข้อมูลนี้จะอัปเดตไปยังตาราง clients โดยตรง
                                                    </div>
                                                </div>

                                                <button type="button"
                                                        class="btn-close"
                                                        data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                            </div>

                                            <div class="modal-body">

                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">ชื่อ-สกุลเด็ก</label>
                                                    <input type="text"
                                                           class="form-control rounded-3 bg-light"
                                                           value="{{ $client->fullname ?? (($client->first_name ?? '') . ' ' . ($client->last_name ?? '')) }}"
                                                           readonly>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">หน่วยงาน</label>
                                                    <input type="text"
                                                           class="form-control rounded-3 bg-light"
                                                           value="{{ auth()->user()->project?->name ?? '-' }}"
                                                           readonly>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">
                                                        บ้านที่ <span class="text-danger">*</span>
                                                    </label>

                                                    <select name="house_id"
                                                            class="form-select rounded-3 house-select"
                                                            data-client-id="{{ $client->id }}"
                                                            required>
                                                        <option value="">-- เลือกบ้าน --</option>

                                                        @foreach($houses as $house)
                                                            <option value="{{ $house->id }}"
                                                                {{ (string) old('house_id', $client->house_id) === (string) $house->id ? 'selected' : '' }}>
                                                                {{ $house->house_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">ชื่อผู้ดูแลในบ้านนั้น</label>
                                                    <input type="text"
                                                           id="caregiverName{{ $client->id }}"
                                                           class="form-control rounded-3 bg-light"
                                                           value="{{ $caregiverName }}"
                                                           readonly>
                                                </div>

                                                <div class="mb-0">
                                                    <label class="form-label fw-semibold">หมายเหตุ</label>
                                                    <textarea name="remark"
                                                              rows="3"
                                                              class="form-control rounded-3"
                                                              placeholder="ระบุหมายเหตุเพิ่มเติม ถ้ามี">{{ old('remark') }}</textarea>
                                                </div>

                                            </div>

                                            <div class="modal-footer border-0 pt-0">
                                                <button type="button"
                                                        class="btn btn-light rounded-pill px-4"
                                                        data-bs-dismiss="modal">
                                                    ยกเลิก
                                                </button>

                                                <button type="submit"
                                                        class="btn btn-primary rounded-pill px-4 btn-save-house">
                                                    <i class="bi bi-check-circle me-1"></i>
                                                    <span>บันทึกการย้ายบ้าน</span>
                                                </button>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">
                                    ยังไม่มีข้อมูลเด็ก
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const caregivers = @json($caregivers);

        document.querySelectorAll('.house-select').forEach(function (select) {
            select.addEventListener('change', function () {
                const clientId = this.dataset.clientId;
                const houseId = this.value;
                const target = document.getElementById('caregiverName' + clientId);

                if (target) {
                    target.value = caregivers[houseId] ?? '-';
                }
            });
        });

        document.querySelectorAll('.house-transfer-form').forEach(function (form) {
            form.addEventListener('submit', function () {
                const btn = form.querySelector('.btn-save-house');

                if (btn) {
                    btn.disabled = true;
                    btn.querySelector('span').textContent = 'กำลังบันทึก...';
                }
            });
        });

        if (typeof $ !== 'undefined' && $.fn.DataTable) {
            $('#houseTransferTable').DataTable({
                pageLength: 25,
                ordering: true,
                responsive: true,
                language: {
                    search: "ค้นหา:",
                    lengthMenu: "แสดง _MENU_ รายการ",
                    info: "แสดง _START_ ถึง _END_ จาก _TOTAL_ รายการ",
                    paginate: {
                        previous: "ก่อนหน้า",
                        next: "ถัดไป"
                    },
                    zeroRecords: "ไม่พบข้อมูล"
                }
            });
        }
    });
</script>
@endpush

@endsection