@if ($errors->any())
<script>
document.addEventListener('DOMContentLoaded', function () {
    const createModalEl = document.getElementById('createPsychiatricModal');
    if (createModalEl) {
        const modal = new bootstrap.Modal(createModalEl);
        modal.show();
    }
});
</script>
@endif