@extends('layouts.landing_pages')

@section('content')
<div class="max-w-6xl mx-auto py-12 px-6">
    <h2 class="text-3xl font-bold text-primary mb-6">📋 รายการแจ้งปัญหา</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded mb-6 shadow">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="w-full border-collapse">
            <thead class="bg-primary text-white">
                <tr>
                    <th class="px-6 py-3 text-left font-semibold">ชื่อ-สกุล</th>
                    <th class="px-6 py-3 text-left font-semibold">เบอร์โทรศัพท์</th>
                    <th class="px-6 py-3 text-left font-semibold">เรื่องที่แจ้ง</th>
                    <th class="px-6 py-3 text-left font-semibold">วันที่แจ้ง</th>
                </tr>
            </thead>
            <tbody>
                @foreach($issues as $issue)
                    <tr class="hover:bg-gray-50 {{ $loop->even ? 'bg-gray-100' : 'bg-white' }}">
                        <td class="px-6 py-4 text-gray-800">{{ $issue->fullname }}</td>
                        <td class="px-6 py-4 text-gray-800">{{ $issue->phone }}</td>
                        <td class="px-6 py-4 text-gray-800">{{ $issue->subject }}</td>
                        <td class="px-6 py-4 text-gray-600 text-sm">{{ $issue->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $issues->links() }}
    </div>
</div>
@endsection