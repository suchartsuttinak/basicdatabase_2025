@extends('admin_client.admin_client')
@section('content')


@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

 
   <div class="d-flex justify-content-end">
  <div class="container-fluid">


  <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
    <div class="flex-grow-1">
      <h5 class="fs-18 fw-semibold m-0">บักทึกการสอบข้อเท็จจริงเบื้องต้น</h5>
    </div>
    <div class="text-end">
      <ol class="breadcrumb m-0 py-0">
        <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
        <li class="breadcrumb-item active">Form Validation</li>
      </ol>
    </div>
  </div>

  <!-- Form Validation -->
  <div class="row">
    <div class="col-xl-12">
      <div class="card">
       

        <div class="card-body">
          <form action="{{ route('factfinding.update', $client->id) }}" method="POST" class="row g-3">
            @csrf
            <!-- ส่ง id ไปด้วย -->
            <input type="hidden" name="client_id" value="{{$client->id}}">
          

                <div class="row pt-4">
                 <div class="form-group col-md-2 mb-3">
                        <label for="date" class="form-label">วันที่บันทึก <span class="text-danger">*</span></label>
                        <input type="date" 
                            name="date" 
                            id="date" 
                            class="form-control @error('date') is-invalid @enderror"
                            value="{{ old('date', isset($factFinding) ? $factFinding->date : '') }}">
                        @error('date')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                      <div class="form-group col-md-3 mb-3">
                        <label for="fact_name" class="form-label">ชื่อผู้นำส่ง</label>
                        <input type="text" name="fact_name" id="fact_name"
                            class="form-control @error('fact_name') is-invalid @enderror"
                            value="{{ old('fact_name', isset($factFinding) ? $factFinding->fact_name : '') }}">
                        @error('fact_name')
                            <div class="invalid-feedback" id="fact_name-error">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <div class="row">
                  
                    <div class="form-group col-md-4 mb-3">
                        <label for="appearance" class="form-label">รูปพรรณสัณฐาน</label>
                        <input type="text" name="appearance" class="form-control" required
                            value="{{ old('appearance', isset($factFinding) ? $factFinding->appearance : '') }}">
                        @error('appearance')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-4 mb-3">
                        <label for="skin" class="form-label">สีผิว</label>
                        <input type="text" name="skin" class="form-control" required
                            value="{{ old('skin', isset($factFinding) ? $factFinding->skin : '') }}">
                        @error('skin')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-4 mb-3">
                        <label for="scar" class="form-label">ตำหนิ/แผลเป็น</label>
                        <input type="text" name="scar" class="form-control" required
                            value="{{ old('scar', isset($factFinding) ? $factFinding->scar : '') }}">
                        @error('scar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                    <div class="row">
                        <!-- ลักษณะความพิการ -->
                        <div class="form-group col-md-4 mb-3">
                            <label for="disability" class="form-label">ลักษณะความพิการ</label>
                            <input type="text" name="disability" class="form-control" 
                            value="{{ old('disability', isset($factFinding) ? $factFinding->disability : '') }}">
                            @error('disability')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                  <!-- Sick radio button -->
                           <div class="form-group col-md-2 mb-3">
                                <label class="form-label d-block">ประวัติการเจ็บป่วย : <span class="text-danger">*</span></label>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input @error('sick') is-invalid @enderror" 
                                        type="radio" 
                                        name="sick" 
                                        id="sickYes"
                                        value="1"
                                        {{ old('sick', isset($factFinding) ? $factFinding->sick : '') == 1 ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="sickYes">มี</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input @error('sick') is-invalid @enderror" 
                                        type="radio" 
                                        name="sick" 
                                        id="sickNo"
                                        value="0"
                                        {{ old('sick', isset($factFinding) ? $factFinding->sick : '') == 0 ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="sickNo">ไม่มี</label>
                                </div>

                                @error('sick')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- รายละเอียดการเจ็บป่วย -->
                        <div class="form-group col-md-6 mb-3" id="sickDetailGroup"
                                style="{{ old('sick', isset($factFinding) ? $factFinding->sick : '') == 1 ? '' : 'display:none;' }}">
                                <label for="sick_detail" class="form-label text-start">รายละเอียดการเจ็บป่วย</label>
                                <textarea name="sick_detail" id="sick_detail"
                                        class="form-control"
                                        style="text-align: left; padding-left: 1em; margin: 0;"
                                        rows="2"
                                        {{ old('sick', isset($factFinding) ? $factFinding->sick : '') == 1 ? 'required' : '' }}>{{ old('sick_detail', isset($factFinding) ? $factFinding->sick_detail : '') }}</textarea>
                                @error('sick_detail')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- ประวัติการรักษาพยาบาล -->
                        <div class="form-group col-md-6 mb-3">
                            <label for="treatment" class="form-label">การรักษาพยาบาล</label>
                            <input type="text" name="treatment" class="form-control" required 
                            value="{{ old('treatment', isset($factFinding) ? $factFinding->treatment : '') }}">
                            @error('treatment')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                         <div class="form-group col-md-4 mb-3">
                            <label for="hospital" class="form-label">โรงพยาบาล</label>
                            <input type="text" name="hospital" class="form-control" 
                            value="{{ old('hospital', isset($factFinding) ? $factFinding->hospital : '') }}">
                            @error('hospital')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>      
                 </div>

                  <div class="row">
                       <div class="form-group col-md-2 mb-3">
                            <label for="weight" class="form-label">น้ำหนัก</label>
                            <div class="d-flex align-items-center">
                                <input type="text" name="weight" id="weight" class="form-control" 
                                value="{{ old('weight', isset($factFinding) ? $factFinding->weight : '') }}">
                                <span class="ms-2">กิโลกรัม</span>
                            </div>
                            @error('weight')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                     </div>

                       <div class="form-group col-md-2 mb-3">
                            <label for="height" class="form-label">ส่วนสูง</label>
                            <div class="d-flex align-items-center">
                                <input type="text" name="height" id="height" class="form-control" 
                                value="{{ old('height', isset($factFinding) ? $factFinding->height : '') }}">
                                <span class="ms-2">เซนติเมตร</span>
                            </div>
                            @error('height')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                     </div>

                      <div class="form-group col-md-8 mb-3">
                            <label for="hygiene" class="form-label">ความสะอาดร่างกาย</label>
                            <input type="text" name="hygiene" class="form-control"
                            value="{{ old('hygiene', isset($factFinding) ? $factFinding->hygiene : '') }}">
                            @error('hygiene')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>    

                      <div class="form-group col-md-6 mb-3">
                            <label for="oral_health" class="form-label">สุขภาพช่องปาก</label>
                            <input type="text" name="oral_health" class="form-control"
                            value="{{ old('oral_health', isset($factFinding) ? $factFinding->oral_health : '') }}">
                            @error('oral_health')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>  

                      <div class="form-group col-md-6 mb-3">
                            <label for="injury" class="form-label">การบาดเจ็บ/บาดแผล</label>
                            <input type="text" name="injury" class="form-control"
                            value="{{ old('injury', isset($factFinding) ? $factFinding->injury : '') }}">
                            @error('injury')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>  
                  </div>
                   
                  <div class="row">
                            <div class="form-group col-md-12 mb-3">
                            <label for="case_history" class="form-label text-start">ประวัติความเป็นมา <span class="text-danger">*</span></label>
                            <textarea name="case_history" id="case_history"
                                    class="form-control @error('case_history') is-invalid @enderror"
                                    style="text-align: left; padding-left: 1em; margin: 0;"
                                    rows="2">{{ old('case_history', isset($factFinding) ? $factFinding->case_history : '') }}</textarea>
                            @error('case_history')
                                <div class="invalid-feedback d-block" id="case_history-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-3 mb-3">
                            <label for="recorder" class="form-label">ผู้บันทึก <span class="text-danger">*</span></label>
                            <input type="text" name="recorder" id="recorder"
                                class="form-control @error('recorder') is-invalid @enderror"
                                value="{{ old('recorder', isset($factFinding) ? $factFinding->recorder : '') }}">
                            @error('recorder')
                                <div class="invalid-feedback" id="recorder-error">{{ $message }}</div>
                            @enderror
                        </div>

                         <div class="form-group col-md-3 mb-3">
                            <label for="evidence" class="form-label">เอกสารเพิ่มเติม</label>
                            <input type="text" name="evidence" class="form-control" 
                            value="{{ old('evidence', isset($factFinding) ? $factFinding->evidence : '') }}">
                            @error('evidence')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror   
                        </div>  

                </div>
                            
             <div class="col-md-12 mb-3">
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
                                    id="document{{ $document->id }}"
                                    {{ in_array($document->id, old('documents', $selectedDocs ?? [])) ? 'checked' : '' }}>
                                {{ $document->document_name }}
                            </label>
                        </div>
                    @endforeach
                </div>
         </div>
            <!-- ปุ่ม -->
            <div class="col-12">
              <button class="btn btn-primary btn-lg px-4 py-2  fw-semibold shadow-sm" type="submit">
                บันทึก
              </button>
            </div>
          </form>
        </div> <!-- end card-body -->
      </div> <!-- end card -->
    </div> <!-- end col -->
  </div> <!-- end row -->
</div> <!-- end container-fluid -->
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


        </script>
 {{-- JavaScript สําหรับการตรวจสอบข้อมูล --}}


@endsection