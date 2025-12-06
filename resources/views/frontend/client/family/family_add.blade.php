@extends('admin.admin_master')
@section('admin')

<style>
    /* ปรับ input และ select ให้มีพื้นหลังสีเทาอ่อน และตัวอักษรสีดำ */
    .form-control, .form-select {
      background-color: #f8f9fa; /* เทาอ่อน */
      border: 1px solid #ddd;    /* ขอบสีเทาอ่อน */
      color: #000000;            /* ตัวอักษรสีดำสนิท */
    }
    .form-control:focus, .form-select:focus {
      background-color: #f1f3f4; /* เทาอ่อนขึ้นเมื่อ focus */
      border-color: #bbb;        /* ขอบเข้มขึ้นเล็กน้อย */
      color: #000000;            /* ยังคงตัวอักษรสีดำ */
      box-shadow: none;          /* ตัดเงา default ของ Bootstrap */
    }
    /* ปรับ placeholder ให้เป็นสีเทาอ่อนกว่าตัวอักษรจริง */
    ::placeholder {
      color: #6c757d; /* เทาอ่อน */
      opacity: 1;
    }

/* ปรับ Tab */
    .custom-tabs .nav-link {
    border-radius: 6px 6px 0 0;
    margin-right: 5px;
    background-color: #f8f9fa;
    color: #0d6efd; /* สีน้ำเงิน */
    font-weight: 500;
    transition: all 0.3s ease;
}

.custom-tabs .nav-link:hover {
    background-color: #e9ecef;
    color: #0b5ed7; /* น้ำเงินเข้มขึ้นตอน hover */
}

.custom-tabs .nav-link.active {
    background-color: #0d6efd; /* น้ำเงินหลัก */
    color: #fff;              /* ตัวอักษรสีขาว */
    font-weight: bold;
}
/* สิ้นสุด ปรับ Tab */

  </style>

<div class="container-fluid py-4">
    <form action="{{ route('family.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

          <!-- ส่ง id ไปด้วย -->
            <input type="hidden" name="client_id" value="{{$client->id}}">

        <!-- Tabs ด้านบน -->
        <ul class="nav nav-tabs custom-tabs mb-3" id="familyTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="father-tab" data-bs-toggle="tab" data-bs-target="#father" type="button" role="tab">บิดา</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="mother-tab" data-bs-toggle="tab" data-bs-target="#mother" type="button" role="tab">มารดา</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="spouse-tab" data-bs-toggle="tab" data-bs-target="#spouse" type="button" role="tab">สามี/ภรรยา</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="relative-tab" data-bs-toggle="tab" data-bs-target="#relative" type="button" role="tab">ญาติ</button>
            </li>
        </ul>

        <!-- เนื้อหาแต่ละ Tab -->
        <div class="tab-content" id="familyTabsContent">
            <!-- บิดา -->
            <div class="tab-pane fade show active" id="father" role="tabpanel">
                <div class="row">
                    <!-- Card ซ้าย -->
                    <div class="col-lg-6 mb-4">
                        <div class="card border shadow-sm">
                            <div class="card-header"><h5 class="mb-0">ข้อมูลส่วนตัวบิดา</h5></div>
                            <div class="card-body">

                        <!-- ชื่อบิดา -->
                    <div class="col-md-12 mb-3">
                            <label for="father_fname" class="form-label">ชื่อบิดา</label>
                            <input type="text" 
                                name="father[fname]" 
                                id="father_fname"
                                class="form-control @error('father.fname') is-invalid @enderror"
                                value="{{ old('father.fname', $father->fname ?? '') }}">
                            @error('father.fname')
                                <small class="text-danger error-message">{{ $message }}</small>
                            @enderror
                        </div>
                        <!-- นามสกุล -->
                        <div class="col-md-12 mb-3">
                                <label for="lname" class="form-label">นามสกุล</label>
                                <input type="text" name="father[lname]" id="lname"
                                    class="form-control @error('lname') is-invalid @enderror"
                                    value="{{ old('father.lname', $father->lname ?? '') }}">
                                @error('lname')
                                    <small class="text-danger error-message" id="error-lname">{{ $message }}</small>
                                @enderror
                        </div>
                                <!-- เลขประจําตัว -->
                       <div class="col-md-12 mb-3">
                            <label for="father_idcard" class="form-label">เลขประจำตัวประชาชน</label>
                            <input type="text" 
                                name="father[idcard]" 
                                id="father_idcard"
                                class="form-control @error('father.idcard') is-invalid @enderror"
                                value="{{ old('father.idcard', $father->idcard ?? '') }}">
                            @error('father.idcard')
                                <div class="invalid-feedback" id="error-father-idcard">{{ $message }}</div>
                            @enderror
                        </div>
                             <!-- อายุ -->
                         <div class="col-md-4 mb-3">
                    <label for="age" class="form-label">อายุ</label>
                    <div class="input-group">
                        <input type="number" name="father[age]" id="age"
                            class="form-control @error('age') is-invalid @enderror"
                            value="{{ old('father.age', $father->age ?? '') }}" min="0">
                        <span class="input-group-text">ปี</span>
                            </div>
                            @error('age')
                                <div class="text-danger small mt-1" id="error-age">{{ $message }}</div>
                            @enderror
                        </div>
                             <!-- อาชีพ -->
                <div class="col-md-12 mb-3">
                    <label for="occupation" class="form-label">อาชีพ</label>
                    <input type="text" name="father[occupation]" id="occupation"
                        class="form-control @error('occupation') is-invalid @enderror"
                        value="{{ old('father.occupation', $father->occupation ?? '') }}">
                    @error('occupation')
                        <small class="text-danger error-message" id="error-occupation">{{ $message }}</small>
                    @enderror
                </div>
                    <!-- รายได้ -->
                 <div class="col-md-12 mb-3">
                    <label for="income" class="form-label">รายได้</label>
                    <input type="text" name="father[income]" id="income"
                        class="form-control @error('income') is-invalid @enderror"
                        value="{{ old('father.income', $father->income ?? '') }}">
                    @error('income')
                        <small class="text-danger error-message" id="error-income">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <!-- Card ขวา -->
    <div class="col-lg-6 mb-4">
        <div class="card border shadow-sm">
            <div class="card-header"><h5 class="mb-0">ข้อมูลการติดต่อบิดา</h5></div>

            <div class="card-body">
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label for="address" class="form-label">ที่อยู่เลขที่</label>
                    <input type="text" name="father[address_no]" id="address_no"
                        class="form-control" value="{{ old('father.address_no', $father->address_no ?? '') }}">
                    @error('address_no')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="moo" class="form-label">หมู่ที่</label>
                    <input type="text" name="father[moo]" id="moo"
                        class="form-control" value="{{ old('father.moo', $father->moo ?? '') }}">
                    @error('moo')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="soi" class="form-label">ตรอก/ซอย</label>
                    <input type="text" name="father[soi]" id="soi"
                        class="form-control" value="{{ old('father.soi', $father->soi ?? '') }}">
                    @error('soi')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="road" class="form-label">ถนน</label>
                    <input type="text" name="father[road]" id="road"
                        class="form-control" value="{{ old('father.road', $father->road ?? '') }}">
                    @error('road')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="village" class="form-label">หมู่บ้าน</label>
                <input type="text" name="father[village]" id="village"
                    class="form-control" value="{{ old('father.village', $father->village ?? '') }}">
                @error('village')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="father_province" class="form-label">จังหวัด</label>
                            <select name="father[province_id]" id="father_province" class="form-select"
                                    data-selected="{{ old('father.province_id', $father->province_id ?? '') }}">
                                <option value="">--เลือกจังหวัด--</option>
                                @foreach($provinces as $province)
                                    <option value="{{ $province->id }}"
                                        {{ old('father.province_id', $father->province_id ?? '') == $province->id ? 'selected' : '' }}>
                                        {{ $province->prov_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="father_district" class="form-label">เขต/อำเภอ</label>
                            <select name="father[district_id]" id="father_district" class="form-select"
                                    data-selected="{{ old('father.district_id', $father->district_id ?? '') }}">
                                <option value="">--เลือกอำเภอ--</option>
                                @foreach($districts as $district)
                                    <option value="{{ $district->id }}"
                                        {{ old('father.district_id', $father->district_id ?? '') == $district->id ? 'selected' : '' }}>
                                        {{ $district->dist_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                     <div class="mb-3">
                            <label for="subdistrict" class="form-label">แขวง/ตำบล</label>
                            <select name="father[sub_district_id]" id="father_subdistrict" class="form-select"
                                    data-selected="{{ old('father.sub_district_id', $father->sub_district_id ?? '') }}">
                                <option value="">-- เลือกตำบล --</option>
                                @foreach($sub_districts as $subdistrict)
                                    <option value="{{ $subdistrict->id }}"
                                        {{ old('father.sub_district_id', $father->sub_district_id ?? '') == $subdistrict->id ? 'selected' : '' }}>
                                        {{ $subdistrict->subd_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('father.sub_district_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                    </div>


                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="father_zipcode" class="form-label">รหัสไปรษณีย์</label>
                            <input type="text" name="father[zipcode]" id="father_zipcode"
                                class="form-control" value="{{ old('father.zipcode', $father->zipcode ?? '') }}">
                            @error('zipcode')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-8 mb-3">
                            <label for="phone" class="form-label">โทรศัพท์</label>
                            <input type="text" name="father[phone]" id="phone"
                                class="form-control" value="{{ old('father.phone', $father->phone ?? '') }}">
                            @error('phone')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- มารดา -->

            <div class="tab-pane fade" id="mother" role="tabpanel">
                <div class="row">
                    <!-- Card ซ้าย -->
                    <div class="col-lg-6 mb-4">
                        <div class="card border shadow-sm">
                            <div class="card-header"><h5 class="mb-0">ข้อมูลส่วนตัวมารดา</h5></div>
                            <div class="card-body">
                               <!-- ชื่อบิดา -->
                        <div class="col-md-12 mb-3">
                            <label for="fname" class="form-label">ชื่อ</label>
                            <input type="text" name="mother[fname]" id="fname"
                                class="form-control @error('fname') is-invalid @enderror"
                                value="{{ old('mother.fname', $mother->fname ?? '') }}">
                            @error('fname')
                                <small class="text-danger error-message" id="error-fname">{{ $message }}</small>
                            @enderror
                        </div>
                        <!-- นามสกุล -->
                        <div class="col-md-12 mb-3">
                                <label for="lname" class="form-label">นามสกุล</label>
                                <input type="text" name="mother[lname]" id="lname"
                                    class="form-control @error('lname') is-invalid @enderror"
                                    value="{{ old('mother.lname', $mother->lname ?? '') }}">
                                @error('lname')
                                    <small class="text-danger error-message" id="error-lname">{{ $message }}</small>
                                @enderror
                        </div>
                                <!-- เลขประจําตัว -->
                        <div class="col-md-12 mb-3">
                            <label for="idcard" class="form-label">เลขประจำตัวประชาชน</label>
                            <input type="text" name="mother[idcard]" id="idcard"
                                class="form-control @error('idcard') is-invalid @enderror"
                                value="{{ old('mother.idcard', $mother->idcard ?? '') }}">
                            @error('idcard')
                                <div class="invalid-feedback" id="error-idcard">{{ $message }}</div>
                            @enderror
                        </div>
                             <!-- อายุ -->
                         <div class="col-md-4 mb-3">
                    <label for="age" class="form-label">อายุ</label>
                    <div class="input-group">
                        <input type="number" name="mother[age]" id="age"
                            class="form-control @error('age') is-invalid @enderror"
                            value="{{ old('mother.age', $mother->age ?? '') }}" min="0">
                        <span class="input-group-text">ปี</span>
                            </div>
                            @error('age')
                                <div class="text-danger small mt-1" id="error-age">{{ $message }}</div>
                            @enderror
                        </div>
                             <!-- อาชีพ -->
                <div class="col-md-12 mb-3">
                    <label for="occupation" class="form-label">อาชีพ</label>
                    <input type="text" name="mother[occupation]" id="occupation"
                        class="form-control @error('occupation') is-invalid @enderror"
                        value="{{ old('mother.occupation', $mother->occupation ?? '') }}">
                    @error('occupation')
                        <small class="text-danger error-message" id="error-occupation">{{ $message }}</small>
                    @enderror
                </div>
                    <!-- รายได้ -->
                 <div class="col-md-12 mb-3">
                    <label for="income" class="form-label">รายได้</label>
                    <input type="text" name="mother[income]" id="income"
                        class="form-control @error('income') is-invalid @enderror"
                        value="{{ old('mother.income', $mother->income ?? '') }}">
                    @error('income')
                        <small class="text-danger error-message" id="error-income">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <!-- Card ขวา -->
    <div class="col-lg-6 mb-4">
        <div class="card border shadow-sm">
            <div class="card-header"><h5 class="mb-0">ข้อมูลการติดต่อบิดา</h5></div>

            <div class="card-body">
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label for="address" class="form-label">ที่อยู่เลขที่</label>
                    <input type="text" name="mother[address_no]" id="address_no"
                        class="form-control" value="{{ old('mother.address_no', $mother->address_no ?? '') }}">
                    @error('address_no')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="moo" class="form-label">หมู่ที่</label>
                    <input type="text" name="mother[moo]" id="moo"
                        class="form-control" value="{{ old('mother.moo', $mother->moo ?? '') }}">
                    @error('moo')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="soi" class="form-label">ตรอก/ซอย</label>
                    <input type="text" name="mother[soi]" id="soi"
                        class="form-control" value="{{ old('mother.soi', $mother->soi ?? '') }}">
                    @error('soi')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="road" class="form-label">ถนน</label>
                    <input type="text" name="mother[road]" id="road"
                        class="form-control" value="{{ old('mother.road', $mother->road ?? '') }}">
                    @error('road')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="village" class="form-label">หมู่บ้าน</label>
                <input type="text" name="mother[village]" id="village"
                    class="form-control" value="{{ old('mother.village', $mother->village ?? '') }}">
                @error('village')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                            <label for="mother_province" class="form-label">จังหวัด</label>
                            <select name="mother[province_id]" id="mother_province" class="form-select"
                                    data-selected="{{ old('mother.province_id', $mother->province_id ?? '') }}">
                                <option value="">--เลือกจังหวัด--</option>
                                @foreach($provinces as $province)
                                    <option value="{{ $province->id }}"
                                        {{ old('mother.province_id', $mother->province_id ?? '') == $province->id ? 'selected' : '' }}>
                                        {{ $province->prov_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    <div class="col-md-6 mb-3">
                        <label for="mother_district" class="form-label">เขต/อำเภอ</label>
                        <select name="mother[district_id]" id="mother_district" class="form-select"
                                data-selected="{{ old('mother.district_id', $mother->district_id ?? '') }}">
                            <option value="">--เลือกอำเภอ--</option>
                            @foreach($districts as $district)
                                <option value="{{ $district->id }}"
                                    {{ old('mother.district_id', $mother->district_id ?? '') == $district->id ? 'selected' : '' }}>
                                    {{ $district->dist_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
            </div>

            <div class="mb-3">
                <label for="subdistrict" class="form-label">แขวง/ตำบล</label>
               <select name="mother[sub_district_id]" id="mother_subdistrict" class="form-select"
                        data-selected="{{ old('mother.sub_district_id', $mother->sub_district_id ?? '') }}">
                    <option value="">-- เลือกตำบล --</option>
                    @foreach($sub_districts as $subdistrict)
                        <option value="{{ $subdistrict->id }}"
                            {{ old('mother.sub_district_id', $mother->sub_district_id ?? '') == $subdistrict->id ? 'selected' : '' }}>
                            {{ $subdistrict->subd_name }}
                        </option>
                    @endforeach
                </select>
                @error('mother.sub_district_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="zipcode" class="form-label">รหัสไปรษณีย์</label>
                            <input type="text" name="mother[zipcode]" id="mother_zipcode"
                                class="form-control" value="{{ old('mother.zipcode', $mother->zipcode ?? '') }}">
                            @error('zipcode')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-8 mb-3">
                            <label for="phone" class="form-label">โทรศัพท์</label>
                            <input type="text" name="mother[phone]" id="phone"
                                class="form-control" value="{{ old('mother.phone', $mother->phone ?? '') }}">
                            @error('phone')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


            <!-- สามี/ภรรยา -->
            <div class="tab-pane fade" id="spouse" role="tabpanel">
               <div class="row">
                    <!-- Card ซ้าย -->
                    <div class="col-lg-6 mb-4">
                        <div class="card border shadow-sm">
                            <div class="card-header"><h5 class="mb-0">ข้อมูลส่วนตัวมารดา</h5></div>
                            <div class="card-body">
                               <!-- ชื่อบิดา -->
                        <div class="col-md-12 mb-3">
                            <label for="fname" class="form-label">ชื่อ</label>
                            <input type="text" name="spouse[fname]" id="fname"
                                class="form-control @error('fname') is-invalid @enderror"
                                value="{{ old('spouse.fname', $spouse->fname ?? '') }}">
                            @error('fname')
                                <small class="text-danger error-message" id="error-fname">{{ $message }}</small>
                            @enderror
                        </div>
                        <!-- นามสกุล -->
                        <div class="col-md-12 mb-3">
                                <label for="lname" class="form-label">นามสกุล</label>
                                <input type="text" name="spouse[lname]" id="lname"
                                    class="form-control @error('lname') is-invalid @enderror"
                                    value="{{ old('spouse.lname', $spouse->lname ?? '') }}">
                                @error('lname')
                                    <small class="text-danger error-message" id="error-lname">{{ $message }}</small>
                                @enderror
                        </div>
                                <!-- เลขประจําตัว -->
                        <div class="col-md-12 mb-3">
                            <label for="idcard" class="form-label">เลขประจำตัวประชาชน</label>
                            <input type="text" name="spouse[idcard]" id="idcard"
                                class="form-control @error('idcard') is-invalid @enderror"
                                value="{{ old('spouse.idcard', $spouse->idcard ?? '') }}">
                            @error('idcard')
                                <div class="invalid-feedback" id="error-idcard">{{ $message }}</div>
                            @enderror
                        </div>
                             <!-- อายุ -->
                         <div class="col-md-4 mb-3">
                    <label for="age" class="form-label">อายุ</label>
                    <div class="input-group">
                        <input type="number" name="spouse[age]" id="age"
                            class="form-control @error('age') is-invalid @enderror"
                            value="{{ old('spouse.age', $spouse->age ?? '') }}" min="0">
                        <span class="input-group-text">ปี</span>
                            </div>
                            @error('age')
                                <div class="text-danger small mt-1" id="error-age">{{ $message }}</div>
                            @enderror
                        </div>
                             <!-- อาชีพ -->
                <div class="col-md-12 mb-3">
                    <label for="occupation" class="form-label">อาชีพ</label>
                    <input type="text" name="spouse[occupation]" id="occupation"
                        class="form-control @error('occupation') is-invalid @enderror"
                        value="{{ old('spouse.occupation', $spouse->occupation ?? '') }}">
                    @error('occupation')
                        <small class="text-danger error-message" id="error-occupation">{{ $message }}</small>
                    @enderror
                </div>
                    <!-- รายได้ -->
                 <div class="col-md-12 mb-3">
                    <label for="income" class="form-label">รายได้</label>
                    <input type="text" name="spouse[income]" id="income"
                        class="form-control @error('income') is-invalid @enderror"
                        value="{{ old('spouse.income', $spouse->income ?? '') }}">
                    @error('income')
                        <small class="text-danger error-message" id="error-income">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <!-- Card ขวา -->
    <div class="col-lg-6 mb-4">
        <div class="card border shadow-sm">
            <div class="card-header"><h5 class="mb-0">ข้อมูลการติดต่อบิดา</h5></div>

            <div class="card-body">
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label for="address" class="form-label">ที่อยู่เลขที่</label>
                    <input type="text" name="spouse[address_no]" id="address_no"
                        class="form-control" value="{{ old('spouse.address_no', $spouse->address_no ?? '') }}">
                    @error('address_no')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="moo" class="form-label">หมู่ที่</label>
                    <input type="text" name="spouse[moo]" id="moo"
                        class="form-control" value="{{ old('spouse.moo', $spouse->moo ?? '') }}">
                    @error('moo')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="soi" class="form-label">ตรอก/ซอย</label>
                    <input type="text" name="spouse[soi]" id="soi"
                        class="form-control" value="{{ old('spouse.soi', $spouse->soi ?? '') }}">
                    @error('soi')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="road" class="form-label">ถนน</label>
                    <input type="text" name="spouse[road]" id="road"
                        class="form-control" value="{{ old('spouse.road', $spouse->road ?? '') }}">
                    @error('road')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="village" class="form-label">หมู่บ้าน</label>
                <input type="text" name="spouse[village]" id="village"
                    class="form-control" value="{{ old('spouse.village', $spouse->village ?? '') }}">
                @error('village')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="province" class="form-label">จังหวัด</label>
                    <select name="spouse[province_id]" id="spouse_province" class="form-select"
                            data-selected="{{ old('spouse.province_id', $spouse->province_id ?? '') }}">
                        <option value="">--เลือกจังหวัด--</option>
                        @foreach($provinces as $province)
                            <option value="{{ $province->id }}"
                                {{ old('spouse.province_id', $spouse->province_id ?? '') == $province->id ? 'selected' : '' }}>
                                {{ $province->prov_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="district" class="form-label">เขต/อำเภอ</label>
                    <select name="spouse[district_id]" id="spouse_district" class="form-select"
                            data-selected="{{ old('spouse.district_id', $spouse->district_id ?? '') }}">
                        <option value="">--เลือกอำเภอ--</option>
                        @foreach($districts as $district)
                            <option value="{{ $district->id }}"
                                {{ old('spouse.district_id', $spouse->district_id ?? '') == $district->id ? 'selected' : '' }}>
                                {{ $district->dist_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label for="subdistrict" class="form-label">แขวง/ตำบล</label>
                <select name="spouse[sub_district_id]" id="spouse_subdistrict" class="form-select"
                        data-selected="{{ old('spouse.sub_district_id', $spouse->sub_district_id ?? '') }}">
                    <option value="">-- เลือกตำบล --</option>
                    @foreach($sub_districts as $subdistrict)
                        <option value="{{ $subdistrict->id }}"
                            {{ old('spouse.sub_district_id', $recipient->sub_district_id ?? '') == $subdistrict->id ? 'selected' : '' }}>
                            {{ $subdistrict->subdist_name }}
                        </option>
                    @endforeach
                </select>
                @error('sub_district_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="zipcode" class="form-label">รหัสไปรษณีย์</label>
                            <input type="text" name="spouse[zipcode]" id="spouse_zipcode"
                                class="form-control" value="{{ old('spouse.zipcode', $spouse->zipcode ?? '') }}">
                            @error('zipcode')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-8 mb-3">
                            <label for="phone" class="form-label">โทรศัพท์</label>
                            <input type="text" name="spouse[phone]" id="phone"
                                class="form-control" value="{{ old('spouse.phone', $spouse->phone ?? '') }}">
                            @error('phone')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

            <!-- ญาติ -->
            <div class="tab-pane fade" id="relative" role="tabpanel">
               <div class="row">
                    <!-- Card ซ้าย -->
                    <div class="col-lg-6 mb-4">
                        <div class="card border shadow-sm">
                            <div class="card-header"><h5 class="mb-0">ข้อมูลส่วนตัวมารดา</h5></div>
                            <div class="card-body">
                               <!-- ชื่อบิดา -->
                        <div class="col-md-12 mb-3">
                            <label for="fname" class="form-label">ชื่อ</label>
                            <input type="text" name="relative[fname]" id="fname"
                                class="form-control @error('fname') is-invalid @enderror"
                                value="{{ old('relative.fname', $relative->fname ?? '') }}">
                            @error('fname')
                                <small class="text-danger error-message" id="error-fname">{{ $message }}</small>
                            @enderror
                        </div>
                        <!-- นามสกุล -->
                        <div class="col-md-12 mb-3">
                                <label for="lname" class="form-label">นามสกุล</label>
                                <input type="text" name="relative[lname]" id="lname"
                                    class="form-control @error('lname') is-invalid @enderror"
                                    value="{{ old('relative.lname', $relative->lname ?? '') }}">
                                @error('lname')
                                    <small class="text-danger error-message" id="error-lname">{{ $message }}</small>
                                @enderror
                        </div>
                                <!-- เลขประจําตัว -->
                        <div class="col-md-12 mb-3">
                            <label for="idcard" class="form-label">เลขประจำตัวประชาชน</label>
                            <input type="text" name="relative[idcard]" id="idcard"
                                class="form-control @error('idcard') is-invalid @enderror"
                                value="{{ old('relative.idcard', $relative->idcard ?? '') }}">
                            @error('idcard')
                                <div class="invalid-feedback" id="error-idcard">{{ $message }}</div>
                            @enderror
                        </div>
                             <!-- อายุ -->
                         <div class="col-md-4 mb-3">
                    <label for="age" class="form-label">อายุ</label>
                    <div class="input-group">
                        <input type="number" name="relative[age]" id="age"
                            class="form-control @error('age') is-invalid @enderror"
                            value="{{ old('relative.age', $relative->age ?? '') }}" min="0">
                        <span class="input-group-text">ปี</span>
                            </div>
                            @error('age')
                                <div class="text-danger small mt-1" id="error-age">{{ $message }}</div>
                            @enderror
                        </div>
                             <!-- อาชีพ -->
                <div class="col-md-12 mb-3">
                    <label for="occupation" class="form-label">อาชีพ</label>
                    <input type="text" name="relative[occupation]" id="occupation"
                        class="form-control @error('occupation') is-invalid @enderror"
                        value="{{ old('relative.occupation', $relative->occupation ?? '') }}">
                    @error('occupation')
                        <small class="text-danger error-message" id="error-occupation">{{ $message }}</small>
                    @enderror
                </div>
                    <!-- รายได้ -->
                 <div class="col-md-12 mb-3">
                    <label for="income" class="form-label">รายได้</label>
                    <input type="text" name="relative[income]" id="income"
                        class="form-control @error('income') is-invalid @enderror"
                        value="{{ old('relative.income', $relative->income ?? '') }}">
                    @error('income')
                        <small class="text-danger error-message" id="error-income">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <!-- Card ขวา -->
    <div class="col-lg-6 mb-4">
        <div class="card border shadow-sm">
            <div class="card-header"><h5 class="mb-0">ข้อมูลการติดต่อบิดา</h5></div>

            <div class="card-body">
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label for="address" class="form-label">ที่อยู่เลขที่</label>
                    <input type="text" name="relative[address_no]" id="address_no"
                        class="form-control" value="{{ old('relative.address_no', $relative->address_no ?? '') }}">
                    @error('address_no')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="moo" class="form-label">หมู่ที่</label>
                    <input type="text" name="relative[moo]" id="moo"
                        class="form-control" value="{{ old('relative.moo', $relative->moo ?? '') }}">
                    @error('moo')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="soi" class="form-label">ตรอก/ซอย</label>
                    <input type="text" name="relative[soi]" id="soi"
                        class="form-control" value="{{ old('relative.soi', $relative->soi ?? '') }}">
                    @error('soi')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="road" class="form-label">ถนน</label>
                    <input type="text" name="relative[road]" id="road"
                        class="form-control" value="{{ old('relative.road', $relative->road ?? '') }}">
                    @error('road')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="village" class="form-label">หมู่บ้าน</label>
                <input type="text" name="relative[village]" id="village"
                    class="form-control" value="{{ old('relative.village', $relative->village ?? '') }}">
                @error('village')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

             <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="province" class="form-label">จังหวัด</label>
                    <select name="relative[province_id]" id="relative_province" class="form-select"
                            data-selected="{{ old('relative.province_id', $relative->province_id ?? '') }}">
                        <option value="">--เลือกจังหวัด--</option>
                        @foreach($provinces as $province)
                            <option value="{{ $province->id }}"
                                {{ old('relative.province_id', $relative->province_id ?? '') == $province->id ? 'selected' : '' }}>
                                {{ $province->prov_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            <div class="col-md-6 mb-3">
                    <label for="district" class="form-label">เขต/อำเภอ</label>
                    <select name="relative[district_id]" id="relative_district" class="form-select"
                            data-selected="{{ old('relative.district_id', $relative->district_id ?? '') }}">
                        <option value="">--เลือกอำเภอ--</option>
                        @foreach($districts as $district)
                            <option value="{{ $district->id }}"
                                {{ old('relative.district_id', $relative->district_id ?? '') == $district->id ? 'selected' : '' }}>
                                {{ $district->dist_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label for="subdistrict" class="form-label">แขวง/ตำบล</label>
                <select name="relative[sub_district_id]" id="relative_subdistrict" class="form-select"
                    data-selected="{{ old('relative.sub_district_id', $relative->sub_district_id ?? '') }}">
                    <option value="">-- เลือกตำบล --</option>
                    @foreach($sub_districts as $subdistrict)
                        <option value="{{ $subdistrict->id }}"
                            {{ old('relative.sub_district_id', $relative->sub_district_id ?? '') == $subdistrict->id ? 'selected' : '' }}>
                            {{ $subdistrict->subdist_name }}
                        </option>
                    @endforeach
                </select>
                @error('sub_district_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="zipcode" class="form-label">รหัสไปรษณีย์</label>
                            <input type="text" name="relative[zipcode]" id="relative_zipcode"
                                class="form-control" value="{{ old('relative.zipcode', $relative->zipcode ?? '') }}">
                            @error('zipcode')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-8 mb-3">
                            <label for="phone" class="form-label">โทรศัพท์</label>
                            <input type="text" name="relative[phone]" id="phone"
                                class="form-control" value="{{ old('relative.phone', $relative->phone ?? '') }}">
                            @error('phone')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
     
       <!-- ปุ่มบันทึก/แก้ไข -->
        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">
                @if(isset($father) || isset($mother) || isset($spouse) || isset($relative))
                    แก้ไขข้อมูล
                @else
                    บันทึกข้อมูล
                @endif
            </button>
        </div>
            </form>
        </div>
    


<!-- จังหวัด อำเภอ ตำบล รหัสไปรษณีย์ -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function () {

    function bindLocationDropdowns(prefix) {
        const province    = $('#' + prefix + '_province');
        const district    = $('#' + prefix + '_district');
        const subdistrict = $('#' + prefix + '_subdistrict');
        const zipcode     = $('#' + prefix + '_zipcode');

        // Reset defaults
        district.html('<option value="">--เลือกอำเภอ--</option>');
        subdistrict.html('<option value="">--เลือกตำบล--</option>');
        zipcode.val('');

        // Province change
        province.on('change', function () {
            const province_id = $(this).val();
            district.html('<option value="">--เลือกอำเภอ--</option>');
            subdistrict.html('<option value="">--เลือกตำบล--</option>');
            zipcode.val('');

            if (province_id) {
                $.get('/get-districts/' + province_id).done(function (data) {
                    $.each(data, function (i, value) {
                        district.append('<option value="' + value.id + '">' + value.dist_name + '</option>');
                    });
                });
            }
        });

        // District change
        district.on('change', function () {
            const district_id = $(this).val();
            subdistrict.html('<option value="">--เลือกตำบล--</option>');
            zipcode.val('');

            if (district_id) {
                $.get('/get-subdistricts/' + district_id).done(function (data) {
                    $.each(data, function (i, value) {
                        subdistrict.append('<option value="' + value.id + '">' + value.subd_name + '</option>');
                    });
                });
            }
        });

        // Subdistrict change
        subdistrict.on('change', function () {
            const subdistrict_id = $(this).val();
            zipcode.val('');
            if (subdistrict_id) {
                $.get('/get-zipcode/' + subdistrict_id).done(function (data) {
                    zipcode.val(data.zipcode || '');
                });
            }
        });

        // ✅ Preload existing selections
        const selectedProvince    = province.data('selected') || '';
        const selectedDistrict    = district.data('selected') || '';
        const selectedSubdistrict = subdistrict.data('selected') || '';

        if (selectedProvince) {
            province.val(selectedProvince);

            // Load districts and select saved one
            $.get('/get-districts/' + selectedProvince).done(function (data) {
                district.html('<option value="">--เลือกอำเภอ--</option>');
                $.each(data, function (i, value) {
                    const selected = (String(value.id) === String(selectedDistrict)) ? ' selected' : '';
                    district.append('<option value="' + value.id + '"' + selected + '>' + value.dist_name + '</option>');
                });

                // Load subdistricts and select saved one
                if (selectedDistrict) {
                    $.get('/get-subdistricts/' + selectedDistrict).done(function (data2) {
                        subdistrict.html('<option value="">--เลือกตำบล--</option>');
                        $.each(data2, function (i, value) {
                            const selected = (String(value.id) === String(selectedSubdistrict)) ? ' selected' : '';
                            subdistrict.append('<option value="' + value.id + '"' + selected + '>' + value.subd_name + '</option>');
                        });

                        // Load zipcode
                        if (selectedSubdistrict) {
                            $.get('/get-zipcode/' + selectedSubdistrict).done(function (data3) {
                                zipcode.val(data3.zipcode || '');
                            });
                        }
                    });
                }
            });
        }
    }

    // ใช้กับทุก prefix
    bindLocationDropdowns('father');
    bindLocationDropdowns('mother');
    bindLocationDropdowns('spouse');
    bindLocationDropdowns('relative');
});
</script>






@endsection

        








