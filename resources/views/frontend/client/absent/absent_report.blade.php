@extends('admin_client.admin_client')

@section('content')
<style>
    .absent-report-page{
        padding: 16px 12px 28px;
    }

    .absent-report-shell{
        max-width: 980px;
        margin: 0 auto;
    }

    .absent-report-card{
        position: relative;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
        overflow: hidden;
    }

    .absent-report-toolbar{
        display: flex;
        justify-content: flex-end;
        align-items: center;
        padding: 18px 20px 0;
    }

    .absent-report-back-btn{
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border-radius: 12px;
        padding: 10px 16px;
        font-weight: 600;
        box-shadow: none !important;
    }

    .absent-report-body{
        padding: 12px 22px 26px;
    }

    .absent-report-header{
        text-align: center;
        padding-bottom: 18px;
        margin-bottom: 20px;
        border-bottom: 1px solid #e5e7eb;
    }

    .absent-report-title{
        margin: 0;
        font-size: 1.55rem;
        font-weight: 700;
        color: #111827;
        line-height: 1.3;
    }

    .absent-report-subtitle{
        margin: 8px 0 0;
        color: #6b7280;
        font-size: .96rem;
    }

    .absent-report-section{
        margin-bottom: 18px;
    }

    .absent-report-section-title{
        margin: 0 0 12px;
        font-size: 1.02rem;
        font-weight: 700;
        color: #1f2937;
    }

    .absent-report-info-grid{
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
    }

    .absent-report-info-card{
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        padding: 12px 14px;
        min-height: 74px;
    }

    .absent-report-label{
        display: block;
        font-size: .88rem;
        font-weight: 600;
        color: #64748b;
        margin-bottom: 4px;
        line-height: 1.35;
    }

    .absent-report-value{
        display: block;
        font-size: 1rem;
        font-weight: 600;
        color: #111827;
        line-height: 1.5;
        word-break: break-word;
    }

    .absent-report-detail-box{
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        overflow: hidden;
    }

    .absent-report-detail-row{
        display: grid;
        grid-template-columns: 220px minmax(0, 1fr);
        border-bottom: 1px solid #eef2f7;
    }

    .absent-report-detail-row:last-child{
        border-bottom: 0;
    }

    .absent-report-detail-key{
        background: #f8fafc;
        padding: 12px 14px;
        font-weight: 700;
        color: #334155;
        line-height: 1.5;
    }

    .absent-report-detail-value{
        padding: 12px 14px;
        color: #111827;
        line-height: 1.6;
        word-break: break-word;
        white-space: pre-line;
    }

    .absent-report-signature{
        margin-top: 28px;
        display: flex;
        justify-content: flex-end;
    }

    .absent-report-signature-box{
        width: 280px;
        text-align: center;
        color: #374151;
    }

    .absent-report-signature-line{
        margin-bottom: 8px;
        padding-top: 24px;
        border-bottom: 1px solid #111827;
        height: 36px;
    }

    @media (max-width: 767.98px){
        .absent-report-page{
            padding: 12px 0 20px;
        }

        .absent-report-card{
            border-radius: 0;
            border-left: 0;
            border-right: 0;
        }

        .absent-report-toolbar{
            padding: 14px 14px 0;
        }

        .absent-report-body{
            padding: 10px 14px 18px;
        }

        .absent-report-title{
            font-size: 1.3rem;
        }

        .absent-report-info-grid{
            grid-template-columns: 1fr;
        }

        .absent-report-detail-row{
            grid-template-columns: 1fr;
        }

        .absent-report-detail-key{
            padding-bottom: 6px;
        }

        .absent-report-detail-value{
            padding-top: 0;
        }

        .absent-report-signature{
            justify-content: center;
        }

        .absent-report-signature-box{
            width: 100%;
            max-width: 260px;
        }
    }

    @media print{
        .absent-report-page{
            padding: 0;
        }

        .absent-report-card{
            box-shadow: none;
            border: 0;
            border-radius: 0;
        }

        .absent-report-toolbar{
            display: none !important;
        }

        .absent-report-body{
            padding: 0;
        }
    }
</style>

<div class="absent-report-page">
    <div class="absent-report-shell">
        <div class="absent-report-card">
            <div class="absent-report-toolbar">
                <a href="{{ route('absent.add', $client->id) }}" class="btn btn-primary absent-report-back-btn">
                    <i class="bi bi-arrow-left-circle"></i>
                    <span>กลับหน้าหลัก</span>
                </a>
            </div>

            <div class="absent-report-body">
                <div class="absent-report-header">
                    <h2 class="absent-report-title">รายงานการติดตามเด็กในโรงเรียน</h2>
                  
                </div>

                <div class="absent-report-section">
                    <h3 class="absent-report-section-title">ข้อมูลผู้รับบริการ</h3>

                    <div class="absent-report-info-grid">
                        <div class="absent-report-info-card">
                            <span class="absent-report-label">ชื่อ–นามสกุล</span>
                            <span class="absent-report-value">{{ $client->full_name ?? $client->fullname ?? '-' }}</span>
                        </div>

                        <div class="absent-report-info-card">
                            <span class="absent-report-label">อายุ</span>
                            <span class="absent-report-value">{{ $age ?? '-' }} ปี</span>
                        </div>

                        <div class="absent-report-info-card">
                            <span class="absent-report-label">ระดับการศึกษา</span>
                            <span class="absent-report-value">{{ $education_name ?? '-' }}</span>
                        </div>

                        <div class="absent-report-info-card">
                            <span class="absent-report-label">โรงเรียน</span>
                            <span class="absent-report-value">{{ $school_name ?? '-' }}</span>
                        </div>

                        <div class="absent-report-info-card">
                            <span class="absent-report-label">ภาคเรียน</span>
                            <span class="absent-report-value">{{ $term ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                <div class="absent-report-section">
                    <h3 class="absent-report-section-title">รายละเอียดการติดตาม</h3>

                    <div class="absent-report-detail-box">
                        <div class="absent-report-detail-row">
                            <div class="absent-report-detail-key">วันที่ขาดเรียน</div>
                            <div class="absent-report-detail-value">{{ $absent->absent_date ?? '-' }}</div>
                        </div>

                        <div class="absent-report-detail-row">
                            <div class="absent-report-detail-key">สาเหตุที่ขาดเรียน</div>
                            <div class="absent-report-detail-value">{{ $absent->cause ?? '-' }}</div>
                        </div>

                        <div class="absent-report-detail-row">
                            <div class="absent-report-detail-key">การดำเนินงาน</div>
                            <div class="absent-report-detail-value">{{ $absent->operation ?? '-' }}</div>
                        </div>

                        <div class="absent-report-detail-row">
                            <div class="absent-report-detail-key">หมายเหตุ</div>
                            <div class="absent-report-detail-value">{{ $absent->remark ?? '-' }}</div>
                        </div>

                        <div class="absent-report-detail-row">
                            <div class="absent-report-detail-key">วันที่บันทึก</div>
                            <div class="absent-report-detail-value">{{ $absent->record_date ?? '-' }}</div>
                        </div>

                        <div class="absent-report-detail-row">
                            <div class="absent-report-detail-key">ชื่อผู้ดูแลเด็ก</div>
                            <div class="absent-report-detail-value">{{ $absent->teacher ?? '-' }}</div>
                        </div>
                    </div>
                </div>

                <div class="absent-report-signature">
                    <div class="absent-report-signature-box">
                        <div class="absent-report-signature-line"></div>
                        <div>ผู้จัดทำรายงาน</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection