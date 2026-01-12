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
                                <li>
                                    <a href="{{ route('visitFamily.create', $client->id) }}" class="tp-link">เยี่ยมครอบครัว</a>
                                </li>
                                <li>
                                    <a href="{{ route('member.create', $client->id) }}" class="tp-link">บันทึกสมาชิกครอบครัว</a>
                                </li>
                                <li>
                                 <a href="{{ route('estimate.show', $client->id) }}" class="tp-link">ประเมินครอบครัว</a>


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
                                <a href="{{ route('escape.index', $client->id) }}" class="tp-link">หนีออกจากบ้าน</a>
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
                    <a href="#sidebarMaps" data-bs-toggle="collapse">
                        <i data-feather="map"></i>
                        <span> สังคมสงเคราะห์ </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarMaps">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('case_outside.show', $client->id) }}" class="tp-link">ติดตามเด็กที่อยู่ภายนอก</a>
                            </li>
                            <li>
                                <a href="maps-vector.html" class="tp-link">Vector Maps</a>
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
