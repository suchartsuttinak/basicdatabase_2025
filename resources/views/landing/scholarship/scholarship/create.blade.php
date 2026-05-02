@extends('layouts.landing_pages')

@section('content')
<section class="min-h-screen bg-gradient-to-b from-slate-50 via-white to-slate-100 py-8 sm:py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mb-8 rounded-3xl bg-white border border-slate-200 shadow-sm p-6 sm:p-8">
            <div class="inline-flex items-center rounded-full bg-blue-50 px-4 py-1 text-sm font-semibold text-blue-700 mb-4">
                สนับสนุนการศึกษา
            </div>

            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-slate-800">
                แบบฟอร์มสนับสนุนทุนการศึกษาเด็ก
            </h1>

            <p class="mt-3 text-slate-500 leading-relaxed">
                กรุณากรอกข้อมูลเพื่อแจ้งความประสงค์ในการสนับสนุน เจ้าหน้าที่จะตรวจสอบและติดต่อกลับภายหลัง
            </p>
        </div>

        @if(session('success'))
            <div id="scholarship-success-alert" class="mb-6 rounded-2xl border border-green-200 bg-green-50 px-5 py-4 text-green-700 shadow-sm">
                <div class="font-semibold">ส่งข้อมูลสำเร็จ</div>
                <div class="text-sm mt-1">{{ session('success') }}</div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    setTimeout(function () {
                        const alertBox = document.getElementById('scholarship-success-alert');

                        if (alertBox) {
                            alertBox.style.opacity = '0';
                            alertBox.style.transform = 'translateY(-10px)';
                            alertBox.style.transition = 'all .5s ease';

                            setTimeout(function () {
                                alertBox.remove();
                            }, 500);
                        }
                    }, 5000);
                });
            </script>
        @endif

        @if($errors->any())
            <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-red-700 shadow-sm">
                <div class="font-semibold">กรุณาตรวจสอบข้อมูล</div>
                <ul class="mt-2 list-disc pl-5 text-sm space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="rounded-3xl bg-white border border-slate-200 shadow-xl shadow-slate-200/60 overflow-hidden">
            <div class="bg-slate-50 border-b border-slate-200 px-5 py-5 sm:px-8">
                <h2 class="text-lg sm:text-xl font-bold text-slate-800">
                    ข้อมูลผู้มีจิตศรัทธา
                </h2>
                <p class="mt-1 text-sm text-slate-500">
                    ช่องที่มีเครื่องหมาย * จำเป็นต้องกรอก
                </p>
            </div>

            <form action="{{ route('scholarship.store') }}" method="POST" class="px-5 py-6 sm:px-8 sm:py-8">
                @csrf

                <div class="grid grid-cols-1 gap-6">

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            ชื่อ-สกุล ผู้มีจิตศรัทธา <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="fullname"
                               value="{{ old('fullname') }}"
                               required
                               class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-slate-800 shadow-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                               placeholder="กรอกชื่อ-สกุล">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-3">
                            มีความประสงค์สนับสนุน <span class="text-red-500">*</span>
                        </label>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            @php
                                $selectedTypes = old('support_types', []);
                            @endphp

                            <label class="flex items-center gap-3 rounded-2xl border border-slate-300 bg-white px-4 py-4 cursor-pointer hover:bg-slate-50">
                                <input type="checkbox"
                                       name="support_types[]"
                                       value="ทุนการศึกษา"
                                       {{ in_array('ทุนการศึกษา', $selectedTypes) ? 'checked' : '' }}
                                       class="h-5 w-5 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                <span class="font-medium text-slate-700">ทุนการศึกษา</span>
                            </label>

                            <label class="flex items-center gap-3 rounded-2xl border border-slate-300 bg-white px-4 py-4 cursor-pointer hover:bg-slate-50">
                                <input type="checkbox"
                                       name="support_types[]"
                                       value="ชุดนักเรียน"
                                       {{ in_array('ชุดนักเรียน', $selectedTypes) ? 'checked' : '' }}
                                       class="h-5 w-5 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                <span class="font-medium text-slate-700">ชุดนักเรียน</span>
                            </label>

                            <label class="flex items-center gap-3 rounded-2xl border border-slate-300 bg-white px-4 py-4 cursor-pointer hover:bg-slate-50">
                                <input type="checkbox"
                                       name="support_types[]"
                                       value="อุปกรณ์การเรียน"
                                       {{ in_array('อุปกรณ์การเรียน', $selectedTypes) ? 'checked' : '' }}
                                       class="h-5 w-5 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                <span class="font-medium text-slate-700">อุปกรณ์การเรียน</span>
                            </label>
                        </div>

                        <p class="mt-2 text-xs text-slate-500">
                            สามารถเลือกได้มากกว่า 1 รายการ
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                เบอร์โทรติดต่อ <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   name="phone"
                                   value="{{ old('phone') }}"
                                   required
                                   class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-slate-800 shadow-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                                   placeholder="เช่น 0812345678">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Email
                            </label>
                            <input type="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-slate-800 shadow-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                                   placeholder="example@email.com">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            รายละเอียดเพิ่มเติม
                        </label>
                        <textarea name="detail"
                                  rows="5"
                                  class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-slate-800 shadow-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100 resize-y"
                                  placeholder="ระบุรายละเอียดเพิ่มเติม เช่น จำนวนที่ต้องการสนับสนุน หรือช่วงเวลาที่สะดวกให้ติดต่อ">{{ old('detail') }}</textarea>
                    </div>
                </div>

                <div class="mt-8 flex flex-col-reverse sm:flex-row gap-3 sm:justify-between">
                    <a href="{{ url('/') }}"
                       class="inline-flex justify-center items-center rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                        กลับหน้าหลัก
                    </a>

                    <button type="submit"
                            class="inline-flex justify-center items-center rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-200 hover:bg-blue-700">
                        ส่งข้อมูลการสนับสนุน
                    </button>
                </div>
            </form>
        </div>

    </div>
</section>
@endsection