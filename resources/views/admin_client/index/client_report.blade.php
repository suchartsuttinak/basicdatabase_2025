@extends('admin_client.admin_client')
@section('content')

    <style>
        /* Base Typography & Layout */
    body {
        font-size: 16px;
        line-height: 1.8;
        background-color: #fff;
        color: #333;
        font-family: "TH Sarabun New", "Tahoma", sans-serif; /* ฟอนต์ราชการ */
        margin: 0;
        padding: 0;
    }

    /* Container */
    .report-container {
        padding: 30px;
        position: relative;
        border: 1px solid #ddd;
        border-radius: 8px;
        background: #fff;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    }

    /* Titles */
    .report-title,
    .section-title,
    .family-title {
        font-weight: bold;
        color: #000;
        font-family: inherit; /* ใช้ฟอนต์จาก body */
    }

    .report-title {
        text-align: center;
        font-size: 26px;
        margin-bottom: 25px;
        padding-bottom: 10px;
        border-bottom: 2px solid #000;
    }

    .section-title {
        font-size: 18px;
        margin: 20px 0 10px;
        padding-bottom: 5px;
        border-bottom: 2px solid #666;
        color: #222;
    }

    .family-title {
        font-size: 16px;
        text-align: left;
        margin-bottom: 10px;
        border-bottom: 1px solid #000;
        padding-bottom: 5px;
    }

    /* Photo */
    .report-photo {
        position: absolute;
        top: 90px;
        right: 30px;
        width: 150px;
        height: 170px;
        object-fit: cover;
        border: 1px solid #000;
        border-radius: 4px;
    }

    /* Sections */
    .report-section {
        display: flex;
        flex-wrap: wrap;
        margin-bottom: 12px;
        padding: 8px 12px;
        background: #f9f9f9;
        border-radius: 4px;
    }

    .report-section .label {
        font-weight: bold;
        margin-right: 6px;
        color: #000;
    }

    .report-section .item {
        margin-right: 20px;
        display: flex;
        align-items: center;
    }

    /* Divider */
    .divider {
        border: 0;
        border-top: 2px solid #000;
        margin: 25px 0;
    }

    /* Family Card */
    /* Family Card */
   .family-card {
    margin-bottom: 20px;
    padding: 16px 20px;
    background: #fff;                  /* พื้นหลังสีขาว */
    border: 1px solid #ddd;            /* กรอบบาง ๆ */
    border-radius: 8px;                /* มุมโค้ง */
    box-shadow: 0 2px 6px rgba(0,0,0,0.08); /* เงาเหมือน report-container */
}



    /* Family Info */
    .family-info {
        font-size: 16px;                   /* ปรับให้มาตรฐาน ไม่ใช้ % */
        color: #000;
        line-height: 1.8;
    }

    .family-info .label {
        font-weight: bold;
        display: inline-block;
        width: 150px;
        color: #000;
        text-decoration: underline;
    }

    /* Family Title */
.family-title {
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 12px;
    color: #000;
    border-bottom: 1px solid #000;
    padding-bottom: 5px;
}


    </style>



<div class="report-container">
    <div class="report-title">ข้อมูลพื้นฐานผู้รับการสงเคราะห์</div>

    {{-- รูปภาพ --}}
    <img src="{{ !empty($client->image) 
        ? asset('upload/client_images/'.$client->image) 
        : asset('upload/no_image.jpg') }}" 
        alt="รูปถ่าย" class="report-photo">

    {{-- เลขทะเบียน / ชื่อเล่น --}}
    <div class="section-title">ข้อมูลทั่วไป</div>
    <div class="report-section">
        <div class="item"><span class="label">เลขทะเบียน:</span> {{ $client->register_number }}</div>
        <div class="item"><span class="label">ชื่อเล่น:</span> {{ $client->nick_name }}</div>
    </div>

    {{-- ชื่อ-นามสกุล / อายุ / เพศ --}}
    <div class="report-section">
        <div class="item"><span class="label">ชื่อ-นามสกุล:</span> {{ optional($client->title)->name }} {{ $client->full_name }}</div>
        <div class="item"><span class="label">อายุ:</span> {{ $client->age }} ปี</div>
        <div class="item"><span class="label">เพศ:</span> {{ $client->gender === 'male' ? 'ชาย' : 'หญิง' }}</div>
    </div>

    {{-- วันเกิด --}}
    <div class="report-section">
        <div class="item"><span class="label">วัน เดือน ปี เกิด:</span>
            {{ $client->birth_date ? date('d/m/Y', strtotime($client->birth_date)) : '-' }}
        </div>
    </div>

    {{-- เชื้อชาติ / ศาสนา / สถานภาพสมรส --}}
    <div class="report-section">
        <div class="item"><span class="label">เชื้อชาติ:</span> {{ optional($client->national)->national_name ?? '-' }}</div>
        <div class="item"><span class="label">ศาสนา:</span> {{ optional($client->religion)->religion_name ?? '-' }}</div>
        <div class="item"><span class="label">สถานภาพสมรส:</span> {{ optional($client->marital)->marital_name ?? '-' }}</div>
    </div>

    {{-- บัตรประชาชน / วันที่รับเข้า --}}
    <div class="report-section">
        <div class="item"><span class="label">เลขประจำตัวประชาชน:</span> {{ $client->id_card }}</div>
        <div class="item"><span class="label">วันที่รับเข้า:</span>
            {{ $client->arrival_date ? date('d/m/Y', strtotime($client->arrival_date)) : '-' }}
        </div>
    </div>

    {{-- กลุ่มเป้าหมาย --}}
    <div class="report-section">
        <div class="item"><span class="label">กลุ่มเป้าหมาย:</span> {{ optional($client->target)->target_name ?? '-' }}</div>
    </div>


             {{-- เส้นคั่น --}}
        <hr class="section-divider">
         {{-- ที่อยู่ปัจจุบัน --}}
    <div class="section-title">ที่อยู่ปัจจุบัน</div>
    <div class="report-section">
        <div class="item"><span class="label">ที่อยู่เลขที่:</span> {{ $client->address }}</div>
        <div class="item"><span class="label">หมู่ที่:</span> {{ $client->moo }}</div>
        <div class="item"><span class="label">ตรอก/ซอย:</span> {{ $client->soi }}</div>
        <div class="item"><span class="label">ถนน:</span> {{ $client->road }}</div>
        <div class="item"><span class="label">หมู่บ้าน:</span> {{ $client->village }}</div>
    </div>
    <div class="report-section">
        <div class="item"><span class="label">ตำบล:</span> {{ optional($client->sub_district)->subd_name ?? '-' }}</div>
        <div class="item"><span class="label">อำเภอ:</span> {{ optional($client->district)->dist_name ?? '-' }}</div>
        <div class="item"><span class="label">จังหวัด:</span> {{ optional($client->province)->prov_name ?? '-' }}</div>
    </div>
    <div class="report-section">
        <div class="item"><span class="label">รหัสไปรษณีย์:</span> {{ $client->zipcode }}</div>
        <div class="item"><span class="label">โทรศัพท์:</span> {{ $client->phone }}</div>
    </div>

    <hr class="divider">

    {{-- ภูมิลำเนาเดิม --}}
    <div class="section-title">ภูมิลำเนาเดิม</div>
    <div class="report-section">
        <div class="item"><span class="label">ที่อยู่เลขที่:</span> {{ $client->origin_address ?? '-' }}</div>
        <div class="item"><span class="label">หมู่ที่:</span> {{ $client->origin_moo ?? '-' }}</div>
        <div class="item"><span class="label">ตรอก/ซอย:</span> {{ $client->origin_soi ?? '-' }}</div>
        <div class="item"><span class="label">ถนน:</span> {{ $client->origin_road ?? '-' }}</div>
        <div class="item"><span class="label">หมู่บ้าน:</span> {{ $client->origin_village ?? '-' }}</div>
    </div>
    <div class="report-section">
        <div class="item"><span class="label">ตำบล:</span> {{ optional($client->originSubDistrict)->subd_name ?? '-' }}</div>
        <div class="item"><span class="label">อำเภอ:</span> {{ optional($client->originDistrict)->dist_name ?? '-' }}</div>
        <div class="item"><span class="label">จังหวัด:</span> {{ optional($client->originProvince)->prov_name ?? '-' }}</div>
    </div>
    <div class="report-section">
        <div class="item"><span class="label">รหัสไปรษณีย์:</span> {{ $client->origin_zipcode ?? '-' }}</div>
        <div class="item"><span class="label">โทรศัพท์:</span> {{ $client->origin_phone ?? '-' }}</div>
    </div>




                {{-- เส้นคั่น --}}
        <hr class="section-divider">

        <div class="section-title">ข้อมูลบิดา มารดา สามี/ภรรยา และญาติ</div>

        {{-- บิดา --}}
        @if($client->father)
        <div class="family-card">
            <h4 class="family-title">บิดา</h4>
            <table class="family-table">
                <tr>
                    <td class="label-cell">ชื่อ-นามสกุล</td>
                    <td>{{ $client->father->fname }} {{ $client->father->lname }}</td>
                </tr>
                <tr>
                    <td class="label-cell">เลขบัตรประชาชน</td>
                    <td>{{ $client->father->idcard }}</td>
                </tr>
                <tr>
                    <td class="label-cell">อายุ</td>
                    <td>{{ $client->father->age }} ปี</td>
                </tr>
                <tr>
                    <td class="label-cell">อาชีพ</td>
                    <td>{{ $client->father->occupation }}</td>
                </tr>
                <tr>
                    <td class="label-cell">รายได้</td>
                    <td>{{ $client->father->income }}</td>
                </tr>
                <tr>
                    <td class="label-cell">ที่อยู่</td>
                    <td>
                        {{ $client->father->address_no }} หมู่ {{ $client->father->moo }} ซอย {{ $client->father->soi }}
                        ถนน {{ $client->father->road }} หมู่บ้าน {{ $client->father->village }}
                        {{ optional($client->father->sub_district)->subd_name ?? '' }}
                        {{ optional($client->father->district)->dist_name ?? '' }}
                        {{ optional($client->father->province)->prov_name ?? '' }}
                    </td>
                </tr>
                <tr>
                    <td class="label-cell">รหัสไปรษณีย์</td>
                    <td>{{ $client->father->zipcode }}</td>
                </tr>
                <tr>
                    <td class="label-cell">โทรศัพท์</td>
                    <td>{{ $client->father->phone }}</td>
                </tr>
            </table>
        </div>
        @endif

            {{-- มารดา --}}
        @if($client->mother)
        <div class="family-card">
            <h4 class="family-title">มารดา</h4>
            <table class="family-table">
                <tr><td class="label-cell">ชื่อ-นามสกุล</td><td>{{ $client->mother->fname }} {{ $client->mother->lname }}</td></tr>
                <tr><td class="label-cell">เลขบัตรประชาชน</td><td>{{ $client->mother->idcard }}</td></tr>
                <tr><td class="label-cell">อายุ</td><td>{{ $client->mother->age }} ปี</td></tr>
                <tr><td class="label-cell">อาชีพ</td><td>{{ $client->mother->occupation }}</td></tr>
                <tr><td class="label-cell">รายได้</td><td>{{ $client->mother->income }}</td></tr>
                <tr><td class="label-cell">ที่อยู่</td>
                    <td>
                        {{ $client->mother->address_no }} หมู่ {{ $client->mother->moo }} ซอย {{ $client->mother->soi }}
                        ถนน {{ $client->mother->road }} หมู่บ้าน {{ $client->mother->village }}
                        {{ optional($client->mother->sub_district)->subd_name ?? '' }}
                        {{ optional($client->mother->district)->dist_name ?? '' }}
                        {{ optional($client->mother->province)->prov_name ?? '' }}
                    </td>
                </tr>
                <tr><td class="label-cell">รหัสไปรษณีย์</td><td>{{ $client->mother->zipcode }}</td></tr>
                <tr><td class="label-cell">โทรศัพท์</td><td>{{ $client->mother->phone }}</td></tr>
            </table>
        </div>
        @endif

                {{-- คู่สมรส --}}
        @if($client->spouse)
        <div class="family-card">
            <h4 class="family-title">สามี/ภรรยา</h4>
            <table class="family-table">
                <tr><td class="label-cell">ชื่อ-นามสกุล</td><td>{{ $client->spouse->fname }} {{ $client->spouse->lname }}</td></tr>
                <tr><td class="label-cell">เลขบัตรประชาชน</td><td>{{ $client->spouse->idcard }}</td></tr>
                <tr><td class="label-cell">อายุ</td><td>{{ $client->spouse->age }} ปี</td></tr>
                <tr><td class="label-cell">อาชีพ</td><td>{{ $client->spouse->occupation }}</td></tr>
                <tr><td class="label-cell">รายได้</td><td>{{ $client->spouse->income }}</td></tr>
                <tr><td class="label-cell">ที่อยู่</td>
                    <td>
                        {{ $client->spouse->address_no }} หมู่ {{ $client->spouse->moo }} ซอย {{ $client->spouse->soi }}
                        ถนน {{ $client->spouse->road }} หมู่บ้าน {{ $client->spouse->village }}
                        {{ optional($client->spouse->sub_district)->subd_name ?? '' }}
                        {{ optional($client->spouse->district)->dist_name ?? '' }}
                        {{ optional($client->spouse->province)->prov_name ?? '' }}
                    </td>
                </tr>
                <tr><td class="label-cell">รหัสไปรษณีย์</td><td>{{ $client->spouse->zipcode }}</td></tr>
                <tr><td class="label-cell">โทรศัพท์</td><td>{{ $client->spouse->phone }}</td></tr>
            </table>
        </div>
        @endif

            {{-- ญาติ --}}
        @if($client->relative)
        <div class="family-card">
            <h4 class="family-title">ญาติ</h4>
            <table class="family-table">
                <tr><td class="label-cell">ชื่อ-นามสกุล</td><td>{{ $client->relative->fname }} {{ $client->relative->lname }}</td></tr>
                <tr><td class="label-cell">เลขบัตรประชาชน</td><td>{{ $client->relative->idcard }}</td></tr>
                <tr><td class="label-cell">อายุ</td><td>{{ $client->relative->age }} ปี</td></tr>
                <tr><td class="label-cell">อาชีพ</td><td>{{ $client->relative->occupation }}</td></tr>
                <tr><td class="label-cell">รายได้</td><td>{{ $client->relative->income }}</td></tr>
                <tr><td class="label-cell">ที่อยู่</td>
                    <td>
                        {{ $client->relative->address_no }} หมู่ {{ $client->relative->moo }} ซอย {{ $client->relative->soi }}
                        ถนน {{ $client->relative->road }} หมู่บ้าน {{ $client->relative->village }}
                        {{ optional($client->relative->sub_district)->subd_name ?? '' }}
                        {{ optional($client->relative->district)->dist_name ?? '' }}
                        {{ optional($client->relative->province)->prov_name ?? '' }}
                    </td>
                </tr>
                <tr><td class="label-cell">รหัสไปรษณีย์</td><td>{{ $client->relative->zipcode }}</td></tr>
                <tr><td class="label-cell">โทรศัพท์</td><td>{{ $client->relative->phone }}</td></tr>
            </table>
        </div>
        @endif

        {{-- เส้นคั่น --}}
        <hr class="section-divider">
        {{-- ข้อมูลครอบครัว --}}
        <div class="report-section">
            <div class="item"><span class="label">สมาชิกภายในครอบครัว:</span></div>
        </div>

        @if($client->members->count() > 0)
            <table class="family-table" border="1" cellspacing="0" cellpadding="5" width="100%">
                <thead>
                    <tr>
                        <th>ชื่อ-นามสกุล</th>
                        <th>ความสัมพันธ์</th>
                        <th>อายุ</th>
                        <th>การศึกษา</th>
                        <th>อาชีพ</th>
                        <th>รายได้</th>
                        <th>หมายเหตุ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($client->members as $member)
                        <tr>
                            <td>{{ $member->fullname }}</td>
                            <td>{{ $member->relationship }}</td>
                            <td>{{ $member->member_age }} ปี</td>
                            <td>{{ optional($member->education)->education_name ?? '-' }}</td>
                            <td>{{ optional($member->occupation)->occupation_name ?? '-' }}</td>
                            <td>{{ optional($member->income)->income_name ?? '-' }} บาท/เดือน</td>
                            <td>{{ $member->remark ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="family-item">- ไม่มีข้อมูลสมาชิกครอบครัว -</div>
        @endif

        {{-- เส้นคั่น --}}
        <hr class="section-divider">
        {{-- การศึกษา --}}
        <div class="report-section">
            <div class="item"><span class="label">ระดับการศึกษา:</span> {{ optional($client->education)->education_name ?? '-' }}</div>
            <div class="item"><span class="label">สถานศึกษา:</span> {{ $client->scholl }}</div>
        </div>


        {{-- อาชีพ / รายได้ --}}
        <div class="report-section">
            <div class="item"><span class="label">อาชีพ:</span> {{ optional($client->occupation)->occupation_name ?? '-' }}</div>
            <div class="item"><span class="label">รายได้เฉลี่ย:</span> {{ optional($client->income)->income_name ?? '-' }} บาท/เดือน</div>
        </div>

        {{-- สถานะ --}}
        <div class="report-section">
            <div class="item"><span class="label">สถานะ:</span> {{ optional($client->status)->status_name ?? '-' }}</div>
        </div>

        {{-- โครงการ / ผู้ติดต่อ / บ้าน --}}
        <div class="report-section">
            <div class="item"><span class="label">โครงการ:</span> {{ optional($client->project)->project_name ?? '-' }}</div>
            <div class="item"><span class="label">ผู้ติดต่อ/นำส่ง:</span> {{ optional($client->contact)->contact_name ?? '-' }}</div>
            <div class="item"><span class="label">บ้านพัก:</span> {{ optional($client->house)->house_name ?? '-' }}</div>
        </div>

        {{-- เส้นคั่น --}}
        <hr class="section-divider">
        {{-- ปัญหา --}}
        {{-- <div class="report-section">
            <span class="label">ปัญหา:</span>
        </div>
        <div class="problem-list">
            @php
                $allProblems = [
                    'เร่ร่อน','ถูกทอดทิ้ง','ถูกเลี้ยงดูไม่เหมาะสม','ถูกทารุณกรรม','ถูกกระทำความรุนแรงในครอบครัว',
                    'ถูกแสวงหาประโยชน์','เหยื่อค้ามนุษย์','กำพร้าบิดา','กำพร้ามารดา','กำพร้าบิดามารดา','ปัญหาความประพฤติ',
                    'ครอบครัวแตกแยก','บิดาหรือมารดาถูกต้องโทษ','ถูกล่อลวง','ถูกกระทำทารุณกรรมทางเพศ',
                    'อยู่ในสภาวะยากลำบาก','ไม่มีสถานะทางทะเบียนราษฎร',
                ];
                $selected = $client->problems->pluck('name')->toArray();
            @endphp

            @foreach($allProblems as $problem)
                <div class="problem-item">
                    <span class="checkbox">
                        {{ in_array($problem, $selected) ? '☑' : '☐' }}
                    </span>
                    <span>{{ $problem }}</span>
                </div>
            @endforeach
        </div> --}}
        
            {{-- ปัญหา --}}
            <div class="report-section">
                    <span class="label">ปัญหา:</span>
                </div>
                    <div class="problem-list">
                        @if($client->problems->count() > 0)
                            @foreach($client->problems as $problem)
                                <div class="problem-item">
                                    <span class="checkbox">☑</span>
                                    <span>{{ $problem->name }}</span>
                                </div>
                            @endforeach
                        @else
                            <div class="problem-item">- ไม่มีข้อมูลปัญหา -</div>
                        @endif
                    </div>
            </div>

        @endsection