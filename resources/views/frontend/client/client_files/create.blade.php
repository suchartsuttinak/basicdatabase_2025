@extends('admin_client.admin_client')

@section('content')
    <div class="card shadow-sm mb-4">
        <div class="card-body d-flex align-items-center">
            <i class="bi bi-file-earmark-plus text-success me-3" style="font-size: 1.5rem;"></i>
            <h5 class="mb-0">เพิ่มไฟล์สำหรับ <span class="text-primary">{{ $client->fullname }}</span></h5>
        </div>
    </div>

    {{-- แสดง error validation --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('client_files.store', $client->id) }}" method="POST" enctype="multipart/form-data" class="card p-3 shadow-sm">
        @csrf
        <div class="mb-3">
            <label for="file_type" class="form-label">ประเภทเอกสาร</label>
            <select name="file_type" class="form-select" required>
                @foreach($fileTypes as $key => $label)
                    <option value="{{ $key }}">{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="file" class="form-label">ไฟล์ PDF</label>
            <input type="file" name="file" class="form-control" required>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success">
                <i class="bi bi-save"></i> บันทึก
            </button>
            <a href="{{ route('client_files.index', $client->id) }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left-circle"></i> กลับหน้าหลัก
            </a>
        </div>
    </form>
@endsection