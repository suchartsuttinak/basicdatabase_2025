<div class="app-sidebar-menu">
    <div class="h-100" data-simplebar>

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <div class="logo-box">
                <a href="index.html" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="assets/images/logo-sm.png" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="assets/images/logo-light.png" alt="" height="24">
                    </span>
                </a>
                <a href="index.html" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="assets/images/logo-sm.png" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="assets/images/logo-dark.png" alt="" height="24">
                    </span>
                </a>
            </div>

            <ul id="side-menu">
                <h1 class="text-danger text-center">{{ $client->id }}</h1>

                <li class="menu-title">ทะเบียนประวัติ</li>

                <li>
                    <a href="#sidebarDashboards" data-bs-toggle="collapse">
                        <i data-feather="home"></i
                        <span> บันทึกข้อมูลแรกเข้า </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarDashboards">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('client.show') }}" class="tp-link">ทะเบียนผู้รับ</a>
                            </li>
                            <li>
                                 <a href="{{ route('client.report', $client->id) }}" class="tp-link">
                                    รายงานการช่วยเหลือ 
                                </a>
                            </li>
                           
                        </ul>
                    </div>
                </li>

                <li class="menu-title">กระบวนการ</li>

               <li>
                        <a href="#sidebarAuth" data-bs-toggle="collapse"
                        class="{{ Request::is('institution*') || Request::is('factfinding*') || Request::is('family*') ? 'active' : '' }}">
                            <i data-feather="users"></i>
                            <span> ข้อมูลผู้ใช้ </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse {{ Request::is('institution*') || Request::is('factfinding*') || Request::is('family*') ? 'show' : '' }}" id="sidebarAuth">
                            <ul class="nav-second-level">
                                <li>
                                    <a href="{{ route('institution.all') }}" class="tp-link">รายการสถานศึกษา</a>
                                </li>
                                <li>
                                    <a href="{{ route('factfinding.add', $client->id) }}" class="tp-link">สอบข้อเท็จจริง</a>
                                </li>
                                <li>
                                    <a href="{{ route('family.add', $client->id) }}" class="tp-link">บันทึกครอบครัว</a>
                                </li>
                            </ul>
                        </div>
                    </li>
               <li>
                    <a href="#sidebareducationRecord" data-bs-toggle="collapse"
                    class="{{ Request::is('education_record*') || Request::is('school_followup*') || Request::is('absent*') ? 'active' : '' }}">
                        <i data-feather="alert-octagon"></i>
                        <span> ข้อมูลการศึกษา </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse {{ Request::is('education_record*') || Request::is('school_followup*') || Request::is('absent*') ? 'show' : '' }}" id="sidebareducationRecord">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('education_record_add', ['client_id' => $client->id]) }}" class="tp-link">บันทึกผลการเรียน</a>
                            </li>
                            <li>
                                <a href="{{ route('education_record_show', $client->id) }}" class="tp-link">แสดงผลการเรียน</a>
                            </li>
                            <li>
                                <a href="{{ route('school_followup_add', $client->id) }}" class="tp-link">ติดตามการศึกษา</a>
                            </li>
                            <li>
                                <a href="{{ route('absent.add', $client->id) }}" class="tp-link">บันทึกการขาดเรียน</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#sidebaraccident" data-bs-toggle="collapse"
                    class="{{ Request::is('accident*') || Request::is('check_body*') || Request::is('medical*') || Request::is('vaccine*') || Request::is('psychiatric*') || Request::is('addictive*') ? 'active' : '' }}">
                        <i data-feather="file-text"></i>
                        <span> ข้อมูลสุขภาพ </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse {{ Request::is('accident*') || Request::is('check_body*') || Request::is('medical*') || Request::is('vaccine*') || Request::is('psychiatric*') || Request::is('addictive*') ? 'show' : '' }}" id="sidebaraccident">
                        <ul class="nav-second-level">
                            <li><a href="{{ route('accident.add', $client->id) }}" class="tp-link">บันทึกการบาดเจ็บ</a></li>
                            <li><a href="{{ route('check_body.add', $client->id) }}" class="tp-link">ตรวจสุขภาพเบื้องต้น</a></li>
                            <li><a href="{{ route('medical.add', $client->id) }}" class="tp-link">การรักษาพยาบาล</a></li>
                            <li><a href="{{ route('vaccine.index', $client->id) }}" class="tp-link">ประวัติการรับวัคซีน</a></li>
                            <li><a href="{{ route('psychiatric.create', $client->id) }}" class="tp-link">การวินิจฉัยทางจิตเวช</a></li>
                            <li><a href="{{ route('addictive.create', $client->id) }}" class="tp-link">การตรวจสารเสพติด</a></li>
                        </ul>
                    </div>
                </li>


                <li class="menu-title mt-2">General</li>

                <li>
                    <a href="#sidebarBaseui" data-bs-toggle="collapse">
                        <i data-feather="package"></i>
                        <span> ข้อมูลด้านพฤติกรรม </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarBaseui">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('observe.create', $client->id) }}" class="tp-link">บันทึกพฤติกรรม</a>
                            </li>
                            <li>
                                <a href="ui-alerts.html" class="tp-link">Alerts</a>
                            </li>
                            <li>
                                <a href="ui-badges.html" class="tp-link">Badges</a>
                            </li>
                            <li>
                                <a href="ui-breadcrumb.html" class="tp-link">Breadcrumb</a>
                            </li>
                                                 
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="widgets.html" class="tp-link">
                        <i data-feather="aperture"></i>
                        <span> Widgets </span>
                    </a>
                </li>

                <li>
                    <a href="#sidebarAdvancedUI" data-bs-toggle="collapse">
                        <i data-feather="cpu"></i>
                        <span> Extended UI </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarAdvancedUI">
                        <ul class="nav-second-level">
                            <li>
                                <a href="extended-carousel.html" class="tp-link">Carousel</a>
                            </li>
                            <li>
                                <a href="extended-notifications.html" class="tp-link">Notifications</a>
                            </li>
                            <li>
                                <a href="extended-offcanvas.html" class="tp-link">Offcanvas</a>
                            </li>
                            <li>
                                <a href="extended-range-slider.html" class="tp-link">Range Slider</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#sidebarIcons" data-bs-toggle="collapse">
                        <i data-feather="award"></i>
                        <span> Icons </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarIcons">
                        <ul class="nav-second-level">
                            <li>
                                <a href="icons-feather.html" class="tp-link">Feather Icons</a>
                            </li>
                            <li>
                                <a href="icons-mdi.html" class="tp-link">Material Design Icons</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#sidebarForms" data-bs-toggle="collapse">
                        <i data-feather="briefcase"></i>
                        <span> Forms </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarForms">
                        <ul class="nav-second-level">
                            <li>
                                <a href="forms-elements.html" class="tp-link">General Elements</a>
                            </li>
                            <li>
                                <a href="forms-validation.html" class="tp-link">Validation</a>
                            </li>
                            <li>
                                <a href="forms-quilljs.html" class="tp-link">Quilljs Editor</a>
                            </li>
                            <li>
                                <a href="forms-pickers.html" class="tp-link">Picker</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#sidebarTables" data-bs-toggle="collapse">
                        <i data-feather="table"></i>
                        <span> Tables </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarTables">
                        <ul class="nav-second-level">
                            <li>
                                <a href="tables-basic.html" class="tp-link">Basic Tables</a>
                            </li>
                            <li>
                                <a href="tables-datatables.html" class="tp-link">Data Tables</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#sidebarCharts" data-bs-toggle="collapse">
                        <i data-feather="pie-chart"></i>
                        <span> Apex Charts </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarCharts">
                        <ul class="nav-second-level">
                            <li>
                                <a href='charts-line.html'>Line</a>
                            </li>
                            <li>
                                <a href='charts-area.html'>Area</a>
                            </li>
                            <li>
                                <a href='charts-column.html'>Column</a>
                            </li>
                            <li>
                                <a href='charts-bar.html'>Bar</a>
                            </li>
                            <li>
                                <a href='charts-mixed.html'>Mixed</a>
                            </li>
                            <li>
                                <a href='charts-timeline.html'>Timeline</a>
                            </li>
                            <li>
                                <a href='charts-rangearea.html'>Range Area</a>
                            </li>
                            <li>
                                <a href='charts-funnel.html'>Funnel</a>
                            </li>
                            <li>
                                <a href='charts-candlestick.html'>Candlestick</a>
                            </li>
                            <li>
                                <a href='charts-boxplot.html'>Boxplot</a>
                            </li>
                            <li>
                                <a href='charts-bubble.html'>Bubble</a>
                            </li>
                            <li>
                                <a href='charts-scatter.html'>Scatter</a>
                            </li>
                            <li>
                                <a href='charts-heatmap.html'>Heatmap</a>
                            </li>
                            <li>
                                <a href='charts-treemap.html'>Treemap</a>
                            </li>
                            <li>
                                <a href='charts-pie.html'>Pie</a>
                            </li>
                            <li>
                                <a href='charts-radialbar.html'>Radialbar</a>
                            </li>
                            <li>
                                <a href='charts-radar.html'>Radar</a>
                            </li>
                            <li>
                                <a href='charts-polararea.html'>Polar</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#sidebarMaps" data-bs-toggle="collapse">
                        <i data-feather="map"></i>
                        <span> Maps </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarMaps">
                        <ul class="nav-second-level">
                            <li>
                                <a href="maps-google.html" class="tp-link">Google Maps</a>
                            </li>
                            <li>
                                <a href="maps-vector.html" class="tp-link">Vector Maps</a>
                            </li>
                        </ul>
                    </div>
                </li>

            </ul>

        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
</div>
