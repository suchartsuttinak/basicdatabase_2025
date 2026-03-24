@extends('layouts.landing')

@section('content')
<section class="py-16 bg-gradient-to-b from-gray-50 to-gray-100">
    <div class="max-w-4xl mx-auto px-6">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            @if($news->image)
                <img src="{{ asset('storage/' . $news->image) }}" 
                     alt="{{ $news->title }}" 
                     class="w-full h-96 object-cover">
            @endif

            <div class="p-8">
                <h1 class="text-3xl font-bold text-primary mb-6">
                    {{ $news->title }}
                </h1>

                <p class="text-gray-700 leading-relaxed mb-8">
                    {{ $news->description }}
                </p>

                <div class="flex justify-between items-center">
                    <a href="{{ route('news.index') }}" 
                       class="px-4 py-2 bg-secondary text-white rounded-lg shadow hover:bg-secondary-dark transition">
                        ← กลับไปหน้าข่าวทั้งหมด
                    </a>

                    <span class="text-sm text-gray-500">
                        เผยแพร่เมื่อ {{ $news->created_at->format('d/m/Y H:i') }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection