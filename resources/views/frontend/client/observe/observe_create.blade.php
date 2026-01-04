@extends('admin_client.admin_client')

@section('content')
            <!-- หัวฟอร์ม -->
     <div class="card mt-2 shadow-sm border-0 me-2 ms-2">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold">
                <i class="bi bi-clipboard-check me-1 text-primary"></i> 
                ข้อมูลการบันทึก/แก้ไขพฤติกรรมของ {{ $client->name }}
                </h6>

            <div class="btn-group">
            <!-- ปุ่มเปิด Modal -->
           <button type="button"
    class="btn btn-sm rounded-pill shadow-sm me-2 
           {{ isset($observe) ? 'btn-warning' : 'btn-success' }}"
    data-bs-toggle="modal"
    data-bs-target="#observeModal">
    <i class="bi {{ isset($observe) ? 'bi-pencil-square' : 'bi-plus-circle' }} me-1"></i>
    {{ isset($observe) ? 'แก้ไขข้อมูล' : 'เพิ่มข้อมูล' }}
</button>
            <!-- ปุ่มไปหน้า observe.create -->
            <button type="button" class="btn btn-sm btn-outline-danger rounded-pill shadow-sm"
                    onclick="window.location.href='{{ route('observe.create', ['client_id' => $client->id]) }}'">
                <i class="bi bi-x-circle me-1"></i> ปิดฟอร์ม
            </button>
            </div>
      </div>

            <!-- ตารางแสดงผล -->
         @if($observes->count() > 0)
            <div class="card mt-2 shadow-sm border-0">
                <div class="card-body pt-0">
                    <table class="table table-striped table-hover align-middle">
                                <thead class="table-primary">
                                    <tr>
                                        <th>วันที่</th>
                                        <th>พฤติกรรมที่พบเห็น</th>
                                        <th>ผลลัพธ์</th>
                                        <th>ผู้บันทึก</th>
                                        <th>การติดตามผล</th>
                                        <th class="text-center">จัดการ</th>
                                    </tr>
                                </thead>
                        <tbody>
                            @forelse($observes as $obs)
                    <tr>
                        <td>{{ $obs->date }}</td>
                        <td>{{ $obs->behavior }}</td>
                        <td>{{ $obs->result }}</td>
                        <td>{{ $obs->recorder }}</td>
                        <td>
                            @forelse($obs->followups as $f)
                                <div>
                                    {{ $f->followup_date }} (ครั้งที่ {{ $f->followup_count }}) -
                                    {{ $f->followup_result }}
                                </div>
                            @empty
                                <span class="text-muted">ยังไม่มีการติดตามผล</span>
                            @endforelse
                        </td>

                        <td class="text-center">
                            <!-- ปุ่มแก้ไขพฤติกรรม -->
                            <a href="{{ route('observe.edit', $obs->id) }}" class="btn btn-sm btn-warning">แก้ไข</a>

                           
                          <!-- ปุ่มลบพฤติกรรม -->
                         <form id="delete-form-observe-{{ $obs->id }}" 
                                action="{{ route('observe.delete', $obs->id) }}" 
                                method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="button" class="btn btn-sm btn-danger"
                                        onclick="confirmDelete('delete-form-observe-{{ $obs->id }}')">
                                    ลบ
                                </button>
                            </form>
                            <!-- ปุ่มติดตามผล -->
                            <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal"
                                data-bs-target="#addFollowupModal{{ $obs->id }}">
                                ติดตามผล
                            </button>

                            <!-- Modal สำหรับเพิ่มการติดตามผล -->
                            <div class="modal fade" id="addFollowupModal{{ $obs->id }}" tabindex="-1"
                                aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content border-0 shadow-sm">

                            <!-- Header -->
                            <div class="modal-header bg-info text-white">
                                <h5 class="modal-title fw-bold">
                                    <i class="bi bi-plus-circle me-1"></i> เพิ่มการติดตามผล (พฤติกรรมวันที่
                                    {{ $obs->date }})
                                </h5>
                                <button type="button" class="btn-close btn-close-white"
                                    data-bs-dismiss="modal"></button>
                            </div>

                <!-- Body -->
            <div class="modal-body">
                <form action="{{ route('followup.store') }}" method="POST" class="text-start">
                    @csrf
                    <input type="hidden" name="observe_id" value="{{ $obs->id }}">

                    <!-- วันที่ติดตาม -->
                    <div class="mb-3 col-6 text-start">
                        <label class="form-label fw-bold text-start d-block">วันที่ติดตาม</label>
                        <input type="date" name="followup_date"
                            class="form-control form-control-sm text-start" required>
                    </div>

                    <!-- ครั้งที่ -->
                    <div class="mb-3 col-6 text-start">
                        <label class="form-label fw-bold text-start d-block">ครั้งที่</label>
                        <input type="number" name="followup_count"
                            class="form-control form-control-sm text-start" min="1" required>
                    </div>

                    <!-- การดำเนินการ -->
                    <div class="mb-3 text-start">
                        <label class="form-label fw-bold text-start d-block">การดำเนินการ</label>
                        <textarea name="followup_action" class="form-control form-control-sm text-start" rows="2"></textarea>
                    </div>

                    <!-- ผลลัพธ์ -->
                    <div class="mb-3 text-start">
                        <label class="form-label fw-bold text-start d-block">ผลลัพธ์</label>
                        <textarea name="followup_result" class="form-control form-control-sm text-start" rows="2"></textarea>
                    </div>

                    <!-- Footer -->
                    <div class="d-flex justify-content-end gap-2 mt-3">
                        <button type="submit" class="btn btn-success btn-sm">
                            <i class="bi bi-save me-1"></i> บันทึกการติดตามผล
                        </button>
                        <button type="button" class="btn btn-secondary btn-sm"
                                data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-1"></i> ปิด
                        </button>
                    </div>
                </form>
            </div>
                </div>
                    </div>
                </div>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="6" class="text-center text-muted">ยังไม่มีบันทึกพฤติกรรม</td>
        </tr>
    @endforelse
                </tbody>
            </table>
        </div>
    </div>
   @else
    <!-- กรณีไม่มีข้อมูล -->
    <div class="alert alert-secondary text-center mt-2">
        <i class="bi bi-info-circle me-1"></i> ยังไม่มีบันทึกพฤติกรรม
    </div>
@endif
 </div>
 
<!-- Modal: ฟอร์มบันทึก/แก้ไขพฤติกรรม -->
<div class="modal fade" id="observeModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content border-0 shadow-sm">
      
      <!-- Header -->
      <div class="modal-header bg-light border-bottom">
        <h6 class="modal-title fw-bold text-dark">
          <i class="bi bi-pencil-square me-2 text-secondary"></i> แบบฟอร์มบันทึก/แก้ไขพฤติกรรม
        </h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Body -->
      <div class="modal-body">

        <!-- Error Alert -->
        @if ($errors->any())
          <div class="alert alert-danger py-2 mb-3">
            <h6 class="fw-bold mb-2">พบข้อผิดพลาด:</h6>
            <ul class="mb-0 small">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <!-- ฟอร์มบันทึกพฤติกรรม -->
        <form action="{{ isset($observe) ? route('observe.update', $observe->id) : route('observe.store') }}"
              method="POST" class="needs-validation" novalidate>
          @csrf
          @if (isset($observe))
            @method('PUT')
          @endif

          <input type="hidden" name="client_id" value="{{ $client->id }}">

          <!-- วันที่ -->
          <div class="row mb-3">
            <div class="col-md-3">
              <label for="date" class="form-label fw-bold text-start">วันที่เกิดเหตุ</label>
              <input type="date" name="date" id="date"
                     class="form-control form-control-sm py-2 text-start"
                     value="{{ old('date', $observe->date ?? '') }}" required>
            </div>
              <div class="col-md-5">
              <label for="misbehavior_id" class="form-label fw-bold text-start">สภาพปัญหา</label>
              <select name="misbehavior_id" id="misbehavior_id"
                      class="form-select form-select-sm py-2 text-start" required>
                <option value="">-- เลือกสภาพปัญหา --</option>
                @foreach ($misbehaviors as $m)
                  <option value="{{ $m->id }}"
                      {{ old('misbehavior_id', $observe->misbehavior_id ?? '') == $m->id ? 'selected' : '' }}>
                      {{ $m->misbehavior_name }}
                  </option>
                @endforeach
              </select>
            </div>
          </div>

          <!-- พฤติกรรม/สาเหตุ/วิธีแก้ไข -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="behavior" class="form-label fw-bold text-start">ความผิดปกติที่พบเห็น</label>
              <textarea name="behavior" id="behavior"
                        class="form-control form-control-sm py-2 text-start" rows="2">{{ old('behavior', $observe->behavior ?? '') }}</textarea>
            </div>
            <div class="col-md-6">
              <label for="cause" class="form-label fw-bold text-start">สาเหตุ</label>
              <textarea name="cause" id="cause"
                        class="form-control form-control-sm py-2 text-start" rows="2">{{ old('cause', $observe->cause ?? '') }}</textarea>
            </div>
            <div class="col-md-6">
              <label for="solution" class="form-label fw-bold text-start">แนวทางแก้ไข</label>
              <textarea name="solution" id="solution"
                        class="form-control form-control-sm py-2 text-start" rows="2">{{ old('solution', $observe->solution ?? '') }}</textarea>
            </div>
            <div class="col-md-6">
              <label for="action" class="form-label fw-bold text-start">การดำเนินการ</label>
              <textarea name="action" id="action"
                        class="form-control form-control-sm py-2 text-start" rows="2">{{ old('action', $observe->action ?? '') }}</textarea>
            </div>
          </div>

          <!-- อุปสรรค/ผลลัพธ์ -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="obstacles" class="form-label fw-bold text-start">ปัญหา/อุปสรรค</label>
              <textarea name="obstacles" id="obstacles"
                        class="form-control form-control-sm py-2 text-start" rows="2">{{ old('obstacles', $observe->obstacles ?? '') }}</textarea>
            </div>
            <div class="col-md-6">
              <label for="result" class="form-label fw-bold text-start">ผลลัพธ์</label>
              <textarea name="result" id="result"
                        class="form-control form-control-sm py-2 text-start" rows="2">{{ old('result', $observe->result ?? '') }}</textarea>
            </div>
          </div>

          <!-- สภาพปัญหา + ผู้บันทึก + ปุ่ม -->
          <div class="row mb-4 align-items-end">
          
            <div class="col-md-3">
              <label for="record_date" class="form-label fw-bold text-start">วันที่บันทึก</label>
              <input type="date" name="record_date" id="record_date"
                     class="form-control form-control-sm py-2 text-start"
                     value="{{ old('record_date', $observe->record_date ?? '') }}">
            </div>
            <div class="col-md-4">
              <label for="recorder" class="form-label fw-bold text-start">ผู้บันทึก</label>
              <input type="text" name="recorder" id="recorder"
                     class="form-control form-control-sm py-2 text-start"
                     value="{{ old('recorder', $observe->recorder ?? '') }}"
                     placeholder="ชื่อผู้บันทึก">
            </div>
            <div class="col-md-4 d-flex justify-content-end gap-2">
              <button type="submit"
                      class="btn btn-outline-primary btn-sm px-3 py-2 d-inline-flex align-items-center">
                <i class="bi bi-save me-2"></i>
                {{ isset($observe) ? 'อัปเดตข้อมูล' : 'บันทึกข้อมูล' }}
              </button>
              <button type="button" class="btn btn-outline-secondary btn-sm px-3 py-2 d-inline-flex align-items-center"
                      data-bs-dismiss="modal">
                <i class="bi bi-x-circle me-2"></i> ปิด
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

   <!-- ถ้าต้องการใช้ observe เดียว (เช่นหน้าแก้ไข)-->
@if($observe)
    @foreach($observe->followups as $f)
        <button type="button" class="btn btn-sm btn-secondary mt-1"
                data-bs-toggle="modal" data-bs-target="#editFollowupModal{{ $f->id }}">
            แก้ไขติดตามผลครั้งที่ {{ $f->followup_count }}
        </button>

        <!-- Modal สำหรับแก้ไขการติดตามผล -->
        <div class="modal fade" id="editFollowupModal{{ $f->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg">

                    <!-- Header -->
                    <div class="modal-header bg-warning text-dark">
                        <h5 class="modal-title fw-bold">
                            <i class="bi bi-pencil-square me-1"></i> แก้ไขการติดตามผล (ครั้งที่ {{ $f->followup_count }})
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Body -->
                    <div class="modal-body">
                        <!-- ฟอร์มอัปเดต -->
                        <form action="{{ route('followup.update', $f->id) }}" method="POST"
                              class="needs-validation" novalidate>
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="observe_id" value="{{ $observe->id }}">

                            <!-- วันที่ และ ครั้งที่ -->
                            <div class="row mb-3">
                                <div class="col-6 col-md-3">
                                    <label class="form-label fw-bold text-start w-100 small">วันที่ติดตาม</label>
                                    <input type="date" name="followup_date" class="form-control form-control-sm"
                                           value="{{ old('followup_date', $f->followup_date) }}" required>
                                </div>
                                <div class="col-6 col-md-2">
                                    <label class="form-label fw-bold text-start w-100 small">ครั้งที่</label>
                                    <input type="number" name="followup_count"
                                           class="form-control form-control-sm"
                                           min="1"
                                           value="{{ old('followup_count', $f->followup_count) }}"
                                           readonly>
                                </div>
                            </div>

                            <!-- การดำเนินการ -->
                            <div class="mb-3">
                                <label class="form-label fw-bold text-start w-100">การดำเนินการ</label>
                                <textarea name="followup_action" class="form-control form-control-sm" rows="2">{{ old('followup_action', $f->followup_action) }}</textarea>
                            </div>

                            <!-- ผลลัพธ์ -->
                            <div class="mb-3">
                                <label class="form-label fw-bold text-start w-100">ผลลัพธ์</label>
                                <textarea name="followup_result" class="form-control form-control-sm" rows="2">{{ old('followup_result', $f->followup_result) }}</textarea>
                            </div>

                            <!-- Footer -->
                            <div class="modal-footer d-flex justify-content-between">
                                <button type="submit" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil-square me-1"></i> อัปเดตการติดตามผล
                                </button>
                            </div>
                        </form>

                       <!-- ปุ่มลบ -->
                            <div class="d-flex justify-content-end">
                                <form id="delete-form-followup-{{ $f->id }}" 
                                    action="{{ route('followup.delete', $f->id) }}" 
                                    method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-outline-danger btn-sm"
                                            onclick="confirmDelete('delete-form-followup-{{ $f->id }}', 'คุณต้องการลบการติดตามผลนี้ใช่หรือไม่')">
                                        <i class="bi bi-trash me-1"></i> ลบการติดตามผล
                                    </button>
                                </form>
                            </div>
                    </div>

                </div>
            </div>
        </div>
    @endforeach
@endif

@if (isset($observe))
    <div class="card mt-4 shadow-sm">
        <div class="card-header bg-light border-bottom d-flex justify-content-between align-items-center">
            <h6 class="mb-0 fw-bold text-dark">
                <i class="bi bi-list-check me-2 text-secondary"></i> รายการติดตามผล
            </h6>
            <!-- ปุ่มเพิ่มการติดตามผล -->
            <button type="button"
                    class="btn btn-sm btn-outline-primary d-inline-flex align-items-center px-3"
                    data-bs-toggle="modal"
                    data-bs-target="#addFollowupModal{{ $observe->id }}">
                <i class="bi bi-plus-circle me-1"></i> เพิ่มการติดตามผล
            </button>
        </div>
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>วันที่ติดตาม</th>
                        <th>ครั้งที่</th>
                        <th>การดำเนินการ</th>
                        <th>ผลลัพธ์</th>
                        <th class="text-center">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($observe->followups as $f)
                        <tr>
                            <td>{{ $f->followup_date }}</td>
                            <td>{{ $f->followup_count }}</td>
                            <td>{{ $f->followup_action }}</td>
                            <td>{{ $f->followup_result }}</td>
                            <td class="text-center">
                                <!-- ปุ่มแก้ไข เปิด modal -->
                                <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#editFollowupModal{{ $f->id }}">
                                    แก้ไข
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">ยังไม่มีการติดตามผล</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endif

@if (session('success'))
  <div class="alert alert-success text-center fw-bold py-2 mb-3">
    {{ session('success') }}
  </div>
@endif

     
@endsection