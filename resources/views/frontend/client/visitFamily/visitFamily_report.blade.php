@extends('admin_client.admin_client')
@section('content')

<style>
.visit-report-page{
    background:#f4f6f9;
    padding:18px 12px 32px;
}

.visit-report-shell{
    max-width:1100px;
    margin:0 auto;
}

.visit-report-card{
    background:#fff;
    border:1px solid #d8dee8;
    border-radius:8px;
    box-shadow:0 4px 14px rgba(15,23,42,.06);
    overflow:hidden;
}

.visit-report-header{
    padding:18px 20px;
    border-bottom:1px solid #e5eaf0;
    background:linear-gradient(180deg,#ffffff 0%,#f8fbff 100%);
}

.visit-report-title{
    font-size:22px;
    font-weight:800;
    color:#1f3f68;
    margin:0;
}

.visit-report-subtitle{
    font-size:14px;
    color:#64748b;
    margin-top:4px;
}

.visit-report-actions{
    display:flex;
    flex-wrap:wrap;
    gap:8px;
    justify-content:flex-end;
}

.visit-btn{
    border-radius:6px;
    font-size:14px;
    font-weight:700;
    padding:7px 14px;
}

.visit-report-body{
    padding:20px;
}

.visit-section{
    margin-bottom:22px;
}

.visit-section-title{
    font-size:16px;
    font-weight:800;
    color:#234f87;
    padding-bottom:8px;
    margin-bottom:12px;
    border-bottom:1px solid #e5eaf0;
}

.visit-info-grid{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:12px;
}

.visit-info-item{
    border-bottom:1px solid #edf1f5;
    padding-bottom:8px;
}

.visit-label{
    font-size:13px;
    color:#64748b;
    margin-bottom:3px;
}

.visit-value{
    font-size:14px;
    color:#111827;
    font-weight:600;
    line-height:1.55;
    white-space:pre-line;
}

.visit-text-block{
    border:1px solid #e5eaf0;
    border-radius:6px;
    padding:10px 12px;
    background:#fcfdff;
    margin-bottom:10px;
}

.visit-gallery{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:10px;
}

.visit-gallery img{
    width:100%;
    height:160px;
    object-fit:cover;
    border-radius:6px;
    border:1px solid #d8dee8;
}

@media(max-width:991.98px){
    .visit-info-grid{
        grid-template-columns:repeat(2,1fr);
    }

    .visit-gallery{
        grid-template-columns:repeat(2,1fr);
    }
}

@media(max-width:575.98px){
    .visit-report-header{
        padding:14px;
    }

    .visit-report-body{
        padding:14px;
    }

    .visit-info-grid{
        grid-template-columns:1fr;
    }

    .visit-report-actions{
        justify-content:flex-start;
        margin-top:10px;
    }

    .visit-btn{
        width:100%;
    }
}

@media print{
    body{
        background:#fff !important;
    }

    .visit-report-page{
        padding:0;
        background:#fff;
    }

    .visit-report-card{
        box-shadow:none;
        border:0;
    }

    .visit-report-actions,
    .navbar,
    .sidebar,
    .footer{
        display:none !important;
    }
}
</style>

<div class="visit-report-page">
    <div class="visit-report-shell">
        <div class="visit-report-card">

            <div class="visit-report-header">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <h1 class="visit-report-title">รายงานการเยี่ยมบ้าน</h1>
                        <div class="visit-report-subtitle">
                            {{ $client->first_name ?? '-' }} {{ $client->last_name ?? '' }}
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="visit-report-actions">
                            <button type="button" onclick="window.print()" class="btn btn-primary visit-btn">
                                <i class="bi bi-printer me-1"></i> พิมพ์รายงาน
                            </button>

                            <a href="{{ route('vitsitFamily.edit', $visitFamily->id) }}" class="btn btn-light border visit-btn">
                                <i class="bi bi-arrow-left me-1"></i> กลับหน้าแก้ไข
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="visit-report-body">

                <div class="visit-section">
                    <div class="visit-section-title">ข้อมูลทั่วไป</div>

                    <div class="visit-info-grid">
                        <div class="visit-info-item">
                            <div class="visit-label">วันที่เยี่ยมบ้าน</div>
                            <div class="visit-value">
                                {{ optional($visitFamily->visit_date)->format('d/m/Y') ?? $visitFamily->visit_date ?? '-' }}
                            </div>
                        </div>

                        <div class="visit-info-item">
                            <div class="visit-label">ผู้ให้ข้อมูล</div>
                            <div class="visit-value">{{ $visitFamily->family_fname ?? '-' }}</div>
                        </div>

                        <div class="visit-info-item">
                            <div class="visit-label">อายุ</div>
                            <div class="visit-value">{{ $visitFamily->family_age ?? '-' }} ปี</div>
                        </div>

                        <div class="visit-info-item">
                            <div class="visit-label">ความสัมพันธ์กับผู้รับ</div>
                            <div class="visit-value">{{ $visitFamily->member ?? '-' }}</div>
                        </div>

                        <div class="visit-info-item">
                            <div class="visit-label">รายได้เฉลี่ยครอบครัว</div>
                            <div class="visit-value">{{ $visitFamily->income->income_name ?? '-' }}</div>
                        </div>

                        <div class="visit-info-item">
                            <div class="visit-label">สถานะการอยู่อาศัย</div>
                            <div class="visit-value">{{ $visitFamily->residence_status ?? '-' }}</div>
                        </div>
                    </div>
                </div>

                <div class="visit-section">
                    <div class="visit-section-title">ที่อยู่</div>

                    <div class="visit-info-grid">
                        <div class="visit-info-item">
                            <div class="visit-label">เลขที่</div>
                            <div class="visit-value">{{ $visitFamily->address ?? '-' }}</div>
                        </div>

                        <div class="visit-info-item">
                            <div class="visit-label">หมู่ที่</div>
                            <div class="visit-value">{{ $visitFamily->moo ?? '-' }}</div>
                        </div>

                        <div class="visit-info-item">
                            <div class="visit-label">ซอย / ถนน</div>
                            <div class="visit-value">
                                {{ $visitFamily->soi ?? '-' }} / {{ $visitFamily->road ?? '-' }}
                            </div>
                        </div>

                        <div class="visit-info-item">
                            <div class="visit-label">หมู่บ้าน</div>
                            <div class="visit-value">{{ $visitFamily->village ?? '-' }}</div>
                        </div>

                        <div class="visit-info-item">
                            <div class="visit-label">รหัสไปรษณีย์</div>
                            <div class="visit-value">{{ $visitFamily->zipcode ?? '-' }}</div>
                        </div>

                        <div class="visit-info-item">
                            <div class="visit-label">โทรศัพท์</div>
                            <div class="visit-value">{{ $visitFamily->phone ?? '-' }}</div>
                        </div>
                    </div>
                </div>

                <div class="visit-section">
                    <div class="visit-section-title">สภาพบ้านและครอบครัว</div>

                    @foreach([
                        'สภาพที่อยู่ภายนอก' => $visitFamily->outside_address,
                        'สภาพที่อยู่ภายใน' => $visitFamily->inside_address,
                        'สภาพแวดล้อม' => $visitFamily->environment,
                        'ความสัมพันธ์กับเพื่อนบ้าน' => $visitFamily->neighbor,
                        'ความสัมพันธ์ของสมาชิกในบ้าน' => $visitFamily->member_relation,
                    ] as $label => $value)
                        <div class="visit-text-block">
                            <div class="visit-label">{{ $label }}</div>
                            <div class="visit-value">{{ $value ?: '-' }}</div>
                        </div>
                    @endforeach
                </div>

                <div class="visit-section">
                    <div class="visit-section-title">การประเมินและการช่วยเหลือ</div>

                    @foreach([
                        'ปัญหาที่พบ' => $visitFamily->problem,
                        'ความต้องการ' => $visitFamily->need,
                        'การวินิจฉัยปัญหา' => $visitFamily->diagnose,
                        'การให้ความช่วยเหลือ' => $visitFamily->assistance,
                        'ข้อคิดเห็น' => $visitFamily->comment,
                        'สิ่งที่ควรแก้ไข' => $visitFamily->modify,
                        'หมายเหตุ' => $visitFamily->remark,
                    ] as $label => $value)
                        <div class="visit-text-block">
                            <div class="visit-label">{{ $label }}</div>
                            <div class="visit-value">{{ $value ?: '-' }}</div>
                        </div>
                    @endforeach
                </div>

                <div class="visit-section">
                    <div class="visit-section-title">ผู้ติดตามเยี่ยมบ้าน</div>
                    <div class="visit-value">{{ $visitFamily->teacher ?? '-' }}</div>
                </div>

                @if(isset($visitFamily->images) && $visitFamily->images->count() > 0)
                    <div class="visit-section">
                        <div class="visit-section-title">รูปภาพประกอบการเยี่ยมบ้าน</div>

                        <div class="visit-gallery">
                            @foreach($visitFamily->images as $img)
                                <img src="{{ asset('storage/'.$img->file_path) }}" alt="visit image">
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>

@endsection