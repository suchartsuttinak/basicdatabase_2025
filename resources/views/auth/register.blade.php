<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="utf-8" />
    <title>สมัครสมาชิก | ระบบสวัสดิการสังคม</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="ระบบสวัสดิการสังคม สำหรับการดูแลเด็ก สตรี ผู้สูงอายุ และกลุ่มเปราะบาง" />
    <meta name="author" content="OpenAI x Suchart" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link rel="shortcut icon" href="{{ asset('backend/assets/images/favicon.ico') }}">

    <link href="{{ asset('backend/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />
    <link href="{{ asset('backend/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

    <style>
        :root{
            --sw-primary:#2563eb;
            --sw-primary-2:#3b82f6;
            --sw-primary-soft:#eff6ff;
            --sw-warning:#f59e0b;
            --sw-warning-soft:#fff7ed;
            --sw-success:#16a34a;
            --sw-success-soft:#f0fdf4;
            --sw-dark:#0f172a;
            --sw-text:#334155;
            --sw-muted:#64748b;
            --sw-border:#e2e8f0;
            --sw-card:#ffffff;
            --sw-bg:#f8fbff;
            --sw-shadow:0 18px 60px rgba(15,23,42,.10);
        }

        html, body{
            min-height:100%;
            background:
                radial-gradient(circle at top left, rgba(59,130,246,.12), transparent 30%),
                radial-gradient(circle at bottom right, rgba(245,158,11,.10), transparent 28%),
                linear-gradient(135deg, #f8fbff 0%, #f5f9ff 42%, #ffffff 100%);
        }

        body{
            color:var(--sw-text);
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }

        .sw-auth-page{
            min-height:100vh;
        }

        .sw-auth-row{
            min-height:100vh;
        }

        .sw-left{
            display:flex;
            align-items:center;
            justify-content:center;
            padding:2rem 1rem;
        }

        .sw-form-shell{
            width:100%;
            max-width:460px;
        }

        .sw-form-card{
            background:rgba(255,255,255,.92);
            border:1px solid rgba(226,232,240,.95);
            border-radius:28px;
            box-shadow:var(--sw-shadow);
            overflow:hidden;
            backdrop-filter: blur(8px);
        }

        .sw-form-topbar{
            height:7px;
            background:linear-gradient(90deg, var(--sw-primary) 0%, var(--sw-primary-2) 55%, var(--sw-warning) 100%);
        }

        .sw-form-body{
            padding:2rem 2rem 1.75rem;
        }

        .sw-brand{
            display:flex;
            align-items:center;
            gap:.9rem;
            margin-bottom:1.35rem;
        }

        .sw-brand-icon{
            width:54px;
            height:54px;
            border-radius:18px;
            background:linear-gradient(135deg, var(--sw-primary) 0%, var(--sw-primary-2) 100%);
            display:flex;
            align-items:center;
            justify-content:center;
            box-shadow:0 14px 28px rgba(37,99,235,.22);
            flex:0 0 auto;
        }

        .sw-brand-icon svg{
            width:29px;
            height:29px;
        }

        .sw-brand-text h1{
            margin:0;
            font-size:1.12rem;
            font-weight:800;
            color:var(--sw-dark);
            line-height:1.2;
        }

        .sw-brand-text p{
            margin:0.2rem 0 0;
            font-size:.9rem;
            color:var(--sw-muted);
        }

        .sw-title{
            font-size:1.85rem;
            font-weight:800;
            color:var(--sw-dark);
            letter-spacing:-.03em;
            margin-bottom:.45rem;
        }

        .sw-subtitle{
            color:var(--sw-muted);
            line-height:1.7;
            margin-bottom:1.3rem;
        }

        .sw-wait-note{
            display:flex;
            align-items:flex-start;
            gap:.75rem;
            padding:1rem 1rem;
            border-radius:18px;
            border:1px solid #fed7aa;
            background:linear-gradient(180deg, #fffaf3 0%, #fff7ed 100%);
            margin-bottom:1.35rem;
        }

        .sw-wait-note-icon{
            width:38px;
            height:38px;
            border-radius:12px;
            background:#fff;
            border:1px solid #fde68a;
            display:flex;
            align-items:center;
            justify-content:center;
            flex:0 0 auto;
        }

        .sw-wait-note-icon svg{
            width:20px;
            height:20px;
        }

        .sw-wait-note h6{
            margin:0 0 .2rem;
            font-size:.96rem;
            font-weight:800;
            color:#9a3412;
        }

        .sw-wait-note p{
            margin:0;
            font-size:.9rem;
            color:#9a3412;
            line-height:1.65;
        }

        .sw-form-group{
            margin-bottom:1rem;
        }

        .sw-label{
            display:block;
            font-weight:700;
            color:#334155;
            font-size:.93rem;
            margin-bottom:.5rem;
        }

        .sw-input{
            min-height:50px;
            border-radius:16px;
            border:1px solid #cbd5e1;
            background:#fff;
            box-shadow:none;
            padding:.75rem 1rem;
            transition:all .2s ease;
            font-size:.96rem;
        }

        .sw-input:focus{
            border-color:#60a5fa;
            box-shadow:0 0 0 .22rem rgba(37,99,235,.12);
        }

        .sw-submit-btn{
            min-height:52px;
            border-radius:16px;
            border:0;
            width:100%;
            color:#fff;
            font-weight:800;
            font-size:1rem;
            background:linear-gradient(135deg, var(--sw-primary) 0%, var(--sw-primary-2) 100%);
            box-shadow:0 16px 28px rgba(37,99,235,.22);
            transition:transform .18s ease, box-shadow .18s ease, opacity .18s ease;
        }

        .sw-submit-btn:hover{
            color:#fff;
            transform:translateY(-1px);
            box-shadow:0 18px 34px rgba(37,99,235,.28);
        }

        .sw-submit-btn:active{
            transform:translateY(0);
        }

        .sw-login-text{
            color:var(--sw-muted);
            text-align:center;
            margin-top:1.15rem;
            margin-bottom:0;
        }

        .sw-login-link{
            font-weight:800;
            color:var(--sw-primary);
            text-decoration:none;
        }

        .sw-login-link:hover{
            color:#1d4ed8;
            text-decoration:underline;
        }

        .sw-divider{
            display:flex;
            align-items:center;
            gap:.8rem;
            color:#94a3b8;
            font-size:.86rem;
            margin:1.15rem 0 0;
        }

        .sw-divider::before,
        .sw-divider::after{
            content:"";
            flex:1;
            height:1px;
            background:#e2e8f0;
        }

        .sw-right{
            position:relative;
            overflow:hidden;
            display:flex;
            align-items:center;
            justify-content:center;
            padding:2rem;
            background:
                radial-gradient(circle at 20% 20%, rgba(255,255,255,.16), transparent 18%),
                radial-gradient(circle at 85% 15%, rgba(255,255,255,.10), transparent 22%),
                radial-gradient(circle at 15% 85%, rgba(255,255,255,.10), transparent 20%),
                linear-gradient(135deg, #2563eb 0%, #3b82f6 45%, #1d4ed8 100%);
        }

        .sw-right::before{
            content:"";
            position:absolute;
            width:360px;
            height:360px;
            border-radius:50%;
            background:rgba(255,255,255,.07);
            top:-120px;
            right:-120px;
        }

        .sw-right::after{
            content:"";
            position:absolute;
            width:280px;
            height:280px;
            border-radius:50%;
            background:rgba(255,255,255,.06);
            bottom:-110px;
            left:-110px;
        }

        .sw-hero{
            position:relative;
            z-index:2;
            width:100%;
            max-width:720px;
            color:#fff;
        }

        .sw-badge{
            display:inline-flex;
            align-items:center;
            gap:.55rem;
            padding:.65rem 1rem;
            border-radius:999px;
            background:rgba(255,255,255,.14);
            border:1px solid rgba(255,255,255,.18);
            backdrop-filter: blur(8px);
            margin-bottom:1.2rem;
            font-weight:700;
        }

        .sw-badge-dot{
            width:10px;
            height:10px;
            border-radius:50%;
            background:#fde68a;
            box-shadow:0 0 0 4px rgba(253,230,138,.18);
        }

        .sw-hero-title{
            font-size:clamp(2rem, 3.6vw, 3rem);
            line-height:1.16;
            font-weight:800;
            letter-spacing:-.03em;
            margin-bottom:1rem;
        }

        .sw-hero-desc{
            font-size:1.02rem;
            line-height:1.85;
            color:rgba(255,255,255,.88);
            max-width:620px;
            margin-bottom:1.45rem;
        }

        .sw-feature-grid{
            display:grid;
            grid-template-columns:repeat(3, minmax(0, 1fr));
            gap:1rem;
            margin-bottom:1.7rem;
        }

        .sw-feature-card{
            background:rgba(255,255,255,.12);
            border:1px solid rgba(255,255,255,.18);
            border-radius:20px;
            padding:1rem;
            min-height:118px;
            backdrop-filter: blur(8px);
            box-shadow:0 12px 25px rgba(15,23,42,.08);
        }

        .sw-feature-card svg{
            width:28px;
            height:28px;
            margin-bottom:.7rem;
        }

        .sw-feature-card h6{
            margin:0 0 .3rem;
            font-weight:800;
            font-size:1rem;
            color:#fff;
        }

        .sw-feature-card p{
            margin:0;
            color:rgba(255,255,255,.82);
            font-size:.91rem;
            line-height:1.65;
        }

        .sw-illustration{
            background:rgba(255,255,255,.10);
            border:1px solid rgba(255,255,255,.18);
            border-radius:28px;
            padding:1.25rem;
            backdrop-filter: blur(10px);
            box-shadow:0 18px 36px rgba(15,23,42,.10);
        }

        .sw-illustration svg{
            width:100%;
            height:auto;
            display:block;
        }

        .sw-footer-note{
            margin-top:1rem;
            color:rgba(255,255,255,.82);
            font-size:.95rem;
            line-height:1.7;
        }

        .sw-error-list{
            margin-bottom:1rem;
            border-radius:16px;
            overflow:hidden;
            box-shadow:none;
        }

        .sw-form-helper{
            color:#94a3b8;
            font-size:.84rem;
            margin-top:.45rem;
        }

        @media (max-width: 1199.98px){
            .sw-feature-grid{
                grid-template-columns:1fr;
            }
        }

        @media (max-width: 991.98px){
            .sw-right{
                display:none !important;
            }

            .sw-left{
                padding:1.2rem .8rem;
            }

            .sw-form-body{
                padding:1.45rem 1.1rem 1.2rem;
            }

            .sw-title{
                font-size:1.55rem;
            }

            .sw-brand{
                margin-bottom:1rem;
            }
        }

        @media (max-width: 575.98px){
            .sw-form-card{
                border-radius:22px;
            }

            .sw-brand{
                align-items:flex-start;
            }

            .sw-brand-icon{
                width:48px;
                height:48px;
                border-radius:16px;
            }

            .sw-brand-text h1{
                font-size:1rem;
            }

            .sw-input{
                min-height:48px;
                border-radius:14px;
            }

            .sw-submit-btn{
                min-height:50px;
                border-radius:14px;
            }

            .sw-wait-note{
                padding:.9rem;
            }
        }
    </style>
</head>

<body>
    <div class="sw-auth-page">
        <div class="container-fluid p-0">
            <div class="row g-0 sw-auth-row">

                {{-- LEFT FORM --}}
                <div class="col-xl-5 col-lg-6 sw-left">
                    <div class="sw-form-shell">
                        <div class="sw-form-card">
                            <div class="sw-form-topbar"></div>

                            <div class="sw-form-body">
                                <div class="sw-brand">
                                    <div class="sw-brand-icon">
                                        <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M22 26C26.4183 26 30 22.4183 30 18C30 13.5817 26.4183 10 22 10C17.5817 10 14 13.5817 14 18C14 22.4183 17.5817 26 22 26Z" fill="white"/>
                                            <path d="M42 24C45.3137 24 48 21.3137 48 18C48 14.6863 45.3137 12 42 12C38.6863 12 36 14.6863 36 18C36 21.3137 38.6863 24 42 24Z" fill="white" fill-opacity=".88"/>
                                            <path d="M12 46C12 38.8203 17.8203 33 25 33H28C35.1797 33 41 38.8203 41 46V48H12V46Z" fill="white"/>
                                            <path d="M36 48V45C36 39.4772 40.4772 35 46 35C51.5228 35 56 39.4772 56 45V48H36Z" fill="white" fill-opacity=".84"/>
                                        </svg>
                                    </div>
                                    <div class="sw-brand-text">
                                        <h1>ระบบสวัสดิการสังคม</h1>
                                        <p>Social Welfare Information System</p>
                                    </div>
                                </div>

                                <h2 class="sw-title">สมัครสมาชิกเข้าใช้งานระบบ</h2>
                                <p class="sw-subtitle">
                                    ลงทะเบียนเพื่อเข้าใช้งานระบบข้อมูลด้านเด็ก สตรี ผู้สูงอายุ และกลุ่มเปราะบาง
                                    โดยบัญชีใหม่จะเข้าสู่สถานะ <strong>รออนุมัติ</strong> ก่อนใช้งานจริง
                                </p>

                                <div class="sw-wait-note">
                                    <div class="sw-wait-note-icon">
                                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12 7V12L15 15" stroke="#EA580C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="#EA580C" stroke-width="2"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h6>สถานะบัญชีหลังสมัคร</h6>
                                        <p>เมื่อสมัครเสร็จ ระบบจะกำหนดสิทธิ์เป็น <strong>wait</strong> และพาไปยังหน้ารออนุมัติ ผู้ดูแลระบบจะตรวจสอบก่อนเปิดใช้งาน</p>
                                    </div>
                                </div>

                                @if ($errors->any())
                                    <div class="alert alert-danger sw-error-list mb-3">
                                        <div class="fw-bold mb-1">ไม่สามารถสมัครสมาชิกได้</div>
                                        <ul class="mb-0 ps-3">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form action="{{ route('register') }}" method="POST" class="mt-2">
                                    @csrf

                                    <div class="sw-form-group">
                                        <label for="name" class="sw-label">ชื่อผู้ใช้งาน</label>
                                        <input
                                            class="form-control sw-input @error('name') is-invalid @enderror"
                                            type="text"
                                            id="name"
                                            name="name"
                                            value="{{ old('name') }}"
                                            required
                                            autocomplete="name"
                                            placeholder="กรอกชื่อ-นามสกุล หรือชื่อผู้ใช้งาน">
                                    </div>

                                    <div class="sw-form-group">
                                        <label for="email" class="sw-label">อีเมล</label>
                                        <input
                                            class="form-control sw-input @error('email') is-invalid @enderror"
                                            type="email"
                                            id="email"
                                            name="email"
                                            value="{{ old('email') }}"
                                            required
                                            autocomplete="username"
                                            placeholder="example@email.com">
                                    </div>

                                    <div class="sw-form-group">
                                        <label for="password" class="sw-label">รหัสผ่าน</label>
                                        <input
                                            class="form-control sw-input @error('password') is-invalid @enderror"
                                            type="password"
                                            id="password"
                                            name="password"
                                            required
                                            autocomplete="new-password"
                                            placeholder="กรอกรหัสผ่าน">
                                        <div class="sw-form-helper">ควรมีอย่างน้อย 8 ตัวอักษรเพื่อความปลอดภัย</div>
                                    </div>

                                    <div class="sw-form-group">
                                        <label for="password_confirmation" class="sw-label">ยืนยันรหัสผ่าน</label>
                                        <input
                                            class="form-control sw-input"
                                            type="password"
                                            id="password_confirmation"
                                            name="password_confirmation"
                                            required
                                            autocomplete="new-password"
                                            placeholder="กรอกรหัสผ่านอีกครั้ง">
                                    </div>

                                    <div class="mt-3">
                                        <button class="btn sw-submit-btn" type="submit">
                                            สมัครสมาชิกและส่งคำขออนุมัติ
                                        </button>
                                    </div>
                                </form>

                                <div class="sw-divider">สำหรับผู้ที่มีบัญชีแล้ว</div>

                                <p class="sw-login-text">
                                    มีบัญชีอยู่แล้วใช่หรือไม่?
                                    <a class="sw-login-link ms-1" href="{{ route('login') }}">เข้าสู่ระบบ</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- RIGHT HERO --}}
                <div class="col-xl-7 col-lg-6 sw-right">
                    <div class="sw-hero">
                        <div class="sw-badge">
                            <span class="sw-badge-dot"></span>
                            เพื่อเด็ก สตรี ผู้สูงอายุ และกลุ่มเปราะบาง
                        </div>

                        <h3 class="sw-hero-title">
                            ระบบที่ออกแบบมาเพื่อการดูแลคนในสังคม
                            อย่างมีประสิทธิภาพและเป็นมาตรฐาน
                        </h3>

                        <p class="sw-hero-desc">
                            รองรับงานทะเบียนผู้รับบริการ การติดตาม การดูแลสวัสดิการ
                            และการประสานความช่วยเหลือสำหรับเด็ก เยาวชน สตรี ผู้สูงอายุ
                            และผู้ที่ต้องการการคุ้มครองทางสังคม
                        </p>

                        <div class="sw-feature-grid">
                            <div class="sw-feature-card">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 3L20 7V12C20 17 16.5 20.74 12 22C7.5 20.74 4 17 4 12V7L12 3Z" stroke="white" stroke-width="1.8"/>
                                    <path d="M9 12L11 14L15.5 9.5" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <h6>ปลอดภัยและเชื่อถือได้</h6>
                                <p>จัดการข้อมูลผู้รับบริการและผู้ใช้งานอย่างเป็นระบบ พร้อมกำหนดสิทธิ์ตามบทบาท</p>
                            </div>

                            <div class="sw-feature-card">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 20V10M12 20V4M17 20V14" stroke="white" stroke-width="1.8" stroke-linecap="round"/>
                                    <path d="M4 20H20" stroke="white" stroke-width="1.8" stroke-linecap="round"/>
                                </svg>
                                <h6>ข้อมูลครบและติดตามได้</h6>
                                <p>รองรับการดูแลต่อเนื่อง การประเมินผล และรายงานที่ช่วยให้การทำงานรวดเร็วขึ้น</p>
                            </div>

                            <div class="sw-feature-card">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8 11C9.65685 11 11 9.65685 11 8C11 6.34315 9.65685 5 8 5C6.34315 5 5 6.34315 5 8C5 9.65685 6.34315 11 8 11Z" stroke="white" stroke-width="1.8"/>
                                    <path d="M16 10C17.1046 10 18 9.10457 18 8C18 6.89543 17.1046 6 16 6C14.8954 6 14 6.89543 14 8C14 9.10457 14.8954 10 16 10Z" stroke="white" stroke-width="1.8"/>
                                    <path d="M3.5 18C3.5 15.5147 5.51472 13.5 8 13.5C10.4853 13.5 12.5 15.5147 12.5 18" stroke="white" stroke-width="1.8" stroke-linecap="round"/>
                                    <path d="M13 18C13 16.067 14.567 14.5 16.5 14.5C18.433 14.5 20 16.067 20 18" stroke="white" stroke-width="1.8" stroke-linecap="round"/>
                                </svg>
                                <h6>เพื่อทีมสหวิชาชีพ</h6>
                                <p>เหมาะกับผู้ดูแลระบบ นักสังคมสงเคราะห์ ครู ผู้บริหาร และเจ้าหน้าที่ที่เกี่ยวข้อง</p>
                            </div>
                        </div>

                        <div class="sw-illustration">
                            <svg viewBox="0 0 760 430" xmlns="http://www.w3.org/2000/svg" fill="none">
                                <defs>
                                    <linearGradient id="cardBg" x1="0" y1="0" x2="1" y2="1">
                                        <stop offset="0%" stop-color="rgba(255,255,255,0.22)"/>
                                        <stop offset="100%" stop-color="rgba(255,255,255,0.08)"/>
                                    </linearGradient>
                                </defs>

                                <rect x="18" y="16" width="724" height="398" rx="28" fill="rgba(255,255,255,.10)" stroke="rgba(255,255,255,.18)"/>

                                <circle cx="165" cy="120" r="42" fill="#FCD34D"/>
                                <rect x="123" y="170" width="84" height="110" rx="28" fill="#F59E0B"/>
                                <rect x="138" y="278" width="18" height="78" rx="9" fill="#1E3A8A"/>
                                <rect x="176" y="278" width="18" height="78" rx="9" fill="#1E3A8A"/>
                                <rect x="98" y="185" width="28" height="16" rx="8" fill="#FCD34D"/>
                                <rect x="204" y="185" width="28" height="16" rx="8" fill="#FCD34D"/>

                                <circle cx="360" cy="100" r="34" fill="#FDE68A"/>
                                <rect x="324" y="138" width="72" height="92" rx="24" fill="#FB7185"/>
                                <rect x="338" y="228" width="15" height="66" rx="7.5" fill="#1E3A8A"/>
                                <rect x="367" y="228" width="15" height="66" rx="7.5" fill="#1E3A8A"/>
                                <rect x="300" y="154" width="22" height="14" rx="7" fill="#FDE68A"/>
                                <rect x="398" y="154" width="22" height="14" rx="7" fill="#FDE68A"/>

                                <circle cx="560" cy="110" r="38" fill="#E5E7EB"/>
                                <rect x="518" y="150" width="86" height="118" rx="28" fill="#64748B"/>
                                <rect x="535" y="265" width="16" height="74" rx="8" fill="#0F172A"/>
                                <rect x="572" y="265" width="16" height="74" rx="8" fill="#0F172A"/>
                                <rect x="492" y="168" width="26" height="14" rx="7" fill="#E5E7EB"/>
                                <rect x="604" y="168" width="26" height="14" rx="7" fill="#E5E7EB"/>

                                <rect x="248" y="304" width="246" height="58" rx="22" fill="rgba(255,255,255,.14)" stroke="rgba(255,255,255,.18)"/>
                                <rect x="272" y="322" width="92" height="12" rx="6" fill="white" fill-opacity=".9"/>
                                <rect x="376" y="322" width="92" height="12" rx="6" fill="#FCD34D"/>
                                <circle cx="243" cy="333" r="15" fill="#10B981"/>

                                <path d="M84 366H668" stroke="rgba(255,255,255,.24)" stroke-width="3" stroke-linecap="round" stroke-dasharray="8 10"/>
                            </svg>
                        </div>

                        <p class="sw-footer-note">
                            สมัครสมาชิกเพื่อเริ่มต้นใช้งานระบบ จากนั้นผู้ดูแลระบบจะพิจารณาและกำหนดสิทธิ์ให้เหมาะสมกับบทบาทของคุณ
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="{{ asset('backend/assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/waypoints/lib/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/jquery.counterup/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/app.js') }}"></script>
</body>

</html>