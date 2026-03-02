@extends('admin_client.admin_client')
@section('content')
<div class="container">
    <h4 class="fw-bold text-primary mb-3">แก้ไขการช่วยเหลือ</h4>

    <form action="{{ route('help_sessions.update', ['client' => $client->id, 'session' => $session->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="help_date" class="form-label">วันที่ให้ความช่วยเหลือ</label>
            <input type="date" name="help_date" id="help_date" 
                   class="form-control" value="{{ $session->help_date }}">
        </div>

        {{-- รายการช่วยเหลือ (loop items) --}}
        @foreach($session->items as $index => $item)
            <div class="mb-3 border p-2 rounded">
                <label>ชื่อรายการ</label>
                <input type="text" name="items[{{ $index }}][item_name]" 
                       value="{{ $item->item_name }}" class="form-control">

                <label>จำนวน</label>
                <input type="number" name="items[{{ $index }}][quantity]" 
                       value="{{ $item->quantity }}" class="form-control">

                <label>ราคา/หน่วย</label>
                <input type="number" step="0.01" name="items[{{ $index }}][unit_price]" 
                       value="{{ $item->unit_price }}" class="form-control">
            </div>
        @endforeach

        <button type="submit" class="btn btn-primary">บันทึกการแก้ไข</button>
    </form>
</div>
@endsection