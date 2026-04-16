<style>
/* =========================
   Job Agency Page Scoped CSS
   ========================= */

.ja-main-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    flex-wrap: wrap;
    padding: 1rem 1.25rem;
    margin-bottom: 1rem;
    background: #fff;
    border: 1px solid #e9edf5;
    border-radius: 18px;
    box-shadow: 0 8px 24px rgba(15, 23, 42, 0.05);
}

.ja-header-left {
    display: flex;
    align-items: center;
    gap: .9rem;
    min-width: 0;
}

.ja-header-icon {
    width: 48px;
    height: 48px;
    flex: 0 0 48px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 14px;
    background: linear-gradient(135deg, #0d6efd, #3b82f6);
    color: #fff;
    font-size: 1.1rem;
    box-shadow: 0 10px 20px rgba(13, 110, 253, 0.18);
}

.ja-header-text h6 {
    margin: 0 0 .2rem;
    font-size: 1.05rem;
    font-weight: 700;
    color: #0f172a;
}

.ja-header-text p {
    margin: 0;
    color: #64748b;
    font-size: .92rem;
}

.ja-header-actions {
    display: flex;
    align-items: center;
    gap: .65rem;
    flex-wrap: wrap;
}

.ja-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: .45rem;
    border-radius: 12px;
    padding: .62rem 1rem;
    font-weight: 600;
    white-space: nowrap;
}

/* filter */
.ja-filter-card {
    background: #fff;
    border: 1px solid #e9edf5;
    border-radius: 18px;
    padding: 1rem 1.1rem;
    margin-bottom: 1rem;
    box-shadow: 0 8px 24px rgba(15, 23, 42, 0.04);
}

.ja-filter-row {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    align-items: end;
}

.ja-filter-group {
    min-width: 190px;
    flex: 1 1 190px;
}

.ja-filter-group label {
    font-size: .88rem;
    font-weight: 600;
    color: #475569;
    margin-bottom: .38rem;
}

.ja-filter-actions {
    display: flex;
    flex-wrap: wrap;
    gap: .6rem;
}

.ja-btn-reset {
    border: 1px solid #dbe3ee;
}

/* table card */
.ja-table-card {
    background: #fff;
    border: 1px solid #e9edf5;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(15, 23, 42, 0.05);
}

.ja-table-head {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: .75rem;
    flex-wrap: wrap;
    padding: 1rem 1.1rem;
    border-bottom: 1px solid #eef2f7;
    background: linear-gradient(to right, #f8fbff, #ffffff);
}

.ja-table-title {
    display: inline-flex;
    align-items: center;
    gap: .55rem;
    font-weight: 700;
    color: #0f172a;
}

.ja-table-title i {
    color: #2563eb;
}

.ja-table-meta {
    font-size: .92rem;
    color: #64748b;
    font-weight: 600;
}

.ja-table-wrap {
    width: 100%;
    overflow-x: auto;
}

.ja-table {
    margin-bottom: 0;
    min-width: 860px;
}

.ja-table thead th {
    font-size: .9rem;
    font-weight: 700;
    color: #334155;
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    white-space: nowrap;
    padding: .95rem .85rem;
}

.ja-table tbody td {
    padding: .9rem .85rem;
    vertical-align: middle;
    border-color: #eef2f7;
}

.ja-cell {
    min-width: 120px;
    color: #0f172a;
}

.ja-income-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: .42rem .72rem;
    min-width: 92px;
    border-radius: 999px;
    background: #eff6ff;
    color: #1d4ed8;
    font-weight: 700;
    font-size: .9rem;
}

.ja-actions {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: .45rem;
    flex-wrap: nowrap;
    white-space: nowrap;
}

.ja-actions form {
    margin: 0;
    flex: 0 0 auto;
}

.ja-btn-sm {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: .35rem;
    padding: .5rem .78rem;
    font-size: .86rem;
    font-weight: 600;
    border-radius: 10px;
    white-space: nowrap;
    min-width: 84px;
}

.ja-empty {
    padding: 2rem 1rem;
    text-align: center;
    color: #64748b;
}

.ja-empty i {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 66px;
    height: 66px;
    border-radius: 50%;
    background: #f1f5f9;
    color: #2563eb;
    font-size: 1.5rem;
    margin-bottom: .85rem;
}

/* responsive */
@media (max-width: 991.98px) {
    .ja-header-actions,
    .ja-filter-actions {
        width: 100%;
    }

    .ja-header-actions .ja-btn,
    .ja-filter-actions .ja-btn,
    .ja-filter-actions .btn {
        flex: 1 1 auto;
    }
}

@media (max-width: 767.98px) {
    .ja-main-header,
    .ja-filter-card,
    .ja-table-head {
        padding: .95rem;
    }

    .ja-header-text h6 {
        font-size: 1rem;
    }

    .ja-header-text p {
        font-size: .86rem;
    }

    .ja-header-actions .ja-btn,
    .ja-filter-actions .btn {
        width: 100%;
    }

    /* ปุ่มแก้ไข/ลบ ต้องอยู่แถวเดียวกัน */
    .ja-actions {
        flex-direction: row;
        flex-wrap: nowrap;
        justify-content: center;
        align-items: center;
        gap: .4rem;
    }

    .ja-actions form {
        display: inline-block;
        width: auto;
    }

    .ja-btn-sm {
        width: auto;
        min-width: 76px;
        padding: .48rem .68rem;
        font-size: .82rem;
    }

    .ja-btn-sm span {
        display: inline;
    }
}

@media (max-width: 480px) {
    .ja-actions {
        gap: .35rem;
    }

    .ja-btn-sm {
        min-width: 70px;
        padding: .44rem .56rem;
        font-size: .78rem;
    }

    .ja-btn-sm i {
        font-size: .85rem;
    }
}
</style>


@if($jobAgencies->isNotEmpty())
    <div class="ja-table-card">
        <div class="ja-table-head">
            <div class="ja-table-title">
                <i class="bi bi-table"></i>
                <span>รายการจัดหางาน</span>
            </div>

            <div class="ja-table-meta">
                จำนวน {{ $jobAgencies->count() }} รายการ
            </div>
        </div>

        <div class="ja-table-wrap">
    <table id="datatable-jobagency" class="table table-hover align-middle ja-table">
        <thead>
            <tr>
                <th class="text-center">วันที่เริ่มงาน</th>
                <th>อาชีพ</th>
                <th>ตำแหน่ง</th>
                <th class="text-center">รายได้/เดือน</th>
                <th>บริษัท</th>
                <th class="text-center" style="width: 180px;">จัดการ</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($jobAgencies as $job)
                <tr>
                    <td class="text-center">
                        {{ \Carbon\Carbon::parse($job->job_date)->addYears(543)->format('d/m/Y') }}
                    </td>

                    <td>
                        <div class="ja-cell">{{ $job->occupation->occupation_name ?? '-' }}</div>
                    </td>

                    <td>
                        <div class="ja-cell">{{ $job->position ?? '-' }}</div>
                    </td>

                    <td class="text-center">
                        <span class="ja-income-badge">
                            {{ number_format($job->income ?? 0, 2) }}
                        </span>
                    </td>

                    <td>
                        <div class="ja-cell">{{ $job->company ?? '-' }}</div>
                    </td>

                    <td class="text-center">
                        <div class="ja-actions">
                            <button type="button"
                                    class="btn btn-warning ja-btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editJobAgencyModal{{ $job->id }}">
                                <i class="bi bi-pencil-square"></i>
                                <span>แก้ไข</span>
                            </button>

                            <form id="delete-form-job-{{ $job->id }}"
                                  action="{{ route('job_agencies.delete', $job->id) }}"
                                  method="POST"
                                  class="d-inline-block">
                                @csrf
                                @method('DELETE')

                                <button type="button"
                                        class="btn btn-danger ja-btn-sm"
                                        onclick="confirmDelete('delete-form-job-{{ $job->id }}', 'คุณต้องการลบข้อมูลนี้ใช่หรือไม่?')">
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
@else
    <div class="ja-table-card">
        <div class="ja-empty">
            <i class="bi bi-briefcase"></i>
            <div class="fw-bold mb-1">ยังไม่มีข้อมูลการจัดหางาน</div>
            <div class="small">เมื่อเพิ่มข้อมูลแล้ว รายการจะแสดงในตารางนี้</div>
        </div>
    </div>
@endif