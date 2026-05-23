@extends('admin_client.admin_client')

@section('content')
<style>
    .ca-page{
        background:#f4f7fb;
        min-height:100vh;
        padding:22px 0 34px;
    }

    .ca-container{
    width:100%;
    max-width:100%;
    margin:0 auto;
    overflow:hidden;
}

.ca-page{
    background:#f4f7fb;
    min-height:100vh;
    padding:16px 14px 28px;
    overflow-x:hidden;
}

.ca-content{
    border:1px solid #e5e7eb;
    border-radius:16px;
    padding:14px 16px;
    background:#fbfdff;
    max-width:100%;
    overflow:hidden;
}

.ca-item-head{
    display:grid;
    grid-template-columns:minmax(0,1fr) auto;
    gap:10px;
    align-items:start;
}

.ca-item-title{
    font-size:1rem;
    font-weight:800;
    color:#0f172a;
    margin:0;
    line-height:1.35;
    overflow-wrap:anywhere;
}

.ca-date{
    color:#64748b;
    font-size:.86rem;
    font-weight:700;
    white-space:nowrap;
}

.ca-desc{
    color:#334155;
    margin:6px 0 0;
    line-height:1.55;
    overflow-wrap:anywhere;
}

.ca-meta{
    display:flex;
    gap:7px;
    flex-wrap:wrap;
    margin-top:10px;
}

.ca-badge{
    border-radius:999px;
    padding:4px 9px;
    background:#eef2ff;
    color:#3730a3;
    font-size:.78rem;
    font-weight:700;
    max-width:100%;
    overflow:hidden;
    text-overflow:ellipsis;
    white-space:nowrap;
}

    .ca-header{
        background:linear-gradient(135deg,#0f766e,#2563eb);
        color:#fff;
        border-radius:22px;
        padding:22px 24px;
        box-shadow:0 16px 36px rgba(15,23,42,.18);
        margin-bottom:18px;
    }

    .ca-header-top{
        display:flex;
        justify-content:space-between;
        gap:14px;
        align-items:flex-start;
        flex-wrap:wrap;
    }

    .ca-title{
        font-size:1.45rem;
        font-weight:800;
        margin:0;
    }

    .ca-subtitle{
        opacity:.92;
        margin-top:5px;
        font-size:.95rem;
    }

    .ca-actions{
        display:flex;
        gap:8px;
        flex-wrap:wrap;
    }

    .ca-btn{
        border:0;
        border-radius:999px;
        padding:9px 15px;
        font-weight:700;
        text-decoration:none;
        display:inline-flex;
        align-items:center;
        gap:6px;
        white-space:nowrap;
    }

    .ca-btn-light{
        background:#fff;
        color:#1e3a8a;
    }

    .ca-btn-outline{
        background:rgba(255,255,255,.14);
        color:#fff;
        border:1px solid rgba(255,255,255,.38);
    }

    .ca-filter-card{
        background:#fff;
        border-radius:18px;
        padding:18px;
        box-shadow:0 10px 26px rgba(15,23,42,.08);
        margin-bottom:18px;
    }

    .ca-label{
        font-weight:700;
        color:#334155;
        margin-bottom:6px;
        font-size:.9rem;
    }

    .ca-timeline-card{
        background:#fff;
        border-radius:20px;
        padding:22px 20px;
        box-shadow:0 10px 26px rgba(15,23,42,.08);
    }

    .ca-timeline{
        position:relative;
        padding-left:34px;
    }

    .ca-timeline:before{
        content:"";
        position:absolute;
        left:13px;
        top:4px;
        bottom:4px;
        width:3px;
        background:#dbeafe;
        border-radius:999px;
    }

    .ca-item{
        position:relative;
        padding:0 0 20px;
    }

    .ca-item:last-child{
        padding-bottom:0;
    }

    .ca-dot{
        position:absolute;
        left:-33px;
        top:0;
        width:30px;
        height:30px;
        border-radius:50%;
        display:flex;
        align-items:center;
        justify-content:center;
        color:#fff;
        box-shadow:0 6px 16px rgba(15,23,42,.18);
    }

    .ca-type-info .ca-dot{ background:#2563eb; }
    .ca-type-success .ca-dot{ background:#16a34a; }
    .ca-type-warning .ca-dot{ background:#f59e0b; }
    .ca-type-danger .ca-dot{ background:#dc2626; }

    .ca-content{
        border:1px solid #e5e7eb;
        border-radius:16px;
        padding:14px 16px;
        background:#fbfdff;
    }

    .ca-item-head{
        display:flex;
        justify-content:space-between;
        gap:10px;
        flex-wrap:wrap;
        margin-bottom:6px;
    }

    .ca-item-title{
        font-size:1.03rem;
        font-weight:800;
        color:#0f172a;
        margin:0;
    }

    .ca-date{
        color:#64748b;
        font-size:.9rem;
        font-weight:600;
    }

    .ca-desc{
        color:#334155;
        margin:6px 0 0;
        line-height:1.55;
    }

    .ca-meta{
        display:flex;
        gap:8px;
        flex-wrap:wrap;
        margin-top:10px;
    }

    .ca-badge{
        border-radius:999px;
        padding:4px 9px;
        background:#eef2ff;
        color:#3730a3;
        font-size:.82rem;
        font-weight:700;
    }

    .ca-empty{
        text-align:center;
        padding:38px 18px;
        color:#64748b;
    }

    .ca-empty i{
        font-size:2.8rem;
        color:#cbd5e1;
        display:block;
        margin-bottom:10px;
    }
    .ca-pagination-wrap{
    margin-top:16px;
    overflow-x:auto;
    padding-bottom:4px;
}

.ca-pagination-wrap .pagination{
    margin:0;
    flex-wrap:wrap;
    gap:4px;
}

.ca-pagination-wrap .page-link{
    border-radius:10px !important;
    font-size:.85rem;
    padding:6px 10px;
}

    @media(max-width:767.98px){
        .ca-header{
            border-radius:16px;
            padding:18px;
        }

        .ca-title{
            font-size:1.18rem;
        }

        .ca-btn{
            width:100%;
            justify-content:center;
        }

        .ca-actions{
            width:100%;
        }

        .ca-timeline-card{
            padding:18px 14px;
        }
    }
</style>

    @php
    $moduleLabels = [
        'client'           => 'ผู้รับบริการ',
        'education_record' => 'บันทึกการศึกษา',
        'psychiatric'      => 'พบจิตแพทย์',
        'medical'          => 'พบแพทย์',
        'vaccine'          => 'วัคซีน',
        'observe'          => 'สังเกตพฤติกรรม',
        'addictive'        => 'พฤติกรรมเสพติด',
        'escape'           => 'หนีออกจากสถานสงเคราะห์',
        'school_followup'  => 'ติดตามการเรียน',
        'help_session'     => 'การช่วยเหลือ',
        'job_agency'       => 'จัดหางาน',
        'refer'            => 'จำหน่าย / ส่งต่อ',
        'absent'           => 'ขาดเรียน',
        'operation'        => 'กิจกรรมประจำวัน',
        'estimate'         => 'แบบประเมิน',
        'health_checkup'   => 'ตรวจสุขภาพ',
        'accident'         => 'อุบัติเหตุ',
    ];
@endphp

<div class="ca-page">
    <div class="ca-container">

        <div class="ca-header">
            <div class="ca-header-top">
                <div>
                    <h1 class="ca-title">
                        <i class="bi bi-clock-history me-1"></i>
                        Timeline ความเคลื่อนไหวของเคส
                    </h1>
                    <div class="ca-subtitle">
                        {{ $client->first_name ?? '' }} {{ $client->last_name ?? '' }}
                        @if(!empty($client->register_number))
                            | เลขทะเบียน {{ $client->register_number }}
                        @endif
                    </div>
                </div>

                <div class="ca-actions">
                    <a href="{{ route('case-activities.report', array_merge(['client' => $client->id], request()->query())) }}"
                       target="_blank"
                       class="ca-btn ca-btn-light">
                        <i class="bi bi-printer"></i>
                        พิมพ์รายงาน
                    </a>

                    <a href="{{ url()->previous() }}"
                       class="ca-btn ca-btn-outline">
                        <i class="bi bi-arrow-left"></i>
                        ย้อนกลับ
                    </a>
                </div>
            </div>
        </div>

        <div class="ca-filter-card">
            <form method="GET" action="{{ route('case-activities.index', $client->id) }}">
                <div class="row g-3 align-items-end">

                    <div class="col-md-3">
                        <label class="ca-label">ประเภท Module</label>
                        <select name="module" class="form-select rounded-3">
                            <option value="">ทั้งหมด</option>

                            @foreach($modules as $module)
                                <option value="{{ $module }}" {{ request('module') == $module ? 'selected' : '' }}>
                                    {{ $moduleLabels[$module] ?? $module }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="ca-label">ระดับเหตุการณ์</label>
                        <select name="type" class="form-select rounded-3">
                            <option value="">ทั้งหมด</option>
                            <option value="info" {{ request('type') == 'info' ? 'selected' : '' }}>ทั่วไป</option>
                            <option value="success" {{ request('type') == 'success' ? 'selected' : '' }}>สำเร็จ</option>
                            <option value="warning" {{ request('type') == 'warning' ? 'selected' : '' }}>เฝ้าระวัง</option>
                            <option value="danger" {{ request('type') == 'danger' ? 'selected' : '' }}>เร่งด่วน</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="ca-label">จากวันที่</label>
                        <input type="date"
                               name="date_from"
                               value="{{ request('date_from') }}"
                               class="form-control rounded-3">
                    </div>

                    <div class="col-md-2">
                        <label class="ca-label">ถึงวันที่</label>
                        <input type="date"
                               name="date_to"
                               value="{{ request('date_to') }}"
                               class="form-control rounded-3">
                    </div>

                    <div class="col-md-2 d-grid">
                        <button type="submit" class="btn btn-primary rounded-3 fw-bold">
                            <i class="bi bi-search"></i>
                            ค้นหา
                        </button>
                    </div>

                </div>
            </form>
        </div>

        <div class="ca-timeline-card">
            @if($activities->count())
                <div class="ca-timeline">
                    @foreach($activities as $activity)
                        @php
                            $typeClass = 'ca-type-' . ($activity->type ?? 'info');
                            $icon = $activity->icon ?: 'bi-clock-history';
                            $moduleName = $moduleLabels[$activity->module] ?? $activity->module;
                        @endphp

                        <div class="ca-item {{ $typeClass }}">
                            <div class="ca-dot">
                                <i class="bi {{ $icon }}"></i>
                            </div>

                            <div class="ca-content">
                                <div class="ca-item-head">
                                    <h3 class="ca-item-title">
                                        {{ $activity->title }}
                                    </h3>

                                    <div class="ca-date">
                                        @if($activity->occurred_at)
                                            {{ $activity->occurred_at->format('d/m/') }}{{ $activity->occurred_at->year + 543 }}
                                            เวลา {{ $activity->occurred_at->format('H:i') }} น.
                                        @else
                                            -
                                        @endif
                                    </div>
                                </div>

                                @if($activity->description)
                                    <p class="ca-desc">
                                        {{ $activity->description }}
                                    </p>
                                @endif

                                <div class="ca-meta">
                                    @if($activity->module)
                                        <span class="ca-badge">
                                            <i class="bi bi-folder2-open me-1"></i>
                                            {{ $moduleName }}
                                        </span>
                                    @endif

                                    @if($activity->user)
                                        <span class="ca-badge">
                                            <i class="bi bi-person me-1"></i>
                                            {{ $activity->user->name }}
                                        </span>
                                    @endif

                                    @if($activity->url)
                                        <a href="{{ $activity->url }}" class="ca-badge text-decoration-none">
                                            <i class="bi bi-box-arrow-up-right me-1"></i>
                                            เปิดรายการ
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($activities->hasPages())
                    <div class="ca-pagination-wrap">
                        {{ $activities->onEachSide(1)->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            @else
                <div class="ca-empty">
                    <i class="bi bi-inbox"></i>
                    ยังไม่มีประวัติความเคลื่อนไหวของเคสนี้
                </div>
            @endif
        </div>

    </div>
</div>
@endsection