@extends('admin_client.admin_client')
@section('content')

<div class="container-fluid mt-2">
    <!-- ฟอร์ม CaseOutside -->
    <div class="card shadow-sm border-0 w-100 mb-0">
        <!-- Header พร้อมปุ่ม toggle -->
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="mb-0 fw-bold">
                <i class="bi bi-people-fill me-1"></i> การติดตามเด็กที่พักอาศัยภายนอก
            </h6>
            <button type="button" class="btn btn-sm btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#createCaseOutsideModal">
                <i class="bi bi-plus-circle me-1"></i> เพิ่มข้อมูล
            </button>
        </div>

        {{-- ข้อมูล client --}}
  <div class="card mb-1 shadow-sm">
    <div class="card-body">
      <div class="row mb-2">
        <div class="col-12 col-md-8">
          <p class="mb-1 d-flex align-items-center flex-wrap">
            <i class="bi bi-person-fill me-2 text-primary"></i>
            <span class="fw-bold">ชื่อ-สกุล :</span>
            <span class="ms-2">{{ $client->fullname ?? '-' }}</span>
            <span class="ms-4">
              <i class="bi bi-calendar-heart me-2 text-success"></i>
              <span class="fw-bold">อายุ :</span> {{ $client->age ?? '-' }} ปี
            </span>
          </p>
        </div>
      </div>
    </div>
  </div>


        @if($caseoutsides->isNotEmpty())
        <div class="card mt-1 shadow-sm border-0 me-2 ms-2">
            <div class="card-body p-2">
                <div class="table-responsive">
    <table id="datatable-caseoutside" class="table table-sm table-striped table-hover align-middle w-100 mb-0">
        <thead class="table-primary text-center small">
         <tr>
            <th>วันที่ติดตาม</th>
            <th style="width:8%">ครั้งที่</th>
            <th>สาเหตุที่พักภายนอก</th>
            <th>สถานที่พัก</th>
            <th>การดำเนินงาน</th>
            <th>ผลการติดตาม</th>
            <th style="width:15%">จัดการ</th>
        </tr>
    </thead>
    <tbody class="small">
        @foreach ($caseoutsides as $case)
            <tr>
                <td class="text-center">{{ \Carbon\Carbon::parse($case->date)->format('d/m/Y') }}</td>
                <td class="text-center">{{ $case->count }}</td>   <!-- ใช้ count แทนลำดับ -->
                <td>{{ $case->outside->outside_name ?? '-' }}</td>
                <td>{{ $case->dormitory ?? '-' }}</td>
                <td>{{ $case->follo_no }}</td>
                <td>{{ $case->results ?? '-' }}</td>
                <td class="text-center">
                    <div class="d-flex justify-content-center gap-1">
                        <button type="button" class="btn btn-sm btn-warning"
                                data-bs-toggle="modal"
                                data-bs-target="#editCaseOutsideModal{{ $case->id }}">
                            <i class="bi bi-pencil-square"></i> แก้ไข
                        </button>

                        <form id="delete-form-caseoutside-{{ $case->id }}" 
                              action="{{ route('case_outside.delete', $case->id) }}" 
                              method="POST" class="d-inline">
                            @csrf 
                            @method('DELETE')
                            <button type="button" class="btn btn-sm btn-danger"
                                    onclick="confirmDelete('delete-form-caseoutside-{{ $case->id }}', 'คุณต้องการลบข้อมูลการติดตามนี้ใช่หรือไม่')">
                                <i class="bi bi-trash"></i> ลบ
                            </button>
                        </form>
                    </div>
                </td>
            </tr>

<!-- ✅ Modal Edit ต้องอยู่ใน loop -->
  <div class="modal fade" id="editCaseOutsideModal{{ $case->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content shadow-sm border-0">
        <div class="modal-header bg-warning bg-opacity-25">
          <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-1"></i> แก้ไขข้อมูลการติดตาม</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <form action="{{ route('case_outside.update',$case->id) }}" method="POST">
            @csrf @method('PUT')
            <input type="hidden" name="client_id" value="{{ $client->id }}">

            <div class="row mb-2">
              <div class="col-12 col-md-4">
                <label class="form-label fw-bold">วันที่ติดตาม</label>
                <!-- ✅ ใช้ format Y-m-d -->
                <input type="date" name="date"
                       value="{{ \Carbon\Carbon::parse($case->date)->format('Y-m-d') }}"
                       class="form-control form-control-sm" required>
              </div>
              <div class="col-12 col-md-6">
                <label class="form-label fw-bold">สาเหตุที่พักอาศัยอยู่ภายนอก</label>
                <select name="outside_id" class="form-select form-select-sm" required>
                  @foreach($outside as $o)
                    <option value="{{ $o->id }}" {{ $case->outside_id == $o->id ? 'selected' : '' }}>
                      {{ $o->outside_name }}
                    </option>
                  @endforeach
                </select>
              </div>
              <div class="col-12 col-md-12 mt-2">
                <label class="form-label fw-bold">สถานที่พัก</label>
                <input type="text" name="dormitory" value="{{ $case->dormitory }}" class="form-control form-control-sm">
              </div>
            </div>

            <div class="mb-2">
              <label class="form-label fw-bold">การดำเนินงาน</label><br>
              @foreach(['หน่วยงานไปเอง','โทรศัพท์','จดหมาย'] as $option)
                <div class="form-check form-check-inline">
                  <!-- ✅ เพิ่ม required -->
                  <input class="form-check-input" type="radio" name="follo_no"
                         value="{{ $option }}" {{ $case->follo_no == $option ? 'checked' : '' }} required>
                  <label class="form-check-label">{{ $option }}</label>
                </div>
              @endforeach
            </div>

            <div class="mb-2">
              <label class="form-label fw-bold">ผลการติดตาม</label>
              <textarea name="results" class="form-control form-control-sm">{{ $case->results }}</textarea>
            </div>

            <div class="mb-2">
              <label class="form-label fw-bold">ผู้ติดตาม</label>
              <input type="text" name="teacher" value="{{ $case->teacher }}" class="form-control form-control-sm">
            </div>

            <div class="mb-2">
              <label class="form-label fw-bold">หมายเหตุ</label>
              <textarea name="remerk" class="form-control form-control-sm">{{ $case->remerk }}</textarea>
            </div>

            <div class="d-flex justify-content-end gap-2">
              <button type="submit" class="btn btn-success btn-sm">
                <i class="bi bi-save me-1"></i> บันทึกการแก้ไข
              </button>
              <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                <i class="bi bi-x-circle me-1"></i> ปิด
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!--สิ้นสุด ✅ Modal Edit ต้องอยู่ใน loop -->
                            @endforeach
                    </tbody>
                </tbody>
            </table>
         </div>
    </div>
 </div>
@else
    <!-- ✅ กรณีไม่มีข้อมูล -->
    <div class="alert alert-info text-center">
        ยังไม่มีข้อมูลการติดตาม
    </div>
@endif
    </div>
</div>
<!-- Modal เพิ่มข้อมูล CaseOutside -->
<div class="modal fade" id="createCaseOutsideModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content shadow-sm border-0">
      <div class="modal-header bg-primary bg-opacity-25">
        <h5 class="modal-title fw-bold">
          <i class="bi bi-plus-circle me-1"></i> เพิ่มข้อมูลการติดตาม
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('case_outside.store') }}" method="POST">
          @csrf
          <input type="hidden" name="client_id" value="{{ $client->id }}">

          <div class="row mb-2">
            <div class="col-12 col-md-4">
              <label class="form-label fw-bold">วันที่ติดตาม</label>
              <input type="date" name="date" class="form-control form-control-sm" required>
            </div>
            <div class="col-12 col-md-6">
              <label class="form-label fw-bold">สาเหตุที่พักอาศัยอยู่ภายนอก</label>
              <select name="outside_id" class="form-select form-select-sm" required>
                <option value="">-- เลือกสาเหตุ --</option>
                @foreach($outside as $o)
                  <option value="{{ $o->id }}">{{ $o->outside_name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-12 col-md-12 mt-2">
              <label class="form-label fw-bold">สถานที่พัก</label>
              <input type="text" name="dormitory" class="form-control form-control-sm">
            </div>
          </div>

          <div class="mb-2">
            <label class="form-label fw-bold">การดำเนินงาน</label><br>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="follo_no" value="หน่วยงานไปเอง" id="follo_self">
              <label class="form-check-label" for="follo_self">หน่วยงานไปเอง</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="follo_no" value="โทรศัพท์" id="follo_phone">
              <label class="form-check-label" for="follo_phone">โทรศัพท์</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="follo_no" value="จดหมาย" id="follo_letter">
              <label class="form-check-label" for="follo_letter">จดหมาย</label>
            </div>
          </div>

          <div class="mb-2 mt-2">
            <label class="form-label fw-bold">ผลการติดตาม</label>
            <textarea name="results" class="form-control form-control-sm" rows="2"></textarea>
          </div>

          <div class="row mb-2 mt-2">
            <div class="col-12 col-md-6">
              <label class="form-label fw-bold">ผู้ติดตาม</label>
              <input type="text" name="teacher" class="form-control form-control-sm">
            </div>
            <div class="col-12 col-md-12 mt-2">
              <label class="form-label fw-bold">หมายเหตุ</label>
              <textarea name="remerk" class="form-control form-control-sm" rows="2"></textarea>
            </div>
          </div>

          <div class="d-flex justify-content-end gap-2">
            <button type="submit" class="btn btn-success btn-sm">
              <i class="bi bi-save me-1"></i> บันทึกข้อมูล
            </button>
            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
              <i class="bi bi-x-circle me-1"></i> ปิด
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection