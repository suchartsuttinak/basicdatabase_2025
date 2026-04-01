@extends('admin_client.admin_client')
@section('content')

    @push('styles')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/help-sessions.css') }}">
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

        <!-- Header -->
            @include('frontend.client.helping.partials._header')

        <div class="hp-body">
            <!-- Profile Card -->
            @include('frontend.client.helping.partials.profile-card')

            <!-- Help Sessions Table -->
              @include('frontend.client.helping.partials._table')

          
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