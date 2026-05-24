<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>รายงานสถิติผู้รับบริการ</title>

    <style>
        body {
            font-family: "TH Sarabun New", "Sarabun", sans-serif;
            background: #e5edf5;
            color: #111827;
            margin: 0;
            font-size: 14px;
            line-height: 1.25;
        }

        .toolbar {
            width: 297mm;
            margin: 14px auto 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn {
            border: 0;
            border-radius: 999px;
            padding: 8px 16px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-print {
            background: linear-gradient(135deg, #0f766e, #14b8a6);
            color: #fff;
            box-shadow: 0 8px 18px rgba(15, 118, 110, .25);
        }

        .btn-back {
            background: #ffffff;
            color: #334155;
            border: 1px solid #cbd5e1;
        }

        .sheet {
            width: 297mm;
            min-height: 210mm;
            margin: 0 auto 18px;
            background: #fff;
            padding: 9mm 10mm;
            box-sizing: border-box;
            border-radius: 6px;
            box-shadow: 0 14px 35px rgba(15, 23, 42, .12);
        }

        .report-head {
            border-bottom: 2px solid #0f766e;
            padding-bottom: 7px;
            margin-bottom: 8px;
            text-align: center;
        }

        .report-kicker {
            font-size: 13px;
            color: #0f766e;
            font-weight: 800;
            letter-spacing: .04em;
        }

        .report-title {
            font-size: 21px;
            font-weight: 800;
            margin: 2px 0 0;
            color: #0f172a;
        }

        .report-subtitle {
            font-size: 13.5px;
            margin-top: 2px;
            color: #64748b;
        }

        .filter-box {
            margin-top: 8px;
            padding: 7px 9px;
            border: 1px solid #dbe3ec;
            background: #f8fafc;
            border-radius: 8px;
            font-size: 13.5px;
            color: #334155;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 7px;
            margin-top: 9px;
        }

        .summary-card {
            border: 1px solid #dbe3ec;
            border-radius: 9px;
            padding: 7px 8px;
            text-align: center;
            background: linear-gradient(180deg, #ffffff, #f8fafc);
        }

        .summary-label {
            color: #64748b;
            font-size: 13px;
            font-weight: 700;
        }

        .summary-value {
            font-size: 22px;
            font-weight: 900;
            margin-top: 1px;
            color: #0f766e;
            line-height: 1;
        }

        .summary-unit {
            font-size: 12px;
            color: #64748b;
            font-weight: 700;
            margin-left: 2px;
        }

        .section-title {
            margin: 11px 0 5px;
            font-size: 15px;
            font-weight: 900;
            color: #0f172a;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .section-title::before {
            content: "";
            width: 4px;
            height: 15px;
            border-radius: 999px;
            background: #0f766e;
            display: inline-block;
        }

        .summary-tables {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
            margin-top: 4px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 4px;
            table-layout: fixed;
        }

        th,
        td {
            border: 1px solid #d7dee8;
            padding: 3.5px 5px;
            vertical-align: top;
            word-break: break-word;
        }

        th {
            background: #ecfdf5;
            color: #064e3b;
            font-weight: 900;
            text-align: center;
            font-size: 13.2px;
        }

        td {
            font-size: 13.2px;
        }

        tbody tr:nth-child(even) {
            background: #fafafa;
        }

        td.center {
            text-align: center;
        }

        .muted {
            color: #64748b;
        }

        .main-table th,
        .main-table td {
            font-size: 12.8px;
            padding: 3px 4px;
        }

        .footer-note {
            margin-top: 8px;
            font-size: 12px;
            color: #64748b;
            text-align: right;
        }

        @media print {
            @page {
                size: A4 landscape;
                margin: 7mm;
            }

            body {
                background: #fff;
                font-size: 13px;
            }

            .toolbar {
                display: none;
            }

            .sheet {
                width: auto;
                min-height: auto;
                margin: 0;
                padding: 0;
                border-radius: 0;
                box-shadow: none;
            }

            .summary-card,
            .filter-box,
            th {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .section-title {
                break-after: avoid;
            }

            table {
                page-break-inside: auto;
            }

            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
        }
    </style>
</head>

<body>

    <div class="toolbar">
        <a href="{{ route('statistics.index', request()->query()) }}" class="btn btn-back">
            ← กลับหน้าสถิติ
        </a>

        <button onclick="window.print()" class="btn btn-print">
            พิมพ์รายงาน
        </button>
    </div>

    <div class="sheet">

        <div class="report-head">
            <h1 class="report-title">รายงานสถิติผู้รับบริการ</h1>
            <div class="report-subtitle">
                วันที่ออกรายงาน {{ now()->locale('th')->translatedFormat('j F') }} {{ now()->year + 543 }}
            </div>
        </div>

        <div class="filter-box">
            <strong>เงื่อนไขการกรอง:</strong>
            สถานะ {{ $releaseStatus === 'all' ? 'ทั้งหมด' : $releaseStatus }},
            บ้าน {{ !empty($houseId) ? 'ตามที่เลือก' : 'ทั้งหมด' }},
            เพศ {{ $gender ? ($gender === 'male' ? 'ชาย' : 'หญิง') : 'ทั้งหมด' }},
            อายุ {{ $ageMin }} - {{ $ageMax }} ปี

            @if ($startMonth && $startYear && $endMonth && $endYear)
                ,
                ช่วงเวลา {{ $startMonth }}/{{ $startYear }} ถึง {{ $endMonth }}/{{ $endYear }}
            @endif
        </div>

        <div class="summary-grid">
            <div class="summary-card">
                <div class="summary-label">จำนวนทั้งหมด</div>
                <div class="summary-value">
                    {{ $clients->count() }}<span class="summary-unit">คน</span>
                </div>
            </div>

            <div class="summary-card">
                <div class="summary-label">ชาย</div>
                <div class="summary-value">
                    {{ $maleCount }}<span class="summary-unit">คน</span>
                </div>
            </div>

            <div class="summary-card">
                <div class="summary-label">หญิง</div>
                <div class="summary-value">
                    {{ $femaleCount }}<span class="summary-unit">คน</span>
                </div>
            </div>
        </div>

        <div class="summary-tables">
         {{-- สรุปตามบ้าน, สภาพปัญหา, ระดับการศึกษา, สถานศึกษา, หน่วยงาน/โครงการ --}}
            @if (isset($houseSummary) && count($houseSummary) > 0)
                <div>
                    <div class="section-title">สรุปตามบ้าน</div>
                    <table>
                        <thead>
                            <tr>
                                <th style="width:75%">บ้าน</th>
                                <th style="width:25%">จำนวน</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($houseSummary as $name => $count)
                                <tr>
                                    <td>{{ $name }}</td>
                                    <td class="center">{{ $count }} คน</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            @if (count($problemSummary) > 0)
                <div>
                    <div class="section-title">สรุปตามสภาพปัญหา</div>
                    <table>
                        <thead>
                            <tr>
                                <th style="width:75%">สภาพปัญหา</th>
                                <th style="width:25%">จำนวน</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($problemSummary as $name => $count)
                                <tr>
                                    <td>{{ $name }}</td>
                                    <td class="center">{{ $count }} คน</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            @if (count($educationSummary) > 0)
                <div>
                    <div class="section-title">สรุปตามระดับการศึกษา</div>
                    <table>
                        <thead>
                            <tr>
                                <th style="width:75%">ระดับการศึกษา</th>
                                <th style="width:25%">จำนวน</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($educationSummary as $name => $count)
                                <tr>
                                    <td>{{ $name }}</td>
                                    <td class="center">{{ $count }} คน</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            @if (count($institutionSummary) > 0)
                <div>
                    <div class="section-title">สรุปตามสถานศึกษา</div>
                    <table>
                        <thead>
                            <tr>
                                <th style="width:75%">สถานศึกษา</th>
                                <th style="width:25%">จำนวน</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($institutionSummary as $name => $count)
                                <tr>
                                    <td>{{ $name }}</td>
                                    <td class="center">{{ $count }} คน</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            @if (count($projectSummary) > 0)
                <div>
                    <div class="section-title">สรุปตามหน่วยงาน / โครงการ</div>
                    <table>
                        <thead>
                            <tr>
                                <th style="width:75%">หน่วยงาน / โครงการ</th>
                                <th style="width:25%">จำนวน</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($projectSummary as $name => $count)
                                <tr>
                                    <td>{{ $name }}</td>
                                    <td class="center">{{ $count }} คน</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <div class="section-title">รายชื่อผู้รับบริการตามเงื่อนไข</div>

        <table class="main-table">
            <thead>
                <tr>
                    <th style="width:5%">ลำดับ</th>
                    <th style="width:18%">ชื่อ - สกุล</th>
                    <th style="width:7%">เพศ</th>
                    <th style="width:6%">อายุ</th>
                    <th style="width:12%">บ้าน</th>
                    <th style="width:15%">ระดับการศึกษา</th>
                    <th style="width:20%">สถานศึกษา</th>
                    <th style="width:17%">สภาพปัญหา</th>
                </tr>

            </thead>

            <tbody>
                @forelse($clients as $index => $client)
                    @php
                        $latestEducation = $client->educationRecords->first();

                        $problemNames = $client->problems
                            ->map(fn($p) => $p->problem_name ?? ($p->name ?? '-'))
                            ->filter()
                            ->implode(', ');
                    @endphp

                    <tr>
                        <td class="center">
                            {{ $index + 1 }}
                        </td>

                        <td>
                            {{ $client->fullname ?? '-' }}
                        </td>

                        <td class="center">
                            @if ($client->gender === 'male')
                                ชาย
                            @elseif($client->gender === 'female')
                                หญิง
                            @else
                                -
                            @endif
                        </td>

                        <td class="center">
                            {{ $client->birth_date ? \Carbon\Carbon::parse($client->birth_date)->age : '-' }}
                        </td>

                        {{-- บ้าน --}}
                        <td>
                            {{ $client->house->house_name ?? '-' }}
                        </td>

                        {{-- ระดับการศึกษา --}}
                        <td>
                            {{ $latestEducation?->education?->education_name ?? '-' }}
                        </td>

                        {{-- สถานศึกษา --}}
                        <td>
                            {{ $latestEducation?->institution?->institution_name ?? ($latestEducation?->school_name ?? '-') }}
                        </td>

                        {{-- สภาพปัญหา --}}
                        <td>
                            {{ $problemNames ?: '-' }}
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="8" class="center muted">
                            ไม่พบข้อมูลตามเงื่อนไขที่เลือก
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="footer-note">
            รวม {{ $clients->count() }} รายการ
        </div>

    </div>

</body>

</html>
