@extends('layouts.landing_pages')

@section('content')
<section class="min-h-screen bg-gradient-to-b from-slate-50 via-white to-slate-100 py-8 sm:py-10 lg:py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mb-6 sm:mb-8">
            <div class="rounded-3xl border border-slate-200 bg-white/95 shadow-sm overflow-hidden">
                <div class="px-5 py-6 sm:px-8 sm:py-8">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                        <div>
                            <div class="inline-flex items-center gap-2 rounded-full bg-blue-50 px-3 py-1 text-sm font-semibold text-blue-700 mb-3">
                                <span>News Management</span>
                            </div>

                            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold tracking-tight text-slate-800">
                                เพิ่มข่าวและกิจกรรมใหม่
                            </h1>

                            <p class="mt-2 text-sm sm:text-base text-slate-500 leading-relaxed">
                                บันทึกข่าวสารและกิจกรรมประชาสัมพันธ์ของหน่วยงานให้เป็นระเบียบและใช้งานง่าย
                            </p>
                        </div>

                        <div class="flex-shrink-0">
                            <a href="{{ route('client.show') }}"
                               class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition duration-200 hover:bg-slate-50 hover:border-slate-400">
                                กลับหน้า Client
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6">
                <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-4 text-emerald-800 shadow-sm">
                    <h3 class="font-semibold">บันทึกข้อมูลสำเร็จ</h3>
                    <p class="mt-1 text-sm">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6">
                <div class="rounded-2xl border border-red-200 bg-red-50 px-4 py-4 shadow-sm">
                    <h3 class="font-semibold text-red-700">กรุณาตรวจสอบข้อมูล</h3>
                    <ul class="mt-2 space-y-1 text-sm text-red-700 list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="rounded-3xl border border-slate-200 bg-white shadow-xl shadow-slate-200/50 overflow-hidden">
            <div class="border-b border-slate-200 bg-slate-50/80 px-5 py-4 sm:px-8">
                <h2 class="text-lg sm:text-xl font-semibold text-slate-800">
                    แบบฟอร์มเพิ่มข่าวและกิจกรรม
                </h2>
                <p class="mt-1 text-sm text-slate-500">
                    กรอกข้อมูลข่าวสารให้ครบถ้วนเพื่อแสดงผลอย่างเป็นระเบียบในระบบ
                </p>
            </div>

            <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data" class="px-5 py-6 sm:px-8 sm:py-8">
                @csrf

                <div class="space-y-6">
                    <div>
                        <label for="title" class="mb-2 block text-sm font-semibold text-slate-700">
                            หัวข้อข่าว <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="title"
                            id="title"
                            value="{{ old('title') }}"
                            required
                            placeholder="กรอกหัวข้อข่าวหรือกิจกรรม"
                            class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-800 shadow-sm outline-none transition duration-200 placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                        >
                    </div>

                    <div>
                        <label for="description" class="mb-2 block text-sm font-semibold text-slate-700">
                            รายละเอียดข่าว <span class="text-red-500">*</span>
                        </label>
                        <textarea
                            name="description"
                            id="description"
                            rows="7"
                            required
                            placeholder="กรอกรายละเอียดข่าวหรือกิจกรรม"
                            class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-800 shadow-sm outline-none transition duration-200 placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 resize-y"
                        >{{ old('description') }}</textarea>
                    </div>

                    <div>
                        <label for="image" class="mb-2 block text-sm font-semibold text-slate-700">
                            รูปภาพประกอบ
                        </label>

                        <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-4 py-4 sm:px-5">
                            <input
                                type="file"
                                name="image"
                                id="image"
                                accept="image/*"
                                class="block w-full text-sm text-slate-600 file:mr-4 file:rounded-xl file:border-0 file:bg-slate-800 file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-white hover:file:bg-slate-700"
                            >

                            <p class="mt-2 text-xs sm:text-sm text-slate-500">
                                รองรับไฟล์ jpg, jpeg, png, webp และระบบจะบีบอัดรูปก่อนบันทึก
                            </p>

                            <div class="mt-5">
                                <div class="text-sm text-slate-500 mb-2">
                                    ตัวอย่างรูปภาพ
                                </div>

                                <div class="w-full max-w-sm overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                                    <img id="image-preview"
                                         src=""
                                         alt="preview"
                                         loading="lazy"
                                         decoding="async"
                                         class="hidden w-full h-56 object-cover">

                                    <div id="image-preview-empty"
                                         class="flex items-center justify-center h-56 text-slate-400 text-sm">
                                        ยังไม่ได้เลือกรูปภาพ
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('client.show') }}"
                           class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition duration-200 hover:bg-slate-50 hover:border-slate-400">
                            กลับหน้า Client
                        </a>

                        <a href="{{ route('news.index') }}"
                           class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-300 bg-slate-100 px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition duration-200 hover:bg-slate-200">
                            กลับไปหน้าข่าวทั้งหมด
                        </a>
                    </div>

                    <button type="submit"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-200 transition duration-200 hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100">
                        บันทึกข่าว
                    </button>
                </div>
            </form>
        </div>

    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/browser-image-compression@2.0.2/dist/browser-image-compression.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('image');
    const preview = document.getElementById('image-preview');
    const empty = document.getElementById('image-preview-empty');

    if (!input || !preview || !empty) return;

    input.addEventListener('change', async function (event) {
        preview.src = '';
        preview.classList.add('hidden');
        empty.style.display = 'flex';

        const file = event.target.files[0];

        if (!file || !file.type.startsWith('image/')) {
            return;
        }

        const reader = new FileReader();

        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            empty.style.display = 'none';
        };

        reader.readAsDataURL(file);

        try {
            const compressedFile = await imageCompression(file, {
                maxSizeMB: 0.7,
                maxWidthOrHeight: 1600,
                useWebWorker: true,
                fileType: 'image/jpeg',
                initialQuality: 0.75,
            });

            const dt = new DataTransfer();
            dt.items.add(compressedFile);
            input.files = dt.files;
        } catch (error) {
            console.error('Image compression failed:', error);
        }
    });
});
</script>
@endsection