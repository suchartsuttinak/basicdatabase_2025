@php use App\Helpers\ThaiDateHelper; @endphp

<div class="table-card card">
    <div class="card-header d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-2">
        <div>
            <h5 class="section-title">
                <i class="bi bi-table me-2 text-primary"></i>รายการตรวจสุขภาพเบื้องต้น
            </h5>
            <p class="section-subtitle">
                แสดงรายการล่าสุดก่อน พร้อมปุ่มแก้ไข ลบ และพิมพ์รายงาน
            </p>
        </div>
        <div>
            <span class="badge text-bg-light border">ทั้งหมด {{ $checkbodies->count() }} รายการ</span>
        </div>
    </div>

    <div class="card-body">
        @if($checkbodies->isNotEmpty())
            <div class="table-responsive">
                <table id="datatable-checkbody" class="table table-hover align-middle w-100 mb-0">
                    <thead>
                        <tr>
                            <th style="width: 70px;">ลำดับ</th>
                            <th style="width: 120px;">วันที่ตรวจ</th>
                            <th style="width: 120px;">พัฒนาการ</th>
                            <th>น้ำหนัก / ส่วนสูง</th>
                            <th>สุขภาพ</th>
                            <th>ผู้ตรวจ</th>
                            <th>หมายเหตุ</th>
                            <th class="text-center" style="width: 150px;">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($checkbodies as $index => $row)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ ThaiDateHelper::formatThaiShort($row->assessor_date) }}</td>
                                <td class="text-center">
                                    @if(($row->development ?? '') === 'สมวัย')
                                        <span class="badge rounded-pill badge-soft-success">สมวัย</span>
                                    @else
                                        <span class="badge rounded-pill badge-soft-warning">ไม่สมวัย</span>
                                    @endif
                                </td>
                                <td>
                                    นน. {{ $row->weight ?? '-' }} กก. /
                                    สส. {{ $row->height ?? '-' }} ซม.
                                </td>
                                <td>{{ $row->health ?? '-' }}</td>
                                <td>{{ $row->recorder ?? '-' }}</td>
                                <td>
                                    @if(!empty($row->remark))
                                        {{ \Illuminate\Support\Str::limit($row->remark, 60) }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-inline-flex flex-nowrap gap-1">
                                        <a href="{{ route('check_body.edit', $row->id) }}"
                                           class="btn btn-warning btn-icon"
                                           title="แก้ไข">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <button type="button"
                                                class="btn btn-danger btn-icon"
                                                onclick="confirmDelete({{ $row->id }})"
                                                title="ลบ">
                                            <i class="bi bi-trash"></i>
                                        </button>

                                        <a href="{{ route('check_body.report', $row->id) }}"
                                           class="btn btn-info btn-icon text-white"
                                           title="รายงาน">
                                            <i class="bi bi-printer"></i>
                                        </a>
                                    </div>

                                    <form id="delete-form-{{ $row->id }}"
                                          action="{{ route('check_body.delete', $row->id) }}"
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
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="bi bi-clipboard2-pulse"></i>
                </div>
                <h6 class="fw-bold mb-2">ยังไม่มีข้อมูลการตรวจสุขภาพ</h6>
                <p class="text-muted mb-3">
                    เริ่มต้นโดยกดปุ่ม “เพิ่มผลการตรวจ” ด้านบนเพื่อบันทึกรายการแรก
                </p>
                <button
                    type="button"
                    class="btn btn-primary btn-modern"
                    data-bs-toggle="collapse"
                    data-bs-target="#checkBodyFormCollapse"
                    aria-expanded="false"
                    aria-controls="checkBodyFormCollapse"
                >
                    <i class="bi bi-plus-circle me-1"></i>เพิ่มผลการตรวจ
                </button>
            </div>
        @endif
    </div>
</div>