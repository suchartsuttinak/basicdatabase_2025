@php use App\Helpers\ThaiDateHelper; @endphp
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>รายงานตรวจสุขภาพเบื้องต้น</title>
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
        <div class="fw-bold" style="font-size: 26px;">รายงานการตรวจสุขภาพเบื้องต้น</div>
        <div>ข้อมูลผู้รับบริการและผลการประเมินสุขภาพ</div>
    </div>

    <div class="mb-2">
        <button class="print-btn" onclick="window.print()">พิมพ์รายงาน</button>
    </div>

    <table class="no-border mb-2">
        <tr>
            <td><strong>ชื่อผู้รับบริการ:</strong> {{ $client->fullname ?? $client->name ?? '-' }}</td>
            <td><strong>อายุ:</strong> {{ $client->age ?? '-' }} ปี</td>
        </tr>
    </table>

    <table>
        <tr>
            <th style="width: 24%;">วันที่ตรวจ</th>
            <td>{{ ThaiDateHelper::formatThaiDate($checkbody->assessor_date) }}</td>
        </tr>
        <tr>
            <th>ผู้ตรวจ / ผู้บันทึก</th>
            <td>{{ $checkbody->recorder ?? '-' }}</td>
        </tr>
        <tr>
            <th>พัฒนาการ</th>
            <td>{{ $checkbody->development ?? '-' }}</td>
        </tr>
        <tr>
            <th>รายละเอียด</th>
            <td>{{ $checkbody->detail ?? '-' }}</td>
        </tr>
        <tr>
            <th>น้ำหนัก</th>
            <td>{{ $checkbody->weight ?? '-' }} กิโลกรัม</td>
        </tr>
        <tr>
            <th>ส่วนสูง</th>
            <td>{{ $checkbody->height ?? '-' }} เซนติเมตร</td>
        </tr>
        <tr>
            <th>สุขภาพช่องปาก</th>
            <td>{{ $checkbody->oral ?? '-' }}</td>
        </tr>
        <tr>
            <th>รูปร่าง / ลักษณะ</th>
            <td>{{ $checkbody->appearance ?? '-' }}</td>
        </tr>
        <tr>
            <th>ร่องรอย / บาดแผล</th>
            <td>{{ $checkbody->wound ?? '-' }}</td>
        </tr>
        <tr>
            <th>โรคประจำตัว</th>
            <td>{{ $checkbody->disease ?? '-' }}</td>
        </tr>
        <tr>
            <th>สุขอนามัย</th>
            <td>{{ $checkbody->hygiene ?? '-' }}</td>
        </tr>
        <tr>
            <th>สุขภาพ</th>
            <td>{{ $checkbody->health ?? '-' }}</td>
        </tr>
        <tr>
            <th>การปลูกฝี</th>
            <td>{{ $checkbody->inoculation ?? '-' }}</td>
        </tr>
        <tr>
            <th>การฉีดยา</th>
            <td>{{ $checkbody->injection ?? '-' }}</td>
        </tr>
        <tr>
            <th>การให้วัคซีน</th>
            <td>{{ $checkbody->vaccination ?? '-' }}</td>
        </tr>
        <tr>
            <th>โรคติดต่อ</th>
            <td>{{ $checkbody->contagious ?? '-' }}</td>
        </tr>
        <tr>
            <th>การเจ็บป่วยอื่น ๆ</th>
            <td>{{ $checkbody->other ?? '-' }}</td>
        </tr>
        <tr>
            <th>ประวัติการแพ้ยา</th>
            <td>{{ $checkbody->drug_allergy ?? '-' }}</td>
        </tr>
        <tr>
            <th>หมายเหตุ</th>
            <td>{{ $checkbody->remark ?? '-' }}</td>
        </tr>
    </table>
</div>
</body>
</html>