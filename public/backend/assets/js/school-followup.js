$(function () {
    const formSelector = '#edit-followup-form';
    const modalId = 'editFollowupModal';

    function buildUrl(template, id) {
        return template.replace(':id', id);
    }

    function clearValidation(form) {
        form.find('.is-invalid').removeClass('is-invalid');
        form.find('.invalid-feedback').text('');
    }

    function showError(message) {
        Swal.fire({
            icon: 'error',
            title: 'เกิดข้อผิดพลาด',
            text: message
        });
    }

    window.openEditFollowup = function (id) {
        const form = $(formSelector);

        if (!form.length) {
            showError('ไม่พบฟอร์มแก้ไข กรุณาตรวจสอบ Edit Modal');
            return;
        }

        if (
            !window.schoolFollowupConfig ||
            !window.schoolFollowupConfig.editUrlTemplate ||
            !window.schoolFollowupConfig.updateUrlTemplate
        ) {
            showError('ยังไม่ได้กำหนด schoolFollowupConfig ใน Blade');
            return;
        }

        form[0].reset();
        clearValidation(form);

        $('#edit_followup_id').val('');
        $('#edit_education_record_id').val('');
        $('#edit_school_name').text('-');
        $('#edit_education_name').text('-');
        $('#edit_semester_name').text('-');
        $('#edit_academic_year').text('-');

        const editUrl = buildUrl(window.schoolFollowupConfig.editUrlTemplate, id);
        const updateUrl = buildUrl(window.schoolFollowupConfig.updateUrlTemplate, id);

        $.ajax({
            url: editUrl,
            type: 'GET',
            dataType: 'json',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            success: function (res) {
                if (!(res && res.success && res.data)) {
                    showError(res?.message || 'ไม่สามารถโหลดข้อมูลได้');
                    return;
                }

                const data = res.data;

                $('#edit_followup_id').val(data.id ?? '');
                $('#edit_education_record_id').val(data.education_record_id ?? '');
                $('#edit_follow_date').val(data.follow_date ?? '');
                $('#edit_teacher_name').val(data.teacher_name ?? '');
                $('#edit_tel').val(data.tel ?? '');
                $('#edit_result').val(data.result ?? '');
                $('#edit_remark').val(data.remark ?? '');
                $('#edit_contact_name').val(data.contact_name ?? '');

                $(`${formSelector} input[name="follow_type"]`).prop('checked', false);
                if (data.follow_type) {
                    $(`${formSelector} input[name="follow_type"][value="${data.follow_type}"]`).prop('checked', true);
                }

                $('#edit_school_name').text(data.school_name ?? '-');
                $('#edit_education_name').text(data.education_name ?? '-');
                $('#edit_semester_name').text(data.semester_name ?? '-');
                $('#edit_academic_year').text(data.academic_year ?? '-');

                form.attr('action', updateUrl);

                const modalEl = document.getElementById(modalId);
                const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                modal.show();
            },
            error: function (xhr) {
                console.error('Edit load error:', xhr);
                showError(xhr.responseJSON?.message || 'ไม่สามารถโหลดข้อมูลได้');
            }
        });
    };

    $(formSelector).on('submit', function (e) {
        e.preventDefault();

        const form = $(this);
        const id = $('#edit_followup_id').val();

        if (!id) {
            showError('ไม่พบรหัสข้อมูลสำหรับอัปเดต');
            return;
        }

        const updateUrl = buildUrl(window.schoolFollowupConfig.updateUrlTemplate, id);
        clearValidation(form);

        $.ajax({
            url: updateUrl,
            type: 'POST',
            data: form.serialize(),
            dataType: 'json',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            success: function (res) {
                if (res && res.success) {
                    Swal.fire({
                        icon: 'success',
                        title: res.message || 'อัปเดตข้อมูลเรียบร้อย',
                        timer: 1200,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.reload();
                    });
                    return;
                }

                showError(res?.message || 'ไม่สามารถอัปเดตข้อมูลได้');
            },
            error: function (xhr) {
                const errors = xhr.responseJSON?.errors || {};

                $.each(errors, function (key, messages) {
                    if (key === 'follow_type') {
                        const container = form.find('input[name="follow_type"]').closest('.col-12');
                        container.find('.invalid-feedback').first().text(messages[0]);
                        return;
                    }

                    const input = form.find(`[name="${key}"]`);
                    if (input.length) {
                        input.addClass('is-invalid');
                        input.closest('.col-md-4, .col-md-6, .col-12')
                            .find('.invalid-feedback')
                            .first()
                            .text(messages[0]);
                    }
                });

                showError(xhr.responseJSON?.message || 'กรุณาตรวจสอบข้อมูล');
            }
        });
    });
});

function confirmDelete(id) {
    Swal.fire({
        title: 'ยืนยันการลบข้อมูล',
        text: 'คุณต้องการลบรายการนี้ใช่หรือไม่',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'ลบข้อมูล',
        cancelButtonText: 'ยกเลิก',
        confirmButtonColor: '#dc3545'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id)?.submit();
        }
    });
}