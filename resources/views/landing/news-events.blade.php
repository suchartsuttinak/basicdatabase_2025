<section class="py-16 bg-gradient-to-b from-gray-50 to-gray-100">
    <div class="max-w-6xl mx-auto px-6">

        <h2 class="text-3xl font-bold text-primary mb-12 text-center">
            📰 ข่าวและกิจกรรมล่าสุด
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse($news as $item)

                <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition duration-300 transform hover:-translate-y-1 overflow-hidden">

                    @if(!empty($item->image))
                        @php
                            if (str_starts_with($item->image, 'upload/')) {
                                $imageUrl = asset($item->image);
                            } elseif (str_starts_with($item->image, 'storage/')) {
                                $imageUrl = asset($item->image);
                            } else {
                                $imageUrl = asset('storage/' . $item->image);
                            }
                        @endphp

                        <div class="w-full h-48 bg-gray-100 overflow-hidden">
                            {{-- PATCH: Lazy Load + Async Decode --}}
                            <img src="{{ $imageUrl }}"
                                 alt="{{ $item->title }}"
                                 loading="lazy"
                                 decoding="async"
                                 class="w-full h-full object-cover hover:scale-105 transition duration-500">
                        </div>
                    @else
                        <div class="w-full h-48 bg-gray-100 flex items-center justify-center text-gray-400">
                            <div class="text-center">
                                <div class="text-3xl mb-2">🖼️</div>
                                <span class="text-sm">ไม่มีรูปภาพ</span>
                            </div>
                        </div>
                    @endif

                    <div class="p-6 text-left">
                        <h3 class="text-xl font-semibold text-primary mb-3 line-clamp-2">
                            {{ $item->title }}
                        </h3>

                        <p class="text-gray-600 mb-4 text-sm leading-relaxed line-clamp-3">
                            {{ Str::limit(strip_tags($item->description), 120) }}
                        </p>

                        <div class="flex justify-between items-center gap-3">
                            <a href="{{ route('news.show', $item->id) }}"
                               class="inline-flex items-center px-4 py-2 bg-secondary text-white rounded-lg shadow hover:bg-secondary-dark transition">
                                อ่านเพิ่มเติม
                            </a>

                            <span class="text-xs text-gray-500 whitespace-nowrap">
                                {{ optional($item->created_at)->format('d/m/Y') }}
                            </span>
                        </div>
                    </div>
                </div>

            @empty
                <div class="col-span-3">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 py-14 px-6 text-center">
                        <div class="text-5xl mb-4">📰</div>

                        <h3 class="text-lg font-semibold text-gray-700 mb-2">
                            ยังไม่มีข่าวและกิจกรรมในขณะนี้
                        </h3>

                        <p class="text-sm text-gray-500">
                            เมื่อมีข่าวใหม่ ระบบจะแสดงข้อมูลที่นี่
                        </p>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="mt-12 text-center">
            <a href="{{ route('news.index') }}"
               class="inline-flex items-center px-6 py-3 bg-primary text-white rounded-lg shadow hover:bg-primary-dark transition">
                ดูข่าวและกิจกรรมทั้งหมด →
            </a>
        </div>

    </div>
</section>