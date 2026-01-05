@extends('admin_client.admin_client')
@section('content')

<h5 class="mb-3 text-center fw-bold mt-4" style="color:#0d47a1;">
    เพิ่มข้อมูลการออกจากสถานสงเคราะห์ของ {{ $client->fullname }}
</h5>

<form action="{{ route('escape.store') }}" method="POST" class="card p-3 shadow-sm">
    @csrf
    <input type="hidden" name="client_id" value="{{ $client->id }}">

    <div class="row g-3">
        <div class="col-md-3">
            <label class="form-label">วันที่ออก</label>
            <input type="date" name="retire_date" class="form-control" required>
        </div>

        <div class="col-md-4">
            <label class="form-label">ประเภทการออกจากหน่วยงาน</label>
            <select name="retire_id" class="form-select" required>
                <option value="">-- เลือก --</option>
                @foreach($retires as $ret)
                    <option value="{{ $ret->id }}">{{ $ret->retire_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-12">
            <label class="form-label">เรื่องราว/สาเหตุ</label>
            <textarea name="stories" class="form-control" rows="3" placeholder="บันทึกสาเหตุหรือรายละเอียดเพิ่มเติม"></textarea>
        </div>
    </div>

    <div class="mt-3 d-flex justify-content-between">
        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left-circle me-1"></i> ย้อนกลับ
        </a>
        <button type="submit" class="btn btn-success">
            <i class="bi bi-save me-1"></i> บันทึกข้อมูล
        </button>
    </div>
</form>

@endsection