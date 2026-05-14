@php
    use Carbon\Carbon;

    $fullName = trim(($client->first_name ?? '') . ' ' . ($client->last_name ?? ''));
    $fullName = $fullName ?: '-';

    $birthDate = !empty($client->birth_date) ? Carbon::parse($client->birth_date) : null;
    $age = $birthDate ? $birthDate->age : '-';

    $thaiDate = function ($date) {
        if (!$date) return '-';

        $months = [
            1 => 'มกราคม', 2 => 'กุมภาพันธ์', 3 => 'มีนาคม', 4 => 'เมษายน',
            5 => 'พฤษภาคม', 6 => 'มิถุนายน', 7 => 'กรกฎาคม', 8 => 'สิงหาคม',
            9 => 'กันยายน', 10 => 'ตุลาคม', 11 => 'พฤศจิกายน', 12 => 'ธันวาคม'
        ];

        $d = Carbon::parse($date);
        return $d->day . ' ' . $months[$d->month] . ' ' . ($d->year + 543);
    };
@endphp

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>รายงานการเยี่ยมบ้าน</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
body{
    font-family:"TH Sarabun New","Sarabun",sans-serif;
    font-size:14px;
    line-height:1.55;
    color:#0f172a;
    background:#eef3f8;
    margin:0;
    padding:22px 12px;
}

.visit-report-page{
    max-width:1020px;
    margin:0 auto;
}

.visit-report-paper{
    background:#ffffff;
    border:1px solid #dde6ef;
    border-radius:18px;
    box-shadow:0 12px 36px rgba(15,23,42,.06);
    overflow:hidden;
}

.visit-report-toolbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:10px;
    padding:12px 18px;
    border-bottom:1px solid #e6edf5;
    background:#f8fbff;
    flex-wrap:wrap;
}

.visit-report-toolbar-group{
    display:flex;
    gap:8px;
}

.visit-report-btn{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:6px;
    height:36px;
    padding:0 14px;
    border-radius:10px;
    border:1px solid #d1d9e6;
    background:#ffffff;
    color:#0f172a;
    font-size:14px;
    font-weight:600;
    text-decoration:none;
    transition:.2s ease;
    cursor:pointer;
}

.visit-report-btn:hover{
    background:#f1f5f9;
}

.visit-report-btn-primary{
    background:#2563eb;
    border-color:#2563eb;
    color:#ffffff;
}

.visit-report-btn-primary:hover{
    background:#1d4ed8;
}

.visit-report-content{
    padding:28px 32px 32px;
}

.visit-report-head{
    text-align:center;
    margin-bottom:18px;
    padding-bottom:14px;
    border-bottom:1px solid #e2e8f0;
}

.visit-report-head-title{
    font-size:16px;
    font-weight:800;
    margin:4px 0;
}

.visit-report-meta{
    display:grid;
    grid-template-columns:repeat(3, 1fr);
    gap:8px 18px;
    margin-bottom:16px;
    padding-bottom:12px;
    border-bottom:1px solid #e2e8f0;
}

.visit-report-meta-item{
    display:grid;
    grid-template-columns:85px 1fr;
    column-gap:8px;
    align-items:start;
}

.visit-report-meta-label{
    font-weight:700;
    color:#475569;
    white-space:nowrap;
}

.visit-report-meta-value{
    color:#0f172a;
    min-width:0;
}

.visit-report-section{
    margin-bottom:16px;
}

.visit-report-section-title{
    font-size:16px;
    font-weight:800;
    margin-bottom:8px;
    padding-bottom:4px;
    border-bottom:1px solid #e5edf5;
}

.visit-report-lines{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:7px 28px;
}

.visit-report-line{
    display:grid;
    grid-template-columns:170px 1fr;
    column-gap:10px;
    align-items:start;
}

.visit-report-line.full{
    grid-column:1 / -1;
}

.visit-report-label{
    font-weight:700;
    color:#475569;
    white-space:nowrap;
}

..visit-report-value{
    display:flex;
    align-items:center;   /* 🔥 ตัวนี้คือจุดสำคัญ */
    min-height:22px;
}

.visit-report-inline-badge{
    display:inline-flex;
    align-items:center;
    height:24px;
    padding:0 10px;
    border-radius:999px;
    background:#eef4ff;
    color:#1d4ed8;
    font-size:13px;
    font-weight:700;
    line-height:1;
}

.visit-report-empty{
    color:#64748b;
    font-size:14px;
    padding:6px 0;
}

.visit-report-pictures{
    display:grid;
    grid-template-columns:repeat(auto-fit, minmax(220px, 280px));
    gap:12px;
    justify-content:start;
    align-items:start;
}

.visit-report-picture-item{
    width:100%;
    max-width:280px;
}

.visit-report-picture-frame{
    width:100%;
}

.visit-report-picture-frame img{
    width:100%;
    height:180px;
    object-fit:cover;
    object-position:center;
    border-radius:10px;
    border:1px solid #dbe3ec;
    display:block;
}

.visit-report-picture-caption{
    font-size:13px;
    color:#334155;
    margin-top:6px;
}

.visit-report-pictures:has(.visit-report-picture-item:only-child){
    grid-template-columns:280px;
}

@media (max-width:768px){
    body{
        padding:12px 8px;
    }

    .visit-report-content{
        padding:18px 14px;
    }

    .visit-report-meta{
        grid-template-columns:1fr;
    }

    .visit-report-meta-item{
        grid-template-columns:150px 1fr;
    }

    .visit-report-lines{
        grid-template-columns:1fr;
        gap:8px;
    }

    .visit-report-line{
        grid-template-columns:150px 1fr;
    }

    .visit-report-toolbar-group{
        width:100%;
    }

    .visit-report-btn{
        width:100%;
    }

    .visit-report-pictures{
        grid-template-columns:1fr;
    }

    .visit-report-picture-item{
        max-width:100%;
    }

    .visit-report-picture-frame img{
        height:220px;
    }
}

@media (max-width:480px){
    .visit-report-meta-item,
    .visit-report-line{
        grid-template-columns:1fr;
        row-gap:2px;
    }

    .visit-report-meta-label,
    .visit-report-label{
        white-space:normal;
    }
}

@media print{
    body{
        background:#fff;
        padding:0;
    }

    .visit-report-toolbar{
        display:none;
    }

    .visit-report-paper{
        border:none;
        box-shadow:none;
        border-radius:0;
    }

    .visit-report-content{
        padding:0;
    }

    .visit-report-pictures{
        grid-template-columns:repeat(2, 1fr);
        gap:10px;
    }

    .visit-report-picture-item{
        max-width:100%;
    }

    .visit-report-picture-frame img{
        height:180px;
        border-radius:6px;
    }
}
    </style>
</head>

<body>
            <div class="visit-report-page">
                <div class="visit-report-paper">

                    <div class="visit-report-toolbar">
                    <button type="button"
                class="visit-report-btn"
                onclick="window.close(); window.history.back();">
                ← ปิดหน้าหรือกลับ
            </button>

            <div class="visit-report-toolbar-group">
                <button type="button" class="visit-report-btn visit-report-btn-primary" onclick="window.print()">
                    พิมพ์รายงาน
                </button>
            </div>
        </div>

        <div class="visit-report-content">

            <div class="visit-report-head">
                <h3 class="visit-report-head-title">รายงานการเยี่ยมบ้าน</h3>
            </div>

            <div class="visit-report-meta">
                <div class="visit-report-meta-item">
                    <span class="visit-report-meta-label">ชื่อ-สกุล:</span>
                    <span class="visit-report-meta-value">{{ $fullName }}</span>
                </div>

                <div class="visit-report-meta-item">
                    <span class="visit-report-meta-label">อายุ:</span>
                    <span class="visit-report-meta-value">{{ $age }} ปี</span>
                </div>

                <div class="visit-report-meta-item">
                    <span class="visit-report-meta-label">วันที่เยี่ยม:</span>
                    <span class="visit-report-meta-value">{{ $thaiDate($visitFamily->visit_date ?? null) }}</span>
                </div>
            </div>

            <div class="visit-report-section">
                <h2 class="visit-report-section-title">ข้อมูลทั่วไป</h2>

                <div class="visit-report-lines">
                    <div class="visit-report-line">
                        <div class="visit-report-label">ผู้ให้ข้อมูล</div>
                        <div class="visit-report-value">{{ $visitFamily->family_fname ?: '-' }}</div>
                    </div>

                    <div class="visit-report-line">
                        <div class="visit-report-label">อายุผู้ให้ข้อมูล</div>
                        <div class="visit-report-value">{{ $visitFamily->family_age ?: '-' }} ปี</div>
                    </div>

                    <div class="visit-report-line">
                        <div class="visit-report-label">ความสัมพันธ์กับผู้รับ</div>
                        <div class="visit-report-value">{{ $visitFamily->member ?: '-' }}</div>
                    </div>

                    <div class="visit-report-line">
                        <div class="visit-report-label">รายได้เฉลี่ยครอบครัว</div>
                        <div class="visit-report-value">{{ $visitFamily->income->income_name ?? '-' }}</div>
                    </div>

                    <div class="visit-report-line">
                        <div class="visit-report-label">สถานะการอยู่อาศัย</div>
                        <div class="visit-report-value">
                            @if($visitFamily->residence_status)
                                <span class="visit-report-inline-badge">{{ $visitFamily->residence_status }}</span>
                            @else
                                -
                            @endif
                        </div>
                    </div>

                    <div class="visit-report-line">
                        <div class="visit-report-label">โทรศัพท์</div>
                        <div class="visit-report-value">{{ $visitFamily->phone ?: '-' }}</div>
                    </div>
                </div>
            </div>

            <div class="visit-report-section">
                <h2 class="visit-report-section-title">ข้อมูลที่อยู่</h2>

                <div class="visit-report-lines">
                    <div class="visit-report-line">
                        <div class="visit-report-label">เลขที่</div>
                        <div class="visit-report-value">{{ $visitFamily->address ?: '-' }}</div>
                    </div>

                    <div class="visit-report-line">
                        <div class="visit-report-label">หมู่ที่</div>
                        <div class="visit-report-value">{{ $visitFamily->moo ?: '-' }}</div>
                    </div>

                    <div class="visit-report-line">
                        <div class="visit-report-label">ซอย</div>
                        <div class="visit-report-value">{{ $visitFamily->soi ?: '-' }}</div>
                    </div>

                    <div class="visit-report-line">
                        <div class="visit-report-label">ถนน</div>
                        <div class="visit-report-value">{{ $visitFamily->road ?: '-' }}</div>
                    </div>

                    <div class="visit-report-line">
                        <div class="visit-report-label">หมู่บ้าน</div>
                        <div class="visit-report-value">{{ $visitFamily->village ?: '-' }}</div>
                    </div>

                    <div class="visit-report-line">
                        <div class="visit-report-label">รหัสไปรษณีย์</div>
                        <div class="visit-report-value">{{ $visitFamily->zipcode ?: '-' }}</div>
                    </div>
                </div>
            </div>

            <div class="visit-report-section">
                <h2 class="visit-report-section-title">สภาพบ้านและสภาพแวดล้อม</h2>

                <div class="visit-report-lines">
                    <div class="visit-report-line full">
                        <div class="visit-report-label">สภาพที่อยู่ภายนอก</div>
                        <div class="visit-report-value">{{ $visitFamily->outside_address ?: '-' }}</div>
                    </div>

                    <div class="visit-report-line full">
                        <div class="visit-report-label">สภาพที่อยู่ภายใน</div>
                        <div class="visit-report-value">{{ $visitFamily->inside_address ?: '-' }}</div>
                    </div>

                    <div class="visit-report-line full">
                        <div class="visit-report-label">สภาพแวดล้อม</div>
                        <div class="visit-report-value">{{ $visitFamily->environment ?: '-' }}</div>
                    </div>

                    <div class="visit-report-line full">
                        <div class="visit-report-label">เพื่อนบ้าน</div>
                        <div class="visit-report-value">{{ $visitFamily->neighbor ?: '-' }}</div>
                    </div>

                    <div class="visit-report-line full">
                        <div class="visit-report-label">ความสัมพันธ์ในบ้าน</div>
                        <div class="visit-report-value">{{ $visitFamily->member_relation ?: '-' }}</div>
                    </div>
                </div>
            </div>

            <div class="visit-report-section">
                <h2 class="visit-report-section-title">การประเมินและการช่วยเหลือ</h2>

                <div class="visit-report-lines">
                    <div class="visit-report-line full">
                        <div class="visit-report-label">ปัญหาที่พบ</div>
                        <div class="visit-report-value">{{ $visitFamily->problem ?: '-' }}</div>
                    </div>

                    <div class="visit-report-line full">
                        <div class="visit-report-label">ความต้องการ</div>
                        <div class="visit-report-value">{{ $visitFamily->need ?: '-' }}</div>
                    </div>

                    <div class="visit-report-line full">
                        <div class="visit-report-label">การวินิจฉัยปัญหา</div>
                        <div class="visit-report-value">{{ $visitFamily->diagnose ?: '-' }}</div>
                    </div>

                    <div class="visit-report-line full">
                        <div class="visit-report-label">การให้ความช่วยเหลือ</div>
                        <div class="visit-report-value">{{ $visitFamily->assistance ?: '-' }}</div>
                    </div>

                    <div class="visit-report-line full">
                        <div class="visit-report-label">ข้อคิดเห็น</div>
                        <div class="visit-report-value">{{ $visitFamily->comment ?: '-' }}</div>
                    </div>

                    <div class="visit-report-line full">
                        <div class="visit-report-label">สิ่งที่ควรแก้ไข</div>
                        <div class="visit-report-value">{{ $visitFamily->modify ?: '-' }}</div>
                    </div>

                    <div class="visit-report-line full">
                        <div class="visit-report-label">หมายเหตุ</div>
                        <div class="visit-report-value">{{ $visitFamily->remark ?: '-' }}</div>
                    </div>
                </div>
            </div>

            <div class="visit-report-section">
                <h2 class="visit-report-section-title">ผู้ติดตามเยี่ยมบ้าน</h2>

                <div class="visit-report-lines">
                    <div class="visit-report-line">
                        <div class="visit-report-label">ผู้ติดตาม / ผู้บันทึก</div>
                        <div class="visit-report-value">{{ $visitFamily->teacher ?: '-' }}</div>
                    </div>
                </div>
            </div>

          <div class="visit-report-section">
                <h2 class="visit-report-section-title">ภาพประกอบการเยี่ยมบ้าน</h2>

                @if($visitFamily->images && $visitFamily->images->count() > 0)
                    <div class="visit-report-pictures">
                        @foreach($visitFamily->images as $index => $img)
                            @php
                                $path = $img->file_path;

                                if (str_starts_with($path, 'upload/')) {
                                    $imageUrl = asset($path);
                                } elseif (str_starts_with($path, 'storage/')) {
                                    $imageUrl = asset($path);
                                } else {
                                    $imageUrl = asset('storage/' . $path);
                                }
                            @endphp

                            <div class="visit-report-picture-item">
                                <div class="visit-report-picture-frame">
                                    <img src="{{ $imageUrl }}"
                                        alt="รูปภาพประกอบ {{ $index + 1 }}">

                                    <div class="visit-report-picture-caption">
                                        รูปภาพประกอบ {{ $index + 1 }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="visit-report-empty">ไม่มีรูปภาพประกอบ</div>
                @endif
            </div>

        </div>
    </div>
</div>
</body>
</html>