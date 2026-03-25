@extends('layouts.landing_pages')

@section('content')
    @include('landing.hero')
    @include('landing.about-mission')   <!-- ใช้ $history, $objective, $mission -->
    @include('landing.donation-report')
    @include('landing.news-events')     <!-- ใช้ $news -->
@endsection