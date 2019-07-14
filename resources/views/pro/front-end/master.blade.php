@extends('pro.master')
@push('stylesheets')

@endpush

@section('header')
	@include('pro.includes.header')
@endsection

@section('main')
@stack('stylesheets')
<main id="wt-main" class="wt-main wt-innerbgcolor wt-haslayout {{ !empty($body_class) ? $body_class : '' }}">
	@yield('content')
</main>

@endsection

@section('footer')
	@include('pro.front-end.includes.footer')
@endsection

@push('scripts')
@stack('scripts')
@endpush
