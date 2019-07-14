@extends('learn.layout')
@section('css')
    <link rel="stylesheet" href="{{asset('learn/assets/front/css/homepage.css')}}">
@stop
@section('content')
@include('learn.partials.menubar')

    <div class="container pad-t-b-80">
        @if(count($subjects)  > 0)
            <div class="row">
                <h2 class="text-center">{{$page_title}}</h2><br>
            </div>
        @foreach($subjects->chunk(5) as $subject)
            <div class="row">
                @foreach($subject as  $k=>$data)
                    @php $slug =  str_slug($data->category->name) @endphp
                    <div class="col-md-2 col-sm-6 col-xs-12 @if($k%5==0)col-md-offset-1 @endif">
                        <a href="{{route('topics',[$data->id,$slug])}}">
                        <button class="btn btn-default orange-circle-button" >{{$data->title or ''}}</button>
                        </a>
                        <br>
                    </div>
                @endforeach
            </div><br>
        @endforeach
            @else
        <h1 class="text-center">No Subject Found!!</h1>
        @endif
    </div>

    @include('learn.partials.subscribe')
@stop