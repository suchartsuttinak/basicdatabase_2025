@extends('layouts.landing_pages')

@section('content')
<section class="min-h-screen bg-gradient-to-b from-slate-50 via-white to-slate-100 py-8 sm:py-10 lg:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="mb-6 sm:mb-8">
            <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
                <div class="px-5 py-6 sm:px-8 sm:py-8">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                        <div>
                            <div class="mb-3 inline-flex items-center gap-2 rounded-full bg-blue-50 px-3 py-1 text-sm font-semibold text-blue-700">
                                <span>Issue Management</span>
                            </div>

                            <h1 class="text-2xl font-bold tracking-tight text-slate-800 sm:text-3xl lg:text-4xl">
                                รายการแจ้งปัญหา
                            </h1>

                            <p class="mt-2 text-sm leading-relaxed text-slate-500 sm:text-base">
                                แสดงรายการแจ้งปัญหาและข้อมูลติดต่อของผู้แจ้งอย่างเป็นระบบ
                                พร้อมรองรับการใช้งานทุกขนาดหน้าจอ
                            </p>
                        </div>

                        <div class="flex-shrink-0">
                            <a href="{{ route('client.show') }}"
                               class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition duration-200 hover:border-slate-400 hover:bg-slate-50">
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

        {{-- Success Alert --}}
        @if(session('success'))
            <div class="mb-6">
                <div class="flex items-start gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-4 text-emerald-800 shadow-sm">
                    <div class="mt-0.5 shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-600" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.707a1 1 0 00-1.414-1.414L9 10.172 7.707 8.879a1 1 0 10-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold">ดำเนินการสำเร็จ</h3>
                        <p class="mt-1 text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        {{-- Main Table Card --}}
        <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 bg-slate-50/80 px-5 py-4 sm:px-6">
                <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-slate-800">
                            ข้อมูลการแจ้งปัญหา
                        </h2>
                        <p class="mt-1 text-sm text-slate-500">
                            จำนวนทั้งหมด
                            {{ method_exists($issues, 'total') ? number_format($issues->total()) : $issues->count() }}
                            รายการ
                        </p>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-800 text-white">
                        <tr>
                            <th class="whitespace-nowrap px-6 py-4 text-left text-sm font-semibold">
                                ชื่อ-สกุล
                            </th>
                            <th class="whitespace-nowrap px-6 py-4 text-left text-sm font-semibold">
                                เบอร์โทรศัพท์
                            </th>
                            <th class="whitespace-nowrap px-6 py-4 text-left text-sm font-semibold">
                                เรื่องที่แจ้ง
                            </th>
                            <th class="whitespace-nowrap px-6 py-4 text-left text-sm font-semibold">
                                วันที่แจ้ง
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-200">
                        @forelse($issues as $issue)
                            <tr class="bg-white transition hover:bg-slate-50">
                                <td class="px-6 py-4 align-top">
                                    <div class="font-semibold text-slate-800">
                                        {{ $issue->fullname }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 align-top">
                                    <div class="whitespace-nowrap text-slate-700">
                                        {{ $issue->phone }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 align-top">
                                    <div class="max-w-2xl leading-relaxed text-slate-700">
                                        {{ $issue->subject }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 align-top">
                                    <div class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-700 whitespace-nowrap sm:text-sm">
                                        {{ $issue->created_at->format('d/m/Y H:i') }}
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-14 text-center">
                                    <div class="flex flex-col items-center justify-center text-slate-500">
                                        <div class="mb-3 rounded-full bg-slate-100 p-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-6m3 6V7m3 10v-4m5 8H4a1 1 0 01-1-1V4a1 1 0 011-1h16a1 1 0 011 1v16a1 1 0 01-1 1z" />
                                            </svg>
                                        </div>
                                        <h3 class="text-base font-semibold text-slate-700">
                                            ยังไม่มีข้อมูลการแจ้งปัญหา
                                        </h3>
                                        <p class="mt-1 text-sm text-slate-500">
                                            เมื่อมีข้อมูล ระบบจะแสดงรายการในส่วนนี้
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination: แสดงเฉพาะเมื่อมีหลายหน้าจริง --}}
        @if(
            $issues instanceof \Illuminate\Contracts\Pagination\Paginator ||
            $issues instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator
        )
            @if($issues->hasPages())
                <div class="mt-6">
                    <div class="rounded-2xl border border-slate-200 bg-white px-4 py-4 shadow-sm">
                        {{ $issues->onEachSide(1)->links() }}
                    </div>
                </div>
            @endif
        @endif

    </div>
</section>
@endsection