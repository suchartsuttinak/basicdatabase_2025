@extends('admin_client.admin_client')

@section('content')
@php
    use Carbon\Carbon;

    $isEdit = isset($accident) && $accident;
    $hasAccidentRows = isset($accidents) && $accidents->count() > 0;
@endphp

<style>
.accident-page {
    --acc-primary: #2563eb;
    --acc-primary-soft: #eef4ff;
    --acc-border-soft: #e7ecf3;
    --acc-text-muted: #6c757d;
    --acc-card-radius: 18px;
    --acc-shadow: 0 10px 30px rgba(26, 54, 93, .06);
    --acc-shadow-sm: 0 4px 12px rgba(15, 23, 42, .05);
}

.accident-page .page-header-card,
.accident-page .form-card,
.accident-page .table-card,
.accident-page .summary-card,
.accident-page .empty-card {
    border: 0;
    border-radius: var(--acc-card-radius);
    box-shadow: var(--acc-shadow);
    overflow: hidden;
    background: #fff;
}

.accident-page .page-header-card,
.accident-page .empty-card {
    background: linear-gradient(135deg, #ffffff 0%, #f7faff 100%);
}

.accident-page .accident-section-subtitle {
    color: var(--acc-text-muted);
    font-size: .875rem;
    margin-bottom: 0;
    line-height: 1.7;
}

.accident-page .info-pill {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    padding: .45rem .8rem;
    border-radius: 999px;
    background: #fff;
    border: 1px solid var(--acc-border-soft);
    font-size: .82rem;
    color: #334155;
    white-space: nowrap;
    box-shadow: var(--acc-shadow-sm);
}

.accident-page .summary-card {
    height: 100%;
}

.accident-page .summary-label {
    font-size: .78rem;
    color: var(--acc-text-muted);
    margin-bottom: .2rem;
}

.accident-page .summary-value {
    font-weight: 700;
    color: #1f2937;
    font-size: .95rem;
    word-break: break-word;
}

.accident-page .form-card .card-header,
.accident-page .table-card .card-header {
    background: #fff;
    border-bottom: 1px solid var(--acc-border-soft);
    padding: 1rem 1.25rem;
}

.accident-page .form-card .card-body,
.accident-page .table-card .card-body {
    padding: 1.25rem;
}

.accident-page .accident-label {
    font-size: .86rem;
    font-weight: 600;
    margin-bottom: .45rem;
    color: #334155;
}

.accident-page .accident-label .required {
    color: #dc3545;
}

.accident-page .form-control,
.accident-page .form-select {
    border-radius: 12px;
    border: 1px solid #dbe3ee;
    padding: .65rem .85rem;
    font-size: .92rem;
    min-height: 44px;
    box-shadow: none;
    background: #fff;
}

.accident-page textarea.form-control {
    min-height: 100px;
}

.accident-page .form-control:focus,
.accident-page .form-select:focus {
    border-color: #7aa7ff;
    box-shadow: 0 0 0 .18rem rgba(13, 110, 253, .10);
}

.accident-page .radio-card-group {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: .75rem;
}

.accident-page .radio-card {
    position: relative;
}

.accident-page .radio-card input[type="radio"] {
    position: absolute;
    opacity: 0;
    pointer-events: none;
}

.accident-page .radio-card label {
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
    margin: 0;
}

.accident-page .radio-card label .icon-wrap {
    width: 34px;
    height: 34px;
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: var(--acc-primary-soft);
    color: var(--acc-primary);
    flex-shrink: 0;
}

.accident-page .radio-card input[type="radio"]:checked + label {
    border-color: #86b7fe;
    background: #f8fbff;
    box-shadow: 0 0 0 .18rem rgba(13, 110, 253, .08);
}

.accident-page .medical-box {
    border: 1px dashed #cdd8e6;
    background: #fafcff;
    border-radius: 16px;
    padding: 1rem;
}

.accident-page .btn-modern {
    border-radius: 12px;
    font-size: .9rem;
    font-weight: 600;
    padding: .62rem .95rem;
}

.accident-page .btn-icon {
    width: 34px;
    height: 34px;
    padding: 0;
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.accident-page .table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

.accident-page .table {
    margin-bottom: 0;
}

.accident-page .table thead th {
    font-size: .82rem;
    font-weight: 700;
    color: #334155;
    background: #f8fafc;
    border-bottom-width: 1px;
    vertical-align: middle;
    white-space: nowrap;
}

.accident-page .table tbody td {
    font-size: .88rem;
    vertical-align: middle;
}

.accident-page .badge-soft-success {
    background: #edf9f1;
    color: #198754;
    border: 1px solid #cdebd8;
    font-weight: 700;
}

.accident-page .badge-soft-secondary {
    background: #f3f4f6;
    color: #6b7280;
    border: 1px solid #e5e7eb;
    font-weight: 700;
}

.accident-page .empty-card {
    padding: 3.25rem 1.25rem;
    text-align: center;
    border: 1px solid var(--acc-border-soft);
}

.accident-page .empty-icon {
    width: 86px;
    height: 86px;
    margin: 0 auto 1rem;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: var(--acc-primary-soft);
    color: var(--acc-primary);
    font-size: 2.15rem;
    box-shadow: 0 12px 28px rgba(37, 99, 235, .14);
}

.accident-page .empty-card h5 {
    margin: 0 0 .5rem;
    color: #1f2937;
    font-size: 1.25rem;
    font-weight: 800;
}

.accident-page .empty-card p {
    max-width: 660px;
    margin: 0 auto 1.35rem;
    color: #64748b;
    line-height: 1.8;
}

.accident-page .sticky-tools {
    display: flex;
    flex-wrap: wrap;
    gap: .6rem;
    justify-content: flex-end;
}

.accident-page .modal-content {
    border-radius: 18px;
    overflow: hidden;
    border: 0;
}

.accident-page .modal-header {
    border-bottom: 1px solid var(--acc-border-soft);
}

.accident-page .modal-footer {
    border-top: 1px solid var(--acc-border-soft);
}

@media (max-width: 991.98px) {
    .accident-page .sticky-tools {
        justify-content: flex-start;
    }

    .accident-page .info-pill {
        white-space: normal;
    }
}

@media (max-width: 767.98px) {
    .accident-page .radio-card-group {
        grid-template-columns: 1fr;
    }

    .accident-page .form-card .card-body,
    .accident-page .table-card .card-body,
    .accident-page .form-card .card-header,
    .accident-page .table-card .card-header {
        padding: 1rem;
    }

    .accident-page .sticky-tools {
        flex-direction: column;
        align-items: stretch;
    }

    .accident-page .sticky-tools .btn,
    .accident-page .sticky-tools .btn-modern {
        width: 100%;
    }

    .accident-page .empty-card {
        padding: 2.5rem 1rem;
    }

    .accident-page .empty-icon {
        width: 74px;
        height: 74px;
        font-size: 1.85rem;
    }
}

@media (max-width: 575.98px) {
    .accident-page .page-header-card,
    .accident-page .form-card,
    .accident-page .table-card,
    .accident-page .summary-card,
    .accident-page .empty-card {
        border-radius: 14px;
    }
}
</style>

<div class="container-fluid px-2 px-lg-3 accident-page">
    <div class="page-header-card card mb-3">
        <div class="card-body p-3 p-lg-4">
            <div class="row g-3 align-items-center">
                <div class="col-lg-8">
                    <div class="d-flex flex-column gap-2">
                        <div>
                            <h4 class="mb-1 fw-bold">
                                <i class="bi bi-shield-plus me-2 text-primary"></i>
                                บันทึกข้อมูลการบาดเจ็บ
                            </h4>
                            <p class="accident-section-subtitle">
                                จัดเก็บประวัติการบาดเจ็บ การรักษา และการติดตามอาการอย่างเป็นระบบ
                            </p>
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <span class="info-pill">
                                <i class="bi bi-person"></i>
                                ชื่อผู้รับบริการ:
                                <strong>{{ $client->name ?? $client->fullname ?? '-' }}</strong>
                            </span>

                            @if(!empty($client->cid))
                                <span class="info-pill">
                                    <i class="bi bi-card-text"></i>
                                    เลขประจำตัวประชาชน:
                                    <strong>{{ $client->cid }}</strong>
                                </span>
                            @endif

                            @if($hasAccidentRows)
                                <span class="info-pill">
                                    <i class="bi bi-journal-medical"></i>
                                    จำนวนบันทึก:
                                    <strong>{{ $accidents->count() }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

              @if($accidents->count() || $isEdit || $errors->any())
                <div class="col-lg-4">
                    <div class="sticky-tools">

                        <button
                            type="button"
                            class="btn btn-primary btn-modern"
                            data-bs-toggle="collapse"
                            data-bs-target="#accidentFormCollapse"
                            aria-expanded="{{ $errors->any() || $isEdit ? 'true' : 'false' }}"
                            aria-controls="accidentFormCollapse"
                            id="toggleAccidentBtn"
                        >
                            <i class="bi {{ $errors->any() || $isEdit ? 'bi-chevron-up' : 'bi-plus-circle' }} me-1"></i>

                            <span>
                                {{ $isEdit ? 'แก้ไขข้อมูล' : 'เพิ่มข้อมูลการบาดเจ็บ' }}
                            </span>
                        </button>

                        @if($isEdit)
                            <a href="{{ route('accident.add', $client->id) }}"
                            class="btn btn-outline-secondary btn-modern">
                                <i class="bi bi-arrow-counterclockwise me-1"></i>
                                ยกเลิกการแก้ไข
                            </a>
                        @endif

                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    @if($hasAccidentRows)
        <div class="row g-3 mb-3">
            <div class="col-md-6 col-xl-3">
                <div class="summary-card card">
                    <div class="card-body">
                        <div class="summary-label">รายการล่าสุด</div>
                        <div class="summary-value">
                            {{ \App\Helpers\ThaiDateHelper::formatThaiShort(optional($accidents->first())->incident_date) }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="summary-card card">
                    <div class="card-body">
                        <div class="summary-label">จำนวนที่พบแพทย์</div>
                        <div class="summary-value">{{ $accidents->where('treat_no', 'พบแพทย์')->count() }}</div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="summary-card card">
                    <div class="card-body">
                        <div class="summary-label">จำนวนที่ไม่พบแพทย์</div>
                        <div class="summary-value">{{ $accidents->where('treat_no', 'ไม่พบแพทย์')->count() }}</div>
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
    @endif

    <div class="collapse {{ $errors->any() || $isEdit ? 'show' : '' }}" id="accidentFormCollapse">
        @include('frontend.client.accident._form')
    </div>

    @if($hasAccidentRows)
        @include('frontend.client.accident._table')
    @else
        <div class="empty-card mb-3">
            <div class="empty-icon">
                <i class="bi bi-shield-plus"></i>
            </div>

            <h5>ยังไม่มีข้อมูลการบาดเจ็บ</h5>

            <p>
                เมื่อยังไม่มีข้อมูล ระบบจะซ่อนการ์ดสรุปและตารางรายการไว้ก่อน
                เพื่อให้หน้าจอดูสะอาด อ่านง่าย และไม่แสดงข้อมูลว่างโดยไม่จำเป็น
            </p>

            <button
                type="button"
                class="btn btn-primary btn-modern"
                data-bs-toggle="collapse"
                data-bs-target="#accidentFormCollapse"
            >
                <i class="bi bi-plus-circle me-1"></i>
                เพิ่มข้อมูลการบาดเจ็บครั้งแรก
            </button>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const treatYes = document.getElementById('treat_yes');
        const treatNo = document.getElementById('treat_no_option');
        const medicalSection = document.getElementById('medical-section');
        const formCollapse = document.getElementById('accidentFormCollapse');
        const toggleAccidentBtn = document.getElementById('toggleAccidentBtn');

        function toggleMedicalSection() {
            if (!medicalSection || !treatYes || !treatNo) return;
            medicalSection.style.display = treatYes.checked ? 'block' : 'none';
        }

        if (treatYes && treatNo) {
            treatYes.addEventListener('change', toggleMedicalSection);
            treatNo.addEventListener('change', toggleMedicalSection);
            toggleMedicalSection();
        }

        if (formCollapse && toggleAccidentBtn) {
            formCollapse.addEventListener('shown.bs.collapse', function () {
                const icon = toggleAccidentBtn.querySelector('i');
                const text = toggleAccidentBtn.querySelector('span');

                if (icon) icon.className = 'bi bi-chevron-up me-1';
                if (text && !@json($isEdit)) text.textContent = 'ซ่อนฟอร์ม';
            });

            formCollapse.addEventListener('hidden.bs.collapse', function () {
                const icon = toggleAccidentBtn.querySelector('i');
                const text = toggleAccidentBtn.querySelector('span');

                if (icon) icon.className = 'bi bi-plus-circle me-1';
                if (text && !@json($isEdit)) text.textContent = 'เพิ่มข้อมูลการบาดเจ็บ';
            });
        }

        const form = document.querySelector('#accident-form');

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

        if (window.jQuery && $.fn.DataTable && document.getElementById('datatable-accident')) {
            $('#datatable-accident').DataTable({
                responsive: true,
                autoWidth: false,
                order: [[0, 'desc']],
                pageLength: 10,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/th.json'
                },
                columnDefs: [
                    { orderable: false, targets: [8] }
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
        @if(session('message'))
            return;
        @endif

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