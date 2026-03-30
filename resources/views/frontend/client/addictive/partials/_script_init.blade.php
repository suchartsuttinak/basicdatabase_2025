@if ($errors->any())
<script>
document.addEventListener('DOMContentLoaded', function () {
    const createModalEl = document.getElementById('createAddictiveModal');
    if (createModalEl) {
        const modal = new bootstrap.Modal(createModalEl);
        modal.show();
    }
});
</script>
@endif