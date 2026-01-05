@extends('admin_client.admin_client')
@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<form action="{{ route('member.update', $client->id) }}" method="POST">
    @csrf
    @method('PUT') <!-- ใช้ PUT สำหรับการแก้ไข -->
    <input type="hidden" name="client_id" value="{{ $client->id }}">

    <!-- ข้อมูลผู้รับบริการ -->
    <div class="container-fluid mb-3 mt-3">
        <h6 class="fw-bold text-dark mb-2">ข้อมูลผู้รับบริการ</h6>
        <div class="d-flex flex-wrap align-items-center mt-2">
            <div class="me-4">
                <label class="fw-semibold text-secondary">ชื่อ - สกุล :</label>
                <span class="text-dark">{{ $client->fullname }}</span>
            </div>
            <div>
                <label class="fw-semibold text-secondary">อายุ :</label>
                <span class="text-dark">{{ $client->age }} ปี</span>
            </div>
        </div>
    </div>

    <!-- สมาชิกครอบครัว -->
    <div class="mb-3">
        <h6 class="fw-bold text-secondary mb-2">รายละเอียดสมาชิกในครอบครัว</h6>
        <table class="table table-bordered table-sm align-middle text-sm">
            <thead class="table-light">
                <tr class="text-center">
                    <th style="width:15%">ชื่อ - สกุล</th>
                    <th style="width:7%">อายุ</th>
                    <th style="width:15%">การศึกษา</th>
                    <th style="width:15%">ความสัมพันธ์กับผู้รับ</th>
                    <th style="width:15%">อาชีพ</th>
                    <th style="width:15%">รายได้เฉลี่ย/เดือน</th>
                    <th style="width:12%">หมายเหตุ</th>
                    <th style="width:6%">ลบ</th>
                </tr>
            </thead>
            <tbody id="member-container">
                @forelse($client->members as $i => $fam)
                <tr class="member-item" data-index="{{ $i }}">
                    <td><input type="text" name="members[{{ $i }}][fullname]"
                               value="{{ $fam->fullname }}"
                               class="form-control form-control-sm" required></td>
                    <td><input type="number" name="members[{{ $i }}][member_age]"
                               value="{{ $fam->member_age }}"
                               class="form-control form-control-sm" min="0"></td>
                    <td>
                        <select name="members[{{ $i }}][education_id]" class="form-select form-select-sm">
                            <option value="">-- เลือก --</option>
                            @foreach($educations as $edu)
                                <option value="{{ $edu->id }}"
                                    {{ $fam->education_id == $edu->id ? 'selected' : '' }}>
                                    {{ $edu->education_name }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="text" name="members[{{ $i }}][relationship]"
                               value="{{ $fam->relationship }}"
                               class="form-control form-control-sm"></td>
                    <td>
                        <select name="members[{{ $i }}][occupation_id]" class="form-select form-select-sm">
                            <option value="">-- เลือก --</option>
                            @foreach($occupations as $occ)
                                <option value="{{ $occ->id }}"
                                    {{ $fam->occupation_id == $occ->id ? 'selected' : '' }}>
                                    {{ $occ->occupation_name }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select name="members[{{ $i }}][income_id]" class="form-select form-select-sm">
                            <option value="">-- เลือก --</option>
                            @foreach($incomes as $inc)
                                <option value="{{ $inc->id }}"
                                    {{ $fam->income_id == $inc->id ? 'selected' : '' }}>
                                    {{ $inc->income_name }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="text" name="members[{{ $i }}][remark]"
                               value="{{ $fam->remark }}"
                               class="form-control form-control-sm"></td>
                    <td class="text-center">
                        <button type="button" class="btn btn-outline-danger btn-sm remove-member">
                            <i class="bi bi-x-circle-fill"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-muted">ยังไม่มีข้อมูลสมาชิกครอบครัว</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- ปุ่ม -->
    <div class="d-flex justify-content-between align-items-center mt-3">
        <button type="button" class="btn btn-outline-secondary btn-sm" id="add-member">
            <i class="bi bi-plus-circle me-1"></i> เพิ่มสมาชิก
        </button>
        <button type="submit" class="btn btn-primary btn-sm">
            <i class="bi bi-pencil-square me-1"></i> แก้ไขข้อมูล
        </button>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('member-container');
    const addBtn = document.getElementById('add-member');

    addBtn.addEventListener('click', function() {
        let index = container.querySelectorAll('.member-item').length;

        let html = `
            <tr class="member-item">
                <td><input type="text" name="members[${index}][fullname]" class="form-control form-control-sm" required></td>
                <td><input type="number" name="members[${index}][member_age]" class="form-control form-control-sm" min="0"></td>
                <td>
                    <select name="members[${index}][education_id]" class="form-select form-select-sm">
                        <option value="">-- เลือก --</option>
                        @foreach($educations as $edu)
                            <option value="{{ $edu->id }}">{{ $edu->education_name }}</option>
                        @endforeach
                    </select>
                </td>
                <td><input type="text" name="members[${index}][relationship]" class="form-control form-control-sm"></td>
                <td>
                    <select name="members[${index}][occupation_id]" class="form-select form-select-sm">
                        <option value="">-- เลือก --</option>
                        @foreach($occupations as $occ)
                            <option value="{{ $occ->id }}">{{ $occ->occupation_name }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <select name="members[${index}][income_id]" class="form-select form-select-sm">
                        <option value="">-- เลือก --</option>
                        @foreach($incomes as $inc)
                            <option value="{{ $inc->id }}">{{ $inc->income_name }}</option>
                        @endforeach
                    </select>
                </td>
                <td><input type="text" name="members[${index}][remark]" class="form-control form-control-sm"></td>
                <td class="text-center">
                    <button type="button" class="btn btn-outline-danger btn-sm remove-member">
                        <i class="bi bi-x-circle-fill"></i>
                    </button>
                </td>
            </tr>
        `;
        container.insertAdjacentHTML('beforeend', html);
    });

    container.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-member') || e.target.closest('.remove-member')) {
            e.target.closest('.member-item').remove();
        }
    });
});
</script>
@endsection