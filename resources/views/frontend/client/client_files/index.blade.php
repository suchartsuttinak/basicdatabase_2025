@extends('admin_client.admin_client')

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<style>
.client-file-page{
    padding: 16px 0 28px;
}

.client-file-header{
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    background: #fff;
    box-shadow: 0 4px 14px rgba(15,23,42,.05);
}

.client-file-title{
    display:flex;
    align-items:center;
    gap:10px;
    font-size:18px;
    font-weight:700;
    color:#0f172a;
}

.client-file-card{
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    overflow:hidden;
    background:#fff;
    box-shadow: 0 4px 14px rgba(15,23,42,.05);
}

.client-file-row{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:12px;
    padding:12px 14px;
}

.client-file-info{
    display:flex;
    align-items:flex-start;
    gap:10px;
    min-width:0;
}

.client-file-name{
    color:#0f172a;
    font-weight:600;
    word-break:break-word;
}

.client-file-type{
    color:#64748b;
    font-size:13px;
}

.client-file-actions{
    display:flex;
    flex-wrap:wrap;
    gap:6px;
    justify-content:flex-end;
}

.client-file-bottom-actions{
    display:flex;
    flex-wrap:wrap;
    gap:8px;
    margin-top:16px;
}

@media(max-width: 767.98px){
    .client-file-row{
        flex-direction:column;
        align-items:stretch;
    }

    .client-file-actions{
        justify-content:flex-start;
    }

    .client-file-actions .btn,
    .client-file-bottom-actions .btn{
        width:100%;
    }
}
</style>

<div class="container-fluid client-file-page">

    <div class="card client-file-header mb-4">
        <div class="card-body">
            <div class="client-file-title">
                <i class="bi bi-folder-fill text-primary"></i>
                <span>
                    ไฟล์เอกสารของ
                    <span class="text-success">{{ $client->fullname }}</span>
                </span>
            </div>
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
        <div class="client-file-card">
            <div class="card-header bg-light">
                <strong>
                    <i class="bi bi-file-earmark-text"></i> รายการไฟล์เอกสาร
                </strong>
            </div>

            <ul class="list-group list-group-flush">
                @foreach($client->files as $file)
                    <li class="list-group-item client-file-row">
                        <div class="client-file-info">
                            <i class="bi bi-file-earmark-pdf text-danger fs-4"></i>

                            <div>
                                <div class="client-file-type">
                                    {{ $fileTypes[$file->file_type] ?? $file->file_type }}
                                </div>

                                <div class="client-file-name">
                                    {{ $file->file_name }}
                                </div>
                            </div>
                        </div>

                        <div class="client-file-actions">
                            <a href="{{ route('client_files.view', [$client->id, $file->id]) }}"
                               target="_blank"
                               class="btn btn-primary btn-sm">
                                <i class="bi bi-eye"></i> ดูไฟล์
                            </a>

                            <a href="{{ route('client_files.download', [$client->id, $file->id]) }}"
                               class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-download"></i> ดาวน์โหลด
                            </a>

                            <form action="{{ route('client_files.destroy', [$client->id, $file->id]) }}"
                                  method="POST"
                                  class="d-inline delete-file-form">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    <i class="bi bi-trash"></i> ลบ
                                </button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="client-file-bottom-actions">
        <a href="{{ route('client_files.create', $client->id) }}" class="btn btn-success btn-sm">
            <i class="bi bi-plus-circle"></i> เพิ่มไฟล์ใหม่
        </a>

        <a href="{{ route('admin.index', $client->id) }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left-circle"></i> กลับหน้าหลัก
        </a>
    </div>

</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.delete-file-form').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            Swal.fire({
                icon: 'warning',
                title: 'ยืนยันการลบ',
                text: 'คุณต้องการลบไฟล์เอกสารนี้หรือไม่?',
                showCancelButton: true,
                confirmButtonText: 'ลบไฟล์',
                cancelButtonText: 'ยกเลิก',
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>
@endpush