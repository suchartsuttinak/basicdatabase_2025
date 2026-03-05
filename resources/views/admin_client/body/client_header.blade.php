<div class="topbar-custom border-bottom bg-light">
    <div class="container-xxl">
        <nav class="navbar navbar-expand-lg navbar-light w-100">
            
            <!-- ปุ่ม toggle สำหรับมือถือ -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" 
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- เมนูหลัก -->
            <div class="collapse navbar-collapse d-flex justify-content-between align-items-center w-100" id="navbarSupportedContent">

                <!-- เมนูด้านซ้าย -->
                <ul class="navbar-nav d-flex align-items-center">
                    <li class="nav-item">
                        <button class="button-toggle-menu nav-link ps-0">
                            <i data-feather="menu" class="noti-icon"></i>
                        </button>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-home"></i> หน้าหลัก
                        </a>
                    </li>

                    <!-- ทะเบียนประวัติ -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="historyDropdown" role="button"
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-book"></i> ทะเบียนประวัติ
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="historyDropdown">
                            <li><a class="dropdown-item" href="#">ร้องเรียนทั่วไป</a></li>
                            <li><a class="dropdown-item" href="#">ร้องเรียนการศึกษา</a></li>
                            <li><a class="dropdown-item" href="#">ร้องเรียนอื่น ๆ</a></li>
                        </ul>
                    </li>

                    <!-- การศึกษา -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ Request::is('education*') ? 'active' : '' }}" 
                           href="#" id="educationDropdown" role="button"
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-graduation-cap"></i> การศึกษา
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="educationDropdown">
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

                    <!-- สุขภาพ -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="healthDropdown" role="button"
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-heartbeat"></i> สุขภาพ
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="healthDropdown">
                            <li><a class="dropdown-item" href="#">ร้องเรียนทั่วไป</a></li>
                            <li><a class="dropdown-item" href="#">ร้องเรียนการศึกษา</a></li>
                            <li><a class="dropdown-item" href="#">ร้องเรียนอื่น ๆ</a></li>
                        </ul>
                    </li>

                    <!-- สังคมสงเคราะห์ -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="socialDropdown" role="button"
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-users"></i> สังคมสงเคราะห์
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="socialDropdown">
                            <li><a class="dropdown-item" href="#">ค้นหาสถานศึกษา</a></li>
                            <li><a class="dropdown-item" href="#">ค้นหาครอบครัว</a></li>
                            <li><a class="dropdown-item" href="#">ค้นหาบุคคล</a></li>
                        </ul>
                    </li>
                </ul>

                <!-- เมนูด้านขวา (โปรไฟล์) -->
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    @php
                        $id = Auth::user()->id;
                        $profileData = App\Models\User::find($id);
                    @endphp
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="profileDropdown"
                           role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ (!empty($profileData->photo)) ? url('upload/user_images/'.$profileData->photo) : url('upload/no_image.jpg') }}"
                                 alt="user-image" class="rounded-circle me-2"
                                 style="height:40px;width:40px;object-fit:cover;">
                            <span class="pro-user-name">
                                {{$profileData->name}} <i class="mdi mdi-chevron-down"></i>
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                            <li><h6 class="dropdown-header">Welcome !</h6></li>
                            <li><a href="{{ route('admin.profile') }}" class="dropdown-item">My Account</a></li>
                            <li><a href="auth-lock-screen.html" class="dropdown-item">Lock Screen</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a href="{{ route('admin.logout') }}" class="dropdown-item">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>