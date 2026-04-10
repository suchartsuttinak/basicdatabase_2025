@extends('admin_client.admin_client')
@section('content')

<link rel="stylesheet" href="{{ asset('backend/assets/css/style.css') }}">

<style>
    .family-member-page{
        --fmp-primary:#0f766e;
        --fmp-primary-2:#14b8a6;
        --fmp-accent:#0d47a1;
        --fmp-text:#1f2937;
        --fmp-muted:#6b7280;
        --fmp-border:#dbe7e7;
        --fmp-border-strong:#cfdfe1;
        --fmp-bg:#f4f8f9;
        --fmp-card:#ffffff;
        --fmp-soft:#f8fbfb;
        --fmp-shadow:0 10px 24px rgba(15,23,42,.05);
        --fmp-shadow-lg:0 18px 40px rgba(15,23,42,.08);
        --fmp-radius-xl:22px;
        --fmp-radius-lg:18px;
        --fmp-radius-md:14px;
        --fmp-radius-sm:12px;
    }

    .family-member-page{
        padding:1rem;
        color:var(--fmp-text);
    }

    .family-member-shell{
        background:linear-gradient(180deg,#fcfefe 0%,#f7fbfb 100%);
        border:1px solid var(--fmp-border);
        border-radius:var(--fmp-radius-xl);
        box-shadow:var(--fmp-shadow);
        overflow:hidden;
    }

    .family-member-header{
        padding:1.15rem 1.15rem .8rem;
        border-bottom:1px solid rgba(219,231,231,.75);
        background:
            radial-gradient(circle at top right, rgba(20,184,166,.08), transparent 24%),
            linear-gradient(180deg, rgba(255,255,255,.96), rgba(248,251,251,.94));
    }

    .family-member-title-wrap{
        display:flex;
        align-items:flex-start;
        justify-content:space-between;
        gap:1rem;
        flex-wrap:wrap;
    }

    .family-member-title-box{
        min-width:0;
    }

    .family-member-title{
        margin:0;
        font-size:1.24rem;
        font-weight:800;
        line-height:1.2;
        color:var(--fmp-accent);
    }

    .family-member-subtitle{
        margin:.38rem 0 0;
        font-size:.93rem;
        line-height:1.55;
        color:var(--fmp-muted);
    }

    .family-member-badge{
        display:inline-flex;
        align-items:center;
        gap:.5rem;
        padding:.68rem .9rem;
        border-radius:999px;
        border:1px solid var(--fmp-border);
        background:#fff;
        color:var(--fmp-primary);
        font-size:.88rem;
        font-weight:700;
        white-space:nowrap;
        box-shadow:0 6px 16px rgba(15,23,42,.04);
    }

    .family-member-body{
        padding:1rem;
    }

    .family-client-card{
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:1rem;
        flex-wrap:wrap;
        padding:1rem;
        margin-bottom:1rem;
        background:linear-gradient(180deg,#ffffff 0%,#f9fcfc 100%);
        border:1px solid var(--fmp-border);
        border-radius:var(--fmp-radius-lg);
        box-shadow:0 8px 20px rgba(15,23,42,.04);
    }

    .family-client-info{
        display:flex;
        align-items:center;
        gap:.9rem;
        min-width:0;
    }

    .family-client-avatar{
        width:52px;
        height:52px;
        min-width:52px;
        border-radius:16px;
        display:inline-flex;
        align-items:center;
        justify-content:center;
        background:linear-gradient(135deg, rgba(15,118,110,.14), rgba(20,184,166,.10));
        color:var(--fmp-primary);
        border:1px solid rgba(15,118,110,.10);
        box-shadow:inset 0 1px 0 rgba(255,255,255,.75);
        font-size:1.35rem;
    }

    .family-client-text{
        min-width:0;
    }

    .family-client-name{
        margin:0;
        font-size:1.05rem;
        font-weight:800;
        color:var(--fmp-text);
        line-height:1.2;
        word-break:break-word;
    }

    .family-client-meta{
        margin:.3rem 0 0;
        display:flex;
        align-items:center;
        gap:.75rem;
        flex-wrap:wrap;
        font-size:.9rem;
        color:var(--fmp-muted);
    }

    .family-client-meta span{
        display:inline-flex;
        align-items:center;
        gap:.35rem;
    }

    .family-action-group{
        display:flex;
        align-items:center;
        gap:.65rem;
        flex-wrap:wrap;
    }

    .family-action-btn{
        min-height:44px;
        border-radius:12px;
        padding:.72rem 1rem;
        font-weight:700;
        font-size:.92rem;
        display:inline-flex;
        align-items:center;
        gap:.45rem;
        text-decoration:none;
        transition:.2s ease;
        box-shadow:none;
    }

    .family-action-btn:hover{
        transform:translateY(-1px);
    }

    .family-action-btn.btn-outline-primary{
        border-color:rgba(13,71,161,.22);
        color:#0d47a1;
        background:#fff;
    }

    .family-action-btn.btn-outline-primary:hover{
        background:rgba(13,71,161,.05);
        color:#0b3a83;
        border-color:rgba(13,71,161,.28);
    }

    .family-action-btn.btn-outline-success{
        border-color:rgba(15,118,110,.22);
        color:var(--fmp-primary);
        background:#fff;
    }

    .family-action-btn.btn-outline-success:hover{
        background:rgba(15,118,110,.06);
        color:#0b5f59;
        border-color:rgba(15,118,110,.28);
    }

    .family-table-card{
        background:var(--fmp-card);
        border:1px solid var(--fmp-border);
        border-radius:var(--fmp-radius-lg);
        box-shadow:0 8px 20px rgba(15,23,42,.04);
        overflow:hidden;
    }

    .family-table-head{
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:1rem;
        flex-wrap:wrap;
        padding:1rem;
        background:linear-gradient(180deg,#ffffff 0%,#f9fcfc 100%);
        border-bottom:1px solid var(--fmp-border);
    }

    .family-table-title{
        margin:0;
        font-size:1rem;
        font-weight:800;
        color:var(--fmp-text);
        display:flex;
        align-items:center;
        gap:.55rem;
    }

    .family-table-title i{
        color:var(--fmp-primary);
    }

    .family-table-count{
        font-size:.88rem;
        font-weight:700;
        color:var(--fmp-muted);
        background:#fff;
        border:1px solid var(--fmp-border);
        border-radius:999px;
        padding:.45rem .75rem;
    }

    .family-table-wrap{
        width:100%;
        overflow-x:auto;
        overflow-y:hidden;
        -webkit-overflow-scrolling:touch;
    }

    .family-table{
        width:100%;
        min-width:980px;
        margin:0;
        border-collapse:separate;
        border-spacing:0;
    }

    .family-table thead th{
        background:#f4f8f9;
        color:#334155;
        font-size:.88rem;
        font-weight:800;
        letter-spacing:.01em;
        text-align:center;
        vertical-align:middle;
        padding:.9rem .8rem;
        border-bottom:1px solid var(--fmp-border);
        border-right:1px solid #e7eff0;
        white-space:nowrap;
    }

    .family-table thead th:last-child{
        border-right:0;
    }

    .family-table tbody td{
        padding:.95rem .85rem;
        font-size:.92rem;
        color:var(--fmp-text);
        vertical-align:middle;
        border-bottom:1px solid #edf3f4;
        border-right:1px solid #f1f5f6;
        background:#fff;
    }

    .family-table tbody td:last-child{
        border-right:0;
    }

    .family-table tbody tr:hover td{
        background:#fbfefe;
    }

    .family-table .text-start{
        text-align:left !important;
    }

    .family-member-name{
        font-weight:700;
        color:#111827;
    }

    .family-member-empty{
        padding:2rem 1rem !important;
        color:var(--fmp-muted) !important;
        font-size:.95rem;
        background:linear-gradient(180deg,#ffffff 0%,#fbfefe 100%) !important;
    }

    .family-member-empty-box{
        display:flex;
        flex-direction:column;
        align-items:center;
        justify-content:center;
        gap:.6rem;
    }

    .family-member-empty-box i{
        font-size:1.5rem;
        color:#94a3b8;
    }

    @media (max-width: 991.98px){
        .family-member-page{
            padding:.85rem;
        }

        .family-member-header,
        .family-member-body{
            padding:.9rem;
        }

        .family-client-card,
        .family-table-head{
            padding:.9rem;
        }

        .family-member-title{
            font-size:1.12rem;
        }
    }

    @media (max-width: 767.98px){
        .family-member-page{
            padding:.55rem;
        }

        .family-member-shell{
            border-radius:16px;
        }

        .family-member-header,
        .family-member-body{
            padding:.78rem;
        }

        .family-member-title{
            font-size:1.02rem;
        }

        .family-member-subtitle{
            font-size:.88rem;
        }

        .family-client-card{
            padding:.82rem;
            border-radius:16px;
        }

        .family-client-avatar{
            width:48px;
            height:48px;
            min-width:48px;
            border-radius:14px;
        }

        .family-client-name{
            font-size:.98rem;
        }

        .family-action-group{
            width:100%;
        }

        .family-action-group .family-action-btn{
            width:100%;
            justify-content:center;
        }

        .family-table-card{
            border-radius:16px;
        }

        .family-table-head{
            padding:.82rem;
        }

        .family-table-title{
            font-size:.95rem;
        }
    }
</style>

<div class="family-member-page">
    <div class="family-member-shell">

        {{-- @include('admin_client.include.tabs') --}}

        <div class="family-member-header">
            <div class="family-member-title-wrap">
                <div class="family-member-title-box">
                    <h2 class="family-member-title">บันทึกสมาชิกในครอบครัว</h2>
                    <p class="family-member-subtitle">
                        แสดงข้อมูลสมาชิกในครอบครัวของผู้รับบริการอย่างเป็นระเบียบ อ่านง่าย และรองรับทุกขนาดหน้าจอ
                    </p>
                </div>

                <div class="family-member-badge">
                    <i class="bi bi-people-fill"></i>
                    <span>{{ $members->count() }} รายการ</span>
                </div>
            </div>
        </div>

        <div class="family-member-body">
            <div class="family-client-card">
                <div class="family-client-info">
                    <div class="family-client-avatar">
                        <i class="bi bi-person-circle"></i>
                    </div>

                    <div class="family-client-text">
                        <h3 class="family-client-name">{{ $client->fullname }}</h3>
                        <div class="family-client-meta">
                            <span>
                                <i class="bi bi-hourglass-split"></i>
                                อายุ {{ $client->age }} ปี
                            </span>
                            <span>
                                <i class="bi bi-card-text"></i>
                                ผู้รับบริการ
                            </span>
                        </div>
                    </div>
                </div>

                <div class="family-action-group">
                    @if($members->count() > 0)
                        <a href="{{ route('member.edit', $client->id) }}" class="btn btn-outline-primary family-action-btn">
                            <i class="bi bi-pencil-square"></i>
                            <span>แก้ไขข้อมูล</span>
                        </a>
                    @else
                        <a href="{{ route('member.create', $client->id) }}" class="btn btn-outline-success family-action-btn">
                            <i class="bi bi-plus-circle"></i>
                            <span>เพิ่มข้อมูล</span>
                        </a>
                    @endif
                </div>
            </div>

            <div class="family-table-card">
                <div class="family-table-head">
                    <h4 class="family-table-title">
                        <i class="bi bi-table"></i>
                        รายการสมาชิกในครอบครัว
                    </h4>

                    <div class="family-table-count">
                        ทั้งหมด {{ $members->count() }} รายการ
                    </div>
                </div>

                <div class="family-table-wrap">
                    <table class="table family-table align-middle text-center">
                        <thead>
                            <tr>
                                <th style="width: 18%;">ชื่อ-นามสกุล</th>
                                <th style="width: 8%;">อายุ</th>
                                <th style="width: 15%;">การศึกษา</th>
                                <th style="width: 12%;">เกี่ยวข้องเป็น</th>
                                <th style="width: 15%;">อาชีพ</th>
                                <th style="width: 14%;">รายได้</th>
                                <th style="width: 18%;">หมายเหตุ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($members as $member)
                                <tr>
                                    <td class="text-start">
                                        <div class="family-member-name">{{ $member->fullname }}</div>
                                    </td>
                                    <td>{{ $member->member_age ?: '-' }}</td>
                                    <td>{{ $member->education->education_name ?? '-' }}</td>
                                    <td>{{ $member->relationship ?: '-' }}</td>
                                    <td>{{ $member->occupation->occupation_name ?? '-' }}</td>
                                    <td>{{ $member->income->income_name ?? '-' }}</td>
                                    <td class="text-start">{{ $member->remark ?: '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="family-member-empty">
                                        <div class="family-member-empty-box">
                                            <i class="bi bi-inbox"></i>
                                            <div>ยังไม่มีข้อมูลสมาชิกในครอบครัว</div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection