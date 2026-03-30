    @extends('admin_client.admin_client')

    @section('content')
    <div class="container-fluid mt-2 addictive-page">
        <div class="card shadow-sm border-0 addictive-card">
            <div class="card-header addictive-card-header">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <h6 class="mb-0 fw-bold d-flex align-items-center">
                        <i class="bi bi-clipboard2-pulse me-2"></i>
                        ข้อมูลการตรวจสารเสพติด
                    </h6>

                    <button type="button"
                            class="btn btn-primary btn-sm addictive-btn-primary"
                            data-bs-toggle="modal"
                            data-bs-target="#createAddictiveModal">
                        <i class="bi bi-plus-circle me-1"></i>
                        เพิ่มข้อมูล
                    </button>
                </div>
            </div>

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