@extends('layout')
@section('css')
<style>
    .menubar-m{
        
        display:none;
    }
</style>
@stop

@section('content')
@include('partials.menubar')
<section class="faq-section pad-t-b-40" >
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div id="faq">
                    <div class="container">

                        <h2 class="text-center">{{$page_title}}</h2>
                        <p>{!!  $menu->description !!}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

    @include('partials.subscribe')
@stop