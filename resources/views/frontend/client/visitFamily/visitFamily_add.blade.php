@extends('admin_client.admin_client')
@section('content')

    <style>

        /* กล่องรวมฟอร์ม */
        .official-form {
            border: 2px solid #0d6efd;
            /* กรอบน้ำเงินกรม */
            padding: 20px;
            background-color: #fdfdfd;
            /* พื้นหลังขาวสะอาด */
            border-radius: 8px;
        }

        /* กล่อง checkbox */
        .official-checkbox {
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            padding: 10px 14px;
            border-radius: 6px;
            transition: all 0.3s ease-in-out;
        }

        .official-checkbox:hover {
            background-color: #e9f2ff;
            /* hover น้ำเงินอ่อน */
            border-color: #0d6efd;
        }

        /* checkbox ปรับขนาดและสี */
        .styled-checkbox {
            width: 20px;
            height: 20px;
            border: 2px solid #0d6efd;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
        }

        .styled-checkbox:checked {
            background-color: #0d6efd;
            border-color: #0d6efd;
            box-shadow: 0 0 4px rgba(13, 110, 253, 0.6);
        }

        /* label */
        .form-check-label {
            margin-left: 0.6em;
            font-size: 1rem;
        }
        /* กล่องรูป */
            .gallery-img {
            width: 100%;
            height: 150px;        /* mobile */
            object-fit: cover;
        }

        @media (min-width: 768px) {
            .gallery-img {
                height: 200px;    /* tablet */
            }
        }

        @media (min-width: 1200px) {
            .gallery-img {
                height: 250px;    /* desktop */
            }
        }
    </style>

        <div class="container-fluid py-4">
            <form method="POST" 
                action="{{ isset($visitFamily) ? route('vitsitFamily.update', $visitFamily->id) : route('vitsitFamily.store', $client_id) }}" 
                  enctype="multipart/form-data">
                    @csrf
                      @if(isset($visitFamily))
                        @method('PUT')
                      @endif

            @if (session('warning'))
                <div class="alert alert-warning">
                    {{ session('warning') }}
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- ฟิลด์ต่าง ๆ -->
            <div class="row">
                <!-- Card ฝั่งซ้าย -->
                <div class="col-lg-6 col-xl-6 mb-4">
                    <div class="card border shadow-sm">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h4 class="card-title mb-0">ข้อมูลการเยี่ยมบ้าน</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- ฟิลด์สำหรับข้อมูลส่วนตัว -->

                            <div class="row pt-4">
                                <div class="form-group col-md-3 mb-3">
                                    <label for="visit_date" class="form-label">วันที่เยี่ยมบ้าน: <span
                                            class="text-danger">*</span></label>
                                    <input type="date" name="visit_date" id="visit_date"
                                        class="form-control @error('visit_date') is-invalid @enderror"
                                        value="{{ old('visit_date', $visitFamily->visit_date ?? '') }}">
                                    @error('visit_date')
                                        <small class="text-danger" id="visit_date-error">{{ $message }}</small>
                                    @enderror
                                </div>

                              <div class="form-group col-md-3 mb-3">
                                <label for="count" class="form-label">ครั้งที่:</label>
                                <div class="d-flex align-items-center">
                                    {{-- แสดงค่า 1 แบบ readonly --}}
                                    <input type="text" id="count" class="form-control" value="1" readonly>
                                    <span class="ms-2">ครั้ง</span>
                                </div>
                                {{-- ส่งค่า 1 ไปกับฟอร์มแบบ hidden --}}
                                <input type="hidden" name="count" value="1">
                            </div>
                        </div>

                            <div class="row">
                                <div class="form-group col-md-6 mb-3">
                                    <label for="family_fname" class="form-label">ชื่อ-สกุล เจ้าของบ้าน: <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="family_fname" id="family_fname"
                                        class="form-control @error('family_fname') is-invalid @enderror"
                                        value="{{ old('family_fname', $visitFamily->family_fname ?? '') }}">
                                    @error('family_fname')
                                        <div class="invalid-feedback" id="family_fname-error">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="form-group col-md-3 mb-3">
                                    <label for="family_age" class="form-label">อายุ:</label>
                                    <div class="d-flex align-items-center">
                                        <input type="text" name="family_age" id="family_age" class="form-control"
                                            value="{{ old('family_age', $visitFamily->family_age ?? '') }}">
                                        <span class="ms-2">ปี</span>
                                    </div>
                                    @error('family_age')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            <div class="row">
                                <div class="form-group col-md-6 mb-3">
                                    <label class="form-label" for="income_id">รายได้ : <span
                                            class="text-danger">*</span></label>
                                    <select name="income_id" id="income_id"
                                        class="form-control form-select @error('income_id') is-invalid @enderror">
                                        <option value="">--รายได้เฉลี่ย--</option>
                                        @foreach ($incomes as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('income_id', $visitFamily->income_id ?? '') == $item->id ? 'selected' : '' }}>
                                                {{ $item->income_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('income_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>



                                <div class="form-group col-md-6 mb-3">
                                    <label for="member" class="form-label">ความสัมพันธ์กับผู้รับ</label>
                                    <input type="text" name="member" class="form-control"
                                        value="{{ old('member', $visitFamily->member ?? '') }}">
                                    @error('member')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="form-group col-md-12 mb-3">
                                    <label for="outside_address" class="form-label">สภาพที่อยู่ภายนอก : <span
                                            class="text-danger">*</span></label>
                                    <textarea name="outside_address" id="outside_address"
                                        class="form-control bg-white border rounded shadow-sm @error('outside_address') is-invalid @enderror"
                                        rows="3">{{ old('outside_address', $visitFamily->outside_address ?? '') }}</textarea>
                                    @error('outside_address')
                                        <div class="invalid-feedback d-block" id="outside_address-error">{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-12 mb-3">
                                    <label for="inside_address" class="form-label">สภาพที่อยู่ภายใน : <span
                                            class="text-danger">*</span></label>
                                    <textarea name="inside_address" id="inside_address"
                                        class="form-control bg-white border rounded shadow-sm @error('inside_address') is-invalid @enderror" rows="3">{{ old('inside_address', $visitFamily->inside_address ?? '') }}</textarea>
                                    @error('inside_address')
                                        <div class="invalid-feedback d-block" id="inside_address-error">{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-12 mb-3">
                                    <label for="environment" class="form-label">สภาพแวดล้อม : <span
                                            class="text-danger">*</span></label>
                                    <textarea name="environment" id="environment"
                                        class="form-control bg-white border rounded shadow-sm @error('environment') is-invalid @enderror" rows="3">{{ old('environment', $visitFamily->environment ?? '') }}</textarea>
                                    @error('environment')
                                        <div class="invalid-feedback d-block" id="environment-error">{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-12 mb-3">
                                    <label for="neighbor" class="form-label">ความสัมพันธ์กับเพื่อนบ้าน : <span
                                            class="text-danger">*</span></label>
                                    <textarea name="neighbor" id="neighbor"
                                        class="form-control bg-white border rounded shadow-sm @error('neighbor') is-invalid @enderror" rows="3">{{ old('neighbor', $visitFamily->neighbor ?? '') }}</textarea>
                                    @error('neighbor')
                                        <div class="invalid-feedback d-block" id="neighbor-error">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-12 mb-3">
                                    <label for="member_relation" class="form-label">ความสัมพันธ์ของสมาชิกในบ้าน : <span
                                            class="text-danger">*</span></label>
                                    <textarea name="member_relation" id="member_relation"
                                        class="form-control bg-white border rounded shadow-sm @error('member_relation') is-invalid @enderror"
                                        rows="3">{{ old('member_relation', $visitFamily->member_relation ?? '') }}</textarea>
                                    @error('member_relation')
                                        <div class="invalid-feedback d-block" id="member_relation-error">{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-12 mb-3 mt-3">
                                    <label for="problem" class="form-label">ปัญหาที่พบ : <span
                                            class="text-danger">*</span></label>
                                    <textarea name="problem" id="problem"
                                        class="form-control bg-white border rounded shadow-sm @error('problem') is-invalid @enderror" rows="3">{{ old('problem', $visitFamily->problem ?? '') }}</textarea>
                                    @error('problem')
                                        <div class="invalid-feedback d-block" id="problem-error">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-12 mb-3">
                                    <label for="need" class="form-label">ความต้องการ : <span
                                            class="text-danger">*</span></label>
                                    <textarea name="need" id="need"
                                        class="form-control bg-white border rounded shadow-sm @error('need') is-invalid @enderror" rows="3">{{ old('need', $visitFamily->need ?? '') }}</textarea>
                                    @error('need')
                                        <div class="invalid-feedback d-block" id="need-error">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                        </div> <!-- สิ้นสุด card-body -->
                    </div>
                </div>

                <!-- Card ฝั่งขวา -->
                <div class="col-lg-6 col-xl-6 mb-4">
                    <div class="card border shadow-sm">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h4 class="card-title mb-0">การประเมินสภาวะเด็กและครอบครัว</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- ฟิลด์สำหรับข้อมูลการติดต่อ -->
                            <!-- ที่อยู่ จังหวัด อำเภอ ตําบล รหัสไปรษณีย์ -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="address" class="form-label">ที่อยู่เลขที่</label>
                                    <input type="text" name="address" id="address" class="form-control"
                                        value="{{ old('address', $visitFamily->address ?? '') }}">
                                    @error('address')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="moo" class="form-label">หมู่ที่</label>
                                    <input type="text" name="moo" id="moo" class="form-control"
                                        value="{{ old('moo', $visitFamily->moo ?? '') }}">
                                    @error('moo')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="soi" class="form-label">ตรอก/ซอย</label>
                                    <input type="text" name="soi" id="soi" class="form-control"
                                        value="{{ old('soi', $visitFamily->soi ?? '') }}">
                                    @error('soi')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="road" class="form-label">ถนน</label>
                                    <input type="text" name="road" id="road" class="form-control"
                                        value="{{ old('road', $visitFamily->road ?? '') }}">
                                    @error('road')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="village" class="form-label">หมู่บ้าน</label>
                                <input type="text" name="village" id="village" class="form-control"
                                    value="{{ old('village', $visitFamily->village ?? '') }}">
                                @error('village')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="province" class="form-label">จังหวัด</label>
                                    <select name="province_id" id="province" class="form-select"
                                        data-selected="{{ old('province_id', $visitFamily->province_id ?? '') }}">
                                        <option value="">--เลือกจังหวัด--</option>
                                        @foreach ($provinces as $province)
                                            <option value="{{ $province->id }}"
                                                {{ old('province_id', $visitFamily->province_id ?? '') == $province->id ? 'selected' : '' }}>
                                                {{ $province->prov_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="district" class="form-label">เขต/อำเภอ</label>
                                    <select name="district_id" id="district" class="form-select"
                                        data-selected="{{ old('district_id', $visitFamily->district_id ?? '') }}">
                                        <option value="">--เลือกอำเภอ--</option>
                                        @foreach ($districts as $district)
                                            <option value="{{ $district->id }}"
                                                {{ old('district_id', $visitFamily->district_id ?? '') == $district->id ? 'selected' : '' }}>
                                                {{ $district->dist_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="subdistrict" class="form-label">แขวง/ตำบล</label>
                                <select name="sub_district_id" id="subdistrict" class="form-select"
                                    data-selected="{{ old('sub_district_id', $visitFamily->sub_district_id ?? '') }}">
                                    <option value="">-- เลือกตำบล --</option>
                                    @foreach ($sub_districts as $subdistrict)
                                        <option value="{{ $subdistrict->id }}"
                                            {{ old('sub_district_id', $visitFamily->sub_district_id ?? '') == $subdistrict->id ? 'selected' : '' }}>
                                            {{ $subdistrict->subd_name }}
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
                                    <input type="text" name="zipcode" id="zipcode" class="form-control"
                                        value="{{ old('zipcode', $visitFamily->zipcode ?? '') }}">
                                    @error('zipcode')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-8">
                                    <label for="phone" class="form-label">โทรศัพท์</label>
                                    <input type="text" name="phone" id="phone" class="form-control"
                                        value="{{ old('phone', $visitFamily->phone ?? '') }}">
                                    @error('phone')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <!-- สิ้นสุด ที่อยู่ จังหวัด อำเภอ ตําบล รหัสไปรษณีย์ -->

                            <div class="form-group col-md-12 mb-3">
                                <label for="diagnose" class="form-label">การวินิจฉัยปัญหา : <span
                                        class="text-danger">*</span></label>
                                <textarea name="diagnose" id="diagnose"
                                    class="form-control bg-white border rounded shadow-sm @error('diagnose') is-invalid @enderror" rows="3">{{ old('diagnose', $visitFamily->diagnose ?? '') }}</textarea>
                                @error('diagnose')
                                    <div class="invalid-feedback d-block" id="diagnose-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-12 mb-3">
                                <label for="assistance" class="form-label">การให้ความช่วยเหลือ : <span
                                        class="text-danger">*</span></label>
                                <textarea name="assistance" id="assistance"
                                    class="form-control bg-white border rounded shadow-sm @error('assistance') is-invalid @enderror" rows="3">{{ old('assistance', $visitFamily->assistance ?? '') }}</textarea>
                                @error('assistance')
                                    <div class="invalid-feedback d-block" id="assistance-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-12 mb-3">
                                <label for="comment" class="form-label">ข้อคิดเห็น : <span
                                        class="text-danger">*</span></label>
                                <textarea name="comment" id="comment"
                                    class="form-control bg-white border rounded shadow-sm @error('comment') is-invalid @enderror" rows="3">{{ old('comment', $visitFamily->comment ?? '') }}</textarea>
                                @error('comment')
                                    <div class="invalid-feedback d-block" id="comment-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-12 mb-3">
                                <label for="modify" class="form-label">สิ่งที่ควรแก้ไข : <span
                                        class="text-danger">*</span></label>
                                <textarea name="modify" id="modify"
                                    class="form-control bg-white border rounded shadow-sm @error('modify') is-invalid @enderror" rows="3">{{ old('modify', $visitFamily->modify ?? '') }}</textarea>
                                @error('modify')
                                    <div class="invalid-feedback d-block" id="modify-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-12 mb-3">
                                <label for="remark" class="form-label">หมายเหตุ : <span
                                        class="text-danger">*</span></label>
                                <textarea name="remark" id="remark"
                                    class="form-control bg-white border rounded shadow-sm @error('remark') is-invalid @enderror" rows="3">{{ old('remark', $visitFamily->remark ?? '') }}</textarea>
                                @error('remark')
                                    <div class="invalid-feedback d-block" id="remark-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-6 mb-3">
                                <label for="teacher" class="form-label">ชื่อเจ้าหน้าที่</label>
                                <input type="text" name="teacher" id="teacher" class="form-control"
                                    value="{{ old('teacher', $visitFamily->teacher ?? '') }}">
                                @error('teacher')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- เลือกรูป --}}
                        <div class="mb-3">
                            <label for="images" class="form-label">เลือกรูปภาพ</label>
                            <input type="file" name="images[]" id="images" class="form-control" multiple accept="image/*">

                            {{-- พื้นที่แสดง preview --}}
                            <div id="preview" class="row mt-3"></div>
                        </div>

               
                  {{-- ลบภาพ --}}
@if(isset($images) && $images->count() > 0)
    <div class="mb-3">
        <label class="form-label">รูปเยี่ยมบ้านที่เคยอัปโหลด</label>
        <div class="row" id="image-gallery">
            @foreach($images as $img)
                <div class="col-md-3 mb-3" id="image-{{ $img->id }}">
                    <div class="position-relative">
                        <div class="ratio ratio-1x1">
                            <img src="{{ asset('storage/'.$img->file_path) }}"
                                 class="w-100 h-100 rounded border shadow-sm"
                                 style="object-fit: cover;">
                        </div>

                        {{-- ปุ่มลบ overlay --}}
                        <button type="button"
                                class="btn btn-danger btn-sm position-absolute top-0 start-0 ms-2 mt-2 delete-image"
                                data-url="{{ route('image.destroy', $img->id) }}"
                                data-id="{{ $img->id }}">
                           ลบภาพ
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
                    <div class="text-start">
                        <button type="submit" class="btn btn-success">
                            {{ isset($visitFamily) ? 'แก้ไขข้อมูล' : 'บันทึกข้อมูลใหม่' }}
                        </button>
                    </div>
                </form>
        </div>


    <!-- จังหวัด อำเภอ ตำบล รหัสไปรษณีย์ -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(function() {
            const province = $('#province');
            const district = $('#district');
            const subdistrict = $('#subdistrict');
            const zipcode = $('#zipcode');

            function resetDistrict() {
                district.html('<option value="">--เลือกอำเภอ--</option>');
            }

            function resetSubdistrict() {
                subdistrict.html('<option value="">--เลือกตำบล--</option>');
            }

            function resetZipcode() {
                zipcode.val('');
            }

            // เมื่อเปลี่ยนจังหวัด
            province.on('change', function() {
                const province_id = $(this).val();
                resetDistrict();
                resetSubdistrict();
                resetZipcode();

                if (province_id) {
                    $.get('/vitsitFamily/get-districts/' + province_id).done(function(data) {
                        console.log('Districts:', data); // ✅ Debug
                        district.html('<option value="">--เลือกอำเภอ--</option>');
                        $.each(data, function(i, value) {
                            district.append('<option value="' + value.id + '">' + value
                                .dist_name + '</option>');
                        });
                    }).fail(function(xhr) {
                        console.error('Error loading districts:', xhr.responseText);
                    });
                }
            });

            // เมื่อเปลี่ยนอำเภอ
            district.on('change', function() {
                const district_id = $(this).val();
                resetSubdistrict();
                resetZipcode();

                if (district_id) {
                    $.get('/vitsitFamily/get-subdistricts/' + district_id).done(function(data) {
                        console.log('Subdistricts:', data); // ✅ Debug
                        subdistrict.html('<option value="">--เลือกตำบล--</option>');
                        $.each(data, function(i, value) {
                            subdistrict.append('<option value="' + value.id + '">' + value
                                .subd_name + '</option>');
                        });
                    }).fail(function(xhr) {
                        console.error('Error loading subdistricts:', xhr.responseText);
                    });
                }
            });

            // เมื่อเปลี่ยนตำบล
            subdistrict.on('change', function() {
                const subdistrict_id = $(this).val();
                resetZipcode();
                if (subdistrict_id) {
                    $.get('/vitsitFamily/get-zipcode/' + subdistrict_id).done(function(data) {
                        console.log('Zipcode:', data); // ✅ Debug
                        zipcode.val(data.zipcode || '');
                    }).fail(function(xhr) {
                        console.error('Error loading zipcode:', xhr.responseText);
                    });
                }
            });
        });
    </script>
    <!-- แสดงภาพ -->
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('images');
        const preview = document.getElementById('preview');

        input.addEventListener('change', function () {
            preview.innerHTML = ''; // เคลียร์ preview เดิมก่อน
            Array.from(this.files).forEach(file => {
                if (!file.type.startsWith('image/')) return;

                const reader = new FileReader();
                reader.onload = e => {
                    const col = document.createElement('div');
                    col.classList.add('col-md-3', 'mb-3');
                    col.innerHTML = `
                        <img src="${e.target.result}" class="img-fluid rounded border shadow-sm">
                    `;
                    preview.appendChild(col);
                };
                reader.readAsDataURL(file);
            });
        });
    });
    </script>

<!-- ต้องมี SweetAlert2 ใน layout -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- ลบภาพ -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const csrf = '{{ csrf_token() }}';

    // ดักทุกปุ่มที่มี class delete-image
    document.querySelectorAll('.delete-image').forEach(button => {
        button.addEventListener('click', () => {
            const url = button.dataset.url;
            const id  = button.dataset.id;

            Swal.fire({
                title: '⚠️ ยืนยันการลบ',
                text: 'คุณแน่ใจหรือไม่ว่าต้องการลบภาพนี้?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e74c3c',
                cancelButtonColor: '#95a5a6',
                confirmButtonText: 'ตกลง',
                cancelButtonText: 'ยกเลิก',
                reverseButtons: true,
                backdrop: true,
                allowOutsideClick: false,
            }).then((result) => {
                if (!result.isConfirmed) return;

                fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrf,
                        'Accept': 'application/json'
                    }
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById(`image-${id}`).remove();
                        Swal.fire({
                            title: 'ลบแล้ว!',
                            text: 'ภาพถูกลบเรียบร้อย',
                            icon: 'success',
                            timer: 1200,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire('ผิดพลาด!', data.error || 'เกิดข้อผิดพลาดในการลบภาพ', 'error');
                    }
                })
                .catch(() => Swal.fire('ผิดพลาด!', 'ไม่สามารถเชื่อมต่อเซิร์ฟเวอร์ได้', 'error'));
            });
        });
    });
});
</script>


    @endsection
