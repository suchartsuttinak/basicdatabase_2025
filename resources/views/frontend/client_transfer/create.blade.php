@extends('admin.admin_master')

@section('admin')
<div class="container-fluid py-4">

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-white border-0">
            <h4 class="mb-1 fw-bold">ย้ายเคสผู้รับบริการ</h4>
            <div class="text-muted small">เลือกโปรเจ็คปลายทางที่ต้องการย้ายเคสไปดูแล</div>
        </div>

        <div class="card-body">

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="alert alert-light border mb-4">
                <div><strong>ชื่อ-นามสกุล:</strong> {{ $client->first_name }} {{ $client->last_name }}</div>
                <div><strong>เลขทะเบียน:</strong> {{ $client->register_number ?? '-' }}</div>
                <div><strong>โปรเจ็คปัจจุบัน:</strong> {{ optional($client->project)->project_name ?? '-' }}</div>
            </div>

            <form method="POST" action="{{ route('client.transfer.store') }}">
                @csrf

                <input type="hidden" name="client_id" value="{{ $client->id }}">

                <div class="mb-3">
                    <label class="form-label fw-semibold">โปรเจ็คปลายทาง <span class="text-danger">*</span></label>
                    <select name="to_project_id" class="form-select @error('to_project_id') is-invalid @enderror" required>
                        <option value="">-- เลือกโปรเจ็คปลายทาง --</option>
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}" {{ old('to_project_id') == $project->id ? 'selected' : '' }}>
                                {{ $project->project_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('to_project_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">หมายเหตุ</label>
                    <textarea name="remark" rows="4" class="form-control @error('remark') is-invalid @enderror"
                        placeholder="ระบุเหตุผลหรือรายละเอียดการย้ายเคส">{{ old('remark') }}</textarea>
                    @error('remark')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('client.show') }}" class="btn btn-light border">
                        ย้อนกลับ
                    </a>

                    <button type="submit" class="btn btn-primary">
                        บันทึกคำขอย้ายเคส
                    </button>
                </div>
            </form>

        </div>
    </div>

</div>
@endsection