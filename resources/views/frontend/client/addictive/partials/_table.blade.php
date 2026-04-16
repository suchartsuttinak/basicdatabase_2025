@if($addictives->isNotEmpty())
    <div class="addictive-record-section">
        <style>
            /* =========================================
               Scoped: addictive-record-section only
               ไม่กระทบส่วนอื่น
            ========================================= */
            .addictive-record-section .addictive-record-card{
                border: 1px solid #e2e8f0;
                border-radius: 22px;
                overflow: hidden;
                background: #ffffff;
                box-shadow: 0 12px 32px rgba(15, 23, 42, 0.07);
            }

            .addictive-record-section .addictive-record-head{
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 1rem;
                padding: 1rem 1.15rem;
                border-bottom: 1px solid #e2e8f0;
                background: linear-gradient(135deg, #f8fbff 0%, #eef5ff 100%);
            }

            .addictive-record-section .addictive-record-head-left{
                display: flex;
                align-items: center;
                gap: 0.8rem;
                min-width: 0;
            }

            .addictive-record-section .addictive-record-head-icon{
                width: 44px;
                height: 44px;
                border-radius: 14px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                flex: 0 0 auto;
                background: #eaf2ff;
                color: #2563eb;
                box-shadow: inset 0 0 0 1px rgba(37, 99, 235, 0.06);
            }

            .addictive-record-section .addictive-record-head-icon i{
                font-size: 1rem;
                line-height: 1;
            }

            .addictive-record-section .addictive-record-head-text{
                min-width: 0;
            }

            .addictive-record-section .addictive-record-head-text h6{
                margin: 0;
                font-size: 1rem;
                font-weight: 800;
                line-height: 1.35;
                color: #0f172a;
                letter-spacing: -0.01em;
            }

            .addictive-record-section .addictive-record-head-text small{
                display: block;
                margin-top: 0.18rem;
                font-size: 0.82rem;
                line-height: 1.5;
                color: #64748b;
            }

            .addictive-record-section .addictive-record-body{
                padding: 0.9rem;
            }

            .addictive-record-section .addictive-table-wrap{
                width: 100%;
                overflow-x: auto;
                overflow-y: hidden;
                -webkit-overflow-scrolling: touch;
                scrollbar-width: thin;
                border-radius: 16px;
            }

            .addictive-record-section .addictive-table{
                width: 100%;
                min-width: 1180px;
                margin-bottom: 0;
                border-collapse: separate;
                border-spacing: 0;
            }

            .addictive-record-section .addictive-table thead th{
                background: #f8fafc;
                color: #0f172a;
                font-size: 0.87rem;
                font-weight: 800;
                text-align: center;
                vertical-align: middle;
                white-space: nowrap;
                padding: 0.92rem 0.75rem;
                border-bottom: 1px solid #e2e8f0;
            }

            .addictive-record-section .addictive-table thead th:first-child{
                border-top-left-radius: 14px;
            }

            .addictive-record-section .addictive-table thead th:last-child{
                border-top-right-radius: 14px;
            }

            .addictive-record-section .addictive-table tbody td{
                vertical-align: middle;
                font-size: 0.9rem;
                color: #1e293b;
                padding: 0.9rem 0.75rem;
                background: #fff;
                border-bottom: 1px solid #eef2f7;
            }

            .addictive-record-section .addictive-table tbody tr:hover td{
                background: #fcfdff;
            }

            .addictive-record-section .addictive-table .col-date,
            .addictive-record-section .addictive-table .col-count{
                white-space: nowrap;
            }

            .addictive-record-section .addictive-table .col-record,
            .addictive-record-section .addictive-table .col-recorder{
                white-space: normal;
                word-break: break-word;
            }

            .addictive-record-section .addictive-table .col-record{
                min-width: 220px;
            }

            .addictive-record-section .addictive-table .col-recorder{
                min-width: 140px;
            }

            .addictive-record-section .addictive-table .badge{
                font-weight: 700;
                font-size: 0.78rem;
                padding: 0.48rem 0.72rem;
                letter-spacing: 0.01em;
            }

            .addictive-record-section .addictive-action-group{
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 0.55rem;
                flex-wrap: nowrap;
                overflow-x: auto;
                overflow-y: hidden;
                -webkit-overflow-scrolling: touch;
                padding-bottom: 0.12rem;
                scrollbar-width: thin;
            }

            .addictive-record-section .addictive-action-group > *{
                flex: 0 0 auto;
            }

            .addictive-record-section .addictive-btn-action{
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 0.42rem;
                min-height: 38px;
                padding: 0.52rem 0.9rem;
                border-radius: 12px;
                font-weight: 700;
                font-size: 0.83rem;
                line-height: 1;
                white-space: nowrap;
                border-width: 1px;
                box-shadow: none !important;
                transition: all 0.18s ease;
            }

            .addictive-record-section .addictive-btn-action i{
                font-size: 0.92rem;
                line-height: 1;
            }

            .addictive-record-section .btn-warning.addictive-btn-action{
                color: #854d0e;
                background: #fff8e6;
                border-color: #f7d98b;
            }

            .addictive-record-section .btn-warning.addictive-btn-action:hover{
                color: #78350f;
                background: #ffefbf;
                border-color: #f2c968;
            }

            .addictive-record-section .btn-danger.addictive-btn-action{
                color: #ffffff;
                background: #dc2626;
                border-color: #dc2626;
            }

            .addictive-record-section .btn-danger.addictive-btn-action:hover{
                background: #b91c1c;
                border-color: #b91c1c;
                color: #ffffff;
            }

            .addictive-record-section .btn-outline-primary.addictive-btn-action{
                color: #2563eb;
                background: #ffffff;
                border-color: #bfdbfe;
            }

            .addictive-record-section .btn-outline-primary.addictive-btn-action:hover{
                color: #ffffff;
                background: #2563eb;
                border-color: #2563eb;
            }

            .addictive-record-section .addictive-record-empty{
                border: 1px dashed #cbd5e1;
                border-radius: 18px;
                background: linear-gradient(180deg, #fbfdff 0%, #f8fbff 100%);
                color: #475569;
                padding: 1.05rem 1rem;
                text-align: center;
                font-size: 0.93rem;
                box-shadow: 0 8px 24px rgba(15, 23, 42, 0.04);
            }

            @media (max-width: 767.98px){
                .addictive-record-section .addictive-record-head{
                    padding: 0.95rem;
                }

                .addictive-record-section .addictive-record-body{
                    padding: 0.72rem;
                }

                .addictive-record-section .addictive-record-head-text h6{
                    font-size: 0.95rem;
                }

                .addictive-record-section .addictive-record-head-text small{
                    font-size: 0.78rem;
                }

                .addictive-record-section .addictive-table thead th,
                .addictive-record-section .addictive-table tbody td{
                    font-size: 0.84rem;
                }

                .addictive-record-section .addictive-btn-action{
                    min-height: 36px;
                    padding: 0.5rem 0.82rem;
                    border-radius: 11px;
                    font-size: 0.8rem;
                }
            }

            @media (max-width: 575.98px){
                .addictive-record-section .addictive-record-card{
                    border-radius: 18px;
                }

                .addictive-record-section .addictive-record-head{
                    padding: 0.9rem;
                }

                .addictive-record-section .addictive-record-head-icon{
                    width: 40px;
                    height: 40px;
                    border-radius: 12px;
                }

                .addictive-record-section .addictive-record-body{
                    padding: 0.62rem;
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
                                <th>วันที่ตรวจ</th>
                                <th class="text-center">ครั้งที่</th>
                                <th>ผลการตรวจ</th>
                                <th>การส่งต่อ</th>
                                <th class="text-center" style="min-width: 240px;">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($addictives as $index => $addictive)
                                <tr id="row-addictive-{{ $addictive->id }}">
                                    <td class="col-date">
                                        {{ $addictive->date ? \Carbon\Carbon::parse($addictive->date)->addYears(543)->format('d/m/Y') : '-' }}
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

                                            <a href="{{ route('addictive.report.all', ['client_id' => $client->id, 'date_from' => $addictive->date, 'date_to' => $addictive->date]) }}"
                                               class="btn btn-outline-primary btn-sm addictive-btn-action">
                                                <i class="bi bi-calendar-event"></i>
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
            .addictive-record-section .addictive-record-empty{
                border: 1px dashed #cbd5e1;
                border-radius: 18px;
                background: linear-gradient(180deg, #fbfdff 0%, #f8fbff 100%);
                color: #475569;
                padding: 1.05rem 1rem;
                text-align: center;
                font-size: 0.93rem;
                box-shadow: 0 8px 24px rgba(15, 23, 42, 0.04);
            }
        </style>

        <div class="addictive-record-empty mt-2">
            <i class="bi bi-info-circle me-1"></i>
            ยังไม่มีข้อมูลการตรวจสารเสพติด
        </div>
    </div>
@endif