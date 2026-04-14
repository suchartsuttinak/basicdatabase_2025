@extends('admin_client.admin_client')

@section('content')

@push('styles')
<link rel="stylesheet" href="{{ asset('backend/assets/css/help-sessions.css') }}">

<style>
   /* ===== Page spacing ===== */
.help-page {
    padding-bottom: 1rem;
}

.help-page .hp-card {
    background: #fff;
    border: 1px solid #e9edf5;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 8px 24px rgba(15, 23, 42, 0.04);
}

.help-page .hp-body {
    padding: 1rem;
}

/* ===== FIX รูป ===== */
.help-page .profile-card,
.help-page .client-profile-card,
.help-page .hp-profile-card,
.help-page .profile-summary-card {
    overflow: hidden;
    border-radius: 16px;
}

/* รูปทั้งหมด */
.help-page .profile-card img,
.help-page .client-profile-card img,
.help-page .hp-profile-card img,
.help-page .profile-summary-card img,
.help-page .client-photo img,
.help-page .profile-photo img,
.help-page .avatar-box img,
.help-page .user-photo img,
.help-page .help-profile-image,
.help-page .client-image {
    width: 100%;
    max-width: 100%;
    height: 220px !important;
    max-height: 220px !important;
    object-fit: cover;
    object-position: center;
    display: block;
    border-radius: 14px;
}

/* fallback */
.help-page .hp-body > div:first-child img {
    width: 100%;
    max-width: 100%;
    height: 220px;
    max-height: 220px;
    object-fit: cover;
    object-position: center;
    display: block;
    border-radius: 14px;
}

/* 🔥 แก้การ์ดขวาให้ไม่สูงตามรูป */
.help-page .summary-card,
.help-page .total-card,
.help-page .amount-card,
.help-page .help-total-box {
    min-height: 220px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

/* ตาราง */
.help-page .table-responsive {
    border-radius: 16px;
    overflow: auto;
}

/* ===== Tablet ===== */
@media (max-width: 991.98px) {
    .help-page .profile-card img,
    .help-page .client-profile-card img,
    .help-page .hp-profile-card img,
    .help-page .profile-summary-card img,
    .help-page .client-photo img,
    .help-page .profile-photo img,
    .help-page .avatar-box img,
    .help-page .user-photo img,
    .help-page .help-profile-image,
    .help-page .client-image,
    .help-page .hp-body > div:first-child img {
        height: 180px !important;
        max-height: 180px !important;
    }

    .help-page .summary-card,
    .help-page .total-card,
    .help-page .amount-card,
    .help-page .help-total-box {
        min-height: auto;
    }
}

/* ===== Mobile ===== */
@media (max-width: 575.98px) {
    .help-page .hp-body {
        padding: 0.75rem;
    }

    .help-page .profile-card img,
    .help-page .client-profile-card img,
    .help-page .hp-profile-card img,
    .help-page .profile-summary-card img,
    .help-page .client-photo img,
    .help-page .profile-photo img,
    .help-page .avatar-box img,
    .help-page .user-photo img,
    .help-page .help-profile-image,
    .help-page .client-image,
    .help-page .hp-body > div:first-child img {
        height: 150px !important;
        max-height: 150px !important;
        border-radius: 12px;
    }
}
</style>
@endpush

@php
    $clientPhoto = $client->photo ?? $client->avatar ?? $client->image ?? $client->profile_image ?? $client->photo_path ?? null;
    $clientPhotoUrl = null;

    if (!empty($clientPhoto)) {
        if (\Illuminate\Support\Str::startsWith($clientPhoto, ['http://', 'https://', '/'])) {
            $clientPhotoUrl = $clientPhoto;
        } elseif (\Illuminate\Support\Str::startsWith($clientPhoto, ['storage/'])) {
            $clientPhotoUrl = asset($clientPhoto);
        } else {
            $clientPhotoUrl = asset('storage/' . ltrim($clientPhoto, '/'));
        }
    }

    $clientInitial = mb_substr(trim($client->fullname ?? 'U'), 0, 1);
@endphp

<div class="container-fluid mt-2 help-page">
    <div class="hp-card">

        {{-- Header --}}
        @include('frontend.client.helping.partials._header')

        <div class="hp-body">

            {{-- Profile Card --}}
            {{-- @include('frontend.client.helping.partials.profile-card') --}}

            {{-- Help Sessions Table --}}
            @include('frontend.client.helping.partials._table')

        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const collapseElements = document.querySelectorAll('.help-page .collapse');

    collapseElements.forEach(function (collapseEl) {
        collapseEl.addEventListener('show.bs.collapse', function () {
            const button = document.querySelector('[data-bs-target="#' + collapseEl.id + '"]');
            if (button) {
                button.innerHTML = '<i class="bi bi-eye-slash"></i><span>ซ่อนรายการ</span>';
                button.classList.remove('btn-info');
                button.classList.add('btn-outline-info');
            }
        });

        collapseEl.addEventListener('hide.bs.collapse', function () {
            const button = document.querySelector('[data-bs-target="#' + collapseEl.id + '"]');
            if (button) {
                button.innerHTML = '<i class="bi bi-list-ul"></i><span>แสดงรายการ</span>';
                button.classList.remove('btn-outline-info');
                button.classList.add('btn-info', 'text-white');
            }
        });
    });
});
</script>
@endpush

@endsection