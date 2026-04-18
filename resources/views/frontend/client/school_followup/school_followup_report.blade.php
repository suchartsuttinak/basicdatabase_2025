@extends('admin_client.admin_client')

@section('content')
<style>
    .school-followup-report-page{
        padding: 16px 12px 28px;
    }

    .school-followup-report-shell{
        max-width: 980px;
        margin: 0 auto;
    }

    .school-followup-report-card{
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 20px;
        box-shadow: 0 10px 28px rgba(15, 23, 42, 0.06);
        overflow: hidden;
    }

    .school-followup-report-toolbar{
        display: flex;
        justify-content: flex-end;
        align-items: center;
        padding: 18px 20px 0;
    }

    .school-followup-report-back-btn{
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border-radius: 12px;
        padding: 10px 16px;
        font-weight: 600;
        box-shadow: none !important;
    }

    .school-followup-report-body{
        padding: 12px 22px 26px;
    }

    .school-followup-report-header{
        text-align: center;
        padding-bottom: 18px;
        margin-bottom: 20px;
        border-bottom: 1px solid #e5e7eb;
    }

    .school-followup-report-title{
        margin: 0;
        font-size: 1.55rem;
        font-weight: 700;
        color: #111827;
        line-height: 1.3;
    }

    .school-followup-report-subtitle{
        margin: 8px 0 0;
        color: #6b7280;
        font-size: .96rem;
    }

    .school-followup-report-section{
        margin-bottom: 18px;
    }

    .school-followup-report-section-title{
        margin: 0 0 12px;
        font-size: 1.02rem;
        font-weight: 700;
        color: #1f2937;
    }

    .school-followup-report-info-grid{
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
    }

    .school-followup-report-info-card{
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        padding: 12px 14px;
        min-height: 74px;
    }

    .school-followup-report-label{
        display: block;
        font-size: .88rem;
        font-weight: 600;
        color: #64748b;
        margin-bottom: 4px;
        line-height: 1.35;
    }

    .school-followup-report-value{
        display: block;
        font-size: 1rem;
        font-weight: 600;
        color: #111827;
        line-height: 1.55;
        word-break: break-word;
    }

    .school-followup-report-detail-box{
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        overflow: hidden;
    }

    .school-followup-report-detail-row{
        display: grid;
        grid-template-columns: 220px minmax(0, 1fr);
        border-bottom: 1px solid #eef2f7;
    }

    .school-followup-report-detail-row:last-child{
        border-bottom: 0;
    }

    .school-followup-report-detail-key{
        background: #f8fafc;
        padding: 12px 14px;
        font-weight: 700;
        color: #334155;
        line-height: 1.5;
    }

    .school-followup-report-detail-value{
        padding: 12px 14px;
        color: #111827;
        line-height: 1.6;
        word-break: break-word;
        white-space: pre-line;
    }

    .school-followup-report-signature{
        margin-top: 28px;
        display: flex;
        justify-content: flex-end;
    }

    .school-followup-report-signature-box{
        width: 280px;
        text-align: center;
        color: #374151;
    }

    .school-followup-report-signature-line{
        margin-bottom: 8px;
        padding-top: 24px;
        border-bottom: 1px solid #111827;
        height: 36px;
    }

    @media (max-width: 767.98px){
        .school-followup-report-page{
            padding: 12px 0 20px;
        }

        .school-followup-report-card{
            border-radius: 0;
            border-left: 0;
            border-right: 0;
        }

        .school-followup-report-toolbar{
            padding: 14px 14px 0;
        }

        .school-followup-report-body{
            padding: 10px 14px 18px;
        }

        .school-followup-report-title{
            font-size: 1.3rem;
        }

        .school-followup-report-info-grid{
            grid-template-columns: 1fr;
        }

        .school-followup-report-detail-row{
            grid-template-columns: 1fr;
        }

        .school-followup-report-detail-key{
            padding-bottom: 6px;
        }

        .school-followup-report-detail-value{
            padding-top: 0;
        }

        .school-followup-report-signature{
            justify-content: center;
        }

        .school-followup-report-signature-box{
            width: 100%;
            max-width: 260px;
        }
    }

    @media print{
        .school-followup-report-page{
            padding: 0;
        }

        .school-followup-report-card{
            box-shadow: none;
            border: 0;
            border-radius: 0;
        }

        .school-followup-report-toolbar{
            display: none !important;
        }

        .school-followup-report-body{
            padding: 0;
        }
    }
</style>

<div class="school-followup-report-page">
    <div class="school-followup-report-shell">
        <div class="school-followup-report-card">
            <div class="school-followup-report-toolbar">
                <a href="{{ route('school_followup_add', $client->id) }}" class="btn btn-primary school-followup-report-back-btn">
                    <i class="bi bi-arrow-left-circle"></i>
                    <span>กลับหน้าหลัก</span>
                </a>
            </div>

            <div class="school-followup-report-body">
                <div class="school-followup-report-header">
                    <h2 class="school-followup-report-title">รายงานการติดตามเด็กในโรงเรียน</h2>
                   
                </div>

                <div class="school-followup-report-section">
                    <h3 class="school-followup-report-section-title">ข้อมูลผู้รับบริการ</h3>

                    <div class="school-followup-report-info-grid">
                        <div class="school-followup-report-info-card">
                            <span class="school-followup-report-label">ชื่อ–นามสกุล</span>
                            <span class="school-followup-report-value">{{ $client->full_name ?? $client->fullname ?? '-' }}</span>
                        </div>

                        <div class="school-followup-report-info-card">
                            <span class="school-followup-report-label">อายุ</span>
                            <span class="school-followup-report-value">{{ $age ?? '-' }} ปี</span>
                        </div>

                        <div class="school-followup-report-info-card">
                            <span class="school-followup-report-label">ระดับการศึกษา</span>
                            <span class="school-followup-report-value">{{ $education_name ?? '-' }}</span>
                        </div>

                        <div class="school-followup-report-info-card">
                            <span class="school-followup-report-label">โรงเรียน</span>
                            <span class="school-followup-report-value">{{ $school_name ?? '-' }}</span>
                        </div>

                        <div class="school-followup-report-info-card">
                            <span class="school-followup-report-label">ภาคเรียน</span>
                            <span class="school-followup-report-value">{{ $term ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                <div class="school-followup-report-section">
                    <h3 class="school-followup-report-section-title">รายละเอียดการติดตาม</h3>

                    <div class="school-followup-report-detail-box">
                        <div class="school-followup-report-detail-row">
                            <div class="school-followup-report-detail-key">วันที่ติดตาม</div>
                            <div class="school-followup-report-detail-value">{{ $followup->follow_date ?? '-' }}</div>
                        </div>

                        <div class="school-followup-report-detail-row">
                            <div class="school-followup-report-detail-key">ครั้งที่</div>
                            <div class="school-followup-report-detail-value">{{ $followup->follo_no ?? '-' }}</div>
                        </div>

                        <div class="school-followup-report-detail-row">
                            <div class="school-followup-report-detail-key">ครูผู้สอน</div>
                            <div class="school-followup-report-detail-value">{{ $followup->teacher_name ?? '-' }}</div>
                        </div>

                        <div class="school-followup-report-detail-row">
                            <div class="school-followup-report-detail-key">เบอร์โทร</div>
                            <div class="school-followup-report-detail-value">{{ $followup->tel ?? '-' }}</div>
                        </div>

                        <div class="school-followup-report-detail-row">
                            <div class="school-followup-report-detail-key">ประเภทการติดตาม</div>
                            <div class="school-followup-report-detail-value">
                                @switch($followup->follow_type)
                                    @case('self') ติดตามด้วยตนเอง @break
                                    @case('phone') โทรศัพท์ @break
                                    @case('other') อื่นๆ @break
                                    @default - 
                                @endswitch
                            </div>
                        </div>

                        <div class="school-followup-report-detail-row">
                            <div class="school-followup-report-detail-key">ผลการติดตาม</div>
                            <div class="school-followup-report-detail-value">{{ $followup->result ?? '-' }}</div>
                        </div>

                        <div class="school-followup-report-detail-row">
                            <div class="school-followup-report-detail-key">ผู้ติดต่อ</div>
                            <div class="school-followup-report-detail-value">{{ $followup->contact_name ?? '-' }}</div>
                        </div>

                        <div class="school-followup-report-detail-row">
                            <div class="school-followup-report-detail-key">หมายเหตุ</div>
                            <div class="school-followup-report-detail-value">{{ $followup->remark ?? '-' }}</div>
                        </div>
                    </div>
                </div>

                <div class="school-followup-report-signature">
                    <div class="school-followup-report-signature-box">
                        <div class="school-followup-report-signature-line"></div>
                        <div>ผู้จัดทำรายงาน</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection