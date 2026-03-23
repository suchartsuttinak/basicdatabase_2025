@extends('admin_client.admin_client')

@section('content')

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">


    <div class="card shadow-sm mb-4">
       <div class="card-body d-flex align-items-center">
    <i class="bi bi-folder-fill text-primary me-3" style="font-size: 1.5rem;"></i>
    <span class="fs-5 fw-bold mb-0">
        ไฟล์เอกสารของ <span class="text-success">{{ $client->fullname }}</span>
    </span>
</div>
    </div>

  @php
    $fileTypes = [
        'id_card' => 'บัตรประชาชน',
        'house_registration' => 'ทะเบียนบ้าน',
        'education_certificate' => 'วุฒิการศึกษา',
        'birth_certificate' => 'สูติบัตร',
        'other' => 'อื่น ๆ',
    ];
@endphp

    @if($client->files->isEmpty())
        <div class="alert alert-info text-center">
            <i class="bi bi-info-circle"></i> ยังไม่มีไฟล์เอกสาร
        </div>
    @else
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <strong><i class="bi bi-file-earmark-text"></i> รายการไฟล์เอกสาร</strong>
            </div>
            <ul class="list-group list-group-flush">
                @foreach($client->files as $file)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-file-earmark-pdf text-danger me-2"></i>
                            <div class="ms-1">
                                <strong>{{ $fileTypes[$file->file_type] ?? $file->file_type }}</strong>
                                <span class="mx-1">:</span>
                                <a href="{{ Storage::url($file->file_path) }}" 
                                target="_blank" 
                                class="text-decoration-none text-primary">
                                    {{ $file->file_name }}
                                </a>
                            </div>
                        </div>
                        <form action="{{ route('client_files.destroy', [$client->id, $file->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                <i class="bi bi-trash"></i> ลบ
                            </button>
                        </form>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

 <div class="mt-4 d-flex gap-2">
    <a href="{{ route('client_files.create', $client->id) }}" class="btn btn-success btn-sm">
        <i class="bi bi-plus-circle"></i> เพิ่มไฟล์ใหม่
    </a>
    <a href="{{ route('admin.index', $client->id) }}" class="btn btn-secondary btn-sm">
        <i class="bi bi-arrow-left-circle"></i> กลับหน้าหลัก
    </a>
</div>

    @endsection


@push('scripts')
 @section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Error --}}
    @if ($errors->any())
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด',
                html: `
                    <ul style="text-align:left;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                `,
                confirmButtonText: 'ตกลง'
            });
        });
    </script>
    @endif

    {{-- Success --}}
    @if (session('success'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: 'success',
                title: 'สำเร็จ!',
                text: '{{ session('success') }}',
                showConfirmButton: true,
                timer: 3000,
                timerProgressBar: true
            });
        });
        </script>
        @endif
    @endpush
@endsection