@extends('admin_client.admin_client')
@section('content')

 <style>
    body {
        font-family: 'TH Sarabun New', sans-serif;
        font-size: 18px;
        line-height: 1.8;
        background-color: #fff;
        color: #333;
    }

    .report-container {
        padding: 30px;
        position: relative;
        border: 1px solid #ddd;
        border-radius: 8px;
        background: #fff;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    }

    .report-title {
        text-align: center;
        font-size: 26px;
        font-weight: bold;
        margin-bottom: 25px;
        padding-bottom: 10px;
        border-bottom: 2px solid #ccc;
        color: #222;
    }

    .report-photo {
        position: absolute;
        top: 90px;
        right: 30px;
        width: 150px;
        height: 170px;
        object-fit: cover;
        border: 1px solid #ccc;
        border-radius: 6px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

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
        color: #444;
    }

    .report-section .item {
        margin-right: 20px;
        display: flex;
        align-items: center;
    }

    .problem-list {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 10px 16px;
        margin-top: 10px;
        margin-bottom: 20px;
    }

    .problem-item {
        display: flex;
        align-items: center;
        font-size: 18px;
        background: #f9f9f9;
        padding: 6px 10px;
        border-radius: 4px;
    }

    .problem-item .checkbox {
        font-size: 20px;
        margin-right: 8px;
        color: #555;
    }
</style>

        <div class="report-container">
            <div class="report-title">ข้อมูลพื้นผู้รับการสงเคราะห์</div>

            {{-- รูปภาพ --}}
                <div class="report-section">
            <img src="{{ !empty($client->image) 
                ? asset('upload/client_images/'.$client->image) 
                : asset('upload/no_image.jpg') }}" 
                alt="logo" class="report-photo">
                </div>
     
            {{-- เลขทะเบียน / ชื่อเล่น --}}
            <div class="report-section">
                <div class="item"><span class="label">เลขทะเบียน:</span> {{ $client->register_number }}</div>
            </div>

            {{-- ชื่อเล่น --}}
            <div class="report-section"> 
                <div class="item"><span class="label">ชื่อเล่น:</span> {{ $client->nick_name }}</div>
            </div>

            {{-- ชื่อ-นามสกุล / อายุ / เพศ --}}
            <div class="report-section">
                <div class="item"><span class="label">ชื่อ-นามสกุล:</span> {{ optional($client->title)->name }} {{ $client->full_name }} </div>
                <div class="item"><span class="label">อายุ:</span> {{ $client->age }} ปี</div>
                {{-- <div class="item"><span class="label">เพศ:</span> {{ $recipients->gender == 'male' ? 'ชาย' : 'หญิง' }}</div> --}}
            </div>

            {{-- วันเกิด  --}}
          <div class="report-section">
                <div class="item">
                    <span class="label">วัน เดือน ปี เกิด:</span>
                    {{ $client->birth_date ? date('d/m/Y', strtotime($client->birth_date)) : '-' }}
                </div>
            </div>

            {{-- เชื้อชาติ / ศาสนา / สถานภาพสมรส --}}
            <div class="report-section">
                <div class="item"><span class="label">เชื้อชาติ:</span> {{ optional($client->national)->national_name ?? '-' }}</div>
                <div class="item"><span class="label">ศาสนา:</span> {{ optional($client->religion)->religion_name ?? '-' }}</div>
                <div class="item"><span class="label">สถานภาพสมรส:</span> {{ optional($client->marital)->marital_name ?? '-' }}</div>
            </div>

            {{-- บัตรประชาชน / วันที่รับเข้า  --}}
           <div class="report-section">
                    <div class="item">
                        <span class="label">เลขประจำตัวประชาชน:</span> {{ $client->id_card }}
                    </div>
                    <div class="item">
                        <span class="label">วันที่รับเข้า:</span>
                        {{ $client->arrival_date ? date('d/m/Y', strtotime($client->arrival_date)) : '-' }}
                    </div>
                </div>

            {{-- กลุ่มเป้าหมาย --}}
            <div class="report-section">
                <div class="item"><span class="label">กลุ่มเป้าหมาย:</span> {{ optional($client->target)->target_name ?? '-' }}</div>
            </div>

            {{-- ที่อยู่ หมู่ที่ ตรอก/ซอย ถนน หมู่บ้าน --}}
            <div class="report-section">
                <div class="item"><span class="label">ที่อยู่เลขที่:</span> {{ $client->address }}</div>
                <div class="item"><span class="label">หมู่ที่:</span> {{ $client->moo }}</div>
                <div class="item"><span class="label">ตรอก/ซอย:</span> {{ $client->soi }}</div>
                <div class="item"><span class="label">ถนน:</span> {{ $client->road }}</div>
                <div class="item"><span class="label">หมู่บ้าน:</span> {{ $client->village }}</div>
            </div>

            {{-- จังหวัด อําเภอ ตําบล --}}
            <div class="report-section">
                <div class="item"><span class="label">ตำบล:</span> {{ optional($client->sub_district)->subd_name ?? '-' }}</div>
                <div class="item"><span class="label">อำเภอ:</span> {{ optional($client->district)->dist_name ?? '-' }}</div>
                <div class="item"><span class="label">จังหวัด:</span> {{ optional($client->province)->prov_name ?? '-' }}</div>
            </div>

            {{-- รหัสไปรษณีย์ โทรศัพท์ --}}
            <div class="report-section">
                <div class="item"><span class="label">รหัสไปรษณีย์:</span> {{ $client->zipcode }}</div>
                <div class="item"><span class="label">โทรศัพท์:</span> {{ $client->phone }}</div>
            </div>

            {{-- การศึกษา --}}
            <div class="report-section">
                <div class="item"><span class="label">ระดับการศึกษา:</span> {{ optional($client->education)->education_name ?? '-' }}</div>
                <div class="item"><span class="label">สถานศึกษา:</span> {{ $client->scholl }}</div>
            </div>

            {{-- อาชีพ / รายได้  --}}
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

            {{-- ปัญหา --}}
            <div class="report-section">
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
            </div>

        </div>

@endsection