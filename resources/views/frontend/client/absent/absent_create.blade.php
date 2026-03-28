@extends('admin_client.admin_client')

@push('styles')
<link rel="stylesheet" href="{{ asset('backend/assets/css/absent.css') }}">
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
document.addEventListener("DOMContentLoaded", function () {
    const createModalEl = document.getElementById('absentModal');
    if (createModalEl) {
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