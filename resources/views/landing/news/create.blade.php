@extends('layouts.landing_pages')

@section('content')
<section class="py-16 bg-gradient-to-b from-gray-50 to-gray-100">
    <div class="max-w-3xl mx-auto px-6">
        <h2 class="text-3xl font-bold text-primary mb-8 text-center">
            ➕ เพิ่มข่าวและกิจกรรมใหม่
        </h2>

        <!-- แสดงข้อความสำเร็จ -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg shadow">
                {{ session('success') }}
            </div>
        @endif

        <!-- แสดง error validation -->
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-lg shadow">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-xl shadow-lg">
            @csrf

            <!-- หัวข้อข่าว -->
            <div class="mb-6">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">หัวข้อข่าว</label>
                <input type="text" name="title" id="title" 
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary" 
                       value="{{ old('title') }}" required>
            </div>

            <!-- รายละเอียดข่าว -->
            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">รายละเอียดข่าว</label>
                <textarea name="description" id="description" rows="6" 
                          class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary" 
                          required>{{ old('description') }}</textarea>
            </div>

            <!-- รูปภาพ -->
            <div class="mb-6">
                <label for="image" class="block text-sm font-medium text-gray-700 mb-2">รูปภาพ (ถ้ามี)</label>
                <input type="file" name="image" id="image" 
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary">
            </div>

            <!-- ปุ่มบันทึก -->
            <div class="flex justify-between items-center">
                <a href="{{ route('news.index') }}" 
                   class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg shadow hover:bg-gray-400 transition">
                    ← กลับไปหน้าข่าวทั้งหมด
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-primary text-white rounded-lg shadow hover:bg-primary-dark transition">
                    บันทึกข่าว
                </button>
            </div>
        </form>
    </div>
</section>
@endsection