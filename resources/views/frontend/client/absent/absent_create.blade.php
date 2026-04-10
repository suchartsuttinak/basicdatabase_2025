@extends('admin_client.admin_client')

@push('styles')
<link rel="stylesheet" href="{{ asset('backend/assets/css/absent.css') }}">

<style>
    /* ===== Page ===== */
    .absent-page-wrap {
        padding-top: .5rem;
        padding-bottom: 1rem;
    }

    /* ===== FIX รูปใหญ่เกิน =====
       ครอบคลุมรูปใน header / summary / table / modal
       เพื่อไม่ให้รูปยืดล้นการ์ด */
    .absent-page img {
        max-width: 100%;
        height: auto;
        display: block;
    }

    /* รูปโปรไฟล์ / รูปผู้รับบริการ */
    .absent-page .client-photo,
    .absent-page .profile-photo,
    .absent-page .profile-image,
    .absent-page .client-image,
    .absent-page .avatar-box img,
    .absent-page .user-avatar img,
    .absent-page .summary-card img,
    .absent-page .header-card img,
    .absent-page .card img {
        width: 100%;
        max-width: 100%;
        height: 260px !important;
        max-height: 260px !important;
        object-fit: cover;
        object-position: center top;
        border-radius: 16px;
        display: block;
    }

    /* ถ้ามี wrapper รูป ให้กันล้น */
    .absent-page .image-wrap,
    .absent-page .photo-wrap,
    .absent-page .avatar-box,
    .absent-page .profile-photo-wrap {
        overflow: hidden;
        border-radius: 16px;
    }

    /* ถ้าใน partial ใช้รูปโปรไฟล์แบบวงกลม */
    .absent-page .rounded-circle,
    .absent-page .avatar-circle,
    .absent-page .profile-avatar {
        width: 88px !important;
        height: 88px !important;
        min-width: 88px !important;
        max-width: 88px !important;
        min-height: 88px !important;
        max-height: 88px !important;
        object-fit: cover;
        object-position: center;
        border-radius: 50% !important;
    }

    /* modal image */
    #absentModal img,
    #editAbsentModal img {
        max-width: 100%;
        height: auto;
        object-fit: cover;
    }

    /* Tablet */
    @media (max-width: 991.98px) {
        .absent-page .client-photo,
        .absent-page .profile-photo,
        .absent-page .profile-image,
        .absent-page .client-image,
        .absent-page .avatar-box img,
        .absent-page .user-avatar img,
        .absent-page .summary-card img,
        .absent-page .header-card img,
        .absent-page .card img {
            height: 220px !important;
            max-height: 220px !important;
        }
    }

    /* Mobile */
    @media (max-width: 575.98px) {
        .absent-page .client-photo,
        .absent-page .profile-photo,
        .absent-page .profile-image,
        .absent-page .client-image,
        .absent-page .avatar-box img,
        .absent-page .user-avatar img,
        .absent-page .summary-card img,
        .absent-page .header-card img,
        .absent-page .card img {
            height: 180px !important;
            max-height: 180px !important;
            border-radius: 12px;
        }

        .absent-page .rounded-circle,
        .absent-page .avatar-circle,
        .absent-page .profile-avatar {
            width: 72px !important;
            height: 72px !important;
            min-width: 72px !important;
            max-width: 72px !important;
            min-height: 72px !important;
            max-height: 72px !important;
        }
    }
</style>
@endpush

@section('content')
@php
    use Carbon\Carbon;

    $clientName = $client->fullname ?? $client->full_name ?? '-';
    $clientAge = $client->age ?? '-';
    $schoolName = optional($educationRecord)->school_name ?? 'ไม่พบข้อมูล';
    $educationName = optional(optional($educationRecord)->education)->education_name ?? 'ไม่พบข้อมูล';
    $semesterName = optional(optional($educationRecord)->semester)->semester_name ?? 'ไม่พบข้อมูล';

    $profileImage = asset('upload/no_image.jpg');
    $clientImageFile = !empty($client->image) ? public_path('upload/client_images/' . $client->image) : null;

    if (!empty($client->image) && $clientImageFile && file_exists($clientImageFile)) {
        $profileImage = asset('upload/client_images/' . $client->image);
    }
@endphp

<div class="container-fluid absent-page absent-page-wrap">
    @include('frontend.client.absent.partials.header')
    @include('frontend.client.absent.partials.summary')
    @include('frontend.client.absent.partials.table')
</div>

@include('frontend.client.absent.partials.create-modal')
@include('frontend.client.absent.partials.edit-modal')

@if ($errors->any())
<script>
document.addEventListener('DOMContentLoaded', function () {
    const createModalEl = document.getElementById('absentModal');
    if (createModalEl && window.bootstrap) {
        const modal = new bootstrap.Modal(createModalEl);
        modal.show();
    }
});
</script>
@endif
@endsection

@push('scripts')
<script>
    window.absentConfig = {
        editBaseUrl: "{{ url('/absent/edit') }}",
        updateBaseUrl: "{{ url('/absent/update') }}"
    };
</script>
<script src="{{ asset('backend/assets/js/absent.js') }}"></script>
@endpush