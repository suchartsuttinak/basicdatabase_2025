<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<style>
/* ===== TAB MODERN UI ===== */
.app-tabs{
    --tab-primary:#0f766e;
    --tab-primary-soft:rgba(15,118,110,.12);
    --tab-border:#dbe7e7;
    --tab-text:#374151;
    --tab-muted:#6b7280;

    display:flex;
    flex-wrap:nowrap;
    gap:.5rem;
    overflow-x:auto;
    overflow-y:hidden;
    padding:.5rem;
    border-bottom:1px solid var(--tab-border);
    background:#fff;
    border-radius:14px;
    -webkit-overflow-scrolling:touch;
    scrollbar-width:none;
}

.app-tabs::-webkit-scrollbar{
    display:none;
}

/* ITEM */
.app-tabs .nav-item{
    flex:0 0 auto;
}

/* LINK */
.app-tabs .nav-link{
    display:flex;
    align-items:center;
    gap:.45rem;
    white-space:nowrap;
    padding:.6rem .95rem;
    border-radius:10px;
    border:1px solid transparent;
    font-size:.92rem;
    font-weight:600;
    color:var(--tab-text);
    background:transparent;
    transition:.2s ease;
}

/* HOVER */
.app-tabs .nav-link:hover{
    background:#f4f8f9;
    color:var(--tab-primary);
}

/* ACTIVE */
.app-tabs .nav-link.active{
    background:var(--tab-primary-soft);
    color:var(--tab-primary);
    border-color:rgba(15,118,110,.25);
    box-shadow:0 4px 12px rgba(15,118,110,.08);
}

/* ICON */
.app-tabs .nav-link i{
    font-size:1rem;
}

/* BACK BUTTON */
.app-tabs .back-home{
    margin-left:auto;
    color:#b91c1c;
}

.app-tabs .back-home:hover{
    background:#fef2f2;
    color:#991b1b;
}

/* MOBILE */
@media (max-width:768px){
    .app-tabs{
        padding:.4rem;
        gap:.4rem;
    }

    .app-tabs .nav-link{
        font-size:.85rem;
        padding:.55rem .75rem;
    }

    .app-tabs .nav-link i{
        font-size:.9rem;
    }
}
</style>

<ul class="nav app-tabs" role="tablist">

    {{-- TAB 1 --}}
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('client.edit') ? 'active' : '' }}"
           href="{{ route('client.edit', $client->id) }}">
            <i class="bi bi-person-plus-fill"></i>
            <span>ข้อมูลผู้รับบริการ</span>
        </a>
    </li>

    {{-- TAB 2 --}}
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('factfinding.add','factfinding.edit') ? 'active' : '' }}"
           href="{{ route('factfinding.add', $client->id) }}">
            <i class="bi bi-search-heart"></i>
            <span>สอบข้อเท็จจริง</span>
        </a>
    </li>

    {{-- TAB 3 --}}
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('family.add','family.edit') ? 'active' : '' }}"
           href="{{ route('family.add', $client->id) }}">
            <i class="bi bi-people-fill"></i>
            <span>บิดา/มารดา</span>
        </a>
    </li>

    {{-- TAB 4 --}}
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('member.create','member.show','member.edit') ? 'active' : '' }}"
           href="{{ route('member.create', $client->id) }}">
            <i class="bi bi-house-heart-fill"></i>
            <span>สมาชิกครอบครัว</span>
        </a>
    </li>

    {{-- BACK --}}
    <li class="nav-item">
        <a class="nav-link back-home" href="{{ route('client.show') }}">
            <i class="bi bi-arrow-left-circle"></i>
            <span>กลับ</span>
        </a>
    </li>

</ul>