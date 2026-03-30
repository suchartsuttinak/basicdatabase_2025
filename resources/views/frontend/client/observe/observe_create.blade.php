@extends('admin_client.admin_client')

@section('content')
 @push('styles')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/observe.css') }}">
    @endpush

<div class="observe-page">
    <div class="observe-shell">

        {{-- Topbar --}}
        <div class="observe-topbar">
            <div class="observe-title-wrap">
                <div class="observe-title-box">
                    <div class="observe-title-icon">
                        <i class="bi bi-clipboard2-pulse"></i>
                    </div>
                    <div>
                        <h1 class="observe-title">ข้อมูลการบันทึกและติดตามพฤติกรรม</h1>
                        <p class="observe-subtitle">
                            จัดการข้อมูลการสังเกตพฤติกรรม การดำเนินการ ผลลัพธ์ และการติดตามผลของผู้รับบริการอย่างเป็นระบบ
                        </p>
                    </div>
                </div>

                <div class="observe-actions">
                    <button type="button"
                            class="btn-modern {{ isset($observe) ? 'btn-modern-warning' : 'btn-modern-primary' }}"
                            data-bs-toggle="modal"
                            data-bs-target="#observeModal">
                        <i class="bi {{ isset($observe) ? 'bi-pencil-square' : 'bi-plus-circle' }}"></i>
                        {{ isset($observe) ? 'แก้ไขข้อมูล' : 'เพิ่มข้อมูลใหม่' }}
                    </button>

                    <button type="button"
                            class="btn-modern btn-modern-danger"
                            onclick="window.location.href='{{ route('observe.create', ['client_id' => $client->id]) }}'">
                        <i class="bi bi-x-circle"></i>
                        ปิดฟอร์ม
                    </button>
                </div>
            </div>
        </div>

        {{-- Summary --}}
       
        @include('frontend.client.observe.partials.summary')


        {{-- Main content --}}
        @include('frontend.client.observe.partials._table') 

        </div>
     </div> 

        {{-- Modal บันทึก/แก้ไขพฤติกรรม --}}
        @include('frontend.client.observe.partials.observeModal')

   
        {{-- Modal แก้ไขการติดตามผล --}}
        @include('frontend.client.observe.partials.editFollowupModal')


        @if ($errors->any())
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const modalEl = document.getElementById('observeModal');
                if (modalEl) {
                    const observeModal = new bootstrap.Modal(modalEl);
                    observeModal.show();
                }
            });
        </script>
        @endif

    @if ($errors->any())
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด',
                html: `
                    <ul style="text-align:left; padding-left: 1rem; margin-bottom:0;">
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
        document.addEventListener("DOMContentLoaded", function () {
            Swal.fire({
                icon: 'success',
                title: '{{ session('success') }}',
                showConfirmButton: true,
                timer: 3000,
                timerProgressBar: true
            });
        });
    </script>


    @endif
@endsection