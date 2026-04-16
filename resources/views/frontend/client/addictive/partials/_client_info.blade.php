<style>
/* =========================
   Scoped CSS: addictive-client-toolbar
   ใช้เฉพาะบล็อกนี้ ไม่กระทบส่วนอื่น
========================= */
.addictive-client-toolbar-card{
    border-radius: 18px;
    background: #ffffff;
    border: 1px solid #e5e7eb;
    box-shadow: 0 10px 28px rgba(15, 23, 42, 0.06);
    overflow: hidden;
}

.addictive-client-toolbar-card .card-body{
    padding: 18px 18px 16px;
}

.addictive-client-toolbar-card .addictive-client-top{
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 16px;
    flex-wrap: wrap;
    margin-bottom: 14px;
}

.addictive-client-toolbar-card .addictive-client-top-left{
    min-width: 0;
    flex: 1 1 520px;
}

.addictive-client-toolbar-card .addictive-client-top-right{
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}

.addictive-client-toolbar-card .addictive-client-title{
    margin: 0 0 4px;
    font-size: 1.02rem;
    font-weight: 800;
    color: #0f172a;
    line-height: 1.4;
}

.addictive-client-toolbar-card .addictive-client-subtitle{
    margin: 0;
    font-size: 0.88rem;
    color: #64748b;
    line-height: 1.65;
}

.addictive-client-toolbar-card .addictive-client-info-grid{
    display: grid;
    grid-template-columns: minmax(0, 1.3fr) minmax(220px, 0.7fr);
    gap: 12px;
    margin-bottom: 14px;
}

.addictive-client-toolbar-card .addictive-client-info{
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
    min-width: 0;
}

.addictive-client-toolbar-card .addictive-client-info--right{
    justify-content: flex-end;
}

.addictive-client-toolbar-card .addictive-client-item{
    display: inline-flex;
    align-items: center;
    gap: 10px;
    min-width: 0;
    padding: 10px 12px;
    border-radius: 12px;
    background: linear-gradient(180deg, #fbfcfe 0%, #f8fafc 100%);
    border: 1px solid #e8eef5;
}

.addictive-client-toolbar-card .addictive-client-item i{
    width: 34px;
    height: 34px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    background: #eef4ff;
    color: #2563eb;
    font-size: 1rem;
    flex: 0 0 auto;
}

.addictive-client-toolbar-card .addictive-client-item--age i{
    background: #ecfdf5;
    color: #059669;
}

.addictive-client-toolbar-card .addictive-client-text{
    min-width: 0;
}

.addictive-client-toolbar-card .addictive-client-text .label{
    display: block;
    font-size: 0.78rem;
    font-weight: 700;
    color: #64748b;
    margin-bottom: 2px;
    line-height: 1.3;
}

.addictive-client-toolbar-card .addictive-client-text .value{
    display: block;
    font-size: 0.95rem;
    font-weight: 700;
    color: #0f172a;
    line-height: 1.45;
    word-break: break-word;
}

.addictive-client-toolbar-card .addictive-filter-panel{
    padding: 14px;
    border: 1px solid #e6edf5;
    border-radius: 14px;
    background: #f8fafc;
}

.addictive-client-toolbar-card .addictive-filter-head{
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 10px;
    flex-wrap: wrap;
    margin-bottom: 12px;
}

.addictive-client-toolbar-card .addictive-filter-title{
    margin: 0;
    font-size: 0.95rem;
    font-weight: 800;
    color: #0f172a;
    line-height: 1.4;
}

.addictive-client-toolbar-card .addictive-filter-desc{
    margin: 3px 0 0;
    font-size: 0.82rem;
    color: #64748b;
    line-height: 1.6;
}

.addictive-client-toolbar-card .addictive-filter-grid{
    display: grid;
    grid-template-columns: minmax(0, 1fr) minmax(0, 1fr) auto;
    gap: 12px;
    align-items: end;
}

.addictive-client-toolbar-card .addictive-filter-group{
    min-width: 0;
}

.addictive-client-toolbar-card .addictive-filter-group label{
    display: block;
    margin-bottom: 6px;
    font-size: 0.84rem;
    font-weight: 700;
    color: #334155;
}

.addictive-client-toolbar-card .addictive-filter-group .form-control{
    min-height: 44px;
    border-radius: 12px;
    border-color: #dbe3ec;
    box-shadow: none;
    font-size: 0.92rem;
}

.addictive-client-toolbar-card .addictive-filter-group .form-control:focus{
    border-color: #93c5fd;
    box-shadow: 0 0 0 0.18rem rgba(37, 99, 235, 0.10);
}

.addictive-client-toolbar-card .addictive-filter-actions{
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
    justify-content: flex-end;
}

.addictive-client-toolbar-card .addictive-btn{
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    min-height: 44px;
    padding: 0.68rem 1rem;
    border-radius: 12px;
    font-weight: 700;
    font-size: 0.92rem;
    white-space: nowrap;
    text-decoration: none;
}

.addictive-client-toolbar-card .addictive-btn i{
    font-size: 0.95rem;
    line-height: 1;
}

.addictive-client-toolbar-card .addictive-btn-report{
    background: #2563eb;
    border: 1px solid #2563eb;
    color: #ffffff;
}

.addictive-client-toolbar-card .addictive-btn-report:hover{
    background: #1d4ed8;
    border-color: #1d4ed8;
    color: #ffffff;
}

.addictive-client-toolbar-card .addictive-btn-search{
    background: #0f766e;
    border: 1px solid #0f766e;
    color: #ffffff;
}

.addictive-client-toolbar-card .addictive-btn-search:hover{
    background: #0b5f58;
    border-color: #0b5f58;
    color: #ffffff;
}

.addictive-client-toolbar-card .addictive-btn-reset{
    background: #ffffff;
    border: 1px solid #cfd8e3;
    color: #334155;
}

.addictive-client-toolbar-card .addictive-btn-reset:hover{
    background: #f8fafc;
    color: #0f172a;
}

.addictive-client-toolbar-card .addictive-inline-note{
    margin-top: 10px;
    font-size: 0.8rem;
    color: #64748b;
    line-height: 1.6;
}

@media (max-width: 991.98px){
    .addictive-client-toolbar-card .addictive-client-info-grid{
        grid-template-columns: 1fr;
    }

    .addictive-client-toolbar-card .addictive-client-info--right{
        justify-content: flex-start;
    }

    .addictive-client-toolbar-card .addictive-filter-grid{
        grid-template-columns: 1fr 1fr;
    }

    .addictive-client-toolbar-card .addictive-filter-actions{
        grid-column: 1 / -1;
        justify-content: flex-start;
    }
}

@media (max-width: 767.98px){
    .addictive-client-toolbar-card .card-body{
        padding: 14px;
    }

    .addictive-client-toolbar-card .addictive-client-top{
        margin-bottom: 12px;
    }

    .addictive-client-toolbar-card .addictive-client-top-right{
        width: 100%;
    }

    .addictive-client-toolbar-card .addictive-client-top-right .addictive-btn{
        width: 100%;
    }

    .addictive-client-toolbar-card .addictive-client-item{
        width: 100%;
        align-items: flex-start;
    }

    .addictive-client-toolbar-card .addictive-filter-grid{
        grid-template-columns: 1fr;
    }

    .addictive-client-toolbar-card .addictive-filter-actions{
        width: 100%;
    }

    .addictive-client-toolbar-card .addictive-filter-actions .addictive-btn{
        width: 100%;
    }
}
</style>

@if($addictives->isNotEmpty())

<div class="card border-0 addictive-client-toolbar-card mb-3">
    <div class="card-body">

        <div class="addictive-client-top">
            <div class="addictive-client-top-left">
                <h5 class="addictive-client-title">ข้อมูลผู้รับบริการและเครื่องมือรายงาน</h5>
                <p class="addictive-client-subtitle">
                    ตรวจสอบข้อมูลผู้รับบริการ ค้นหารายงานตามช่วงวันที่ และเปิดรายงานทั้งหมดได้จากส่วนเดียว
                </p>
            </div>

           
        </div>

       <div class="addictive-client-info-grid">

    <div class="addictive-client-info">
        <div class="addictive-client-item">
            <i class="bi bi-person-fill"></i>
            <div class="addictive-client-text">
                <span class="label">ชื่อ-สกุล:</span>
                <span class="value">{{ $client->fullname ?? '-' }}</span>
            </div>
        </div>

        <div class="addictive-client-item addictive-client-item--age">
            <i class="bi bi-calendar-heart"></i>
            <div class="addictive-client-text">
                <span class="label">อายุ:</span>
                <span class="value">{{ $client->age ?? '-' }} ปี</span>
            </div>
        </div>
    </div>

</div>

        <form method="GET" action="{{ route('addictive.report.all', $client->id) }}" class="addictive-filter-panel">
            <div class="addictive-filter-head">
                <div>
                    <h6 class="addictive-filter-title">ตัวกรองรายงานตามช่วงวันที่</h6>
                    
                </div>
            </div>

            <div class="addictive-filter-grid">
                <div class="addictive-filter-group">
                    <label for="addictive_date_from">วันที่เริ่มต้น</label>
                    <input
                        type="date"
                        name="date_from"
                        id="addictive_date_from"
                        class="form-control"
                        value="{{ request('date_from') }}"
                    >
                </div>

                <div class="addictive-filter-group">
                    <label for="addictive_date_to">วันที่สิ้นสุด</label>
                    <input
                        type="date"
                        name="date_to"
                        id="addictive_date_to"
                        class="form-control"
                        value="{{ request('date_to') }}"
                    >
                </div>

            <div class="addictive-filter-actions">

            {{-- รายงานทั้งหมด --}}
            <a href="{{ route('addictive.report.all', $client->id) }}"
            class="addictive-btn addictive-btn-report">
                <i class="bi bi-file-earmark-text"></i>
                <span>รายงานทั้งหมด</span>
            </a>

            {{-- ค้นหา --}}
            <button type="submit" class="addictive-btn addictive-btn-search">
                <i class="bi bi-search"></i>
                <span>ค้นหารายงาน</span>
            </button>

        <button type="reset"
                class="addictive-btn addictive-btn-reset"
                onclick="
                    setTimeout(() => {
                        const from = document.getElementById('addictive_date_from');
                        if(from){
                            from.focus();
                        }
                    }, 50);
                ">
            <i class="bi bi-arrow-counterclockwise"></i>
            <span>ล้างค่า</span>
        </button>

        </div>
                    </div>

                    <div class="addictive-inline-note">
                        ระบบจะเปิดหน้ารายงานทั้งหมดพร้อมเงื่อนไขช่วงวันที่ที่เลือกไว้ทันที
                    </div>
                </form>

            </div>
        </div>

        @endif