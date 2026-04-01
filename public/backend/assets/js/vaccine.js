document.addEventListener('DOMContentLoaded', function () {
    const addModal = document.getElementById('add-vaccine-modal');
    const editModal = document.getElementById('edit-vaccine-modal');

    function clearValidation(form) {
        if (!form) return;

        form.querySelectorAll('.is-invalid').forEach((el) => {
            el.classList.remove('is-invalid');
        });

        form.querySelectorAll('.invalid-feedback.dynamic-feedback').forEach((el) => {
            el.remove();
        });
    }

    function resetForm(modalEl) {
        const form = modalEl?.querySelector('form');
        if (!form) return;

        form.reset();
        clearValidation(form);
    }

    function removeFieldError(field) {
        if (!field) return;

        field.classList.remove('is-invalid');

        const next = field.nextElementSibling;
        if (next && next.classList.contains('invalid-feedback') && next.classList.contains('dynamic-feedback')) {
            next.remove();
        }
    }

    function attachRealtimeValidationClear(form) {
        if (!form) return;

        form.querySelectorAll('input, select, textarea').forEach((field) => {
            ['input', 'change'].forEach((eventName) => {
                field.addEventListener(eventName, function () {
                    removeFieldError(field);
                });
            });
        });
    }

    function initModalBehavior(modalEl) {
        if (!modalEl) return;

        const form = modalEl.querySelector('form');
        attachRealtimeValidationClear(form);

        modalEl.addEventListener('hidden.bs.modal', function () {
            resetForm(modalEl);
        });
    }

    function initVaccineDataTable() {
        if (!window.jQuery || !$.fn.DataTable || !$('#datatable-vaccine').length) {
            return;
        }

        if ($.fn.DataTable.isDataTable('#datatable-vaccine')) {
            $('#datatable-vaccine').DataTable().destroy();
        }

        $('#datatable-vaccine').DataTable({
            responsive: false,
            autoWidth: false,
            scrollX: true,
            pageLength: 10,
            order: [],
            language: {
                processing: 'กำลังประมวลผล...',
                lengthMenu: 'แสดง _MENU_ รายการต่อหน้า',
                zeroRecords: 'ไม่พบข้อมูล',
                emptyTable: 'ยังไม่มีข้อมูลในตาราง',
                info: 'แสดง _START_ ถึง _END_ จาก _TOTAL_ รายการ',
                infoEmpty: 'แสดง 0 ถึง 0 จาก 0 รายการ',
                infoFiltered: '(กรองจากทั้งหมด _MAX_ รายการ)',
                search: 'ค้นหา:',
                loadingRecords: 'กำลังโหลดข้อมูล...',
                paginate: {
                    first: 'หน้าแรก',
                    last: 'หน้าสุดท้าย',
                    next: 'ถัดไป',
                    previous: 'ก่อนหน้า'
                },
                aria: {
                    sortAscending: ': เรียงข้อมูลจากน้อยไปมาก',
                    sortDescending: ': เรียงข้อมูลจากมากไปน้อย'
                }
            },
            dom:
                "<'row g-3 align-items-center mb-2'<'col-12 col-md-6'l><'col-12 col-md-6'f>>" +
                "t" +
                "<'row g-3 align-items-center mt-2'<'col-12 col-md-5'i><'col-12 col-md-7'p>>"
        });
    }

    initModalBehavior(addModal);
    initModalBehavior(editModal);
    initVaccineDataTable();
});

function vaccineEdit(id) {
    const modalEl = document.getElementById('edit-vaccine-modal');
    const form = document.getElementById('edit-vaccine-form');

    if (!modalEl || !form || !id) return;

    form.querySelectorAll('.is-invalid').forEach((el) => {
        el.classList.remove('is-invalid');
    });

    form.querySelectorAll('.invalid-feedback.dynamic-feedback').forEach((el) => {
        el.remove();
    });

    fetch(`/vaccine/edit/${id}`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
        .then((response) => {
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}`);
            }
            return response.json();
        })
        .then((data) => {
            document.getElementById('edit_client_id').value = data.client_id ?? '';
            document.getElementById('edit_date').value = data.date ?? '';
            document.getElementById('edit_vaccine_name').value = data.vaccine_name ?? '';
            document.getElementById('edit_hospital').value = data.hospital ?? '';
            document.getElementById('edit_recorder').value = data.recorder ?? '';
            document.getElementById('edit_remark').value = data.remark ?? '';

            form.action = `/vaccine/update/${data.id}`;

            bootstrap.Modal.getOrCreateInstance(modalEl).show();
        })
        .catch((error) => {
            console.error('Error loading vaccine data:', error);
            alert('ไม่สามารถโหลดข้อมูลวัคซีนเพื่อแก้ไขได้');
        });
}