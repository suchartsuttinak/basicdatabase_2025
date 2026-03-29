<div class="card border-0 shadow-sm vaccine-table-card">
    <div class="card-header bg-white border-0 px-3 py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h6 class="mb-0 fw-bold">
                <i class="bi bi-table me-2 text-primary"></i>รายการข้อมูลวัคซีน
            </h6>
        </div>
        <div class="small text-muted">
            จำนวน {{ $vaccinations->count() }} รายการ
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive vaccine-table-wrapper">
            <table id="datatable-vaccine" class="table table-hover align-middle mb-0 vaccine-table">
                <thead>
                    <tr>
                        <th style="min-width: 130px;">วันที่รับวัคซีน</th>
                        <th style="min-width: 180px;">ชนิดวัคซีน</th>
                        <th style="min-width: 180px;">สถานพยาบาล</th>
                        <th style="min-width: 180px;">หมายเหตุ</th>
                        <th style="min-width: 140px;">ผู้บันทึก</th>
                        <th class="text-center" style="min-width: 200px;">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($vaccinations as $item)
                        <tr>
                            <td>{{ $item->date ?? '-' }}</td>
                            <td>{{ $item->vaccine_name ?? '-' }}</td>
                            <td>{{ $item->hospital ?? '-' }}</td>
                            <td>{{ $item->remark ?? '-' }}</td>
                            <td>{{ $item->recorder ?? '-' }}</td>
                            <td class="text-center">
                                <div class="action-group">
                                    <button type="button"
                                            class="btn btn-warning btn-sm action-btn"
                                            onclick="vaccineEdit({{ $item->id }})">
                                        <i class="bi bi-pencil-square"></i>
                                        <span>แก้ไข</span>
                                    </button>

                                    <button type="button"
                                            class="btn btn-danger btn-sm action-btn"
                                            onclick="confirmDelete('delete-form-item-{{ $item->id }}', 'คุณต้องการลบข้อมูลนี้ใช่หรือไม่')">
                                        <i class="bi bi-trash"></i>
                                        <span>ลบ</span>
                                    </button>
                                </div>

                                <form id="delete-form-item-{{ $item->id }}"
                                      action="{{ route('vaccine.delete', $item->id) }}"
                                      method="POST"
                                      class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>