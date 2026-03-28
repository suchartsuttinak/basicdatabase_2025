@if($absents->isNotEmpty())
    <div class="card shadow-sm border-0 table-card">
        <div class="card-header bg-white border-0 px-3 px-md-4 pt-3 pt-md-4 pb-2">
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2">
                <div>
                    <h5 class="section-title mb-1 d-flex align-items-center">
                        <i class="bi bi-table me-2 text-primary"></i>รายการบันทึกการขาดเรียน
                    </h5>
                    <p class="section-subtitle mb-0">
                        แสดงรายการข้อมูลการขาดเรียนที่บันทึกไว้ สามารถแก้ไข ลบ และออกรายงานได้
                    </p>
                </div>

                <div class="section-badge">
                    ทั้งหมด {{ $absents->count() }} รายการ
                </div>
            </div>
        </div>

        <div class="card-body p-3 p-md-4 pt-2">
            <div class="table-responsive custom-table-wrap">
                <table id="datatable-absent" class="table modern-table align-middle w-100 mb-0">
                    <thead>
                        <tr class="text-center">
                            <th style="width: 15%">วันที่ขาดเรียน</th>
                            <th style="width: 15%">วันที่บันทึก</th>
                            <th style="width: 28%">สาเหตุ</th>
                            <th style="width: 20%">ผู้ดูแลเด็ก</th>
                            <th style="width: 22%" class="text-center action-col">การจัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($absents as $item)
                            <tr>
                                <td class="text-center fw-semibold">
                                    {{ \Carbon\Carbon::parse($item->absent_date)->format('d/m/Y') }}
                                </td>

                                <td class="text-center fw-semibold">
                                    {{ !empty($item->record_date) ? \Carbon\Carbon::parse($item->record_date)->format('d/m/Y') : '-' }}
                                </td>

                                <td title="{{ $item->cause }}">
                                    <div class="table-text-wrap">
                                        {{ \Illuminate\Support\Str::limit($item->cause ?? '-', 60) }}
                                    </div>
                                </td>

                                <td>
                                    <div class="teacher-name-cell">
                                        {{ $item->teacher ?? '-' }}
                                    </div>
                                </td>

                                <td class="text-center">
                                    <div class="table-action-group">
                                        <button type="button"
                                                class="btn btn-warning btn-sm action-btn"
                                                onclick="openEditAbsent({{ $item->id }})">
                                            <i class="bi bi-pencil-square me-1"></i>แก้ไข
                                        </button>

                                        <button type="button"
                                                class="btn btn-danger btn-sm action-btn"
                                                onclick="confirmDelete({{ $item->id }})">
                                            <i class="bi bi-trash me-1"></i>ลบ
                                        </button>

                                        <a href="{{ route('absent.report', $item->id) }}"
                                           class="btn btn-info btn-sm action-btn text-white">
                                            <i class="bi bi-file-earmark-text me-1"></i>รายงาน
                                        </a>
                                    </div>

                                    <form id="delete-form-{{ $item->id }}"
                                          action="{{ route('absent.delete', $item->id) }}"
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
@else
    <div class="card border-0 shadow-sm table-card">
        <div class="card-body empty-state">
            <div class="empty-icon">
                <i class="bi bi-journal-x"></i>
            </div>
            <h5 class="empty-title">ยังไม่มีข้อมูลการขาดเรียน</h5>
            <p class="empty-text mb-0">
                เมื่อมีการบันทึกข้อมูลการขาดเรียน รายการจะแสดงในส่วนนี้เพื่อใช้ติดตาม แก้ไข และออกรายงานต่อไป
            </p>
        </div>
    </div>
@endif