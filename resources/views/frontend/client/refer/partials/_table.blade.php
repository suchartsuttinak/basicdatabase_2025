@php
    $canApproveRefer = auth()->check() && in_array(auth()->user()->role, ['admin', 'executive']);
    $hasReferRows = isset($refers) && $refers->count() > 0;
@endphp

<style>
.rf-table-card{
    margin-top:16px;
    border:1px solid #e7edf5;
    border-radius:22px;
    background:#ffffff;
    box-shadow:0 12px 32px rgba(15,23,42,.06);
    overflow:hidden;
}

.rf-table-head{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:12px;
    flex-wrap:wrap;
    padding:16px 18px;
    border-bottom:1px solid #eef2f7;
    background:linear-gradient(135deg,#ffffff 0%,#f8fbff 100%);
}

.rf-table-title{
    display:flex;
    align-items:center;
    gap:10px;
    font-size:16px;
    font-weight:800;
    color:#0f172a;
}

.rf-table-title i{
    width:38px;
    height:38px;
    border-radius:12px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    background:#eef2ff;
    color:#4f46e5;
}

.rf-table-meta{
    padding:7px 12px;
    border-radius:999px;
    background:#f8fafc;
    border:1px solid #e2e8f0;
    color:#475569;
    font-size:13px;
    font-weight:700;
}

.rf-table-wrap{
    padding:16px;
    overflow-x:auto;
}

.rf-table{
    min-width:1500px;
    margin-bottom:0;
}

.rf-table thead th{
    white-space:nowrap;
    font-size:13px;
    color:#334155;
    background:#f8fafc;
    border-bottom:1px solid #e2e8f0;
    vertical-align:middle;
}

.rf-table tbody td{
    font-size:13px;
    color:#334155;
    vertical-align:middle;
}

.rf-cell{
    min-width:130px;
    max-width:180px;
    white-space:normal;
    line-height:1.6;
}

.rf-cell-sm{
    min-width:90px;
    max-width:130px;
    white-space:normal;
    line-height:1.6;
}

.rf-cell-lg{
    min-width:180px;
    max-width:260px;
    white-space:normal;
    line-height:1.6;
}

.rf-btn-sm{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:6px;
    min-height:34px;
    padding:7px 10px;
    border-radius:11px;
    font-size:12px;
    font-weight:700;
    white-space:nowrap;
}

.rf-actions{
    min-width:170px;
}

.rf-empty-card{
    margin-top:16px;
    padding:52px 20px;
    border:1px solid #e7edf5;
    border-radius:22px;
    background:linear-gradient(135deg,#ffffff 0%,#f8fbff 100%);
    box-shadow:0 12px 32px rgba(15,23,42,.06);
    text-align:center;
}

.rf-empty-icon{
    width:86px;
    height:86px;
    margin:0 auto 18px;
    border-radius:50%;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    background:#eef2ff;
    color:#4f46e5;
    font-size:2.1rem;
    box-shadow:0 12px 28px rgba(79,70,229,.14);
}

.rf-empty-card h5{
    margin:0 0 8px;
    color:#0f172a;
    font-size:1.25rem;
    font-weight:800;
}

.rf-empty-card p{
    max-width:620px;
    margin:0 auto 22px;
    color:#64748b;
    line-height:1.8;
}

.rf-empty-btn{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    min-height:44px;
    padding:10px 16px;
    border-radius:14px;
    font-weight:700;
}

@media (max-width:575.98px){
    .rf-table-head{
        padding:14px;
    }

    .rf-table-wrap{
        padding:12px;
    }

    .rf-empty-card{
        padding:42px 14px;
    }

    .rf-empty-icon{
        width:74px;
        height:74px;
        font-size:1.8rem;
    }

    .rf-empty-btn{
        width:100%;
    }
}
</style>

@if($hasReferRows)
    <div class="rf-table-card">
        <div class="rf-table-head">
            <div class="rf-table-title">
                <i class="bi bi-table"></i>
                <span>รายการจำหน่าย</span>
            </div>

            <div class="rf-table-meta">
                จำนวน {{ $refers->count() }} รายการ
            </div>
        </div>

        <div class="rf-table-wrap">
            <table id="datatable-refer" class="table table-hover align-middle rf-table">
                <thead>
                    <tr>
                        <th>วันที่นำส่ง</th>
                        <th>ชื่อผู้รับ</th>
                        <th>สาเหตุ</th>
                        <th>สถานที่นำส่ง</th>
                        <th>ผู้ดูแล</th>
                        <th>ผู้รับตัว</th>
                        <th>โทรศัพท์</th>
                        <th>ความสัมพันธ์</th>
                        <th>ผู้นำส่ง</th>
                        <th>ผลคณะกรรมการฯ</th>
                        <th>รายงานประชุม</th>
                        <th>หมายเหตุ</th>
                        <th>สถานะ</th>
                        <th>จัดการ</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($refers as $refer)
                        @php
                            $approveStatus = $refer->approve_status ?? 'pending';
                            $committeeResult = $refer->committee_result ?? 'ไม่ผ่าน';
                        @endphp

                        <tr>
                            <td class="text-center">
                                {{ \Carbon\Carbon::parse($refer->refer_date)->format('d/m/Y') }}
                            </td>

                            <td>
                                <div class="rf-cell">
                                    {{ $refer->client->fullname ?? $refer->client->name ?? '-' }}
                                </div>
                            </td>

                            <td>
                                <div class="rf-cell">
                                    {{ $refer->translate->translate_name ?? '-' }}
                                </div>
                            </td>

                            <td>
                                <div class="rf-cell-lg">
                                    {{ $refer->destination ?? '-' }}
                                </div>
                            </td>

                            <td class="text-center">
                                <div class="rf-cell-sm">
                                    {{ $refer->guardian ?? '-' }}
                                </div>
                            </td>

                            <td>
                                <div class="rf-cell">
                                    {{ $refer->parent_name ?? '-' }}
                                </div>
                            </td>

                            <td>
                                <div class="rf-cell">
                                    {{ $refer->parent_tel ?? '-' }}
                                </div>
                            </td>

                            <td>
                                <div class="rf-cell">
                                    {{ $refer->member ?? '-' }}
                                </div>
                            </td>

                            <td>
                                <div class="rf-cell">
                                    {{ $refer->teacher ?? '-' }}
                                </div>
                            </td>

                            <td class="text-center">
                                @if($committeeResult === 'ผ่าน')
                                    <span class="badge rounded-pill bg-success-subtle text-success border border-success-subtle px-3 py-2">
                                        <i class="bi bi-check-circle me-1"></i> ผ่าน
                                    </span>
                                @else
                                    <span class="badge rounded-pill bg-secondary-subtle text-secondary border border-secondary-subtle px-3 py-2">
                                        <i class="bi bi-x-circle me-1"></i> ไม่ผ่าน
                                    </span>
                                @endif
                            </td>

                            <td class="text-center">
                                @if(!empty($refer->meeting_report_file))
                                    <a href="{{ asset('uploads/refer_meeting_reports/' . $refer->meeting_report_file) }}"
                                       target="_blank"
                                       class="btn btn-outline-primary rf-btn-sm">
                                        <i class="bi bi-file-earmark-pdf"></i>
                                        <span>เปิดไฟล์</span>
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>

                            <td>
                                <div class="rf-cell-lg">
                                    {{ $refer->remark ?? '-' }}
                                </div>
                            </td>

                            <td class="text-center">
                                @if($approveStatus === 'pending')
                                    <span class="badge rounded-pill bg-warning text-dark px-3 py-2">
                                        <i class="bi bi-hourglass-split me-1"></i> รออนุมัติ
                                    </span>
                                @elseif($approveStatus === 'approved')
                                    <span class="badge rounded-pill bg-success px-3 py-2">
                                        <i class="bi bi-check-circle me-1"></i> อนุมัติแล้ว
                                    </span>
                                @elseif($approveStatus === 'cancelled')
                                    <span class="badge rounded-pill bg-secondary px-3 py-2">
                                        <i class="bi bi-x-circle me-1"></i> ยกเลิกแล้ว
                                    </span>
                                @else
                                    <span class="badge rounded-pill bg-light text-dark border px-3 py-2">
                                        <i class="bi bi-question-circle me-1"></i> ไม่ระบุ
                                    </span>
                                @endif
                            </td>

                            <td class="text-center">
                                <div class="rf-actions d-flex flex-wrap justify-content-center gap-2">
                                    @if($approveStatus === 'pending')
                                        <button type="button" class="btn btn-warning rf-btn-sm" disabled>
                                            <i class="bi bi-hourglass-split"></i>
                                            <span>รออนุมัติ</span>
                                        </button>

                                        @if($canApproveRefer)
                                            <form action="{{ route('refers.approve', $refer->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit"
                                                        class="btn btn-success rf-btn-sm"
                                                        onclick="return confirm('ยืนยันการอนุมัติการจำหน่ายรายการนี้ใช่หรือไม่?')">
                                                    <i class="bi bi-check-circle"></i>
                                                    <span>อนุมัติ</span>
                                                </button>
                                            </form>
                                        @endif
                                    @endif

                                    @if($approveStatus === 'approved')
                                        @if($canApproveRefer)
                                            <form action="{{ route('refers.restore', $refer->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit"
                                                        class="btn btn-outline-success rf-btn-sm"
                                                        onclick="return confirm('ยืนยันการคืนสถานะผู้รับบริการรายนี้ใช่หรือไม่?')">
                                                    <i class="bi bi-arrow-counterclockwise"></i>
                                                    <span>Restore</span>
                                                </button>
                                            </form>
                                        @else
                                            <button type="button" class="btn btn-outline-secondary rf-btn-sm" disabled>
                                                <i class="bi bi-lock"></i>
                                                <span>รอสิทธิ์อนุมัติ</span>
                                            </button>
                                        @endif
                                    @endif

                                    @if($approveStatus === 'cancelled')
                                        <button type="button" class="btn btn-secondary rf-btn-sm" disabled>
                                            <i class="bi bi-slash-circle"></i>
                                            <span>ยกเลิกแล้ว</span>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@else
    <div class="rf-empty-card">
        <div class="rf-empty-icon">
            <i class="bi bi-inbox"></i>
        </div>

        <h5>ยังไม่มีข้อมูลการจำหน่าย</h5>

        <p>
            เมื่อยังไม่มีข้อมูล ระบบจะซ่อนตารางรายการจำหน่ายไว้ก่อน
            เพื่อให้หน้าจอดูสะอาด ใช้งานง่าย และไม่แสดงตารางว่างโดยไม่จำเป็น
        </p>

        <button type="button"
                class="btn btn-primary rf-empty-btn"
                data-bs-toggle="modal"
                data-bs-target="#createReferModal">
            <i class="bi bi-plus-circle"></i>
            <span>เพิ่มข้อมูลจำหน่าย</span>
        </button>
    </div>
@endif