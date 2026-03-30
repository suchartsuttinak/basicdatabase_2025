document.addEventListener('DOMContentLoaded', function () {
    const createModalEl = document.getElementById('createAddictiveModal');
    const editModalEl = document.getElementById('editAddictiveModal');
    const createForm = document.getElementById('addictive-form');
    const editForm = document.getElementById('addictive-edit-form');

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

            const date = form.querySelector('[name="date"]');
            const examChecked = form.querySelector('[name="exam"]:checked');
            const recorder = form.querySelector('[name="recorder"]');
            const referField = form.querySelector('[name="refer"]');
            const examYes = form.querySelector('[name="exam"][value="1"]');

            if (date && !date.value) {
                showError(date, 'กรุณาระบุวันที่ตรวจ');
                valid = false;
            }

            if (!examChecked) {
                const examInputs = form.querySelectorAll('[name="exam"]');
                if (examInputs.length > 0) {
                    showError(examInputs[examInputs.length - 1], 'กรุณาเลือกผลการตรวจ');
                }
                valid = false;
            }

            if (recorder && !recorder.value.trim()) {
                showError(recorder, 'กรุณาระบุชื่อผู้ตรวจ');
                valid = false;
            }

            if (examYes && examYes.checked) {
                const referChecked = form.querySelector('[name="refer"]:checked');
                if (!referChecked && referField) {
                    const referInputs = form.querySelectorAll('[name="refer"]');
                    if (referInputs.length > 0) {
                        showError(referInputs[referInputs.length - 1], 'กรุณาเลือกการส่งต่อ');
                    }
                    valid = false;
                }
            }

            if (!valid) e.preventDefault();
        });
    }

    function toggleReferField(form, yesSelector, fieldSelector) {
        if (!form) return;

        const examYes = form.querySelector(yesSelector);
        const examNo = form.querySelector(yesSelector.replace('yes', 'no'));
        const referField = form.querySelector(fieldSelector);
        const referInputs = form.querySelectorAll('[name="refer"]');

        function update() {
            if (!referField || !examYes) return;

            if (examYes.checked) {
                referField.style.display = 'flex';
            } else {
                referField.style.display = 'none';
                referInputs.forEach(input => input.checked = false);
            }
        }

        if (examYes) examYes.addEventListener('change', update);
        if (examNo) examNo.addEventListener('change', update);

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

    toggleReferField(createForm, '#exam_yes_new', '#refer_field_new');
    toggleReferField(editForm, '#edit_exam_yes', '#edit_refer_field');

    if (createModalEl) {
        createModalEl.addEventListener('hidden.bs.modal', function () {
            resetForm(createForm);

            const referField = document.getElementById('refer_field_new');
            if (referField) referField.style.display = 'none';

            const examNo = document.getElementById('exam_no_new');
            if (examNo) examNo.checked = true;
        });
    }

    if (editModalEl) {
        editModalEl.addEventListener('hidden.bs.modal', function () {
            resetForm(editForm);

            const referField = document.getElementById('edit_refer_field');
            if (referField) referField.style.display = 'none';

            const referTreatment = document.getElementById('edit_refer_treatment');
            const referFollowup = document.getElementById('edit_refer_followup');
            if (referTreatment) referTreatment.checked = false;
            if (referFollowup) referFollowup.checked = false;

            editForm.action = '';
        });
    }

    window.openEditAddictive = function (id) {
    fetch(`${window.addictiveConfig.jsonUrl}/${id}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (!editForm || !editModalEl) return;

            editForm.action = `${window.addictiveConfig.updateBaseUrl}/${data.id}`;

            document.getElementById('edit_id').value = data.id ?? '';
            document.getElementById('edit_date').value = data.date ?? '';
            document.getElementById('edit_count').value = data.count ?? '';
            document.getElementById('edit_record').value = data.record ?? '';
            document.getElementById('edit_recorder').value = data.recorder ?? '';

            const examYes = document.getElementById('edit_exam_yes');
            const examNo = document.getElementById('edit_exam_no');
            const referField = document.getElementById('edit_refer_field');
            const referTreatment = document.getElementById('edit_refer_treatment');
            const referFollowup = document.getElementById('edit_refer_followup');

            if (examYes) examYes.checked = false;
            if (examNo) examNo.checked = false;
            if (referTreatment) referTreatment.checked = false;
            if (referFollowup) referFollowup.checked = false;

            if (String(data.exam) === '1') {
                if (examYes) examYes.checked = true;
                if (referField) referField.style.display = 'flex';
            } else {
                if (examNo) examNo.checked = true;
                if (referField) referField.style.display = 'none';
            }

            if (String(data.refer) === '1' && referTreatment) {
                referTreatment.checked = true;
            } else if (String(data.refer) === '2' && referFollowup) {
                referFollowup.checked = true;
            }

            const modal = new bootstrap.Modal(editModalEl);
            modal.show();
        })
        .catch(error => {
            console.error('โหลดข้อมูลแก้ไขไม่สำเร็จ:', error);
            alert('ไม่สามารถโหลดข้อมูลเพื่อแก้ไขได้');
        });
};
});