@extends('admin_client.admin_client')

@section('content')

@php
    use Carbon\Carbon;

    function thaidate($date) {
        if (!$date) return '-';
        try {
            $d = $date instanceof \Carbon\Carbon ? $date : Carbon::parse($date);
            return $d->format('d/m/') . ($d->year + 543);
        } catch (\Exception $e) {
            return '-';
        }
    }

    function thaidatetime($date) {
        if (!$date) return '-';
        try {
            $d = $date instanceof \Carbon\Carbon ? $date : Carbon::parse($date);
            return $d->format('d/m/') . ($d->year + 543) . ' ' . $d->format('H:i') . ' น.';
        } catch (\Exception $e) {
            return '-';
        }
    }

    $followCount = $escape->follows ? $escape->follows->count() : 0;
@endphp

<div class="container-fluid escape-report-page">
    <div class="escape-report-shell">

        {{-- Header --}}
        <div class="escape-report-head">
            <div class="escape-report-head__left">
                <div class="escape-report-head__eyebrow">
                    <i class="bi bi-file-earmark-text"></i>
                    <span>รายงานข้อมูลการออกจากสถานสงเคราะห์</span>
                </div>

                <h1 class="escape-report-head__title">รายงานรายละเอียดการออกจากสถานสงเคราะห์</h1>

                <p class="escape-report-head__desc">
                    แสดงข้อมูลเหตุการณ์หลัก ประเภทการออก และประวัติการติดตามทั้งหมดอย่างเป็นระเบียบ
                    ในรูปแบบที่อ่านง่ายและเหมาะสำหรับตรวจสอบย้อนหลัง
                </p>
            </div>

            <div class="escape-report-head__right">
                <a href="{{ route('escape.edit', $escape->id) }}" class="btn escape-report-btn escape-report-btn--primary">
                    <i class="bi bi-pencil-square"></i>
                    <span>กลับหน้าแก้ไข</span>
                </a>

                <a href="{{ route('escape.index', $client->id) }}" class="btn escape-report-btn escape-report-btn--light">
                    <i class="bi bi-arrow-left-circle"></i>
                    <span>กลับหน้ารายการ</span>
                </a>
            </div>
        </div>

        {{-- Summary --}}
        <div class="escape-report-summary">
            <div class="escape-report-summary__item">
                <div class="escape-report-summary__label">วันที่ออก</div>
                <div class="escape-report-summary__value">{{ thaidate($escape->retire_date) }}</div>
            </div>

            <div class="escape-report-summary__item">
                <div class="escape-report-summary__label">ประเภทการออก</div>
                <div class="escape-report-summary__value">{{ $escape->retire->retire_name ?? '-' }}</div>
            </div>

            <div class="escape-report-summary__item">
                <div class="escape-report-summary__label">จำนวนครั้งที่ติดตาม</div>
                <div class="escape-report-summary__value">{{ $followCount }} ครั้ง</div>
            </div>

            <div class="escape-report-summary__item">
                <div class="escape-report-summary__label">บันทึกเมื่อ</div>
                <div class="escape-report-summary__value">{{ thaidatetime($escape->created_at) }}</div>
            </div>
        </div>

        {{-- Main Info --}}
        <section class="escape-report-section">
            <div class="escape-report-section__head">
                <h2 class="escape-report-section__title">ข้อมูลเหตุการณ์หลัก</h2>
                <p class="escape-report-section__desc">ข้อมูลสรุปของรายการนี้จากเหตุการณ์หลัก</p>
            </div>

            <div class="escape-report-panel">
                <div class="escape-report-grid">
                    <div class="escape-report-field">
                        <div class="escape-report-field__label">ผู้รับบริการ</div>
                        <div class="escape-report-field__value">
                            {{ trim(($client->prefix ?? '') . ($client->first_name ?? '') . ' ' . ($client->last_name ?? '')) ?: '-' }}
                        </div>
                    </div>

                    <div class="escape-report-field">
                        <div class="escape-report-field__label">ประเภทการออก</div>
                        <div class="escape-report-field__value">
                            {{ $escape->retire->retire_name ?? '-' }}
                        </div>
                    </div>

                    <div class="escape-report-field">
                        <div class="escape-report-field__label">วันที่ออก</div>
                        <div class="escape-report-field__value">
                            {{ thaidate($escape->retire_date) }}
                        </div>
                    </div>

                    <div class="escape-report-field escape-report-field--full">
                        <div class="escape-report-field__label">พฤติการณ์ / สาเหตุ / เรื่องราว</div>
                        <div class="escape-report-field__textbox">
                            {!! nl2br(e($escape->stories ?: '-')) !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Follow History --}}
        <section class="escape-report-section">
            <div class="escape-report-section__head">
                <h2 class="escape-report-section__title">ประวัติการติดตาม</h2>
                <p class="escape-report-section__desc">รายการติดตามทั้งหมดที่เชื่อมกับเหตุการณ์นี้</p>
            </div>

            @if($followCount > 0)
                <div class="escape-report-follow-stack">
                    @foreach($escape->follows as $follow)
                        <article class="escape-report-follow">
                            <div class="escape-report-follow__head">
                                <div class="escape-report-follow__title-wrap">
                                    <div class="escape-report-follow__no">ครั้งที่ {{ $follow->count }}</div>
                                    <div class="escape-report-follow__date">{{ thaidate($follow->trace_date) }}</div>
                                </div>
                            </div>

                            <div class="escape-report-panel escape-report-panel--soft">
                                <div class="escape-report-grid">
                                    <div class="escape-report-field">
                                        <div class="escape-report-field__label">เลขติดตาม</div>
                                        <div class="escape-report-field__value">
                                            {{ $follow->trac_no ?: '-' }}
                                        </div>
                                    </div>

                                    <div class="escape-report-field">
                                        <div class="escape-report-field__label">วันที่รายงาน</div>
                                        <div class="escape-report-field__value">
                                            {{ thaidate($follow->report_date) }}
                                        </div>
                                    </div>

                                    <div class="escape-report-field">
                                        <div class="escape-report-field__label">วันที่ยุติ</div>
                                        <div class="escape-report-field__value">
                                            {{ thaidate($follow->stop_date) }}
                                        </div>
                                    </div>

                                    <div class="escape-report-field">
                                        <div class="escape-report-field__label">วันที่ลงโทษ</div>
                                        <div class="escape-report-field__value">
                                            {{ thaidate($follow->punish_date) }}
                                        </div>
                                    </div>

                                    <div class="escape-report-field escape-report-field--full">
                                        <div class="escape-report-field__label">รายละเอียดการติดตาม</div>
                                        <div class="escape-report-field__textbox">
                                            {!! nl2br(e($follow->detail ?: '-')) !!}
                                        </div>
                                    </div>

                                    <div class="escape-report-field escape-report-field--full">
                                        <div class="escape-report-field__label">การลงโทษ</div>
                                        <div class="escape-report-field__textbox">
                                            {!! nl2br(e($follow->punish ?: '-')) !!}
                                        </div>
                                    </div>

                                    <div class="escape-report-field escape-report-field--full">
                                        <div class="escape-report-field__label">หมายเหตุ</div>
                                        <div class="escape-report-field__textbox escape-report-field__textbox--muted">
                                            {!! nl2br(e($follow->remark ?: '-')) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="escape-report-empty">
                    <div class="escape-report-empty__icon">
                        <i class="bi bi-inboxes"></i>
                    </div>
                    <div class="escape-report-empty__title">ยังไม่มีข้อมูลการติดตาม</div>
                    <div class="escape-report-empty__desc">
                        เมื่อมีการบันทึกข้อมูลติดตาม ระบบจะแสดงรายละเอียดในส่วนนี้โดยอัตโนมัติ
                    </div>
                </div>
            @endif
        </section>

    </div>
</div>

<style>
/* =========================================================
   Escape Report Page
   Clean / Minimal / Professional
   Scoped only this page
========================================================= */
.escape-report-page{
    padding:20px 12px 30px;
    background:#f8fafc;
}

.escape-report-page .escape-report-shell{
    max-width:1200px;
    margin:0 auto;
}

/* Header */
.escape-report-page .escape-report-head{
    display:flex;
    align-items:flex-start;
    justify-content:space-between;
    gap:18px;
    flex-wrap:wrap;
    padding:0 0 18px;
    margin-bottom:20px;
    border-bottom:1px solid #e9eef5;
}

.escape-report-page .escape-report-head__left{
    min-width:0;
    flex:1 1 680px;
}

.escape-report-page .escape-report-head__eyebrow{
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

.escape-report-page .escape-report-head__title{
    margin:0 0 8px;
    font-size:clamp(1.45rem, 2vw, 1.95rem);
    font-weight:800;
    color:#0f172a;
    letter-spacing:-0.02em;
}

.escape-report-page .escape-report-head__desc{
    margin:0;
    max-width:760px;
    color:#64748b;
    font-size:.96rem;
    line-height:1.75;
}

.escape-report-page .escape-report-head__right{
    display:flex;
    align-items:center;
    gap:10px;
    flex-wrap:wrap;
}

.escape-report-page .escape-report-btn{
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

.escape-report-page .escape-report-btn--primary{
    background:#ffffff;
    border-color:#dbe5f0;
    color:#0f172a;
}

.escape-report-page .escape-report-btn--primary:hover{
    background:#f8fafc;
    color:#0f172a;
}

.escape-report-page .escape-report-btn--light{
    background:#ffffff;
    border-color:#e2e8f0;
    color:#475569;
}

.escape-report-page .escape-report-btn--light:hover{
    background:#f8fafc;
    color:#334155;
}

/* Summary */
.escape-report-page .escape-report-summary{
    display:grid;
    grid-template-columns:repeat(4, minmax(0, 1fr));
    gap:12px;
    margin-bottom:24px;
}

.escape-report-page .escape-report-summary__item{
    padding:16px 18px;
    background:#ffffff;
    border:1px solid #e7edf4;
    border-radius:18px;
}

.escape-report-page .escape-report-summary__label{
    margin-bottom:6px;
    color:#64748b;
    font-size:.88rem;
    font-weight:600;
}

.escape-report-page .escape-report-summary__value{
    color:#0f172a;
    font-size:1rem;
    font-weight:800;
    line-height:1.5;
    word-break:break-word;
}

/* Section */
.escape-report-page .escape-report-section{
    margin-bottom:24px;
}

.escape-report-page .escape-report-section__head{
    margin-bottom:12px;
}

.escape-report-page .escape-report-section__title{
    margin:0 0 4px;
    color:#0f172a;
    font-size:1.08rem;
    font-weight:800;
    letter-spacing:-0.01em;
}

.escape-report-page .escape-report-section__desc{
    margin:0;
    color:#64748b;
    font-size:.92rem;
    line-height:1.65;
}

/* Panel */
.escape-report-page .escape-report-panel{
    background:#ffffff;
    border:1px solid #e7edf4;
    border-radius:20px;
    padding:20px;
}

.escape-report-page .escape-report-panel--soft{
    background:#ffffff;
    border-color:#ecf1f6;
    box-shadow:none;
}

/* Grid */
.escape-report-page .escape-report-grid{
    display:grid;
    grid-template-columns:repeat(2, minmax(0, 1fr));
    gap:16px;
}

.escape-report-page .escape-report-field{
    min-width:0;
}

.escape-report-page .escape-report-field--full{
    grid-column:1 / -1;
}

.escape-report-page .escape-report-field__label{
    margin-bottom:6px;
    color:#475569;
    font-size:.9rem;
    font-weight:700;
}

.escape-report-page .escape-report-field__value{
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

.escape-report-page .escape-report-field__textbox{
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

.escape-report-page .escape-report-field__textbox--muted{
    background:#fbfcfd;
}

/* Follow */
.escape-report-page .escape-report-follow-stack{
    display:grid;
    gap:16px;
}

.escape-report-page .escape-report-follow{
    display:grid;
    gap:10px;
}

.escape-report-page .escape-report-follow__head{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:12px;
    flex-wrap:wrap;
}

.escape-report-page .escape-report-follow__title-wrap{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:12px;
    flex-wrap:wrap;
    width:100%;
}

.escape-report-page .escape-report-follow__no{
    color:#0f172a;
    font-size:1rem;
    font-weight:800;
}

.escape-report-page .escape-report-follow__date{
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

/* Empty */
.escape-report-page .escape-report-empty{
    padding:34px 18px;
    background:#ffffff;
    border:1px solid #e7edf4;
    border-radius:20px;
    text-align:center;
}

.escape-report-page .escape-report-empty__icon{
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

.escape-report-page .escape-report-empty__title{
    margin-bottom:6px;
    color:#1e293b;
    font-size:1rem;
    font-weight:800;
}

.escape-report-page .escape-report-empty__desc{
    color:#64748b;
    font-size:.92rem;
    line-height:1.7;
    max-width:460px;
    margin:0 auto;
}

/* Responsive */
@media (max-width: 1199.98px){
    .escape-report-page .escape-report-summary{
        grid-template-columns:repeat(2, minmax(0, 1fr));
    }
}

@media (max-width: 767.98px){
    .escape-report-page{
        padding:16px 8px 24px;
    }

    .escape-report-page .escape-report-summary,
    .escape-report-page .escape-report-grid{
        grid-template-columns:1fr;
    }

    .escape-report-page .escape-report-panel{
        padding:14px;
        border-radius:16px;
    }

    .escape-report-page .escape-report-summary__item{
        padding:14px;
        border-radius:16px;
    }

    .escape-report-page .escape-report-head{
        gap:14px;
        margin-bottom:18px;
        padding-bottom:16px;
    }

    .escape-report-page .escape-report-head__right{
        width:100%;
        overflow-x:auto;
        flex-wrap:nowrap;
        padding-bottom:2px;
    }

    .escape-report-page .escape-report-btn{
        flex:0 0 auto;
    }

    .escape-report-page .escape-report-follow__title-wrap{
        flex-direction:column;
        align-items:flex-start;
    }
}
</style>

@endsection