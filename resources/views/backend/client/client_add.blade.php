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
  </style>

    <div class="container-fluid py-4">
        <!-- เปิดฟอร์ม -->
       <form action="{{ route('client.store') }}" method="POST" enctype="multipart/form-data">
    @csrf


            <div class="row">
            <!-- Card ฝั่งซ้าย -->
            <div class="col-lg-6 col-xl-6 mb-4">
                <div class="card border shadow-sm">
                <div class="card-header">
                    <div class="row align-items-center">
                    <div class="col">
                        <h4 class="card-title mb-0">ข้อมูลส่วนตัว</h4>
                    </div>
                    </div>
                </div>
          <div class="card-body">

           <div class="form-group col-md-3 mb-3">
                    <div class="form-group w-100">
                 <label for="register_number" class="form-label">เลขทะเบียน</label>
                <input type="text" name="register_number" class="form-control"
                value="{{ old('register_number') }}">   
            </div>
            </div>

            <div class="form-group mb-3 row">
                    <div class="col-lg-12 col-xl-12">
               <label class="form-label d-block">เพศ : <span class="text-danger">*</span></label>
                <div class="form-check form-check-inline">        
                    <input class="form-check-input" type="radio" name="gender" id="genderMale" 
                    value="male" {{ old('gender') == 'male' ? 'checked' : '' }} required
                        value="{{ old('gender') }}">
                    <label class="form-check-label" for="genderMale">ชาย</label>
                </div>
                
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="genderFemale" 
                    value="female" {{ old('gender') == 'female' ? 'checked' : '' }} required>
                    
                    <label class="form-check-label" for="genderFemale">หญิง</label>
                </div>     
            </div>
            </div>

            <div class="row">
                <div class="form-group col-md-4 mb-3">
                    <div class="form-group w-100">
              <label class="form-label" for="title_id">คำนำหน้าชื่อ : <span class="text-danger">*</span></label>
                <select name="title_id" id="title_id" class="form-control form-select">
                    <option value="">--เลือกคำนำหน้าชื่อ--</option>
                    @foreach ($titles as $item)
                        <option value="{{ $item->id }}" 
                            {{ old('title_id') == $item->id ? 'selected' : '' }}>
                            {{ $item->title_name }}
                        </option>
                    @endforeach
                </select>                   
            </div>
         </div>

             <div class="form-group col-md-8 mb-3">
                    <div class="form-group w-100">
              <label for="nick_name" class="form-label">ชื่อเล่น</label>
                <input type="text" name="nick_name" class="form-control" required
                value="{{ old('nick_name') }}">
            </div>
        </div>
     </div>
             
            <div class="row">
                  <div class="form-group col-md-6 mb-3">
                    <div class="form-group w-100">
                        <label for="first_name" class="form-label">ชื่อ : <span class="text-danger">*</span></label>
                        <input type="text" name="first_name" class="form-control" required
                        value="{{ old('first_name') }}">
                    </div>
                </div>

                <div class="form-group col-md-6 mb-3">
                    <div class="form-group w-100">
                        <label for="last_name" class="form-label">นามสกุล</label>
                        <input type="text" name="last_name" class="form-control" required
                        value="{{ old('last_name') }}">
                    </div>
                </div>
            </div>
               
            <div class="row">
                  <div class="form-group col-md-6 mb-3">
                    <div class="form-group w-100">
                            <label for="id_card" class="form-label">เลขประจําตัวประชาชน</label>
                        <input type="text" name="id_card" class="form-control" required
                        value="{{ old('id_card') }}">
                        @error('id_card')
                     <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                 </div>
                    </div>

                <div class="form-group col-md-6 mb-3">
                    <div class="form-group w-100">
                        <div class="col-lg-12 col-xl-12">
                            <label for="birth_date" class="form-label">วันเกิด</label>
                        <input type="date" name="birth_date" id="birth_date" class="form-control" required
                        value="{{ old('birth_date') }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                  <div class="form-group col-md-6 mb-3">
                    <div class="form-group w-100">
                            <label class="form-label" for="national_id">สัญชาติ : <span class="text-danger">*</span></label>
                    <select name="national_id" id="national_id" class="form-control form-select">
                        <option value="">--เลือกสัญชาติ--</option>
                        @foreach ($nations as $item)
                            <option value="{{ $item->id }}" 
                                {{ old('national_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->national_name }}
                            </option>
                        @endforeach
                    </select>           
                        </div>
                    </div>

                   <div class="form-group col-md-6 mb-3">
                    <div class="form-group w-100">
                        <label class="form-label" for="religion_id">ศาสนา : <span class="text-danger">*</span></label>
                        <select name="religion_id" id="religion_id" class="form-control form-select">
                            <option value="">--เลือกศาสนา--</option>
                            @foreach ($religions as $item)
                                <option value="{{ $item->id }}" 
                                    {{ old('religion_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->religion_name }}
                                </option>
                            @endforeach
                        </select>             
                        </div>
                    </div>
            </div>

                    <div class="form-group mb-3 row">
                        <div class="col-lg-12 col-xl-12">
                        <label class="form-label" for="marital_id">สถานะ : <span class="text-danger">*</span></label>
                        <select name="marital_id" id="marital_id" class="form-control form-select">
                            <option value="">--สถานะการสมรส--</option>
                            @foreach ($maritals as $item)
                                <option value="{{ $item->id }}" 
                                    {{ old('marital_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->marital_name }}
                                </option>
                            @endforeach
                        </select>           
                        </div>
                    </div>

            <div class="row">
                    <div class="form-group col-md-6 mb-3">
                    <div class="form-group w-100">
                            <label class="form-label" for="occupation_id">อาชีพ : <span class="text-danger">*</span></label>
                        <select name="occupation_id" id="occupation_id" class="form-control form-select">
                        <option value="">--อาชีพ--</option>
                        @foreach ($occupations as $item)
                            <option value="{{ $item->id }}" 
                                {{ old('occupation_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->occupation_name }}
                            </option>
                        @endforeach
                    </select>             
                        </div>
                    </div>

                <div class="form-group col-md-6 mb-3">
                    <div class="form-group w-100">
                        <label class="form-label" for="income_id">รายได้ : <span class="text-danger">*</span></label>
                        <select name="income_id" id="income_id" class="form-control form-select">
                            <option value="">--รายได้เฉลี่ย--</option>
                            @foreach ($incomes as $item)
                                <option value="{{ $item->id }}" 
                                    {{ old('income_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->income_name }}
                                </option>
                            @endforeach
                        </select>                
                        </div>
                    </div>
            </div>

            <div class="row">
                    <div class="form-group col-md-4 mb-3">
                    <div class="form-group w-100">
                        <label class="form-label" for="education_id">การศึกษา : <span class="text-danger">*</span></label>
                    <select name="education_id" id="education_id" class="form-control form-select">
                        <option value="">--การศึกษา--</option>
                        @foreach ($educations as $item)
                            <option value="{{ $item->id }}" 
                                {{ old('education_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->education_name }}
                            </option>
                        @endforeach
                    </select>              
                        </div>
                    </div>

                 <div class="form-group col-md-8 mb-3">
                    <div class="form-group w-100">
                            <label for="scholl" class="form-label">ชื่อโรงเรียน</label>
                    <input type="text" name="scholl" id="scholl" 
                        class="form-control" 
                        value="{{ old('scholl') }}" required>
                    @error('scholl')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                        </div>
                    </div>
                 </div>

        
            <div class="col-md-12 mb-3">
                <label class="form-label">ปัญหาที่พบ : <span class="text-danger">* (เลือกได้มากกว่า 1 รายการ)</span></label>
                <div class="row">
                    @foreach($problems as $problem)
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" 
                                name="problems[]" value="{{ $problem->id }}" id="problem{{ $problem->id }}">
                                <label  class="form-check-label" for="problem{{ $problem->id }}">
                                    {{ $problem->name }}
                                </label>
                            </div>
                        </div>        
                    @endforeach
                    
                        </div>           
                    </div>  
                </div>
             </div>
        </div>



        <!-- Card ฝั่งขวา -->
        <div class="col-lg-6 col-xl-6 mb-4">
            <div class="card border shadow-sm">
            <div class="card-header">
                <div class="row align-items-center">
                <div class="col">
                    <h4 class="card-title mb-0">ข้อมูลการติดต่อ</h4>
                </div>
                </div>
            </div>
            <div class="card-body">

            <div class="row">
                 <div class="form-group col-md-6 mb-3">
                    <div class="form-group w-100">
                    <label for="address" class="form-label">ที่อยู่เลขที่</label>
                    <input type="text" name="address" id="address" 
                        class="form-control" 
                        value="{{ old('address') }}">
                    @error('address')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
            </div>
         </div>

             <div class="form-group col-md-6 mb-3">
                    <div class="form-group w-100">
             <label for="address" class="form-label">หมู่ที่</label>
                <input type="text" name="moo" id="moo" 
                    class="form-control" 
                    value="{{ old('moo') }}">
                @error('moo')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
         </div>
      </div>

            <div class="row">
                 <div class="form-group col-md-6 mb-3">
                     <div class="form-group w-100">
                 <label for="soi" class="form-label">ตรอก/ซอย</label>
                <input type="text" name="soi" id="soi" 
                    class="form-control" 
                    value="{{ old('soi') }}">
                @error('soi')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
         </div>
     
            <div class="form-group col-md-6 mb-3">
                <div class="form-group w-100">
                <label for="road" class="form-label">ถนน</label>
                <input type="text" name="road" id="road" 
                    class="form-control" 
                    value="{{ old('road') }}">
                @error('road')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
         </div>
    </div>
         
        <div class="form-group mb-3 row">
             <div class="col-lg-12 col-xl-12">
             <label for="village" class="form-label">หมู่บ้าน</label>
                <input type="text" name="village" id="village" 
                    class="form-control" 
                    value="{{ old('village') }}">
                @error('village')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
         </div>
         
                <div class="row">
                      <div class="form-group col-md-12 mb-3">
                     <div class="form-group w-100">
                    <label class="form-label" for="province">จังหวัด</label>
                    <select name="province_id" id="province" class="form-select">
                        <option value="">--เลือกจังหวัด--</option>
                        @foreach($provinces as $province)
                            <option value="{{ $province->id }}" 
                                {{ old('province_id') == $province->id ? 'selected' : '' }}>
                                {{ $province->prov_name }}
                            </option>
                        @endforeach
                    </select>                   
                </div>
            </div>

        <div class="form-group col-md-12 mb-3">
                     <div class="form-group w-100">
                    <label class="form-label" for="district">เขต/อำเภอ</label>
                    <select name="district_id" id="district" class="form-control form-select">
                        <option value="">--เลือกอำเภอ--</option>
                        @foreach($districts as $district)
                            <option value="{{ $district->id }}" 
                                {{ old('district_id') == $district->id ? 'selected' : '' }}>
                                {{ $district->dist_name }}
                            </option>
                        @endforeach
                    </select>                   
                </div>
            </div>
         
                </div>
      
           <div class="form-group col-md-12 mb-3">
                     <div class="form-group w-100">
                    <label class="form-label" for="subdistrict">แขวง/ตำบล</span></label>
                    <select name="sub_district_id" id="subdistrict" class="form-select" required>
                        <option value="">-- เลือกตำบล --</option>
                        @foreach($sub_districts as $subdistrict)
                            <option value="{{ $subdistrict->id }}" 
                                {{ old('sub_district_id', $recipient->sub_district_id ?? '') == $subdistrict->id ? 'selected' : '' }}>
                                {{ $subdistrict->subdist_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('sub_district_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="row">
                 <div class="form-group col-md-4 mb-3">
                     <div class="form-group w-100">
                <label for="zipcode" class="form-label">รหัสไปรษณีย์</label>
                    <input type="text" name="zipcode" id="zipcode" 
                        class="form-control" 
                        value="{{ old('zipcode') }}">
                    @error('zipcode')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

          <div class="form-group col-md-8 mb-3">
                     <div class="form-group w-100">
                <label for="phone" class="form-label">โทรศัพท์</label>
                    <input type="text" name="phone" id="phone" 
                        class="form-control" 
                        value="{{ old('phone') }}" required>
                    @error('phone')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            </div>
           
            <div class="row">
            <div class="form-group col-md-6 mb-3">
                    <div class="form-group w-100">
                        <label class="form-label" for="target_id">กลุ่มเป้าหมาย : <span class="text-danger">*</span></label>
                        <select name="target_id" id="target_id" class="form-control form-select">
                            <option value="">--กลุ่มเป้าหมาย--</option>
                            @foreach ($targets as $item)
                                <option value="{{ $item->id }}" 
                                    {{ old('target_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->target_name }}
                                </option>
                            @endforeach
                        </select>                   
                    </div>
                </div>

            <div class="form-group col-md-6 mb-3">
                    <div class="form-group w-100">
                        <label class="form-label" for="contact_id">วิธีการติดต่อ : <span class="text-danger">*</span></label>
                        <select name="contact_id" id="contact_id" class="form-control form-select">
                            <option value="">--การติดต่อ--</option>
                            @foreach ($contacts as $item)
                                <option value="{{ $item->id }}" 
                                    {{ old('contact_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->contact_name }}
                                </option>
                            @endforeach
                        </select>                   
                    </div>
                </div>
            </div>

            <div class="row">
                    <div class="form-group col-md-6 mb-3">
                    <div class="form-group w-100">
                        <label class="form-label" for="project_id">หน่วยงาน : <span class="text-danger">*</span></label>
                        <select name="project_id" id="project_id" class="form-control form-select">
                            <option value="">--หน่วยงาน--</option>
                            @foreach ($projects as $item)
                                <option value="{{ $item->id }}" 
                                    {{ old('project_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->project_name }}
                                </option>
                            @endforeach
                        </select>                   
                    </div>
                </div>


            <div class="form-group col-md-6 mb-3">
                    <div class="form-group w-100">
                        <label class="form-label" for="house_id">สถานที่พักอาศัย : <span class="text-danger">*</span></label>
                        <select name="house_id" id="house_id" class="form-control form-select">
                            <option value="">--สถานที่พัก--</option>
                            @foreach ($houses as $item)
                                <option value="{{ $item->id }}" 
                                    {{ old('house_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->house_name }}
                                </option>
                            @endforeach
                        </select>                   
                    </div>
                </div>
            </div>
            
            <div class="row">
            <div class="form-group col-md-6 mb-3">
                    <div class="form-group w-100">
                        <label class="form-label" for="status_id">สถานะผู้เข้ารับ : <span class="text-danger">*</span></label>
                        <select name="status_id" id="status_id" class="form-control form-select">
                            <option value="">--สถานะผู้เข้ารับ--</option>
                            @foreach ($statuses as $item)
                                <option value="{{ $item->id }}" 
                                    {{ old('status_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->status_name }}
                                </option>
                            @endforeach
                        </select>                   
                    </div>
                </div>

                <div class="form-group col-md-6 mb-3">
                    <label for="arrival_date" class="form-label">วันที่รับเข้า <span class="text-danger">*</span></label>
                    <input type="date" name="arrival_date" id="arrival_date" 
                        class="form-control" 
                        value="{{ old('arrival_date') }}">
                    @error('arrival_date')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            

            <div class="col-md-12 mb-3">
                <label for="case_resident" class="form-label">สถานะอยู่อาศัย <span class="text-danger">*</span></label>
                    <select name="case_resident" class="form-select" required>
                        <option value="">-- เลือกสถานะ --</option>
                        <option value="Active" selected>อยู่อาศัย</option>
                        <option value="Inactive">ไม่อยู่อาศัย</option>
                    </select>
                </div>

                <!-- Image -->
                <div class="row">
                    <div class="col-md-4">
                        <label for="image" class="form-label">อัปโหลดรูป</label>
                        <input class="form-control" type="file" name="image" id="image">
                    </div>

                    <div class="col-md-6">
                        <label for="image" class="form-label">ภาพถ่าย</label>
                        <img id="showImage" 
                            src="{{ !empty($profileData->image) ? asset($profileData->image) : asset('upload/no_image.jpg') }}"
                            class="rounded-circle avatar-xxl img-thumbnail float-start" alt="image profile">
                    </div>
                </div>  
                <!-- Image -->
                    <div div class="text-start">
                        <button type="submit" class="btn btn-success">บันทึกข้อมูล</button>
                    </div> 
            </form>
        </div>
    </div>
</div>


<!-- จังหวัด อำเภอ ตำบล รหัสไปรษณีย์ -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function () {
    // เคลียร์ค่าเริ่มต้นทุก dropdown ตอนโหลดหน้า
    $('#district').empty().append('<option value="">--เลือกอำเภอ--</option>');
    $('#subdistrict').empty().append('<option value="">--เลือกตำบล--</option>');
    $('#zipcode').val('');

    // เมื่อเลือกจังหวัด
    $('#province').on('change', function () {
        let province_id = $(this).val();
        console.log("Selected province ID:", province_id);

        if (province_id) {
            $.get('/get-districts/' + province_id, function (data) {
                console.log("Districts loaded:", data);

                $('#district').empty().append('<option value="">--เลือกอำเภอ--</option>');
                $.each(data, function (key, value) {
                    $('#district').append('<option value="' + value.id + '">' + value.dist_name + '</option>');
                });

                $('#subdistrict').empty().append('<option value="">--เลือกตำบล--</option>');
                $('#zipcode').val('');
            });
        } else {
            // ถ้าไม่ได้เลือกจังหวัด ให้เคลียร์ dropdown
            $('#district').empty().append('<option value="">--เลือกอำเภอ--</option>');
            $('#subdistrict').empty().append('<option value="">--เลือกตำบล--</option>');
            $('#zipcode').val('');
        }
    });

    // เมื่อเลือกอำเภอ
    $('#district').on('change', function () {
        let district_id = $(this).val();

        if (district_id) {
            $.get('/get-subdistricts/' + district_id, function (data) {
                $('#subdistrict').empty().append('<option value="">--เลือกตำบล--</option>');
                $.each(data, function (key, value) {
                    $('#subdistrict').append('<option value="' + value.id + '">' + value.subd_name + '</option>');
                });
                $('#zipcode').val('');
            });
        } else {
            $('#subdistrict').empty().append('<option value="">--เลือกตำบล--</option>');
            $('#zipcode').val('');
        }
    });

    // เมื่อเลือกตำบล
    $('#subdistrict').on('change', function () {
        let subdistrict_id = $(this).val();

        if (subdistrict_id) {
            $.get('/get-zipcode/' + subdistrict_id, function (data) {
                $('#zipcode').val(data.zipcode);
            });
        } else {
            $('#zipcode').val('');
        }
    });
});
</script>

<!-- show image -->
        <script type="text/javascript">
            $(document).ready(function() {
                $('#image').change(function(e) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#showImage').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(e.target.files['0']);
                });
            });
        </script>
        <!-- end show image -->   
@endsection

        





