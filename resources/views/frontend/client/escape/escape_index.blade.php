@extends('admin_client.admin_client')

@section('content')

<link rel="stylesheet" href="{{ asset('backend/assets/css/escape.css') }}">

<div class="container-fluid mt-3 escape-page">

    <div class="escape-shell">
        {{-- Header --}}
         @include('frontend.client.escape.partials._header')
      
        {{-- Client Info --}}
        @include('frontend.client.escape.partials.client_info')

   
        {{-- Escape Table --}}
            @include('frontend.client.escape.partials._table')

        
          {{-- Create Modal --}}
          @include('frontend.client.escape.partials.escapeCreateModal')

          {{-- Edit Modal --}}
          @include('frontend.client.escape.partials.escapeEditModal')

    </div>
</div>

      @endsection



