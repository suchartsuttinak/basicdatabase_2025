@if($psychiatrics->isNotEmpty())
    <div class="card border-0 shadow-sm psychiatric-table-card">
        <div class="card-body p-2">
            <div class="table-responsive psychiatric-table-wrap">
                <table id="datatable-psychiatric" class="table table-sm table-hover align-middle psychiatric-table mb-0">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 70px;">ลำดับ</th>
                            <th>วันที่ส่งตรวจ</th>
                            <th>สถานพยาบาล</th>
                            <th>ผลการตรวจ</th>
                            <th>นัดครั้งต่อไป</th>
                            <th>การรักษา</th>
                            <th>การขึ้นทะเบียน</th>
                            <th class="text-center" style="min-width: 220px;">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($psychiatrics as $index => $psychiatric)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>
                                    {{ $psychiatric->sent_date ? \Carbon\Carbon::parse($psychiatric->sent_date)->format('d/m/Y') : '-' }}
                                </td>
                                <td>{{ $psychiatric->hotpital ?? '-' }}</td>
                                <td>{{ $psychiatric->psycho->psycho_name ?? '-' }}</td>
                                <td>
                                    {{ $psychiatric->appoin_date ? \Carbon\Carbon::parse($psychiatric->appoin_date)->format('d/m/Y') : '-' }}
                                </td>
                                <td>
                                    @if($psychiatric->drug_no === 'yes')
                                        <span class="badge rounded-pill text-bg-success">รับยา</span>
                                    @else
                                        <span class="badge rounded-pill text-bg-secondary">ไม่รับยา</span>
                                    @endif
                                </td>
                                <td>
                                    @if($psychiatric->disa_no === 'yes')
                                        <span class="badge rounded-pill text-bg-info">ขึ้นทะเบียน</span>
                                    @else
                                        <span class="badge rounded-pill text-bg-secondary">ไม่ขึ้นทะเบียน</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="psychiatric-action-group">
                                        <button type="button"
                                                class="btn btn-warning btn-sm psychiatric-btn-action"
                                                onclick="openEditPsychiatric({{ $psychiatric->id }})">
                                            <i class="bi bi-pencil-square"></i>
                                            <span>แก้ไข</span>
                                        </button>

                                        <button type="button"
                                                class="btn btn-danger btn-sm psychiatric-btn-action"
                                                onclick="confirmDelete('delete-form-psychiatric-{{ $psychiatric->id }}', 'คุณต้องการลบข้อมูลจิตเวชนี้ใช่หรือไม่')">
                                            <i class="bi bi-trash"></i>
                                            <span>ลบ</span>
                                        </button>

                                        <a href="#"
                                           class="btn btn-info btn-sm psychiatric-btn-action">
                                            <i class="bi bi-file-earmark-text"></i>
                                            <span>รายงาน</span>
                                        </a>
                                    </div>

                                    <form id="delete-form-psychiatric-{{ $psychiatric->id }}"
                                          action="{{ route('psychiatric.delete', $psychiatric->id) }}"
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
    <div class="alert alert-info text-center small mt-2 mb-0">
        <i class="bi bi-info-circle me-1"></i>
        ยังไม่มีข้อมูลการตรวจจิตเวช
    </div>
@endif