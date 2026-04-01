@extends('admin_client.admin_client')

@section('content')

@push('styles')
 <link rel="stylesheet" href="{{ asset('backend/assets/css/case_outside.css') }}">
@endpush


<div class="container-fluid mt-2 co-page">
    <div class="co-card">

          <!-- Header -->
          @include('frontend.client.case_outside.partials._header')


        <div class="co-body">

          <!-- Info Card -->
          @include('frontend.client.case_outside.partials.info-card')


            @if($caseoutsides->isNotEmpty())
                <!-- Table Card -->
                @include('frontend.client.case_outside.partials._table')
            @else
                <div class="co-table-card">
                    <div class="co-empty">
                        <i class="bi bi-info-circle"></i>
                        <div class="fw-bold mb-1">ยังไม่มีข้อมูลการติดตาม</div>
                        <div class="small">เมื่อเพิ่มข้อมูลแล้ว รายการจะแสดงในส่วนนี้</div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- =========================
         Edit Modals
    ========================== --}}
          @include('frontend.client.case_outside.partials.edit_modal')  

    {{-- =========================
         Create Modal
    ========================== --}}
          @include('frontend.client.case_outside.partials.create_modal')

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const createModalEl = document.getElementById('createCaseOutsideModal');
    const createForm = document.getElementById('createCaseOutsideForm');
    const createOpenBtn = document.querySelector('[data-bs-target="#createCaseOutsideModal"]');

    function resetFormState(form) {
        if (!form) return;

        form.reset();

        form.querySelectorAll('select').forEach(select => {
            select.selectedIndex = 0;
        });

        form.querySelectorAll('input[type="radio"]').forEach(radio => {
            radio.checked = false;
        });

        form.querySelectorAll('textarea').forEach(textarea => {
            if (!textarea.hasAttribute('data-preserve')) {
                textarea.value = '';
            }
        });
    }

    function validateCaseOutsideForm(form) {
        const errors = [];

        const dateInput = form.querySelector('input[name="date"]');
        const outsideSelect = form.querySelector('select[name="outside_id"]');
        const dormitoryInput = form.querySelector('input[name="dormitory"]');
        const resultsInput = form.querySelector('textarea[name="results"]');
        const radioInputs = form.querySelectorAll('input[name="follo_no"]');

        if (!dateInput || !dateInput.value) {
            errors.push('กรุณากรอกวันที่ติดตาม');
        }

        if (!outsideSelect || !outsideSelect.value) {
            errors.push('กรุณาเลือกสาเหตุที่พักอาศัยภายนอก');
        }

        if (!dormitoryInput || !dormitoryInput.value.trim()) {
            errors.push('กรุณากรอกสถานที่พัก');
        }

        if (!radioInputs.length || !Array.from(radioInputs).some(radio => radio.checked)) {
            errors.push('กรุณาเลือกการดำเนินงาน');
        }

        if (!resultsInput || !resultsInput.value.trim()) {
            errors.push('กรุณากรอกผลการติดตาม');
        }

        return errors;
    }

    if (createOpenBtn && createForm) {
        createOpenBtn.addEventListener('click', function () {
            resetFormState(createForm);
        });
    }

    if (createForm) {
        createForm.addEventListener('submit', function (e) {
            const errors = validateCaseOutsideForm(createForm);

            if (errors.length) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'กรอกข้อมูลไม่ครบ',
                    html: errors.join('<br>'),
                    confirmButtonText: 'ตกลง'
                });
            }
        });
    }

    document.querySelectorAll('.co-modal-edit form').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            const errors = validateCaseOutsideForm(form);

            if (errors.length) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'กรอกข้อมูลไม่ครบ',
                    html: errors.join('<br>'),
                    confirmButtonText: 'ตกลง'
                });
            }
        });
    });

    document.querySelectorAll('.co-modal').forEach(function (modalEl) {
        modalEl.addEventListener('shown.bs.modal', function () {
            const modalBody = modalEl.querySelector('.co-modal-body');
            if (modalBody) {
                modalBody.scrollTop = 0;
            }
        });
    });

    // รองรับ DataTable ถ้ามีใช้งานอยู่
    if (window.jQuery && jQuery.fn.DataTable && jQuery.fn.DataTable.isDataTable('#datatable-caseoutside')) {
        setTimeout(function () {
            jQuery('#datatable-caseoutside').DataTable().columns.adjust();
        }, 150);
    }

    @if ($errors->any())
        @if (old('case_id'))
            (function () {
                const modalId = 'editCaseOutsideModal' + {{ old('case_id') }};
                const modalEl = document.getElementById(modalId);

                if (modalEl) {
                    const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                    modal.show();
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
                if (createModalEl) {
                    const modal = bootstrap.Modal.getOrCreateInstance(createModalEl);
                    modal.show();
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