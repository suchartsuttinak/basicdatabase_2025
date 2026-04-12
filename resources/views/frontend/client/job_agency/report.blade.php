@extends('admin_client.admin_client')
@section('content')

<div class="container-fluid">
    <div class="jr-page">
        <div class="jr-head">
            <div class="jr-head-left">
                <div class="jr-icon">
                    <i class="bi bi-file-earmark-text"></i>
                </div>
                <div>
                    <h4 class="jr-title mb-1">รายงานการจัดหางาน</h4>
                    <div class="jr-subtitle">
                        ผู้รับบริการ:
                        <strong>{{ $client->fullname ?? $client->name ?? '-' }}</strong>
                    </div>
                </div>
            </div>

            <div class="jr-head-actions">
                <a href="{{ route('job_agencies.show', $client->id) }}" class="btn btn-light jr-btn">
                    <i class="bi bi-arrow-left"></i>
                    <span>กลับหน้าหลัก</span>
                </a>

                <button onclick="window.print()" class="btn btn-primary jr-btn">
                    <i class="bi bi-printer"></i>
                    <span>พิมพ์รายงาน</span>
                </button>
            </div>
        </div>

        <div class="jr-filter-card">
            <form method="GET" action="{{ route('job_agencies.report', $client->id) }}">
                <div class="jr-filter-row">
                    <div class="jr-filter-group">
                        <label>วันที่เริ่มต้น</label>
                        <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                    </div>

                    <div class="jr-filter-group">
                        <label>วันที่สิ้นสุด</label>
                        <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                    </div>

                    <div class="jr-filter-actions">
                        <button type="submit" class="btn btn-primary jr-btn">
                            <i class="bi bi-search"></i>
                            <span>ค้นหา</span>
                        </button>

                        <a href="{{ route('job_agencies.report', $client->id) }}" class="btn btn-outline-secondary jr-btn">
                            <i class="bi bi-arrow-clockwise"></i>
                            <span>รีเซ็ต</span>
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <div class="jr-table-card">
            <div class="jr-table-head">
                <div class="jr-table-title">
                    <i class="bi bi-table"></i>
                    <span>สรุปรายการจัดหางาน</span>
                </div>

                <div class="jr-table-meta">
                    จำนวน {{ $jobAgencies->count() }} รายการ
                </div>
            </div>

            <div class="jr-table-wrap">
                <table class="table table-bordered align-middle jr-table">
                    <thead>
                        <tr>
                            <th style="width: 70px;" class="text-center">ลำดับ</th>
                            <th class="text-center">วันที่เริ่มงาน</th>
                            <th>อาชีพ</th>
                            <th>ตำแหน่ง</th>
                            <th class="text-center">รายได้/เดือน</th>
                            <th>บริษัท</th>
                            <th>ผู้ประสานงาน</th>
                            <th>หมายเหตุ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jobAgencies as $index => $job)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td class="text-center">{{ \Carbon\Carbon::parse($job->job_date)->format('d/m/Y') }}</td>
                                <td>{{ $job->occupation->occupation_name ?? '-' }}</td>
                                <td>{{ $job->position ?? '-' }}</td>
                                <td class="text-center">{{ number_format($job->income ?? 0, 2) }}</td>
                                <td>{{ $job->company ?? '-' }}</td>
                                <td>{{ $job->coordinator ?? '-' }}</td>
                                <td>{{ $job->remark ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    ไม่พบข้อมูลรายการจัดหางาน
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
.jr-page {
    padding: 1rem 0 1.5rem;
}

.jr-head {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
    background: #fff;
    border: 1px solid #e9edf5;
    border-radius: 20px;
    padding: 1rem 1.2rem;
    margin-bottom: 1rem;
    box-shadow: 0 10px 24px rgba(15, 23, 42, 0.05);
}

.jr-head-left {
    display: flex;
    align-items: center;
    gap: .9rem;
}

.jr-icon {
    width: 52px;
    height: 52px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #16a34a, #22c55e);
    color: #fff;
    font-size: 1.15rem;
}

.jr-title {
    color: #0f172a;
    font-weight: 700;
}

.jr-subtitle {
    color: #64748b;
    font-size: .94rem;
}

.jr-head-actions {
    display: flex;
    gap: .65rem;
    flex-wrap: wrap;
}

.jr-btn {
    display: inline-flex;
    align-items: center;
    gap: .45rem;
    border-radius: 12px;
    font-weight: 600;
    padding: .62rem 1rem;
}

.jr-filter-card,
.jr-table-card {
    background: #fff;
    border: 1px solid #e9edf5;
    border-radius: 20px;
    padding: 1rem 1.1rem;
    margin-bottom: 1rem;
    box-shadow: 0 8px 24px rgba(15, 23, 42, 0.04);
}

.jr-filter-row {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    align-items: end;
}

.jr-filter-group {
    min-width: 190px;
    flex: 1 1 190px;
}

.jr-filter-group label {
    font-size: .88rem;
    font-weight: 600;
    margin-bottom: .4rem;
    color: #475569;
}

.jr-filter-actions {
    display: flex;
    gap: .6rem;
    flex-wrap: wrap;
}

.jr-table-head {
    margin-bottom: .8rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: .75rem;
    flex-wrap: wrap;
}

.jr-table-title {
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    font-weight: 700;
    color: #0f172a;
}

.jr-table-meta {
    color: #64748b;
    font-size: .92rem;
    font-weight: 600;
}

.jr-table-wrap {
    overflow-x: auto;
}

.jr-table {
    min-width: 980px;
    margin-bottom: 0;
}

.jr-table thead th {
    background: #f8fafc;
    color: #334155;
    white-space: nowrap;
}

@media (max-width: 767.98px) {
    .jr-head-actions,
    .jr-filter-actions {
        width: 100%;
    }

    .jr-head-actions .jr-btn,
    .jr-filter-actions .jr-btn,
    .jr-filter-actions .btn {
        width: 100%;
        justify-content: center;
    }
}

@media print {
    .jr-head-actions,
    .jr-filter-card {
        display: none !important;
    }

    .jr-page {
        padding: 0;
    }

    .jr-head,
    .jr-table-card {
        box-shadow: none !important;
    }
}
</style>
@endsection