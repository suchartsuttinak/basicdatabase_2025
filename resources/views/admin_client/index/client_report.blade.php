@extends('admin_client.admin_client')
@section('content')


   <style>
    @page {
        size: A4 portrait;
        margin: 12mm 10mm 12mm 14mm;
    }

    body {
        margin: 0;
        padding: 24px;
        background: #eef1f5;
        font-family: "TH Sarabun New", "Sarabun", "Tahoma", sans-serif;
        color: #1f2937;
        font-size: 19px;
        line-height: 1.4;
        letter-spacing: 0.1px;
    }

    .report-wrap {
        width: 1080px;
        margin: 0 auto;
        background: #ffffff;
        border: 1px solid #d8dee8;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
        padding: 26px 34px 30px 46px;
        box-sizing: border-box;
    }

    .report-header {
        position: relative;
        min-height: 126px;
        margin-bottom: 14px;
        padding-bottom: 10px;
        border-bottom: 1px solid #e5e7eb;
    }

    .report-title {
        text-align: center;
        font-size: 28px;
        font-weight: 700;
        color: #4f46e5;
        margin: 2px 110px 4px 0;
        line-height: 1.2;
        letter-spacing: .2px;
    }

    .photo-box {
        position: absolute;
        top: 0;
        right: 0;
        width: 92px;
        height: 108px;
        border: 1px solid #bfc7d4;
        border-radius: 4px;
        overflow: hidden;
        background: #fff;
    }

    .photo-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .form-row {
        display: flex;
        align-items: flex-start;
        margin-bottom: 12px;
    }

    .row-no {
        width: 42px;
        flex: 0 0 42px;
        font-weight: 700;
        font-size: 20px;
        line-height: 1.5;
        padding-top: 2px;
        color: #111827;
    }

    .row-body {
        flex: 1;
        min-width: 0;
    }

    .line {
        display: flex;
        flex-wrap: wrap;
        align-items: flex-end;
        gap: 8px 18px;
    }

    .sub-line {
        margin-top: 8px;
    }

    .sub-line + .sub-line {
        margin-top: 6px;
    }

    .field {
        display: inline-flex;
        align-items: flex-end;
        white-space: nowrap;
        min-height: 30px;
    }

    .label {
        font-weight: 700;
        margin-right: 4px;
        color: #111827;
    }

    .value {
        display: inline-block;
        border-bottom: 1px solid #98a2b3;
        min-height: 26px;
        line-height: 1.2;
        padding: 0 5px 2px 5px;
        vertical-align: bottom;
        text-align: center;
        color: #111827;
    }

    .value.left {
        text-align: left;
    }

    .w-30  { min-width: 30px; }
    .w-35  { min-width: 35px; }
    .w-40  { min-width: 40px; }
    .w-45  { min-width: 45px; }
    .w-50  { min-width: 50px; }
    .w-55  { min-width: 55px; }
    .w-60  { min-width: 60px; }
    .w-70  { min-width: 70px; }
    .w-80  { min-width: 80px; }
    .w-90  { min-width: 90px; }
    .w-100 { min-width: 100px; }
    .w-110 { min-width: 110px; }
    .w-120 { min-width: 120px; }
    .w-130 { min-width: 130px; }
    .w-140 { min-width: 140px; }
    .w-150 { min-width: 150px; }
    .w-160 { min-width: 160px; }
    .w-180 { min-width: 180px; }
    .w-200 { min-width: 200px; }
    .w-220 { min-width: 220px; }
    .w-240 { min-width: 240px; }
    .w-260 { min-width: 260px; }
    .w-320 { min-width: 320px; }
    .w-420 { min-width: 420px; }
    .w-520 { min-width: 520px; }
    .w-full { width: 100%; min-height: 30px; }

    .report-block-title,
    .problem-title,
    .member-table-title,
    .factfinding-subtitle {
        font-weight: 700;
        color: #374151;
        padding-bottom: 4px;
        border-bottom: 1px solid #d9dee7;
    }

    .report-block-title,
    .problem-title,
    .member-table-title {
        font-size: 22px;
        margin: 22px 0 10px;
    }

    .problem-list {
        display: flex;
        flex-wrap: wrap;
        gap: 8px 24px;
        padding-top: 2px;
    }

    .problem-item {
        min-width: 260px;
        font-size: 18px;
        line-height: 1.5;
    }

    .checkbox {
        font-weight: 700;
        margin-right: 4px;
    }

    .member-table-wrap {
        margin-top: 22px;
    }

    .member-table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
        margin-top: 8px;
    }

    .member-table th,
    .member-table td {
        border: 1px solid #4b5563;
        padding: 8px 10px;
        font-size: 17px;
        line-height: 1.4;
        vertical-align: top;
        word-break: break-word;
    }

    .member-table th {
        text-align: center;
        font-weight: 700;
        background: #f8fafc;
        color: #1f2937;
    }

    .center {
        text-align: center;
    }

    .factfinding-section {
        margin-top: 28px;
        padding-top: 16px;
        border-top: 2px solid #c7cfdb;
    }

    .factfinding-subtitle {
        font-size: 21px;
        margin: 18px 0 10px 0;
    }

    .factfinding-box {
        border: 1px solid #d6dde8;
        background: #fbfcff;
        padding: 12px 14px;
        margin-top: 10px;
        border-radius: 4px;
    }

    .factfinding-box + .factfinding-box {
        margin-top: 12px;
    }

    .factfinding-text {
        border: 1px solid #d3d9e3;
        background: #ffffff;
        min-height: 58px;
        padding: 10px 12px;
        line-height: 1.55;
        white-space: pre-line;
        margin-top: 6px;
        border-radius: 3px;
        word-break: break-word;
        overflow-wrap: anywhere;
    }

    .doc-list {
        display: flex;
        flex-wrap: wrap;
        gap: 8px 18px;
        margin-top: 4px;
    }

    .doc-item {
        min-width: 240px;
        font-size: 18px;
    }

    .muted {
        color: #6b7280;
    }

    /* ---------- ช่องข้อความยาวแบบอยู่แถวเดิม แต่ขึ้นบรรทัดใหม่ได้ ---------- */
    .field.wrap {
        white-space: normal;
        align-items: flex-start;
        min-width: 0;
    }

    .field.wrap .label {
        white-space: nowrap;
        flex-shrink: 0;
        margin-top: 1px;
    }

    .field.wrap .value {
        white-space: normal;
        word-break: break-word;
        overflow-wrap: anywhere;
        line-height: 1.5;
        min-width: 0;
    }

    /* ---------- แถวคู่ที่ข้อความยาวและตัดบรรทัดได้ ---------- */
    .paired-wrap-row {
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
        gap: 18px;
        align-items: start;
    }

    .paired-wrap-row .field.wrap {
        width: 100%;
    }

    .paired-wrap-row .field.wrap .value {
        flex: 1 1 auto;
        width: auto;
    }

    /* ---------- หัวข้อย่อย 14.1 - 14.4 ---------- */
    .subitem-group {
        padding-left: 42px;
        margin-top: 6px;
    }

    .subitem-row {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 10px;
    }

    .subitem-no {
        width: 60px;
        flex: 0 0 60px;
        font-weight: 700;
        color: #111827;
        line-height: 1.55;
        padding-top: 1px;
    }

    .subitem-body {
        flex: 1;
        min-width: 0;
    }

    .subitem-line {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        width: 100%;
        min-width: 0;
    }

    .subitem-label {
        flex: 0 0 250px;
        font-weight: 700;
        color: #111827;
        line-height: 1.55;
        white-space: nowrap;
        padding-top: 1px;
    }

    .subitem-value {
        flex: 1 1 auto;
        min-width: 0;
        border-bottom: 1px dashed #9aa3af;
        color: #111827;
        line-height: 1.55;
        padding: 0 5px 2px 5px;
        white-space: normal;
        word-break: break-word;
        overflow-wrap: anywhere;
        text-align: left;
    }

    @media (max-width: 1200px) {
        body {
            padding: 14px;
        }

        .report-wrap {
            width: 100%;
            padding: 22px 22px 26px 26px;
        }
    }

    @media (max-width: 768px) {
        body {
            padding: 8px;
            font-size: 18px;
        }

        .report-wrap {
            padding: 18px 16px 22px 18px;
        }

        .photo-box {
            position: static;
            margin: 12px auto 0;
        }

        .report-header {
            padding-bottom: 14px;
        }

        .form-row {
            gap: 6px;
        }

        .row-no {
            width: 34px;
            flex-basis: 34px;
        }

        .paired-wrap-row {
            grid-template-columns: 1fr;
        }

        .subitem-group {
            padding-left: 0;
        }

        .subitem-row {
            flex-direction: column;
            gap: 2px;
        }

        .subitem-no {
            width: 100%;
            flex: 0 0 auto;
        }

        .subitem-line {
            flex-direction: column;
            gap: 3px;
        }

        .subitem-label {
            flex: 0 0 auto;
            width: 100%;
            white-space: normal;
        }

        .subitem-value {
            width: 100%;
        }
    }

    @media print {
        body {
            background: #fff;
            padding: 0;
            font-size: 18px;
            line-height: 1.32;
            color: #000;
        }

        .report-wrap {
            width: 100%;
            margin: 0;
            border: 0;
            box-shadow: none;
            padding: 0;
        }

        .report-header {
            margin-bottom: 10px;
            padding-bottom: 8px;
            border-bottom: 1px solid #cfcfcf;
        }

        .factfinding-section,
        .member-table-wrap,
        .factfinding-box,
        .subitem-row,
        .form-row {
            page-break-inside: avoid;
        }
    }
</style>


@php
    $factFinding = $factFinding ?? null;

    $birthDate   = $client->birth_date ? date('d/m/Y', strtotime($client->birth_date)) : '-';
    $arrivalDate = $client->arrival_date ? date('d/m/Y', strtotime($client->arrival_date)) : '-';

    $factDate = !empty($factFinding?->date) ? date('d/m/Y', strtotime($factFinding->date)) : '-';
    $receiveDate = !empty($factFinding?->receive_date) ? date('d/m/Y', strtotime($factFinding->receive_date)) : '-';

    $showText = function ($value, $default = '-') {
        return filled($value) ? $value : $default;
    };

    $extractPlaceName = function ($value, array $possibleKeys = [], $default = '-') {
        if (blank($value)) {
            return $default;
        }

        if (is_string($value) || is_numeric($value)) {
            return $value;
        }

        if (is_object($value)) {
            foreach ($possibleKeys as $key) {
                if (isset($value->$key) && filled($value->$key)) {
                    return $value->$key;
                }
            }

            if ($value instanceof \JsonSerializable) {
                $value = $value->jsonSerialize();
            } else {
                $value = (array) $value;
            }
        }

        if (is_array($value)) {
            foreach ($possibleKeys as $key) {
                if (array_key_exists($key, $value) && filled($value[$key])) {
                    return $value[$key];
                }
            }
        }

        return $default;
    };

    $personSubDistrict = function ($person) use ($extractPlaceName) {
        if (!$person) return '-';

        return $extractPlaceName(
            $person->sub_district ?? $person->subDistrict ?? null,
            ['subd_name', 'name', 'subdistrict_name', 'sub_district_name']
        );
    };

    $personDistrict = function ($person) use ($extractPlaceName) {
        if (!$person) return '-';

        return $extractPlaceName(
            $person->district ?? null,
            ['dist_name', 'name', 'district_name']
        );
    };

    $personProvince = function ($person) use ($extractPlaceName) {
        if (!$person) return '-';

        return $extractPlaceName(
            $person->province ?? null,
            ['prov_name', 'name', 'province_name']
        );
    };
@endphp

<div class="report-wrap">
    <div class="report-header">
        <div class="report-title">ทะเบียนประวัติผู้รับการสงเคราะห์</div>
      
        <div class="photo-box">
            <img src="{{ !empty($client->image) ? asset('upload/client_images/'.$client->image) : asset('upload/no_image.jpg') }}" alt="รูปถ่าย">
        </div>
    </div>

    <div class="form-row">
        <div class="row-no"></div>
        <div class="row-body">
            <div class="line">
                <div class="field">
                    <span class="label">เลขทะเบียน</span>
                    <span class="value left w-90">{{ $client->register_number ?? '-' }}</span>
                </div>

                <div class="field" style="margin-left:36px;">
                    <span class="label">ชื่อเล่น</span>
                    <span class="value left w-90">{{ $client->nick_name ?? '-' }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="form-row">
        <div class="row-no">1.</div>
        <div class="row-body">
            <div class="line">
                <div class="field">
                    <span class="label">ชื่อ-สกุล</span>
                    <span class="value left w-260">{{ $client->full_name ?? '-' }}</span>
                </div>

                <div class="field">
                    <span class="label">อายุ</span>
                    <span class="value w-40">{{ $client->age ?? '-' }}</span>
                </div>

                <div class="field">
                    <span class="label">ปี</span>
                </div>
            </div>
        </div>
    </div>

    <div class="form-row">
        <div class="row-no">2.</div>
        <div class="row-body">
            <div class="line">
                <div class="field">
                    <span class="label">วัน เดือน ปี เกิด</span>
                    <span class="value w-100">{{ $birthDate }}</span>
                </div>

                <div class="field">
                    <span class="label">เชื้อชาติ</span>
                    <span class="value left w-80">{{ optional($client->national)->national_name ?? '-' }}</span>
                </div>

                <div class="field">
                    <span class="label">สัญชาติ</span>
                    <span class="value left w-80">{{ optional($client->national)->national_name ?? '-' }}</span>
                </div>

                <div class="field">
                    <span class="label">ศาสนา</span>
                    <span class="value left w-80">{{ optional($client->religion)->religion_name ?? '-' }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="form-row">
        <div class="row-no">3.</div>
        <div class="row-body">
            <div class="line">
                <div class="field">
                    <span class="label">บัตรประจำตัวประชาชนเลขที่</span>
                    <span class="value left w-180">{{ $client->id_card ?? '-' }}</span>
                </div>

                <div class="field">
                    <span class="label">วันที่รับเข้า</span>
                    <span class="value w-100">{{ $arrivalDate }}</span>
                </div>

                <div class="field">
                    <span class="label">กลุ่มเป้าหมาย</span>
                    <span class="value left w-130">{{ optional($client->target)->target_name ?? '-' }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="form-row">
        <div class="row-no">4.</div>
        <div class="row-body">
            <div class="line">
                <div class="field">
                    <span class="label">ภูมิลำเนาเดิมเลขที่</span>
                    <span class="value left w-50">{{ $client->origin_address ?? '-' }}</span>
                </div>

                <div class="field">
                    <span class="label">ตรอก/ซอย</span>
                    <span class="value left w-90">{{ $client->origin_soi ?? '-' }}</span>
                </div>

                <div class="field">
                    <span class="label">ถนน</span>
                    <span class="value left w-90">{{ $client->origin_road ?? '-' }}</span>
                </div>

                <div class="field">
                    <span class="label">หมู่ที่</span>
                    <span class="value w-40">{{ $client->origin_moo ?? '-' }}</span>
                </div>
            </div>

            <div class="sub-line">
                <div class="line">
                    <div class="field">
                        <span class="label">ตำบล/แขวง</span>
                        <span class="value left w-120">{{ optional($client->originSubDistrict)->subd_name ?? '-' }}</span>
                    </div>

                    <div class="field">
                        <span class="label">อำเภอ/เขต</span>
                        <span class="value left w-120">{{ optional($client->originDistrict)->dist_name ?? '-' }}</span>
                    </div>

                    <div class="field">
                        <span class="label">จังหวัด</span>
                        <span class="value left w-110">{{ optional($client->originProvince)->prov_name ?? '-' }}</span>
                    </div>

                    <div class="field">
                        <span class="label">โทร.</span>
                        <span class="value left w-100">{{ $client->origin_phone ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-row">
        <div class="row-no">5.</div>
        <div class="row-body">
            <div class="line">
                <div class="field">
                    <span class="label">ที่อยู่ปัจจุบัน เลขที่</span>
                    <span class="value left w-50">{{ $client->address ?? '-' }}</span>
                </div>

                <div class="field">
                    <span class="label">ตรอก/ซอย</span>
                    <span class="value left w-90">{{ $client->soi ?? '-' }}</span>
                </div>

                <div class="field">
                    <span class="label">ถนน</span>
                    <span class="value left w-90">{{ $client->road ?? '-' }}</span>
                </div>

                <div class="field">
                    <span class="label">หมู่ที่</span>
                    <span class="value w-40">{{ $client->moo ?? '-' }}</span>
                </div>
            </div>

            <div class="sub-line">
                <div class="line">
                    <div class="field">
                        <span class="label">ตำบล/แขวง</span>
                        <span class="value left w-120">{{ optional($client->sub_district)->subd_name ?? '-' }}</span>
                    </div>

                    <div class="field">
                        <span class="label">อำเภอ/เขต</span>
                        <span class="value left w-120">{{ optional($client->district)->dist_name ?? '-' }}</span>
                    </div>

                    <div class="field">
                        <span class="label">จังหวัด</span>
                        <span class="value left w-110">{{ optional($client->province)->prov_name ?? '-' }}</span>
                    </div>

                    <div class="field">
                        <span class="label">โทร.</span>
                        <span class="value left w-100">{{ $client->phone ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-row">
        <div class="row-no">6.</div>
        <div class="row-body">
            <div class="line">
                <div class="field">
                    <span class="label">ระดับการศึกษา</span>
                    <span class="value left w-120">{{ optional($client->education)->education_name ?? '-' }}</span>
                </div>

                <div class="field">
                    <span class="label">สถานศึกษา</span>
                    <span class="value left w-220">{{ $client->scholl ?? '-' }}</span>
                </div>

                <div class="field">
                    <span class="label">รายได้รายเดือน</span>
                    <span class="value left w-110">{{ optional($client->income)->income_name ?? '-' }}</span>
                </div>
            </div>

            <div class="sub-line">
                <div class="line">
                    <div class="field">
                        <span class="label">ปีการศึกษา</span>
                        <span class="value left w-70">{{ $client->study_year ?? '-' }}</span>
                    </div>

                    <div class="field">
                        <span class="label">จังหวัด</span>
                        <span class="value left w-110">{{ $client->school_province ?? '-' }}</span>
                    </div>

                    <div class="field">
                        <span class="label">อำเภอ/เขต</span>
                        <span class="value left w-110">{{ $client->school_district ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="report-block-title">ข้อมูลครอบครัว</div>

    <div class="form-row">
        <div class="row-no">7.</div>
        <div class="row-body">
            <div class="line">
                <div class="field">
                    <span class="label">บิดาชื่อ</span>
                    <span class="value left w-110">{{ optional($client->father)->fname ?? '-' }}</span>
                </div>

                <div class="field">
                    <span class="label">นามสกุล</span>
                    <span class="value left w-110">{{ optional($client->father)->lname ?? '-' }}</span>
                </div>

                <div class="field">
                    <span class="label">อายุ</span>
                    <span class="value w-40">{{ optional($client->father)->age ?? '-' }}</span>
                </div>

                <div class="field">
                    <span class="label">ปี</span>
                </div>

                <div class="field">
                    <span class="label">อาชีพ</span>
                    <span class="value left w-100">{{ optional($client->father)->occupation ?? '-' }}</span>
                </div>
            </div>

            <div class="sub-line">
                <div class="line">
                    <div class="field">
                        <span class="label">ที่อยู่ปัจจุบัน เลขที่</span>
                        <span class="value left w-50">{{ optional($client->father)->address_no ?? '-' }}</span>
                    </div>

                    <div class="field">
                        <span class="label">ตรอก/ซอย</span>
                        <span class="value left w-90">{{ optional($client->father)->soi ?? '-' }}</span>
                    </div>

                    <div class="field">
                        <span class="label">ถนน</span>
                        <span class="value left w-90">{{ optional($client->father)->road ?? '-' }}</span>
                    </div>

                    <div class="field">
                        <span class="label">หมู่ที่</span>
                        <span class="value w-40">{{ optional($client->father)->moo ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <div class="sub-line">
                <div class="line">
                    <div class="field">
                        <span class="label">ตำบล/แขวง</span>
                        <span class="value left w-120">{{ $personSubDistrict($client->father) }}</span>
                    </div>

                    <div class="field">
                        <span class="label">อำเภอ/เขต</span>
                        <span class="value left w-120">{{ $personDistrict($client->father) }}</span>
                    </div>

                    <div class="field">
                        <span class="label">จังหวัด</span>
                        <span class="value left w-110">{{ $personProvince($client->father) }}</span>
                    </div>

                    <div class="field">
                        <span class="label">โทร.</span>
                        <span class="value left w-100">{{ optional($client->father)->phone ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-row">
        <div class="row-no">8.</div>
        <div class="row-body">
            <div class="line">
                <div class="field">
                    <span class="label">มารดาชื่อ</span>
                    <span class="value left w-110">{{ optional($client->mother)->fname ?? '-' }}</span>
                </div>

                <div class="field">
                    <span class="label">นามสกุล</span>
                    <span class="value left w-110">{{ optional($client->mother)->lname ?? '-' }}</span>
                </div>

                <div class="field">
                    <span class="label">อายุ</span>
                    <span class="value w-40">{{ optional($client->mother)->age ?? '-' }}</span>
                </div>

                <div class="field">
                    <span class="label">ปี</span>
                </div>

                <div class="field">
                    <span class="label">อาชีพ</span>
                    <span class="value left w-100">{{ optional($client->mother)->occupation ?? '-' }}</span>
                </div>
            </div>

            <div class="sub-line">
                <div class="line">
                    <div class="field">
                        <span class="label">ที่อยู่ปัจจุบัน เลขที่</span>
                        <span class="value left w-50">{{ optional($client->mother)->address_no ?? '-' }}</span>
                    </div>

                    <div class="field">
                        <span class="label">ตรอก/ซอย</span>
                        <span class="value left w-90">{{ optional($client->mother)->soi ?? '-' }}</span>
                    </div>

                    <div class="field">
                        <span class="label">ถนน</span>
                        <span class="value left w-90">{{ optional($client->mother)->road ?? '-' }}</span>
                    </div>

                    <div class="field">
                        <span class="label">หมู่ที่</span>
                        <span class="value w-40">{{ optional($client->mother)->moo ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <div class="sub-line">
                <div class="line">
                    <div class="field">
                        <span class="label">ตำบล/แขวง</span>
                        <span class="value left w-120">{{ $personSubDistrict($client->mother) }}</span>
                    </div>

                    <div class="field">
                        <span class="label">อำเภอ/เขต</span>
                        <span class="value left w-120">{{ $personDistrict($client->mother) }}</span>
                    </div>

                    <div class="field">
                        <span class="label">จังหวัด</span>
                        <span class="value left w-110">{{ $personProvince($client->mother) }}</span>
                    </div>

                    <div class="field">
                        <span class="label">โทร.</span>
                        <span class="value left w-100">{{ optional($client->mother)->phone ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-row">
        <div class="row-no">9.</div>
        <div class="row-body">
            <div class="line">
                <div class="field">
                    <span class="label">ผู้ปกครองชื่อ</span>
                    <span class="value left w-110">{{ optional($client->relative)->fname ?? '-' }}</span>
                </div>

                <div class="field">
                    <span class="label">นามสกุล</span>
                    <span class="value left w-110">{{ optional($client->relative)->lname ?? '-' }}</span>
                </div>

                <div class="field">
                    <span class="label">อายุ</span>
                    <span class="value w-40">{{ optional($client->relative)->age ?? '-' }}</span>
                </div>

                <div class="field">
                    <span class="label">ปี</span>
                </div>

                <div class="field">
                    <span class="label">เกี่ยวข้องเป็น</span>
                    <span class="value left w-100">{{ optional($client->relative)->relation ?? '-' }}</span>
                </div>
            </div>

            <div class="sub-line">
                <div class="line">
                    <div class="field">
                        <span class="label">ที่อยู่ปัจจุบัน เลขที่</span>
                        <span class="value left w-50">{{ optional($client->relative)->address_no ?? '-' }}</span>
                    </div>

                    <div class="field">
                        <span class="label">ตรอก/ซอย</span>
                        <span class="value left w-90">{{ optional($client->relative)->soi ?? '-' }}</span>
                    </div>

                    <div class="field">
                        <span class="label">ถนน</span>
                        <span class="value left w-90">{{ optional($client->relative)->road ?? '-' }}</span>
                    </div>

                    <div class="field">
                        <span class="label">หมู่ที่</span>
                        <span class="value w-40">{{ optional($client->relative)->moo ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <div class="sub-line">
                <div class="line">
                    <div class="field">
                        <span class="label">ตำบล/แขวง</span>
                        <span class="value left w-120">{{ $personSubDistrict($client->relative) }}</span>
                    </div>

                    <div class="field">
                        <span class="label">อำเภอ/เขต</span>
                        <span class="value left w-120">{{ $personDistrict($client->relative) }}</span>
                    </div>

                    <div class="field">
                        <span class="label">จังหวัด</span>
                        <span class="value left w-110">{{ $personProvince($client->relative) }}</span>
                    </div>

                    <div class="field">
                        <span class="label">โทร.</span>
                        <span class="value left w-100">{{ optional($client->relative)->phone ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-row">
        <div class="row-no">10.</div>
        <div class="row-body">
            <div class="line">
                <div class="field">
                    <span class="label">ญาติผู้ที่อุปการะชื่อ</span>
                    <span class="value left w-110">{{ optional($client->spouse)->fname ?? '-' }}</span>
                </div>

                <div class="field">
                    <span class="label">นามสกุล</span>
                    <span class="value left w-110">{{ optional($client->spouse)->lname ?? '-' }}</span>
                </div>

                <div class="field">
                    <span class="label">อายุ</span>
                    <span class="value w-40">{{ optional($client->spouse)->age ?? '-' }}</span>
                </div>

                <div class="field">
                    <span class="label">ปี</span>
                </div>

                <div class="field">
                    <span class="label">เกี่ยวข้องเป็น</span>
                    <span class="value left w-100">{{ optional($client->spouse)->relation ?? '-' }}</span>
                </div>
            </div>

            <div class="sub-line">
                <div class="line">
                    <div class="field">
                        <span class="label">ที่อยู่ปัจจุบัน เลขที่</span>
                        <span class="value left w-50">{{ optional($client->spouse)->address_no ?? '-' }}</span>
                    </div>

                    <div class="field">
                        <span class="label">ตรอก/ซอย</span>
                        <span class="value left w-90">{{ optional($client->spouse)->soi ?? '-' }}</span>
                    </div>

                    <div class="field">
                        <span class="label">ถนน</span>
                        <span class="value left w-90">{{ optional($client->spouse)->road ?? '-' }}</span>
                    </div>

                    <div class="field">
                        <span class="label">หมู่ที่</span>
                        <span class="value w-40">{{ optional($client->spouse)->moo ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <div class="sub-line">
                <div class="line">
                    <div class="field">
                        <span class="label">ตำบล/แขวง</span>
                        <span class="value left w-120">{{ $personSubDistrict($client->spouse) }}</span>
                    </div>

                    <div class="field">
                        <span class="label">อำเภอ/เขต</span>
                        <span class="value left w-120">{{ $personDistrict($client->spouse) }}</span>
                    </div>

                    <div class="field">
                        <span class="label">จังหวัด</span>
                        <span class="value left w-110">{{ $personProvince($client->spouse) }}</span>
                    </div>

                    <div class="field">
                        <span class="label">โทร.</span>
                        <span class="value left w-100">{{ optional($client->spouse)->phone ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="problem-title">สภาพปัญหา</div>
        <div class="problem-list">
            @if(!empty($clientProblems) && $clientProblems->count() > 0)

                @foreach($clientProblems as $problem)
                    <div class="problem-item">
                        <span class="checkbox">☑</span>
                        {{ $problem->problem_name ?? $problem->name ?? '-' }}
                    </div>
                @endforeach

            @else
                <div class="problem-item">- ไม่มีข้อมูลปัญหา -</div>
            @endif
        </div>

    <div class="member-table-wrap">
        <div class="member-table-title">รายละเอียดสมาชิกครอบครัว</div>

        <table class="member-table">
            <thead>
                <tr>
                    <th style="width:7%;">ลำดับที่</th>
                    <th style="width:25%;">ชื่อ-สกุล</th>
                    <th style="width:7%;">อายุ</th>
                    <th style="width:10%;">เกี่ยวข้อง</th>
                    <th style="width:20%;">อาชีพ/การศึกษา</th>
                    <th style="width:17%;">รายได้/เดือน</th>
                    <th style="width:15%;">หมายเหตุ</th>
                </tr>
            </thead>
            <tbody>
                @forelse($client->members as $index => $member)
                    <tr>
                        <td class="center">{{ $index + 1 }}</td>
                        <td>{{ $member->fullname ?? '-' }}</td>
                        <td class="center">{{ $member->member_age ?? '-' }}</td>
                        <td class="center">{{ $member->relationship ?? '-' }}</td>
                        <td>{{ optional($member->occupation)->occupation_name ?? optional($member->education)->education_name ?? '-' }}</td>
                        <td class="center">{{ optional($member->income)->income_name ?? '-' }}</td>
                        <td>{{ $member->remark ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td class="center">&nbsp;</td>
                        <td></td>
                        <td class="center"></td>
                        <td class="center"></td>
                        <td></td>
                        <td class="center"></td>
                        <td></td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="factfinding-section">
       

        <div class="form-row">
            <div class="row-no">11.</div>
            <div class="row-body">
                <div class="line">
                    <div class="field">
                        <span class="label">วันที่นำส่ง</span>
                        <span class="value w-100">{{ $factDate }}</span>
                    </div>

                    <div class="field">
                        <span class="label">วันที่บันทึกข้อมูล</span>
                        <span class="value w-100">{{ $receiveDate }}</span>
                    </div>

                    <div class="field">
                        <span class="label">ผู้นำส่ง</span>
                        <span class="value left w-260">{{ $showText($factFinding?->fact_name) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="factfinding-subtitle">12. ข้อมูลด้านร่างกายและสุขภาพ</div>

        <div class="form-row">
            <div class="row-no"></div>
            <div class="row-body">
                <div class="line">
                    <div class="field">
                        <span class="label">รูปพรรณสัณฐาน</span>
                        <span class="value left w-150">{{ $showText($factFinding?->appearance) }}</span>
                    </div>
                    <div class="field">
                        <span class="label">สีผิว</span>
                        <span class="value left w-120">{{ $showText($factFinding?->skin) }}</span>
                    </div>
                    <div class="field">
                        <span class="label">ตำหนิ/แผลเป็น</span>
                        <span class="value left w-120">{{ $showText($factFinding?->scar) }}</span>
                    </div>
                    <div class="field">
                        <span class="label">ลักษณะความพิการ</span>
                        <span class="value left w-140">{{ $showText($factFinding?->disability) }}</span>
                    </div>
                </div>

                <div class="sub-line">
                    <div class="line">
                        <div class="field">
                            <span class="label">น้ำหนัก</span>
                            <span class="value w-55">{{ $showText($factFinding?->weight) }}</span>
                        </div>
                        <div class="field"><span class="label">กก.</span></div>

                        <div class="field">
                            <span class="label">ส่วนสูง</span>
                            <span class="value w-55">{{ $showText($factFinding?->height) }}</span>
                        </div>
                        <div class="field"><span class="label">ซม.</span></div>

                        <div class="field">
                            <span class="label">กรุ๊ปเลือด</span>
                            <span class="value left w-70">{{ $showText($factFinding?->blood_group) }}</span>
                        </div>

                        <div class="field">
                            <span class="label">สุขอนามัย</span>
                            <span class="value left w-120">{{ $showText($factFinding?->hygiene) }}</span>
                        </div>

                        <div class="field">
                            <span class="label">สุขภาพช่องปาก</span>
                            <span class="value left w-120">{{ $showText($factFinding?->oral_health) }}</span>
                        </div>
                    </div>
                </div>

                <div class="sub-line">
                    <div class="line">
                        <div class="field">
                            <span class="label">บาดแผล/การบาดเจ็บ</span>
                            <span class="value left w-260">{{ $showText($factFinding?->injury) }}</span>
                        </div>
                       <div class="field wrap">
    <span class="label">หลักฐานที่พบ</span>
    <span class="value left w-260">{{ $showText($factFinding?->evidence) }}</span>
</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="row-no">13.</div>
            <div class="row-body">
                <div class="line">
                    <div class="field">
                        <span class="label">การเจ็บป่วย</span>
                        <span class="value left w-70">{{ ($factFinding?->sick ?? 0) == 1 ? 'มี' : 'ไม่มี' }}</span>
                    </div>

                    <div class="field">
                        <span class="label">รายละเอียดการเจ็บป่วย</span>
                        <span class="value left w-320">{{ $showText($factFinding?->sick_detail) }}</span>
                    </div>
                </div>

                <div class="sub-line">
                    <div class="line">
                        <div class="field">
                            <span class="label">การรักษา</span>
                            <span class="value left w-220">{{ $showText($factFinding?->treatment) }}</span>
                        </div>

                        <div class="field">
                            <span class="label">โรงพยาบาล</span>
                            <span class="value left w-260">{{ $showText($factFinding?->hospital) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="factfinding-subtitle">14. ข้อมูลด้านครอบครัวและความสัมพันธ์</div>

        <div class="subitem-group">
            <div class="subitem-row">
                <div class="subitem-no">14.1</div>
                <div class="subitem-body">
                    <div class="full-row-field">
                        <span class="label">สถานภาพสมรส</span>
                        <span class="value left">{{ optional($factFinding?->marital)->marital_name ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <div class="subitem-row">
                <div class="subitem-no">14.2</div>
                <div class="subitem-body">
                    <div class="full-row-field">
                        <span class="label">ความสัมพันธ์ระหว่างบิดามารดา</span>
                        <span class="value left">{{ $showText($factFinding?->relation_parent) }}</span>
                    </div>
                </div>
            </div>

            <div class="subitem-row">
                <div class="subitem-no">14.3</div>
                <div class="subitem-body">
                    <div class="full-row-field">
                        <span class="label">ความสัมพันธ์ระหว่างบุคคลในครอบครัว</span>
                        <span class="value left">{{ $showText($factFinding?->relation_family) }}</span>
                    </div>
                </div>
            </div>

            <div class="subitem-row">
                <div class="subitem-no">14.4</div>
                <div class="subitem-body">
                    <div class="full-row-field">
                        <span class="label">ความสัมพันธ์กับบุตร/บุคคลในครอบครัว</span>
                        <span class="value left">{{ $showText($factFinding?->relation_child) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="factfinding-subtitle">15. สภาพแวดล้อม</div>

        <div class="factfinding-box">
            <div class="label">สภาพที่อยู่อาศัยภายนอก</div>
            <div class="factfinding-text">{{ $showText($factFinding?->ex_conditions) }}</div>
        </div>

        <div class="factfinding-box">
            <div class="label">สภาพที่อยู่อาศัยภายใน</div>
            <div class="factfinding-text">{{ $showText($factFinding?->in_conditions) }}</div>
        </div>

        <div class="factfinding-box">
            <div class="label">สภาพแวดล้อม</div>
            <div class="factfinding-text">{{ $showText($factFinding?->environment) }}</div>
        </div>

        <div class="factfinding-subtitle">16. การวิเคราะห์ปัญหาและความต้องการ</div>

        <div class="factfinding-box">
            <div class="label">สาเหตุที่เข้ารับการสงเคราะห์</div>
            <div class="factfinding-text">{{ $showText($factFinding?->cause_problem) }}</div>
        </div>

        <div class="factfinding-box">
            <div class="label">ความต้องการความช่วยเหลือ</div>
            <div class="factfinding-text">{{ $showText($factFinding?->need) }}</div>
        </div>

        <div class="factfinding-box">
            <div class="label">ประวัติความเป็นมา</div>
            <div class="factfinding-text">{{ $showText($factFinding?->case_history) }}</div>
        </div>

        <div class="factfinding-box">
            <div class="label">ข้อมูลเท็จจริงอื่น ๆ</div>
            <div class="factfinding-text">{{ $showText($factFinding?->information) }}</div>
        </div>

        <div class="factfinding-box">
            <div class="label">การวินิจฉัยปัญหา</div>
            <div class="factfinding-text">{{ $showText($factFinding?->diagnosis) }}</div>
        </div>

        <div class="factfinding-subtitle">17. เอกสารประกอบและผู้บันทึก</div>

        <div class="form-row">
            <div class="row-no"></div>
            <div class="row-body">
                <div class="line">
                    <div class="field">
                        <span class="label">ผู้บันทึก</span>
                        <span class="value left w-220">{{ $showText($factFinding?->recorder) }}</span>
                    </div>

                    <div class="field">
                        <span class="label">สถานะข้อมูล</span>
                        <span class="value left w-100">{{ ($factFinding?->active ?? 0) ? 'ใช้งาน' : 'ไม่ใช้งาน' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="problem-title" style="margin-top: 12px;">เอกสารประกอบการสอบข้อเท็จจริง</div>
        <div class="doc-list">
            @if(!empty($factFinding) && $factFinding->documents && $factFinding->documents->count() > 0)
                @foreach($factFinding->documents as $doc)
                    <div class="doc-item">
                        <span class="checkbox">☑</span>{{ $doc->document_name ?? '-' }}
                    </div>
                @endforeach
            @else
                <div class="doc-item muted">- ไม่มีข้อมูลเอกสารประกอบ -</div>
            @endif
        </div>
    </div>
</div>

@endsection