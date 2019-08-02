@extends('master_backend.master')
@section('content')
 <style>
        .box{
                height: 230px;
                width: 310px;
                padding: 40px;
                float: left;
                background: repeating-linear-gradient(45deg, green, transparent 100px);
                margin: 30px;
        }
        .options{
            font-size: 30px;
            font-weight: 900;
            text-align: center;
            padding: 20px;
            color: white;
            background: linear-gradient(15deg, green, transparent);
        }
        a{            
            font-weight: 700;
            /* color: #007bff; */
            color: black;
            text-align: center;
            font-size: 50px;
            text-decoration: none;
            background-color: transparent;
        }
    </style>
<div >
    <div class="well">
        <p class="options">MODULES</p>
    </div>
   
    <div class="box">
        <a href="{{url('master_redirect/'.'freelancer')}}">Freelancer</a>
    </div>
    <div class="box" style="float:right">
        <a href="{{url('master_redirect/'.'pro')}}">Pro</a>
    </div>
    <div class="box">
        <a href="{{url('master_redirect/'.'candidate')}}">Job</a>
    </div>
    <div class="box" style="float:right">
        <a href="{{url('master_redirect/'.'chores')}}">Chores</a>
    </div>
    <div class="box">
        <a href="{{url('master_redirect/'.'study')}}">Studey and Grow</a>
    </div>
    <div class="box" style="float:right">
        <a href="{{url('master_redirect/'.'coupon')}}">Coupon</a>
    </div>

</div>
@endsection