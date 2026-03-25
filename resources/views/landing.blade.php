@extends('layouts.landing_pages')

@section('content')
    @include('landing.hero')
    @include('landing.about-mission')
    @include('landing.donation-report')
    @include('landing.news-events') <!-- ใช้ $news ที่ส่งมาจาก LandingController -->
@endsection