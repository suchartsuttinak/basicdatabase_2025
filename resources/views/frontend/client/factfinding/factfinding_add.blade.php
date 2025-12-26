@extends('admin_client.admin_client')
@section('content')


<style>
    /* กล่องรวมฟอร์ม */
    .official-form {
        border: 2px solid #0d6efd;   /* กรอบน้ำเงินกรม */
        padding: 20px;
        background-color: #fdfdfd;   /* พื้นหลังขาวสะอาด */
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
        background-color: #e9f2ff;   /* hover น้ำเงินอ่อน */
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
    
</style>



@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif


   <div class="container-fluid py-4">
    <!-- เปิดฟอร์ม -->
     <form action="{{ route('factfinding.store') }}" method="POST" class="row g-3">
            @csrf
            <!-- ส่ง id ไปด้วย -->
            <input type="hidden" name="client_id" value="{{$client->id}}">
        <div class="row">
            <!-- Card ฝั่งซ้าย -->
            <div class="col-lg-6 col-xl-6 mb-4">
                <div class="card border shadow-sm">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h4 class="card-title mb-0">ข้อมูลการสอบข้อเท็จจริงเบื้องต้น</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- ฟิลด์สำหรับข้อมูลส่วนตัว -->

                <div class="row pt-4">
                    <div class="form-group col-md-3 mb-3">
                        <label for="date" class="form-label">วันที่บันทึก: <span class="text-danger">*</span></label>
                        <input type="date" name="date" id="date"
                            class="form-control @error('date') is-invalid @enderror"
                            value="{{ old('date') }}">
                        @error('date')
                            <small class="text-danger" id="date-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group col-md-9 mb-3">
                        <label for="fact_name" class="form-label">ผู้นำส่ง: <span class="text-danger">*</span></label>
                        <input type="text" name="fact_name" id="fact_name"
                            class="form-control @error('fact_name') is-invalid @enderror"
                            value="{{ old('fact_name') }}">
                        @error('fact_name')
                            <div class="invalid-feedback" id="fact_name-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                 <div class="row">
                        <div class="form-group col-md-6 mb-3">
                            <label for="appearance" class="form-label">รูปพรรณสัณฐาน</label>
                            <input type="text" name="appearance" class="form-control" 
                                value="{{ old('appearance') }}">
                            @error('appearance')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-6 mb-3">
                            <label for="skin" class="form-label">สีผิว</label>
                            <input type="text" name="skin" class="form-control" 
                                value="{{ old('skin') }}">
                            @error('skin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                </div>

                    <div class="row">
                        <div class="form-group col-md-6 mb-3">
                            <label for="scar" class="form-label">ตำหนิ/แผลเป็น</label>
                            <input type="text" name="scar" class="form-control" 
                                value="{{ old('scar') }}">
                            @error('scar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                            <div class="form-group col-md-6 mb-3">
                                <label for="disability" class="form-label">ลักษณะความพิการ</label>
                                <input type="text" name="disability" class="form-control" 
                                value="{{ old('disability') }}">
                                @error('disability')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                        </div>
                </div>

                <!-- Sick radio button -->
                    <div class="form-group col-md-2 mb-3">
                        <label class="form-label d-block">ประวัติการเจ็บป่วย : <span class="text-danger">*</span></label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input @error('sick') is-invalid @enderror"
                                    type="radio" name="sick" id="sickYes"
                                    value="1" {{ old('sick') === '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="sickYes">มี</label>
                            </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input @error('sick') is-invalid @enderror"
                                type="radio" name="sick" id="sickNo"
                                value="0" {{ old('sick') === '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="sickNo">ไม่มี</label>
                        </div>

                        @error('sick')
                            <div class="text-danger small" id="sick-error">{{ $message }}</div>
                        @enderror
                    </div>

                      <!-- รายละเอียดการเจ็บป่วย -->
                    <div class="form-group col-md-12 mb-3" id="sickDetailGroup"
                        style="{{ old('sick') == 1 ? '' : 'display:none;' }}">
                        <label for="sick_detail" class="form-label text-start">รายละเอียดการเจ็บป่วย</label>
                        <textarea name="sick_detail" id="sick_detail"
                                class="form-control bg-white border rounded shadow-sm"
                                style="text-align: left; padding-left: 1em; margin: 0;"
                                rows="4"
                                {{ old('sick') == 1 ? 'required' : '' }}>{{ old('sick_detail') }}</textarea>
                        @error('sick_detail')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6 mb-3">
                            <label for="treatment" class="form-label">การรักษาพยาบาล</label>
                            <input type="text" name="treatment" class="form-control"
                            value="{{ old('treatment') }}">
                            @error('treatment')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                         </div>

                    <div class="form-group col-md-6 mb-3">
                            <label for="hospital" class="form-label">สถานพยาบาล</label>
                            <input type="text" name="hospital" class="form-control" 
                            value="{{ old('hospital') }}">
                            @error('hospital')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>      
                 </div>

                   <div class="row">
                       <div class="form-group col-md-3 mb-3">
                            <label for="weight" class="form-label">น้ำหนัก</label>
                            <div class="d-flex align-items-center">
                                <input type="text" name="weight" id="weight" class="form-control" 
                                value="{{ old('weight') }}">
                                <span class="ms-2">กิโลกรัม</span>
                            </div>
                            @error('weight')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                     </div>

                    <div class="form-group col-md-3 mb-3">
                            <label for="height" class="form-label">ส่วนสูง</label>
                            <div class="d-flex align-items-center">
                                <input type="text" name="height" id="height" class="form-control" 
                                value="{{ old('height') }}">
                                <span class="ms-2">เซนติเมตร</span>
                            </div>
                            @error('height')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                     </div>

                      <div class="form-group col-md-6 mb-3">
                            <label for="hygiene" class="form-label">ความสะอาดร่างกาย</label>
                            <input type="text" name="hygiene" class="form-control" 
                            value="{{ old('hygiene') }}">
                            @error('hygiene')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>  
                 </div>    

                <div class="row">
                      <div class="form-group col-md-6 mb-3">
                            <label for="oral_health" class="form-label">สุขภาพช่องปาก</label>
                            <input type="text" name="oral_health" class="form-control"  
                            value="{{ old('oral_health') }}">
                            @error('oral_health')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>  

                      <div class="form-group col-md-6 mb-3">
                            <label for="injury" class="form-label">การบาดเจ็บ/บาดแผล</label>
                            <input type="text" name="injury" class="form-control" 
                            value="{{ old('injury') }}">
                            @error('injury')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>  
                  </div>

                    <div class="form-group col-md-6 mb-3">
                            <label class="form-label" for="marital_id">สถานะการสมรส : <span class="text-danger">*</span></label>
                            <select name="marital_id" id="marital_id"
                                    class="form-control form-select @error('marital_id') is-invalid @enderror">
                                <option value="">--สถานะการสมรส--</option>
                                @foreach ($maritals as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('marital_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->marital_name }}
                                    </option>
                                @endforeach
                            </select>
                            {{-- ✅ แสดงข้อความ error ภาษาไทย --}}
                            @error('marital_id')
                                <div class="invalid-feedback" id="marital_id-error">{{ $message }}</div>
                            @enderror
                        </div>
                
            <div class="row">
                <div class="form-group col-md-12 mb-3">
                        <label for="relation_parent" class="form-label">ความสัมพันธ์ระหว่างบิดา/มารดา : <span class="text-danger">*</span></label>
                        <textarea name="relation_parent" id="relation_parent"
                                class="form-control bg-white border rounded shadow-sm @error('relation_parent') is-invalid @enderror"
                                rows="3">{{ old('relation_parent') }}</textarea>
                        @error('relation_parent')
                            <div class="invalid-feedback d-block" id="relation_parent-error">{{ $message }}</div>
                        @enderror
                    </div>

                <div class="form-group col-md-12 mb-3">
                        <label for="relation_family" class="form-label">ความสัมพันธ์ระหว่างบุคลลในครอบครัว : <span class="text-danger">*</span></label>
                        <textarea name="relation_family" id="relation_family"
                                class="form-control bg-white border rounded shadow-sm @error('relation_family') is-invalid @enderror"
                                rows="3">{{ old('relation_family') }}</textarea>
                        @error('relation_family')
                            <div class="invalid-feedback d-block" id="relation_family-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                     <div class="form-group col-md-12 mb-3">
                        <label for="relation_child" class="form-label">ความสัมพันธ์ระหว่างเด็กกับบุคคลในครอบครัว : <span class="text-danger">*</span></label>
                        <textarea name="relation_child" id="relation_child"
                                class="form-control bg-white border rounded shadow-sm @error('relation_child') is-invalid @enderror"
                                rows="3">{{ old('relation_child') }}</textarea>
                        @error('relation_child')
                            <div class="invalid-feedback d-block" id="relation_child-error">{{ $message }}</div>
                        @enderror
                    </div>

                     <div class="form-group col-md-12 mb-3">
                                <label for="evidence" class="form-label">เอกสารเพิ่มเติม</label>
                                <input type="text" name="evidence" class="form-control" 
                                value="{{ old('evidence') }}">
                                @error('evidence')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror   
                        </div>  

                     <div class="col-md-12 mb-3 ms-3">
                    <label class="form-label fw-bold text-dark">
                        เอกสารที่เกี่ยวข้อง <span class="text-danger">* (เลือกได้มากกว่า 1 รายการ)</span>
                    </label>
                     <div class="row">
                        @foreach($documents as $document)
                            <div class="col-md-6 col-lg-4">
                                <label class="custom-checkbox">
                                    <input type="checkbox"
                                        name="documents[]"
                                        value="{{ $document->id }}"
                                        id="document{{ $document->id }}">
                                    {{ $document->document_name }}
                                </label>
                            </div>
                        @endforeach
                    </div> 
                </div>



            </div>  <!-- สิ้นสุด card-body -->
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
                      

                <div class="form-group col-md-12 mb-3">
                        <label for="ex_conditions" class="form-label">สภาพที่อยู่อาศัยภายนอก : <span class="text-danger">*</span></label>
                        <textarea name="ex_conditions" id="ex_conditions"
                                class="form-control bg-white border rounded shadow-sm @error('ex_conditions') is-invalid @enderror"
                                rows="3">{{ old('ex_conditions') }}</textarea>
                        @error('ex_conditions')
                            <div class="invalid-feedback d-block" id="ex_conditions-error">{{ $message }}</div>
                        @enderror
                    </div>

                <div class="form-group col-md-12 mb-3">
                        <label for="in_conditions" class="form-label">สภาพที่อยู่อาศัยภายใน : <span class="text-danger">*</span></label>
                        <textarea name="in_conditions" id="in_conditions"
                                class="form-control bg-white border rounded shadow-sm @error('in_conditions') is-invalid @enderror"
                                rows="3">{{ old('in_conditions') }}</textarea>
                        @error('in_conditions')
                            <div class="invalid-feedback d-block" id="in_conditions-error">{{ $message }}</div>
                        @enderror
                    </div>

                <div class="form-group col-md-12 mb-3">
                        <label for="environment" class="form-label">สภาพแวดล้อม : <span class="text-danger">*</span></label>
                        <textarea name="environment" id="environment"
                                class="form-control bg-white border rounded shadow-sm @error('environment') is-invalid @enderror"
                                rows="4">{{ old('environment') }}</textarea>
                        @error('environment')
                            <div class="invalid-feedback d-block" id="environment-error">{{ $message }}</div>
                        @enderror
                </div>

                <div class="form-group col-md-12 mb-3">
                        <label for="cause_problem" class="form-label">สาเหตุที่เข้ารับการสงเคราะห์ : <span class="text-danger">*</span></label>
                        <textarea name="cause_problem" id="cause_problem"
                                class="form-control bg-white border rounded shadow-sm @error('cause_problem') is-invalid @enderror"
                                rows="3">{{ old('cause_problem') }}</textarea>
                        @error('cause_problem')
                            <div class="invalid-feedback d-block" id="cause_problem-error">{{ $message }}</div>
                        @enderror
                </div>

                <div class="form-group col-md-12 mb-3">
                        <label for="need" class="form-label">ความต้องการความช่วยเหลือ : <span class="text-danger">*</span></label>
                        <textarea name="need" id="need"
                                class="form-control bg-white border rounded shadow-sm @error('need') is-invalid @enderror"
                                rows="3">{{ old('need') }}</textarea>
                        @error('need')
                            <div class="invalid-feedback d-block" id="need-error">{{ $message }}</div>
                        @enderror
                </div>

                   <div class="form-group col-md-12 mb-3">
                        <label for="case_history" class="form-label">ประวัติความเป็นมา : <span class="text-danger">*</span></label>
                        <textarea name="case_history" id="case_history"
                                class="form-control bg-white border rounded shadow-sm @error('case_history') is-invalid @enderror"
                                rows="4">{{ old('case_history') }}</textarea>
                        @error('case_history')
                            <div class="invalid-feedback d-block" id="case_history-error">{{ $message }}</div>
                        @enderror
                    </div>

                <div class="form-group col-md-12 mb-3">
                        <label for="information" class="form-label">ข้อเท็จจริงอื่นๆ : <span class="text-danger">*</span></label>
                        <textarea name="information" id="information"
                                class="form-control bg-white border rounded shadow-sm @error('information') is-invalid @enderror"
                                rows="4">{{ old('information') }}</textarea>
                        @error('information')
                            <div class="invalid-feedback d-block" id="information-error">{{ $message }}</div>
                        @enderror
                    </div>

                <div class="form-group col-md-12 mb-3">
                        <label for="diagnosis" class="form-label">การวินิจฉัยปัญหา : <span class="text-danger">*</span></label>
                        <textarea name="diagnosis" id="diagnosis"
                                class="form-control bg-white border rounded shadow-sm @error('diagnosis') is-invalid @enderror"
                                rows="4">{{ old('diagnosis') }}</textarea>
                        @error('diagnosis')
                            <div class="invalid-feedback d-block" id="diagnosis-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="form-group col-md-4 mb-3">
                                <label for="receive_date" class="form-label">วันที่รับเข้า: <span class="text-danger">*</span></label>
                                <input type="date" name="receive_date" id="receive_date"
                                    class="form-control @error('receive_date') is-invalid @enderror"
                                    value="{{ old('receive_date') }}">
                                @error('receive_date')
                                    <small class="text-danger" id="receive_date-error">{{ $message }}</small>
                                @enderror
                            </div>

                        <div class="form-group col-md-8 mb-3">
                                    <label for="recorder" class="form-label">ชื่อผู้บันทึก: <span class="text-danger">*</span></label>
                                    <input type="text" name="recorder" id="recorder"
                                        class="form-control @error('recorder') is-invalid @enderror"
                                        value="{{ old('recorder') }}">
                                    @error('recorder')
                                        <small class="text-danger" id="recorder-error">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="text-start">
                                <button type="submit" class="btn btn-success">บันทึกข้อมูล</button>
                                </div>
                        </div>                      
                    </div>
                </div>
            </div> <!-- สิ้นสุด Card ฝั่งขวา -->
        </div> <!-- สิ้นสุด div class="row" -->
                </form>
            </div>
            
  <!-- ประวัติการรักษาพยาบาล -->
       <script>
    document.addEventListener('DOMContentLoaded', function () {
    const yes = document.getElementById('sickYes');
    const no = document.getElementById('sickNo');
    const detail = document.getElementById('sickDetailGroup');
    const detailField = document.getElementById('sick_detail');

    function toggleDetail() {
        if (yes.checked) {
            detail.style.display = '';
            detailField.setAttribute('required', 'required');
        } else {
            detail.style.display = 'none';
            detailField.removeAttribute('required');
        }
    }

    yes.addEventListener('change', toggleDetail);
    no.addEventListener('change', toggleDetail);
    toggleDetail(); // init on load
});
</script>

{{-- JavaScript สําหรับการตรวจสอบข้อมูล --}}
        <script>
        document.querySelectorAll('input[name="sick"]').forEach(function(radio) {
            radio.addEventListener('change', function() {
                const errorMsg = document.getElementById('sick-error');
                if (errorMsg) {
                    errorMsg.remove(); // ลบข้อความ error ทันที
                }
                // เอา class is-invalid ออกด้วย
                document.querySelectorAll('input[name="sick"]').forEach(function(r) {
                    r.classList.remove('is-invalid');
                });
            });
        });
        document.getElementById('date').addEventListener('input', function() {
            const errorMsg = document.getElementById('date-error');
            if (errorMsg) errorMsg.remove();
            this.classList.remove('is-invalid');
        });
        document.getElementById('receive_date').addEventListener('input', function() {
            const errorMsg = document.getElementById('receive_date-error');
            if (errorMsg) errorMsg.remove();
            this.classList.remove('is-invalid');
        });

        document.getElementById('recorder').addEventListener('input', function() {
            const errorMsg = document.getElementById('recorder-error');
            if (errorMsg) errorMsg.remove();
            this.classList.remove('is-invalid');
        });

        document.getElementById('fact_name').addEventListener('input', function() {
            const errorMsg = document.getElementById('fact_name-error');
            if (errorMsg) errorMsg.remove(); // ลบข้อความ error ทันที
            this.classList.remove('is-invalid'); // ลบกรอบแดง
        });

        document.getElementById('case_history').addEventListener('input', function() {
            const errorMsg = document.getElementById('case_history-error');
            if (errorMsg) errorMsg.remove(); // ลบข้อความ error ทันทีเมื่อพิมพ์
            this.classList.remove('is-invalid'); // ลบกรอบแดง
});
        document.getElementById('marital_id').addEventListener('input', function() {
            const errorMsg = document.getElementById('marital_id-error');
            if (errorMsg) errorMsg.remove(); // ลบข้อความ error ทันทีเมื่อพิมพ์
            this.classList.remove('is-invalid'); // ลบกรอบแดง
        });

        </script>
 {{-- JavaScript สําหรับการตรวจสอบข้อมูล --}}
      


@endsection

        





