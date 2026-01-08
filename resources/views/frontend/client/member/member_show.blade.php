@extends('admin_client.admin_client')
@section('content')

<h5 class="mb-3 text-center fw-bold mt-4" style="color:#0d47a1;">
    บันทึกสมาชิกในครอบครัว
</h5>

<!-- ปุ่มจัดการ + ข้อมูล client -->
<div class="d-flex justify-content-between align-items-center mb-3 p-2 border rounded shadow-sm bg-light">
    <!-- ฝั่งซ้าย: ชื่อ-นามสกุล และอายุ -->
    <div>
        <span class="fw-bold text-primary">
            <i class="bi bi-person-circle me-1"></i>
            {{ $client->fullname }} 
        </span>
        <span class="text-muted ms-2">
            อายุ {{ $client->age }} ปี
        </span>
    </div>

    <!-- ฝั่งขวา: ปุ่มจัดการ -->
    <div class="d-flex gap-2">
        @if($members->count() > 0)
            <a href="{{ route('member.edit', $client->id) }}" 
               class="btn btn-sm btn-outline-primary">
                <i class="bi bi-pencil-square me-1"></i> แก้ไขข้อมูล
            </a>
        @else
            <a href="{{ route('member.create', $client->id) }}" 
               class="btn btn-sm btn-outline-success">
                <i class="bi bi-plus-circle me-1"></i> เพิ่มข้อมูล
            </a>
        @endif
    </div>
</div>

<div class="table-responsive">
    <table class="table table-bordered table-sm align-middle text-center">
        <thead class="table-secondary">
            <tr>
                <th style="width: 15%">ชื่อ-นามสกุล</th>
                <th style="width: 7%">อายุ</th>
                <th style="width: 14%">การศึกษา</th>
                <th style="width: 10%">เกี่ยวข้องเป็น</th>
                <th style="width: 14%">อาชีพ</th>
                <th style="width: 13%">รายได้</th>
                <th style="width: 13%">หมายเหตุ</th>
            </tr>
        </thead>
        <tbody>
            @forelse($members as $member)
                <tr>
                    <td class="text-start">{{ $member->fullname }}</td>
                    <td>{{ $member->member_age }}</td>
                    <td>{{ $member->education->education_name ?? '-' }}</td>
                    <td>{{ $member->relationship }}</td>
                    <td>{{ $member->occupation->occupation_name ?? '-' }}</td>
                    <td>{{ $member->income->income_name ?? '-' }}</td>
                    <td class="text-start">{{ $member->remark }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">ยังไม่มีข้อมูลสมาชิก</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection