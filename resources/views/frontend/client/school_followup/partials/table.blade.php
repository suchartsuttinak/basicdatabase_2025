<div class="card border-0 shadow-sm rounded-4 table-card">
    <div class="card-header bg-white border-0 px-4 pt-4 pb-2">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <h5 class="section-title mb-1">รายการติดตามผลการเรียน</h5>
                <p class="section-subtitle mb-0">แสดงข้อมูลการติดตามทั้งหมด พร้อมเครื่องมือจัดการแต่ละรายการ</p>
            </div>
            <div class="section-badge">
                <i class="bi bi-table me-2"></i>{{ $followups->count() }} รายการ
            </div>
        </div>
    </div>

    <div class="card-body px-4 pb-4 pt-2">
        @if($followups->isNotEmpty())
            <div class="table-responsive">
                <table id="datatable-followup" class="table align-middle modern-table w-100 mb-0">
                    <thead>
                        <tr>
                            <th>วันที่ติดตาม</th>
                            <th>สถานศึกษา</th>
                            <th>ระดับชั้น</th>
                            <th>ครูประจำชั้น</th>
                            <th>โทรศัพท์</th>
                            <th class="text-center">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($followups as $item)
                            <tr>
                                <td>
                                    <div class="fw-semibold text-dark">
                                        {{ Carbon\Carbon::parse($item->follow_date)->format('d/m/Y') }}
                                    </div>
                                </td>
                                <td>{{ optional($item->educationRecord)->school_name ?? 'ไม่พบข้อมูล' }}</td>
                                <td>{{ optional(optional($item->educationRecord)->education)->education_name ?? 'ไม่พบข้อมูล' }}</td>
                                <td>{{ $item->teacher_name ?? '-' }}</td>
                                <td>{{ $item->tel ?? '-' }}</td>
                                <td class="text-center">
                                    <div class="d-flex flex-wrap justify-content-center gap-2 action-group">
                                        <button type="button"
                                                class="btn btn-warning btn-sm action-btn"
                                                onclick="openEditFollowup({{ $item->id }})">
                                            <i class="bi bi-pencil-square me-1"></i> แก้ไข
                                        </button>

                                        <button type="button"
                                                class="btn btn-danger btn-sm action-btn"
                                                onclick="confirmDelete({{ $item->id }})">
                                            <i class="bi bi-trash me-1"></i> ลบ
                                        </button>

                                        <a href="{{ route('school_followup.report', $item->id) }}"
                                           class="btn btn-info btn-sm action-btn text-white">
                                            <i class="bi bi-file-earmark-text me-1"></i> รายงาน
                                        </a>
                                    </div>

                                    <form id="delete-form-{{ $item->id }}"
                                          action="{{ route('school_followup.delete', $item->id) }}"
                                          method="POST"
                                          class="d-none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="bi bi-journal-x"></i>
                </div>
                <h5 class="empty-title">ยังไม่มีข้อมูลการติดตามผลการเรียน</h5>
                <p class="empty-text mb-3">เริ่มต้นเพิ่มข้อมูลการติดตามใหม่เพื่อให้ระบบสามารถจัดเก็บและออกรายงานได้</p>
                <button type="button"
                        class="btn btn-primary btn-action"
                        data-bs-toggle="modal"
                        data-bs-target="#followupModal">
                    <i class="bi bi-plus-circle-fill me-2"></i> เพิ่มการติดตามใหม่
                </button>
            </div>
        @endif
    </div>
</div>