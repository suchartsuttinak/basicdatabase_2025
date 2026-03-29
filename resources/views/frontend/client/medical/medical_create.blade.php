@extends('admin_client.admin_client')

@push('styles')
<link rel="stylesheet" href="{{ asset('backend/assets/css/medical.css') }}">
@endpush

@section('content')
<div class="container-fluid py-3 medical-page">

    @include('frontend.client.medical.partials._header')
    @include('frontend.client.medical.partials._client_info')

    @if($medicals->isNotEmpty())
        @include('frontend.client.medical.partials._table')
    @else
        @include('frontend.client.medical.partials._empty')
    @endif

</div>

@include('frontend.client.medical.partials._add_modal')
@include('frontend.client.medical.partials._edit_modal')
@endsection

@push('scripts')
<script src="{{ asset('backend/assets/js/medical.js') }}"></script>

@if ($errors->any() && !session('edit_mode'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        bootstrap.Modal.getOrCreateInstance(document.getElementById('add-medical-modal')).show();
    });
</script>
@endif

@if ($errors->any() && session('edit_mode') && session('edit_id'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        openEditMedical({{ session('edit_id') }});
        showEditErrors(@json($errors->toArray()));
    });
</script>
@endif
@endpush