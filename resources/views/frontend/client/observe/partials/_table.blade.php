<div class="observe-body">
            @if($observes->count() > 0)
                <div class="section-card">
                    <div class="section-header">
                        <h2 class="section-title">
                            <i class="bi bi-table"></i>
                            รายการบันทึกพฤติกรรม
                        </h2>
                        <span class="section-badge">
                            {{ $observes->count() }} รายการ
                        </span>
                    </div>

                    <div class="table-wrap">
                        <table class="table observe-table">
                            <thead>
                                <tr>
                                    <th style="min-width: 120px;">วันที่</th>
                                    <th style="min-width: 220px;">พฤติกรรมที่พบเห็น</th>
                                    <th style="min-width: 180px;">ผลลัพธ์</th>
                                    <th style="min-width: 140px;">ผู้บันทึก</th>
                                    <th style="min-width: 300px;">การติดตามผล</th>
                                    <th class="text-center" style="min-width: 220px;">จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($observes as $obs)
                                    <tr>
                                        <td>
                                            <div class="data-main">{{ $obs->date ?: '-' }}</div>
                                            @if(!empty($obs->record_date))
                                                <div class="data-sub">บันทึก: {{ $obs->record_date }}</div>
                                            @endif
                                        </td>

                                        <td>
                                            <div class="data-main">{{ $obs->behavior ?: '-' }}</div>
                                            @if(!empty($obs->cause))
                                                <div class="data-sub">สาเหตุ: {{ $obs->cause }}</div>
                                            @endif
                                        </td>

                                        <td>
                                            <div class="data-main">{{ $obs->result ?: '-' }}</div>
                                            @if(!empty($obs->solution))
                                                <div class="data-sub">แนวทาง: {{ $obs->solution }}</div>
                                            @endif
                                        </td>

                                        <td>
                                            <div class="data-main">{{ $obs->recorder ?: '-' }}</div>
                                        </td>

                                        <td>
                                            @forelse($obs->followups as $f)
                                                <div class="followup-list">
                                                    <div class="followup-item">
                                                        <div class="data-main">
                                                            {{ $f->followup_date }} · ครั้งที่ {{ $f->followup_count }}
                                                        </div>
                                                        <div class="data-sub">
                                                            {{ $f->followup_result ?: 'ยังไม่ได้ระบุผลลัพธ์' }}
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="followup-empty">ยังไม่มีการติดตามผล</div>
                                            @endforelse
                                        </td>

                                        <td class="text-center">
                                            <div class="action-stack">
                                                <a href="{{ route('observe.edit', $obs->id) }}"
                                                   class="btn-action btn-action-warning text-decoration-none">
                                                    <i class="bi bi-pencil-square"></i> แก้ไข
                                                </a>

                                                <form id="delete-form-observe-{{ $obs->id }}"
                                                      action="{{ route('observe.delete', $obs->id) }}"
                                                      method="POST"
                                                      class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                            class="btn-action btn-action-danger"
                                                            onclick="confirmDelete('delete-form-observe-{{ $obs->id }}')">
                                                        <i class="bi bi-trash"></i> ลบ
                                                    </button>
                                                </form>

                                                <button type="button"
                                                        class="btn-action btn-action-info"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#addFollowupModal{{ $obs->id }}">
                                                    <i class="bi bi-arrow-repeat"></i> ติดตามผล
                                                </button>
                                            </div>

                                            {{-- Modal เพิ่มการติดตามผล --}}
                                            <div class="modal fade observe-modal"
                                                 id="addFollowupModal{{ $obs->id }}"
                                                 tabindex="-1"
                                                 aria-hidden="true">
                                                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">
                                                                <i class="bi bi-plus-circle"></i>
                                                                เพิ่มการติดตามผล (พฤติกรรมวันที่ {{ $obs->date }})
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <form action="{{ route('followup.store') }}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="observe_id" value="{{ $obs->id }}">

                                                                <div class="form-section">
                                                                    <h6 class="form-section-title">
                                                                        <i class="bi bi-calendar-check"></i>
                                                                        ข้อมูลการติดตาม
                                                                    </h6>

                                                                    <div class="row g-3">
                                                                        <div class="col-12 col-md-6">
                                                                            <label class="form-label-modern">วันที่ติดตาม</label>
                                                                            <input type="date"
                                                                                   name="followup_date"
                                                                                   class="form-control form-control-modern"
                                                                                   required>
                                                                        </div>

                                                                        <div class="col-12 col-md-6">
                                                                            <label class="form-label-modern">ครั้งที่</label>
                                                                            <input type="number"
                                                                                   name="followup_count"
                                                                                   class="form-control form-control-modern"
                                                                                   min="1"
                                                                                   required>
                                                                        </div>

                                                                        <div class="col-12">
                                                                            <label class="form-label-modern">การดำเนินการ</label>
                                                                            <textarea name="followup_action"
                                                                                      class="form-control form-control-modern"
                                                                                      rows="3"></textarea>
                                                                        </div>

                                                                        <div class="col-12">
                                                                            <label class="form-label-modern">ผลลัพธ์</label>
                                                                            <textarea name="followup_result"
                                                                                      class="form-control form-control-modern"
                                                                                      rows="3"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="modal-footer-modern">
                                                                    <button type="submit" class="btn-form-primary">
                                                                        <i class="bi bi-save"></i> บันทึกการติดตามผล
                                                                    </button>
                                                                    <button type="button" class="btn-form-secondary" data-bs-dismiss="modal">
                                                                        <i class="bi bi-x-circle"></i> ปิด
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">
                                            ยังไม่มีบันทึกพฤติกรรม
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="empty-state">
                    <i class="bi bi-info-circle"></i>
                    <div class="fw-bold mb-1">ยังไม่มีบันทึกพฤติกรรม</div>
                    <div>เริ่มต้นโดยกดปุ่ม “เพิ่มข้อมูลใหม่” เพื่อบันทึกข้อมูลการสังเกตพฤติกรรม</div>
                </div>
            @endif

            {{-- รายการติดตามผลของ observe เดียว --}}
            @if (isset($observe))
                <div class="section-card mt-4">
                    <div class="section-header">
                        <h2 class="section-title">
                            <i class="bi bi-list-check"></i>
                            รายการติดตามผล
                        </h2>

                        <button type="button"
                                class="btn-modern btn-modern-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#addFollowupModal{{ $observe->id }}">
                            <i class="bi bi-plus-circle"></i>
                            เพิ่มการติดตามผล
                        </button>
                    </div>

                    <div class="table-wrap">
                        <table class="table observe-table" style="min-width: 780px;">
                            <thead>
                                <tr>
                                    <th>วันที่ติดตาม</th>
                                    <th>ครั้งที่</th>
                                    <th>การดำเนินการ</th>
                                    <th>ผลลัพธ์</th>
                                    <th class="text-center">จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($observe->followups as $f)
                                    <tr>
                                        <td>{{ $f->followup_date }}</td>
                                        <td>{{ $f->followup_count }}</td>
                                        <td>{{ $f->followup_action ?: '-' }}</td>
                                        <td>{{ $f->followup_result ?: '-' }}</td>
                                        <td class="text-center">
                                            <button type="button"
                                                    class="btn-action btn-action-warning"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editFollowupModal{{ $f->id }}">
                                                <i class="bi bi-pencil-square"></i> แก้ไข
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            ยังไม่มีการติดตามผล
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>