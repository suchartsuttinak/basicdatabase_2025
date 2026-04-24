
<style>
    /* ===== Header Layout ===== */
.rf-main-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:14px;
    flex-wrap:wrap;
    margin-bottom:14px;
}

/* ===== Title ===== */
.rf-header-title{
    display:flex;
    align-items:center;
    gap:12px;
    flex:1;
    min-width:260px;
}

.rf-header-icon{
    width:42px;
    height:42px;
    border-radius:12px;
    background:#eef2ff;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:18px;
    color:#4f46e5;
    flex-shrink:0;
}

.rf-header-text h6{
    margin:0;
    font-size:16px;
    font-weight:700;
    color:#0f172a;
}

.rf-header-text p{
    margin:2px 0 0;
    font-size:13px;
    color:#64748b;
}

/* ===== Actions (ปุ่มด้านขวา) ===== */
.rf-header-actions{
    display:flex;
    align-items:center;
    gap:10px;
    flex-wrap:wrap;
}

/* ===== Base Button ===== */
.rf-btn{
    display:inline-flex;
    align-items:center;
    gap:8px;
    padding:9px 14px;
    border-radius:10px;
    font-size:14px;
    font-weight:600;
    line-height:1;
    border:1px solid transparent;
    cursor:pointer;
    text-decoration:none;
    transition:all .2s ease;
    white-space:nowrap;
}

.rf-btn i{
    font-size:15px;
}

/* ===== Primary ===== */
.rf-btn-primary{
    background:#2563eb;
    color:#fff;
    border-color:#2563eb;
}

.rf-btn-primary:hover{
    background:#1d4ed8;
    border-color:#1d4ed8;
}

/* ===== Outline (ปุ่มรายงาน) ===== */
.rf-btn-outline{
    background:#ffffff;
    color:#1f2937;
    border-color:#d1d9e6;
}

.rf-btn-outline:hover{
    background:#f8fafc;
    border-color:#b8c4d3;
    color:#0f172a;
}
/* ===== ปุ่มรายงาน (ใหม่ สวยขึ้น) ===== */
.rf-btn-report{
    display:inline-flex;
    align-items:center;
    gap:8px;
    padding:9px 14px;
    border-radius:10px;
    font-size:14px;
    font-weight:600;
    line-height:1;
    cursor:pointer;
    text-decoration:none;
    white-space:nowrap;

    /* จุดเด่น */
    background:linear-gradient(135deg, #06b6d4, #3b82f6);
    color:#ffffff;
    border:none;

    box-shadow:0 6px 14px rgba(59,130,246,0.25);
    transition:all .2s ease;
}

.rf-btn-report i{
    font-size:15px;
}

/* hover */
.rf-btn-report:hover{
    transform:translateY(-1px);
    box-shadow:0 10px 22px rgba(59,130,246,0.35);
    color:#ffffff;
}

/* active */
.rf-btn-report:active{
    transform:scale(0.97);
    box-shadow:0 4px 10px rgba(59,130,246,0.25);
}

/* ===== Mobile ===== */
@media (max-width: 576px){
    .rf-main-header{
        align-items:flex-start;
    }

    .rf-header-actions{
        width:100%;
        justify-content:flex-end;
    }

    .rf-btn{
        font-size:13px;
        padding:8px 12px;
    }
}
</style>




<div class="rf-main-header">
    <div class="rf-header-title">
        <span class="rf-header-icon">
            <i class="bi bi-box-arrow-right"></i>
        </span>
        <div class="rf-header-text">
            <h6>ตารางการจำหน่ายผู้รับออกจากสถานสงเคราะห์</h6>
            <p>ออกแบบใหม่ให้ทันสมัย ใช้งานง่าย และรองรับทุกขนาดหน้าจอ</p>
        </div>
    </div>

    <div class="rf-header-actions">
        {{-- ปุ่มรายงาน --}}
       <a href="{{ route('refers.report', $client->id) }}"
   class="rf-btn rf-btn-report">
    <i class="bi bi-file-earmark-bar-graph"></i>
    <span>รายงาน</span>
</a>

        {{-- ปุ่มเพิ่ม --}}
        <button type="button"
                class="rf-btn rf-btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#createReferModal">
            <i class="bi bi-plus-circle"></i>
            <span>เพิ่มข้อมูลจำหน่าย</span>
        </button>
    </div>
</div>