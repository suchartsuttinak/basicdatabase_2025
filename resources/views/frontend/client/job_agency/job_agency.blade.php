@extends('admin_client.admin_client')
@section('content')

@push('styles')
 <link rel="stylesheet" href="{{ asset('backend/assets/css/job_agency.css') }}">
@endpush

<div class="container-fluid mt-2 jobagency-page">
    <div class="ja-main-card">
        <!-- Header -->
        @include('frontend.client.job_agency.partials._header')

        <div class="ja-body">
           <!-- Info Card -->
           @include('frontend.client.job_agency.partials.info-card')

           <!-- Table Card -->
          @include('frontend.client.job_agency.partials._table')
            
        </div>
    </div>

    {{-- =========================
         Edit Modals
    ========================== --}}
    <!-- Edit Modals -->
        @include('frontend.client.job_agency.partials._edit_modal')


    {{-- =========================
         Create Modal
    ========================== --}}
        @include('frontend.client.job_agency.partials._create_modal')
  
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const formSelector = '.jobagency-validate-form';
    const createModalEl = document.getElementById('createJobAgencyModal');
    const createForm = document.getElementById('createJobAgencyForm');

    function clearFieldError(field) {
        if (!field) return;
        field.classList.remove('is-invalid');

        const wrapper = field.closest('.col-12, .col-md-4, .col-md-6, .col-md-8, .ja-section') || field.parentElement;
        if (!wrapper) return;

        const errorEl = wrapper.querySelector(':scope > .ja-invalid-text');
        if (errorEl) errorEl.remove();
    }

    function showFieldError(field, message) {
        if (!field) return;
        field.classList.add('is-invalid');

        const wrapper = field.closest('.col-12, .col-md-4, .col-md-6, .col-md-8, .ja-section') || field.parentElement;
        if (!wrapper) return;

        let errorEl = wrapper.querySelector(':scope > .ja-invalid-text');
        if (!errorEl) {
            errorEl = document.createElement('div');
            errorEl.className = 'ja-invalid-text';
            wrapper.appendChild(errorEl);
        }
        errorEl.textContent = message;
    }

    function resetValidationState(form) {
        if (!form) return;

        form.querySelectorAll('.is-invalid').forEach(function (el) {
            el.classList.remove('is-invalid');
        });

        form.querySelectorAll('.ja-invalid-text').forEach(function (el) {
            el.remove();
        });
    }

    function validateJobAgencyForm(form) {
        let isValid = true;
        let firstInvalid = null;

        const jobDate = form.querySelector('input[name="job_date"]');
        const occupationId = form.querySelector('select[name="occupation_id"]');
        const position = form.querySelector('input[name="position"]');
        const income = form.querySelector('input[name="income"]');
        const company = form.querySelector('input[name="company"]');
        const coordinator = form.querySelector('input[name="coordinator"]');

        [jobDate, occupationId, position, income, company, coordinator].forEach(clearFieldError);

        if (!jobDate || !jobDate.value.trim()) {
            isValid = false;
            showFieldError(jobDate, 'กรุณาเลือกวันที่เริ่มงาน');
            if (!firstInvalid) firstInvalid = jobDate;
        }

        if (!occupationId || !occupationId.value.trim()) {
            isValid = false;
            showFieldError(occupationId, 'กรุณาเลือกอาชีพ');
            if (!firstInvalid) firstInvalid = occupationId;
        }

        if (!position || !position.value.trim()) {
            isValid = false;
            showFieldError(position, 'กรุณากรอกตำแหน่ง');
            if (!firstInvalid) firstInvalid = position;
        }

        if (!income || !income.value.trim()) {
            isValid = false;
            showFieldError(income, 'กรุณากรอกรายได้');
            if (!firstInvalid) firstInvalid = income;
        } else if (Number(income.value) < 0) {
            isValid = false;
            showFieldError(income, 'รายได้ต้องมีค่าไม่น้อยกว่า 0');
            if (!firstInvalid) firstInvalid = income;
        }

        if (!company || !company.value.trim()) {
            isValid = false;
            showFieldError(company, 'กรุณากรอกชื่อบริษัทหรือหน่วยงาน');
            if (!firstInvalid) firstInvalid = company;
        }

        if (!coordinator || !coordinator.value.trim()) {
            isValid = false;
            showFieldError(coordinator, 'กรุณากรอกชื่อผู้ประสานงาน');
            if (!firstInvalid) firstInvalid = coordinator;
        }

        if (!isValid && firstInvalid) {
            const modalBody = form.querySelector('.ja-modal-body');
            if (modalBody && modalBody.contains(firstInvalid)) {
                const bodyRect = modalBody.getBoundingClientRect();
                const fieldRect = firstInvalid.getBoundingClientRect();
                modalBody.scrollTop += (fieldRect.top - bodyRect.top) - 80;
            }

            setTimeout(function () {
                firstInvalid.focus({ preventScroll: true });
            }, 120);
        }

        return isValid;
    }

    function bindLiveValidation(form) {
        if (!form) return;

        form.querySelectorAll('input[name="job_date"], select[name="occupation_id"], input[name="position"], input[name="income"], input[name="company"], input[name="coordinator"]').forEach(function (field) {
            field.addEventListener('input', function () {
                if (field.value.trim()) clearFieldError(field);
            });

            field.addEventListener('change', function () {
                if (field.value.trim()) clearFieldError(field);
            });
        });
    }

    document.querySelectorAll(formSelector).forEach(function (form) {
        bindLiveValidation(form);

        form.addEventListener('submit', function (e) {
            resetValidationState(form);
            const valid = validateJobAgencyForm(form);

            if (!valid) {
                e.preventDefault();

                if (window.Swal) {
                    Swal.fire({
                        icon: 'error',
                        title: 'กรอกข้อมูลไม่ครบ',
                        text: 'กรุณาตรวจสอบช่องที่มีกรอบสีแดง',
                        confirmButtonText: 'ตกลง'
                    });
                }
            }
        });
    });

    if (createModalEl && createForm) {
        createModalEl.addEventListener('show.bs.modal', function () {
            createForm.reset();
            resetValidationState(createForm);
        });

        createModalEl.addEventListener('shown.bs.modal', function () {
            const modalBody = createModalEl.querySelector('.ja-modal-body');
            if (modalBody) modalBody.scrollTop = 0;
        });
    }

    document.querySelectorAll('.ja-modal-edit').forEach(function (modalEl) {
        modalEl.addEventListener('show.bs.modal', function () {
            const form = modalEl.querySelector('form.jobagency-validate-form');
            if (!form) return;
            resetValidationState(form);
        });

        modalEl.addEventListener('shown.bs.modal', function () {
            const modalBody = modalEl.querySelector('.ja-modal-body');
            if (modalBody) modalBody.scrollTop = 0;
        });
    });

    function adjustJobAgencyTable() {
        if (window.jQuery && jQuery.fn.DataTable && jQuery.fn.DataTable.isDataTable('#datatable-jobagency')) {
            const dt = jQuery('#datatable-jobagency').DataTable();
            dt.columns.adjust();
            if (dt.responsive && typeof dt.responsive.recalc === 'function') {
                dt.responsive.recalc();
            }
        }
    }

    setTimeout(adjustJobAgencyTable, 150);
    window.addEventListener('resize', adjustJobAgencyTable);

    if (window.jQuery) {
        jQuery('#datatable-jobagency').on('draw.dt', function () {
            adjustJobAgencyTable();
        });
    }

    @if ($errors->any())
        @if (old('job_id'))
            (function () {
                const modalId = 'editJobAgencyModal' + {{ old('job_id') }};
                const modalEl = document.getElementById(modalId);

                if (modalEl) {
                    bootstrap.Modal.getOrCreateInstance(modalEl).show();
                }

                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด',
                    html: `{!! implode('<br>', $errors->all()) !!}`,
                    confirmButtonText: 'ตกลง'
                });
            })();
        @else
            (function () {
                const modalEl = document.getElementById('createJobAgencyModal');
                if (modalEl) {
                    bootstrap.Modal.getOrCreateInstance(modalEl).show();
                }

                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด',
                    html: `{!! implode('<br>', $errors->all()) !!}`,
                    confirmButtonText: 'ตกลง'
                });
            })();
        @endif
    @endif

    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'สำเร็จ',
            text: '{{ session('success') }}',
            timer: 3000,
            confirmButtonText: 'ตกลง'
        });
    @endif
});
</script>
@endpush

@endsection