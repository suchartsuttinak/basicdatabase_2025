{{-- Table Card --}}
<div class="escape-table-card">
    <div class="escape-table-card__header">
        <div class="escape-table-card__title-wrap">
            <div class="escape-table-card__icon">
                <i class="bi bi-table"></i>
            </div>
            <div>
                <h6 class="escape-table-card__title mb-0">รายการข้อมูลการออกจากสถานสงเคราะห์</h6>
                <div class="escape-table-card__subtitle">แสดงข้อมูลที่บันทึกไว้ทั้งหมด</div>
            </div>
        </div>

        <div class="escape-table-card__count">
            จำนวน {{ $escapes->count() }} รายการ
        </div>
    </div>

    <div class="escape-table-card__body p-0">
        @if($escapes->count() > 0)
            <div class="table-responsive escape-table-wrapper">
                <table class="table align-middle mb-0 escape-table">
                    <thead>
                        <tr>
                            {{-- <th style="min-width: 80px;" class="text-center">ลำดับ</th> --}}
                            <th style="min-width: 130px;">วันที่ออก</th>
                            <th style="min-width: 220px;">ติดตามล่าสุด</th>
                            <th style="min-width: 220px;">ประเภทการออก</th>
                            <th style="min-width: 280px;">พฤติการณ์ / สาเหตุ</th>
                            <th style="min-width: 320px;" class="text-center">การจัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($escapes as $escape)
                            @php
                                $latestFollow = $escape->follows
                                    ->sortByDesc(function ($follow) {
                                        return optional($follow->trace_date)?->timestamp ?? 0;
                                    })
                                    ->first();
                            @endphp

                            <tr>
                                {{-- <td class="text-center">
                                    <span class="escape-row-index">{{ $loop->iteration }}</span>
                                </td> --}}

                                <td>
                                    <div class="escape-table__date">
                                        {{ $escape->retire_date ? $escape->retire_date->addYears(543)->format('d/m/Y') : '-' }}
                                    </div>
                                </td>

                                <td>
                                    @if($latestFollow)
                                        <div class="escape-follow-summary">
                                            <span class="escape-date-chip">
                                                <i class="bi bi-calendar-event"></i>
                                                {{ $latestFollow->trace_date ? $latestFollow->trace_date->format('d/m/Y') : '-' }}
                                            </span>

                                            <span class="escape-count-badge">
                                                ครั้งที่ {{ $latestFollow->count }}
                                            </span>
                                        </div>
                                    @else
                                        <span class="escape-follow-empty">ยังไม่มีข้อมูล</span>
                                    @endif
                                </td>

                                <td>
                                    <div class="escape-table__primary">
                                        {{ $escape->retire->retire_name ?? '-' }}
                                    </div>
                                </td>

                                <td>
                                    <div class="escape-table__remark">
                                        {{ $escape->stories ?? '-' }}
                                    </div>
                                </td>

                                <td class="text-center">
                                    <div class="escape-action-group">
                                        <a href="{{ route('escape.edit', $escape->id) }}"
                                           class="btn escape-action-btn escape-action-btn--follow">
                                            <i class="bi bi-arrow-repeat"></i>
                                            <span>ติดตาม</span>
                                        </a>

                                        <a href="{{ route('escape.report', $escape->id) }}"
                                           class="btn escape-action-btn escape-action-btn--report">
                                            <i class="bi bi-file-earmark-text"></i>
                                            <span>รายงาน</span>
                                        </a>

                                        <button type="button"
                                                class="btn escape-action-btn escape-action-btn--edit"
                                                data-bs-toggle="modal"
                                                data-bs-target="#escapeEditModal{{ $escape->id }}">
                                            <i class="bi bi-pencil-square"></i>
                                            <span>แก้ไข</span>
                                        </button>

                                        <form id="delete-form-{{ $escape->id }}"
                                              action="{{ route('escape.delete', $escape->id) }}"
                                              method="POST"
                                              class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                    class="btn escape-action-btn escape-action-btn--delete"
                                                    onclick="confirmDelete('delete-form-{{ $escape->id }}','คุณต้องการลบข้อมูลนี้ใช่หรือไม่')">
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
        @else
            <div class="escape-empty-state">
                <div class="escape-empty-state__icon">
                    <i class="bi bi-inboxes"></i>
                </div>
                <div class="escape-empty-state__title">ยังไม่มีข้อมูลการออกจากสถานสงเคราะห์</div>
                <div class="escape-empty-state__desc">เมื่อมีการบันทึกข้อมูล รายการจะแสดงในส่วนนี้</div>
            </div>
        @endif
    </div>
</div>

<style>
/* ปรับเฉพาะส่วนตารางหน้านี้ ไม่กระทบหน้าอื่น */
.escape-page .escape-action-group{
    display:flex;
    flex-wrap:wrap;
    justify-content:center;
    align-items:center;
    gap:8px;
}

.escape-page .escape-action-group .escape-action-btn{
    white-space:nowrap;
}

.escape-page .escape-action-btn--report{
    border:1px solid #0dcaf0;
    color:#0c8599;
    background:#eefcff;
}

.escape-page .escape-action-btn--report:hover{
    background:#d9f7ff;
    color:#0b7285;
}

.escape-page .escape-follow-summary{
    display:flex;
    align-items:center;
    flex-wrap:wrap;
    gap:6px;
}

.escape-page .escape-date-chip{
    display:inline-flex;
    align-items:center;
    gap:6px;
    padding:7px 12px;
    border-radius:999px;
    background:linear-gradient(135deg,#eef4ff 0%,#dbeafe 100%);
    color:#1d4ed8;
    font-weight:700;
    font-size:.84rem;
    white-space:nowrap;
}

.escape-page .escape-count-badge{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    padding:7px 12px;
    border-radius:999px;
    background:linear-gradient(135deg,#fff7ed 0%,#ffedd5 100%);
    color:#c2410c;
    font-weight:800;
    font-size:.84rem;
    white-space:nowrap;
}

.escape-page .escape-follow-empty{
    color:#94a3b8;
    font-size:.9rem;
}

@media (max-width: 767.98px){
    .escape-page .escape-action-group{
        min-width:max-content;
        flex-wrap:nowrap;
    }

    .escape-page .escape-follow-summary{
        min-width:170px;
    }

    .escape-page .escape-date-chip,
    .escape-page .escape-count-badge{
        font-size:.8rem;
        padding:6px 10px;
    }
}
</style>