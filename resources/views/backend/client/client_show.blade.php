@extends('admin.admin_master')
@section('admin')

<style>
    .client-page {
        padding-top: .5rem;
    }

    .client-toolbar {
        display: flex;
        flex-wrap: wrap;
        gap: .75rem;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1rem;
    }

    .client-toolbar-left,
    .client-toolbar-right {
        display: flex;
        align-items: center;
        gap: .5rem;
    }

    .client-title-box h4 {
        margin: 0;
        font-weight: 600;
        color: #1f2937;
    }

    .client-title-box p {
        margin: .15rem 0 0 0;
        font-size: 13px;
        color: #6b7280;
    }

    .client-btn {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        border-radius: 12px;
        padding: .55rem .95rem;
        font-weight: 500;
        box-shadow: 0 2px 8px rgba(15, 23, 42, .06);
    }

    .client-list-card {
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 18px rgba(15, 23, 42, .04);
    }

    .client-list-card .card-header {
        background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
        border-bottom: 1px solid #eef2f7;
        padding: 1rem 1rem;
    }

    .client-list-card .card-title {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
        color: #1f2937;
    }

    .client-list-card .card-body {
        padding: 1rem;
    }

    .client-table-wrap {
        overflow-x: auto;
    }

    .client-table {
        margin-bottom: 0;
        min-width: 980px;
        vertical-align: middle;
    }

    .client-table thead th {
        background: #eef4ff !important;
        color: #1d4f91;
        font-weight: 600;
        font-size: 13px;
        border-bottom: 1px solid #dbe6f5 !important;
        white-space: nowrap;
    }

    .client-table tbody td {
        font-size: 14px;
        vertical-align: middle;
    }

    .client-table tbody tr:hover {
        background: #fafcff;
    }

    .client-avatar {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #e5e7eb;
    }

    .client-name {
        font-weight: 600;
        color: #111827;
        margin-bottom: 2px;
    }

    .client-subtext {
        font-size: 12px;
        color: #6b7280;
    }

    .problem-list {
        margin: 0;
        padding-left: 1rem;
        font-size: 13px;
    }

    .status-badge {
        padding: .45rem .7rem;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 600;
    }

    .action-group {
        display: flex;
        flex-wrap: wrap;
        gap: .35rem;
    }

    .action-btn {
        width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        padding: 0;
    }

    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #d1d5db;
        border-radius: 10px;
        padding: .35rem .65rem;
        margin-left: .4rem;
    }

    .dataTables_wrapper .dataTables_length select {
        border: 1px solid #d1d5db;
        border-radius: 10px;
        padding: .2rem 1.8rem .2rem .5rem;
    }

    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate,
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        font-size: 13px;
        margin-top: .35rem;
    }

    @media (max-width: 767.98px) {
        .client-toolbar {
            align-items: stretch;
        }

        .client-toolbar-left,
        .client-toolbar-right {
            width: 100%;
            justify-content: space-between;
        }

        .client-toolbar-right .client-btn {
            width: 100%;
            justify-content: center;
        }

        .client-list-card .card-header,
        .client-list-card .card-body {
            padding: .85rem;
        }
    }
</style>

<div class="content">
    <div class="container-fluid client-page">

        {{-- Header --}}
        <div class="client-toolbar">
            <div class="client-toolbar-left">
                <a href="{{ route('dashboard') }}" class="btn btn-primary client-btn">
                    <i data-feather="arrow-left-circle"></i>
                    <span>ย้อนกลับ</span>
                </a>

                <div class="client-title-box">
                    <h4>รายการผู้รับบริการ</h4>
                    <p>จัดการข้อมูลผู้รับบริการทั้งหมดในระบบ</p>
                </div>
            </div>

            <div class="client-toolbar-right">
                <a href="{{ route('client.add') }}" class="btn btn-success client-btn">
                    <i data-feather="plus-circle"></i>
                    <span>เพิ่มรายการ</span>
                </a>
            </div>
        </div>

        <div class="card client-list-card">
            <div class="card-header">
                <h5 class="card-title">รายการผู้รับ</h5>
            </div>

            <div class="card-body">
                @if($clients->isNotEmpty())
                    <div class="client-table-wrap">
                        <table id="datatable" class="table table-hover align-middle client-table nowrap w-100">
                            <thead>
                                <tr>
                                    <th>ลำดับ</th>
                                    <th>ภาพ</th>
                                    <th>ชื่อ-นามสกุล</th>
                                    <th>วันที่รับเข้า</th>
                                    <th>วันเกิด</th>
                                    <th>อายุ</th>
                                    <th>ปัญหา</th>
                                    <th>สถานะ</th>
                                    <th>การจัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($clients as $key => $client)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>

                                        <td>
                                            @php
                                                $imagePath = public_path('upload/client_images/' . $client->image);
                                            @endphp

                                            @if(!empty($client->image) && file_exists($imagePath))
                                                <img src="{{ asset('upload/client_images/' . $client->image) }}"
                                                     alt="client-image"
                                                     class="client-avatar">
                                            @else
                                                <img src="{{ asset('upload/no_image.jpg') }}"
                                                     alt="no-image"
                                                     class="client-avatar">
                                            @endif
                                        </td>

                                        <td>
                                            <div class="client-name">{{ $client->full_name }}</div>
                                            <div class="client-subtext">รหัสรายการ #{{ $client->id }}</div>
                                        </td>

                                        <td>{{ $client->arrival_date }}</td>
                                        <td>{{ $client->birth_date }}</td>
                                        <td>{{ $client->age }}</td>

                                        <td>
                                            @if($client->problems->isNotEmpty())
                                                <ul class="problem-list">
                                                    @foreach($client->problems as $problem)
                                                        <li>{{ $problem->name }}</li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <span class="text-muted small">ไม่มีข้อมูล</span>
                                            @endif
                                        </td>

                                        <td>
                                            @if($client->release_status === 'show')
                                                <span class="badge bg-success-subtle text-success status-badge">อยู่ในระบบ</span>
                                            @else
                                                <span class="badge bg-secondary-subtle text-secondary status-badge">ไม่อยู่ในระบบ</span>
                                            @endif
                                        </td>

                                        <td>
                                            <div class="action-group">
                                                <a title="ดูข้อมูล"
                                                   href="{{ route('admin.index', $client->id) }}"
                                                   class="btn btn-primary btn-sm action-btn">
                                                    <span class="mdi mdi-eye-circle mdi-18px"></span>
                                                </a>

                                                <a title="แก้ไข"
                                                   href="{{ route('client.edit', $client->id) }}"
                                                   class="btn btn-success btn-sm action-btn">
                                                    <span class="mdi mdi-book-edit-outline mdi-18px"></span>
                                                </a>

                                                <a title="ลบ"
                                                   href="{{ route('client.delete', $client->id) }}"
                                                   class="btn btn-danger btn-sm action-btn"
                                                   id="delete">
                                                    <span class="mdi mdi-trash-can-outline mdi-18px"></span>
                                                </a>

                                                <a title="จำหน่าย"
                                                   href="{{ route('refers.index', $client->id) }}"
                                                   class="btn btn-warning btn-sm action-btn">
                                                    <span class="mdi mdi-arrow-right-bold mdi-18px"></span>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info mb-0">
                        ไม่มีข้อมูลผู้รับ
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#datatable').DataTable({
            responsive: true,
            autoWidth: false,
            pageLength: 10,
            order: [[0, 'asc']],
            language: {
                search: "ค้นหา:",
                lengthMenu: "แสดง _MENU_ รายการ",
                info: "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                infoEmpty: "ไม่มีข้อมูลให้แสดง",
                paginate: {
                    first: "หน้าแรก",
                    last: "หน้าสุดท้าย",
                    next: "ถัดไป",
                    previous: "ก่อนหน้า"
                },
                zeroRecords: "ไม่พบข้อมูลที่ค้นหา"
            }
        });

        if (window.feather) {
            feather.replace();
        }
    });
</script>
@endpush