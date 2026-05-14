@extends('admin_client.admin_client')

@section('content')

<style>
    .help-session-create-wrap{
        padding-bottom: 110px;
    }

    .help-session-save-area{
        margin-top: 24px;
        margin-bottom: 60px;
        padding-bottom: 24px;
    }

    .help-session-save-btn{
        border: none;
        border-radius: 999px;
        padding: 11px 28px;
        font-weight: 600;
        letter-spacing: .2px;
        background: linear-gradient(135deg, #16a34a, #22c55e);
        box-shadow: 0 10px 22px rgba(34, 197, 94, .28);
        transition: all .2s ease;
    }

    .help-session-save-btn:hover:not(:disabled){
        transform: translateY(-1px);
        box-shadow: 0 14px 28px rgba(34, 197, 94, .34);
    }

    .help-session-save-btn:disabled{
        opacity: .55;
        cursor: not-allowed;
        background: #94a3b8;
        box-shadow: none;
    }

    @media (max-width: 768px){
        .help-session-create-wrap{
            padding-bottom: 140px;
        }

        .help-session-save-area{
            text-align: center !important;
            margin-bottom: 80px;
        }

        .help-session-save-area .btn{
            width: 100%;
        }
    }
</style>

{{-- ต้องเพิ่ม enctype เพื่อรองรับการอัปโหลดไฟล์ --}}
<div class="container help-session-create-wrap">
    <h5 class="mb-4 text-center fw-bold mt-4 text-primary">
        เพิ่มการช่วยเหลือใหม่สำหรับ {{ $client->full_name }}
    </h5>

    <form action="{{ route('help_sessions.store', $client->id) }}" method="POST">
        @csrf

        {{-- ฟิลด์วันที่ --}}
        <div class="card mb-4">
            <div class="card-header">
                ข้อมูลการช่วยเหลือ
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="help_date" class="form-label fw-bold">วันที่ให้ความช่วยเหลือ</label>
                    <input type="date" name="help_date" id="help_date"
                        class="form-control"
                        value="{{ old('help_date', date('Y-m-d')) }}" required>
                    <small class="text-muted">สามารถเลือกย้อนหลังได้</small>
                </div>
            </div>
        </div>

        {{-- ตารางรายการ --}}
        <div class="card mb-4">
            <div class="card-header">
                รายการช่วยเหลือ
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="items-table">
                    <thead class="table-light">
                        <tr>
                            <th>รายการ</th>
                            <th>จำนวน</th>
                            <th>ราคา/หน่วย</th>
                            <th>ราคารวม</th>
                            <th>จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- เริ่มต้นไม่มีแถว --}}
                    </tbody>
                </table>

                <div class="mt-3">
                    <a href="{{ route('help_sessions.show', $client->id) }}?page={{ request('page') }}"
                       class="btn btn-outline-secondary btn-sm me-2">
                        <i class="bi bi-arrow-left-circle me-1"></i> กลับหน้าหลัก
                    </a>

                    <button type="button" class="btn btn-primary btn-sm" id="add-row">
                        <i class="bi bi-plus-circle me-1"></i> เพิ่มรายการ
                    </button>
                </div>
            </div>
        </div>

        {{-- ปุ่มบันทึก --}}
        <div class="text-end help-session-save-area">
            <button type="submit"
                    id="save-btn"
                    class="btn btn-success help-session-save-btn"
                    disabled>
                <i class="bi bi-save2 me-1"></i> บันทึกการช่วยเหลือ
            </button>
        </div>
    </form>
</div>

<script>
    let rowIndex = 0;

    function toggleSaveButton() {
        const tableBody = document.querySelector('#items-table tbody');
        const saveBtn = document.getElementById('save-btn');
        const helpDate = document.getElementById('help_date').value;

        let isValid = true;

        if (!helpDate) {
            isValid = false;
        }

        if (tableBody.children.length === 0) {
            isValid = false;
        }

        tableBody.querySelectorAll('tr').forEach(row => {
            const itemName = row.querySelector('input[name*="[item_name]"]')?.value.trim();
            const quantity = row.querySelector('.quantity')?.value;
            const unitPrice = row.querySelector('.unit_price')?.value;

            if (
                !itemName ||
                !quantity ||
                Number(quantity) <= 0 ||
                unitPrice === '' ||
                Number(unitPrice) < 0
            ) {
                isValid = false;
            }
        });

        saveBtn.disabled = !isValid;
    }

    document.getElementById('add-row').addEventListener('click', function () {
        const tableBody = document.querySelector('#items-table tbody');
        const newRow = document.createElement('tr');

        newRow.innerHTML = `
            <td><input type="text" name="items[${rowIndex}][item_name]" class="form-control item-name" required></td>
            <td><input type="number" name="items[${rowIndex}][quantity]" class="form-control quantity" min="1" required></td>
            <td><input type="number" step="0.01" name="items[${rowIndex}][unit_price]" class="form-control unit_price" min="0" required></td>
            <td><input type="text" class="form-control total_price" readonly></td>
            <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="bi bi-trash"></i> ลบ</button></td>
        `;

        tableBody.appendChild(newRow);
        rowIndex++;
        toggleSaveButton();
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-row') || e.target.closest('.remove-row')) {
            e.target.closest('tr').remove();
            toggleSaveButton();
        }
    });

    document.addEventListener('input', function (e) {
        if (e.target.classList.contains('quantity') || e.target.classList.contains('unit_price')) {
            const row = e.target.closest('tr');
            const quantity = parseFloat(row.querySelector('.quantity').value) || 0;
            const unitPrice = parseFloat(row.querySelector('.unit_price').value) || 0;
            const totalPriceField = row.querySelector('.total_price');

            totalPriceField.value = quantity && unitPrice ? (quantity * unitPrice).toFixed(2) : '';
        }

        toggleSaveButton();
    });

    document.getElementById('help_date').addEventListener('change', function () {
        toggleSaveButton();
    });

    // Preview ภาพที่เลือก
    const imagesInput = document.getElementById('images');
    if (imagesInput) {
        imagesInput.addEventListener('change', function (event) {
            const preview = document.getElementById('preview-images');
            preview.innerHTML = '';

            const files = event.target.files;
            if (files) {
                Array.from(files).forEach(file => {
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.classList.add('img-thumbnail');
                            img.style.width = '150px';
                            img.style.height = 'auto';
                            preview.appendChild(img);
                        }
                        reader.readAsDataURL(file);
                    }
                });
            }
        });
    }

    // ✅ ตรวจสอบวันที่ซ้ำแบบ AJAX
    document.getElementById('help_date').addEventListener('change', function () {
        const selectedDate = this.value;
        const clientId = "{{ $client->id }}";

        if (selectedDate) {
            fetch(`/check-duplicate-date/${clientId}?date=${selectedDate}`)
                .then(response => response.json())
                .then(data => {
                    if (data.exists) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'วันที่ซ้ำ',
                            text: `วันที่ ${selectedDate} มีการบันทึกแล้ว`,
                            confirmButtonText: 'ตกลง'
                        });

                        this.value = "";
                        toggleSaveButton();
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    });

    toggleSaveButton();
</script>

{{-- ต้องมี SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if($errors->has('help_date'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'ไม่สามารถบันทึกได้',
        text: '{{ $errors->first("help_date") }}',
        confirmButtonText: 'ตกลง'
    });
</script>
@endif

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'สำเร็จ',
        text: '{{ session("success") }}',
        confirmButtonText: 'ตกลง'
    });
</script>
@endif

@endsection