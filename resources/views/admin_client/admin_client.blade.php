<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="utf-8" />
    <title>@yield('title', 'ระบบข้อมูลผู้รับบริการ')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="ระบบฐานข้อมูลผู้รับบริการ" />
    <meta name="author" content="Zoyothemes" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link rel="shortcut icon" href="{{ asset('backend/assets/images/favicon.ico') }}">

    <link href="{{ asset('backend/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />
    <link href="{{ asset('backend/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">

    <link href="{{ asset('backend/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/assets/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/assets/libs/datatables.net-keytable-bs5/css/keyTable.bootstrap5.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/assets/libs/datatables.net-select-bs5/css/select.bootstrap5.min.css') }}" rel="stylesheet" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    @stack('styles')

    <style>
        :root{
            --topbar-height: 72px;
            --sidebar-width: 260px;

            --topbar-offset: 12px; /* ยิ่งมาก content ยิ่งถูกดันขึ้น */
            --content-top-padding: .12rem;
            --content-top-padding-lg: .18rem;
            --content-top-padding-sm: .08rem;

            --topbar-bg: rgba(255,255,255,.92);
            --topbar-border: #e6edf5;
            --topbar-text: #1f3b64;
            --topbar-muted: #6b7280;
            --topbar-hover: #eef5ff;
            --topbar-active-bg: #e8f1ff;
            --topbar-active-text: #2563eb;
            --topbar-shadow: 0 6px 20px rgba(15, 23, 42, 0.06);

            --content-bg: #f8fafc;
            --card-border: #e9ecef;
            --shadow-soft: 0 6px 18px rgba(15, 23, 42, .04);
            --radius-lg: 16px;
            --radius-md: 12px;
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
            padding-top: calc(var(--topbar-height) - var(--topbar-offset));
        }

        h1, h2, h3, h4, h5, .card-header, .navbar-brand {
            font-weight: 500;
        }

        table td, table th {
            font-size: 14px;
            vertical-align: middle;
        }

        .btn {
            font-weight: 500;
            letter-spacing: .15px;
        }

        .form-control,
        .form-select {
            color: #495057;
            border-radius: 12px;
            min-height: 42px;
        }

        .form-control::placeholder {
            color: #adb5bd;
            opacity: 1;
        }

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

        #app-layout {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .app-body {
            display: flex;
            min-height: calc(100vh - var(--topbar-height) + var(--topbar-offset));
        }

        .app-sidebar-menu {
            width: var(--sidebar-width);
            flex: 0 0 var(--sidebar-width);
            background: #f8f9fa;
            border-right: 1px solid #dee2e6;
            min-height: calc(100vh - var(--topbar-height) + var(--topbar-offset));
        }

        .content-page {
            flex: 1 1 auto;
            min-width: 0;
            position: relative;
            background-color: var(--content-bg);
            min-height: calc(100vh - var(--topbar-height) + var(--topbar-offset));
            overflow-x: hidden;
            padding: var(--content-top-padding) 1.25rem 1.5rem 1.25rem !important;
        }

        .content-page > .content,
        .page-content,
        .main-content,
        .content-shell {
            max-width: 100%;
        }

        .content-shell,
        .content-scroll-x {
            margin-top: 0 !important;
            padding-top: 0 !important;
        }

        .content-scroll-x {
            width: 100%;
            overflow-x: auto;
            overflow-y: visible;
            -webkit-overflow-scrolling: touch;
        }

        .content-page > :first-child,
        .content-page > .content-shell:first-child,
        .content-page > .content-shell > .content-scroll-x:first-child,
        .content-page > .content-shell > .content-scroll-x > :first-child,
        .content-page .container:first-child,
        .content-page .container-fluid:first-child,
        .content-page .row:first-child,
        .content-page .card:first-child,
        .content-page section:first-child,
        .content-page article:first-child,
        .content-page form:first-child,
        .content-page .page-header-compact:first-child {
            margin-top: 0 !important;
            padding-top: 0 !important;
        }

        .content-page .container-fluid.mt-1,
        .content-page .container-fluid.mt-2,
        .content-page .container-fluid.mt-3,
        .content-page .container.mt-1,
        .content-page .container.mt-2,
        .content-page .container.mt-3,
        .content-page .row.mt-1,
        .content-page .row.mt-2,
        .content-page .row.mt-3,
        .content-page .card.mt-1,
        .content-page .card.mt-2,
        .content-page .card.mt-3 {
            margin-top: 0 !important;
        }

        .table-wrap {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table-wrap table {
            min-width: 900px;
        }

        .form-wrap-wide {
            width: 100%;
            overflow-x: auto;
            padding-bottom: .5rem;
        }

        .card {
            border: 1px solid var(--card-border);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-soft);
        }

        .card-header {
            background: #fff;
            border-bottom: 1px solid #eef1f4;
        }

        .app-topbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1100;
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

        .topbar-dropdown {
            min-width: 235px;
            padding: .45rem;
            border: 1px solid #e8edf3;
            border-radius: 14px;
            box-shadow: 0 14px 30px rgba(15, 23, 42, 0.10);
            z-index: 1200;
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

        @media (min-width: 1200px) {
            .topbar-menu .dropdown:hover > .topbar-dropdown {
                display: block;
                margin-top: 0;
            }

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

            .content-page {
                padding-top: var(--content-top-padding-lg) !important;
            }
        }

        @media (max-width: 1199.98px) {
            :root{
                --topbar-offset: 10px;
            }

            .app-body {
                flex-direction: row !important;
            }

            .app-sidebar-menu {
                position: fixed;
                top: calc(var(--topbar-height) - var(--topbar-offset));
                left: 0;
                width: 260px;
                height: calc(100vh - var(--topbar-height) + var(--topbar-offset));
                background: #fff;
                z-index: 1090;
                transform: translateX(-100%);
                transition: transform .25s ease, visibility .25s ease;
                box-shadow: 2px 0 12px rgba(0,0,0,.08);
                border-right: 1px solid #dee2e6;
                border-bottom: 0;
                overflow-y: auto;
                -webkit-overflow-scrolling: touch;
                visibility: hidden;
                pointer-events: none;
            }

            body.sidebar-open .app-sidebar-menu {
                transform: translateX(0);
                visibility: visible;
                pointer-events: auto;
            }

            .sidebar-overlay {
                position: fixed;
                top: calc(var(--topbar-height) - var(--topbar-offset));
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0,0,0,.35);
                z-index: 1085;
                opacity: 0;
                visibility: hidden;
                transition: .25s ease;
            }

            body.sidebar-open .sidebar-overlay {
                opacity: 1;
                visibility: visible;
            }

            .content-page {
                width: 100%;
                margin-left: 0 !important;
                padding: .1rem 1rem 1.25rem 1rem !important;
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

            .topbar-navbar {
                min-height: auto;
            }

            .topbar-collapse {
                padding-top: .85rem;
                max-height: calc(100vh - var(--topbar-height) - 12px);
                overflow-y: auto;
                -webkit-overflow-scrolling: touch;
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

        @media (max-width: 767.98px) {
            :root{
                --topbar-height: 64px;
                --topbar-offset: 8px;
            }

            body {
                font-size: 14px;
            }

            .topbar-brand-text {
                font-size: 14px;
            }

            .topbar-link {
                font-size: .95rem;
                padding: .65rem .8rem !important;
            }

            .topbar-user-avatar,
            .profile-avatar {
                width: 38px;
                height: 38px;
            }

            .topbar-dropdown .dropdown-item {
                font-size: 13.5px;
            }

            .topbar-custom .container-fluid,
            .topbar-custom .container-xxl {
                padding-left: .75rem;
                padding-right: .75rem;
            }

            .content-page {
                padding: var(--content-top-padding-sm) .75rem 1rem .75rem !important;
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

            .app-footer {
                margin-top: 1rem;
                padding-top: .75rem;
            }

            .app-footer .footer-text {
                font-size: 12px;
            }
        }
        
    </style>
</head>

<body data-menu-color="light" data-sidebar="default">

    <div id="app-layout">

        @include('admin_client.body.client_header')

        <div class="app-body">

            @include('admin_client.body.client_sidebar')

            <div class="sidebar-overlay"></div>

            <main class="content-page main-content">
                <div class="content-shell">
                    <div class="content-scroll-x">
                        @yield('content')
                    </div>
                </div>

                @include('admin_client.body.client_footer')
            </main>

        </div>
    </div>

    <script src="{{ asset('backend/assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/waypoints/lib/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/jquery.counterup/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/feather-icons/feather.min.js') }}"></script>

    <script src="{{ asset('backend/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="https://apexcharts.com/samples/assets/stock-prices.js"></script>

    <script src="{{ asset('backend/assets/js/pages/analytics-dashboard.init.js') }}"></script>
    <script src="{{ asset('backend/assets/js/app.js') }}"></script>

    <script src="{{ asset('backend/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/pages/datatable.init.js') }}"></script>

    <script>
        $(function() {
            $.extend(true, $.fn.dataTable.defaults, {
                responsive: false,
                destroy: true,
                autoWidth: false,
                scrollX: true,
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

            $('table[id^="datatable"], table.data-table-auto').each(function() {
                const $table = $(this);
                if ($.fn.dataTable.isDataTable(this)) {
                    $table.DataTable().destroy();
                }
                $table.DataTable();
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="{{ asset('backend/assets/js/code.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.th.min.js"></script>

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

    <script>
        $(function () {
            if (window.feather) {
                feather.replace();
            }
        });
    </script>

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
            const toggleBtns = document.querySelectorAll('.button-toggle-menu');
            const overlay = document.querySelector('.sidebar-overlay');
            const topbar = document.getElementById('appTopbar') || document.querySelector('.app-topbar');
            const navbarCollapse = document.getElementById('navbarSupportedContent');

            function syncTopbarHeight() {
                if (!topbar) return;

                const height = topbar.offsetHeight || 72;
                const rootStyle = getComputedStyle(document.documentElement);
                const offset = parseInt(rootStyle.getPropertyValue('--topbar-offset')) || 0;
                const safePadding = Math.max(height - offset, 52);

                document.documentElement.style.setProperty('--topbar-height', height + 'px');
                document.body.style.paddingTop = safePadding + 'px';
            }

            syncTopbarHeight();

            toggleBtns.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    if (window.innerWidth < 1200) {
                        document.body.classList.toggle('sidebar-open');
                    }
                });
            });

            overlay?.addEventListener('click', function () {
                document.body.classList.remove('sidebar-open');
            });

            window.addEventListener('resize', function () {
                syncTopbarHeight();
                if (window.innerWidth >= 1200) {
                    document.body.classList.remove('sidebar-open');
                }
            });

            if (navbarCollapse) {
                navbarCollapse.addEventListener('shown.bs.collapse', syncTopbarHeight);
                navbarCollapse.addEventListener('hidden.bs.collapse', syncTopbarHeight);
            }
        });
    </script>
</body>
</html>