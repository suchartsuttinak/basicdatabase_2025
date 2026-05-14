@extends('admin.admin_master')
@section('admin')

                <div class="container-fluid py-3">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-header bg-white border-0 px-4 py-3">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                <div>
                                    <h4 class="mb-1 fw-bold">
                                        <i class="bi bi-plus-circle me-2 text-primary"></i>
                                        เพิ่มรายงานการปฏิบัติงาน
                                    </h4>
                                    <div class="text-muted small">
                                        บันทึกรายละเอียดการดำเนินงานประจำวัน
                                    </div>
                                </div>

                                <a href="{{ route('operations.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                                    <i class="bi bi-arrow-left me-1"></i> กลับหน้ารายการ
                                </a>
                            </div>
                        </div>

                        <div class="card-body px-4 py-4">
                            <form action="{{ route('operations.store') }}" method="POST">
                                @csrf

                                <div class="row g-4">
                                    <div class="col-lg-4">
                    <label class="form-label fw-semibold">
                        วันที่ <span class="text-danger">*</span>
                    </label>

                    @php
                        $isAdmin = auth()->user()->isAdmin();
                    @endphp

                    <input type="date"
                        name="operation_date"
                        value="{{ old('operation_date', now()->format('Y-m-d')) }}"
                        max="{{ now()->format('Y-m-d') }}"
                        @unless($isAdmin)
                            min="{{ now()->subDay()->format('Y-m-d') }}"
                        @endunless
                        class="form-control rounded-3 @error('operation_date') is-invalid @enderror">

                    @error('operation_date')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                    @unless($isAdmin)
                        <div class="form-text text-muted">
                            สามารถเลือกได้เฉพาะวันนี้ หรือย้อนหลังไม่เกิน 1 วัน
                        </div>
                    @endunless
                </div>

                {{-- <div class="col-lg-4">
                    <label class="form-label fw-semibold">ครั้งที่ <span class="text-danger">*</span></label>
                    <input type="number" min="1" name="sequence_no"
                        value="{{ old('sequence_no', 1) }}"
                        class="form-control rounded-3 @error('sequence_no') is-invalid @enderror"
                        placeholder="เช่น 1">
                    @error('sequence_no')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div> --}}

                    <div class="col-lg-4">
                        <label class="form-label fw-semibold">ผู้ดำเนินงาน</label>
                        <input type="text" class="form-control rounded-3 bg-light"
                               value="{{ auth()->user()->name }}" readonly>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">เรื่องที่ดำเนินงาน <span class="text-danger">*</span></label>
                        <input type="text" name="subject"
                               value="{{ old('subject') }}"
                               class="form-control rounded-3 @error('subject') is-invalid @enderror"
                               placeholder="ระบุเรื่องที่ดำเนินงาน">
                        @error('subject')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">ผลการดำเนินงาน</label>
                        <textarea name="result" rows="4"
                                  class="form-control rounded-3 @error('result') is-invalid @enderror"
                                  placeholder="สรุปผลการดำเนินงาน">{{ old('result') }}</textarea>
                        @error('result')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">หมายเหตุ</label>
                        <textarea name="remark" rows="3"
                                  class="form-control rounded-3 @error('remark') is-invalid @enderror"
                                  placeholder="รายละเอียดเพิ่มเติม (ถ้ามี)">{{ old('remark') }}</textarea>
                        @error('remark')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 pt-2">
                        <div class="d-flex flex-wrap gap-2">
                            <button type="submit" class="btn btn-primary rounded-pill px-4">
                                <i class="bi bi-save me-1"></i> บันทึกข้อมูล
                            </button>

                            <a href="{{ route('operations.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                                ยกเลิก
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection