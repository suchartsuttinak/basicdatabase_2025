@php
    $canApproveRefer = auth()->check() && in_array(auth()->user()->role, ['admin', 'executive']);
@endphp

<div class="rf-table-card">
    <div class="rf-table-head">
        <div class="rf-table-title">
            <i class="bi bi-table"></i>
            <span>รายการจำหน่าย</span>
        </div>
        <div class="rf-table-meta">จำนวน {{ $refers->count() }} รายการ</div>
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
                @forelse ($refers as $refer)
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
                                            <button type="submit" class="btn btn-success rf-btn-sm"
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
                                            <button type="submit" class="btn btn-outline-success rf-btn-sm"
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
                @empty
                    <tr>
                        <td colspan="14">
                            <div class="rf-empty">
                                <i class="bi bi-info-circle"></i>
                                <div class="fw-bold mb-1">ยังไม่มีข้อมูลการจำหน่าย</div>
                                <div class="small">เมื่อมีข้อมูล รายการจะแสดงในตารางนี้</div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>