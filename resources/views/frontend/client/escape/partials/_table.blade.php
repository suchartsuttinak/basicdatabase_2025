{{-- Table Card --}}
        <div class="escape-table-card">
            <div class="escape-table-card__header">
                <div class="escape-table-card__title-wrap">
                    <div class="escape-table-card__icon">
                        <i class="bi bi-table"></i>
                    </div>
                    <div>
                        <h6 class="escape-table-card__title mb-0">รายการข้อมูลการออกจากสถานสงเคราะห์</h6>
                        <div class="escape-table-card__subtitle">แสดงข้อมูลที่บันทึกไว้ทั้งหมด</div>
                    </div>
                </div>

                <div class="escape-table-card__count">
                    จำนวน {{ $escapes->count() }} รายการ
                </div>
            </div>

            <div class="escape-table-card__body p-0">
                @if($escapes->count() > 0)
                    <div class="table-responsive escape-table-wrapper">
                        <table class="table align-middle mb-0 escape-table">
                            <thead>
                                <tr>
                                    <th style="min-width: 80px;" class="text-center">ลำดับ</th>
                                    <th style="min-width: 130px;">วันที่ออก</th>
                                    <th style="min-width: 220px;">ประเภทการออก</th>
                                    <th style="min-width: 280px;">พฤติการณ์ / สาเหตุ</th>
                                    <th style="min-width: 250px;" class="text-center">การจัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($escapes as $escape)
                                    <tr>
                                        <td class="text-center">
                                            <span class="escape-row-index">{{ $loop->iteration }}</span>
                                        </td>

                                        <td>
                                            <div class="escape-table__date">
                                                {{ $escape->retire_date ? $escape->retire_date->format('d/m/Y') : '-' }}
                                            </div>
                                        </td>

                                        <td>
                                            <div class="escape-table__primary">
                                                {{ $escape->retire->retire_name ?? '-' }}
                                            </div>
                                        </td>

                                        <td>
                                            <div class="escape-table__remark">
                                                {{ $escape->stories ?? '-' }}
                                            </div>
                                        </td>

                                        <td class="text-center">
                                            <div class="escape-action-group">
                                                <a href="{{ route('escape.edit', $escape->id) }}"
                                                   class="btn escape-action-btn escape-action-btn--follow">
                                                    <i class="bi bi-arrow-repeat"></i>
                                                    <span>ติดตาม</span>
                                                </a>

                                                <button type="button"
                                                        class="btn escape-action-btn escape-action-btn--edit"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#escapeEditModal{{ $escape->id }}">
                                                    <i class="bi bi-pencil-square"></i>
                                                    <span>แก้ไข</span>
                                                </button>

                                                <form id="delete-form-{{ $escape->id }}"
                                                      action="{{ route('escape.delete', $escape->id) }}"
                                                      method="POST"
                                                      class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                            class="btn escape-action-btn escape-action-btn--delete"
                                                            onclick="confirmDelete('delete-form-{{ $escape->id }}','คุณต้องการลบข้อมูลนี้ใช่หรือไม่')">
                                                        <i class="bi bi-trash"></i>
                                                        <span>ลบ</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="escape-empty-state">
                        <div class="escape-empty-state__icon">
                            <i class="bi bi-inboxes"></i>
                        </div>
                        <div class="escape-empty-state__title">ยังไม่มีข้อมูลการออกจากสถานสงเคราะห์</div>
                        <div class="escape-empty-state__desc">เมื่อมีการบันทึกข้อมูล รายการจะแสดงในส่วนนี้</div>
                    </div>
                @endif
            </div>
        </div>
    </div>
