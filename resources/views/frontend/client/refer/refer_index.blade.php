@extends('admin_client.admin_client')
@section('content')


    @push('styles')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/refer.css') }}">
    @endpush


    <div class="container-fluid mt-2 refer-page">
        <div class="rf-main-card">
        
            <!-- Header -->
            @include('frontend.client.refer.partials._header')

        <div class="rf-body">

               <!-- Info Card -->
            @include('frontend.client.refer.partials.info-card')

               <!-- Table -->
            @include('frontend.client.refer.partials._table')
 
        </div>
    </div>

    <!-- Create Modal -->
    @include('frontend.client.refer.partials.create_modal')
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const createModalEl = document.getElementById('createReferModal');
    const form = document.getElementById('referForm');
    const guardianFields = document.getElementById('guardianFields');
    const guardianSection = document.getElementById('guardianSection');
    const guardianRadios = form ? form.querySelectorAll('input[name="guardian"]') : [];
    const tableEl = document.getElementById('datatable-refer');

    function setGuardianState(show) {
        if (!guardianFields) return;

        guardianFields.classList.toggle('is-active', show);

        if (!show) {
            guardianFields.querySelectorAll('input').forEach(function (el) {
                el.value = '';
                el.classList.remove('is-invalid');
            });
        }
    }

    function clearFieldError(field) {
        if (!field) return;
        field.classList.remove('is-invalid');

        const wrapper = field.closest('.col-12, .col-md-4, .col-md-6, .col-md-8, .rf-section') || field.parentElement;
        if (!wrapper) return;

        const errorEl = wrapper.querySelector(':scope > .rf-invalid-text');
        if (errorEl) errorEl.remove();
    }

    function showFieldError(field, message) {
        if (!field) return;
        field.classList.add('is-invalid');

        const wrapper = field.closest('.col-12, .col-md-4, .col-md-6, .col-md-8, .rf-section') || field.parentElement;
        if (!wrapper) return;

        let errorEl = wrapper.querySelector(':scope > .rf-invalid-text');
        if (!errorEl) {
            errorEl = document.createElement('div');
            errorEl.className = 'rf-invalid-text';
            wrapper.appendChild(errorEl);
        }
        errorEl.textContent = message;
    }

    function clearRadioError() {
        guardianRadios.forEach(function (radio) {
            const optionWrap = radio.closest('.rf-option');
            if (optionWrap) optionWrap.classList.remove('is-invalid-wrap');
        });

        if (guardianSection) guardianSection.classList.remove('rf-section-error');

        const errorEl = guardianSection ? guardianSection.querySelector(':scope > .rf-invalid-text') : null;
        if (errorEl) errorEl.remove();
    }

    function showRadioError(message) {
        guardianRadios.forEach(function (radio) {
            const optionWrap = radio.closest('.rf-option');
            if (optionWrap) optionWrap.classList.add('is-invalid-wrap');
        });

        if (guardianSection) {
            guardianSection.classList.add('rf-section-error');

            let errorEl = guardianSection.querySelector(':scope > .rf-invalid-text');
            if (!errorEl) {
                errorEl = document.createElement('div');
                errorEl.className = 'rf-invalid-text';
                guardianSection.appendChild(errorEl);
            }
            errorEl.textContent = message;
        }
    }

    function resetValidationState() {
        if (!form) return;

        form.querySelectorAll('.is-invalid').forEach(function (el) {
            el.classList.remove('is-invalid');
        });

        form.querySelectorAll('.is-invalid-wrap').forEach(function (el) {
            el.classList.remove('is-invalid-wrap');
        });

        form.querySelectorAll('.rf-section-error').forEach(function (el) {
            el.classList.remove('rf-section-error');
        });

        form.querySelectorAll('.rf-invalid-text').forEach(function (el) {
            el.remove();
        });
    }

    function validateForm() {
        if (!form) return true;

        let isValid = true;
        let firstInvalid = null;

        const referDate = form.querySelector('input[name="refer_date"]');
        const translateId = form.querySelector('select[name="translate_id"]');
        const destination = form.querySelector('input[name="destination"]');
        const address = form.querySelector('textarea[name="address"]');
        const teacher = form.querySelector('input[name="teacher"]');

        [referDate, translateId, destination, address, teacher].forEach(clearFieldError);
        clearRadioError();

        if (!referDate || !referDate.value.trim()) {
            isValid = false;
            showFieldError(referDate, 'กรุณาเลือกวันที่นำส่ง');
            if (!firstInvalid) firstInvalid = referDate;
        }

        if (!translateId || !translateId.value.trim()) {
            isValid = false;
            showFieldError(translateId, 'กรุณาเลือกสาเหตุการจำหน่าย');
            if (!firstInvalid) firstInvalid = translateId;
        }

        if (!destination || !destination.value.trim()) {
            isValid = false;
            showFieldError(destination, 'กรุณากรอกชื่อสถานที่นำส่ง');
            if (!firstInvalid) firstInvalid = destination;
        }

        if (!address || !address.value.trim()) {
            isValid = false;
            showFieldError(address, 'กรุณากรอกที่อยู่');
            if (!firstInvalid) firstInvalid = address;
        }

        if (!Array.from(guardianRadios).some(radio => radio.checked)) {
            isValid = false;
            showRadioError('กรุณาเลือกว่ามีผู้ดูแลหรือไม่');
            if (!firstInvalid && guardianRadios.length) firstInvalid = guardianRadios[0];
        }

        if (!teacher || !teacher.value.trim()) {
            isValid = false;
            showFieldError(teacher, 'กรุณากรอกชื่อผู้นำส่ง');
            if (!firstInvalid) firstInvalid = teacher;
        }

        if (!isValid && firstInvalid) {
            const modalBody = form.querySelector('.rf-modal-body');
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

    function bindLiveValidation() {
        if (!form) return;

        form.querySelectorAll('input[name="refer_date"], select[name="translate_id"], input[name="destination"], textarea[name="address"], input[name="teacher"]').forEach(function (field) {
            field.addEventListener('input', function () {
                if (field.value.trim()) clearFieldError(field);
            });

            field.addEventListener('change', function () {
                if (field.value.trim()) clearFieldError(field);
            });
        });

        guardianRadios.forEach(function (radio) {
            radio.addEventListener('change', function () {
                clearRadioError();
                setGuardianState(this.value === 'มี');
            });
        });
    }

    if (form) {
        bindLiveValidation();

        form.addEventListener('submit', function (e) {
            resetValidationState();
            const valid = validateForm();

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
    }

    if (createModalEl && form) {
        createModalEl.addEventListener('show.bs.modal', function () {
            form.reset();
            resetValidationState();
            setGuardianState(false);
        });

        createModalEl.addEventListener('shown.bs.modal', function () {
            const modalBody = createModalEl.querySelector('.rf-modal-body');
            if (modalBody) modalBody.scrollTop = 0;
        });
    }

    // ถ้ามี old guardian จาก validation ฝั่ง server
    if (form && "{{ old('guardian') }}" === 'มี') {
        setGuardianState(true);
    }

    // DataTable adjust
    function adjustReferTable() {
        if (window.jQuery && jQuery.fn.DataTable && jQuery.fn.DataTable.isDataTable('#datatable-refer')) {
            const dt = jQuery('#datatable-refer').DataTable();
            dt.columns.adjust();
            if (dt.responsive && typeof dt.responsive.recalc === 'function') {
                dt.responsive.recalc();
            }
        }
    }

    setTimeout(adjustReferTable, 150);
    window.addEventListener('resize', adjustReferTable);

    if (window.jQuery) {
        jQuery('#datatable-refer').on('draw.dt', function () {
            adjustReferTable();
        });
    }

    @if ($errors->any())
        (function () {
            const modalEl = document.getElementById('createReferModal');
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

    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'สำเร็จ',
            text: '{{ session('success') }}',
            timer: 2500,
            confirmButtonText: 'ตกลง'
        });
    @endif
});
</script>
@endpush

@endsection