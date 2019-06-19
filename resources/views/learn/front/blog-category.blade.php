
@extends('layout')
@section('css')
@stop
@section('content')
@include('partials.menubar')
    <section class="blog-page-area">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-sm-12">
                    @foreach($posts as $data)
                    <div  class="single-blog-post">
                        <div class="thumb">
                            @php
                            $slug = str_slug($data->title)
                            @endphp
                            <a href="{{route('details.blog',[$data->id, $slug])}}">
                            <img src="{{asset('assets/images/post/'.$data->image)}}" alt="blog images">
                            </a>
                        </div>
                        <div class="content">
                            <div class="left-content">
                                <div class="post-meta">
                                    <span class="meta-date">{{date('d',strtotime($data->created_at))}}</span>
                                    <span class="meta-month">{{date('F',strtotime($data->created_at))}}</span>
                                </div>
                            </div>
                            <div class="right-content">
                                <a href="{{route('details.blog',[$data->id, $slug])}}">
                                <h3>{{$data->title}}</h3>
                                </a>
                                @php
                                    $details = strip_tags($data->details)
                                @endphp

                                <p>{!! str_limit($details,120)  !!}</p>
                            </div>
                        </div>
                    </div>
                        @endforeach
                            {!! $posts->links() !!}

                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="sidebar-area-blog blog-page">

                        <div class="widget-area category">
                            <div class="widget-title">
                                <h4>Category</h4>
                            </div>
                            <div class="widget-body">
                                <ul>
                                    @foreach($blogCategory as $data)
                                        @php
                                            $slug = str_slug($data->name)
                                        @endphp
                                    <li>
                                        <a href="{{route('blog.category',[$data->id,$slug])}}">{{$data->name}} <span>({{$data->posts()->whereStatus(1)->count()}})</span></a></li>
                                        @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    @include('partials.subscribe')
@stop