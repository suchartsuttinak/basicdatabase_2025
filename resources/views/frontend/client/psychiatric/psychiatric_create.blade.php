    @extends('admin_client.admin_client')

    @section('content')
    <div class="container-fluid mt-2 psychiatric-page">
        <div class="card shadow-sm border-0 psychiatric-card">

          <!-- header -->`
                @include('frontend.client.psychiatric.partials.header')

          
                <div class="card-body p-2 p-md-3">
                @include('frontend.client.psychiatric.partials._client_info')
                @include('frontend.client.psychiatric.partials._table')
            </div>
        </div>
    </div>

    @include('frontend.client.psychiatric.partials._create_modal')
    @include('frontend.client.psychiatric.partials._edit_modal')
    @endsection

    @push('styles')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/psychiatric.css') }}">
    @endpush

    @push('scripts')
    <script>
        window.psychiatricConfig = {
            editJsonUrl: "{{ url('/psychiatric/edit-json') }}",
            updateBaseUrl: "{{ url('/psychiatric') }}"
        };
    </script>
    <script src="{{ asset('backend/assets/js/psychiatric.js') }}"></script>
    @include('frontend.client.psychiatric.partials._script_init')
    @endpush