@extends('admin.admin_master')
@section('admin')

<style>
    .operation-page{
        --op-primary: #2563eb;
        --op-primary-dark: #1d4ed8;
        --op-success: #059669;
        --op-warning: #f59e0b;
        --op-warning-dark: #ea580c;
        --op-danger: #ef4444;
        --op-danger-dark: #dc2626;
        --op-text: #0f172a;
        --op-muted: #64748b;
        --op-border: #e2e8f0;
        --op-soft: #f8fafc;
        --op-soft-2: #f1f5f9;
        --op-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
        --op-shadow-sm: 0 4px 14px rgba(15, 23, 42, 0.08);
    }

    .operation-page .operation-card{
        border: 0;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: var(--op-shadow);
        background: #fff;
    }

    .operation-page .operation-card-header{
        background:
            radial-gradient(circle at top left, rgba(37, 99, 235, 0.10), transparent 35%),
            linear-gradient(135deg, #ffffff 0%, #f8fbff 100%);
        border-bottom: 1px solid rgba(226, 232, 240, 0.85);
        padding: 1.25rem 1.5rem;
    }

    .operation-page .operation-title-wrap{
        display: flex;
        align-items: flex-start;
        gap: 1rem;
    }

    .operation-page .operation-title-icon{
        width: 52px;
        height: 52px;
        flex: 0 0 52px;
        border-radius: 16px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #dbeafe 0%, #eff6ff 100%);
        color: var(--op-primary);
        font-size: 1.35rem;
        box-shadow: inset 0 0 0 1px rgba(37, 99, 235, 0.08);
    }

    .operation-page .operation-title{
        margin: 0;
        font-size: 1.35rem;
        font-weight: 800;
        color: var(--op-text);
        letter-spacing: -.01em;
    }

    .operation-page .operation-subtitle{
        margin-top: .25rem;
        color: var(--op-muted);
        font-size: .94rem;
        line-height: 1.6;
    }

    .operation-page .operation-top-actions{
        display: flex;
        flex-wrap: wrap;
        gap: .75rem;
        justify-content: flex-end;
        align-items: center;
    }

    .operation-page .op-btn{
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: .5rem;
        min-height: 42px;
        padding: .68rem 1.15rem;
        border-radius: 999px;
        border: 1px solid transparent;
        font-size: .92rem;
        font-weight: 700;
        line-height: 1;
        text-decoration: none;
        transition: all .22s ease;
        white-space: nowrap;
        box-shadow: var(--op-shadow-sm);
    }

    .operation-page .op-btn i{
        font-size: 1rem;
        line-height: 1;
    }

    .operation-page .op-btn-report{
        color: #fff;
        background: linear-gradient(135deg, var(--op-primary) 0%, var(--op-primary-dark) 100%);
    }

    .operation-page .op-btn-report:hover{
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 10px 24px rgba(37, 99, 235, 0.24);
        background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
    }

    .operation-page .op-btn-create{
        color: #fff;
        background: linear-gradient(135deg, #10b981 0%, var(--op-success) 100%);
    }

    .operation-page .op-btn-create:hover{
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 10px 24px rgba(5, 150, 105, 0.22);
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
    }

    .operation-page .operation-card-body{
        padding: 1.5rem;
    }

    .operation-page .operation-alert{
        border: 0;
        border-radius: 16px;
        box-shadow: var(--op-shadow-sm);
        padding: .95rem 1rem;
        margin-bottom: 1.25rem;
    }

    .operation-page .operation-filter-box{
        background: linear-gradient(180deg, #fbfdff 0%, #f8fafc 100%);
        border: 1px solid var(--op-border);
        border-radius: 20px;
        padding: 1rem;
        margin-bottom: 1.25rem;
    }

    .operation-page .operation-filter-label{
        font-size: .88rem;
        font-weight: 700;
        color: #334155;
        margin-bottom: .45rem;
    }

    .operation-page .operation-input,
    .operation-page .operation-select{
        min-height: 44px;
        border-radius: 14px;
        border: 1px solid #dbe3ee;
        background: #fff;
        color: var(--op-text);
        font-size: .93rem;
        box-shadow: none;
        transition: all .2s ease;
    }

    .operation-page .operation-input:focus,
    .operation-page .operation-select:focus{
        border-color: rgba(37, 99, 235, 0.45);
        box-shadow: 0 0 0 .22rem rgba(37, 99, 235, 0.10);
    }

    .operation-page .operation-filter-actions{
        display: flex;
        gap: .65rem;
        flex-wrap: wrap;
        align-items: end;
        height: 100%;
    }

    .operation-page .op-filter-btn{
        min-height: 44px;
        padding: .72rem 1.15rem;
        border-radius: 14px;
        font-size: .9rem;
        font-weight: 700;
        border: 1px solid transparent;
        transition: all .2s ease;
        text-decoration: none;
    }

    .operation-page .op-filter-btn-search{
        background: #0f172a;
        color: #fff;
    }

    .operation-page .op-filter-btn-search:hover{
        background: #020617;
        color: #fff;
    }

    .operation-page .op-filter-btn-reset{
        background: #fff;
        color: #475569;
        border-color: #dbe3ee;
    }

    .operation-page .op-filter-btn-reset:hover{
        background: #f8fafc;
        color: #0f172a;
    }

    .operation-page .operation-table-shell{
        border: 1px solid var(--op-border);
        border-radius: 20px;
        overflow: hidden;
        background: #fff;
    }

    .operation-page .operation-table-scroll{
        width: 100%;
        overflow-x: auto;
        overflow-y: hidden;
        -webkit-overflow-scrolling: touch;
    }

    .operation-page .operation-table{
        width: 100%;
        min-width: 1120px;
        margin: 0;
        border-collapse: separate;
        border-spacing: 0;
    }

    .operation-page .operation-table thead th{
        background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
        color: #334155;
        font-size: .88rem;
        font-weight: 800;
        padding: 1rem .9rem;
        border-bottom: 1px solid var(--op-border);
        white-space: nowrap;
        vertical-align: middle;
    }

    .operation-page .operation-table tbody td{
        padding: 1rem .9rem;
        vertical-align: top;
        color: var(--op-text);
        border-bottom: 1px solid #eef2f7;
        background: #fff;
        font-size: .93rem;
    }

    .operation-page .operation-table tbody tr:hover td{
        background: #fcfdff;
    }

    .operation-page .operation-table tbody tr:last-child td{
        border-bottom: 0;
    }

    .operation-page .operation-id-badge{
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 38px;
        min-height: 38px;
        padding: .35rem .6rem;
        border-radius: 12px;
        background: #f8fafc;
        color: #334155;
        font-weight: 800;
        border: 1px solid #e2e8f0;
    }

    .operation-page .operation-date-text{
        font-weight: 700;
        color: #0f172a;
        white-space: nowrap;
    }

    .operation-page .operation-seq-badge{
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: .52rem .85rem;
        border-radius: 999px;
        background: #eff6ff;
        color: #1d4ed8;
        font-size: .86rem;
        font-weight: 800;
        white-space: nowrap;
    }

    .operation-page .operation-user-pill{
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        padding: .45rem .8rem;
        border-radius: 999px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        color: #334155;
        font-weight: 700;
        font-size: .86rem;
        white-space: nowrap;
    }

    .operation-page .operation-text-wrap{
        white-space: normal;
        word-break: break-word;
        line-height: 1.6;
        color: #0f172a;
    }

    .operation-page .operation-empty{
        padding: 3rem 1rem;
        text-align: center;
        color: #64748b;
    }

    .operation-page .operation-empty i{
        font-size: 2rem;
        display: block;
        margin-bottom: .75rem;
        color: #94a3b8;
    }

    .operation-page .operation-row-actions{
        display: flex;
        flex-wrap: wrap;
        gap: .5rem;
        justify-content: center;
        align-items: center;
    }

    .operation-page .operation-row-btn{
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: .42rem;
        min-height: 36px;
        padding: .55rem .95rem;
        border-radius: 999px;
        border: 1px solid transparent;
        font-size: .84rem;
        font-weight: 700;
        line-height: 1;
        text-decoration: none;
        transition: all .2s ease;
        white-space: nowrap;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.08);
    }

    .operation-page .operation-row-btn i{
        font-size: .92rem;
        line-height: 1;
    }

    .operation-page .operation-row-btn-edit{
        color: #fff;
        background: linear-gradient(135deg, var(--op-warning) 0%, var(--op-warning-dark) 100%);
    }

    .operation-page .operation-row-btn-edit:hover{
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 10px 20px rgba(245, 158, 11, 0.24);
        background: linear-gradient(135deg, #d97706 0%, #c2410c 100%);
    }

    .operation-page .operation-row-btn-delete{
        color: #fff;
        background: linear-gradient(135deg, var(--op-danger) 0%, var(--op-danger-dark) 100%);
    }

    .operation-page .operation-row-btn-delete:hover{
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 10px 20px rgba(239, 68, 68, 0.24);
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
    }

    .operation-page .operation-delete-form{
        margin: 0;
    }

    .operation-page .operation-pagination{
        margin-top: 1.25rem;
    }

    /* ===== FILTER BUTTON FIX ===== */
.operation-page .operation-filter-btn-group{
    display: flex;
    gap: .6rem;
    align-items: center;
    justify-content: flex-start;
    height: 100%;
}

/* ปุ่มพื้นฐาน */
.operation-page .op-btn-search,
.operation-page .op-btn-reset{
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: .45rem;
    min-height: 44px;
    padding: .65rem 1.2rem;
    border-radius: 14px;
    font-size: .9rem;
    font-weight: 700;
    white-space: nowrap;
    transition: all .2s ease;
    border: none;
}

/* ปุ่มค้นหา */
.operation-page .op-btn-search{
    background: #0f172a;
    color: #fff;
}

.operation-page .op-btn-search:hover{
    background: #020617;
    transform: translateY(-1px);
}

/* ปุ่มรีเซ็ต */
.operation-page .op-btn-reset{
    background: #fff;
    color: #475569;
    border: 1px solid #dbe3ee;
}

.operation-page .op-btn-reset:hover{
    background: #f1f5f9;
    color: #0f172a;
}

/* ===== RESPONSIVE ===== */

/* Tablet */
@media (max-width: 991.98px){
    .operation-page .operation-filter-btn-group{
        margin-top: .3rem;
    }
}

/* Mobile */
@media (max-width: 575.98px){
    .operation-page .operation-filter-btn-group{
        flex-direction: column;
        width: 100%;
    }

    .operation-page .op-btn-search,
    .operation-page .op-btn-reset{
        width: 100%;
        border-radius: 12px;
    }
}

    @media (max-width: 1199.98px){
        .operation-page .operation-card-header,
        .operation-page .operation-card-body{
            padding: 1.25rem;
        }
    }

    @media (max-width: 991.98px){
        .operation-page .operation-card-header{
            padding: 1.1rem 1rem;
        }

        .operation-page .operation-card-body{
            padding: 1rem;
        }

        .operation-page .operation-title{
            font-size: 1.18rem;
        }

        .operation-page .operation-top-actions{
            width: 100%;
            justify-content: flex-start;
        }

        .operation-page .op-btn{
            min-height: 40px;
            padding: .62rem 1rem;
            font-size: .88rem;
        }

        .operation-page .operation-filter-actions{
            align-items: stretch;
        }

        .operation-page .op-filter-btn{
            flex: 1 1 auto;
            text-align: center;
        }
    }

    @media (max-width: 575.98px){
        .operation-page .operation-title-wrap{
            gap: .8rem;
        }

        .operation-page .operation-title-icon{
            width: 46px;
            height: 46px;
            flex-basis: 46px;
            border-radius: 14px;
            font-size: 1.15rem;
        }

        .operation-page .operation-title{
            font-size: 1.05rem;
        }

        .operation-page .operation-subtitle{
            font-size: .88rem;
        }

        .operation-page .operation-top-actions{
            display: grid;
            grid-template-columns: 1fr;
            width: 100%;
        }

        .operation-page .operation-top-actions .op-btn{
            width: 100%;
            border-radius: 14px;
        }

        .operation-page .operation-filter-box{
            padding: .9rem;
            border-radius: 18px;
        }

        .operation-page .operation-filter-actions{
            display: grid;
            grid-template-columns: 1fr;
            width: 100%;
        }

        .operation-page .op-filter-btn{
            width: 100%;
        }

        .operation-page .operation-row-actions{
            display: grid;
            grid-template-columns: 1fr;
            width: 100%;
        }

        .operation-page .operation-row-actions > a,
        .operation-page .operation-row-actions > form{
            width: 100%;
        }

        .operation-page .operation-row-btn{
            width: 100%;
            min-height: 40px;
            border-radius: 14px;
        }
    }
</style>

<div class="container-fluid py-3 operation-page">
    <div class="operation-card">
        <div class="operation-card-header">
            <div class="row g-3 align-items-center">
                <div class="col-xl-7 col-lg-7">
                    <div class="operation-title-wrap">
                        <div class="operation-title-icon">
                            <i class="bi bi-journal-text"></i>
                        </div>

                        <div>
                            <h4 class="operation-title">รายงานการปฏิบัติงานประจำวัน</h4>
                            <div class="operation-subtitle">
                                บันทึก ติดตาม และจัดการข้อมูลการปฏิบัติงานประจำวันของพนักงาน
                                พร้อมค้นหาและดูรายงานรายวันได้สะดวก
                            </div>
                        </div>
                    </div>
                </div>

             <div class="col-xl-5 col-lg-5">
                    <div class="operation-top-actions">

                        <a href="{{ route('operations.report.daily', request()->only(['keyword', 'start_date', 'end_date'])) }}"
                        class="op-btn op-btn-report">
                            <i class="bi bi-file-earmark-text"></i>
                            <span>รายงานรายวัน</span>
                        </a>

                        <a href="{{ route('operations.create') }}"
                        class="op-btn op-btn-create">
                            <i class="bi bi-plus-circle"></i>
                            <span>เพิ่มรายงาน</span>
                        </a>

                    </div>
                </div>
            </div>
        </div>

        <div class="operation-card-body">
            @if(session('success'))
                <div class="alert alert-success operation-alert">
                    <i class="bi bi-check-circle-fill me-1"></i>
                    {{ session('success') }}
                </div>
            @endif

       <form method="GET" action="{{ route('operations.index') }}" class="operation-filter-box">
                <div class="row g-3 align-items-end">

                <div class="col-lg-4 col-md-6">
                <label class="operation-filter-label">
                    <i class="bi bi-search me-1"></i>
                    ค้นหาคำสำคัญ
                </label>

                <input
                    type="text"
                    name="keyword"
                    value="{{ request('keyword') }}"
                    class="form-control operation-input"
                    placeholder="ค้นหาเรื่อง / ผล / หมายเหตุ / ชื่อผู้ดำเนินงาน"
                >

                <small class="text-muted mt-1 d-block">
                    ค้นหาได้จากชื่อผู้ดำเนินงาน เรื่อง ผลการดำเนินงาน หรือหมายเหตุ
                </small>
            </div>
        <div class="col-lg-3 col-md-6">
            <label class="operation-filter-label">ตั้งแต่วันที่</label>
            <input
                type="date"
                name="start_date"
                value="{{ request('start_date') }}"
                class="form-control operation-input"
            >
        </div>

        <div class="col-lg-3 col-md-6">
            <label class="operation-filter-label">ถึงวันที่</label>
            <input
                type="date"
                name="end_date"
                value="{{ request('end_date') }}"
                class="form-control operation-input"
            >
        </div>

        <div class="col-lg-2 col-md-6">
            <div class="operation-filter-btn-group">
                <button type="submit" class="btn op-btn-search">
                    <i class="bi bi-search"></i>
                    <span>ค้นหา</span>
                </button>

                <a href="{{ route('operations.index') }}" class="btn op-btn-reset">
                    <i class="bi bi-arrow-clockwise"></i>
                    <span>รีเซ็ต</span>
                </a>
            </div>
        </div>

    </div>
</form>
            <div class="operation-table-shell">
                <div class="operation-table-scroll">
                    <table class="table operation-table align-middle">
                        <thead>
                            <tr>
                                {{-- <th class="text-center" style="width: 78px;">#</th> --}}
                                <th style="min-width: 140px;">วันที่</th>
                                <th class="text-center" style="min-width: 110px;">ครั้งที่</th>
                                <th style="min-width: 240px;">เรื่องที่ดำเนินงาน</th>
                                <th style="min-width: 240px;">ผลการดำเนินงาน</th>
                                <th style="min-width: 200px;">หมายเหตุ</th>
                                <th style="min-width: 160px;">ผู้ดำเนินงาน</th>
                                <th class="text-center" style="min-width: 170px;">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($operations as $key => $item)
                                <tr>
                                    {{-- <td class="text-center">
                                        <span class="operation-id-badge">
                                            {{ $operations->firstItem() + $key }}
                                        </span>
                                    </td> --}}

                                    <td>
                                        <div class="operation-date-text">
                                            {{ \Carbon\Carbon::parse($item->operation_date)->addYears(543)->format('d/m/Y') }}
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <span class="operation-seq-badge">
                                            ครั้งที่ {{ $item->sequence_no }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="operation-text-wrap">
                                            {{ $item->subject ?: '-' }}
                                        </div>
                                    </td>

                                    <td>
                                        <div class="operation-text-wrap">
                                            {{ $item->result ?: '-' }}
                                        </div>
                                    </td>

                                    <td>
                                        <div class="operation-text-wrap">
                                            {{ $item->remark ?: '-' }}
                                        </div>
                                    </td>

                                    <td>
                                        <span class="operation-user-pill">
                                            <i class="bi bi-person-circle"></i>
                                            {{ $item->user->name ?? '-' }}
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        <div class="operation-row-actions">
                                            <a href="{{ route('operations.edit', $item->id) }}"
                                               class="operation-row-btn operation-row-btn-edit">
                                                <i class="bi bi-pencil-square"></i>
                                                <span>แก้ไข</span>
                                            </a>

                                        <form action="{{ route('operations.delete', $item->id) }}"
                                                method="POST"
                                                class="operation-delete-form delete-operation-form">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="btn operation-row-btn operation-row-btn-delete">
                                                    <i class="bi bi-trash"></i>
                                                    <span>ลบ</span>
                                                </button>

                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">
                                        <div class="operation-empty">
                                            <i class="bi bi-inbox"></i>
                                            ยังไม่มีข้อมูลรายงานการปฏิบัติงาน
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($operations->hasPages())
                <div class="operation-pagination">
                    {{ $operations->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function () {

    const deleteForms = document.querySelectorAll('.delete-operation-form');

    deleteForms.forEach(form => {

        form.addEventListener('submit', function (e) {

            e.preventDefault();

            Swal.fire({
                title: 'ยืนยันการลบรายการ ?',
                text: 'เมื่อดำเนินการแล้วจะไม่สามารถกู้คืนข้อมูลได้',
                icon: 'warning',

                showCancelButton: true,

                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#64748b',

                confirmButtonText: '<i class="bi bi-trash me-1"></i> ลบข้อมูล',
                cancelButtonText: 'ยกเลิก',

                reverseButtons: true,
                focusCancel: true,
            }).then((result) => {

                if (result.isConfirmed) {
                    form.submit();
                }

            });

        });

    });

});
</script>