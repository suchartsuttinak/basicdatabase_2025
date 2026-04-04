@php
    $isProfileOpen = Request::routeIs('client.show') || Request::routeIs('client.show_refer');

    $isDashboardOpen =
        Request::routeIs('issues.index') || Request::routeIs('news.create') || Request::routeIs('landing.about.index');

    $isMasterMenu =
        Request::routeIs('institution.*') ||
        Request::routeIs('subject.*') ||
        Request::routeIs('education.*') ||
        Request::routeIs('semester.*') ||
        Request::routeIs('psycho.*') ||
        Request::routeIs('misbehavior.*') ||
        Request::routeIs('outside.*') ||
        Request::routeIs('document.*') ||
        Request::routeIs('income.*') ||
        Request::routeIs('help_type.*') ||
        Request::routeIs('translate.*');
@endphp

<style>
    /* (เหมือนเดิมทุกอย่าง — ไม่เปลี่ยน CSS เดิมของคุณ) */
    .app-sidebar-menu.sidebar-arrow-fix .menu-arrow {
        position: relative;
        display: inline-block;
        width: 10px;
        min-width: 10px;
        height: 10px;
        margin-left: auto;
        font-size: 0 !important;
        line-height: 0 !important;
        color: transparent !important;
        overflow: hidden;
    }

    .app-sidebar-menu.sidebar-arrow-fix .menu-arrow::before {
        content: "";
        position: absolute;
        top: 50%;
        left: 50%;
        width: 7px;
        height: 7px;
        border-right: 2px solid #64748b;
        border-bottom: 2px solid #64748b;
        transform: translate(-50%, -50%) rotate(-45deg);
        transition: transform .2s ease;
    }

    .app-sidebar-menu.sidebar-arrow-fix a[aria-expanded="true"]>.menu-arrow::before {
        transform: translate(-50%, -50%) rotate(45deg);
    }

    .app-sidebar-menu.sidebar-arrow-fix i[data-feather] {
        opacity: 0;
    }

    .app-sidebar-menu.sidebar-arrow-fix.sidebar-icons-ready i[data-feather],
    .app-sidebar-menu.sidebar-arrow-fix.sidebar-icons-ready svg.feather {
        opacity: 1;
    }

    .app-sidebar-menu.sidebar-arrow-fix #side-menu>li>a::after {
        content: none !important;
    }
</style>

<div class="app-sidebar-menu sidebar-arrow-fix" id="stableMasterSidebar">
    <div class="h-100" data-simplebar>
        <div id="sidebar-menu">

            <div class="logo-box">
                <a href="{{ url('/') }}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ asset('backend/assets/images/logo-sm.png') }}" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('backend/assets/images/logo-light.png') }}" height="24">
                    </span>
                </a>
            </div>

            <ul id="side-menu" class="metismenu list-unstyled pt-2">

                {{-- =========================
                    ทะเบียนประวัติ
                ========================== --}}
                <li class="menu-title">ทะเบียนประวัติ</li>
                <li>
                    <a href="#sidebarProfile" data-bs-toggle="collapse"
                        aria-expanded="{{ $isProfileOpen ? 'true' : 'false' }}"
                        class="{{ $isProfileOpen ? 'active' : '' }}">
                        <i data-feather="users"></i>
                        <span>บันทึกข้อมูลแรกเข้า</span>
                        <span class="menu-arrow"></span>
                    </a>

                    <div class="collapse {{ $isProfileOpen ? 'show' : '' }}" id="sidebarProfile">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('client.show') }}"
                                    class="tp-link {{ Request::routeIs('client.show') ? 'active' : '' }}">
                                    ทะเบียนผู้รับบริการ
                                </a>
                            </li>
                              @if(auth()->check() && auth()->user()->role === 'admin')
                            <li>
                                <a href="{{ route('client.show_refer') }}"
                                    class="tp-link {{ Request::routeIs('client.show_refer') ? 'active' : '' }}">
                                    ทะเบียนผู้รับบริการทั้งหมด
                                </a>
                            </li>
                             @endif

                             {{-- @if(auth()->check() && auth()->user()->hasRole(['admin','executive','manager']))
                                <li>
                                    <a href="{{ route('client.show_refer') }}"
                                        class="tp-link {{ Request::routeIs('client.show_refer') ? 'active' : '' }}">
                                        ทะเบียนผู้รับบริการทั้งหมด
                                    </a>
                                </li>
                             @endif --}}
                        </ul>
                    </div>
                </li>

                {{-- =========================
                    🔥 Dashboard ใหม่
                ========================== --}}
                <li class="menu-title">Dashboard</li>
                <li>
                    <a href="#sidebarDashboard" data-bs-toggle="collapse"
                        aria-expanded="{{ $isDashboardOpen ? 'true' : 'false' }}"
                        class="{{ $isDashboardOpen ? 'active' : '' }}">
                        <i data-feather="layout"></i>
                        <span>เข้าสู่หน้ายินดีต้อนรับ</span>
                        <span class="menu-arrow"></span>
                    </a>

                    <div class="collapse {{ $isDashboardOpen ? 'show' : '' }}" id="sidebarDashboard">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('issues.index') }}"
                                    class="tp-link {{ Request::routeIs('issues.index') ? 'active' : '' }}">
                                    แจ้งเรื่องช่วยเหลือ
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('news.create') }}"
                                    class="tp-link {{ Request::routeIs('news.create') ? 'active' : '' }}">
                                    เพิ่มข่าวสาร
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('landing.about.index') }}"
                                    class="tp-link {{ Request::routeIs('landing.about.index') ? 'active' : '' }}">
                                    ประวัติความเป็นมา
                                </a>
                            </li>

                     
                        </ul>
                    </div>
                </li>

                {{-- =========================
                    ข้อมูลอ้างอิง
                ========================== --}}
                   @if(auth()->check() && auth()->user()->role === 'admin')
                <li class="menu-title">ข้อมูลอ้างอิง</li>
                    <li>
                    <a href="#sidebar-master-data" data-bs-toggle="collapse"
                        aria-expanded="{{ $isMasterMenu ? 'true' : 'false' }}"
                        class="{{ $isMasterMenu ? 'active' : '' }}">
                        <i data-feather="grid"></i>
                        <span>ประเภท / หมวดหมู่</span>
                        <span class="menu-arrow"></span>
                    </a>

                    <div class="collapse {{ $isMasterMenu ? 'show' : '' }}" id="sidebar-master-data">
                        <ul class="nav-second-level">
                            <li><a href="{{ route('institution.all') }}">รายการสถานศึกษา</a></li>
                            <li><a href="{{ route('subject.show') }}">รายการวิชาเรียน</a></li>
                            <li><a href="{{ route('education.show') }}">รายการระดับการศึกษา</a></li>
                            <li><a href="{{ route('semester.show') }}">รายการปีการศึกษา</a></li>
                            <li><a href="{{ route('psycho.show') }}">รายการโรคทางจิตเวช</a></li>
                            <li><a href="{{ route('misbehavior.show') }}">รายการพฤติกรรม</a></li>
                            <li><a href="{{ route('outside.show') }}">รายการเด็กที่อยู่ภายนอก</a></li>
                            <li><a href="{{ route('document.show') }}">รายการเอกสาร</a></li>
                            <li><a href="{{ route('income.show') }}">รายการรายได้</a></li>
                            <li><a href="{{ route('help_type.show') }}">ประเภทการช่วยเหลือ</a></li>
                            <li><a href="{{ route('translate.show') }}">ประเภทการพ้นอุปการะ</a></li>
                        </ul>
                    </div>
                </li>
            @endif

                   {{-- =========================
                    🔥  ประชาสัมพันธ์
                ========================== --}}
              
                    <li class="menu-title mt-2">ประชาสัมพันธ์</li>
                    <li>
                       <a href="{{ route('publicizes.index') }}"
                            class="tp-link {{ Request::routeIs('publicizes.index') ? 'active' : '' }}">
                            <i class="bi bi-megaphone me-1"></i> ข่าวสาร/กิจกรรม
                            </a>
                    </li>
            
              {{-- จัดการผู้ใช้งาน (เฉพาะ admin-เท่านั้น) --}}  
               
                  @if(auth()->check() && auth()->user()->role === 'admin')
                    <li>
                        <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
                            <i class="bi bi-people-fill"></i>
                            <span>จัดการผู้ใช้งาน</span>
                        </a>
                    </li>
                    @endif


                {{-- =========================
                    ระบบ
                ========================== --}}
                <li class="menu-title mt-2">ระบบ</li>
                <li>
                    <a href="{{ route('admin.logout') ?? url('/logout') }}">
                        <i data-feather="log-out"></i>
                        <span>ออกจากระบบ</span>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('stableMasterSidebar');
        if (!sidebar) return;

        function renderFeather() {
            if (window.feather) {
                try {
                    feather.replace();
                } catch (e) {}
            }
            sidebar.classList.add('sidebar-icons-ready');
        }

        renderFeather();
        setTimeout(renderFeather, 100);
    });
</script>
