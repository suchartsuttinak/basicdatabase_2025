@php
    $clientId = $client->id ?? null;

    $isProfileOpen =
        Request::routeIs('client.show') ||
        Request::routeIs('client.report') ||
        Request::routeIs('issues.index');

    $isProcessOpen =
        Request::routeIs('factfinding.*') ||
        Request::routeIs('family.*') ||
        Request::routeIs('visitFamily.*') ||
        Request::routeIs('member.*') ||
        Request::routeIs('estimate.*') ||
        Request::routeIs('client_files.*');

    $isEducationOpen =
        Request::routeIs('education_record_*') ||
        Request::routeIs('school_followup_*') ||
        Request::routeIs('absent.*');

    $isHealthOpen =
        Request::routeIs('accident.*') ||
        Request::routeIs('check_body.*') ||
        Request::routeIs('medical.*') ||
        Request::routeIs('vaccine.*') ||
        Request::routeIs('psychiatric.*') ||
        Request::routeIs('addictive.*');

    $isBehaviorOpen =
        Request::routeIs('observe.*') ||
        Request::routeIs('escape.*');

    $isSocialOpen =
        Request::routeIs('case_outside.*') ||
        Request::routeIs('refers.*') ||
        Request::routeIs('job_agencies.*') ||
        Request::routeIs('help_sessions.*');
@endphp

<div class="app-sidebar-menu">
    <div class="h-100" data-simplebar>
        <div id="sidebar-menu">

            <ul id="side-menu" class="metismenu list-unstyled pt-2">

                <li class="menu-title">ทะเบียนประวัติ</li>

                <li>
                    <a href="#sidebarProfile"
                       data-bs-toggle="collapse"
                       aria-expanded="{{ $isProfileOpen ? 'true' : 'false' }}"
                       class="{{ $isProfileOpen ? 'active' : '' }}">
                        <i data-feather="home"></i>
                        <span> บันทึกข้อมูลแรกเข้า </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse {{ $isProfileOpen ? 'show' : '' }}" id="sidebarProfile">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('client.show') }}"
                                   class="tp-link {{ Request::routeIs('client.show') ? 'active' : '' }}">
                                    ทะเบียนผู้รับ
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('client.report', $clientId) }}"
                                   class="tp-link {{ Request::routeIs('client.report') ? 'active' : '' }}">
                                    รายงานผู้รับบริการ
                                </a>
                            </li>
                         
                        </ul>
                    </div>
                </li>

                <li class="menu-title">กระบวนการ</li>

                <li>
                    <a href="#sidebarProcess"
                       data-bs-toggle="collapse"
                       aria-expanded="{{ $isProcessOpen ? 'true' : 'false' }}"
                       class="{{ $isProcessOpen ? 'active' : '' }}">
                        <i data-feather="users"></i>
                        <span> ข้อมูลผู้ใช้ </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse {{ $isProcessOpen ? 'show' : '' }}" id="sidebarProcess">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('factfinding.add', $clientId) }}"
                                   class="tp-link {{ Request::routeIs('factfinding.*') ? 'active' : '' }}">
                                    สอบข้อเท็จจริง
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('family.add', $clientId) }}"
                                   class="tp-link {{ Request::routeIs('family.*') ? 'active' : '' }}">
                                    บันทึกครอบครัว
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('visitFamily.create', $clientId) }}"
                                   class="tp-link {{ Request::routeIs('visitFamily.*') ? 'active' : '' }}">
                                    เยี่ยมครอบครัว
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('member.create', $clientId) }}"
                                   class="tp-link {{ Request::routeIs('member.*') ? 'active' : '' }}">
                                    บันทึกสมาชิกครอบครัว
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('estimate.show', $clientId) }}"
                                   class="tp-link {{ Request::routeIs('estimate.*') ? 'active' : '' }}">
                                    ประเมินครอบครัว
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('client_files.index', $clientId) }}"
                                   class="tp-link {{ Request::routeIs('client_files.*') ? 'active' : '' }}">
                                    รายการไฟล์เอกสาร
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#sidebarEducation"
                       data-bs-toggle="collapse"
                       aria-expanded="{{ $isEducationOpen ? 'true' : 'false' }}"
                       class="{{ $isEducationOpen ? 'active' : '' }}">
                        <i class="fas fa-graduation-cap sidebar-fa-icon"></i>
                        <span> ข้อมูลการศึกษา </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse {{ $isEducationOpen ? 'show' : '' }}" id="sidebarEducation">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('education_record_add', ['client_id' => $clientId]) }}"
                                   class="tp-link {{ Request::routeIs('education_record_add') ? 'active' : '' }}">
                                    บันทึกผลการเรียน
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('education_record_show', $clientId) }}"
                                   class="tp-link {{ Request::routeIs('education_record_show') ? 'active' : '' }}">
                                    แสดงผลการเรียน
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('school_followup_add', $clientId) }}"
                                   class="tp-link {{ Request::routeIs('school_followup_*') ? 'active' : '' }}">
                                    ติดตามการศึกษา
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('absent.add', $clientId) }}"
                                   class="tp-link {{ Request::routeIs('absent.*') ? 'active' : '' }}">
                                    บันทึกการขาดเรียน
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#sidebarHealth"
                       data-bs-toggle="collapse"
                       aria-expanded="{{ $isHealthOpen ? 'true' : 'false' }}"
                       class="{{ $isHealthOpen ? 'active' : '' }}">
                        <i class="fas fa-heartbeat sidebar-fa-icon"></i>
                        <span> ข้อมูลสุขภาพ </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse {{ $isHealthOpen ? 'show' : '' }}" id="sidebarHealth">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('accident.add', $clientId) }}"
                                   class="tp-link {{ Request::routeIs('accident.*') ? 'active' : '' }}">
                                    บันทึกการบาดเจ็บ
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('check_body.add', $clientId) }}"
                                   class="tp-link {{ Request::routeIs('check_body.*') ? 'active' : '' }}">
                                    ตรวจสุขภาพเบื้องต้น
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('medical.add', $clientId) }}"
                                   class="tp-link {{ Request::routeIs('medical.*') ? 'active' : '' }}">
                                    การรักษาพยาบาล
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('vaccine.index', $clientId) }}"
                                   class="tp-link {{ Request::routeIs('vaccine.*') ? 'active' : '' }}">
                                    ประวัติการรับวัคซีน
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('psychiatric.create', $clientId) }}"
                                   class="tp-link {{ Request::routeIs('psychiatric.*') ? 'active' : '' }}">
                                    การวินิจฉัยทางจิตเวช
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('addictive.create', $clientId) }}"
                                   class="tp-link {{ Request::routeIs('addictive.*') ? 'active' : '' }}">
                                    การตรวจสารเสพติด
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="menu-title mt-2">ข้อมูลด้านพฤติกรรม</li>

                <li>
                    <a href="#sidebarBehavior"
                       data-bs-toggle="collapse"
                       aria-expanded="{{ $isBehaviorOpen ? 'true' : 'false' }}"
                       class="{{ $isBehaviorOpen ? 'active' : '' }}">
                        <i data-feather="package"></i>
                        <span> ข้อมูลด้านพฤติกรรม </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse {{ $isBehaviorOpen ? 'show' : '' }}" id="sidebarBehavior">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('observe.create', $clientId) }}"
                                   class="tp-link {{ Request::routeIs('observe.*') ? 'active' : '' }}">
                                    บันทึกพฤติกรรม
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('escape.index', $clientId) }}"
                                   class="tp-link {{ Request::routeIs('escape.*') ? 'active' : '' }}">
                                    หนีออกจากบ้าน
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="menu-title mt-2">ข้อมูลด้านสังคม</li>

                <li>
                    <a href="#sidebarSocial"
                       data-bs-toggle="collapse"
                       aria-expanded="{{ $isSocialOpen ? 'true' : 'false' }}"
                       class="{{ $isSocialOpen ? 'active' : '' }}">
                        <i class="fas fa-users sidebar-fa-icon"></i>
                        <span> สังคมสงเคราะห์ </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse {{ $isSocialOpen ? 'show' : '' }}" id="sidebarSocial">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('case_outside.show', $clientId) }}"
                                   class="tp-link {{ Request::routeIs('case_outside.*') ? 'active' : '' }}">
                                    ติดตามเด็กที่อยู่ภายนอก
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('refers.index', $clientId) }}"
                                   class="tp-link {{ Request::routeIs('refers.*') ? 'active' : '' }}">
                                    รายการการจำหน่าย
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('job_agencies.show', $clientId) }}"
                                   class="tp-link {{ Request::routeIs('job_agencies.*') ? 'active' : '' }}">
                                    หางานให้ผู้รับบริการ
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('help_sessions.show', $clientId) }}"
                                   class="tp-link {{ Request::routeIs('help_sessions.*') ? 'active' : '' }}">
                                    รายการการช่วยเหลือ
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

            </ul>
        </div>
    </div>
</div>