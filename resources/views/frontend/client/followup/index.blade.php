@extends('admin_client.admin_client')

@section('content')



@if(session('error'))
    <div class="alert alert-danger mx-3 mx-md-4 mb-3">
        {{ session('error') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger mx-3 mx-md-4 mb-3">
        <div class="fw-bold mb-1">กรุณาตรวจสอบข้อมูล</div>
        <ul class="mb-0 ps-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif






<div class="followup-page">
    <style>
        .followup-page {
            padding-bottom: 1.5rem;
        }

        .followup-page .followup-card {
            background: #fff;
            border: 1px solid #e8edf4;
            border-radius: 22px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.05);
            overflow: hidden;
        }

        .followup-page .followup-header {
            padding: 1.25rem 1.25rem 0.75rem;
            border-bottom: 1px solid #eef2f7;
            background: linear-gradient(180deg, #f8fbff 0%, #ffffff 100%);
        }

        .followup-page .followup-title-wrap {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .followup-page .followup-title-box h2 {
            margin: 0;
            font-size: 1.35rem;
            font-weight: 700;
            color: #1e293b;
        }

        .followup-page .followup-title-box p {
            margin: .4rem 0 0;
            color: #64748b;
            line-height: 1.7;
        }

        .followup-page .followup-badge {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            padding: .7rem 1rem;
            border-radius: 999px;
            background: #eff6ff;
            color: #1d4ed8;
            font-weight: 600;
            white-space: nowrap;
        }

        .followup-page .followup-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: .75rem;
            padding: 1rem 1.25rem;
            flex-wrap: wrap;
        }

        .followup-page .followup-toolbar-left,
        .followup-page .followup-toolbar-right {
            display: flex;
            gap: .75rem;
            flex-wrap: wrap;
            align-items: center;
        }

        .followup-page .followup-note {
            color: #64748b;
            font-size: .95rem;
        }

        .followup-page .table-wrap {
            padding: 0 1.25rem 1.25rem;
            overflow-x: auto;
        }

        .followup-page table.dataTable thead th {
            white-space: nowrap;
        }

        .followup-page .followup-table {
            width: 100% !important;
            min-width: 830px;
        }

        .followup-page .text-preline {
            white-space: pre-line;
            line-height: 1.7;
        }

        .followup-page .action-group {
            display: flex;
            gap: .45rem;
            flex-wrap: nowrap;
        }

        .followup-page .btn-action {
            min-width: 40px;
            height: 40px;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            border-radius: 12px;
        }

        .followup-page .modal .form-label {
            font-weight: 600;
            color: #334155;
        }

        .followup-page .required-star {
            color: #dc2626;
        }

        .followup-page .client-meta {
            display: flex;
            flex-wrap: wrap;
            gap: .5rem .75rem;
            margin-top: .75rem;
        }

        .followup-page .client-chip {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            padding: .45rem .8rem;
            border-radius: 999px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            color: #334155;
            font-size: .92rem;
        }

        .followup-page .followup-empty {
            margin: 0 1.25rem 1.25rem;
            padding: 2rem 1.25rem;
            border: 1px dashed #cbd5e1;
            border-radius: 18px;
            background: #f8fafc;
            text-align: center;
        }

        .followup-page .followup-empty-icon {
            width: 64px;
            height: 64px;
            margin: 0 auto 1rem;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #e2e8f0;
            color: #475569;
            font-size: 1.5rem;
        }

        .followup-page .followup-empty h4 {
            margin: 0 0 .5rem;
            font-size: 1.1rem;
            font-weight: 700;
            color: #1e293b;
        }

        .followup-page .followup-empty p {
            margin: 0;
            color: #64748b;
            line-height: 1.7;
        }

        @media (max-width: 767.98px) {
            .followup-page .followup-header,
            .followup-page .followup-toolbar,
            .followup-page .table-wrap {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            .followup-page .followup-empty {
                margin-left: 1rem;
                margin-right: 1rem;
            }

            .followup-page .followup-title-box h2 {
                font-size: 1.15rem;
            }

            .followup-page .followup-toolbar-left,
            .followup-page .followup-toolbar-right {
                width: 100%;
            }

            .followup-page .followup-toolbar-right .btn {
                flex: 1 1 auto;
            }
        }
    </style>

    @php
        $thaiMonths = [
            1 => 'มกราคม',
            2 => 'กุมภาพันธ์',
            3 => 'มีนาคม',
            4 => 'เมษายน',
            5 => 'พฤษภาคม',
            6 => 'มิถุนายน',
            7 => 'กรกฎาคม',
            8 => 'สิงหาคม',
            9 => 'กันยายน',
            10 => 'ตุลาคม',
            11 => 'พฤศจิกายน',
            12 => 'ธันวาคม',
        ];
    @endphp

    <div class="followup-card">
        <div class="followup-header">
            <div class="followup-title-wrap">
                <div class="followup-title-box">
                    <h2>
                        <i class="bi bi-journal-check me-2"></i>
                        ติดตามผลการช่วยเหลือ
                    </h2>
                    <p>
                        บันทึกข้อมูลการช่วยเหลือและติดตามผลของผู้รับบริการอย่างเป็นระบบ อ่านง่าย ใช้งานสะดวก
                        และรองรับทุกขนาดหน้าจอ
                    </p>

                    <div class="client-meta">
                        <div class="client-chip">
                            <i class="bi bi-person-vcard"></i>
                            รหัสผู้รับบริการ: {{ $client->id }}
                        </div>

                        @if(!empty($client->fullname))
                            <div class="client-chip">
                                <i class="bi bi-person-circle"></i>
                                {{ $client->fullname }}
                            </div>
                        @elseif(!empty($client->name))
                            <div class="client-chip">
                                <i class="bi bi-person-circle"></i>
                                {{ $client->name }}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="followup-badge">
                    <i class="bi bi-clipboard2-pulse"></i>
                    <span>{{ $followups->count() }} รายการ</span>
                </div>
            </div>
        </div>

        <div class="followup-toolbar">
            <div class="followup-toolbar-left">
                <a href="{{ route('client.edit', $client->id) }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left-circle me-1"></i>
                    กลับหน้าแก้ไขผู้รับบริการ
                </a>

                @if($followups->count() > 0)
                    <a href="{{ route('followup.report', $client->id) }}" target="_blank" class="btn btn-outline-primary">
                        <i class="bi bi-printer me-1"></i>
                        รายงาน
                    </a>
                @endif
            </div>

            <div class="followup-toolbar-right">
                <div class="followup-note">
                    ระบบนี้รองรับการเพิ่ม แก้ไข และพิมพ์รายงานจากข้อมูลจริงของผู้รับบริการรายนี้
                </div>

                @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'executive', 'social_worker']))
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createFollowupModal">
                        <i class="bi bi-plus-circle me-1"></i>
                        เพิ่มข้อมูลติดตามผล
                    </button>
                @endif
            </div>
        </div>


        <div class="px-3 px-md-4 pb-3">
    <form action="{{ route('followup.index', $client->id) }}" method="GET" class="row g-3 align-items-end">
        <div class="col-md-3">
            <label class="form-label fw-semibold">วันที่เริ่มต้น</label>
            <input type="date" name="date_from" class="form-control" value="{{ $dateFrom ?? request('date_from') }}">
        </div>

        <div class="col-md-3">
            <label class="form-label fw-semibold">วันที่สิ้นสุด</label>
            <input type="date" name="date_to" class="form-control" value="{{ $dateTo ?? request('date_to') }}">
        </div>

        <div class="col-md-6">
            <div class="d-flex flex-wrap gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-funnel me-1"></i>
                    ค้นหาตามช่วงวันที่
                </button>

                <a href="{{ route('followup.index', $client->id) }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-clockwise me-1"></i>
                    ล้างตัวกรอง
                </a>

                <a href="{{ route('followup.report', ['client_id' => $client->id, 'date_from' => request('date_from'), 'date_to' => request('date_to')]) }}"
                   target="_blank"
                   class="btn btn-outline-primary">
                    <i class="bi bi-file-earmark-text me-1"></i>
                    รายงานตามช่วงวันที่
                </a>

              
            </div>
        </div>
    </form>
</div>

        @if($followups->count() > 0)
            <div class="table-wrap">
                <table id="followupTable" class="table table-bordered table-hover align-middle followup-table">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 180px;">วันเดือนปี</th>
                            <th>การช่วยเหลือและติดตามผล</th>
                            <th>หมายเหตุ</th>
                            <th style="width: 160px;">รายงาน</th>
                            <th style="width: 160px;">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($followups as $item)
                            @php
                                $date = \Carbon\Carbon::parse($item->followup_date);
                                $thaiDate = $date->day . ' ' . $thaiMonths[$date->month] . ' ' . ($date->year + 543);
                            @endphp
                            <tr>
                                <td>{{ $thaiDate }}</td>
                                <td class="text-preline">{{ $item->assistance_detail }}</td>
                                <td class="text-preline">{{ $item->note ?: '-' }}</td>
                               <td class="text-center">
    <a href="{{ route('followup.report_item', $item->id) }}"
       target="_blank"
       class="btn btn-outline-primary btn-sm">
        <i class="bi bi-file-earmark-text me-1"></i>
        เปิดรายงาน
    </a>
</td>
                                <td class="text-center">
                                    <div class="action-group justify-content-center">
                                        @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'executive', 'social_worker']))
                                            <button
                                                type="button"
                                                class="btn btn-warning btn-sm btn-action edit-followup-btn"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editFollowupModal"
                                                data-id="{{ $item->id }}"
                                                data-date="{{ \Carbon\Carbon::parse($item->followup_date)->format('Y-m-d') }}"
                                                data-detail="{{ e($item->assistance_detail) }}"
                                                data-note="{{ e($item->note) }}"
                                                title="แก้ไข"
                                            >
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                        @endif

                                        @if(auth()->check() && auth()->user()->role === 'admin')
                                            <form action="{{ route('followup.delete', $item->id) }}" method="POST" class="d-inline delete-followup-form">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm btn-action" title="ลบ">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="followup-empty">
                <div class="followup-empty-icon">
                    <i class="bi bi-inbox"></i>
                </div>
                <h4>ยังไม่มีข้อมูลติดตามผล</h4>
                <p>เมื่อมีการบันทึกข้อมูล ระบบจะแสดงรายการในส่วนนี้โดยอัตโนมัติ</p>
            </div>
        @endif
    </div>

    {{-- Create Modal --}}
    <div class="modal fade" id="createFollowupModal" tabindex="-1" aria-labelledby="createFollowupModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <form action="{{ route('followup.store', $client->id) }}" method="POST" class="modal-content">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title" id="createFollowupModalLabel">
                        <i class="bi bi-plus-circle me-1"></i>
                        เพิ่มข้อมูลติดตามผล
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">
                                วันเดือนปี <span class="required-star">*</span>
                            </label>
                            <input type="date" name="followup_date" class="form-control" value="{{ old('followup_date') }}" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label">
                                การช่วยเหลือและติดตามผล <span class="required-star">*</span>
                            </label>
                            <textarea name="assistance_detail" rows="5" class="form-control" required>{{ old('assistance_detail') }}</textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label">หมายเหตุ</label>
                            <textarea name="note" rows="4" class="form-control">{{ old('note') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">
                        ปิด
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-1"></i>
                        บันทึกข้อมูล
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Edit Modal --}}
    <div class="modal fade" id="editFollowupModal" tabindex="-1" aria-labelledby="editFollowupModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <form id="editFollowupForm" action="" method="POST" class="modal-content">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title" id="editFollowupModalLabel">
                        <i class="bi bi-pencil-square me-1"></i>
                        แก้ไขข้อมูลติดตามผล
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">
                                วันเดือนปี <span class="required-star">*</span>
                            </label>
                            <input type="date" name="followup_date" id="edit_followup_date" class="form-control" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label">
                                การช่วยเหลือและติดตามผล <span class="required-star">*</span>
                            </label>
                            <textarea name="assistance_detail" id="edit_assistance_detail" rows="5" class="form-control" required></textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label">หมายเหตุ</label>
                            <textarea name="note" id="edit_note" rows="4" class="form-control"></textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">
                        ปิด
                    </button>
                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-check-circle me-1"></i>
                        บันทึกการแก้ไข
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (window.jQuery && $.fn.DataTable && document.getElementById('followupTable')) {
        $('#followupTable').DataTable({
            responsive: false,
            autoWidth: false,
            pageLength: 10,
            order: [],
            language: {
                search: 'ค้นหา:',
                lengthMenu: 'แสดง _MENU_ รายการ',
                info: 'แสดง _START_ ถึง _END_ จาก _TOTAL_ รายการ',
                infoEmpty: 'แสดง 0 ถึง 0 จาก 0 รายการ',
                zeroRecords: 'ไม่พบข้อมูลที่ค้นหา',
                paginate: {
                    first: 'หน้าแรก',
                    last: 'หน้าสุดท้าย',
                    next: 'ถัดไป',
                    previous: 'ก่อนหน้า'
                }
            },
            dom: '<"row align-items-center mb-3"<"col-md-6"l><"col-md-6 text-md-end"f>>rt<"row align-items-center mt-3"<"col-md-6"i><"col-md-6 text-md-end"p>>'
        });
    }

    const editButtons = document.querySelectorAll('.edit-followup-btn');
    const editForm = document.getElementById('editFollowupForm');
    const editDate = document.getElementById('edit_followup_date');
    const editDetail = document.getElementById('edit_assistance_detail');
    const editNote = document.getElementById('edit_note');

    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id') || '';
            const date = this.getAttribute('data-date') || '';
            const detail = this.getAttribute('data-detail') || '';
            const note = this.getAttribute('data-note') || '';

            editForm.action = "{{ url('/followup/update') }}/" + id;
            editDate.value = date;
            editDetail.value = detail;
            editNote.value = note;
        });
    });

    document.querySelectorAll('.delete-followup-form').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            if (window.Swal) {
                Swal.fire({
                    title: 'ยืนยันการลบ?',
                    text: 'เมื่อลบแล้วจะไม่สามารถกู้คืนข้อมูลนี้ได้',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'ใช่, ลบข้อมูล',
                    cancelButtonText: 'ยกเลิก'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            } else {
                if (confirm('ยืนยันการลบข้อมูลนี้ใช่หรือไม่?')) {
                    form.submit();
                }
            }
        });
    });

    @if(session('followup_modal') === 'create' && $errors->any())
        const createModal = new bootstrap.Modal(document.getElementById('createFollowupModal'));
        createModal.show();
    @endif

    @if(session('followup_modal') === 'edit' && session('followup_edit_id'))
        @php
            $editItem = $followups->firstWhere('id', session('followup_edit_id'));
        @endphp

        @if($editItem)
            editForm.action = "{{ url('/followup/update/' . $editItem->id) }}";
            editDate.value = "{{ \Carbon\Carbon::parse($editItem->followup_date)->format('Y-m-d') }}";
            editDetail.value = @json($editItem->assistance_detail ?? '');
            editNote.value = @json($editItem->note ?? '');

            const editModal = new bootstrap.Modal(document.getElementById('editFollowupModal'));
            editModal.show();
        @endif
    @endif
});
</script>
@endpush