@extends('learn.layout')
@section('css')
    <link rel="stylesheet" href="{{asset('learn/assets/front/css/homepage.css')}}">
@stop
@section('content')


    @include('learn.partials.menubar')
    <!-- vacation of your dream area start -->
    <section class="vacation-area">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2 text-center">
                    <div class="section-title">
                        <h2><strong>{{$basic->goal_heading}}</strong></h2>
                        <p>{!! 	$basic->goal_para !!}</p>
                    </div>
                </div>
            </div>
            <div class="row text-center">
                @foreach($goals as $data)
                    <div class="col-md-4 col-sm-6">
                        <div class="single-vacation-item">
                            <div class="icon">
                                <img src="{{asset('learn/assets/images/'.$data->image)}}" class="m-t-50"
                                     alt="...">
                            </div>
                            <div class="content">
                                <a>
                                    <h4> {{$data->title}}</h4>
                                </a>
                                <p>{!! $data->details !!}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- vacation of your dream area end -->





    <!-- news updates start -->
    <section class="news-update-area">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2 text-center">
                    <div class="section-title">
                        <h2><strong>Our</strong> Blog</h2>
                    </div>
                </div>
            </div>
            @foreach($blogs->chunk(3) as $blog)
            <div class="row">
                @foreach($blog as $data)
                <div class="col-md-4 col-sm-6">
                    <div class="single-news-item">
                        @php
                            $slug = str_slug($data->title);
                        @endphp

                        <a href="{{route('details.blog',[$data->id,$slug])}}">
                            <img src="{{asset('learn/assets/images/post/'.$data->image)}}" alt="">
                        </a>

                        <div class="content">
                            <span class="meta-time">{{date('d F Y',strtotime($data->created_at))}}</span><br>
                            <a href="{{route('details.blog',[$data->id,$slug])}}">
                                <h4>{{$data->title}}</h4>
                            </a>
                        </div>
                    </div>
                </div>
                    @endforeach
            </div>
                <br>
            @endforeach


        </div>
    </section>
    <!-- news updates end -->




















    <div class="parallax section overlay" data-stellar-background-ratio="0.5"
         style="background-image:url('learn/assets/images/logo/testimonial.jpg'); background-position: 0px 66.4844px">

        <div class="container">

            <div class="row">

                <div class="col-md-12">
                    <div class="row testimonials">

                        <div class="owl-carousel owl-theme">
                            @foreach($testimonials as $testimonial)
                                <div class="single-testimonial-item">
                                    <blockquote>
                                        <p class="clients-words">{!! $testimonial->details !!}</p>
                                        <span class="clients-name text-primary">— {{$testimonial->name}}</span>
                                        <img class="img-circle img-thumbnail"
                                             src="{{asset('learn/assets/images/testimonial/'.$testimonial->image)}}"
                                             alt="{{$testimonial->name}}">
                                    </blockquote>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div><!--/.col-->
            </div><!--/.row-->
        </div><!-- end container -->
    </div><!-- end section -->

    @include('learn.partials.subscribe')



@stop