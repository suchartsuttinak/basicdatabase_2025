<style>
.rf-main-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:16px;
    flex-wrap:wrap;
    margin-bottom:16px;
    padding:18px 20px;
    border:1px solid #e7edf5;
    border-radius:20px;
    background:linear-gradient(135deg,#ffffff 0%,#f8fbff 100%);
    box-shadow:0 10px 30px rgba(15,23,42,.06);
}

.rf-header-title{
    display:flex;
    align-items:center;
    gap:14px;
    flex:1 1 420px;
    min-width:260px;
}

.rf-header-icon{
    width:52px;
    height:52px;
    border-radius:16px;
    background:#eef2ff;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:24px;
    color:#4f46e5;
    flex-shrink:0;
    box-shadow:0 8px 20px rgba(79,70,229,.14);
}

.rf-header-text h6{
    margin:0;
    font-size:18px;
    font-weight:800;
    color:#0f172a;
}

.rf-header-text p{
    margin:4px 0 0;
    font-size:13px;
    color:#64748b;
    line-height:1.6;
}

.rf-header-actions{
    display:flex;
    align-items:center;
    gap:10px;
    flex-wrap:wrap;
}

.rf-btn{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    min-height:44px;
    padding:10px 16px;
    border-radius:14px;
    font-size:14px;
    font-weight:700;
    line-height:1;
    border:1px solid transparent;
    cursor:pointer;
    text-decoration:none;
    transition:all .18s ease;
    white-space:nowrap;
}

.rf-btn i{
    font-size:16px;
}

.rf-btn-primary{
    background:linear-gradient(135deg,#2563eb,#4f46e5);
    color:#fff;
    border-color:transparent;
    box-shadow:0 10px 22px rgba(37,99,235,.22);
}

.rf-btn-primary:hover{
    color:#fff;
    transform:translateY(-1px);
    box-shadow:0 14px 28px rgba(37,99,235,.30);
}

.rf-btn-report{
    background:#ffffff;
    color:#0f766e;
    border-color:#99f6e4;
    box-shadow:0 8px 18px rgba(15,118,110,.10);
}

.rf-btn-report:hover{
    background:#ecfdf5;
    color:#0f766e;
    border-color:#5eead4;
    transform:translateY(-1px);
    box-shadow:0 12px 24px rgba(15,118,110,.16);
}

.rf-btn:active{
    transform:scale(.98);
}

@media (max-width:576px){
    .rf-main-header{
        padding:14px;
        align-items:flex-start;
    }

    .rf-header-title{
        align-items:flex-start;
    }

    .rf-header-icon{
        width:46px;
        height:46px;
        border-radius:14px;
        font-size:21px;
    }

    .rf-header-text h6{
        font-size:16px;
    }

    .rf-header-actions{
        width:100%;
    }

    .rf-btn{
        width:100%;
        min-height:42px;
    }
}
</style>

@php
    $hasReferRows = false;

    if (isset($refers)) {
        $hasReferRows = $refers->count() > 0;
    } elseif (isset($refer)) {
        $hasReferRows = collect($refer)->count() > 0;
    } elseif (isset($items)) {
        $hasReferRows = $items->count() > 0;
    }
@endphp

<div class="rf-main-header">
    <div class="rf-header-title">
        <span class="rf-header-icon">
            <i class="bi bi-box-arrow-right"></i>
        </span>

        <div class="rf-header-text">
            <h6>ตารางการจำหน่ายผู้รับออกจากสถานสงเคราะห์</h6>
            <p>จัดการข้อมูลการจำหน่ายผู้รับบริการ พร้อมออกรายงานเมื่อมีข้อมูลจริง</p>
        </div>
    </div>

     @if($hasReferRows)
    <div class="rf-header-actions">
       
            <a href="{{ route('refers.report', $client->id) }}"
               class="rf-btn rf-btn-report">
                <i class="bi bi-file-earmark-bar-graph"></i>
                <span>รายงาน</span>
            </a>
       
        <button type="button"
                class="rf-btn rf-btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#createReferModal">
            <i class="bi bi-plus-circle"></i>
            <span>เพิ่มข้อมูลจำหน่าย</span>
        </button>
    </div>
     @endif
</div>