@extends('admin.admin_master')

@section('admin')

<style>
    @page {
        size: A4 landscape;
        margin: 8mm;
    }

    .report-page {
        padding: 20px;
        background: #f4f6f9;
    }

    .report-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #e5e7eb;
        padding: 20px;
    }

    .report-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 12px;
        border-bottom: 2px solid #e5e7eb;
        padding-bottom: 12px;
        margin-bottom: 12px;
    }

    .report-title h4 {
        margin: 0;
        font-weight: 800;
        color: #111827;
    }

    .report-title p {
        margin: 4px 0 0;
        color: #6b7280;
    }

    .report-actions {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .report-summary {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        margin-bottom: 12px;
    }

    .summary-badge {
        background: #eef2ff;
        color: #3730a3;
        border-radius: 999px;
        padding: 7px 13px;
        font-weight: 700;
        font-size: 14px;
    }

    .report-table-wrap {
        width: 100%;
        overflow-x: auto;
    }

    .report-table {
        width: 100%;
        font-size: 13px;
        table-layout: fixed;
    }

    .report-table th {
        background: #f8fafc;
        color: #111827;
        font-weight: 800;
        text-align: center;
        vertical-align: middle;
        white-space: nowrap;
    }

    .report-table td {
        vertical-align: top;
        word-break: break-word;
    }

    .report-photo {
        width: 58px;
        height: 58px;
        object-fit: cover;
        border-radius: 10px;
        border: 1px solid #d1d5db;
    }

    .report-avatar {
        width: 58px;
        height: 58px;
        border-radius: 10px;
        background: #eef2ff;
        color: #4f46e5;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 22px;
        margin: 0 auto;
    }

    .empty-box {
        text-align: center;
        padding: 35px 20px;
        color: #6b7280;
        border: 1px dashed #cbd5e1;
        border-radius: 16px;
        background: #f8fafc;
    }

    @media print {
        html,
        body {
            width: 297mm;
            height: 210mm;
            background: #fff !important;
            margin: 0 !important;
            padding: 0 !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .no-print,
        .navbar,
        .sidebar,
        .footer,
        .topbar,
        .page-title,
        .breadcrumb,
        header,
        nav,
        aside {
            display: none !important;
        }

        .report-page {
            padding: 0 !important;
            margin: 0 !important;
            background: #fff !important;
        }

        .report-card {
            border: none !important;
            box-shadow: none !important;
            border-radius: 0 !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        .report-header {
            padding-bottom: 6px !important;
            margin-bottom: 6px !important;
            page-break-after: avoid;
        }

        .report-title h4 {
            font-size: 18px !important;
            margin: 0 !important;
        }

        .report-title p {
            font-size: 12px !important;
            margin: 2px 0 0 !important;
        }

        .report-summary {
            margin-bottom: 6px !important;
            page-break-after: avoid;
        }

        .summary-badge {
            font-size: 11px !important;
            padding: 4px 8px !important;
        }

        .report-table-wrap {
            overflow: visible !important;
        }

        .report-table {
            width: 100% !important;
            min-width: 0 !important;
            table-layout: fixed !important;
            font-size: 10px !important;
            margin-bottom: 0 !important;
        }

        .report-table th,
        .report-table td {
            padding: 4px 5px !important;
            line-height: 1.25 !important;
        }

        .report-table th:nth-child(1),
        .report-table td:nth-child(1) {
            width: 7%;
        }

        .report-table th:nth-child(2),
        .report-table td:nth-child(2) {
            width: 14%;
        }

        .report-table th:nth-child(3),
        .report-table td:nth-child(3) {
            width: 4%;
        }

        .report-table th:nth-child(4),
        .report-table td:nth-child(4) {
            width: 9%;
        }

        .report-table th:nth-child(5),
        .report-table td:nth-child(5) {
            width: 17%;
        }

        .report-table th:nth-child(6),
        .report-table td:nth-child(6) {
            width: 8%;
        }

        .report-table th:nth-child(7),
        .report-table td:nth-child(7) {
            width: 8%;
        }

        .report-table th:nth-child(8),
        .report-table td:nth-child(8) {
            width: 8%;
        }

        .report-table th:nth-child(9),
        .report-table td:nth-child(9) {
            width: 11%;
        }

        .report-table th:nth-child(10),
        .report-table td:nth-child(10) {
            width: 14%;
        }

        .report-photo,
        .report-avatar {
            width: 42px !important;
            height: 42px !important;
            border-radius: 8px !important;
        }

        tr {
            page-break-inside: avoid;
        }
    }
</style>

<div class="report-page">
    <div class="report-card">

        <div class="report-header">
            <div class="report-title">
                <h4>รายงานผู้ขอรับทุนการศึกษา</h4>
                <p>
                    @if($academicYear)
                        ปีการศึกษา {{ $academicYear }}
                    @else
                        ทุกปีการศึกษา
                    @endif
                </p>
            </div>

            <div class="report-actions no-print">
                <a href="{{ route('scholarship.children.index', ['academic_year' => $academicYear]) }}"
                   class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> กลับหน้าหลัก
                </a>

                <button type="button" onclick="window.print()" class="btn btn-dark">
                    <i class="bi bi-printer"></i> พิมพ์รายงาน
                </button>
            </div>
        </div>

        <div class="report-summary">
            <div class="summary-badge">
                จำนวนผู้ขอรับทุน {{ $children->count() }} ราย
            </div>

            <div class="summary-badge">
                @if($academicYear)
                    ปีการศึกษา {{ $academicYear }}
                @else
                    ทุกปีการศึกษา
                @endif
            </div>
        </div>

        @if($children->count() > 0)
            <div class="report-table-wrap">
                <table class="table table-bordered align-middle report-table">
                    <thead>
                        <tr>
                            <th>ภาพ</th>
                            <th>ชื่อ - นามสกุล</th>
                            <th>อายุ</th>
                            <th>ระดับการศึกษา</th>
                            <th>สถานศึกษา</th>
                            <th>ปีการศึกษา</th>
                            <th>ผู้ปกครอง</th>
                            <th>โทรศัพท์</th>
                            <th>สาเหตุที่ขอรับทุน</th>
                            <th>ความต้องการช่วยเหลือ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($children as $child)
                            <tr>
                             <td class="text-center">
                                        @if(!empty($child->photo))
                                            @php
                                                if (str_starts_with($child->photo, 'upload/')) {
                                                    $photoUrl = asset($child->photo);
                                                } elseif (str_starts_with($child->photo, 'storage/')) {
                                                    $photoUrl = asset($child->photo);
                                                } else {
                                                    $photoUrl = asset('storage/' . $child->photo);
                                                }
                                            @endphp

                                            {{-- =====================================================
                                                PATCH:
                                                Lazy Load + Async Decode
                                                ช่วยให้ report โหลดเร็วขึ้นเมื่อมีหลายรูป
                                            ====================================================== --}}
                                            <img src="{{ $photoUrl }}"
                                                loading="lazy"
                                                decoding="async"
                                                class="report-photo"
                                                alt="{{ $child->first_name }}">

                                        @else
                                            <div class="report-avatar">
                                                {{ mb_substr($child->first_name ?? '-', 0, 1) }}
                                            </div>
                                        @endif
                                    </td>
                                <td>
                                    <strong>{{ $child->first_name }} {{ $child->last_name }}</strong>
                                    @if($child->current_address)
                                        <div class="text-muted small mt-1">
                                            {{ $child->current_address }}
                                        </div>
                                    @endif
                                </td>

                                <td class="text-center">{{ $child->age ?? '-' }}</td>
                                <td>{{ $child->education_level ?? '-' }}</td>
                                <td>{{ $child->school_name ?? '-' }}</td>
                                <td class="text-center">{{ $child->academic_year }}</td>
                                <td>{{ $child->guardian_name ?? '-' }}</td>
                                <td>{{ $child->phone ?? '-' }}</td>
                                <td>{{ $child->reason ?? '-' }}</td>
                                <td>{{ $child->help_needed ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-box">
                ไม่พบข้อมูลรายงาน
            </div>
        @endif

    </div>
</div>

@endsection