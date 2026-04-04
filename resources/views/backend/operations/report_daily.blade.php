@extends('admin.admin_master')
@section('admin')

<div class="container-fluid py-3 operation-report-page">

    <style>
    .operation-report-page{
        --rp-primary: #2563eb;
        --rp-primary-dark: #1d4ed8;
        --rp-primary-soft: #eff6ff;
        --rp-primary-soft-2: #dbeafe;
        --rp-dark: #0f172a;
        --rp-text: #1e293b;
        --rp-muted: #64748b;
        --rp-border: #e2e8f0;
        --rp-border-soft: #eef2f7;
        --rp-bg-soft: #f8fafc;
        --rp-white: #ffffff;
        --rp-shadow: 0 12px 32px rgba(15, 23, 42, 0.08);
        --rp-shadow-soft: 0 6px 18px rgba(15, 23, 42, 0.06);
    }

    .operation-report-page .report-card{
        border: 0;
        border-radius: 24px;
        box-shadow: var(--rp-shadow);
        overflow: hidden;
        background: var(--rp-white);
    }

    .operation-report-page .report-topbar{
        background:
            radial-gradient(circle at top left, rgba(59, 130, 246, 0.16), transparent 30%),
            linear-gradient(135deg, #f8fbff 0%, #eff6ff 45%, #dbeafe 100%);
        border-bottom: 1px solid var(--rp-border);
        padding: 1.1rem 1.5rem;
    }

    .operation-report-page .report-topbar-inner{
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .operation-report-page .report-topbar-title{
        font-size: 1.15rem;
        font-weight: 800;
        letter-spacing: -.01em;
        margin: 0;
        color: #1e3a8a;
    }

    .operation-report-page .report-topbar-subtitle{
        margin-top: .2rem;
        font-size: .92rem;
        color: #475569;
        line-height: 1.6;
    }

    .operation-report-page .report-shell{
        padding: 1.5rem;
        background:
            radial-gradient(circle at top right, rgba(37, 99, 235, 0.05), transparent 22%),
            linear-gradient(180deg, #ffffff 0%, #fbfdff 100%);
    }

    .operation-report-page .report-paper{
        border: 1px solid var(--rp-border);
        border-radius: 24px;
        overflow: hidden;
        background: #fff;
        box-shadow: var(--rp-shadow-soft);
    }

    .operation-report-page .report-paper-header{
        padding: 1.5rem 1.5rem 1.2rem;
        border-bottom: 1px solid var(--rp-border);
        background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
    }

    .operation-report-page .report-paper-title{
        text-align: center;
        margin-bottom: 1rem;
    }

    .operation-report-page .report-paper-title h1{
        margin: 0;
        font-size: 1.45rem;
        font-weight: 800;
        color: var(--rp-dark);
        line-height: 1.4;
    }

    .operation-report-page .report-paper-title p{
        margin: .35rem 0 0;
        font-size: .94rem;
        color: var(--rp-muted);
    }

    .operation-report-page .report-meta-grid{
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: .9rem;
    }

    .operation-report-page .report-meta-card{
        border: 1px solid var(--rp-border);
        background: var(--rp-bg-soft);
        border-radius: 18px;
        padding: .95rem 1rem;
    }

    .operation-report-page .report-meta-label{
        display: block;
        font-size: .8rem;
        font-weight: 700;
        color: var(--rp-muted);
        margin-bottom: .35rem;
        text-transform: uppercase;
        letter-spacing: .04em;
    }

    .operation-report-page .report-meta-value{
        display: block;
        font-size: .98rem;
        font-weight: 700;
        color: var(--rp-dark);
        line-height: 1.5;
        word-break: break-word;
    }

    .operation-report-page .filter-card{
        border: 1px solid var(--rp-border);
        border-radius: 20px;
        background: var(--rp-bg-soft);
        padding: 1rem;
        margin: 1.25rem 0 1.4rem;
    }

    .operation-report-page .filter-label{
        font-size: .88rem;
        font-weight: 700;
        color: #334155;
        margin-bottom: .45rem;
    }

    .operation-report-page .filter-input,
    .operation-report-page .filter-select{
        min-height: 44px;
        border-radius: 14px;
        border: 1px solid #dbe3ee;
        box-shadow: none;
    }

    .operation-report-page .filter-input:focus,
    .operation-report-page .filter-select:focus{
        border-color: rgba(37, 99, 235, 0.45);
        box-shadow: 0 0 0 .22rem rgba(37, 99, 235, 0.10);
    }

    .operation-report-page .filter-actions{
        display: flex;
        gap: .65rem;
        align-items: end;
        height: 100%;
    }

    .operation-report-page .btn-search-modern,
    .operation-report-page .btn-back-modern,
    .operation-report-page .btn-print-modern{
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: .45rem;
        min-height: 44px;
        padding: .72rem 1.18rem;
        border-radius: 999px;
        font-size: .9rem;
        font-weight: 700;
        text-decoration: none;
        border: 1px solid transparent;
        transition: all .2s ease;
        white-space: nowrap;
    }

    .operation-report-page .btn-search-modern{
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        color: #fff;
        box-shadow: 0 6px 16px rgba(15, 23, 42, 0.12);
    }

    .operation-report-page .btn-search-modern:hover{
        background: linear-gradient(135deg, #020617 0%, #0f172a 100%);
        color: #fff;
        transform: translateY(-1px);
    }

    .operation-report-page .btn-back-modern{
        background: rgba(255, 255, 255, 0.92);
        color: #334155;
        border-color: #dbe3ee;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.05);
    }

    .operation-report-page .btn-back-modern:hover{
        background: #ffffff;
        color: #0f172a;
        border-color: #cbd5e1;
        transform: translateY(-1px);
    }

    .operation-report-page .btn-print-modern{
        background: linear-gradient(135deg, #f59e0b 0%, #f97316 100%);
        color: #fff;
        box-shadow: 0 8px 20px rgba(249, 115, 22, 0.20);
    }

    .operation-report-page .btn-print-modern:hover{
        background: linear-gradient(135deg, #ea580c 0%, #c2410c 100%);
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 10px 22px rgba(234, 88, 12, 0.24);
    }

    .operation-report-page .day-block{
        border: 1px solid var(--rp-border);
        border-radius: 22px;
        overflow: hidden;
        margin-bottom: 1.25rem;
        background: #fff;
        box-shadow: 0 5px 16px rgba(15, 23, 42, 0.04);
    }

    .operation-report-page .day-block-header{
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
        background: linear-gradient(135deg, var(--rp-primary-soft) 0%, #f8fafc 100%);
        padding: 1rem 1.2rem;
        border-bottom: 1px solid var(--rp-border);
    }

    .operation-report-page .day-title{
        font-size: 1.05rem;
        font-weight: 800;
        color: var(--rp-dark);
        margin: 0 0 .2rem;
    }

    .operation-report-page .day-meta{
        font-size: .9rem;
        color: var(--rp-muted);
    }

    .operation-report-page .day-total{
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: .5rem .9rem;
        border-radius: 999px;
        background: #fff;
        border: 1px solid var(--rp-border);
        color: #334155;
        font-weight: 700;
        font-size: .88rem;
    }

    .operation-report-page .report-table-wrap{
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .operation-report-page .report-table{
        width: 100%;
        min-width: 980px;
        border-collapse: separate;
        border-spacing: 0;
        margin: 0;
    }

    .operation-report-page .report-table thead th{
        background: #f8fafc;
        color: #334155;
        font-weight: 800;
        font-size: .9rem;
        padding: .95rem .9rem;
        border-bottom: 1px solid var(--rp-border);
        white-space: nowrap;
        vertical-align: middle;
    }

    .operation-report-page .report-table tbody td{
        padding: 1rem .9rem;
        border-bottom: 1px solid var(--rp-border-soft);
        vertical-align: top;
        color: var(--rp-text);
        font-size: .94rem;
        line-height: 1.65;
    }

    .operation-report-page .report-table tbody tr:last-child td{
        border-bottom: 0;
    }

    .operation-report-page .seq-badge{
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 92px;
        padding: .48rem .9rem;
        border-radius: 999px;
        background: #dbeafe;
        color: #1d4ed8;
        font-weight: 800;
        font-size: .88rem;
    }

    .operation-report-page .staff-badge{
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        padding: .46rem .78rem;
        border-radius: 999px;
        background: #f1f5f9;
        color: #334155;
        font-weight: 700;
        font-size: .87rem;
        white-space: nowrap;
        border: 1px solid #e2e8f0;
    }

    .operation-report-page .text-pretty{
        white-space: pre-line;
        word-break: break-word;
    }

    .operation-report-page .empty-box{
        text-align: center;
        padding: 3.2rem 1rem;
        color: var(--rp-muted);
    }

    .operation-report-page .empty-box i{
        font-size: 2.1rem;
        display: block;
        margin-bottom: .8rem;
        color: #94a3b8;
    }

    .operation-report-page .report-footer{
        border-top: 1px solid var(--rp-border);
        margin-top: .5rem;
        padding: 1.2rem 1.5rem 1.4rem;
        background: #fff;
    }

    .operation-report-page .report-sign-grid{
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 1.5rem;
    }

    .operation-report-page .report-sign-box{
        text-align: center;
        padding-top: 1.4rem;
    }

    .operation-report-page .report-sign-line{
        width: 70%;
        margin: 0 auto .75rem;
        border-bottom: 1px solid #94a3b8;
        height: 34px;
    }

    .operation-report-page .report-sign-label{
        font-size: .88rem;
        color: var(--rp-muted);
        margin-bottom: .2rem;
    }

    .operation-report-page .report-sign-name{
        font-size: .96rem;
        color: var(--rp-dark);
        font-weight: 700;
    }

    @media (max-width: 991.98px){
        .operation-report-page .report-meta-grid{
            grid-template-columns: 1fr 1fr;
        }
    }

    @media (max-width: 767.98px){
        .operation-report-page .report-shell{
            padding: 1rem;
        }

        .operation-report-page .report-paper-header{
            padding: 1.2rem 1rem 1rem;
        }

        .operation-report-page .report-meta-grid{
            grid-template-columns: 1fr;
        }

        .operation-report-page .filter-actions{
            flex-wrap: wrap;
        }

        .operation-report-page .report-sign-grid{
            grid-template-columns: 1fr;
            gap: 1rem;
        }
    }

    @media (max-width: 575.98px){
        .operation-report-page .report-topbar{
            padding: 1rem;
        }

        .operation-report-page .report-topbar-title{
            font-size: 1.02rem;
        }

        .operation-report-page .report-topbar-subtitle{
            font-size: .88rem;
        }

        .operation-report-page .report-paper-title h1{
            font-size: 1.18rem;
        }

        .operation-report-page .btn-back-modern,
        .operation-report-page .btn-print-modern,
        .operation-report-page .btn-search-modern{
            width: 100%;
            border-radius: 14px;
        }
    }

    @media print {
        .operation-report-page .no-print{
            display: none !important;
        }

        .operation-report-page .container-fluid{
            padding: 0 !important;
        }

        .operation-report-page .report-card,
        .operation-report-page .report-paper,
        .operation-report-page .day-block{
            box-shadow: none !important;
        }

        .operation-report-page .report-card{
            border: 0 !important;
        }

        .operation-report-page .report-paper{
            border-radius: 0 !important;
            border: 0 !important;
        }

        .operation-report-page .day-block{
            break-inside: avoid;
        }

        .operation-report-page .report-shell{
            padding: 0 !important;
            background: #fff !important;
        }

        body{
            background: #fff !important;
        }

        @page{
            size: A4;
            margin: 12mm;
        }
    }
</style>

    @php
        $reportUser = auth()->user()->isAdmin()
            ? ($users->firstWhere('id', request('user_id')) ?? null)
            : auth()->user();

        $reportUserName = $reportUser?->name ?? 'ทุกคน';

        $reportRangeText = 'ทั้งหมด';
        if(request('start_date') && request('end_date')){
            $reportRangeText =
                \Carbon\Carbon::parse(request('start_date'))->addYears(543)->format('d/m/Y')
                . ' - ' .
                \Carbon\Carbon::parse(request('end_date'))->addYears(543)->format('d/m/Y');
        } elseif(request('start_date')) {
            $reportRangeText =
                'ตั้งแต่ ' . \Carbon\Carbon::parse(request('start_date'))->addYears(543)->format('d/m/Y');
        } elseif(request('end_date')) {
            $reportRangeText =
                'ถึง ' . \Carbon\Carbon::parse(request('end_date'))->addYears(543)->format('d/m/Y');
        }

        $generatedAt = now()->addYears(543)->format('d/m/Y H:i');
        $totalItems = $groupedOperations->flatten()->count();
        $totalDays  = $groupedOperations->count();
    @endphp

    <div class="report-card">
        <div class="report-topbar no-print">
            <div class="report-topbar-inner">
                <div>
                    <h2 class="report-topbar-title">
                        <i class="bi bi-file-earmark-text me-2"></i>
                        รายงานการปฏิบัติงานประจำวัน
                    </h2>
                    <div class="report-topbar-subtitle">
                        รูปแบบรายงานอย่างเป็นทางการ พร้อมพิมพ์และแสดงผลได้สวยงามทุกขนาดหน้าจอ
                    </div>
                </div>

                <div class="d-flex gap-2 flex-wrap w-auto">
                    <a href="{{ route('operations.index') }}" class="btn-back-modern">
                        <i class="bi bi-arrow-left"></i>
                        <span>กลับหน้ารายการ</span>
                    </a>

                    <button type="button" class="btn-print-modern" onclick="window.print()">
                        <i class="bi bi-printer"></i>
                        <span>พิมพ์รายงาน</span>
                    </button>
                </div>
            </div>
        </div>

        <div class="report-shell">
            <div class="report-paper">

                <div class="report-paper-header">
                    <div class="report-paper-title">
                        <h1>รายงานการปฏิบัติงานประจำวันของพนักงาน</h1>
                        <p>แบบสรุปรายวัน แสดงผลตามลำดับการปฏิบัติงานของแต่ละวัน</p>
                    </div>

                    <div class="report-meta-grid">
                        <div class="report-meta-card">
                            <span class="report-meta-label">ชื่อ - สกุล</span>
                            <span class="report-meta-value">{{ $reportUserName }}</span>
                        </div>

                        <div class="report-meta-card">
                            <span class="report-meta-label">ช่วงวันที่รายงาน</span>
                            <span class="report-meta-value">{{ $reportRangeText }}</span>
                        </div>

                        <div class="report-meta-card">
                            <span class="report-meta-label">วันที่พิมพ์ / ออกรายงาน</span>
                            <span class="report-meta-value">{{ $generatedAt }} น.</span>
                        </div>

                        <div class="report-meta-card">
                            <span class="report-meta-label">จำนวนวันที่มีรายการ</span>
                            <span class="report-meta-value">{{ number_format($totalDays) }} วัน</span>
                        </div>

                        <div class="report-meta-card">
                            <span class="report-meta-label">จำนวนรายการทั้งหมด</span>
                            <span class="report-meta-value">{{ number_format($totalItems) }} รายการ</span>
                        </div>

                        <div class="report-meta-card">
                            <span class="report-meta-label">ผู้จัดทำรายงาน</span>
                            <span class="report-meta-value">{{ auth()->user()->name ?? '-' }}</span>
                        </div>
                    </div>

                    <form method="GET" action="{{ route('operations.report.daily') }}" class="filter-card no-print">
                        <div class="row g-3 align-items-end">
                            <div class="col-lg-3 col-md-6">
                                <label class="filter-label">วันที่เริ่มต้น</label>
                                <input type="date"
                                       name="start_date"
                                       value="{{ request('start_date') }}"
                                       class="form-control filter-input">
                            </div>

                            <div class="col-lg-3 col-md-6">
                                <label class="filter-label">วันที่สิ้นสุด</label>
                                <input type="date"
                                       name="end_date"
                                       value="{{ request('end_date') }}"
                                       class="form-control filter-input">
                            </div>

                            @if(auth()->user()->isAdmin())
                                <div class="col-lg-4 col-md-6">
                                    <label class="filter-label">ผู้ดำเนินงาน</label>
                                    <select name="user_id" class="form-select filter-select">
                                        <option value="">-- ทั้งหมด --</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                            <div class="col-lg-2 col-md-6">
                                <div class="filter-actions">
                                    <button type="submit" class="btn-search-modern w-100">
                                        <i class="bi bi-search"></i>
                                        <span>ค้นหา</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="p-3 p-md-4">
                    @forelse($groupedOperations as $date => $items)
                        @php
                            $carbonDate = \Carbon\Carbon::parse($date);
                        @endphp

                        <div class="day-block">
                            <div class="day-block-header">
                                <div>
                                    <div class="day-title">
                                        <i class="bi bi-calendar3 me-2 text-primary"></i>
                                        วันที่ {{ $carbonDate->addYears(543)->format('d/m/Y') }}
                                    </div>
                                    <div class="day-meta">
                                        รายงานผลการปฏิบัติงานประจำวัน
                                    </div>
                                </div>

                                <div class="day-total">
                                    จำนวน {{ $items->count() }} รายการ
                                </div>
                            </div>

                            <div class="report-table-wrap">
                                <table class="report-table">
                                    <thead>
                                        <tr>
                                            <th style="width: 110px;">ครั้งที่</th>
                                            <th style="min-width: 260px;">เรื่องที่ดำเนินงาน</th>
                                            <th style="min-width: 260px;">ผลการดำเนินงาน</th>
                                            <th style="min-width: 220px;">หมายเหตุ</th>
                                            <th style="min-width: 180px;">ผู้ดำเนินงาน</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($items as $item)
                                            <tr>
                                                <td>
                                                    <span class="seq-badge">ครั้งที่ {{ $item->sequence_no }}</span>
                                                </td>
                                                <td class="text-pretty">
                                                    {{ $item->subject ?: '-' }}
                                                </td>
                                                <td class="text-pretty">
                                                    {{ $item->result ?: '-' }}
                                                </td>
                                                <td class="text-pretty">
                                                    {{ $item->remark ?: '-' }}
                                                </td>
                                                <td>
                                                    <span class="staff-badge">
                                                        <i class="bi bi-person-circle"></i>
                                                        {{ $item->user->name ?? '-' }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @empty
                        <div class="empty-box">
                            <i class="bi bi-inbox"></i>
                            ไม่พบข้อมูลรายงานในช่วงที่เลือก
                        </div>
                    @endforelse
                </div>

                <div class="report-footer">
                    <div class="report-sign-grid">
                        <div class="report-sign-box">
                            <div class="report-sign-line"></div>
                            <div class="report-sign-label">ผู้จัดทำรายงาน</div>
                            <div class="report-sign-name">{{ auth()->user()->name ?? '-' }}</div>
                        </div>

                        <div class="report-sign-box">
                            <div class="report-sign-line"></div>
                            <div class="report-sign-label">ผู้ตรวจสอบ</div>
                            <div class="report-sign-name">..........................................</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection