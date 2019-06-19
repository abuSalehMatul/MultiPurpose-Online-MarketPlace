@extends('layout')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/front/css/custom.css')}}">
<style>
    .menubar-m{
        
        display:none;
    }
</style>
@stop
@section('content')
@include('partials.menubar')
    <!-- contact area start -->
    <section class="contact-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 remove-col-padding">
                    <div class="contact-form-inner">

                        <div class="row">
                            <div class="col-lg-12 remove-col-padding">
                                <div class="contact-form-wrapper">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="singl-contact-info">
                                                <div class="icon">
                                                    <i class="far fa-map"></i>
                                                </div>
                                                <div class="content">
                                                    <h5>Location</h5>
                                                    <span class="details">{!! $basic->address !!}</span>
                                                </div>
                                            </div>
                                            <div class="singl-contact-info">
                                                <div class="icon">
                                                    <i class="far fa-envelope"></i>
                                                </div>
                                                <div class="content">
                                                    <h5>Email</h5>
                                                    <span class="details">{{$basic->email}}</span>
                                                </div>
                                            </div>
                                            <div class="singl-contact-info margin-bottom-60">
                                                <div class="icon">
                                                    <i class="fas fa-phone"></i>
                                                </div>
                                                <div class="content">
                                                    <h5>Phone</h5>
                                                    <span class="details">{!! $basic->phone !!}</span>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-lg-6">
                                            <div class="contact-from-wrapper">
                                                <form action="" method="post">
                                                    @csrf
                                                    <div class="form-element square">
                                                        <label>Your Name
                                                            <span>**</span>
                                                        </label>
                                                        <input type="text" name="name" placeholder="Type your name...."
                                                               class="input-field-square">
                                                        @if($errors->has('name'))
                                                            <span class="error height-25">{{ $errors->first('name')}}</span>
                                                        @endif
                                                    </div>
                                                    <div class="form-element square">
                                                        <label>Your Email
                                                            <span>**</span>
                                                        </label>
                                                        <input type="email" name="email"
                                                               placeholder="Type your email...."
                                                               class="input-field-square">
                                                        @if($errors->has('email'))
                                                            <span class="error height-25">{{ $errors->first('email')}}</span>
                                                        @endif
                                                    </div>
                                                    <div class="form-element square">
                                                        <label>Your Messages
                                                            <span>**</span>
                                                        </label>
                                                        <textarea rows="5" name="message"
                                                                  placeholder="Type your message...."
                                                                  class="input-field-square textarea"></textarea>
                                                        @if($errors->has('message'))
                                                            <span class="error height-25">{{ $errors->first('message')}}</span>
                                                        @endif

                                                    </div>
                                                    <button type="submit" class="submit-form-btn">submit now</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- contact area end -->
    @include('partials.subscribe')

@stop