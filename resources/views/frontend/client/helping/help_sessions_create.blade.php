@extends('admin_client.admin_client')

@section('content')


    {{-- ต้องเพิ่ม enctype เพื่อรองรับการอัปโหลดไฟล์ --}}
   <div class="container">
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
        <div class="text-end">
            <button type="submit" id="save-btn" class="btn btn-success" disabled>
                <i class="bi bi-save me-1"></i> บันทึกการช่วยเหลือ
            </button>
        </div>
    </form>
</div>

<script>
    let rowIndex = 0;

    function toggleSaveButton() {
        const tableBody = document.querySelector('#items-table tbody');
        const saveBtn = document.getElementById('save-btn');
        saveBtn.disabled = tableBody.children.length === 0;
    }

    document.getElementById('add-row').addEventListener('click', function () {
        const tableBody = document.querySelector('#items-table tbody');
        const newRow = document.createElement('tr');

        newRow.innerHTML = `
            <td><input type="text" name="items[${rowIndex}][item_name]" class="form-control" required></td>
            <td><input type="number" name="items[${rowIndex}][quantity]" class="form-control quantity" min="1" required></td>
            <td><input type="number" step="0.01" name="items[${rowIndex}][unit_price]" class="form-control unit_price" required></td>
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
    });

    // Preview ภาพที่เลือก
    const imagesInput = document.getElementById('images');
    if (imagesInput) {
        imagesInput.addEventListener('change', function (event) {
            const preview = document.getElementById('preview-images');
            preview.innerHTML = ''; // เคลียร์ภาพเดิมก่อน

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
                        this.value = ""; // เคลียร์ค่าออกเพื่อบังคับให้เลือกใหม่
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