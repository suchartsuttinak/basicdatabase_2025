document.addEventListener('DOMContentLoaded', function () {
    const createModalEl = document.getElementById('createPsychiatricModal');
    const editModalEl = document.getElementById('editPsychiatricModal');
    const createForm = document.getElementById('psychiatric-form');
    const editForm = document.getElementById('psychiatric-edit-form');

    function clearValidation(form) {
        if (!form) return;

        form.querySelectorAll('.is-invalid').forEach(el => {
            el.classList.remove('is-invalid');
        });

        form.querySelectorAll('.invalid-feedback.dynamic-feedback').forEach(el => {
            el.remove();
        });
    }

    function showError(el, message) {
        if (!el) return;

        el.classList.add('is-invalid');

        let feedback = el.parentElement.querySelector('.invalid-feedback.dynamic-feedback');
        if (!feedback) {
            feedback = document.createElement('div');
            feedback.className = 'invalid-feedback dynamic-feedback';
            el.parentElement.appendChild(feedback);
        }

        feedback.textContent = message;
    }

    function attachRealtimeValidationClear(form) {
        if (!form) return;

        form.querySelectorAll('input, select, textarea').forEach(el => {
            ['input', 'change'].forEach(evt => {
                el.addEventListener(evt, function () {
                    el.classList.remove('is-invalid');

                    const feedback = el.parentElement.querySelector('.invalid-feedback.dynamic-feedback');
                    if (feedback) feedback.remove();
                });
            });
        });
    }

    function attachThaiValidation(form) {
        if (!form || form.dataset.validationAttached === 'true') return;
        form.dataset.validationAttached = 'true';

        form.addEventListener('submit', function (e) {
            clearValidation(form);

            let valid = true;

            const sentDate = form.querySelector('[name="sent_date"]');
            const hospital = form.querySelector('[name="hotpital"]');
            const psychoId = form.querySelector('[name="psycho_id"]');

            if (sentDate && !sentDate.value) {
                showError(sentDate, 'กรุณาระบุวันที่ส่งตรวจ');
                valid = false;
            }

            if (hospital && !hospital.value.trim()) {
                showError(hospital, 'กรุณาระบุสถานพยาบาล');
                valid = false;
            }

            if (psychoId && !psychoId.value) {
                showError(psychoId, 'กรุณาเลือกผลการตรวจวินิจฉัย');
                valid = false;
            }

            if (!valid) e.preventDefault();
        });
    }

    function toggleDrugField(form, yesSelector, fieldSelector, inputSelector) {
        if (!form) return;

        const yesInput = form.querySelector(yesSelector);
        const field = form.querySelector(fieldSelector);
        const input = form.querySelector(inputSelector);
        const noInput = form.querySelector(`${yesSelector.replace('yes', 'no')}`);

        function update() {
            if (!field || !yesInput) return;

            if (yesInput.checked) {
                field.style.display = 'block';
            } else {
                field.style.display = 'none';
                if (input) input.value = '';
            }
        }

        if (yesInput) yesInput.addEventListener('change', update);
        if (noInput) noInput.addEventListener('change', update);
        update();
    }

    function resetForm(form) {
        if (!form) return;
        form.reset();
        clearValidation(form);
    }

    attachRealtimeValidationClear(createForm);
    attachRealtimeValidationClear(editForm);
    attachThaiValidation(createForm);
    attachThaiValidation(editForm);

    toggleDrugField(createForm, '#drug_yes_new', '#drug_name_field_new', 'input[name="drug_name"]');
    toggleDrugField(editForm, '#edit_drug_yes', '#edit_drug_name_field', '#edit_drug_name');

    if (createModalEl) {
        createModalEl.addEventListener('hidden.bs.modal', function () {
            resetForm(createForm);

            const drugField = createForm?.querySelector('#drug_name_field_new');
            if (drugField) drugField.style.display = 'none';

            const defaultNo = createForm?.querySelector('#drug_no_new');
            if (defaultNo) defaultNo.checked = true;
        });
    }

    if (editModalEl) {
        editModalEl.addEventListener('hidden.bs.modal', function () {
            resetForm(editForm);

            const drugField = editForm?.querySelector('#edit_drug_name_field');
            if (drugField) drugField.style.display = 'none';

            editForm.action = '';
        });
    }

    window.openEditPsychiatric = function (id) {
        fetch(`${window.psychiatricConfig.editJsonUrl}/${id}`)
            .then(response => response.json())
            .then(data => {
                if (!editForm || !editModalEl) return;

                editForm.action = `${window.psychiatricConfig.updateBaseUrl}/${data.id}`;

                document.getElementById('edit_id').value = data.id ?? '';
                document.getElementById('edit_sent_date').value = data.sent_date ?? '';
                document.getElementById('edit_hotpital').value = data.hotpital ?? '';
                document.getElementById('edit_psycho_id').value = data.psycho_id ?? '';
                document.getElementById('edit_diagnose').value = data.diagnose ?? '';
                document.getElementById('edit_appoin_date').value = data.appoin_date ?? '';
                document.getElementById('edit_drug_name').value = data.drug_name ?? '';

                const drugYes = document.getElementById('edit_drug_yes');
                const drugNo = document.getElementById('edit_drug_no');
                const disaYes = document.getElementById('edit_disa_yes');
                const disaNo = document.getElementById('edit_disa_no');
                const drugField = document.getElementById('edit_drug_name_field');

                if (data.drug_no === 'yes') {
                    if (drugYes) drugYes.checked = true;
                    if (drugField) drugField.style.display = 'block';
                } else {
                    if (drugNo) drugNo.checked = true;
                    if (drugField) drugField.style.display = 'none';
                    const drugName = document.getElementById('edit_drug_name');
                    if (drugName) drugName.value = '';
                }

                if (data.disa_no === 'yes') {
                    if (disaYes) disaYes.checked = true;
                } else {
                    if (disaNo) disaNo.checked = true;
                }

                clearValidation(editForm);

                const modal = new bootstrap.Modal(editModalEl);
                modal.show();
            })
            .catch(error => {
                console.error('โหลดข้อมูลแก้ไขไม่สำเร็จ:', error);
                alert('ไม่สามารถโหลดข้อมูลเพื่อแก้ไขได้');
            });
    };
});