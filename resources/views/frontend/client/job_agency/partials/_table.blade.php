 @if($jobAgencies->isNotEmpty())
                <div class="ja-table-card">
                    <div class="ja-table-head">
                        <div class="ja-table-title">
                            <i class="bi bi-table"></i>
                            <span>รายการจัดหางาน</span>
                        </div>
                        <div class="ja-table-meta">จำนวน {{ $jobAgencies->count() }} รายการ</div>
                    </div>

                    <div class="ja-table-wrap">
                        <table id="datatable-jobagency" class="table table-hover align-middle ja-table">
                            <thead>
                                <tr>
                                    <th>วันที่เริ่มงาน</th>
                                    <th>อาชีพ</th>
                                    <th>ตำแหน่ง</th>
                                    <th>รายได้/เดือน</th>
                                    <th>บริษัท</th>
                                    <th>ผู้ประสานงาน</th>
                                    <th>หมายเหตุ</th>
                                    <th style="width:15%;">จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jobAgencies as $job)
                                    <tr>
                                        <td class="text-center">{{ \Carbon\Carbon::parse($job->job_date)->format('d/m/Y') }}</td>
                                        <td><div class="ja-cell">{{ $job->occupation->occupation_name ?? '-' }}</div></td>
                                        <td><div class="ja-cell">{{ $job->position ?? '-' }}</div></td>
                                        <td class="text-center">
                                            <span class="ja-income-badge">
                                                {{ number_format($job->income ?? 0, 2) }}
                                            </span>
                                        </td>
                                        <td><div class="ja-cell">{{ $job->company ?? '-' }}</div></td>
                                        <td><div class="ja-cell">{{ $job->coordinator ?? '-' }}</div></td>
                                        <td><div class="ja-cell-lg">{{ $job->remark ?? '-' }}</div></td>
                                        <td class="text-center">
                                            <div class="ja-actions">
                                                <button type="button"
                                                        class="btn btn-warning ja-btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editJobAgencyModal{{ $job->id }}">
                                                    <i class="bi bi-pencil-square"></i>
                                                    <span>แก้ไข</span>
                                                </button>

                                                <form id="delete-form-job-{{ $job->id }}"
                                                      action="{{ route('job_agencies.delete', $job->id) }}"
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                            class="btn btn-danger ja-btn-sm"
                                                            onclick="confirmDelete('delete-form-job-{{ $job->id }}', 'คุณต้องการลบข้อมูลนี้ใช่หรือไม่?')">
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
                </div>
            @else
                <div class="ja-table-card">
                    <div class="ja-empty">
                        <i class="bi bi-briefcase"></i>
                        <div class="fw-bold mb-1">ยังไม่มีข้อมูลการจัดหางาน</div>
                        <div class="small">เมื่อเพิ่มข้อมูลแล้ว รายการจะแสดงในตารางนี้</div>
                    </div>
                </div>
            @endif