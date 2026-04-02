@php
    $id = Auth::user()->id;
    $profileData = App\Models\User::find($id);
@endphp

<style>
    /* =========================================================
       Scoped style เฉพาะ topbar นี้เท่านั้น
       ปรับเฉพาะข้อความเมนูหลักให้เหมือน "ระบบข้อมูลผู้รับบริการ"
       ========================================================= */
    #appTopbar .topbar-menu > .nav-item > .topbar-link > span,
    #appTopbar .topbar-menu > .nav-item > .topbar-link.dropdown-toggle > span {
        font-family: 'Kanit', sans-serif !important;
        font-size: 15px !important;
        font-weight: 600 !important;
        line-height: 1.2 !important;
        letter-spacing: .01em !important;
        color: #1e3a5f !important;
        display: inline-block !important;
        vertical-align: middle !important;
        text-rendering: geometricPrecision;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    /* คงรูปแบบเดิมตอน active / hover โดยไม่ไปยุ่งส่วนอื่น */
    #appTopbar .topbar-menu > .nav-item > .topbar-link.active > span,
    #appTopbar .topbar-menu > .nav-item > .topbar-link:hover > span,
    #appTopbar .topbar-menu > .nav-item > .topbar-link:focus > span,
    #appTopbar .topbar-menu > .nav-item > .topbar-link.dropdown-toggle.active > span,
    #appTopbar .topbar-menu > .nav-item > .topbar-link.dropdown-toggle:hover > span,
    #appTopbar .topbar-menu > .nav-item > .topbar-link.dropdown-toggle:focus > span {
        font-family: 'Kanit', sans-serif !important;
        font-size: 15px !important;
        font-weight: 600 !important;
        line-height: 1.2 !important;
        letter-spacing: .01em !important;
    }

    /* จัดไอคอนกับข้อความให้บาลานซ์ขึ้น แต่ไม่กระทบเมนูย่อย */
    #appTopbar .topbar-menu > .nav-item > .topbar-link {
        display: inline-flex !important;
        align-items: center !important;
        gap: .55rem !important;
    }

    #appTopbar .topbar-menu > .nav-item > .topbar-link > i {
        flex: 0 0 auto;
    }

    @media (max-width: 767.98px) {
        #appTopbar .topbar-menu > .nav-item > .topbar-link > span,
        #appTopbar .topbar-menu > .nav-item > .topbar-link.dropdown-toggle > span,
        #appTopbar .topbar-menu > .nav-item > .topbar-link.active > span,
        #appTopbar .topbar-menu > .nav-item > .topbar-link:hover > span,
        #appTopbar .topbar-menu > .nav-item > .topbar-link:focus > span {
            font-family: 'Kanit', sans-serif !important;
            font-size: 15px !important;
            font-weight: 600 !important;
            line-height: 1.2 !important;
            letter-spacing: .01em !important;
            color: #1e3a5f !important;
        }
    }
</style>

<div class="topbar-custom app-topbar" id="appTopbar">
    <div class="container-fluid px-2 px-lg-3">
        <nav class="navbar navbar-expand-xl navbar-light topbar-navbar">

            <!-- Left: mobile toggle -->
            <div class="d-flex align-items-center topbar-left-group">
                <button class="navbar-toggler topbar-toggler"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent"
                        aria-expanded="false"
                        aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <button type="button" class="button-toggle-menu topbar-sidebar-toggle border-0 bg-transparent d-none d-xl-inline-flex">
                    <i data-feather="menu" class="topbar-icon"></i>
                </button>

                <a href="{{ route('dashboard') }}" class="topbar-brand d-none d-md-flex">
                    <span class="topbar-brand-badge">
                        <i class="fas fa-people-group"></i>
                    </span>
                    <span class="topbar-brand-text">
                        ระบบข้อมูลผู้รับบริการ
                    </span>
                </a>
            </div>

            <!-- Main menu -->
            <div class="collapse navbar-collapse topbar-collapse" id="navbarSupportedContent">

                <ul class="navbar-nav topbar-menu mb-2 mb-xl-0">
                    <li class="nav-item">
                        <a class="nav-link topbar-link {{ Request::routeIs('dashboard') ? 'active' : '' }}"
                           href="{{ route('dashboard') }}">
                            <i class="fas fa-home"></i>
                            <span>หน้าหลัก</span>
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link topbar-link dropdown-toggle {{ Request::is('history*') ? 'active' : '' }}"
                           href="#"
                           id="historyDropdown"
                           role="button"
                           data-bs-toggle="dropdown"
                           aria-expanded="false">
                            <i class="fas fa-book"></i>
                            <span>ทะเบียนประวัติ</span>
                        </a>
                        <ul class="dropdown-menu topbar-dropdown" aria-labelledby="historyDropdown">
                            <li><a class="dropdown-item" href="#">ร้องเรียนทั่วไป</a></li>
                            <li><a class="dropdown-item" href="#">ร้องเรียนการศึกษา</a></li>
                            <li><a class="dropdown-item" href="#">ร้องเรียนอื่น ๆ</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link topbar-link dropdown-toggle {{ Request::is('education*') ? 'active' : '' }}"
                           href="#"
                           id="educationDropdown"
                           role="button"
                           data-bs-toggle="dropdown"
                           aria-expanded="false">
                            <i class="fas fa-graduation-cap"></i>
                            <span>การศึกษา</span>
                        </a>
                        <ul class="dropdown-menu topbar-dropdown" aria-labelledby="educationDropdown">
                            <li>
                                <a class="dropdown-item {{ setActive('education_record_add') }}"
                                   href="{{ route('education_record_add', ['client_id' => $client->id]) }}">
                                    บันทึกผลการเรียน
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ setActive('education_record_show') }}"
                                   href="{{ route('education_record_show', $client->id) }}">
                                    แสดงผลการเรียน
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ setActive('education_other') }}" href="#">
                                    ร้องเรียนอื่น ๆ
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link topbar-link dropdown-toggle {{ Request::is('health*') ? 'active' : '' }}"
                           href="#"
                           id="healthDropdown"
                           role="button"
                           data-bs-toggle="dropdown"
                           aria-expanded="false">
                            <i class="fas fa-heartbeat"></i>
                            <span>สุขภาพ</span>
                        </a>
                        <ul class="dropdown-menu topbar-dropdown" aria-labelledby="healthDropdown">
                            <li><a class="dropdown-item" href="#">ร้องเรียนทั่วไป</a></li>
                            <li><a class="dropdown-item" href="#">ร้องเรียนการศึกษา</a></li>
                            <li><a class="dropdown-item" href="#">ร้องเรียนอื่น ๆ</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link topbar-link dropdown-toggle {{ Request::is('social*') ? 'active' : '' }}"
                           href="#"
                           id="socialDropdown"
                           role="button"
                           data-bs-toggle="dropdown"
                           aria-expanded="false">
                            <i class="fas fa-users"></i>
                            <span>สังคมสงเคราะห์</span>
                        </a>
                        <ul class="dropdown-menu topbar-dropdown" aria-labelledby="socialDropdown">
                            <li><a class="dropdown-item" href="#">ค้นหาสถานศึกษา</a></li>
                            <li><a class="dropdown-item" href="#">ค้นหาครอบครัว</a></li>
                            <li><a class="dropdown-item" href="#">ค้นหาบุคคล</a></li>
                        </ul>
                    </li>
                </ul>

                <!-- Right profile -->
                <ul class="navbar-nav ms-xl-auto align-items-xl-center topbar-profile-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link topbar-user dropdown-toggle"
                           href="#"
                           id="profileDropdown"
                           role="button"
                           data-bs-toggle="dropdown"
                           aria-expanded="false">
                            <img src="{{ !empty($profileData->photo) ? url('upload/user_images/'.$profileData->photo) : url('upload/no_image.jpg') }}"
                                 alt="user-image"
                                 class="topbar-user-avatar">
                            <span class="topbar-user-meta d-none d-md-flex">
                                <span class="topbar-user-label">ผู้ใช้งาน</span>
                                <span class="topbar-user-name">{{ $profileData->name }}</span>
                            </span>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end topbar-dropdown topbar-user-dropdown"
                            aria-labelledby="profileDropdown">
                            <li>
                                <h6 class="dropdown-header">บัญชีผู้ใช้งาน</h6>
                            </li>
                            <li>
                                <a href="{{ route('admin.profile') }}" class="dropdown-item">
                                    <i class="fas fa-user-circle me-2"></i>ข้อมูลส่วนตัว
                                </a>
                            </li>
                            <li>
                                <a href="auth-lock-screen.html" class="dropdown-item">
                                    <i class="fas fa-lock me-2"></i>ล็อกหน้าจอ
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a href="{{ route('admin.logout') }}" class="dropdown-item text-danger">
                                    <i class="fas fa-sign-out-alt me-2"></i>ออกจากระบบ
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>

            </div>
        </nav>
    </div>
</div>