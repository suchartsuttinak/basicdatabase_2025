@if($addictives->isNotEmpty())
    <div class="card border-0 shadow-sm addictive-table-card">
        <div class="card-body p-2">
            <div class="table-responsive addictive-table-wrap">
                <table id="datatable-addictive" class="table table-sm table-hover align-middle addictive-table mb-0">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 70px;">ลำดับ</th>
                            <th>วันที่ตรวจ</th>
                            <th class="text-center">ครั้งที่</th>
                            <th>ผลการตรวจ</th>
                            <th>การส่งต่อ</th>
                            <th>บันทึกผล</th>
                            <th>ผู้ตรวจ</th>
                            <th class="text-center" style="min-width: 220px;">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($addictives as $index => $addictive)
                            <tr id="row-addictive-{{ $addictive->id }}">
                                <td class="text-center">{{ $index + 1 }}</td>

                                <td class="col-date">
                                    {{ $addictive->date ? \Carbon\Carbon::parse($addictive->date)->format('d/m/Y') : '-' }}
                                </td>

                                <td class="text-center col-count">{{ $addictive->count ?? '-' }}</td>

                                <td class="col-exam">
                                    @if($addictive->exam == 0)
                                        <span class="badge rounded-pill text-bg-success">ไม่พบสารเสพติด</span>
                                    @else
                                        <span class="badge rounded-pill text-bg-danger">พบสารเสพติด</span>
                                    @endif
                                </td>

                                <td class="col-refer">
                                    @if($addictive->exam == 1)
                                        @if($addictive->refer == 1)
                                            <span class="badge rounded-pill text-bg-warning text-dark">ส่งต่อบำบัด</span>
                                        @elseif($addictive->refer == 2)
                                            <span class="badge rounded-pill text-bg-info">ติดตามดูแลต่อเนื่อง</span>
                                        @else
                                            <span class="badge rounded-pill text-bg-secondary">-</span>
                                        @endif
                                    @else
                                        <span class="badge rounded-pill text-bg-secondary">-</span>
                                    @endif
                                </td>

                                <td class="col-record">{{ $addictive->record ?? '-' }}</td>
                                <td class="col-recorder">{{ $addictive->recorder ?? '-' }}</td>

                                <td class="text-center">
                                    <div class="addictive-action-group">
                                        <button type="button"
                                                class="btn btn-warning btn-sm addictive-btn-action"
                                                onclick="openEditAddictive({{ $addictive->id }})">
                                            <i class="bi bi-pencil-square"></i>
                                            <span>แก้ไข</span>
                                        </button>

                                        <form id="delete-form-addictive-{{ $addictive->id }}"
                                              action="{{ route('addictive.delete', $addictive->id) }}"
                                              method="POST"
                                              class="d-inline">
                                            @csrf
                                            @method('DELETE')

                                            <button type="button"
                                                    class="btn btn-danger btn-sm addictive-btn-action"
                                                    onclick="confirmDelete('delete-form-addictive-{{ $addictive->id }}', 'คุณต้องการลบข้อมูลการตรวจสารเสพติดนี้ใช่หรือไม่')">
                                                <i class="bi bi-trash"></i>
                                                <span>ลบ</span>
                                            </button>
                                        </form>

                                        <a href="#" class="btn btn-info btn-sm addictive-btn-action">
                                            <i class="bi bi-file-earmark-text"></i>
                                            <span>รายงาน</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@else
    <div class="alert alert-info text-center small mt-2 mb-0">
        <i class="bi bi-info-circle me-1"></i>
        ยังไม่มีข้อมูลการตรวจสารเสพติด
    </div>
@endif