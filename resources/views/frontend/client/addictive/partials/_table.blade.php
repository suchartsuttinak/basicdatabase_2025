@if($addictives->isNotEmpty())
    <div class="addictive-record-section">
        <style>
            .addictive-record-section .addictive-record-card {
                border: 1px solid #e2e8f0;
                border-radius: 20px;
                overflow: hidden;
                background: #ffffff;
                box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
            }

            .addictive-record-section .addictive-record-head {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 1rem;
                padding: 1rem 1.15rem;
                border-bottom: 1px solid #e2e8f0;
                background: linear-gradient(135deg, #f8fbff 0%, #eef5ff 100%);
            }

            .addictive-record-section .addictive-record-head-left {
                display: flex;
                align-items: center;
                gap: 0.75rem;
                min-width: 0;
            }

            .addictive-record-section .addictive-record-head-icon {
                width: 42px;
                height: 42px;
                border-radius: 12px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                flex: 0 0 auto;
                background: #eff6ff;
                color: #2563eb;
            }

            .addictive-record-section .addictive-record-head-icon i {
                font-size: 1rem;
                line-height: 1;
            }

            .addictive-record-section .addictive-record-head-text {
                min-width: 0;
            }

            .addictive-record-section .addictive-record-head-text h6 {
                margin: 0;
                font-size: 1rem;
                font-weight: 800;
                line-height: 1.35;
                color: #0f172a;
            }

            .addictive-record-section .addictive-record-head-text small {
                display: block;
                margin-top: 0.15rem;
                font-size: 0.82rem;
                line-height: 1.4;
                color: #64748b;
            }

            .addictive-record-section .addictive-record-body {
                padding: 0.85rem;
            }

            .addictive-record-section .addictive-table-wrap {
                width: 100%;
                overflow-x: auto;
                overflow-y: hidden;
                -webkit-overflow-scrolling: touch;
                scrollbar-width: thin;
                border-radius: 14px;
            }

            .addictive-record-section .addictive-table {
                width: 100%;
                min-width: 1180px;
                margin-bottom: 0;
                border-collapse: separate;
                border-spacing: 0;
            }

            .addictive-record-section .addictive-table thead th {
                background: #f8fafc;
                color: #0f172a;
                font-size: 0.87rem;
                font-weight: 700;
                text-align: center;
                vertical-align: middle;
                white-space: nowrap;
                padding: 0.9rem 0.75rem;
                border-bottom: 1px solid #e2e8f0;
            }

            .addictive-record-section .addictive-table tbody td {
                vertical-align: middle;
                font-size: 0.89rem;
                color: #1e293b;
                padding: 0.85rem 0.75rem;
                background: #fff;
                border-bottom: 1px solid #eef2f7;
            }

            .addictive-record-section .addictive-table tbody tr:hover td {
                background: #fcfdff;
            }

            .addictive-record-section .addictive-table .col-record,
            .addictive-record-section .addictive-table .col-recorder {
                white-space: normal;
                word-break: break-word;
            }

            .addictive-record-section .addictive-table .col-record {
                min-width: 220px;
            }

            .addictive-record-section .addictive-table .col-recorder {
                min-width: 140px;
            }

            .addictive-record-section .addictive-action-group {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 0.45rem;
                flex-wrap: nowrap;
                overflow-x: auto;
                overflow-y: hidden;
                -webkit-overflow-scrolling: touch;
                padding-bottom: 0.1rem;
            }

            .addictive-record-section .addictive-action-group > * {
                flex: 0 0 auto;
            }

            .addictive-record-section .addictive-btn-action {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 0.35rem;
                min-height: 35px;
                padding: 0.45rem 0.78rem;
                border-radius: 10px;
                font-weight: 600;
                line-height: 1;
                white-space: nowrap;
            }

            .addictive-record-section .addictive-record-empty {
                border: 1px dashed #cbd5e1;
                border-radius: 16px;
                background: #f8fbff;
                color: #475569;
                padding: 1rem;
                text-align: center;
                font-size: 0.92rem;
            }

            @media (max-width: 767.98px) {
                .addictive-record-section .addictive-record-head {
                    padding: 0.95rem;
                }

                .addictive-record-section .addictive-record-body {
                    padding: 0.7rem;
                }

                .addictive-record-section .addictive-record-head-text h6 {
                    font-size: 0.95rem;
                }

                .addictive-record-section .addictive-record-head-text small {
                    font-size: 0.78rem;
                }

                .addictive-record-section .addictive-table thead th,
                .addictive-record-section .addictive-table tbody td {
                    font-size: 0.84rem;
                }
            }

            @media (max-width: 575.98px) {
                .addictive-record-section .addictive-record-card {
                    border-radius: 16px;
                }

                .addictive-record-section .addictive-record-head {
                    padding: 0.9rem;
                }

                .addictive-record-section .addictive-record-head-icon {
                    width: 38px;
                    height: 38px;
                    border-radius: 11px;
                }

                .addictive-record-section .addictive-record-body {
                    padding: 0.6rem;
                }
            }
        </style>

        <div class="card border-0 shadow-sm addictive-table-card addictive-record-card">
            <div class="addictive-record-head">
                <div class="addictive-record-head-left">
                    <div class="addictive-record-head-icon">
                        <i class="bi bi-table"></i>
                    </div>
                    <div class="addictive-record-head-text">
                        <h6>รายการข้อมูลการตรวจสารเสพติด</h6>
                        <small>แสดงประวัติผลการตรวจ การส่งต่อ และผู้รับผิดชอบทั้งหมด</small>
                    </div>
                </div>
            </div>

            <div class="card-body addictive-record-body">
                <div class="table-responsive addictive-table-wrap">
                    <table id="datatable-addictive" class="table table-sm table-hover align-middle addictive-table mb-0">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 70px;">ลำดับ</th>
                                <th>วันที่ตรวจ</th>
                                <th class="text-center">ครั้งที่</th>
                                <th>ผลการตรวจ</th>
                                <th>การส่งต่อ</th>
                                <th>บันทึกผล</th>
                                <th>ผู้ตรวจ</th>
                                <th class="text-center" style="min-width: 220px;">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($addictives as $index => $addictive)
                                <tr id="row-addictive-{{ $addictive->id }}">
                                    <td class="text-center">{{ $index + 1 }}</td>

                                    <td class="col-date">
                                        {{ $addictive->date ? \Carbon\Carbon::parse($addictive->date)->format('d/m/Y') : '-' }}
                                    </td>

                                    <td class="text-center col-count">{{ $addictive->count ?? '-' }}</td>

                                    <td class="col-exam">
                                        @if($addictive->exam == 0)
                                            <span class="badge rounded-pill text-bg-success">ไม่พบสารเสพติด</span>
                                        @else
                                            <span class="badge rounded-pill text-bg-danger">พบสารเสพติด</span>
                                        @endif
                                    </td>

                                    <td class="col-refer">
                                        @if($addictive->exam == 1)
                                            @if($addictive->refer == 1)
                                                <span class="badge rounded-pill text-bg-warning text-dark">ส่งต่อบำบัด</span>
                                            @elseif($addictive->refer == 2)
                                                <span class="badge rounded-pill text-bg-info">ติดตามดูแลต่อเนื่อง</span>
                                            @else
                                                <span class="badge rounded-pill text-bg-secondary">-</span>
                                            @endif
                                        @else
                                            <span class="badge rounded-pill text-bg-secondary">-</span>
                                        @endif
                                    </td>

                                    <td class="col-record">{{ $addictive->record ?? '-' }}</td>
                                    <td class="col-recorder">{{ $addictive->recorder ?? '-' }}</td>

                                    <td class="text-center">
                                        <div class="addictive-action-group">
                                            <button type="button"
                                                    class="btn btn-warning btn-sm addictive-btn-action"
                                                    onclick="openEditAddictive({{ $addictive->id }})">
                                                <i class="bi bi-pencil-square"></i>
                                                <span>แก้ไข</span>
                                            </button>

                                            <form id="delete-form-addictive-{{ $addictive->id }}"
                                                  action="{{ route('addictive.delete', $addictive->id) }}"
                                                  method="POST"
                                                  class="d-inline">
                                                @csrf
                                                @method('DELETE')

                                                <button type="button"
                                                        class="btn btn-danger btn-sm addictive-btn-action"
                                                        onclick="confirmDelete('delete-form-addictive-{{ $addictive->id }}', 'คุณต้องการลบข้อมูลการตรวจสารเสพติดนี้ใช่หรือไม่')">
                                                    <i class="bi bi-trash"></i>
                                                    <span>ลบ</span>
                                                </button>
                                            </form>

                                            <a href="#" class="btn btn-info btn-sm addictive-btn-action">
                                                <i class="bi bi-file-earmark-text"></i>
                                                <span>รายงาน</span>
                                            </a>
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
@else
    <div class="addictive-record-section">
        <style>
            .addictive-record-section .addictive-record-empty {
                border: 1px dashed #cbd5e1;
                border-radius: 16px;
                background: #f8fbff;
                color: #475569;
                padding: 1rem;
                text-align: center;
                font-size: 0.92rem;
            }
        </style>

        <div class="addictive-record-empty mt-2">
            <i class="bi bi-info-circle me-1"></i>
            ยังไม่มีข้อมูลการตรวจสารเสพติด
        </div>
    </div>
@endif