@extends('layouts.landing')

@section('content')
<section class="py-16 bg-gradient-to-b from-gray-50 to-gray-100">
    <div class="max-w-6xl mx-auto px-6">
        <h2 class="text-3xl font-bold text-primary mb-12 text-center">
            📰 ข่าวทั้งหมด
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse($news as $item)
                <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition transform hover:-translate-y-1 overflow-hidden">
                    @if($item->image)
                        <img src="{{ asset('storage/' . $item->image) }}" 
                             alt="{{ $item->title }}" 
                             class="w-full h-48 object-cover">
                    @endif
                    <div class="p-6 text-left">
                        <h3 class="text-xl font-semibold text-primary mb-3 line-clamp-2">
                            {{ $item->title }}
                        </h3>
                        <p class="text-gray-600 mb-4 text-sm line-clamp-3">
                            {{ Str::limit($item->description, 120) }}
                        </p>
                        <a href="{{ route('news.show', $item->id) }}" 
                           class="inline-block px-4 py-2 bg-secondary text-white rounded-lg shadow hover:bg-secondary-dark transition">
                            อ่านเพิ่มเติม
                        </a>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-500 col-span-3">
                    ยังไม่มีข่าวในขณะนี้
                </p>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $news->links() }} <!-- Pagination -->
        </div>

        <!-- ปุ่มย้อนกลับไปหน้าหลัก -->
        <div class="mt-12 text-center">
            <a href="{{ route('landing.index') }}" 
               class="px-6 py-3 bg-primary text-white rounded-lg shadow hover:bg-primary-dark transition">
                ← กลับไปหน้าหลัก
            </a>
        </div>
    </div>
</section>
@endsection