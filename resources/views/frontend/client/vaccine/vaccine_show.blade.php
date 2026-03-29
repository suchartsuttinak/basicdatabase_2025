    @extends('admin_client.admin_client')

    @push('styles')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/vaccine.css') }}">
    @endpush

    @section('content')
    <div class="container-fluid py-3 vaccine-page">

        @include('frontend.client.vaccine.partials._header')
        @include('frontend.client.vaccine.partials._client_info')

        @if($vaccinations->isNotEmpty())
            @include('frontend.client.vaccine.partials._table')
        @else
            @include('frontend.client.vaccine.partials._empty')
        @endif

    </div>

    @include('frontend.client.vaccine.partials._add_modal')
    @include('frontend.client.vaccine.partials._edit_modal')
    @endsection

    @push('scripts')
    <script src="{{ asset('backend/assets/js/vaccine.js') }}"></script>

    @if ($errors->any() && !session('edit_mode'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            bootstrap.Modal.getOrCreateInstance(document.getElementById('add-vaccine-modal')).show();
        });
    </script>
    @endif

    @if ($errors->any() && session('edit_mode') && session('edit_id'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            vaccineEdit({{ session('edit_id') }});
        });
    </script>
    @endif
    @endpush