   <div class="rf-table-card">
                <div class="rf-table-head">
                    <div class="rf-table-title">
                        <i class="bi bi-table"></i>
                        <span>รายการจำหน่าย</span>
                    </div>
                    <div class="rf-table-meta">จำนวน {{ $refers->count() }} รายการ</div>
                </div>

                <div class="rf-table-wrap">
                    <table id="datatable-refer" class="table table-hover align-middle rf-table">
                        <thead>
                            <tr>
                                <th>วันที่นำส่ง</th>
                                <th>ชื่อผู้รับ</th>
                                <th>สาเหตุ</th>
                                <th>สถานที่นำส่ง</th>
                                <th>ผู้ดูแล</th>
                                <th>ผู้รับตัว</th>
                                <th>โทรศัพท์</th>
                                <th>ความสัมพันธ์</th>
                                <th>ผู้นำส่ง</th>
                                <th>หมายเหตุ</th>
                                <th>จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($refers as $refer)
                                <tr>
                                    <td class="text-center">{{ \Carbon\Carbon::parse($refer->refer_date)->format('d/m/Y') }}</td>
                                    <td><div class="rf-cell">{{ $refer->client->name ?? '-' }}</div></td>
                                    <td><div class="rf-cell">{{ $refer->translate->translate_name ?? '-' }}</div></td>
                                    <td><div class="rf-cell-lg">{{ $refer->destination ?? '-' }}</div></td>
                                    <td class="text-center"><div class="rf-cell-sm">{{ $refer->guardian ?? '-' }}</div></td>
                                    <td><div class="rf-cell">{{ $refer->parent_name ?? '-' }}</div></td>
                                    <td><div class="rf-cell">{{ $refer->parent_tel ?? '-' }}</div></td>
                                    <td><div class="rf-cell">{{ $refer->member ?? '-' }}</div></td>
                                    <td><div class="rf-cell">{{ $refer->teacher ?? '-' }}</div></td>
                                    <td><div class="rf-cell-lg">{{ $refer->remark ?? '-' }}</div></td>
                                    <td class="text-center">
                                        <div class="rf-actions">
                                            <form action="{{ route('refers.restore', $refer->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-success rf-btn-sm">
                                                    <i class="bi bi-arrow-counterclockwise"></i>
                                                    <span>Restore</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11">
                                        <div class="rf-empty">
                                            <i class="bi bi-info-circle"></i>
                                            <div class="fw-bold mb-1">ยังไม่มีข้อมูลการจำหน่าย</div>
                                            <div class="small">เมื่อมีข้อมูล รายการจะแสดงในตารางนี้</div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>