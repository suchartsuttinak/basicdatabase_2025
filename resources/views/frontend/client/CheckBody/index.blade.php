@extends('admin_client.admin_client')

@section('content')
@php
    use App\Helpers\ThaiDateHelper;
    $isEdit = isset($checkbody) && $checkbody;
@endphp

<style>
    .checkbody-page {
        --primary-soft: #eef4ff;
        --border-soft: #e7ecf3;
        --text-muted-soft: #6c757d;
        --success-soft: #edf9f1;
        --warning-soft: #fff8e6;
        --card-radius: 18px;
    }

    .checkbody-page .page-header-card,
    .checkbody-page .form-card,
    .checkbody-page .table-card,
    .checkbody-page .summary-card {
        border: 0;
        border-radius: var(--card-radius);
        box-shadow: 0 10px 30px rgba(26, 54, 93, .06);
        overflow: hidden;
    }

    .checkbody-page .page-header-card {
        background: linear-gradient(135deg, #ffffff 0%, #f7faff 100%);
    }

    .checkbody-page .section-title {
        font-size: 1rem;
        font-weight: 700;
        margin-bottom: 0;
        color: #1f2d3d;
    }

    .checkbody-page .section-subtitle {
        color: var(--text-muted-soft);
        font-size: .875rem;
        margin-bottom: 0;
    }

    .checkbody-page .info-pill {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        padding: .45rem .8rem;
        border-radius: 999px;
        background: #fff;
        border: 1px solid var(--border-soft);
        font-size: .82rem;
        color: #334155;
        white-space: nowrap;
    }

    .checkbody-page .summary-card {
        background: #fff;
        height: 100%;
    }

    .checkbody-page .summary-label {
        font-size: .78rem;
        color: var(--text-muted-soft);
        margin-bottom: .2rem;
    }

    .checkbody-page .summary-value {
        font-weight: 700;
        color: #1f2937;
        font-size: .95rem;
        word-break: break-word;
    }

    .checkbody-page .form-card .card-header,
    .checkbody-page .table-card .card-header {
        background: #fff;
        border-bottom: 1px solid var(--border-soft);
        padding: 1rem 1.25rem;
    }

    .checkbody-page .form-card .card-body,
    .checkbody-page .table-card .card-body {
        padding: 1.25rem;
    }

    .checkbody-page .modern-label {
        font-size: .86rem;
        font-weight: 600;
        margin-bottom: .45rem;
        color: #334155;
    }

    .checkbody-page .modern-label .required {
        color: #dc3545;
    }

    .checkbody-page .form-control,
    .checkbody-page .form-select {
        border-radius: 12px;
        border: 1px solid #dbe3ee;
        padding: .65rem .85rem;
        font-size: .92rem;
        min-height: 44px;
        box-shadow: none;
    }

    .checkbody-page textarea.form-control {
        min-height: 100px;
    }

    .checkbody-page .form-control:focus,
    .checkbody-page .form-select:focus {
        border-color: #7aa7ff;
        box-shadow: 0 0 0 .18rem rgba(13, 110, 253, .10);
    }

    .checkbody-page .radio-card-group {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: .75rem;
    }

    .checkbody-page .radio-card {
        position: relative;
    }

    .checkbody-page .radio-card input[type="radio"] {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .checkbody-page .radio-card label {
        display: flex;
        align-items: center;
        gap: .75rem;
        border: 1px solid #dbe3ee;
        border-radius: 14px;
        padding: .95rem 1rem;
        background: #fff;
        cursor: pointer;
        transition: all .2s ease;
        min-height: 58px;
        font-weight: 600;
        color: #334155;
    }

    .checkbody-page .radio-card label .icon-wrap {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: var(--primary-soft);
        color: #0d6efd;
        flex-shrink: 0;
    }

    .checkbody-page .radio-card input[type="radio"]:checked + label {
        border-color: #86b7fe;
        background: #f8fbff;
        box-shadow: 0 0 0 .18rem rgba(13, 110, 253, .08);
    }

    .checkbody-page .metric-box {
        border: 1px dashed #cdd8e6;
        background: #fafcff;
        border-radius: 16px;
        padding: 1rem;
    }

    .checkbody-page .btn-modern {
        border-radius: 12px;
        font-size: .9rem;
        font-weight: 600;
        padding: .62rem .95rem;
    }

    .checkbody-page .btn-icon {
        width: 34px;
        height: 34px;
        padding: 0;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .checkbody-page .table thead th {
        font-size: .82rem;
        font-weight: 700;
        color: #334155;
        background: #f8fafc;
        border-bottom-width: 1px;
        vertical-align: middle;
        white-space: nowrap;
    }

    .checkbody-page .table tbody td {
        font-size: .88rem;
        vertical-align: middle;
    }

    .checkbody-page .badge-soft-success {
        background: #edf9f1;
        color: #198754;
        border: 1px solid #cdebd8;
        font-weight: 700;
    }

    .checkbody-page .badge-soft-warning {
        background: #fff8e6;
        color: #b7791f;
        border: 1px solid #f6dea3;
        font-weight: 700;
    }

    .checkbody-page .empty-state {
        border: 1px dashed #d9e2ef;
        border-radius: 18px;
        padding: 2rem 1rem;
        text-align: center;
        background: linear-gradient(180deg, #ffffff 0%, #fbfdff 100%);
    }

    .checkbody-page .empty-state .empty-icon {
        width: 64px;
        height: 64px;
        margin: 0 auto 1rem;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--primary-soft);
        color: #0d6efd;
        font-size: 1.6rem;
    }

    .checkbody-page .sticky-tools {
        display: flex;
        flex-wrap: wrap;
        gap: .6rem;
        justify-content: flex-end;
    }

    @media (max-width: 991.98px) {
        .checkbody-page .sticky-tools {
            justify-content: flex-start;
        }
    }

    @media (max-width: 767.98px) {
        .checkbody-page .radio-card-group {
            grid-template-columns: 1fr;
        }

        .checkbody-page .form-card .card-body,
        .checkbody-page .table-card .card-body,
        .checkbody-page .form-card .card-header,
        .checkbody-page .table-card .card-header {
            padding: 1rem;
        }
    }
</style>

<div class="container-fluid px-2 px-lg-3 checkbody-page">
    <div class="page-header-card card mb-3">
        <div class="card-body p-3 p-lg-4">
            <div class="row g-3 align-items-center">
                <div class="col-lg-8">
                    <div class="d-flex flex-column gap-2">
                        <div>
                            <h4 class="mb-1 fw-bold">
                                <i class="bi bi-heart-pulse me-2 text-primary"></i>บันทึกการตรวจสุขภาพเบื้องต้น
                            </h4>
                            <p class="section-subtitle">
                                จัดเก็บข้อมูลการตรวจร่างกาย พัฒนาการ และสุขภาพทั่วไปอย่างเป็นระบบ
                            </p>
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <span class="info-pill">
                                <i class="bi bi-person"></i>
                                ชื่อผู้รับบริการ:
                                <strong>{{ $client->fullname ?? $client->name ?? '-' }}</strong>
                            </span>

                            @if(!empty($client->age))
                                <span class="info-pill">
                                    <i class="bi bi-calendar-heart"></i>
                                    อายุ:
                                    <strong>{{ $client->age }} ปี</strong>
                                </span>
                            @endif

                            <span class="info-pill">
                                <i class="bi bi-clipboard2-pulse"></i>
                                จำนวนบันทึก:
                                <strong>{{ $checkbodies->count() }}</strong>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="sticky-tools">
                        <button
                            type="button"
                            class="btn btn-primary btn-modern"
                            data-bs-toggle="collapse"
                            data-bs-target="#checkBodyFormCollapse"
                            aria-expanded="{{ $errors->any() || $isEdit ? 'true' : 'false' }}"
                            aria-controls="checkBodyFormCollapse"
                            id="toggleCheckBodyBtn"
                        >
                            <i class="bi {{ $errors->any() || $isEdit ? 'bi-chevron-up' : 'bi-plus-circle' }} me-1"></i>
                            <span>{{ $isEdit ? 'แก้ไขข้อมูล' : 'เพิ่มผลการตรวจ' }}</span>
                        </button>

                        @if($isEdit)
                            <a href="{{ route('check_body.add', $client->id) }}" class="btn btn-outline-secondary btn-modern">
                                <i class="bi bi-arrow-counterclockwise me-1"></i>ยกเลิกการแก้ไข
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-md-6 col-xl-3">
            <div class="summary-card card">
                <div class="card-body">
                    <div class="summary-label">วันที่ตรวจล่าสุด</div>
                    <div class="summary-value">
                        {{ ThaiDateHelper::formatThaiShort(optional($checkbodies->first())->assessor_date) }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="summary-card card">
                <div class="card-body">
                    <div class="summary-label">สมวัย</div>
                    <div class="summary-value">{{ $checkbodies->where('development', 'สมวัย')->count() }}</div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="summary-card card">
                <div class="card-body">
                    <div class="summary-label">ไม่สมวัย</div>
                    <div class="summary-value">{{ $checkbodies->where('development', 'ไม่สมวัย')->count() }}</div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="summary-card card">
                <div class="card-body">
                    <div class="summary-label">สถานะหน้าฟอร์ม</div>
                    <div class="summary-value">{{ $isEdit ? 'กำลังแก้ไขข้อมูล' : 'พร้อมเพิ่มรายการใหม่' }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="collapse {{ $errors->any() || $isEdit ? 'show' : '' }}" id="checkBodyFormCollapse">
        @include('frontend.client.checkBody._form')
    </div>

    @include('frontend.client.checkBody._table')
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const devNormal = document.getElementById('development_normal');
        const devAbnormal = document.getElementById('development_abnormal');
        const detailField = document.getElementById('development-detail-field');

        const devTypeNormal = document.getElementById('development_type_normal');
        const devTypeSpecial = document.getElementById('development_type_special');
        const specialSupportSection = document.getElementById('special-support-section');
        const specialSupportType = document.getElementById('special_support_type');
        const specialSupportOtherWrap = document.getElementById('special-support-other-wrap');
        const specialSupportOther = document.getElementById('special_support_other');

        const formCollapse = document.getElementById('checkBodyFormCollapse');
        const toggleBtn = document.getElementById('toggleCheckBodyBtn');

        function toggleDevelopmentDetail() {
            if (!detailField || !devNormal || !devAbnormal) return;
            detailField.style.display = devAbnormal.checked ? 'block' : 'none';
        }

        function toggleSpecialSupportSection() {
            if (!specialSupportSection || !devTypeNormal || !devTypeSpecial) return;

            if (devTypeSpecial.checked) {
                specialSupportSection.style.display = 'block';
            } else {
                specialSupportSection.style.display = 'none';

                if (specialSupportType) {
                    specialSupportType.value = '';
                }

                if (specialSupportOtherWrap) {
                    specialSupportOtherWrap.style.display = 'none';
                }

                if (specialSupportOther) {
                    specialSupportOther.value = '';
                }
            }

            toggleSpecialSupportOther();
        }

        function toggleSpecialSupportOther() {
            if (!specialSupportType || !specialSupportOtherWrap || !specialSupportOther) return;

            if (specialSupportType.value === 'อื่น ๆ') {
                specialSupportOtherWrap.style.display = 'block';
            } else {
                specialSupportOtherWrap.style.display = 'none';
                specialSupportOther.value = '';
            }
        }

        if (devNormal && devAbnormal) {
            devNormal.addEventListener('change', toggleDevelopmentDetail);
            devAbnormal.addEventListener('change', toggleDevelopmentDetail);
            toggleDevelopmentDetail();
        }

        if (devTypeNormal && devTypeSpecial) {
            devTypeNormal.addEventListener('change', toggleSpecialSupportSection);
            devTypeSpecial.addEventListener('change', toggleSpecialSupportSection);
            toggleSpecialSupportSection();
        }

        if (specialSupportType) {
            specialSupportType.addEventListener('change', toggleSpecialSupportOther);
            toggleSpecialSupportOther();
        }

        if (formCollapse && toggleBtn) {
            formCollapse.addEventListener('shown.bs.collapse', function () {
                const icon = toggleBtn.querySelector('i');
                const text = toggleBtn.querySelector('span');
                if (icon) icon.className = 'bi bi-chevron-up me-1';
                if (text && !@json($isEdit)) text.textContent = 'ซ่อนฟอร์ม';
            });

            formCollapse.addEventListener('hidden.bs.collapse', function () {
                const icon = toggleBtn.querySelector('i');
                const text = toggleBtn.querySelector('span');
                if (icon) icon.className = 'bi bi-plus-circle me-1';
                if (text && !@json($isEdit)) text.textContent = 'เพิ่มผลการตรวจ';
            });
        }

        const form = document.querySelector('#checkbody-form');
        if (form) {
            form.querySelectorAll('input, textarea, select').forEach(function (field) {
                field.addEventListener('input', function () {
                    field.classList.remove('is-invalid');
                });
                field.addEventListener('change', function () {
                    field.classList.remove('is-invalid');
                });
            });
        }

        if (window.jQuery && $.fn.DataTable && document.getElementById('datatable-checkbody')) {
            $('#datatable-checkbody').DataTable({
                responsive: true,
                autoWidth: false,
                order: [[1, 'desc']],
                pageLength: 10,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/th.json'
                },
                columnDefs: [
                    { orderable: false, targets: [7] }
                ]
            });
        }
    });

    function confirmDelete(id) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'ยืนยันการลบข้อมูล',
                text: 'เมื่อลบแล้วจะไม่สามารถกู้คืนได้',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ลบข้อมูล',
                cancelButtonText: 'ยกเลิก',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        } else {
            if (confirm('ยืนยันการลบข้อมูลนี้ใช่หรือไม่?')) {
                document.getElementById('delete-form-' + id).submit();
            }
        }
    }
</script>

@if ($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'พบข้อผิดพลาด',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                icon: 'error',
                confirmButtonText: 'ตกลง'
            });
        }
    });
</script>
@endif
@endpush