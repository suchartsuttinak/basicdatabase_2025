
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">


<section class="relative overflow-hidden bg-gradient-to-br from-blue-700 via-indigo-700 to-slate-900 text-white">
    <div class="absolute inset-0 opacity-20">
        <div class="absolute -top-24 -left-24 w-72 h-72 bg-white rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-80 h-80 bg-sky-300 rounded-full blur-3xl"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-6 py-20 md:py-24 text-center">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 mb-6 rounded-full bg-white/10 border border-white/20 text-sm font-medium text-blue-50">
            <span>🔐</span>
           <span>ระบบเข้าใช้งานสำหรับเจ้าหน้าที่</span>
        </div>

        <h1 class="text-4xl md:text-5xl font-extrabold mb-4 tracking-tight">
            ยินดีต้อนรับสู่ระบบของเรา
        </h1>

        <p class="text-base md:text-lg mb-8 text-blue-100">
            เข้าสู่ระบบเพื่อจัดการข้อมูลและใช้งานบริการต่าง ๆ อย่างปลอดภัย
        </p>

        <div class="flex justify-center">
            <a href="{{ route('login') }}"
               class="group inline-flex items-center justify-center gap-3
                      px-8 py-3.5 rounded-2xl
                      bg-white text-blue-700 font-bold
                      shadow-xl shadow-black/20
                      hover:bg-blue-50 hover:-translate-y-0.5
                      active:translate-y-0
                      transition-all duration-300">

                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-700
                             group-hover:bg-blue-700 group-hover:text-white transition">
                    <i class="bi bi-box-arrow-in-right"></i>
                </span>

                <span>เข้าสู่ระบบ</span>
            </a>
        </div>
    </div>
</section>