<style>
    .hp-main-header{
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:16px;
        flex-wrap:wrap;
        margin-bottom:1rem;
        padding:18px 20px;
        border:1px solid #e7edf5;
        border-radius:18px;
        background:linear-gradient(135deg, #ffffff 0%, #f8fbff 100%);
        box-shadow:0 8px 24px rgba(15, 23, 42, 0.04);
    }

    .hp-header-title{
        display:flex;
        align-items:flex-start;
        gap:14px;
        min-width:0;
        flex:1 1 420px;
    }

    .hp-header-icon{
        width:48px;
        height:48px;
        border-radius:14px;
        display:inline-flex;
        align-items:center;
        justify-content:center;
        background:#eef4ff;
        color:#4f6edb;
        font-size:1.2rem;
        flex:0 0 48px;
    }

    .hp-header-text h6{
        margin:0 0 4px 0;
        font-size:1.08rem;
        font-weight:800;
        color:#0f172a;
        line-height:1.35;
    }

    .hp-header-text p{
        margin:0;
        color:#64748b;
        font-size:.95rem;
        line-height:1.55;
    }

    .hp-header-actions{
        display:flex;
        align-items:center;
        gap:12px;
        flex-wrap:wrap;
        justify-content:flex-end;
    }

    .hp-main-header .hp-btn{
        display:inline-flex;
        align-items:center;
        gap:8px;
        min-height:44px;
        padding:.68rem 1rem;
        border-radius:12px;
        font-weight:700;
        white-space:nowrap;
        box-shadow:none;
    }

    .hp-filter-card{
        margin-bottom:1rem;
        padding:18px 20px;
        border:1px solid #e7edf5;
        border-radius:18px;
        background:#ffffff;
        box-shadow:0 8px 24px rgba(15, 23, 42, 0.04);
    }

    .hp-filter-head{
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:12px;
        flex-wrap:wrap;
        margin-bottom:14px;
    }

    .hp-filter-title{
        display:flex;
        align-items:center;
        gap:10px;
        color:#0f172a;
        font-weight:800;
        font-size:1rem;
    }

    .hp-filter-title i{
        color:#4f6edb;
        font-size:1.05rem;
    }

    .hp-filter-subtitle{
        color:#64748b;
        font-size:.92rem;
        line-height:1.55;
        margin:0;
    }

    .hp-filter-form{
        display:grid;
        grid-template-columns: minmax(180px, 220px) minmax(180px, 220px) auto;
        gap:14px;
        align-items:end;
    }

    .hp-filter-group{
        display:flex;
        flex-direction:column;
        gap:8px;
    }

    .hp-filter-label{
        margin:0;
        color:#334155;
        font-size:.92rem;
        font-weight:700;
    }

    .hp-filter-input{
        height:44px;
        border:1px solid #d6deea;
        border-radius:12px;
        padding:0 14px;
        color:#0f172a;
        background:#fff;
        outline:none;
        transition:border-color .15s ease, box-shadow .15s ease;
    }

    .hp-filter-input:focus{
        border-color:#90b4ff;
        box-shadow:0 0 0 4px rgba(79, 110, 219, 0.10);
    }

    .hp-filter-actions{
        display:flex;
        align-items:center;
        gap:10px;
        flex-wrap:wrap;
    }

    .hp-filter-btn{
        display:inline-flex;
        align-items:center;
        justify-content:center;
        gap:8px;
        min-height:44px;
        padding:.68rem 1rem;
        border-radius:12px;
        font-weight:700;
        text-decoration:none;
        white-space:nowrap;
        border:1px solid transparent;
    }

    .hp-filter-btn-outline{
        background:#fff;
        color:#334155;
        border-color:#cfd9e8;
    }

    .hp-filter-btn-outline:hover{
        background:#f8fafc;
        color:#0f172a;
        border-color:#b9c7da;
    }

    .hp-filter-note{
        margin-top:12px;
        color:#64748b;
        font-size:.9rem;
        line-height:1.55;
    }

    .hp-empty-card{
        margin-bottom:1rem;
        padding:52px 20px;
        border:1px solid #e7edf5;
        border-radius:22px;
        background:linear-gradient(135deg, #ffffff 0%, #f8fbff 100%);
        box-shadow:0 12px 32px rgba(15, 23, 42, 0.06);
        text-align:center;
    }

    .hp-empty-icon{
        width:86px;
        height:86px;
        margin:0 auto 18px;
        border-radius:50%;
        display:inline-flex;
        align-items:center;
        justify-content:center;
        background:#eef4ff;
        color:#4f6edb;
        font-size:2.1rem;
        box-shadow:0 12px 28px rgba(79, 110, 219, .14);
    }

    .hp-empty-card h5{
        margin:0 0 8px;
        color:#0f172a;
        font-size:1.25rem;
        font-weight:800;
    }

    .hp-empty-card p{
        max-width:620px;
        margin:0 auto 22px;
        color:#64748b;
        line-height:1.8;
    }

    .hp-empty-card .hp-btn{
        display:inline-flex;
        align-items:center;
        justify-content:center;
        gap:8px;
        min-height:44px;
        padding:.68rem 1rem;
        border-radius:12px;
        font-weight:700;
    }

    @media (max-width: 991.98px){
        .hp-main-header{
            align-items:flex-start;
        }

        .hp-header-actions{
            width:100%;
            justify-content:flex-start;
        }

        .hp-filter-form{
            grid-template-columns:1fr 1fr;
        }

        .hp-filter-actions{
            grid-column:1 / -1;
        }
    }

    @media (max-width: 575.98px){
        .hp-main-header,
        .hp-filter-card,
        .hp-empty-card{
            padding:14px;
        }

        .hp-header-actions{
            width:100%;
        }

        .hp-main-header .hp-btn,
        .hp-empty-card .hp-btn{
            width:100%;
            justify-content:center;
        }

        .hp-filter-form{
            grid-template-columns:1fr;
        }

        .hp-filter-actions{
            width:100%;
        }

        .hp-filter-btn{
            width:100%;
        }

        .hp-empty-card{
            padding-top:42px;
            padding-bottom:42px;
        }

        .hp-empty-icon{
            width:74px;
            height:74px;
            font-size:1.8rem;
        }
    }
</style>

@php
    $hasHelpingRows = false;

    if (isset($helpSessions)) {
        $hasHelpingRows = $helpSessions->count() > 0;
    } elseif (isset($help_sessions)) {
        $hasHelpingRows = $help_sessions->count() > 0;
    } elseif (isset($sessions)) {
        $hasHelpingRows = $sessions->count() > 0;
    } elseif (isset($items)) {
        $hasHelpingRows = $items->count() > 0;
    }

    $hasDateFilter = request()->filled('from') || request()->filled('to');

    /*
        ✅ ถ้ามีข้อมูลจริง หรือมีการกรองวันที่ ให้แสดงส่วนหัว/ข้อมูลผู้รับ/ค้นหา
        ✅ ถ้าไม่มีข้อมูลเลย ให้ซ่อนทั้งหมดและแสดง Empty State แทน
    */
    $showHelpHeaderSection = $hasHelpingRows || $hasDateFilter;
@endphp

@if($showHelpHeaderSection)
    <div class="hp-main-header">
        <div class="hp-header-title">
            <span class="hp-header-icon">
                <i class="bi bi-heart-pulse-fill"></i>
            </span>

            <div class="hp-header-text">
                <h6>รายการให้ความช่วยเหลือผู้รับ</h6>
                <p>ออกแบบใหม่ให้ทันสมัย อ่านง่าย และใช้งานได้ดีทุกขนาดหน้าจอ</p>
            </div>
        </div>

        <div class="hp-header-actions">
            <a href="{{ route('help_sessions.create', $client->id) }}" class="btn btn-primary hp-btn">
                <i class="bi bi-plus-circle"></i>
                <span>เพิ่มการช่วยเหลือใหม่</span>
            </a>
        </div>
    </div>

    {{-- Profile Card --}}
    @include('frontend.client.helping.partials.profile-card')

    <div class="hp-filter-card">
        <div class="hp-filter-head">
            <div>
                <div class="hp-filter-title">
                    <i class="bi bi-funnel-fill"></i>
                    <span>ค้นหาและออกรายงานตามช่วงวันที่</span>
                </div>

                <p class="hp-filter-subtitle">
                    เลือกช่วงวันที่เพื่อดูรายการเฉพาะช่วง หรือกดดูทั้งหมดเพื่อแสดงข้อมูลทุกวัน
                </p>
            </div>
        </div>

        <form method="GET" action="{{ route('help_sessions.show', $client->id) }}" class="hp-filter-form">
            <div class="hp-filter-group">
                <label for="from" class="hp-filter-label">ตั้งแต่วันที่</label>
                <input type="date"
                       id="from"
                       name="from"
                       class="hp-filter-input"
                       value="{{ request('from') }}">
            </div>

            <div class="hp-filter-group">
                <label for="to" class="hp-filter-label">ถึงวันที่</label>
                <input type="date"
                       id="to"
                       name="to"
                       class="hp-filter-input"
                       value="{{ request('to') }}">
            </div>

            <div class="hp-filter-actions">
                <button type="submit" class="btn btn-primary hp-filter-btn">
                    <i class="bi bi-search"></i>
                    <span>ค้นหา</span>
                </button>

                <a href="{{ route('help_sessions.show', $client->id) }}"
                   class="hp-filter-btn hp-filter-btn-outline">
                    <i class="bi bi-arrow-clockwise"></i>
                    <span>ดูทั้งหมด</span>
                </a>

                @if($hasHelpingRows)
                    <a href="{{ route('help_sessions.report_range', ['client' => $client->id, 'from' => request('from'), 'to' => request('to')]) }}"
                       class="hp-filter-btn hp-filter-btn-outline">
                        <i class="bi bi-printer"></i>
                        <span>รายงานตามช่วงวันที่</span>
                    </a>
                @endif
            </div>
        </form>

        <div class="hp-filter-note">
            กรณีไม่เลือกวันที่ ระบบจะแสดงข้อมูลทั้งหมดโดยอัตโนมัติ
        </div>
    </div>
@else
    <div class="hp-empty-card">
        <div class="hp-empty-icon">
            <i class="bi bi-inbox"></i>
        </div>

        <h5>ยังไม่มีข้อมูลการให้ความช่วยเหลือ</h5>

        <p>
            เมื่อยังไม่มีข้อมูล ระบบจะซ่อนข้อมูลผู้รับบริการ ช่องค้นหา และปุ่มรายงานไว้ก่อน
            เพื่อให้หน้าจอดูสะอาดและใช้งานง่ายขึ้น
        </p>

        <a href="{{ route('help_sessions.create', $client->id) }}" class="btn btn-primary hp-btn">
            <i class="bi bi-plus-circle"></i>
            <span>เพิ่มการช่วยเหลือใหม่</span>
        </a>
    </div>
@endif