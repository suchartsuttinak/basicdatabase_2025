document.addEventListener('DOMContentLoaded', function () {
    function removeValidationState(container) {
        container.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        container.querySelectorAll('.invalid-feedback.dynamic-feedback').forEach(el => el.remove());
    }

    function resetForm(modalEl) {
        const form = modalEl.querySelector('form');
        if (form) form.reset();

        removeValidationState(modalEl);

        if (modalEl.id === 'add-medical-modal') {
            const referNoNew = document.getElementById('refer_no_new');
            const sectionNew = document.getElementById('medical-section-new');

            if (referNoNew) referNoNew.checked = true;
            if (sectionNew) sectionNew.style.display = 'none';
        }

        if (modalEl.id === 'editMedicalModal') {
            const section = document.getElementById('edit_medical_section');
            if (section) section.style.display = 'none';
        }
    }

    function toggleSection(sectionEl, referYesEl) {
        if (!sectionEl || !referYesEl) return;
        sectionEl.style.display = referYesEl.checked ? 'block' : 'none';
    }

    function attachRealtimeValidationClear(form) {
        form.querySelectorAll('input, textarea, select').forEach(el => {
            ['input', 'change'].forEach(evt => {
                el.addEventListener(evt, () => {
                    if (el.classList.contains('is-invalid')) {
                        el.classList.remove('is-invalid');
                    }

                    const next = el.nextElementSibling;
                    if (next && next.classList.contains('invalid-feedback') && next.classList.contains('dynamic-feedback')) {
                        next.remove();
                    }
                });
            });
        });
    }

    const addModal = document.getElementById('add-medical-modal');
    if (addModal) {
        addModal.addEventListener('hidden.bs.modal', () => resetForm(addModal));

        const addForm = addModal.querySelector('form');
        if (addForm) attachRealtimeValidationClear(addForm);

        const sectionNew = document.getElementById('medical-section-new');
        const referYesNew = document.getElementById('refer_yes_new');
        const referNoNew = document.getElementById('refer_no_new');

        if (referYesNew && referNoNew && sectionNew) {
            toggleSection(sectionNew, referYesNew);
            referYesNew.addEventListener('change', () => toggleSection(sectionNew, referYesNew));
            referNoNew.addEventListener('change', () => toggleSection(sectionNew, referYesNew));
        }
    }

    const editModal = document.getElementById('editMedicalModal');
    if (editModal) {
        editModal.addEventListener('hidden.bs.modal', () => resetForm(editModal));

        const editForm = editModal.querySelector('form');
        if (editForm) attachRealtimeValidationClear(editForm);

        const section = document.getElementById('edit_medical_section');
        const referYes = document.getElementById('edit_refer_yes');
        const referNo = document.getElementById('edit_refer_no');

        if (referYes && referNo && section) {
            referYes.addEventListener('change', () => toggleSection(section, referYes));
            referNo.addEventListener('change', () => toggleSection(section, referYes));
        }
    }
});

function openEditMedical(id) {
    fetch(`/medical/json/${id}`)
        .then(response => response.json())
        .then(data => {
            const form = document.getElementById('editMedicalForm');
            form.action = `/medical/update/${data.id}`;

            document.getElementById('edit_medical_id').value = data.id ?? '';
            document.getElementById('edit_client_id').value = data.client_id ?? '';
            document.getElementById('edit_medical_date').value = data.medical_date ?? '';
            document.getElementById('edit_disease_name').value = data.disease_name ?? '';
            document.getElementById('edit_illness').value = data.illness ?? '';
            document.getElementById('edit_treatment').value = data.treatment ?? '';
            document.getElementById('edit_diagnosis').value = data.diagnosis ?? '';
            document.getElementById('edit_appt_date').value = data.appt_date ?? '';
            document.getElementById('edit_teacher').value = data.teacher ?? '';
            document.getElementById('edit_remark').value = data.remark ?? '';

            const referYes = document.getElementById('edit_refer_yes');
            const referNo = document.getElementById('edit_refer_no');
            const section = document.getElementById('edit_medical_section');

            if ((data.refer ?? '') === 'พบแพทย์') {
                referYes.checked = true;
                referNo.checked = false;
                section.style.display = 'block';
            } else {
                referNo.checked = true;
                referYes.checked = false;
                section.style.display = 'none';
            }

            bootstrap.Modal.getOrCreateInstance(document.getElementById('editMedicalModal')).show();
        })
        .catch(error => console.error('Error loading medical data:', error));
}

function showEditErrors(errors) {
    const form = document.getElementById('editMedicalForm');

    Object.keys(errors).forEach(field => {
        const input = form.querySelector(`[name="${field}"]`);
        if (input) {
            input.classList.add('is-invalid');

            const feedback = document.createElement('div');
            feedback.classList.add('invalid-feedback', 'dynamic-feedback');
            feedback.textContent = errors[field][0];

            input.insertAdjacentElement('afterend', feedback);
        }
    });
}