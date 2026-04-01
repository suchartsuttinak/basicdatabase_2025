  @if($sessions->isNotEmpty())
                <div class="hp-table-card">
                    <div class="hp-table-head">
                        <div class="hp-table-title">
                            <i class="bi bi-table"></i>
                            <span>ประวัติการให้ความช่วยเหลือ</span>
                        </div>
                        <div class="hp-table-meta">จำนวน {{ $sessions->count() }} รายการ</div>
                    </div>

                    <div class="hp-table-wrap">
                        <table class="table hp-table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 16%;">วันที่</th>
                                    <th style="width: 18%;">ยอดรวม</th>
                                    <th style="width: 21%;">รายละเอียด</th>
                                    <th style="width: 25%;">หมายเหตุการจัดการ</th>
                                    <th style="width: 20%;">จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sessions as $session)
                                    <tr>
                                        <td class="text-center">
                                            <span class="hp-date-badge">
                                                {{ \Carbon\Carbon::parse($session->help_date)->format('d/m/Y') }}
                                            </span>
                                        </td>

                                        <td class="text-center">
                                            <span class="hp-total-badge">
                                                {{ number_format($session->total_amount, 2) }} บาท
                                            </span>
                                        </td>

                                        <td class="text-center">
                                            <button class="btn btn-info hp-btn-sm hp-toggle-btn text-white"
                                                    type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#session-{{ $session->id }}"
                                                    aria-expanded="false"
                                                    aria-controls="session-{{ $session->id }}">
                                                <i class="bi bi-list-ul"></i>
                                                <span>แสดงรายการ</span>
                                            </button>
                                        </td>

                                        <td>
                                            <div class="small text-secondary fw-semibold">
                                                รายการช่วยเหลือ {{ $session->items->count() }} รายการ
                                            </div>
                                        </td>

                                        <td>
                                            <div class="hp-actions">
                                                <a href="{{ route('help_sessions.edit', ['client' => $client->id, 'session' => $session->id]) }}"
                                                   class="btn btn-warning hp-btn-sm">
                                                    <i class="bi bi-pencil-square"></i>
                                                    <span>แก้ไข</span>
                                                </a>

                                                <form id="delete-form-{{ $session->id }}"
                                                      action="{{ route('help_sessions.destroy', ['client' => $client->id, 'session' => $session->id]) }}"
                                                      method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                            class="btn btn-danger hp-btn-sm"
                                                            onclick="confirmDelete('delete-form-{{ $session->id }}', 'คุณแน่ใจหรือไม่ที่จะลบการช่วยเหลือครั้งนี้?')">
                                                        <i class="bi bi-trash"></i>
                                                        <span>ลบ</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr class="hp-detail-row">
                                        <td colspan="5" class="hp-detail-cell">
                                            <div id="session-{{ $session->id }}" class="collapse">
                                                <div class="hp-detail-shell">
                                                    <div class="hp-detail-card">
                                                        <div class="hp-detail-head">
                                                            <div class="hp-detail-title">
                                                                <i class="bi bi-bag-heart-fill"></i>
                                                                <span>รายละเอียดการช่วยเหลือ วันที่ {{ \Carbon\Carbon::parse($session->help_date)->format('d/m/Y') }}</span>
                                                            </div>
                                                            <div class="small fw-bold text-secondary">
                                                                รวม {{ $session->items->count() }} รายการ
                                                            </div>
                                                        </div>

                                                        <div class="hp-detail-wrap">
                                                            <table class="table hp-detail-table mb-0">
                                                                <thead>
                                                                    <tr>
                                                                        <th>รายการ</th>
                                                                        <th style="width: 14%;">จำนวน</th>
                                                                        <th style="width: 18%;">ราคา/หน่วย</th>
                                                                        <th style="width: 18%;">ราคารวม</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach($session->items as $item)
                                                                        <tr>
                                                                            <td>
                                                                                <div class="hp-item-name">{{ $item->item_name }}</div>
                                                                            </td>
                                                                            <td class="text-center">{{ $item->quantity }}</td>
                                                                            <td class="text-end">{{ number_format($item->unit_price, 2) }}</td>
                                                                            <td class="text-end">
                                                                                <span class="hp-item-money">
                                                                                    {{ number_format($item->total_price, 2) }}
                                                                                </span>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="hp-table-card">
                    <div class="hp-empty">
                        <i class="bi bi-inbox"></i>
                        <div class="fw-bold mb-1">ยังไม่มีข้อมูลการช่วยเหลือ</div>
                        <div class="small">เมื่อเพิ่มข้อมูลแล้ว รายการจะแสดงในตารางนี้</div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
