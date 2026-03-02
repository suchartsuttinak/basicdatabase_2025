@extends('admin_client.admin_client')

@section('content')
<div class="container">
    <h5 class="mb-4 text-center fw-bold mt-4 text-primary">
        แก้ไขการช่วยเหลือสำหรับ {{ $client->full_name }}
    </h5>

    <form action="{{ route('help_sessions.update', ['client' => $client->id, 'session' => $session->id]) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- ฟิลด์วันที่ --}}
        <div class="card mb-4">
            <div class="card-header">ข้อมูลการช่วยเหลือ</div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="help_date" class="form-label fw-bold">วันที่ให้ความช่วยเหลือ</label>
                    <input type="date" name="help_date" id="help_date"
                           class="form-control"
                           value="{{ old('help_date', $session->help_date) }}" required>
                    <small class="text-muted">สามารถเลือกย้อนหลังได้</small>
                </div>
            </div>
        </div>

        {{-- ตารางรายการ --}}
        <div class="card mb-4">
            <div class="card-header">รายการช่วยเหลือ</div>
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
                        @foreach($session->items as $index => $item)
                            <tr>
                                <td><input type="text" name="items[{{ $index }}][item_name]"
                                           value="{{ $item->item_name }}" class="form-control" required></td>
                                <td><input type="number" name="items[{{ $index }}][quantity]"
                                           value="{{ $item->quantity }}" class="form-control quantity" min="1" required></td>
                                <td><input type="number" step="0.01" name="items[{{ $index }}][unit_price]"
                                           value="{{ $item->unit_price }}" class="form-control unit_price" required></td>
                                <td><input type="text" class="form-control total_price"
                                           value="{{ number_format($item->total_price, 2) }}" readonly></td>
                                <td><button type="button" class="btn btn-danger btn-sm remove-row">ลบ</button></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            <div class="mt-3 d-flex gap-2">
                {{-- ปุ่มกลับหน้าหลัก --}}
                <a href="{{ route('help_sessions.show', $client->id) }}?page={{ request('page') }}"  
                class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left-circle me-1"></i> กลับหน้าหลัก
                </a>

                {{-- ปุ่มเพิ่มรายการ --}}
                <button type="button" class="btn btn-primary btn-sm" id="add-row">
                    <i class="bi bi-plus-circle me-1"></i> เพิ่มรายการ
                </button>
            </div>
            {{-- ปุ่มบันทึก --}}
                    <div class="text-end">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-save me-1"></i> บันทึกการแก้ไข
                        </button>
                    </div>
                            </div>
                        </div>
                    </div>   
                </form>
            </div>

    <script>
    let rowIndex = {{ $session->items->count() }};

    document.getElementById('add-row').addEventListener('click', function () {
        const tableBody = document.querySelector('#items-table tbody');
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td><input type="text" name="items[${rowIndex}][item_name]" class="form-control" required></td>
            <td><input type="number" name="items[${rowIndex}][quantity]" class="form-control quantity" min="1" required></td>
            <td><input type="number" step="0.01" name="items[${rowIndex}][unit_price]" class="form-control unit_price" required></td>
            <td><input type="text" class="form-control total_price" readonly></td>
            <td><button type="button" class="btn btn-danger btn-sm remove-row">ลบ</button></td>
        `;
        tableBody.appendChild(newRow);
        rowIndex++;
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-row') || e.target.closest('.remove-row')) {
            e.target.closest('tr').remove();
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
</script>
@endsection