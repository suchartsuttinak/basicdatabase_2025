@extends('admin_client.admin_client')

@section('content')

<style>
    .bs-index-page{
        padding:24px 0 40px;
    }

    .bs-index-header{
        display:flex;
        justify-content:space-between;
        align-items:center;
        gap:16px;
        flex-wrap:wrap;
        margin-bottom:22px;
    }

    .bs-index-title{
        font-size:1.35rem;
        font-weight:800;
        color:#0f172a;
        margin:0 0 4px;
    }

    .bs-index-subtitle{
        color:#64748b;
        font-size:.95rem;
    }

    .bs-add-btn{
        border-radius:12px;
        padding:10px 18px;
        font-weight:700;
        box-shadow:0 8px 18px rgba(37,99,235,.18);
    }

    .bs-table-card{
        border:0;
        border-radius:18px;
        overflow:hidden;
        box-shadow:0 10px 30px rgba(15,23,42,.06);
        background:#fff;
    }

    .bs-table{
        margin:0;
        min-width:980px;
    }

    .bs-table thead th{
        background:#f8fafc;
        color:#0f172a;
        font-weight:800;
        border-bottom:1px solid #e2e8f0;
        padding:14px 12px;
        white-space:nowrap;
        vertical-align:middle;
    }

    .bs-table tbody td{
        padding:16px 12px;
        vertical-align:middle;
        border-bottom:1px solid #eef2f7;
        color:#0f172a;
    }

    .bs-table tbody tr:last-child td{
        border-bottom:0;
    }

    .bs-summary{
        white-space:pre-line;
        line-height:1.7;
        font-weight:600;
        min-width:260px;
    }

    .bs-score{
        display:inline-flex;
        align-items:center;
        justify-content:center;
        min-width:30px;
        height:24px;
        padding:0 9px;
        border-radius:999px;
        font-size:.78rem;
        font-weight:800;
        color:#fff;
    }

    .bs-score-learning{ background:#4f6df5; }
    .bs-score-ld{ background:#38aee2; }
    .bs-score-adhd{ background:#f59e0b; color:#111827; }
    .bs-score-autism{ background:#fb7185; }

    .bs-action-group{
        display:inline-flex;
        align-items:center;
        justify-content:center;
        gap:8px;
        flex-wrap:nowrap;
    }

    .bs-action-btn{
        width:34px;
        height:34px;
        padding:0;
        display:inline-flex;
        align-items:center;
        justify-content:center;
        border-radius:10px;
        line-height:1;
    }

    .bs-action-btn i{
        font-size:14px;
        line-height:1;
    }

    .bs-empty-card{
        border:0;
        border-radius:18px;
        box-shadow:0 10px 30px rgba(15,23,42,.06);
    }

    .bs-index-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:16px;
    flex-wrap:wrap;
    margin-bottom:22px;
}

.bs-index-header-left{
    display:flex;
    align-items:flex-start;
    gap:14px;
    flex-wrap:wrap;
}

.bs-index-title-wrap{
    display:flex;
    flex-direction:column;
}

.bs-back-btn{
    border-radius:12px;
    padding:8px 14px;
    font-weight:600;
    border:1px solid #dbe3ef;
    background:#fff;
    transition:all .2s ease;
    white-space:nowrap;
}

.bs-back-btn:hover{
    background:#f8fafc;
    transform:translateY(-1px);
}

.bs-add-btn{
    border-radius:12px;
    padding:10px 18px;
    font-weight:600;
    box-shadow:0 4px 14px rgba(13,110,253,.15);
}

@media (max-width: 768px){

    .bs-index-header{
        align-items:stretch;
    }

    .bs-index-header-left{
        width:100%;
        flex-direction:column;
        align-items:flex-start;
    }

    .bs-add-btn{
        width:100%;
        justify-content:center;
    }

    .bs-back-btn{
        width:100%;
        justify-content:center;
    }
}

    @media (max-width: 767.98px){
        .bs-index-page{
            padding:14px 0 28px;
        }

        .bs-index-header{
            align-items:stretch;
        }

        .bs-add-btn{
            width:100%;
        }
    }
</style>

<div class="container-fluid bs-index-page">

  <div class="bs-index-header">

    <div class="bs-index-header-left">

        <a href="{{ route('client.show') }}"
           class="btn btn-light bs-back-btn">
            <i class="bi bi-arrow-left-circle me-1"></i>
            กลับไปหน้าเคส
        </a>

       <div class="official-report-head">
    <div class="official-title">
        แบบสังเกตพฤติกรรม 4 โรค
    </div>

    <div class="official-subtitle">
        สำหรับคัดกรองพฤติกรรมเบื้องต้น
    </div>
</div>

    </div>

    <a href="{{ route('behavior-screenings.create', $client->id) }}"
       class="btn btn-primary bs-add-btn">
        <i class="bi bi-plus-circle me-1"></i>
        เพิ่มแบบประเมิน
    </a>

</div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($screenings->count())

        <div class="card bs-table-card">
            <div class="table-responsive">
                <table class="table bs-table align-middle">
                    <thead>
                        <tr>
                            <th style="width:120px;">วันที่</th>
                            <th>ผลสรุป</th>
                            <th style="width:110px;" class="text-center">เรียนรู้ช้า</th>
                            <th style="width:80px;" class="text-center">LD</th>
                            <th style="width:90px;" class="text-center">ADHD</th>
                            <th style="width:90px;" class="text-center">Autism</th>
                            <th style="width:150px;">ผู้ประเมิน</th>
                            <th style="width:120px;" class="text-center">จัดการ</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($screenings as $item)
                            <tr>
                                <td class="fw-semibold">
                                    {{ $item->screening_date?->format('d/m/Y') }}
                                </td>

                                <td>
                                    <div class="bs-summary">
                                        {{ $item->summary }}
                                    </div>
                                </td>

                                <td class="text-center">
                                    <span class="bs-score bs-score-learning">
                                        {{ $item->learning_score }}
                                    </span>
                                </td>

                                <td class="text-center">
                                    <span class="bs-score bs-score-ld">
                                        {{ $item->ld_score }}
                                    </span>
                                </td>

                                <td class="text-center">
                                    <span class="bs-score bs-score-adhd">
                                        {{ $item->adhd_score }}
                                    </span>
                                </td>

                                <td class="text-center">
                                    <span class="bs-score bs-score-autism">
                                        {{ $item->autism_score }}
                                    </span>
                                </td>

                                <td>
                                    {{ $item->observer_name ?: '-' }}
                                </td>

                                <td class="text-center">
                                    <div class="bs-action-group">
                                        <a href="{{ route('behavior-screenings.show', $item->id) }}"
                                           class="btn btn-outline-primary bs-action-btn"
                                           title="ดูข้อมูล">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <form action="{{ route('behavior-screenings.destroy', $item->id) }}"
                                              method="POST"
                                              class="behavior-delete-form m-0 p-0">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="btn btn-outline-danger bs-action-btn"
                                                    title="ลบข้อมูล">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>

        <div class="mt-3">
            {{ $screenings->links() }}
        </div>

    @else

        <div class="card bs-empty-card">
            <div class="card-body text-center py-5">
                <i class="bi bi-clipboard2-pulse fs-1 text-muted"></i>

                <h5 class="mt-3">
                    ยังไม่มีข้อมูลแบบประเมิน
                </h5>

                <div class="text-muted mb-3">
                    กรุณาเพิ่มแบบสังเกตพฤติกรรม
                </div>

                {{-- <a href="{{ route('behavior-screenings.create', $client->id) }}"
                   class="btn btn-primary bs-add-btn">
                    <i class="bi bi-plus-circle me-1"></i>
                    เพิ่มแบบประเมิน
                </a> --}}
            </div>
        </div>

    @endif

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const deleteForms = document.querySelectorAll('.behavior-delete-form');

    deleteForms.forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            Swal.fire({
                title: 'ยืนยันการลบ ?',
                text: 'เมื่อลบแล้วจะไม่สามารถกู้คืนข้อมูลได้',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'ใช่, ลบข้อมูล',
                cancelButtonText: 'ยกเลิก',
                reverseButtons: true
            }).then(function (result) {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>

@endsection