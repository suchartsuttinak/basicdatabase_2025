@props([
    'name' => 'record_date',
    'label' => 'วันที่',
    'value' => null,
])

<div class="mb-3">
    <label for="{{ $name }}_display" class="form-label fw-bold">
        {{ $label }} <span class="text-danger">*</span>
    </label>

    {{-- ช่องที่ผู้ใช้เห็น (พ.ศ.) --}}
    <input
        type="text"
        id="{{ $name }}_display"
        class="form-control"
        autocomplete="off"
        required
    >

    {{-- ช่องซ่อนสำหรับส่งค่า ค.ศ. ไป DB --}}
    <input
        type="hidden"
        name="{{ $name }}"
        id="{{ $name }}"
        value="{{ old($name, $value ? \Carbon\Carbon::parse($value)->format('Y-m-d') : '') }}"
    >

    <small id="{{ $name }}_hint" class="text-primary fw-bold"></small>

    @error($name)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>

@push('scripts')
<script>
$(function() {
    const displayInput = $('#{{ $name }}_display');
    const hiddenInput = $('#{{ $name }}');
    const hint = $('#{{ $name }}_hint');

    // Pre-fill display (edit case)
    if (hiddenInput.val()) {
        const d = new Date(hiddenInput.val());
        const day = String(d.getDate()).padStart(2, '0');
        const month = String(d.getMonth() + 1).padStart(2, '0');
        const thaiYear = d.getFullYear() + 543;
        displayInput.val(`${day}/${month}/${thaiYear}`);
    }

    // Init Thai datepicker
    displayInput.datepicker({
        format: 'dd/mm/yyyy',
        language: 'th',
        thaiyear: true,
        autoclose: true,
        todayHighlight: true
    }).on('changeDate', function(e) {
        const gDate = e.date;
        const yyyy = gDate.getFullYear();
        const mm = String(gDate.getMonth() + 1).padStart(2, '0');
        const dd = String(gDate.getDate()).padStart(2, '0');

        hiddenInput.val(`${yyyy}-${mm}-${dd}`);
        hint.text(`วันที่ (พ.ศ.): ${dd}/${mm}/${yyyy + 543}`);
    });
});
</script>
@endpush