@extends('layouts.landing_pages')

@section('content')
<section class="min-h-screen bg-gradient-to-b from-slate-50 via-white to-slate-100 py-8 sm:py-10 lg:py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
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
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                                </svg>
                                กลับหน้า Client
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Success --}}
        @if(session('success'))
            <div class="mb-6">
                <div class="flex items-start gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-4 text-emerald-800 shadow-sm">
                    <div class="mt-0.5 shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-600" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.707a1 1 0 00-1.414-1.414L9 10.172 7.707 8.879a1 1 0 10-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold">บันทึกข้อมูลสำเร็จ</h3>
                        <p class="mt-1 text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="mb-6">
                <div class="rounded-2xl border border-red-200 bg-red-50 px-4 py-4 shadow-sm">
                    <div class="flex items-start gap-3">
                        <div class="mt-0.5 shrink-0 text-red-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10A8 8 0 112 10a8 8 0 0116 0zm-8.707-3.707a1 1 0 011.414 0L11 6.586l.293-.293a1 1 0 111.414 1.414L12.414 8l.293.293a1 1 0 01-1.414 1.414L11 9.414l-.293.293a1 1 0 01-1.414-1.414L9.586 8l-.293-.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </div>

                        <div class="min-w-0">
                            <h3 class="font-semibold text-red-700">กรุณาตรวจสอบข้อมูล</h3>
                            <ul class="mt-2 space-y-1 text-sm text-red-700 list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Form Card --}}
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

                    {{-- Title --}}
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

                    {{-- Description --}}
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

                    {{-- Image --}}
                    <div>
                        <label for="image" class="mb-2 block text-sm font-semibold text-slate-700">
                            รูปภาพประกอบ
                        </label>

                        <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-4 py-4 sm:px-5">
                            <input
                                type="file"
                                name="image"
                                id="image"
                                class="block w-full text-sm text-slate-600 file:mr-4 file:rounded-xl file:border-0 file:bg-slate-800 file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-white hover:file:bg-slate-700"
                            >
                            <p class="mt-2 text-xs sm:text-sm text-slate-500">
                                รองรับไฟล์รูปภาพสำหรับใช้ประกอบข่าวสารและกิจกรรม
                            </p>
                        </div>
                    </div>

                </div>

                {{-- Actions --}}
                <div class="mt-8 flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('client.show') }}"
                           class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition duration-200 hover:bg-slate-50 hover:border-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                            กลับหน้า Client
                        </a>

                        <a href="{{ route('news.index') }}"
                           class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-300 bg-slate-100 px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition duration-200 hover:bg-slate-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5h12M9 12h12M9 19h12M5 5h.01M5 12h.01M5 19h.01" />
                            </svg>
                            กลับไปหน้าข่าวทั้งหมด
                        </a>
                    </div>

                    <button type="submit"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-200 transition duration-200 hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        บันทึกข่าว
                    </button>
                </div>
            </form>
        </div>

    </div>
</section>
@endsection