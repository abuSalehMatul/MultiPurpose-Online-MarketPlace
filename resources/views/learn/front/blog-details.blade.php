
@extends('layout')
@section('css')
@stop
@section('content')

@include('partials.menubar')

<!-- end header-area -->
<section class="listing-details-area">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-sm-12">
                <div class="listing-details-wrapper">
                    <div class="thumb">
                        <img src="{{asset('assets/images/post/'.$post->image)}}" alt="listing details image">
                    </div>
                    <div class="listing-title">
                        <span class="category">{{$post->category->name}}</span><br><br>
                        <div class="content">
                            <h4>{{$post->title}}</h4>
                        </div>
                    </div>
                    <div class="listing-details">

                        <div class="overvew-content">
                            <p>{!!  $post->details!!}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="sidebar-area-listing-details">
                    <div class="widget-area hosted-profile">
                        <div class="widget-body">
                            <div class="content">
                                <h4>Share This</h4>
                            </div>
                            <div class="social-profile">
                                <ul>
                                    <li><a href="https://www.facebook.com/sharer/sharer.php?u={{urlencode(url()->current()) }}" class="boxed-btn facebook">Share with facebook</a></li>
                                    <li ><a href="https://plus.google.com/share?url={{urlencode(url()->current()) }}" class="boxed-btn gplus">Share with Google Plus</a></li>
                                    <li><a href="https://twitter.com/intent/tweet?text=my share text&amp;url={{urlencode(url()->current()) }}" class="boxed-btn twitter">Share with twitter</a></li>
                                    <br>
                                    <li><a href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{urlencode(url()->current()) }}&amp;title=my share text&amp;summary=dit is de linkedin summary" class="boxed-btn linkedin">Share with Linkedin</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <style>

                    </style>
                    <div class="widget-area category">
                        <div class="widget-title">
                            <h4>Category</h4>
                        </div>
                        <div class="widget-body">
                            <ul>
                                @foreach($blogCategory as $data)
                                <li class="padding-t-b-10">
                                    @php
                                    $slug = str_slug($data->name)
                                    @endphp
                                    <a href="{{route('blog.category',[$data->id,$slug])}}">{{$data->name}} <span class="padding-l-40">({{$data->posts()->whereStatus(1)->count()}})</span></a></li>
                                    @endforeach
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</section>
<!-- footer area start -->


    @include('partials.subscribe')
@stop