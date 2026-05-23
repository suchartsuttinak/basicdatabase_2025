@extends('admin.admin_master')
@section('admin')

<div class="container-fluid py-3">
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-0 px-4 py-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <h4 class="mb-1 fw-bold">
                        <i class="bi bi-pencil-square me-2 text-warning"></i>
                        แก้ไขรายงานการปฏิบัติงาน
                    </h4>
                    <div class="text-muted small">
                        ปรับปรุงข้อมูลรายงานการดำเนินงาน
                    </div>
                </div>

                <a href="{{ route('operations.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                    <i class="bi bi-arrow-left me-1"></i> กลับหน้ารายการ
                </a>
            </div>
        </div>

        <div class="card-body px-4 py-4">
            <form action="{{ route('operations.update', $operation->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-4">
                  <div class="col-lg-4">
            <label class="form-label fw-semibold">
                วันที่
                <span class="text-danger">*</span>
            </label>

            <input
                type="date"
                name="operation_date"
                value="{{ old('operation_date', $operation->operation_date?->format('Y-m-d')) }}"
                class="form-control rounded-3 @error('operation_date') is-invalid @enderror"

                {{ auth()->user()->isAdmin() ? '' : 'readonly disabled' }}
            >

            @if(!auth()->user()->isAdmin())
                <small class="text-muted d-block mt-1">
                    <i class="bi bi-lock-fill me-1"></i>
                    เฉพาะผู้ดูแลระบบเท่านั้นที่สามารถแก้ไขวันที่ได้
                </small>
            @endif

            @error('operation_date')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

                    <div class="col-lg-4">
                        <label class="form-label fw-semibold">ครั้งที่ <span class="text-danger">*</span></label>
                        <input type="number" min="1" name="sequence_no"
                               value="{{ old('sequence_no', $operation->sequence_no) }}"
                               class="form-control rounded-3 @error('sequence_no') is-invalid @enderror">
                        @error('sequence_no')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-lg-4">
                        <label class="form-label fw-semibold">ผู้ดำเนินงาน</label>
                        <input type="text" class="form-control rounded-3 bg-light"
                               value="{{ $operation->user->name ?? auth()->user()->name }}" readonly>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">เรื่องที่ดำเนินงาน <span class="text-danger">*</span></label>
                        <input type="text" name="subject"
                               value="{{ old('subject', $operation->subject) }}"
                               class="form-control rounded-3 @error('subject') is-invalid @enderror">
                        @error('subject')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">ผลการดำเนินงาน</label>
                        <textarea name="result" rows="4"
                                  class="form-control rounded-3 @error('result') is-invalid @enderror">{{ old('result', $operation->result) }}</textarea>
                        @error('result')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">หมายเหตุ</label>
                        <textarea name="remark" rows="3"
                                  class="form-control rounded-3 @error('remark') is-invalid @enderror">{{ old('remark', $operation->remark) }}</textarea>
                        @error('remark')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 pt-2">
                        <div class="d-flex flex-wrap gap-2">
                            <button type="submit" class="btn btn-warning rounded-pill px-4 text-white">
                                <i class="bi bi-save me-1"></i> อัปเดตข้อมูล
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