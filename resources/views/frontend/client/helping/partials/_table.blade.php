<style>
    /* ===== scoped only for help session table partial ===== */
    .hp-table-card .hp-table{
        table-layout: auto;
    }

    .hp-table-card .hp-table th:last-child,
    .hp-table-card .hp-table td:last-child{
        min-width: 170px;
    }

    /* ===== ปุ่มแสดงรายละเอียด: fix สีตอนกดแล้วมองไม่เห็น ===== */
    .hp-table-card .hp-toggle-btn{
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        min-height: 38px;
        padding: .45rem .85rem;
        border-radius: 10px;
        font-size: .85rem;
        font-weight: 700;
        line-height: 1.2;
        white-space: nowrap;
        border: 1px solid #5dade2;
        background: #5dade2;
        color: #ffffff !important;
        box-shadow: none;
        transition: all .15s ease;
    }

    .hp-table-card .hp-toggle-btn i,
    .hp-table-card .hp-toggle-btn span{
        color: inherit !important;
    }

    .hp-table-card .hp-toggle-btn:hover,
    .hp-table-card .hp-toggle-btn:focus,
    .hp-table-card .hp-toggle-btn:active{
        background: #4aa3da !important;
        border-color: #4aa3da !important;
        color: #ffffff !important;
        box-shadow: none !important;
    }

    /* ตอนเปิดแล้ว ให้ยังเห็นชัด ไม่กลายเป็นขาว */
    .hp-table-card .hp-toggle-btn[aria-expanded="true"]{
        background: #ffffff !important;
        border-color: #5dade2 !important;
        color: #2b7fb7 !important;
    }

    .hp-table-card .hp-toggle-btn[aria-expanded="true"] i,
    .hp-table-card .hp-toggle-btn[aria-expanded="true"] span{
        color: #2b7fb7 !important;
    }

    .hp-table-card .hp-toggle-btn[aria-expanded="true"]:hover,
    .hp-table-card .hp-toggle-btn[aria-expanded="true"]:focus,
    .hp-table-card .hp-toggle-btn[aria-expanded="true"]:active{
        background: #f4fbff !important;
        border-color: #4aa3da !important;
        color: #2b7fb7 !important;
    }

    /* ===== action buttons ===== */
    .hp-table-card .hp-actions{
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .hp-table-card .hp-actions .btn{
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        white-space: nowrap;
        min-height: 36px;
        padding: .42rem .72rem;
        font-size: .85rem;
        line-height: 1.2;
        border-radius: 10px;
    }

    .hp-table-card .hp-actions form{
        display: inline-flex;
        margin: 0;
    }

    .hp-table-card .hp-actions form button{
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        white-space: nowrap;
        min-height: 36px;
        padding: .42rem .72rem;
        font-size: .85rem;
        line-height: 1.2;
        border-radius: 10px;
    }

    @media (max-width: 991.98px){
        .hp-table-card .hp-actions{
            gap: 6px;
        }

        .hp-table-card .hp-actions .btn,
        .hp-table-card .hp-actions form button{
            font-size: .8rem;
            padding: .4rem .65rem;
        }

        .hp-table-card .hp-toggle-btn{
            font-size: .82rem;
            padding: .42rem .75rem;
        }
    }

    @media (max-width: 575.98px){
        .hp-table-card .hp-table th:last-child,
        .hp-table-card .hp-table td:last-child{
            min-width: 150px;
        }

        .hp-table-card .hp-actions{
            flex-direction: column;
            align-items: stretch;
            width: 100%;
            gap: 6px;
        }

        .hp-table-card .hp-actions .btn,
        .hp-table-card .hp-actions form,
        .hp-table-card .hp-actions form button{
            width: 100%;
        }

        .hp-table-card .hp-actions .btn,
        .hp-table-card .hp-actions form button{
            justify-content: center;
            padding: .58rem .75rem;
            font-size: .85rem;
        }

        .hp-table-card .hp-toggle-btn{
            min-width: 100%;
            justify-content: center;
        }
    }
</style>

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
                                    {{ \Carbon\Carbon::parse($session->help_date)->addYears(543)->format('d/m/Y') }}
                                </span>
                            </td>

                            <td class="text-center">
                                <span class="hp-total-badge">
                                    {{ number_format($session->total_amount, 2) }} บาท
                                </span>
                            </td>

                            <td class="text-center">
                                <button class="btn hp-btn-sm hp-toggle-btn"
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

                                    <a href="{{ route('help_sessions.report', ['client' => $client->id, 'session' => $session->id]) }}"
                                       class="btn btn-primary hp-btn-sm">
                                        <i class="bi bi-printer"></i>
                                        <span>รายงาน</span>
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
                                                    <span>รายละเอียดการช่วยเหลือ วันที่ {{ \Carbon\Carbon::parse($session->help_date)->addYears(543)->format('d/m/Y') }}</span>
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