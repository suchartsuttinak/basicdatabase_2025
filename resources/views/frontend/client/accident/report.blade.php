<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>รายงานการบาดเจ็บ</title>
    <style>
        body {
            font-family: "TH Sarabun New", sans-serif;
            font-size: 18px;
            color: #000;
            margin: 24px;
        }

        .report-wrap {
            max-width: 900px;
            margin: 0 auto;
        }

        .text-center { text-align: center; }
        .mb-1 { margin-bottom: 8px; }
        .mb-2 { margin-bottom: 16px; }
        .mb-3 { margin-bottom: 24px; }
        .fw-bold { font-weight: bold; }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td, th {
            border: 1px solid #000;
            padding: 8px 10px;
            vertical-align: top;
        }

        .no-border td {
            border: 0;
            padding: 2px 0;
        }

        @media print {
            @page {
                size: A4 portrait;
                margin: 12mm;
            }

            .print-btn {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="report-wrap">
        <div class="text-center mb-3">
            <div class="fw-bold" style="font-size: 26px;">รายงานบันทึกการบาดเจ็บ</div>
            <div>ข้อมูลผู้รับบริการและรายละเอียดเหตุการณ์</div>
        </div>

        <div class="mb-2">
            <button class="print-btn" onclick="window.print()">พิมพ์รายงาน</button>
        </div>

        <table class="no-border mb-2">
            <tr>
                <td><strong>ชื่อผู้รับบริการ:</strong> {{ $client->name ?? $client->fullname ?? '-' }}</td>
                <td><strong>เลขประจำตัวประชาชน:</strong> {{ $client->cid ?? '-' }}</td>
            </tr>
        </table>

        <table>
            <tr>
                <th style="width: 24%;">วันที่เกิดเหตุ</th>
                <td>{{ $accident->incident_date ? $accident->incident_date->format('d/m/Y') : '-' }}</td>
            </tr>
            <tr>
                <th>สถานที่เกิดเหตุ</th>
                <td>{{ $accident->location ?? '-' }}</td>
            </tr>
            <tr>
                <th>ผู้พบเห็นเหตุการณ์</th>
                <td>{{ $accident->eyewitness ?? '-' }}</td>
            </tr>
            <tr>
                <th>รายละเอียดการบาดเจ็บ</th>
                <td>{{ $accident->detail ?? '-' }}</td>
            </tr>
            <tr>
                <th>สาเหตุ</th>
                <td>{{ $accident->cause ?? '-' }}</td>
            </tr>
            <tr>
                <th>การพบแพทย์</th>
                <td>{{ $accident->treat_no ?? '-' }}</td>
            </tr>
            <tr>
                <th>สถานพยาบาล</th>
                <td>{{ $accident->hospital ?? '-' }}</td>
            </tr>
            <tr>
                <th>ผลวินิจฉัย</th>
                <td>{{ $accident->diagnosis ?? '-' }}</td>
            </tr>
            <tr>
                <th>นัดครั้งต่อไป</th>
                <td>{{ $accident->appointment ? $accident->appointment->format('d/m/Y') : '-' }}</td>
            </tr>
            <tr>
                <th>การรักษา</th>
                <td>{{ $accident->treatment ?? '-' }}</td>
            </tr>
            <tr>
                <th>การป้องกัน/การแก้ไข</th>
                <td>{{ $accident->protection ?? '-' }}</td>
            </tr>
            <tr>
                <th>ผู้ดูแล</th>
                <td>{{ $accident->caretaker ?? '-' }}</td>
            </tr>
            <tr>
                <th>วันที่บันทึก</th>
                <td>{{ $accident->record_date ? $accident->record_date->format('d/m/Y') : '-' }}</td>
            </tr>
        </table>
    </div>
</body>
</html>