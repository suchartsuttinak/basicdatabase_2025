<div class="card border-0 shadow-sm vaccine-table-card vaccine-record-card">
    <div class="card-header vaccine-record-card__header">
        <div class="vaccine-record-card__title-wrap">
            <div class="vaccine-record-card__icon">
                <i class="bi bi-shield-plus"></i>
            </div>
            <div>
                <h6 class="vaccine-record-card__title mb-0">รายการข้อมูลวัคซีน</h6>
                <div class="vaccine-record-card__subtext">ประวัติการรับวัคซีนของผู้รับบริการ</div>
            </div>
        </div>

        <div class="vaccine-record-card__count">
            จำนวน {{ $vaccinations->count() }} รายการ
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive vaccine-table-wrapper vaccine-record-table-wrapper">
            <table id="datatable-vaccine" class="table table-hover align-middle mb-0 vaccine-table vaccine-record-table">
                <thead>
                    <tr>
                        <th style="min-width: 130px;">วันที่รับวัคซีน</th>
                        <th style="min-width: 180px;">ชนิดวัคซีน</th>
                        <th style="min-width: 180px;">สถานพยาบาล</th>
                        <th style="min-width: 220px;">หมายเหตุ</th>
                        <th style="min-width: 160px;">ผู้บันทึก</th>
                        <th class="text-center" style="min-width: 170px;">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($vaccinations as $item)
                        <tr>
                            <td>
                                <span class="vaccine-record-table__date">
                                    {{ $item->date ?? '-' }}
                                </span>
                            </td>

                            <td>
                                <div class="vaccine-record-table__primary">
                                    {{ $item->vaccine_name ?? '-' }}
                                </div>
                            </td>

                            <td>{{ $item->hospital ?? '-' }}</td>

                            <td>
                                <div class="vaccine-record-table__remark">
                                    {{ $item->remark ?? '-' }}
                                </div>
                            </td>

                            <td>{{ $item->recorder ?? '-' }}</td>

                            <td class="text-center">
                                <div class="vaccine-action-group">
                                    <button type="button"
                                            class="btn btn-warning vaccine-action-btn vaccine-action-btn--edit"
                                            onclick="vaccineEdit({{ $item->id }})">
                                        <i class="bi bi-pencil-square"></i>
                                        <span>แก้ไข</span>
                                    </button>

                                    <button type="button"
                                            class="btn btn-danger vaccine-action-btn vaccine-action-btn--delete"
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
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="vaccine-record-empty">
                                    <div class="vaccine-record-empty__icon">
                                        <i class="bi bi-inboxes"></i>
                                    </div>
                                    <div class="vaccine-record-empty__title">ยังไม่มีข้อมูลวัคซีน</div>
                                    <div class="vaccine-record-empty__text">เมื่อมีการบันทึกข้อมูล ระบบจะแสดงรายการในตารางนี้</div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>