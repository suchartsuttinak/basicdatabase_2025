           <style>
    /* =========================
       CaseOutside Table Fix Only
       จำกัดผลกระทบเฉพาะการ์ดตารางนี้
    ========================= */
    .co-table-card {
        border: 1px solid #dbe3ef;
        border-radius: 18px;
        background: #fff;
        overflow: hidden;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
    }

    .co-table-card .co-table-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
        padding: 1rem 1.25rem;
        border-bottom: 1px solid #dbe3ef;
        background: #fff;
    }

    .co-table-card .co-table-title {
        display: flex;
        align-items: center;
        gap: .6rem;
        font-weight: 800;
        color: #0f172a;
    }

    .co-table-card .co-table-title i {
        color: #4f6edb;
    }

    .co-table-card .co-table-meta {
        font-size: .92rem;
        font-weight: 700;
        color: #64748b;
    }

    .co-table-card .co-table-wrap {
        width: 100%;
        overflow-x: auto;
        overflow-y: hidden;
        -webkit-overflow-scrolling: touch;
        background: #fff;
    }

    .co-table-card .co-table-wrap::-webkit-scrollbar {
        height: 10px;
    }

    .co-table-card .co-table-wrap::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 999px;
    }

    /* ===== Table หลัก ===== */
    .co-table-card table.co-table {
        width: 100% !important;
        min-width: 1100px;
        margin: 0 !important;
        border-collapse: separate;
        border-spacing: 0;
        vertical-align: middle;
    }

    .co-table-card table.co-table thead th {
        background: #f8fbff;
        color: #334155;
        font-size: .86rem;
        font-weight: 800;
        text-align: center;
        white-space: nowrap;
        padding: .95rem .75rem;
        border-bottom: 1px solid #dbe3ef !important;
        vertical-align: middle;
    }

    .co-table-card table.co-table tbody td {
        padding: .9rem .75rem;
        font-size: .92rem;
        color: #334155;
        border-top: 0;
        border-bottom: 1px solid #eef2f7;
        vertical-align: middle;
        background: #fff;
    }

    .co-table-card table.co-table tbody tr:hover td {
        background: #fbfdff;
    }

    .co-table-card table.co-table th,
    .co-table-card table.co-table td {
        box-sizing: border-box;
    }

    .co-table-card .co-cell {
        min-width: 120px;
        word-break: break-word;
        white-space: normal;
    }

    .co-table-card .co-cell-result {
        min-width: 180px;
        max-width: 280px;
        word-break: break-word;
        white-space: normal;
    }

    /* คุมคอลัมน์ action ไม่ให้ยุบ */
    .co-table-card table.co-table th:last-child,
    .co-table-card table.co-table td:last-child {
        min-width: 180px;
        white-space: nowrap;
    }

    .co-table-card .co-actions {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: .5rem;
        flex-wrap: nowrap;
        min-width: max-content;
    }

    .co-table-card .co-actions .btn,
    .co-table-card .co-actions button {
        min-width: 88px;
        height: 38px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: .35rem;
        padding: .45rem .8rem;
        border-radius: 10px;
        font-size: .875rem;
        font-weight: 700;
        white-space: nowrap;
    }

    /* ===== Fix DataTables wrapper ===== */
    .co-table-card #datatable-caseoutside_wrapper {
        padding: 0;
    }

    .co-table-card #datatable-caseoutside_wrapper .row {
        margin-left: 0;
        margin-right: 0;
    }

    .co-table-card #datatable-caseoutside_wrapper .row > div {
        padding-left: .75rem;
        padding-right: .75rem;
    }

    /* ส่วนบน */
    .co-table-card #datatable-caseoutside_wrapper .dataTables_length,
    .co-table-card #datatable-caseoutside_wrapper .dataTables_filter {
        padding-top: .85rem;
        padding-bottom: .65rem;
    }

    .co-table-card #datatable-caseoutside_wrapper .dataTables_length {
        display: flex;
        align-items: center;
        gap: .5rem;
        flex-wrap: wrap;
        color: #475569;
        font-size: .9rem;
        font-weight: 600;
    }

    .co-table-card #datatable-caseoutside_wrapper .dataTables_length label {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        margin-bottom: 0;
        font-weight: 600;
    }

    .co-table-card #datatable-caseoutside_wrapper .dataTables_length select {
        min-width: 64px;
        height: 38px;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        padding: .35rem 2rem .35rem .75rem;
        background-color: #fff;
        box-shadow: none;
    }

    .co-table-card #datatable-caseoutside_wrapper .dataTables_filter {
        text-align: right;
    }

    .co-table-card #datatable-caseoutside_wrapper .dataTables_filter label {
        display: inline-flex;
        align-items: center;
        justify-content: flex-end;
        gap: .5rem;
        margin-bottom: 0;
        width: 100%;
        color: #475569;
        font-size: .9rem;
        font-weight: 600;
    }

    .co-table-card #datatable-caseoutside_wrapper .dataTables_filter input {
        width: 220px;
        max-width: 100%;
        height: 38px;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        padding: .45rem .75rem;
        margin-left: 0 !important;
        box-shadow: none;
        background: #fff;
    }

    /* table area */
    .co-table-card #datatable-caseoutside_wrapper .dataTables_scroll,
    .co-table-card #datatable-caseoutside_wrapper .dataTables_scrollHead,
    .co-table-card #datatable-caseoutside_wrapper .dataTables_scrollBody {
        border: 0 !important;
    }

    .co-table-card #datatable-caseoutside_wrapper .dataTables_scrollHeadInner,
    .co-table-card #datatable-caseoutside_wrapper .dataTables_scrollHeadInner table,
    .co-table-card #datatable-caseoutside_wrapper .dataTables_scrollBody table {
        width: 100% !important;
        min-width: 1100px;
    }

    .co-table-card #datatable-caseoutside_wrapper .dataTables_scrollBody {
        overflow-x: auto !important;
        overflow-y: auto !important;
    }

    /* ส่วนล่าง */
    .co-table-card #datatable-caseoutside_wrapper .dataTables_info,
    .co-table-card #datatable-caseoutside_wrapper .dataTables_paginate {
        padding-top: .85rem;
        padding-bottom: .9rem;
        color: #64748b;
        font-size: .9rem;
    }

    .co-table-card #datatable-caseoutside_wrapper .dataTables_paginate {
        display: flex;
        justify-content: flex-end;
    }

    .co-table-card #datatable-caseoutside_wrapper .pagination {
        margin-bottom: 0;
        gap: .2rem;
        flex-wrap: wrap;
    }

    .co-table-card #datatable-caseoutside_wrapper .paginate_button .page-link {
        border-radius: 10px !important;
        min-width: 38px;
        height: 38px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #dbe3ef;
        color: #475569;
        padding: .45rem .75rem;
        box-shadow: none !important;
    }

    .co-table-card #datatable-caseoutside_wrapper .paginate_button.active .page-link {
        background: #4f6edb;
        border-color: #4f6edb;
        color: #fff;
    }

    /* sort icon spacing */
    .co-table-card table.dataTable thead > tr > th.sorting,
    .co-table-card table.dataTable thead > tr > th.sorting_asc,
    .co-table-card table.dataTable thead > tr > th.sorting_desc {
        padding-right: 2rem !important;
    }

    /* responsive */
    @media (max-width: 767.98px) {
        .co-table-card .co-table-head {
            padding: .9rem 1rem;
        }

        .co-table-card #datatable-caseoutside_wrapper .dataTables_length,
        .co-table-card #datatable-caseoutside_wrapper .dataTables_filter,
        .co-table-card #datatable-caseoutside_wrapper .dataTables_info,
        .co-table-card #datatable-caseoutside_wrapper .dataTables_paginate {
            text-align: left !important;
        }

        .co-table-card #datatable-caseoutside_wrapper .dataTables_filter label {
            justify-content: flex-start;
        }

        .co-table-card #datatable-caseoutside_wrapper .dataTables_filter input {
            width: 100%;
        }

        .co-table-card #datatable-caseoutside_wrapper .dataTables_paginate {
            justify-content: flex-start;
        }
    }
</style>

<div class="co-table-card">
    <div class="co-table-head">
        <div class="co-table-title">
            <i class="bi bi-table"></i>
            <span>รายการติดตาม</span>
        </div>
        <div class="co-table-meta">จำนวน {{ $caseoutsides->count() }} รายการ</div>
    </div>

   <div class="co-table-wrap">
    <table id="datatable-caseoutside" class="table table-hover align-middle co-table">
        <thead>
            <tr>
                <th>วันที่ติดตาม</th>
                <th style="width:8%;">ครั้งที่</th>
                <th>สาเหตุที่พักภายนอก</th>
                <th>สถานที่พัก</th>
                <th>การดำเนินงาน</th>
                <th>ผลการติดตาม</th>
                <th style="width:15%;">จัดการ</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($caseoutsides as $case)
                <tr>
                    <td class="text-center">
                        {{ \Carbon\Carbon::parse($case->date)->addYears(543)->format('d/m/Y') }}
                    </td>

                    <td class="text-center">{{ $case->count }}</td>

                    <td>
                        <div class="co-cell">{{ $case->outside->outside_name ?? '-' }}</div>
                    </td>

                    <td>
                        <div class="co-cell">{{ $case->dormitory ?? '-' }}</div>
                    </td>

                    <td>
                        <div class="co-cell">{{ $case->follo_no ?? '-' }}</div>
                    </td>

                    <td>
                        <div class="co-cell-result">{{ $case->results ?? '-' }}</div>
                    </td>

                    <td class="text-center">
                        <div class="co-actions">
                            <button type="button"
                                    class="btn btn-warning"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editCaseOutsideModal{{ $case->id }}">
                                <i class="bi bi-pencil-square"></i>
                                <span>แก้ไข</span>
                            </button>

                            <form id="delete-form-caseoutside-{{ $case->id }}"
                                  action="{{ route('case_outside.delete', $case->id) }}"
                                  method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')

                                <button type="button"
                                        class="btn btn-danger"
                                        onclick="confirmDelete('delete-form-caseoutside-{{ $case->id }}', 'คุณต้องการลบข้อมูลการติดตามนี้ใช่หรือไม่')">
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const tableEl = document.getElementById('datatable-caseoutside');

    if (!tableEl) return;

    function adjustCaseOutsideTable() {
        if (window.jQuery && jQuery.fn.DataTable && jQuery.fn.DataTable.isDataTable(tableEl)) {
            const dt = jQuery(tableEl).DataTable();
            dt.columns.adjust();
            if (dt.responsive && typeof dt.responsive.recalc === 'function') {
                dt.responsive.recalc();
            }
        }
    }

    setTimeout(adjustCaseOutsideTable, 150);
    window.addEventListener('resize', adjustCaseOutsideTable);

    document.querySelectorAll('[data-bs-toggle="modal"]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            setTimeout(adjustCaseOutsideTable, 200);
        });
    });

    if (window.jQuery) {
        jQuery(tableEl).on('draw.dt', function () {
            adjustCaseOutsideTable();
        });
    }
});
</script>
@endpush