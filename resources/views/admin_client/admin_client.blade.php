<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Dashboard | Admin Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc." />
    <meta name="author" content="Zoyothemes" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
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

<!-- ✅ Datepicker CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet">

<!-- ✅ Google Fonts (Kanit) -->
<link href="https://fonts.googleapis.com/css2?family=Kanit:wght@400;500;600&display=swap" rel="stylesheet">


<!-- ✅ Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
   body {
    font-family: 'Kanit', sans-serif;
    font-size: 15px;
    line-height: 1.6;
    color: #212529;
}
h1, h2, h3, .card-header, .navbar-brand {
    font-weight: 300;
}
table td, table th {
    font-size: 14px;
    vertical-align: middle;
}
.btn {
    font-weight: 400;
    letter-spacing: 0.5px;
}
.form-control {
    color: #6c757d;
}
.form-control::placeholder {
    color: #adb5bd;
    opacity: 1;
}

/* ปรับตัวอักษรในตาราง DataTable ให้เล็กลง */
table.dataTable td,
table.dataTable th {
    font-size: 12px;
}

/* ปรับตัวอักษรในส่วน control เช่น search, pagination */
.dataTables_wrapper .dataTables_info,
.dataTables_wrapper .dataTables_length,
.dataTables_wrapper .dataTables_filter,
.dataTables_wrapper .dataTables_paginate {
    font-size: 12px;
}

/* เมนูหลัก */
.topbar-custom {
    background: #e3f2fd; /* ฟ้าอ่อน */
    border-bottom: 1px solid #90caf9;
}

/* เมนูหลัก */
.topbar-custom .nav-link {
    color: #0d47a1 !important; /* น้ำเงินเข้ม */
    font-weight: 500;
    transition: all 0.2s ease;
    padding: 0.5rem 1rem;
    border-radius: 0.25rem;
}

/* dropdown */
.dropdown-menu {
    display: none; /* ซ่อนค่าเริ่มต้น */
    position: absolute; /* ยึดตำแหน่งจาก parent */
    top: 100%; /* แสดงใต้ปุ่ม */
    left: 0; /* ค่าเริ่มต้นชิดซ้าย */
    background-color: #fff;
    border-radius: 0.5rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    min-width: 200px;
    opacity: 0;
    transform: translateY(10px);
    transition: all 0.25s ease-in-out;
    z-index: 1050; /* ป้องกันโดน element อื่นทับ */
}
/* สำหรับ dropdown ที่ต้องการชิดขวา */
.dropdown-menu-end {
    right: 0;
    left: auto;
}

.dropdown-item {
    color: #333;
    transition: all 0.2s ease;
    padding: 0.5rem 1rem;
}
.dropdown-item:hover {
    background-color: #e9f2ff;
    color: #0d6efd;
}

/* โปรไฟล์ด้านขวา */
.nav-user .pro-user-name {
    color: #333 !important;
    font-weight: 500;
}
.nav-user img {
    border: 2px solid #0d6efd;
}

/* ให้ dropdown แสดงเมื่อ hover บน desktop */
@media (min-width: 992px) {
    .navbar .nav-item.dropdown:hover .dropdown-menu {
        display: block;
        margin-top: 0;
    }
}

/* effect fade-in + slide */
.nav-item.dropdown:hover > .dropdown-menu,
.show > .dropdown-menu {
    display: block;
    opacity: 1;
    transform: translateY(0);
}

/* Active Menu */
.topbar-custom .nav-link.active,
.topbar-custom .dropdown-item.active {
    color: #0d6efd !important;
    background-color: #f4f5f7;
    font-weight: 200;
    text-decoration: none; /* ✅ ไม่ขีดเส้นใต้ */
}


/* Sidebar */
.sidebar {
    background-color: #f8f9fa; /* เทาอ่อน */
    border-right: 1px solid #dee2e6;
    min-height: 100vh;
    padding-top: 1rem;
}

.sidebar .nav-link {
    color: #495057;
    font-weight: 500;
    padding: 0.75rem 1rem;
    border-radius: 0.25rem;
}

.sidebar .nav-link:hover {
    background-color: #e3f2fd;
    color: #0d47a1;
}

.sidebar .nav-link.active {
    background-color: #0d6efd;
    color: #fff !important;
}

/* Content */
.content-page {
    padding: 3rem;
    background-color: #ffffff;
    min-height: calc(100vh - 60px); /* ลบความสูง header */
    margin-top: 60px; /* ✅ เว้นระยะจาก header */
}




</style>
</head>

<body data-menu-color="light" data-sidebar="default">
    <div id="app-layout">
        @include('admin_client.body.client_header')   <!-- Header -->
        @include('admin_client.body.client_sidebar')  <!-- Sidebar -->

        <div class="content-page">
            @yield('content')                         <!-- Content -->
            @include('admin_client.body.client_footer')<!-- Footer -->
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

<!-- ✅ DataTables ภาษาไทย (Global) -->
<script>
$(function() {
    $.extend(true, $.fn.dataTable.defaults, {
        responsive: true,
        destroy: true,
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
        if (!$.fn.dataTable.isDataTable($table)) {
            $table.DataTable();
        } else {
            $table.DataTable().destroy();
            $table.DataTable();
        }
    });
});
</script>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="{{ asset('backend/assets/js/code.js') }}"></script>

<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<!-- ✅ Datepicker JS + Thai locale -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.th.min.js"></script>

<!-- ✅ Init Datepicker Thai -->
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
                    const year = parseInt(match[1]);
                    if (year < 2500) {
                        $(this).text(text.replace(year, year + 543));
                    }
                }
            });
            $('.datepicker-years .year').each(function() {
                const year = parseInt($(this).text());
                if (year < 2500) {
                    $(this).text(year + 543);
                }
            });
        }, 10);
    });
});
</script>

<!-- ✅ ฟังก์ชันกลางสำหรับยืนยันการลบ -->
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
            cancelButtonText: 'ยกเลิก',
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

<!-- ✅ จุดสำคัญ: ให้ Blade ลูกสามารถ push script ได้ -->
@stack('scripts')

<!-- JS สำหรับ hover dropdown -->

</body>
</html>