@extends('admin_client.admin_client')
@section('content')

<style>
    body {
        margin: 0;
        padding: 20px;
        background: #f2f2f2;
        font-family: "TH Sarabun New", "Sarabun", "Tahoma", sans-serif;
        color: #222;
        font-size: 18px;
        line-height: 1.25;
    }

    .report-wrap {
        width: 1120px;
        margin: 0 auto;
        background: #fff;
        border: 1px solid #cfcfcf;
        padding: 18px 24px 20px 24px;
        box-sizing: border-box;
    }

    .report-header {
        position: relative;
        min-height: 118px;
        margin-bottom: 8px;
    }

    .report-title {
        text-align: center;
        font-size: 25px;
        font-weight: bold;
        color: #6f72d9;
        margin: 2px 0 0 0;
    }

    .photo-box {
        position: absolute;
        top: 0;
        right: 10px;
        width: 84px;
        height: 98px;
        border: 1px solid #8f8f8f;
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
        margin-bottom: 4px;
    }

    .row-no {
        width: 34px;
        flex: 0 0 34px;
        font-weight: bold;
        font-size: 19px;
        line-height: 1.2;
        padding-top: 1px;
    }

    .row-body {
        flex: 1;
        min-width: 0;
    }

    .line {
        display: flex;
        flex-wrap: wrap;
        align-items: flex-end;
        gap: 3px 12px;
    }

    .sub-line {
        margin-top: 2px;
    }

    /* ให้บรรทัดย่อยเริ่มในแนวเดียวกับข้อความหลัก */
    .sub-line.same-start {
        padding-left: 0;
    }

    .field {
        display: inline-flex;
        align-items: flex-end;
        white-space: nowrap;
    }

    .label {
        font-weight: bold;
        margin-right: 3px;
    }

    .value {
        display: inline-block;
        border-bottom: 1px solid #9d9d9d;
        min-height: 20px;
        line-height: 1.05;
        padding: 0 3px 1px 3px;
        vertical-align: bottom;
        text-align: center;
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
    .w-260 { min-width: 260px; }

    .problem-title {
        font-weight: bold;
        font-size: 19px;
        margin: 10px 0 3px 0;
    }

    .problem-list {
        display: flex;
        flex-wrap: wrap;
        gap: 2px 16px;
    }

    .problem-item {
        min-width: 250px;
        font-size: 17px;
    }

    .checkbox {
        font-weight: bold;
        margin-right: 3px;
    }

    .member-table-wrap {
        margin-top: 14px;
    }

    .member-table-title {
        font-weight: bold;
        font-size: 19px;
        margin-bottom: 5px;
    }

    .member-table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
    }

    .member-table th,
    .member-table td {
        border: 2px solid #333;
        padding: 5px 6px;
        font-size: 16px;
        line-height: 1.2;
        vertical-align: top;
        word-break: break-word;
    }

    .member-table th {
        text-align: center;
        font-weight: bold;
        background: #fafafa;
    }

    .center {
        text-align: center;
    }

    @media (max-width: 1200px) {
        .report-wrap {
            width: 100%;
        }
    }

    .form-row {
    display: flex;
    align-items: flex-start;
    margin-bottom: 14px;   /* เพิ่มจาก 10 → 14 */
}

.row-no {
    width: 34px;
    flex: 0 0 34px;
    font-weight: bold;
    font-size: 19px;
    line-height: 1.5;     /* เพิ่มความโปร่ง */
    padding-top: 2px;
}

.line {
    display: flex;
    flex-wrap: wrap;
    align-items: flex-end;
    gap: 8px 18px;        /* เพิ่ม spacing แนวนอน + แนวตั้ง */
}

.sub-line {
    margin-top: 8px;      /* จาก 6 → 8 */
}

/* เพิ่มช่องว่างระหว่างบล็อกย่อย */
.sub-line + .sub-line {
    margin-top: 6px;
}

.value {
    display: inline-block;
    border-bottom: 1px solid #9d9d9d;
    min-height: 24px;     /* จาก 22 → 24 */
    line-height: 1.2;
    padding: 0 4px 2px 4px;
}

/* ข้อ 7–10 ให้โปร่งขึ้นอีกนิด */
.form-row.family-row {
    margin-bottom: 16px;
}

/* สภาพปัญหา */
.problem-title {
    font-weight: bold;
    font-size: 19px;
    margin: 20px 0 8px 0;   /* เพิ่มระยะบน */
}

.problem-list {
    display: flex;
    flex-wrap: wrap;
    gap: 8px 24px;
}

.problem-item {
    min-width: 260px;
    font-size: 17px;
    line-height: 1.5;
}

/* ตาราง */
.member-table-wrap {
    margin-top: 22px;
}

.member-table-title {
    font-weight: bold;
    font-size: 19px;
    margin-bottom: 10px;
}

.member-table th,
.member-table td {
    border: 2px solid #333;
    padding: 9px 10px;   /* เพิ่มอีก */
    font-size: 16px;
    line-height: 1.4;
}

.report-wrap {
    width: 1120px;
    margin: 0 auto;
    padding-left: 100px;   /* เพิ่ม */
    padding-right: 24px;
}

</style>

@php
    $birthDate   = $client->birth_date ? date('m/d/Y', strtotime($client->birth_date)) : '-';
    $arrivalDate = $client->arrival_date ? date('m/d/Y', strtotime($client->arrival_date)) : '-';
@endphp

<div class="report-wrap">
    <div class="report-header">
        <div class="report-title">ทะเบียนประวัติผู้รับการสงเคราะห์</div>

        <div class="photo-box">
            <img src="{{ !empty($client->image) ? asset('upload/client_images/'.$client->image) : asset('upload/no_image.jpg') }}" alt="รูปถ่าย">
        </div>
    </div>

    {{-- เลขทะเบียน / ชื่อเล่น --}}
    <div class="form-row">
        <div class="row-no"></div>
        <div class="row-body">
            <div class="line">
                <div class="field">
                    <span class="label">เลขทะเบียน</span>
                    <span class="value left w-70">{{ $client->register_number ?? '-' }}</span>
                </div>

                <div class="field" style="margin-left:55px;">
                    <span class="label">ชื่อเล่น</span>
                    <span class="value left w-70">{{ $client->nick_name ?? '-' }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- 1 --}}
    <div class="form-row">
        <div class="row-no">1.</div>
        <div class="row-body">
            <div class="line">
               

                <div class="field">
                    <span class="label">ชื่อ-สกุล</span>
                    <span class="value left w-220">{{ $client->full_name ?? '-' }}</span>
                </div>

                <div class="field">
                    <span class="label">อายุ</span>
                    <span class="value w-35">{{ $client->age ?? '-' }}</span>
                </div>

                <div class="field">
                    <span class="label">ปี</span>
                </div>
            </div>
        </div>
    </div>

    {{-- 2 --}}
    <div class="form-row">
        <div class="row-no">2.</div>
        <div class="row-body">
            <div class="line">
                <div class="field">
                    <span class="label">วัน เดือน ปี เกิด</span>
                    <span class="value w-90">{{ $birthDate }}</span>
                </div>

                <div class="field">
                    <span class="label">เชื้อชาติ</span>
                    <span class="value left w-55">{{ optional($client->national)->national_name ?? '-' }}</span>
                </div>

                <div class="field">
                    <span class="label">สัญชาติ</span>
                    <span class="value left w-55">{{ optional($client->national)->national_name ?? '-' }}</span>
                </div>

                <div class="field">
                    <span class="label">ศาสนา</span>
                    <span class="value left w-55">{{ optional($client->religion)->religion_name ?? '-' }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- 3 --}}
    <div class="form-row">
        <div class="row-no">3.</div>
        <div class="row-body">
            <div class="line">
                <div class="field">
                    <span class="label">บัตรประจำตัวประชาชนเลขที่</span>
                    <span class="value left w-160">{{ $client->id_card ?? '-' }}</span>
                </div>

                <div class="field">
                    <span class="label">วันที่รับเข้า</span>
                    <span class="value w-90">{{ $arrivalDate }}</span>
                </div>

                <div class="field">
                    <span class="label">กลุ่มเป้าหมาย</span>
                    <span class="value left w-110">{{ optional($client->target)->target_name ?? '-' }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- 4 --}}
    <div class="form-row">
        <div class="row-no">4.</div>
        <div class="row-body">
            <div class="line">
                <div class="field">
                    <span class="label">ภูมิลำเนาเดิมเลขที่</span>
                    <span class="value left w-45">{{ $client->origin_address ?? '-' }}</span>
                </div>

                <div class="field">
                    <span class="label">ตรอก/ซอย</span>
                    <span class="value left w-80">{{ $client->origin_soi ?? '-' }}</span>
                </div>

                <div class="field">
                    <span class="label">ถนน</span>
                    <span class="value left w-80">{{ $client->origin_road ?? '-' }}</span>
                </div>

                <div class="field">
                    <span class="label">หมู่ที่</span>
                    <span class="value w-35">{{ $client->origin_moo ?? '-' }}</span>
                </div>
            </div>

            <div class="sub-line same-start">
                <div class="line">
                    <div class="field">
                        <span class="label">ตำบล/แขวง</span>
                        <span class="value left w-100">{{ optional($client->originSubDistrict)->subd_name ?? '-' }}</span>
                    </div>

                    <div class="field">
                        <span class="label">อำเภอ/เขต</span>
                        <span class="value left w-100">{{ optional($client->originDistrict)->dist_name ?? '-' }}</span>
                    </div>

                    <div class="field">
                        <span class="label">จังหวัด</span>
                        <span class="value left w-90">{{ optional($client->originProvince)->prov_name ?? '-' }}</span>
                    </div>

                    <div class="field">
                        <span class="label">โทร.</span>
                        <span class="value left w-80">{{ $client->origin_phone ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 5 --}}
    <div class="form-row">
        <div class="row-no">5.</div>
        <div class="row-body">
            <div class="line">
                <div class="field">
                    <span class="label">ที่อยู่ปัจจุบัน เลขที่</span>
                    <span class="value left w-45">{{ $client->address ?? '-' }}</span>
                </div>

                <div class="field">
                    <span class="label">ตรอก/ซอย</span>
                    <span class="value left w-80">{{ $client->soi ?? '-' }}</span>
                </div>

                <div class="field">
                    <span class="label">ถนน</span>
                    <span class="value left w-80">{{ $client->road ?? '-' }}</span>
                </div>

                <div class="field">
                    <span class="label">หมู่ที่</span>
                    <span class="value w-35">{{ $client->moo ?? '-' }}</span>
                </div>
            </div>

            <div class="sub-line same-start">
                <div class="line">
                    <div class="field">
                        <span class="label">ตำบล/แขวง</span>
                        <span class="value left w-100">{{ optional($client->sub_district)->subd_name ?? '-' }}</span>
                    </div>

                    <div class="field">
                        <span class="label">อำเภอ/เขต</span>
                        <span class="value left w-100">{{ optional($client->district)->dist_name ?? '-' }}</span>
                    </div>

                    <div class="field">
                        <span class="label">จังหวัด</span>
                        <span class="value left w-90">{{ optional($client->province)->prov_name ?? '-' }}</span>
                    </div>

                    <div class="field">
                        <span class="label">โทร.</span>
                        <span class="value left w-80">{{ $client->phone ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 6 --}}
    <div class="form-row">
        <div class="row-no">6.</div>
        <div class="row-body">
            <div class="line">
                <div class="field">
                    <span class="label">ระดับการศึกษา</span>
                    <span class="value left w-100">{{ optional($client->education)->education_name ?? '-' }}</span>
                </div>

                <div class="field">
                    <span class="label">สถานศึกษา</span>
                    <span class="value left w-160">{{ $client->scholl ?? '-' }}</span>
                </div>

                <div class="field">
                    <span class="label">รายได้รายเดือน</span>
                    <span class="value left w-100">{{ optional($client->income)->income_name ?? '-' }}</span>
                </div>
            </div>

            <div class="sub-line same-start">
                <div class="line">
                    <div class="field">
                        <span class="label">ปีการศึกษา</span>
                        <span class="value left w-55">{{ $client->study_year ?? '-' }}</span>
                    </div>

                    <div class="field">
                        <span class="label">จังหวัด</span>
                        <span class="value left w-90">{{ optional($client->schoolProvince)->prov_name ?? '-' }}</span>
                    </div>

                    <div class="field">
                        <span class="label">อำเภอ/เขต</span>
                        <span class="value left w-90">{{ optional($client->schoolDistrict)->dist_name ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 7 บิดา --}}
    <div class="form-row">
        <div class="row-no">7.</div>
        <div class="row-body">
            <div class="line">
                <div class="field">
                    <span class="label">บิดาชื่อ</span>
                    <span class="value left w-100">{{ optional($client->father)->fname ?? '-' }}</span>
                </div>

                <div class="field">
                    <span class="label">นามสกุล</span>
                    <span class="value left w-100">{{ optional($client->father)->lname ?? '-' }}</span>
                </div>

                <div class="field">
                    <span class="label">อายุ</span>
                    <span class="value w-35">{{ optional($client->father)->age ?? '-' }}</span>
                </div>

                <div class="field">
                    <span class="label">ปี</span>
                </div>

                <div class="field">
                    <span class="label">อาชีพ</span>
                    <span class="value left w-80">{{ optional($client->father)->occupation ?? '-' }}</span>
                </div>
            </div>

            <div class="sub-line same-start">
                <div class="line">
                    <div class="field">
                        <span class="label">ที่อยู่ปัจจุบัน เลขที่</span>
                        <span class="value left w-45">{{ optional($client->father)->address_no ?? '-' }}</span>
                    </div>

                    <div class="field">
                        <span class="label">ตรอก/ซอย</span>
                        <span class="value left w-80">{{ optional($client->father)->soi ?? '-' }}</span>
                    </div>

                    <div class="field">
                        <span class="label">ถนน</span>
                        <span class="value left w-80">{{ optional($client->father)->road ?? '-' }}</span>
                    </div>

                    <div class="field">
                        <span class="label">หมู่ที่</span>
                        <span class="value w-35">{{ optional($client->father)->moo ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <div class="sub-line same-start">
                <div class="line">
                    <div class="field">
                        <span class="label">ตำบล/แขวง</span>
                        <span class="value left w-100">{{ optional(optional($client->father)->sub_district)->subd_name ?? '-' }}</span>
                    </div>

                    <div class="field">
                        <span class="label">อำเภอ/เขต</span>
                        <span class="value left w-100">{{ optional(optional($client->father)->district)->dist_name ?? '-' }}</span>
                    </div>

                    <div class="field">
                        <span class="label">จังหวัด</span>
                        <span class="value left w-90">{{ optional(optional($client->father)->province)->prov_name ?? '-' }}</span>
                    </div>

                    <div class="field">
                        <span class="label">โทร.</span>
                        <span class="value left w-80">{{ optional($client->father)->phone ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 8 มารดา --}}
    <div class="form-row">
        <div class="row-no">8.</div>
        <div class="row-body">
            <div class="line">
                <div class="field">
                    <span class="label">มารดาชื่อ</span>
                    <span class="value left w-100">{{ optional($client->mother)->fname ?? '-' }}</span>
                </div>

                <div class="field">
                    <span class="label">นามสกุล</span>
                    <span class="value left w-100">{{ optional($client->mother)->lname ?? '-' }}</span>
                </div>

                <div class="field">
                    <span class="label">อายุ</span>
                    <span class="value w-35">{{ optional($client->mother)->age ?? '-' }}</span>
                </div>

                <div class="field">
                    <span class="label">ปี</span>
                </div>

                <div class="field">
                    <span class="label">อาชีพ</span>
                    <span class="value left w-80">{{ optional($client->mother)->occupation ?? '-' }}</span>
                </div>
            </div>

            <div class="sub-line same-start">
                <div class="line">
                    <div class="field">
                        <span class="label">ที่อยู่ปัจจุบัน เลขที่</span>
                        <span class="value left w-45">{{ optional($client->mother)->address_no ?? '-' }}</span>
                    </div>

                    <div class="field">
                        <span class="label">ตรอก/ซอย</span>
                        <span class="value left w-80">{{ optional($client->mother)->soi ?? '-' }}</span>
                    </div>

                    <div class="field">
                        <span class="label">ถนน</span>
                        <span class="value left w-80">{{ optional($client->mother)->road ?? '-' }}</span>
                    </div>

                    <div class="field">
                        <span class="label">หมู่ที่</span>
                        <span class="value w-35">{{ optional($client->mother)->moo ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <div class="sub-line same-start">
                <div class="line">
                    <div class="field">
                        <span class="label">ตำบล/แขวง</span>
                        <span class="value left w-100">{{ optional(optional($client->mother)->sub_district)->subd_name ?? '-' }}</span>
                    </div>

                    <div class="field">
                        <span class="label">อำเภอ/เขต</span>
                        <span class="value left w-100">{{ optional(optional($client->mother)->district)->dist_name ?? '-' }}</span>
                    </div>

                    <div class="field">
                        <span class="label">จังหวัด</span>
                        <span class="value left w-90">{{ optional(optional($client->mother)->province)->prov_name ?? '-' }}</span>
                    </div>

                    <div class="field">
                        <span class="label">โทร.</span>
                        <span class="value left w-80">{{ optional($client->mother)->phone ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 9 ผู้ปกครอง --}}
    <div class="form-row">
        <div class="row-no">9.</div>
        <div class="row-body">
            <div class="line">
                <div class="field">
                    <span class="label">ผู้ปกครองชื่อ</span>
                    <span class="value left w-100">{{ optional($client->relative)->fname ?? '-' }}</span>
                </div>

                <div class="field">
                    <span class="label">นามสกุล</span>
                    <span class="value left w-100">{{ optional($client->relative)->lname ?? '-' }}</span>
                </div>

                <div class="field">
                    <span class="label">อายุ</span>
                    <span class="value w-35">{{ optional($client->relative)->age ?? '-' }}</span>
                </div>

                <div class="field">
                    <span class="label">ปี</span>
                </div>

                <div class="field">
                    <span class="label">เกี่ยวข้องเป็น</span>
                    <span class="value left w-80">{{ optional($client->relative)->relation ?? '-' }}</span>
                </div>
            </div>

            <div class="sub-line same-start">
                <div class="line">
                    <div class="field">
                        <span class="label">ที่อยู่ปัจจุบัน เลขที่</span>
                        <span class="value left w-45">{{ optional($client->relative)->address_no ?? '-' }}</span>
                    </div>

                    <div class="field">
                        <span class="label">ตรอก/ซอย</span>
                        <span class="value left w-80">{{ optional($client->relative)->soi ?? '-' }}</span>
                    </div>

                    <div class="field">
                        <span class="label">ถนน</span>
                        <span class="value left w-80">{{ optional($client->relative)->road ?? '-' }}</span>
                    </div>

                    <div class="field">
                        <span class="label">หมู่ที่</span>
                        <span class="value w-35">{{ optional($client->relative)->moo ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <div class="sub-line same-start">
                <div class="line">
                    <div class="field">
                        <span class="label">ตำบล/แขวง</span>
                        <span class="value left w-100">{{ optional(optional($client->relative)->sub_district)->subd_name ?? '-' }}</span>
                    </div>

                    <div class="field">
                        <span class="label">อำเภอ/เขต</span>
                        <span class="value left w-100">{{ optional(optional($client->relative)->district)->dist_name ?? '-' }}</span>
                    </div>

                    <div class="field">
                        <span class="label">จังหวัด</span>
                        <span class="value left w-90">{{ optional(optional($client->relative)->province)->prov_name ?? '-' }}</span>
                    </div>

                    <div class="field">
                        <span class="label">โทร.</span>
                        <span class="value left w-80">{{ optional($client->relative)->phone ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 10 ญาติผู้ที่อุปการะ --}}
    <div class="form-row">
        <div class="row-no">10.</div>
        <div class="row-body">
            <div class="line">
                <div class="field">
                    <span class="label">ญาติผู้ที่อุปการะชื่อ</span>
                    <span class="value left w-100">{{ optional($client->spouse)->fname ?? '-' }}</span>
                </div>

                <div class="field">
                    <span class="label">นามสกุล</span>
                    <span class="value left w-100">{{ optional($client->spouse)->lname ?? '-' }}</span>
                </div>

                <div class="field">
                    <span class="label">อายุ</span>
                    <span class="value w-35">{{ optional($client->spouse)->age ?? '-' }}</span>
                </div>

                <div class="field">
                    <span class="label">ปี</span>
                </div>

                <div class="field">
                    <span class="label">เกี่ยวข้องเป็น</span>
                    <span class="value left w-80">{{ optional($client->spouse)->relation ?? '-' }}</span>
                </div>
            </div>

            <div class="sub-line same-start">
                <div class="line">
                    <div class="field">
                        <span class="label">ที่อยู่ปัจจุบัน เลขที่</span>
                        <span class="value left w-45">{{ optional($client->spouse)->address_no ?? '-' }}</span>
                    </div>

                    <div class="field">
                        <span class="label">ตรอก/ซอย</span>
                        <span class="value left w-80">{{ optional($client->spouse)->soi ?? '-' }}</span>
                    </div>

                    <div class="field">
                        <span class="label">ถนน</span>
                        <span class="value left w-80">{{ optional($client->spouse)->road ?? '-' }}</span>
                    </div>

                    <div class="field">
                        <span class="label">หมู่ที่</span>
                        <span class="value w-35">{{ optional($client->spouse)->moo ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <div class="sub-line same-start">
                <div class="line">
                    <div class="field">
                        <span class="label">ตำบล/แขวง</span>
                        <span class="value left w-100">{{ optional(optional($client->spouse)->sub_district)->subd_name ?? '-' }}</span>
                    </div>

                    <div class="field">
                        <span class="label">อำเภอ/เขต</span>
                        <span class="value left w-100">{{ optional(optional($client->spouse)->district)->dist_name ?? '-' }}</span>
                    </div>

                    <div class="field">
                        <span class="label">จังหวัด</span>
                        <span class="value left w-90">{{ optional(optional($client->spouse)->province)->prov_name ?? '-' }}</span>
                    </div>

                    <div class="field">
                        <span class="label">โทร.</span>
                        <span class="value left w-80">{{ optional($client->spouse)->phone ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- สภาพปัญหา --}}
    <div class="problem-title">สภาพปัญหา</div>
    <div class="problem-list">
        @if($client->problems->count() > 0)
            @foreach($client->problems as $problem)
                <div class="problem-item">
                    <span class="checkbox">☑</span>{{ $problem->name }}
                </div>
            @endforeach
        @else
            <div class="problem-item">- ไม่มีข้อมูลปัญหา -</div>
        @endif
    </div>

    {{-- สมาชิกครอบครัว --}}
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
                    <th style="width:12%;">รายได้/เดือน</th>
                    <th style="width:19%;">หมายเหตุ</th>
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
</div>

@endsection