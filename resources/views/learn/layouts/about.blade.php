@extends('learn.layout')
@section('css')
<style>
    .menubar-m{
        
        display:none;
    }

</style>
@stop
@section('content')
@include('learn.partials.menubar')

    <section class="faq-section pad-t-b-40" >
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div id="faq">
                        <div class="container">

                            <h2 class="text-center text-uppercase">{{$page_title}}</h2>
                            <p>{!! $basic->about !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('learn.partials.subscribe')


@stop