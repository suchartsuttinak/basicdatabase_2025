<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="utf-8" />
    <title>Dashboard | Admin Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc." />
    <meta name="author" content="Zoyothemes" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link rel="shortcut icon" href="{{ asset('backend/assets/images/favicon.ico') }}">

    <!-- Core CSS -->
    <link href="{{ asset('backend/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />
    <link href="{{ asset('backend/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">

    <!-- Datatables CSS -->
    <link href="{{ asset('backend/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/assets/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/assets/libs/datatables.net-keytable-bs5/css/keyTable.bootstrap5.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/assets/libs/datatables.net-select-bs5/css/select.bootstrap5.min.css') }}" rel="stylesheet" />

    <!-- Datepicker CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

        <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

       {{-- 🔥 เพิ่มตรงนี้ --}}
    @stack('styles')

    <style>
        :root{
            --topbar-height: 70px;
            --sidebar-width: 260px;
            --primary-soft: #e3f2fd;
            --primary-border: #90caf9;
            --primary-text: #0d47a1;
            --content-bg: #f8fafc;
            --card-border: #e9ecef;
            --shadow-soft: 0 2px 10px rgba(15, 23, 42, .03);
            --radius-lg: 14px;
            --radius-md: 10px;
        }

        html, body {
            min-height: 100%;
        }

        body {
            margin: 0;
            font-family: 'Kanit', sans-serif;
            font-size: 15px;
            line-height: 1.6;
            color: #212529;
            background: var(--content-bg);
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, .card-header, .navbar-brand {
            font-weight: 500;
        }

        table td, table th {
            font-size: 14px;
            vertical-align: middle;
        }

        .btn {
            font-weight: 400;
            letter-spacing: .2px;
        }

        .form-control,
        .form-select {
            color: #495057;
        }

        .form-control::placeholder {
            color: #adb5bd;
            opacity: 1;
        }

        /* DataTable */
        table.dataTable td,
        table.dataTable th {
            font-size: 12px;
        }

        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_paginate {
            font-size: 12px;
        }

        .dataTables_wrapper .dataTables_filter input {
            margin-left: .4rem;
        }

        /* App Layout */
        #app-layout {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .app-body {
            display: flex;
            min-height: calc(100vh - var(--topbar-height));
        }

        .app-sidebar-menu {
            width: var(--sidebar-width);
            flex: 0 0 var(--sidebar-width);
            background: #f8f9fa;
            border-right: 1px solid #dee2e6;
            min-height: calc(100vh - var(--topbar-height));
        }

        .content-page {
            flex: 1 1 auto;
            min-width: 0;
            position: relative;
            background-color: var(--content-bg);
            min-height: calc(100vh - var(--topbar-height));
            overflow-x: hidden;
            padding: .75rem 1.25rem 1.5rem 1.25rem;
        }

        .content-page > .content,
        .page-content,
        .main-content {
            max-width: 100%;
        }

        .content-shell {
            max-width: 100%;
        }

        /* ===== FIX SIDEBAR RESPONSIVE ===== */

/* desktop ปกติ */
.app-body {
    display: flex;
}

/* มือถือ / tablet */
@media (max-width: 1199.98px){

    /* ❌ ยกเลิกการเป็น column */
    .app-body{
        flex-direction: row !important;
    }

    /* ทำ sidebar เป็น slide แทน */
    .app-sidebar-menu{
        position: fixed;
        top: var(--topbar-height);
        left: 0;
        width: 260px;
        height: calc(100vh - var(--topbar-height));
        background: #fff;
        z-index: 1050;
        transform: translateX(-100%);
        transition: transform .25s ease;
        box-shadow: 2px 0 12px rgba(0,0,0,.08);
    }

    /* เปิดเมนู */
    body.sidebar-open .app-sidebar-menu{
        transform: translateX(0);
    }

    /* content เต็มจอ */
    .content-page{
        width: 100%;
        margin-left: 0 !important;
    }

    /* overlay */
    .sidebar-overlay{
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,.35);
        z-index: 1045;
        opacity: 0;
        visibility: hidden;
        transition: .25s ease;
    }

    body.sidebar-open .sidebar-overlay{
        opacity: 1;
        visibility: visible;
    }
}

        /* Topbar */
        :root{
    --topbar-height: 72px;
    --topbar-bg: rgba(255,255,255,.88);
    --topbar-border: #e6edf5;
    --topbar-text: #1f3b64;
    --topbar-muted: #6b7280;
    --topbar-hover: #eef5ff;
    --topbar-active-bg: #e8f1ff;
    --topbar-active-text: #2563eb;
    --topbar-shadow: 0 6px 20px rgba(15, 23, 42, 0.05);
}

/* wrapper */
.app-topbar {
    position: sticky;
    top: 0;
    z-index: 1040;
    min-height: var(--topbar-height);
    background: var(--topbar-bg);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border-bottom: 1px solid var(--topbar-border);
    box-shadow: var(--topbar-shadow);
}

.topbar-navbar {
    min-height: var(--topbar-height);
    padding-top: .5rem;
    padding-bottom: .5rem;
}

.topbar-left-group {
    display: flex;
    align-items: center;
    gap: .5rem;
}

.topbar-brand {
    display: inline-flex;
    align-items: center;
    gap: .65rem;
    text-decoration: none;
    margin-left: .35rem;
}

.topbar-brand-badge {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #2563eb, #60a5fa);
    color: #fff;
    font-size: 15px;
    box-shadow: 0 4px 10px rgba(37, 99, 235, .25);
}

.topbar-brand-text {
    font-weight: 600;
    color: #1e3a5f;
    font-size: 15px;
    letter-spacing: .01em;
}

.topbar-toggler {
    border: 0;
    box-shadow: none !important;
    padding: .4rem .55rem;
    border-radius: 10px;
}

.topbar-toggler:hover {
    background: #f4f8ff;
}

.topbar-sidebar-toggle {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    color: var(--topbar-text);
    align-items: center;
    justify-content: center;
    transition: all .2s ease;
}

.topbar-sidebar-toggle:hover {
    background: #f4f8ff;
    color: var(--topbar-active-text);
}

.topbar-icon {
    width: 18px;
    height: 18px;
}

.topbar-collapse {
    align-items: center;
}

.topbar-menu {
    gap: .35rem;
}

.topbar-link {
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    color: var(--topbar-text) !important;
    font-weight: 500;
    padding: .65rem .9rem !important;
    border-radius: 12px;
    transition: all .2s ease;
    white-space: nowrap;
    position: relative;
}

.topbar-link i {
    font-size: 14px;
    width: 16px;
    text-align: center;
}

.topbar-link:hover,
.topbar-link:focus {
    background: var(--topbar-hover);
    color: var(--topbar-active-text) !important;
}

.topbar-link.active {
    background: var(--topbar-active-bg);
    color: var(--topbar-active-text) !important;
    font-weight: 600;
}

.topbar-link.dropdown-toggle::after {
    margin-left: .45rem;
    opacity: .7;
}

/* profile */
.topbar-profile-nav {
    margin-top: 0;
}

.topbar-user {
    display: inline-flex;
    align-items: center;
    gap: .7rem;
    padding: .4rem .6rem .4rem .45rem !important;
    border-radius: 14px;
    color: var(--topbar-text) !important;
    transition: all .2s ease;
}

.topbar-user:hover,
.topbar-user:focus {
    background: #f7faff;
}

.topbar-user-avatar {
    width: 42px;
    height: 42px;
    object-fit: cover;
    border-radius: 50%;
    border: 2px solid #dbeafe;
    box-shadow: 0 2px 8px rgba(37, 99, 235, .12);
}

.topbar-user-meta {
    display: flex;
    flex-direction: column;
    line-height: 1.15;
}

.topbar-user-label {
    font-size: 11px;
    color: var(--topbar-muted);
}

.topbar-user-name {
    font-size: 14px;
    font-weight: 600;
    color: #1f2937;
}

/* dropdown */
.topbar-dropdown {
    min-width: 235px;
    padding: .45rem;
    border: 1px solid #e8edf3;
    border-radius: 14px;
    box-shadow: 0 14px 30px rgba(15, 23, 42, 0.10);
}

.topbar-dropdown .dropdown-header {
    color: #64748b;
    font-size: 12px;
    font-weight: 600;
    padding: .55rem .75rem;
}

.topbar-dropdown .dropdown-item {
    display: flex;
    align-items: center;
    border-radius: 10px;
    padding: .65rem .8rem;
    color: #334155;
    transition: all .18s ease;
    font-size: 14px;
}

.topbar-dropdown .dropdown-item:hover,
.topbar-dropdown .dropdown-item:focus {
    background: #eef5ff;
    color: #2563eb;
}

.topbar-dropdown .dropdown-divider {
    margin: .4rem 0;
}

/* desktop hover */
@media (min-width: 1200px) {
    .topbar-menu .dropdown:hover > .topbar-dropdown {
        display: block;
        margin-top: 0;
    }
}

/* tablet and down */
@media (max-width: 1199.98px) {
    .topbar-navbar {
        min-height: auto;
    }

    .topbar-collapse {
        padding-top: .85rem;
    }

    .topbar-menu {
        gap: .15rem;
    }

    .topbar-menu,
    .topbar-profile-nav {
        width: 100%;
    }

    .topbar-menu .nav-item,
    .topbar-profile-nav .nav-item {
        width: 100%;
    }

    .topbar-link,
    .topbar-user {
        width: 100%;
        justify-content: flex-start;
    }

    .topbar-dropdown {
        position: static !important;
        transform: none !important;
        width: 100%;
        min-width: 100%;
        margin-top: .3rem;
        border-radius: 12px;
        box-shadow: none;
    }

    .topbar-profile-nav {
        margin-top: .7rem;
        padding-top: .7rem;
        border-top: 1px solid #e9edf3;
    }

    .topbar-user {
        padding-left: .2rem !important;
    }

    .topbar-brand {
        margin-left: .15rem;
    }
}

/* mobile */
@media (max-width: 767.98px) {
    :root{
        --topbar-height: 64px;
    }

    .topbar-brand-text {
        font-size: 14px;
    }

    .topbar-link {
        font-size: .95rem;
        padding: .65rem .8rem !important;
    }

    .topbar-user-avatar {
        width: 38px;
        height: 38px;
    }

    .topbar-dropdown .dropdown-item {
        font-size: 13.5px;
    }
}

        .button-toggle-menu {
            cursor: pointer;
            outline: none;
            box-shadow: none !important;
        }

        .button-toggle-menu.nav-link {
            display: flex;
            align-items: center;
            border: 0;
            background: transparent;
        }

        .nav-user .pro-user-name {
            color: #333 !important;
            font-weight: 500;
        }

        .nav-user img,
        .profile-avatar {
            border: 2px solid #0d6efd;
            width: 40px;
            height: 40px;
            object-fit: cover;
        }

        /* Sidebar */
        .app-sidebar-menu .logo-box {
            background: #fff;
        }

        .app-sidebar-menu .logo-lg {
            font-size: 15px;
            color: #1f2937;
        }

        .client-mini-card {
            background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
        }

        .client-id {
            line-height: 1;
        }

        #sidebar-menu {
            padding-bottom: 1rem;
        }

        #side-menu {
            padding-left: 0;
            margin-bottom: 0;
        }

        #side-menu .menu-title {
            font-size: 12px;
            font-weight: 600;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: .04em;
            padding: 12px 20px 8px;
            margin: 0;
        }

        #side-menu > li > a {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #334155;
            font-weight: 500;
            padding: 10px 18px;
            margin: 2px 10px;
            border-radius: 10px;
            transition: all .2s ease;
            text-decoration: none;
            position: relative;
        }

        #side-menu > li > a:hover {
            background: #e8f2ff;
            color: #0d6efd;
        }

        #side-menu > li > a.active {
            background: #dbeafe;
            color: #0d6efd;
            font-weight: 600;
        }

        #side-menu > li > a i,
        #side-menu > li > a svg,
        .sidebar-fa-icon {
            width: 18px;
            min-width: 18px;
            text-align: center;
        }

        #side-menu .menu-arrow {
            margin-left: auto;
            transition: transform .2s ease;
        }

        #side-menu > li > a[aria-expanded="true"] .menu-arrow {
            transform: rotate(90deg);
        }

        #side-menu .collapse {
            transition: all .2s ease;
        }

        #side-menu .nav-second-level {
            list-style: none;
            padding: 4px 0 6px 0;
            margin: 0 0 4px 0;
        }

        #side-menu .nav-second-level li a {
            display: block;
            color: #475569;
            font-size: 14px;
            font-weight: 400;
            padding: 8px 18px 8px 50px;
            margin: 1px 10px;
            border-radius: 8px;
            text-decoration: none;
            transition: all .2s ease;
        }

        #side-menu .nav-second-level li a:hover {
            background: #eef6ff;
            color: #0d6efd;
        }

        #side-menu .nav-second-level li a.active {
            background: #dbeafe;
            color: #0d6efd;
            font-weight: 500;
        }

        /* Card / block */
        .card {
            border: 1px solid var(--card-border);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-soft);
        }

        .card-header {
            background: #fff;
            border-bottom: 1px solid #eef1f4;
        }

        /* Utility for wide forms/tables */
        .content-scroll-x {
            width: 100%;
            overflow-x: auto;
            overflow-y: visible;
            -webkit-overflow-scrolling: touch;
        }

        .table-wrap {
            width: 100%;
            overflow-x: auto;
        }

        .table-wrap table {
            min-width: 900px;
        }

        .form-wrap-wide {
            width: 100%;
            overflow-x: auto;
            padding-bottom: .5rem;
        }

        /* Page header compact */
        .page-header-compact {
            margin-top: 0 !important;
            padding-top: 0 !important;
            margin-bottom: 1rem;
        }

        .page-header-compact .title-wrap,
        .page-header-compact .section-title-wrap {
            margin-top: 0 !important;
            padding-top: 0 !important;
        }

        .page-header-compact h1,
        .page-header-compact h2,
        .page-header-compact h3,
        .page-header-compact h4 {
            margin-top: 0 !important;
            margin-bottom: .2rem;
        }

        .page-header-compact .page-subtitle {
            margin-bottom: .35rem;
            color: #6c757d;
        }

        .page-header-compact .page-divider {
            width: 380px;
            max-width: 100%;
            height: 1px;
            background: #cfd8ff;
            margin: .5rem auto 0;
        }

        /* ลดระยะหัวฟอร์มที่ตกต่ำ */
        .content-page > .content-scroll-x > :first-child,
        .content-page > :first-child {
            margin-top: 0 !important;
        }

        .content-page .card:first-child,
        .content-page .page-header-compact + .card,
        .content-page .page-header-compact + .row,
        .content-page .page-header-compact + .container,
        .content-page .page-header-compact + .container-fluid {
            margin-top: 0 !important;
        }

        /* Report / print-like pages */
        .report-wrap,
        .print-page,
        .report-container {
            max-width: 100%;
        }

        .report-wrap img,
        .print-page img,
        .report-container img {
            max-width: 100%;
            height: auto;
        }

        .app-footer {
    margin-top: 1.25rem;
    padding: .9rem 0 0 0;
    background: transparent;
    border-top: 1px solid #e5e7eb;
}

    .app-footer .footer-text {
        font-size: 13px;
        color: #6b7280;
        line-height: 1.6;
    }

    .app-footer .fw-semibold {
        color: #374151;
    }

    @media (max-width: 767.98px) {
        .app-footer {
            margin-top: 1rem;
            padding-top: .75rem;
        }

        .app-footer .footer-text {
            font-size: 12px;
        }
    }

        /* Hover dropdown only desktop */
        @media (min-width: 1200px) {
            .navbar .nav-item.dropdown:hover > .dropdown-menu {
                display: block;
                opacity: 1;
                transform: translateY(0);
                margin-top: 0;
            }

            .topbar-custom .dropdown-menu {
                display: none;
                opacity: 0;
                transform: translateY(10px);
                transition: all .25s ease-in-out;
            }

            .topbar-custom .navbar-collapse {
                display: flex !important;
                align-items: center;
            }
        }

        /* Tablet / notebook */
        @media (max-width: 1199.98px) {
            .app-body {
                flex-direction: column;
            }

            .app-sidebar-menu {
                width: 100%;
                flex: 0 0 auto;
                min-height: auto;
                border-right: 0;
                border-bottom: 1px solid #dee2e6;
            }

            #side-menu > li > a {
                margin-left: 8px;
                margin-right: 8px;
            }

            #side-menu .nav-second-level li a {
                padding-left: 46px;
                margin-left: 8px;
                margin-right: 8px;
            }

            .topbar-custom .navbar {
                min-height: auto;
            }

            .topbar-custom .navbar-toggler {
                margin-left: auto;
            }

            .topbar-custom .navbar-collapse {
                padding-top: .85rem;
            }

            .topbar-custom .navbar-nav {
                align-items: stretch !important;
            }

            .topbar-custom .nav-item {
                width: 100%;
            }

            .topbar-custom .nav-link,
            .topbar-custom .dropdown-toggle {
                display: flex;
                align-items: center;
                justify-content: flex-start;
                width: 100%;
                padding-top: .65rem;
                padding-bottom: .65rem;
            }

            .topbar-custom .dropdown-menu {
                position: static !important;
                transform: none !important;
                width: 100%;
                min-width: 100%;
                margin-top: .25rem;
                border: 1px solid #dee2e6;
                border-radius: .5rem;
                box-shadow: none !important;
                display: none;
                opacity: 1;
            }

            .topbar-custom .dropdown-menu.show {
                display: block;
            }

            .content-page {
                padding: .75rem 1rem 1.25rem 1rem;
            }
        }

        /* Mobile */
        @media (max-width: 767.98px) {
            :root{
                --topbar-height: 64px;
            }

            body {
                font-size: 14px;
            }

            .topbar-custom .container-fluid,
            .topbar-custom .container-xxl {
                padding-left: .75rem;
                padding-right: .75rem;
            }

            .topbar-custom .nav-link {
                font-size: .95rem;
            }

            .profile-avatar {
                width: 36px;
                height: 36px;
            }

            .content-page {
                padding: .65rem .75rem 1rem .75rem;
            }

            .card {
                border-radius: 12px;
            }

            table td, table th {
                font-size: 13px;
            }

            .page-header-compact {
                margin-bottom: .75rem;
            }
        }
 
    </style>
</head>

<body data-menu-color="light" data-sidebar="default">

    <div id="app-layout">

        {{-- HEADER --}}
        @include('admin_client.body.client_header')

        {{-- BODY --}}
        <div class="app-body">

            {{-- SIDEBAR --}}
            @include('admin_client.body.client_sidebar')

            {{-- OVERLAY (สำคัญมาก) --}}
            <div class="sidebar-overlay"></div>

            {{-- CONTENT --}}
            <main class="content-page main-content">
                <div class="content-shell">
                    <div class="content-scroll-x">
                        @yield('content')
                    </div>
                </div>

                {{-- FOOTER --}}
                @include('admin_client.body.client_footer')
            </main>

        </div>
    </div>

    <!-- Vendor JS -->
    <script src="{{ asset('backend/assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/waypoints/lib/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/jquery.counterup/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/feather-icons/feather.min.js') }}"></script>

    <!-- Apexcharts -->
    <script src="{{ asset('backend/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="https://apexcharts.com/samples/assets/stock-prices.js"></script>

    <!-- Dashboard Init -->
    <script src="{{ asset('backend/assets/js/pages/analytics-dashboard.init.js') }}"></script>

    <!-- App JS -->
    <script src="{{ asset('backend/assets/js/app.js') }}"></script>

    <!-- Datatables JS -->
    <script src="{{ asset('backend/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/pages/datatable.init.js') }}"></script>

    <!-- DataTables ภาษาไทย -->
    <script>
        $(function() {
            $.extend(true, $.fn.dataTable.defaults, {
                responsive: true,
                destroy: true,
                autoWidth: false,
                language: {
                    search: "ค้นหา:",
                    lengthMenu: "แสดง _MENU_ รายการต่อหน้า",
                    info: "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                    infoEmpty: "ไม่มีข้อมูลให้แสดง",
                    infoFiltered: "(กรองจากทั้งหมด _MAX_ รายการ)",
                    zeroRecords: "ไม่พบข้อมูลที่ค้นหา",
                    paginate: {
                        first: "หน้าแรก",
                        last: "หน้าสุดท้าย",
                        next: "ถัดไป",
                        previous: "ก่อนหน้า"
                    }
                }
            });

            $('table[id^="datatable"]').each(function() {
                const $table = $(this);
                if ($.fn.dataTable.isDataTable($table)) {
                    $table.DataTable().destroy();
                }
                $table.DataTable();
            });
        });
    </script>

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="{{ asset('backend/assets/js/code.js') }}"></script>

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Datepicker JS + Thai locale -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.th.min.js"></script>

    <!-- Init Datepicker Thai -->
    <script>
        $(function() {
            $('.datepicker-th').datepicker({
                format: 'dd/mm/yyyy',
                language: 'th',
                thaiyear: true,
                autoclose: true,
                todayHighlight: true
            }).on('show', function() {
                setTimeout(function() {
                    $('.datepicker-switch').each(function() {
                        const text = $(this).text();
                        const match = text.match(/(\d{4})$/);
                        if (match) {
                            const year = parseInt(match[1], 10);
                            if (year < 2500) {
                                $(this).text(text.replace(year, year + 543));
                            }
                        }
                    });

                    $('.datepicker-years .year').each(function() {
                        const year = parseInt($(this).text(), 10);
                        if (year < 2500) {
                            $(this).text(year + 543);
                        }
                    });
                }, 10);
            });
        });
    </script>

    <!-- ฟังก์ชันยืนยันการลบ -->
    <script>
        window.confirmDelete = function(formId, message = 'คุณต้องการลบข้อมูลนี้ใช่หรือไม่') {
            Swal.fire({
                title: 'ท่านแน่ใจ ?',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'ตกลง',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        };
    </script>

    <!-- Toastr Alert -->
    <script>
        @if(Session::has('message'))
            var type = "{{ Session::get('alert-type','info') }}";
            switch(type){
                case 'info': toastr.info("{{ Session::get('message') }}"); break;
                case 'success': toastr.success("{{ Session::get('message') }}"); break;
                case 'warning': toastr.warning("{{ Session::get('message') }}"); break;
                case 'error': toastr.error("{{ Session::get('message') }}"); break;
            }
        @endif
    </script>

    <!-- Feather icon refresh -->
    <script>
        $(function () {
            if (window.feather) {
                feather.replace();
            }
        });
    </script>

    <!-- Footer -->
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const footerYear = document.getElementById('footer-year');
        if (footerYear) {
            footerYear.textContent = new Date().getFullYear();
        }
    });
</script>

    @stack('scripts')


    <script>
    document.addEventListener('DOMContentLoaded', function () {

    const toggleBtn = document.querySelector('.button-toggle-menu');
    const overlay = document.querySelector('.sidebar-overlay');

    toggleBtn?.addEventListener('click', function () {
        document.body.classList.toggle('sidebar-open');
    });

    overlay?.addEventListener('click', function () {
        document.body.classList.remove('sidebar-open');
    });

});
</script>
</body>
</html>