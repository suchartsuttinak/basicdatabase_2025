
@if(isset($absents) && $absents->count() > 0)
<style>
    .absent-filter-card{
        border-radius: 18px;
        overflow: hidden;
        background: #ffffff;
        border: 1px solid #eef2f7;
    }

    .absent-filter-card .card-body{
        padding: 1rem 1rem 1.05rem;
    }

    .absent-filter-label{
        display: inline-block;
        font-size: .92rem;
        font-weight: 600;
        color: #334155;
        margin-bottom: .45rem;
        line-height: 1.35;
    }

    .absent-filter-control{
        min-height: 46px;
        height: 46px;
        border-radius: 12px;
        border: 1px solid #d7deea;
        background: #ffffff;
        font-size: .95rem;
        color: #0f172a;
        box-shadow: none;
        transition: border-color .2s ease, box-shadow .2s ease, background-color .2s ease;
    }

    .absent-filter-control:focus{
        border-color: #86b7fe;
        box-shadow: 0 0 0 .18rem rgba(13, 110, 253, .10);
        background: #fff;
    }

    .absent-filter-control::-webkit-calendar-picker-indicator{
        cursor: pointer;
    }

    .absent-filter-actions-wrap{
        display: flex;
        align-items: flex-end;
        height: 100%;
    }

    .absent-filter-actions{
        display: flex;
        flex-wrap: wrap;
        gap: .6rem;
        justify-content: flex-start;
        align-items: center;
        width: 100%;
    }

    .absent-filter-btn{
        min-height: 46px;
        height: 46px;
        border-radius: 12px;
        padding: 0 1rem;
        font-size: .92rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: .42rem;
        white-space: nowrap;
        transition: all .2s ease;
        box-shadow: none;
    }

    .absent-filter-btn i{
        font-size: .95rem;
        line-height: 1;
    }

    .absent-filter-btn.btn-primary{
        background: #2563eb;
        border-color: #2563eb;
    }

    .absent-filter-btn.btn-primary:hover{
        background: #1d4ed8;
        border-color: #1d4ed8;
    }

    .absent-filter-btn.btn-outline-primary:hover,
    .absent-filter-btn.btn-outline-secondary:hover{
        transform: translateY(-1px);
    }

    @media (min-width: 1200px){
        .absent-filter-card .card-body{
            padding: 1.1rem 1.2rem 1.15rem;
        }

        .absent-filter-actions{
            justify-content: flex-end;
        }
    }

    @media (max-width: 991.98px){
        .absent-filter-actions-wrap{
            align-items: stretch;
        }

        .absent-filter-actions{
            justify-content: flex-start;
        }
    }

    @media (max-width: 767.98px){
        .absent-filter-card{
            border-radius: 16px;
        }

        .absent-filter-card .card-body{
            padding: .95rem;
        }

        .absent-filter-label{
            font-size: .9rem;
        }

        .absent-filter-control{
            min-height: 44px;
            height: 44px;
            font-size: .94rem;
        }

        .absent-filter-btn{
            min-height: 44px;
            height: 44px;
            font-size: .9rem;
            padding: 0 .9rem;
        }

        .absent-filter-actions{
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: .6rem;
        }

        .absent-filter-btn{
            width: 100%;
        }
    }

    @media (max-width: 575.98px){
        .absent-filter-actions{
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="absent-filter-card card border-0 shadow-sm mb-3">
    <div class="card-body p-3 p-lg-4">

        <form method="GET" action="{{ route('absent.add', $client->id) }}">
            <div class="row g-3 align-items-end">

                {{-- ตั้งแต่วันที่ --}}
                <div class="col-12 col-md-6 col-xl-3">
                    <label class="form-label absent-filter-label">ตั้งแต่วันที่</label>
                    <input
                        type="date"
                        name="start_date"
                        class="form-control absent-filter-control"
                        value="{{ request('start_date') }}"
                    >
                </div>

                {{-- ถึงวันที่ --}}
                <div class="col-12 col-md-6 col-xl-3">
                    <label class="form-label absent-filter-label">ถึงวันที่</label>
                    <input
                        type="date"
                        name="end_date"
                        class="form-control absent-filter-control"
                        value="{{ request('end_date') }}"
                    >
                </div>

                {{-- ปุ่ม --}}
                <div class="col-12 col-xl-6">
                    <div class="d-flex flex-wrap gap-2 justify-content-xl-end">

                        {{-- 🔍 ค้นหา (อยู่หน้าเดิม) --}}
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search me-1"></i>
                            ค้นหาข้อมูล
                        </button>

                        {{-- 📄 รายงานรวม (อิง filter ปัจจุบัน) --}}
                        <a href="{{ route('absent.report.range', [
                                'client_id' => $client->id,
                                'start_date' => request('start_date'),
                                'end_date' => request('end_date')
                            ]) }}"
                           class="btn btn-outline-primary">
                            <i class="bi bi-file-earmark-text me-1"></i>
                            รายงานรวม
                        </a>

                        {{-- 🔄 ล้างค่า (กลับค่าทั้งหมดจริง ๆ) --}}
                        <a href="{{ route('absent.add', $client->id) }}"
                           class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-counterclockwise me-1"></i>
                            ล้างค่า
                        </a>

                    </div>
                </div>

            </div>
        </form>

    </div>
</div>
@endif