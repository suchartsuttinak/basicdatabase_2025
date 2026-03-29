document.addEventListener('DOMContentLoaded', function () {
    function clearValidation(form) {
        if (!form) return;

        form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        form.querySelectorAll('.invalid-feedback.dynamic-feedback').forEach(el => el.remove());
    }

    function resetForm(modalEl) {
        const form = modalEl?.querySelector('form');
        if (!form) return;

        form.reset();
        clearValidation(form);
    }

    function attachRealtimeValidationClear(form) {
        if (!form) return;

        form.querySelectorAll('input, select, textarea').forEach(el => {
            ['input', 'change'].forEach(evt => {
                el.addEventListener(evt, () => {
                    el.classList.remove('is-invalid');

                    const next = el.nextElementSibling;
                    if (next && next.classList.contains('invalid-feedback')) {
                        next.remove();
                    }
                });
            });
        });
    }

    const addModal = document.getElementById('add-vaccine-modal');
    const editModal = document.getElementById('edit-vaccine-modal');

    if (addModal) {
        addModal.addEventListener('hidden.bs.modal', () => resetForm(addModal));
        attachRealtimeValidationClear(addModal.querySelector('form'));
    }

    if (editModal) {
        editModal.addEventListener('hidden.bs.modal', () => resetForm(editModal));
        attachRealtimeValidationClear(editModal.querySelector('form'));
    }

    if (window.jQuery && $('#datatable-vaccine').length) {
        $('#datatable-vaccine').DataTable({
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/th.json'
            }
        });
    }
});

function vaccineEdit(id) {
    fetch(`/vaccine/edit/${id}`)
        .then(response => response.json())
        .then(data => {
            const modalEl = document.getElementById('edit-vaccine-modal');
            const form = document.getElementById('edit-vaccine-form');

            if (!modalEl || !form) return;

            form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
            form.querySelectorAll('.invalid-feedback.dynamic-feedback').forEach(el => el.remove());

            document.getElementById('edit_client_id').value = data.client_id ?? '';
            document.getElementById('edit_date').value = data.date ?? '';
            document.getElementById('edit_vaccine_name').value = data.vaccine_name ?? '';
            document.getElementById('edit_hospital').value = data.hospital ?? '';
            document.getElementById('edit_recorder').value = data.recorder ?? '';
            document.getElementById('edit_remark').value = data.remark ?? '';

            form.action = `/vaccine/update/${data.id}`;

            bootstrap.Modal.getOrCreateInstance(modalEl).show();
        })
        .catch(error => console.error('Error loading vaccine data:', error));
}