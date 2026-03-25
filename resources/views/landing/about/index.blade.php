@extends('layouts.landing_pages')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-10">

    <h2 class="text-3xl font-bold text-primary mb-8 text-center">เกี่ยวกับเรา</h2>

    <!-- ฟอร์มบันทึกข้อมูล -->
    <div class="bg-white p-6 rounded-lg shadow mb-10">
        <form action="{{ route('landing.about.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">เลือกประเภท</label>
                <select name="type" class="w-full border rounded px-3 py-2">
                    <option value="history">ประวัติองค์กร</option>
                    <option value="objective">วัตถุประสงค์</option>
                    <option value="mission">พันธกิจของเรา</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">รายละเอียด</label>
                <textarea name="content" rows="4" class="w-full border rounded px-3 py-2"></textarea>
            </div>

            <button type="submit" class="bg-primary text-white px-6 py-2 rounded hover:bg-primary-dark">
                บันทึกข้อมูล
            </button>
        </form>
    </div>

    <!-- ตารางแสดงข้อมูล -->
    <div class="bg-white p-6 rounded-lg shadow mb-10">
        <h3 class="text-xl font-semibold text-primary mb-4">ข้อมูลล่าสุด</h3>
        <table class="w-full border-collapse border border-gray-200">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2">ประเภท</th>
                    <th class="border px-4 py-2">รายละเอียด</th>
                    <th class="border px-4 py-2">วันที่บันทึก</th>
                </tr>
            </thead>
            <tbody>
                @forelse($aboutData as $data)
                    <tr>
                        <td class="border px-4 py-2">
                            @if($data->type === 'history') ประวัติองค์กร
                            @elseif($data->type === 'objective') วัตถุประสงค์
                            @else พันธกิจของเรา
                            @endif
                        </td>
                        <td class="border px-4 py-2">{{ $data->content }}</td>
                        <td class="border px-4 py-2">{{ $data->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center text-gray-500 py-4">ยังไม่มีข้อมูล</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Section Card เกี่ยวกับเรา -->
    <section class="py-10 bg-gray-50">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Card 1 -->
            <div class="p-6 bg-white rounded-lg shadow hover:shadow-lg transition text-left">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 flex items-center justify-center bg-primary text-white rounded-full">📖</div>
                    <h3 class="text-xl font-semibold text-primary ml-3">ประวัติองค์กร</h3>
                </div>
                <p class="text-gray-600 leading-relaxed indent-8">
                    {{ $history ? $history->content : 'ยังไม่มีข้อมูล' }}
                </p>
            </div>

            <!-- Card 2 -->
            <div class="p-6 bg-white rounded-lg shadow hover:shadow-lg transition text-left">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 flex items-center justify-center bg-primary text-white rounded-full">🎯</div>
                    <h3 class="text-xl font-semibold text-primary ml-3">วัตถุประสงค์</h3>
                </div>
                <p class="text-gray-600 leading-relaxed indent-8">
                    {{ $objective ? $objective->content : 'ยังไม่มีข้อมูล' }}
                </p>
            </div>

            <!-- Card 3 -->
            <div class="p-6 bg-white rounded-lg shadow hover:shadow-lg transition text-left">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 flex items-center justify-center bg-primary text-white rounded-full">❤️</div>
                    <h3 class="text-xl font-semibold text-primary ml-3">พันธกิจของเรา</h3>
                </div>
                <p class="text-gray-600 leading-relaxed indent-8">
                    {{ $mission ? $mission->content : 'ยังไม่มีข้อมูล' }}
                </p>
            </div>
        </div>
    </section>

</div>
@endsection