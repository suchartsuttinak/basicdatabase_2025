<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="utf-8" />
    <title>เข้าสู่ระบบ | ระบบสวัสดิการสังคม</title>
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
            --sw-danger:#dc2626;
            --sw-danger-soft:#fef2f2;
            --sw-success:#16a34a;
            --sw-dark:#0f172a;
            --sw-text:#334155;
            --sw-muted:#64748b;
            --sw-border:#e2e8f0;
            --sw-card:#ffffff;
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
            background:rgba(255,255,255,.94);
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
            margin:.2rem 0 0;
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

        .sw-login-note{
            display:flex;
            align-items:flex-start;
            gap:.75rem;
            padding:1rem 1rem;
            border-radius:18px;
            border:1px solid #dbeafe;
            background:linear-gradient(180deg, #f8fbff 0%, #eff6ff 100%);
            margin-bottom:1.35rem;
        }

        .sw-login-note-icon{
            width:38px;
            height:38px;
            border-radius:12px;
            background:#fff;
            border:1px solid #bfdbfe;
            display:flex;
            align-items:center;
            justify-content:center;
            flex:0 0 auto;
        }

        .sw-login-note-icon svg{
            width:20px;
            height:20px;
        }

        .sw-login-note h6{
            margin:0 0 .2rem;
            font-size:.96rem;
            font-weight:800;
            color:#1d4ed8;
        }

        .sw-login-note p{
            margin:0;
            font-size:.9rem;
            color:#1e40af;
            line-height:1.65;
        }

        .sw-alert{
            border-radius:16px;
            border:1px solid transparent;
            padding:.95rem 1rem;
            font-size:.94rem;
            line-height:1.65;
            margin-bottom:1rem;
        }

        .sw-alert-danger{
            background:var(--sw-danger-soft);
            border-color:#fecaca;
            color:#991b1b;
        }

        .sw-alert-success{
            background:#f0fdf4;
            border-color:#bbf7d0;
            color:#166534;
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

        .sw-error{
            display:block;
            margin-top:.45rem;
            color:#dc2626;
            font-size:.84rem;
            font-weight:600;
        }

        .sw-row-meta{
            display:flex;
            justify-content:flex-end;
            align-items:center;
            gap:1rem;
            margin-bottom:1rem;
        }

        .sw-forgot-link{
            font-size:.9rem;
            font-weight:700;
            color:var(--sw-primary);
            text-decoration:none;
        }

        .sw-forgot-link:hover{
            color:#1d4ed8;
            text-decoration:underline;
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

        .sw-register-text{
            color:var(--sw-muted);
            text-align:center;
            margin-top:1.15rem;
            margin-bottom:0;
        }

        .sw-register-link{
            font-weight:800;
            color:var(--sw-primary);
            text-decoration:none;
        }

        .sw-register-link:hover{
            color:#1d4ed8;
            text-decoration:underline;
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

        .sw-stat-grid{
            display:grid;
            grid-template-columns:repeat(3, minmax(0, 1fr));
            gap:1rem;
            margin-bottom:1.7rem;
        }

        .sw-stat-card{
            background:rgba(255,255,255,.12);
            border:1px solid rgba(255,255,255,.18);
            border-radius:20px;
            padding:1rem;
            min-height:118px;
            backdrop-filter: blur(8px);
            box-shadow:0 12px 25px rgba(15,23,42,.08);
        }

        .sw-stat-card h6{
            margin:0 0 .25rem;
            font-size:.95rem;
            color:rgba(255,255,255,.82);
            font-weight:700;
        }

        .sw-stat-number{
            font-size:1.65rem;
            line-height:1.1;
            font-weight:800;
            color:#fff;
            margin-bottom:.35rem;
        }

        .sw-stat-card p{
            margin:0;
            color:rgba(255,255,255,.82);
            font-size:.91rem;
            line-height:1.6;
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

        @media (max-width: 1199.98px){
            .sw-stat-grid{
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

            .sw-login-note{
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

                                <h2 class="sw-title">เข้าสู่ระบบ</h2>
                                <p class="sw-subtitle">
                                    เข้าสู่ระบบเพื่อใช้งานข้อมูลด้านเด็ก สตรี ผู้สูงอายุ
                                    และกลุ่มเปราะบางในสังคมอย่างเป็นระบบและปลอดภัย
                                </p>

                                <div class="sw-login-note">
                                    <div class="sw-login-note-icon">
                                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M7 10V8C7 5.23858 9.23858 3 12 3C14.7614 3 17 5.23858 17 8V10" stroke="#2563EB" stroke-width="2" stroke-linecap="round"/>
                                            <rect x="4" y="10" width="16" height="11" rx="3" stroke="#2563EB" stroke-width="2"/>
                                            <circle cx="12" cy="15.5" r="1.2" fill="#2563EB"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h6>เข้าสู่ระบบอย่างปลอดภัย</h6>
                                        <p>ผู้ใช้ใหม่ที่เพิ่งสมัครสมาชิกอาจต้องรอการอนุมัติสิทธิ์ก่อน จึงจะสามารถใช้งานระบบได้เต็มรูปแบบ</p>
                                    </div>
                                </div>

                                @if (session('error'))
                                    <div class="sw-alert sw-alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif

                                @if (session('status'))
                                    <div class="sw-alert sw-alert-success">
                                        {{ session('status') }}
                                    </div>
                                @endif

                                <form action="{{ route('login') }}" method="POST" class="mt-2">
                                    @csrf

                                    <div class="sw-form-group">
                                        <label for="email" class="sw-label">อีเมล</label>
                                        <input
                                            class="form-control sw-input @error('email') is-invalid @enderror"
                                            type="email"
                                            id="email"
                                            name="email"
                                            value="{{ old('email') }}"
                                            required
                                            autofocus
                                            autocomplete="username"
                                            placeholder="example@email.com">
                                        @error('email')
                                            <small class="sw-error">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="sw-form-group">
                                        <label for="password" class="sw-label">รหัสผ่าน</label>
                                        <input
                                            class="form-control sw-input @error('password') is-invalid @enderror"
                                            type="password"
                                            id="password"
                                            name="password"
                                            required
                                            autocomplete="current-password"
                                            placeholder="กรอกรหัสผ่าน">
                                        @error('password')
                                            <small class="sw-error">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="sw-row-meta">
                                        @if (Route::has('password.request'))
                                            <a class="sw-forgot-link" href="{{ route('password.request') }}">
                                                ลืมรหัสผ่าน?
                                            </a>
                                        @endif
                                    </div>

                                    <div class="mt-3">
                                        <button class="btn sw-submit-btn" type="submit">
                                            เข้าสู่ระบบ
                                        </button>
                                    </div>
                                </form>

                                <div class="sw-divider">สำหรับผู้ที่ยังไม่มีบัญชี</div>
                                    @if (Route::has('register'))
                                    <div class="sw-divider">การเข้าใช้งานระบบ</div>

                                    <p class="sw-register-text mb-0">
                                        หากยังไม่มีบัญชีผู้ใช้งาน กรุณาติดต่อผู้ดูแลระบบเพื่อสร้างบัญชีให้
                                    </p>
                                    @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- RIGHT HERO --}}
                <div class="col-xl-7 col-lg-6 sw-right">
                    <div class="sw-hero">
                        <div class="sw-badge">
                            <span class="sw-badge-dot"></span>
                            ดูแล คุ้มครอง และพัฒนาคุณภาพชีวิต
                        </div>

                        <h3 class="sw-hero-title">
                            เชื่อมโยงข้อมูลการช่วยเหลือทางสังคม
                            ให้ทำงานร่วมกันได้อย่างมีประสิทธิภาพ
                        </h3>

                        <p class="sw-hero-desc">
                            ระบบนี้ช่วยสนับสนุนการทำงานของหน่วยงานและบุคลากรที่เกี่ยวข้อง
                            ในการดูแลเด็ก สตรี ผู้สูงอายุ และกลุ่มเปราะบาง
                            ด้วยข้อมูลที่เป็นระบบ ใช้งานง่าย และเข้าถึงได้ตามสิทธิ์
                        </p>

                        <div class="sw-stat-grid">
                            <div class="sw-stat-card">
                                <h6>เด็กและเยาวชน</h6>
                                <div class="sw-stat-number">Child</div>
                                <p>รองรับการดูแลข้อมูลพื้นฐาน การติดตาม และการคุ้มครองอย่างต่อเนื่อง</p>
                            </div>

                            <div class="sw-stat-card">
                                <h6>สตรีและครอบครัว</h6>
                                <div class="sw-stat-number">Family</div>
                                <p>ช่วยจัดเก็บข้อมูลและประสานการช่วยเหลือสำหรับครอบครัวและสตรีกลุ่มเปราะบาง</p>
                            </div>

                            <div class="sw-stat-card">
                                <h6>ผู้สูงอายุ</h6>
                                <div class="sw-stat-number">Senior</div>
                                <p>เหมาะกับการดูแลข้อมูลสุขภาวะ การเข้าถึงสวัสดิการ และการติดตามรายกรณี</p>
                            </div>
                        </div>

                        <div class="sw-illustration">
                            <svg viewBox="0 0 760 430" xmlns="http://www.w3.org/2000/svg" fill="none">
                                <rect x="18" y="16" width="724" height="398" rx="28" fill="rgba(255,255,255,.10)" stroke="rgba(255,255,255,.18)"/>

                                <rect x="86" y="70" width="180" height="118" rx="22" fill="rgba(255,255,255,.16)" />
                                <rect x="108" y="96" width="88" height="12" rx="6" fill="white"/>
                                <rect x="108" y="120" width="126" height="10" rx="5" fill="rgba(255,255,255,.75)"/>
                                <rect x="108" y="142" width="104" height="10" rx="5" fill="rgba(255,255,255,.55)"/>
                                <circle cx="228" cy="128" r="18" fill="#FCD34D"/>

                                <rect x="302" y="62" width="372" height="138" rx="24" fill="rgba(255,255,255,.14)" />
                                <rect x="330" y="92" width="146" height="12" rx="6" fill="white"/>
                                <rect x="330" y="118" width="296" height="10" rx="5" fill="rgba(255,255,255,.75)"/>
                                <rect x="330" y="140" width="260" height="10" rx="5" fill="rgba(255,255,255,.55)"/>
                                <rect x="330" y="162" width="198" height="10" rx="5" fill="rgba(255,255,255,.40)"/>

                                <circle cx="152" cy="284" r="38" fill="#FCD34D"/>
                                <rect x="112" y="322" width="82" height="38" rx="19" fill="#F59E0B"/>

                                <circle cx="330" cy="270" r="34" fill="#FDE68A"/>
                                <rect x="294" y="304" width="72" height="34" rx="17" fill="#FB7185"/>

                                <circle cx="524" cy="282" r="36" fill="#E5E7EB"/>
                                <rect x="484" y="318" width="82" height="36" rx="18" fill="#64748B"/>

                                <path d="M230 286C250 250 290 238 322 250" stroke="#93C5FD" stroke-width="8" stroke-linecap="round"/>
                                <path d="M366 260C396 228 452 226 490 254" stroke="#FCD34D" stroke-width="8" stroke-linecap="round"/>

                                <rect x="248" y="360" width="260" height="28" rx="14" fill="rgba(255,255,255,.18)"/>
                                <rect x="272" y="368" width="126" height="12" rx="6" fill="white"/>
                            </svg>
                        </div>

                        <p class="sw-footer-note">
                            หากบัญชีของคุณยังอยู่ในสถานะรออนุมัติ ระบบจะแจ้งให้ทราบหลังเข้าสู่ระบบ
                            เพื่อให้ผู้ดูแลสามารถตรวจสอบและกำหนดสิทธิ์ได้อย่างเหมาะสม
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