@extends('admin_client.admin_client')

@section('content')

@php
    use Carbon\Carbon;

    function thai_date($date) {
        if (!$date) return '-';
        try {
            $d = $date instanceof \Carbon\Carbon ? $date : Carbon::parse($date);
            return $d->format('d/m/') . ($d->year + 543);
        } catch (\Exception $e) {
            return '-';
        }
    }

    function thai_datetime($date) {
        if (!$date) return '-';
        try {
            $d = $date instanceof \Carbon\Carbon ? $date : Carbon::parse($date);
            return $d->format('d/m/') . ($d->year + 543) . ' ' . $d->format('H:i') . ' น.';
        } catch (\Exception $e) {
            return '-';
        }
    }

    $followCount = $observe->followups ? $observe->followups->count() : 0;
@endphp

<div class="container-fluid observe-report-page">
    <div class="observe-report-shell">

        {{-- Header --}}
        <div class="observe-report-head">
            <div class="observe-report-head__left">
                <div class="observe-report-head__eyebrow">
                    <i class="bi bi-file-earmark-text"></i>
                    <span>รายงานข้อมูลพฤติกรรม</span>
                </div>

                <h1 class="observe-report-head__title">รายงานพฤติกรรมและการติดตามผล</h1>

                <p class="observe-report-head__desc">
                    แสดงข้อมูลเหตุการณ์พฤติกรรมไม่เหมาะสม รายละเอียดการดำเนินการ และประวัติการติดตามผลทั้งหมด
                    ในรูปแบบที่อ่านง่าย เหมาะสำหรับตรวจสอบย้อนหลัง
                </p>
            </div>

            <div class="observe-report-head__right">
                <a href="{{ route('observe.edit', $observe->id) }}" class="btn observe-report-btn observe-report-btn--primary">
                    <i class="bi bi-pencil-square"></i>
                    <span>กลับหน้าแก้ไข</span>
                </a>

                <a href="{{ route('observe.create', $client->id) }}" class="btn observe-report-btn observe-report-btn--light">
                    <i class="bi bi-arrow-left-circle"></i>
                    <span>กลับหน้ารายการ</span>
                </a>
            </div>
        </div>

        {{-- Summary --}}
        <div class="observe-report-summary">
            <div class="observe-report-summary__item">
                <div class="observe-report-summary__label">วันที่เกิดเหตุ</div>
                <div class="observe-report-summary__value">{{ thai_date($observe->date) }}</div>
            </div>

            <div class="observe-report-summary__item">
                <div class="observe-report-summary__label">ประเภทพฤติกรรม</div>
                <div class="observe-report-summary__value">{{ $observe->misbehavior->misbehavior_name ?? '-' }}</div>
            </div>

            <div class="observe-report-summary__item">
                <div class="observe-report-summary__label">จำนวนครั้งที่ติดตาม</div>
                <div class="observe-report-summary__value">{{ $followCount }} ครั้ง</div>
            </div>

            <div class="observe-report-summary__item">
                <div class="observe-report-summary__label">วันที่บันทึก</div>
                <div class="observe-report-summary__value">{{ thai_date($observe->record_date) }}</div>
            </div>
        </div>

        {{-- Main Info --}}
        <section class="observe-report-section">
            <div class="observe-report-section__head">
                <h2 class="observe-report-section__title">ข้อมูลเหตุการณ์หลัก</h2>
                <p class="observe-report-section__desc">ข้อมูลสำคัญของเหตุการณ์และผู้เกี่ยวข้อง</p>
            </div>

            <div class="observe-report-panel">
                <div class="observe-report-grid">
                    <div class="observe-report-field">
                        <div class="observe-report-field__label">ผู้รับบริการ</div>
                        <div class="observe-report-field__value">
                            {{ trim(($client->prefix ?? '') . ($client->first_name ?? '') . ' ' . ($client->last_name ?? '')) ?: '-' }}
                        </div>
                    </div>

                    <div class="observe-report-field">
                        <div class="observe-report-field__label">ประเภทพฤติกรรมไม่เหมาะสม</div>
                        <div class="observe-report-field__value">
                            {{ $observe->misbehavior->misbehavior_name ?? '-' }}
                        </div>
                    </div>

                    <div class="observe-report-field">
                        <div class="observe-report-field__label">วันที่เกิดเหตุ</div>
                        <div class="observe-report-field__value">
                            {{ thai_date($observe->date) }}
                        </div>
                    </div>

                    <div class="observe-report-field">
                        <div class="observe-report-field__label">วันที่บันทึก</div>
                        <div class="observe-report-field__value">
                            {{ thai_date($observe->record_date) }}
                        </div>
                    </div>

                    <div class="observe-report-field">
                        <div class="observe-report-field__label">ผู้บันทึก</div>
                        <div class="observe-report-field__value">
                            {{ $observe->recorder ?: '-' }}
                        </div>
                    </div>

                    <div class="observe-report-field observe-report-field--full">
                        <div class="observe-report-field__label">พฤติกรรม</div>
                        <div class="observe-report-field__textbox">
                            {!! nl2br(e($observe->behavior ?: '-')) !!}
                        </div>
                    </div>

                    <div class="observe-report-field observe-report-field--full">
                        <div class="observe-report-field__label">สาเหตุ</div>
                        <div class="observe-report-field__textbox">
                            {!! nl2br(e($observe->cause ?: '-')) !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Action / Result --}}
        <section class="observe-report-section">
            <div class="observe-report-section__head">
                <h2 class="observe-report-section__title">การดำเนินการและผล</h2>
                <p class="observe-report-section__desc">แนวทางแก้ไข การปฏิบัติจริง อุปสรรค และผลลัพธ์</p>
            </div>

            <div class="observe-report-panel">
                <div class="observe-report-grid">
                    <div class="observe-report-field observe-report-field--full">
                        <div class="observe-report-field__label">แนวทางแก้ไข</div>
                        <div class="observe-report-field__textbox">
                            {!! nl2br(e($observe->solution ?: '-')) !!}
                        </div>
                    </div>

                    <div class="observe-report-field observe-report-field--full">
                        <div class="observe-report-field__label">การดำเนินการ</div>
                        <div class="observe-report-field__textbox">
                            {!! nl2br(e($observe->action ?: '-')) !!}
                        </div>
                    </div>

                    <div class="observe-report-field observe-report-field--full">
                        <div class="observe-report-field__label">อุปสรรค</div>
                        <div class="observe-report-field__textbox observe-report-field__textbox--muted">
                            {!! nl2br(e($observe->obstacles ?: '-')) !!}
                        </div>
                    </div>

                    <div class="observe-report-field observe-report-field--full">
                        <div class="observe-report-field__label">ผลการดำเนินการ</div>
                        <div class="observe-report-field__textbox">
                            {!! nl2br(e($observe->result ?: '-')) !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Followups --}}
        <section class="observe-report-section">
            <div class="observe-report-section__head">
                <h2 class="observe-report-section__title">ประวัติการติดตามผล</h2>
                <p class="observe-report-section__desc">รายการติดตามผลทั้งหมดที่เชื่อมกับเหตุการณ์นี้</p>
            </div>

            @if($followCount > 0)
                <div class="observe-report-follow-stack">
                    @foreach($observe->followups as $followup)
                        <article class="observe-report-follow">
                            <div class="observe-report-follow__head">
                                <div class="observe-report-follow__title-wrap">
                                    <div class="observe-report-follow__no">
                                        ครั้งที่ {{ $followup->followup_count ?: $loop->iteration }}
                                    </div>
                                    <div class="observe-report-follow__date">
                                        {{ thai_date($followup->followup_date) }}
                                    </div>
                                </div>
                            </div>

                            <div class="observe-report-panel observe-report-panel--soft">
                                <div class="observe-report-grid">
                                    <div class="observe-report-field">
                                        <div class="observe-report-field__label">ครั้งที่ติดตาม</div>
                                        <div class="observe-report-field__value">
                                            {{ $followup->followup_count ?: '-' }}
                                        </div>
                                    </div>

                                    <div class="observe-report-field">
                                        <div class="observe-report-field__label">วันที่ติดตาม</div>
                                        <div class="observe-report-field__value">
                                            {{ thai_date($followup->followup_date) }}
                                        </div>
                                    </div>

                                    <div class="observe-report-field observe-report-field--full">
                                        <div class="observe-report-field__label">การติดตาม / การดำเนินการเพิ่มเติม</div>
                                        <div class="observe-report-field__textbox">
                                            {!! nl2br(e($followup->followup_action ?: '-')) !!}
                                        </div>
                                    </div>

                                    <div class="observe-report-field observe-report-field--full">
                                        <div class="observe-report-field__label">ผลการติดตาม</div>
                                        <div class="observe-report-field__textbox">
                                            {!! nl2br(e($followup->followup_result ?: '-')) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="observe-report-empty">
                    <div class="observe-report-empty__icon">
                        <i class="bi bi-inboxes"></i>
                    </div>
                    <div class="observe-report-empty__title">ยังไม่มีข้อมูลการติดตามผล</div>
                    <div class="observe-report-empty__desc">
                        เมื่อมีการบันทึกข้อมูลติดตามผล ระบบจะแสดงรายละเอียดในส่วนนี้โดยอัตโนมัติ
                    </div>
                </div>
            @endif
        </section>

    </div>
</div>

<style>
.observe-report-page{
    padding:20px 12px 30px;
    background:#f8fafc;
}

.observe-report-page .observe-report-shell{
    max-width:1200px;
    margin:0 auto;
}

.observe-report-page .observe-report-head{
    display:flex;
    align-items:flex-start;
    justify-content:space-between;
    gap:18px;
    flex-wrap:wrap;
    padding:0 0 18px;
    margin-bottom:20px;
    border-bottom:1px solid #e9eef5;
}

.observe-report-page .observe-report-head__left{
    min-width:0;
    flex:1 1 680px;
}

.observe-report-page .observe-report-head__eyebrow{
    display:inline-flex;
    align-items:center;
    gap:8px;
    padding:6px 12px;
    margin-bottom:12px;
    border-radius:999px;
    background:#eef4ff;
    color:#3159d1;
    font-size:.88rem;
    font-weight:700;
}

.observe-report-page .observe-report-head__title{
    margin:0 0 8px;
    font-size:clamp(1.45rem, 2vw, 1.95rem);
    font-weight:800;
    color:#0f172a;
    letter-spacing:-0.02em;
}

.observe-report-page .observe-report-head__desc{
    margin:0;
    max-width:760px;
    color:#64748b;
    font-size:.96rem;
    line-height:1.75;
}

.observe-report-page .observe-report-head__right{
    display:flex;
    align-items:center;
    gap:10px;
    flex-wrap:wrap;
}

.observe-report-page .observe-report-btn{
    display:inline-flex;
    align-items:center;
    gap:8px;
    padding:10px 16px;
    border-radius:14px;
    font-weight:700;
    font-size:.94rem;
    white-space:nowrap;
    border:1px solid transparent;
}

.observe-report-page .observe-report-btn--primary{
    background:#ffffff;
    border-color:#dbe5f0;
    color:#0f172a;
}

.observe-report-page .observe-report-btn--primary:hover{
    background:#f8fafc;
    color:#0f172a;
}

.observe-report-page .observe-report-btn--light{
    background:#ffffff;
    border-color:#e2e8f0;
    color:#475569;
}

.observe-report-page .observe-report-btn--light:hover{
    background:#f8fafc;
    color:#334155;
}

.observe-report-page .observe-report-summary{
    display:grid;
    grid-template-columns:repeat(4, minmax(0, 1fr));
    gap:12px;
    margin-bottom:24px;
}

.observe-report-page .observe-report-summary__item{
    padding:16px 18px;
    background:#ffffff;
    border:1px solid #e7edf4;
    border-radius:18px;
}

.observe-report-page .observe-report-summary__label{
    margin-bottom:6px;
    color:#64748b;
    font-size:.88rem;
    font-weight:600;
}

.observe-report-page .observe-report-summary__value{
    color:#0f172a;
    font-size:1rem;
    font-weight:800;
    line-height:1.5;
    word-break:break-word;
}

.observe-report-page .observe-report-section{
    margin-bottom:24px;
}

.observe-report-page .observe-report-section__head{
    margin-bottom:12px;
}

.observe-report-page .observe-report-section__title{
    margin:0 0 4px;
    color:#0f172a;
    font-size:1.08rem;
    font-weight:800;
    letter-spacing:-0.01em;
}

.observe-report-page .observe-report-section__desc{
    margin:0;
    color:#64748b;
    font-size:.92rem;
    line-height:1.65;
}

.observe-report-page .observe-report-panel{
    background:#ffffff;
    border:1px solid #e7edf4;
    border-radius:20px;
    padding:20px;
}

.observe-report-page .observe-report-panel--soft{
    background:#ffffff;
    border-color:#ecf1f6;
    box-shadow:none;
}

.observe-report-page .observe-report-grid{
    display:grid;
    grid-template-columns:repeat(2, minmax(0, 1fr));
    gap:16px;
}

.observe-report-page .observe-report-field{
    min-width:0;
}

.observe-report-page .observe-report-field--full{
    grid-column:1 / -1;
}

.observe-report-page .observe-report-field__label{
    margin-bottom:6px;
    color:#475569;
    font-size:.9rem;
    font-weight:700;
}

.observe-report-page .observe-report-field__value{
    min-height:48px;
    display:flex;
    align-items:center;
    padding:12px 14px;
    border-radius:14px;
    background:#f8fafc;
    border:1px solid #e9eef5;
    color:#0f172a;
    font-size:.95rem;
    line-height:1.65;
    word-break:break-word;
}

.observe-report-page .observe-report-field__textbox{
    min-height:96px;
    padding:14px 16px;
    border-radius:16px;
    background:#f8fafc;
    border:1px solid #e9eef5;
    color:#1e293b;
    font-size:.95rem;
    line-height:1.8;
    word-break:break-word;
}

.observe-report-page .observe-report-field__textbox--muted{
    background:#fbfcfd;
}

.observe-report-page .observe-report-follow-stack{
    display:grid;
    gap:16px;
}

.observe-report-page .observe-report-follow{
    display:grid;
    gap:10px;
}

.observe-report-page .observe-report-follow__head{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:12px;
    flex-wrap:wrap;
}

.observe-report-page .observe-report-follow__title-wrap{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:12px;
    flex-wrap:wrap;
    width:100%;
}

.observe-report-page .observe-report-follow__no{
    color:#0f172a;
    font-size:1rem;
    font-weight:800;
}

.observe-report-page .observe-report-follow__date{
    display:inline-flex;
    align-items:center;
    padding:6px 12px;
    border-radius:999px;
    background:#ffffff;
    border:1px solid #e2e8f0;
    color:#475569;
    font-size:.88rem;
    font-weight:700;
}

.observe-report-page .observe-report-empty{
    padding:34px 18px;
    background:#ffffff;
    border:1px solid #e7edf4;
    border-radius:20px;
    text-align:center;
}

.observe-report-page .observe-report-empty__icon{
    width:64px;
    height:64px;
    margin:0 auto 12px;
    display:grid;
    place-items:center;
    border-radius:20px;
    background:#f8fafc;
    color:#94a3b8;
    font-size:1.5rem;
}

.observe-report-page .observe-report-empty__title{
    margin-bottom:6px;
    color:#1e293b;
    font-size:1rem;
    font-weight:800;
}

.observe-report-page .observe-report-empty__desc{
    color:#64748b;
    font-size:.92rem;
    line-height:1.7;
    max-width:460px;
    margin:0 auto;
}

@media (max-width: 1199.98px){
    .observe-report-page .observe-report-summary{
        grid-template-columns:repeat(2, minmax(0, 1fr));
    }
}

@media (max-width: 767.98px){
    .observe-report-page{
        padding:16px 8px 24px;
    }

    .observe-report-page .observe-report-summary,
    .observe-report-page .observe-report-grid{
        grid-template-columns:1fr;
    }

    .observe-report-page .observe-report-panel{
        padding:14px;
        border-radius:16px;
    }

    .observe-report-page .observe-report-summary__item{
        padding:14px;
        border-radius:16px;
    }

    .observe-report-page .observe-report-head{
        gap:14px;
        margin-bottom:18px;
        padding-bottom:16px;
    }

    .observe-report-page .observe-report-head__right{
        width:100%;
        overflow-x:auto;
        flex-wrap:nowrap;
        padding-bottom:2px;
    }

    .observe-report-page .observe-report-btn{
        flex:0 0 auto;
    }

    .observe-report-page .observe-report-follow__title-wrap{
        flex-direction:column;
        align-items:flex-start;
    }
}
</style>

@endsection