    @extends('admin_client.admin_client')

    @section('content')
    <div class="container-fluid mt-2 addictive-page">
        <div class="card shadow-sm border-0 addictive-card">

            <!-- HEADER -->
            @include('frontend.client.addictive.partials.header')

            <div class="card-body p-2 p-md-3">
                @include('frontend.client.addictive.partials._client_info')
                @include('frontend.client.addictive.partials._table')
            </div>
        </div>
    </div>

    @include('frontend.client.addictive.partials._create_modal')
    @include('frontend.client.addictive.partials._edit_modal')
    @endsection

    @push('styles')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/addictive.css') }}">
    @endpush

   @push('scripts')
    <script>
        window.addictiveConfig = {
            jsonUrl: "{{ url('/addictive/json') }}",
            updateBaseUrl: "{{ url('/addictive/update') }}"
        };
    </script>
    <script src="{{ asset('backend/assets/js/addictive.js') }}"></script>
    @include('frontend.client.addictive.partials._script_init')
    @endpush