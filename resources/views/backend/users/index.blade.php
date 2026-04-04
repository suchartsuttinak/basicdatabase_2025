@extends('admin.admin_master')
@section('admin')


<div class="container-fluid py-3 user-page">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <div>
            <h2 class="mb-1 fw-bold user-page-title">จัดการผู้ใช้งานและกำหนดสิทธิ์</h2>
            <div class="text-muted user-page-subtitle">บริหารบัญชีผู้ใช้งาน สิทธิ์การเข้าถึง และสถานะการใช้งานของระบบ</div>
        </div>

        <a href="{{ route('users.create') }}" class="btn btn-primary user-main-btn">
            <i class="bi bi-person-plus-fill me-1"></i> เพิ่มผู้ใช้งาน
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-3 mb-4">
        <div class="col-6 col-md-4 col-xl-2">
            <div class="user-stat-card">
                <div class="user-stat-icon bg-primary-subtle text-primary">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div class="user-stat-number">{{ $stats['total'] }}</div>
                <div class="user-stat-label">ผู้ใช้ทั้งหมด</div>
            </div>
        </div>

        <div class="col-6 col-md-4 col-xl-2">
            <div class="user-stat-card">
                <div class="user-stat-icon bg-success-subtle text-success">
                    <i class="bi bi-person-check-fill"></i>
                </div>
                <div class="user-stat-number">{{ $stats['active'] }}</div>
                <div class="user-stat-label">กำลังใช้งาน</div>
            </div>
        </div>

        <div class="col-6 col-md-4 col-xl-2">
            <div class="user-stat-card">
                <div class="user-stat-icon bg-danger-subtle text-danger">
                    <i class="bi bi-shield-lock-fill"></i>
                </div>
                <div class="user-stat-number">{{ $stats['admin'] }}</div>
                <div class="user-stat-label">ผู้ดูแลระบบ</div>
            </div>
        </div>

        <div class="col-6 col-md-4 col-xl-2">
            <div class="user-stat-card">
                <div class="user-stat-icon bg-warning-subtle text-warning">
                    <i class="bi bi-briefcase-fill"></i>
                </div>
                <div class="user-stat-number">{{ $stats['executive'] }}</div>
                <div class="user-stat-label">ผู้บริหาร</div>
            </div>
        </div>

        <div class="col-6 col-md-4 col-xl-2">
            <div class="user-stat-card">
                <div class="user-stat-icon bg-info-subtle text-info">
                    <i class="bi bi-heart-pulse-fill"></i>
                </div>
                <div class="user-stat-number">{{ $stats['social_worker'] }}</div>
                <div class="user-stat-label">นักสังคมสงเคราะห์</div>
            </div>
        </div>

        <div class="col-6 col-md-4 col-xl-2">
            <div class="user-stat-card">
                <div class="user-stat-icon bg-secondary-subtle text-secondary">
                    <i class="bi bi-mortarboard-fill"></i>
                </div>
                <div class="user-stat-number">{{ $stats['teacher_caregiver'] }}</div>
                <div class="user-stat-label">ครู/ผู้ดูแล</div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm user-table-card">
        <div class="card-header bg-white border-0 py-3 px-3 px-lg-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <h5 class="mb-1 fw-bold">รายการผู้ใช้งาน</h5>
                    <div class="text-muted small">จัดการข้อมูลบัญชีผู้ใช้งานในระบบ</div>
                </div>
                <div class="small text-muted">
                    จำนวน {{ $users->count() }} รายการ
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="user-table-wrap">
                <div class="table-responsive">
                    <table id="usersTable" class="table align-middle mb-0 user-modern-table">
                        <thead>
                            <tr>
                                <th style="width: 70px;">รูป</th>
                                <th>ชื่อ</th>
                                <th>อีเมล</th>
                                <th>เบอร์โทร</th>
                                <th>สิทธิ์</th>
                                <th>สถานะ</th>
                                <th>วันที่สร้าง</th>
                                <th class="text-center" style="width: 220px;">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $item)
                                @php
                                    $roleClass = match($item->role) {
                                        'admin' => 'bg-danger-subtle text-danger border-danger-subtle',
                                        'manager' => 'bg-primary-subtle text-primary border-primary-subtle',
                                        'executive' => 'bg-warning-subtle text-warning border-warning-subtle',
                                        'social_worker' => 'bg-success-subtle text-success border-success-subtle',
                                        'teacher_caregiver' => 'bg-info-subtle text-info border-info-subtle',
                                        default => 'bg-secondary-subtle text-secondary border-secondary-subtle',
                                    };
                                @endphp

                                <tr>
                                    <td>
                                        <img src="{{ $item->photo_url }}" alt="user-photo" class="user-avatar-table">
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-dark">{{ $item->name }}</div>
                                        <div class="small text-muted">ID: {{ $item->id }}</div>
                                    </td>
                                    <td>
                                        <div class="text-break">{{ $item->email }}</div>
                                    </td>
                                    <td>{{ $item->phone ?? '-' }}</td>
                                    <td>
                                        <span class="badge rounded-pill px-3 py-2 border {{ $roleClass }}">
                                            {{ $item->role_label }}
                                        </span>
                                    </td>
                                    <td>
                                        @if((string)$item->status === '1')
                                            <span class="badge rounded-pill bg-success-subtle text-success border border-success-subtle px-3 py-2">
                                                ใช้งาน
                                            </span>
                                        @else
                                            <span class="badge rounded-pill bg-danger-subtle text-danger border border-danger-subtle px-3 py-2">
                                                ปิดใช้งาน
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ optional($item->created_at)->format('d/m/Y') ?? '-' }}
                                    </td>
                                    <td>
                                        <div class="user-action-group">
                                            <a href="{{ route('users.edit', $item->id) }}" class="btn btn-sm btn-warning user-action-btn">
                                                <i class="bi bi-pencil-square"></i>
                                                <span>แก้ไข</span>
                                            </a>

                                            <form action="{{ route('users.toggleStatus', $item->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-info user-action-btn text-white"
                                                    onclick="return confirm('ยืนยันการเปลี่ยนสถานะผู้ใช้งานนี้หรือไม่ ?')">
                                                    <i class="bi bi-arrow-repeat"></i>
                                                    <span>สถานะ</span>
                                                </button>
                                            </form>

                                            <form action="{{ route('users.delete', $item->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger user-action-btn"
                                                    onclick="return confirm('ยืนยันการลบผู้ใช้งานนี้หรือไม่ ?')">
                                                    <i class="bi bi-trash"></i>
                                                    <span>ลบ</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.user-page{
    --user-primary: #2563eb;
    --user-dark: #0f172a;
    --user-muted: #64748b;
    --user-border: #e2e8f0;
    --user-soft: #f8fafc;
}

.user-page-title{
    color: var(--user-dark);
    font-size: 1.55rem;
    letter-spacing: -.02em;
}

.user-page-subtitle{
    font-size: .95rem;
}

.user-main-btn{
    border-radius: 12px;
    padding: .72rem 1rem;
    font-weight: 600;
    box-shadow: 0 10px 25px rgba(37,99,235,.18);
}

.user-stat-card{
    background: #fff;
    border: 1px solid var(--user-border);
    border-radius: 18px;
    padding: 1rem;
    height: 100%;
    box-shadow: 0 8px 24px rgba(15,23,42,.05);
    transition: .2s ease;
}

.user-stat-card:hover{
    transform: translateY(-2px);
    box-shadow: 0 14px 30px rgba(15,23,42,.08);
}

.user-stat-icon{
    width: 46px;
    height: 46px;
    border-radius: 14px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    margin-bottom: .8rem;
}

.user-stat-number{
    font-size: 1.5rem;
    font-weight: 800;
    color: var(--user-dark);
    line-height: 1;
    margin-bottom: .35rem;
}

.user-stat-label{
    color: var(--user-muted);
    font-size: .92rem;
    font-weight: 500;
}

.user-table-card{
    border-radius: 20px;
    overflow: hidden;
}

.user-table-wrap{
    padding: 0;
}

.user-modern-table{
    min-width: 1100px;
}

.user-modern-table thead th{
    background: #f8fafc;
    color: #334155;
    font-size: .87rem;
    font-weight: 700;
    border-bottom: 1px solid var(--user-border);
    padding: .95rem .9rem;
    white-space: nowrap;
}

.user-modern-table tbody td{
    padding: .95rem .9rem;
    border-bottom: 1px solid #eef2f7;
    vertical-align: middle;
}

.user-modern-table tbody tr:hover{
    background: #fcfdff;
}

.user-avatar-table{
    width: 46px;
    height: 46px;
    object-fit: cover;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 3px 10px rgba(15,23,42,.12);
}

.user-action-group{
    display: flex;
    gap: .4rem;
    flex-wrap: wrap;
    justify-content: center;
}

.user-action-btn{
    border-radius: 10px;
    padding: .48rem .72rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: .35rem;
    white-space: nowrap;
}

div.dataTables_wrapper div.dataTables_filter{
    text-align: right;
    margin-bottom: 1rem;
    padding: 0 1rem;
}

div.dataTables_wrapper div.dataTables_filter input{
    margin-left: .5rem;
    border: 1px solid #cbd5e1;
    border-radius: 12px;
    padding: .45rem .75rem;
    min-height: 40px;
}

div.dataTables_wrapper div.dataTables_length{
    padding: 1rem 1rem 0 1rem;
}

div.dataTables_wrapper div.dataTables_length select{
    border: 1px solid #cbd5e1;
    border-radius: 10px;
    padding: .35rem 2rem .35rem .75rem;
    min-height: 40px;
}

div.dataTables_wrapper div.dataTables_info{
    padding: 1rem;
    color: #64748b;
}

div.dataTables_wrapper div.dataTables_paginate{
    padding: .75rem 1rem 1rem 1rem;
}

div.dataTables_wrapper div.dataTables_paginate .paginate_button{
    border-radius: 10px !important;
    margin-left: .2rem;
}

@media (max-width: 991.98px){
    .user-page-title{
        font-size: 1.3rem;
    }

    .user-main-btn{
        width: 100%;
        justify-content: center;
    }
}

@media (max-width: 767.98px){
    div.dataTables_wrapper div.dataTables_filter,
    div.dataTables_wrapper div.dataTables_length,
    div.dataTables_wrapper div.dataTables_info,
    div.dataTables_wrapper div.dataTables_paginate{
        text-align: left !important;
    }

    .user-action-group{
        justify-content: flex-start;
    }
}
</style>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('#usersTable').DataTable({
            pageLength: 10,
            lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
            responsive: false,
            autoWidth: false,
            language: {
                search: "ค้นหา:",
                lengthMenu: "แสดง _MENU_ รายการต่อหน้า",
                info: "แสดง _START_ ถึง _END_ จาก _TOTAL_ รายการ",
                infoEmpty: "ไม่มีข้อมูล",
                zeroRecords: "ไม่พบข้อมูลที่ค้นหา",
                paginate: {
                    first: "แรก",
                    last: "สุดท้าย",
                    next: "ถัดไป",
                    previous: "ก่อนหน้า"
                }
            }
        });
    });
</script>
@endpush