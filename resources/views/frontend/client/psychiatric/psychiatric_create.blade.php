    @extends('admin_client.admin_client')

    @section('content')
    <div class="container-fluid mt-2 psychiatric-page">
        <div class="card shadow-sm border-0 psychiatric-card">
            <div class="card-header psychiatric-header">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <h6 class="mb-0 fw-bold d-flex align-items-center">
                        <i class="bi bi-clipboard-check me-2"></i>
                        ข้อมูลการตรวจวินิจฉัยทางจิตวิทยา
                    </h6>

                    <button type="button"
                            class="btn btn-primary btn-sm psychiatric-btn-primary"
                            data-bs-toggle="modal"
                            data-bs-target="#createPsychiatricModal"
                            id="btn-create-psychiatric">
                        <i class="bi bi-plus-circle me-1"></i> เพิ่มข้อมูล
                    </button>
                </div>
            </div>

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