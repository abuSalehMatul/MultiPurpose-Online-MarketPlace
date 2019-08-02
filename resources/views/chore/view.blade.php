
@extends('layouts.app')
@section('title','Chores And Service')
@section('content')


@include('chore.style.CSS')
@include('chore.style.choreContent')
<div class="">
   @php
       $chores=App\Chore::where('type',1)->get();
       $chores_service=App\Chore::where('type',2)->get();
    //    print_r($chores[0]->id);

   @endphp
   {{-- <head>
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
   </head> --}}
    <div class="main-div awesome">
       
       
       
         <div class="top-div">
            <h3>Find local help for your chores or trade your services</h3>
            <small>You can start by posting a chore you need done, or a service you can do for others</small>
        </div>
        @auth
         <div class="post">
            <a href="{{url('service/add')}}" class=" btn-post ">Post a service</a>
            <a href="{{url('chores/add')}}" class="btn-post ">Post a Task</a>
           
        </div>
        <div class="post">
             <a href="{{url('chores/admin')}}" class="btn btn-success">Your Dashboard</a>
        </div>
        @endauth
        @php
            
        @endphp
        <div class="sliderm">            
            <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
                @if($chores)
                <div class="carousel-inner ">
                    @if(count($chores)>0)
                        @php
                            $image=App\Image::where('id',$chores[0]->image_id)->first();
                            // print_r($chores[0]);
                            // exit();
                        @endphp
                        <div class="carousel-item active div-slider ">
                            <img src="{{asset('uploads/image/'.$image->image)}}" class="d-block w-100 " alt="...">
                            <h6 class="c_name">{{$chores[0]->name}}</h6>
                            <h6 class="c_price">${{$chores[0]->price}}</h6>
                            
                            
                        </div>
                    @endif    
                
                    @if(count($chores)>1)
                        @php
                            $image=App\Image::where('id',$chores[1]->image_id)->first();
                        @endphp
                        <div class="carousel-item div-slider">
                            <img src="{{asset('uploads/image/'.$image->image)}}" class="d-block w-100" alt="...">
                            <h6 class="c_name">{{$chores[1]->name}}</h6>
                            <h6 class="c_price">${{$chores[1]->price}}</h6>
                        </div>
                    @endif
                    
                    @if(count($chores)>2)
                        @php
                            $image=App\Image::where('id',$chores[2]->image_id)->first();
                            
                        @endphp
                        <div class="carousel-item div-slider">
                        <img src="{{asset('uploads/image/'.$image->image)}}" class="d-block w-100" alt="...">
                            <h6 class="c_name">{{$chores[2]->name}}</h6>
                            <h6 class="c_price">${{$chores[2]->price}}</h6>
                        </div>
                    @endif    
                </div>
                @endif
            </div>

            <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
            @if($chores)
            <div class="carousel-inner ">
                @if(count($chores)>3)
                    <div class="carousel-item active div-slider">
                        @php
                            $image=App\Image::where('id',$chores[3]->image_id)->first();
                        @endphp
                        <img src="{{asset('uploads/image/'.$image->image)}}" class="d-block w-100" alt="...">
                        <h6 class="c_name">{{$chores[3]->name}}</h6>
                        <h6 class="c_price">${{$chores[3]->price}}</h6>
                        
                        
                    </div>
                @endif

                @if(count($chores)>4)
                    <div class="carousel-item div-slider">
                        @php
                            $image=App\Image::where('id',$chores[4]->image_id)->first();
                        @endphp
                    
                    <img src="{{asset('uploads/image/'.$image->image)}}" class="d-block w-100" alt="...">
                        <h6 class="c_name">{{$chores[4]->name}}</h6>
                        <h6 class="c_price">${{$chores[4]->price}}</h6>
                    </div>
                @endif

                @if(count($chores)>5)
                    <div class="carousel-item div-slider">
                    @php
                        $image=App\Image::where('id',$chores[5]->image_id)->first();
                        
                    @endphp
                    <img src="{{asset('uploads/image/'.$image->image)}}" class="d-block w-100" alt="...">
                        <h6 class="c_name">{{$chores[5]->name}}</h6>
                        <h6 class="c_price">${{$chores[5]->price}}</h6>
                    </div>
                @endif
            </div>
            @endif
            </div>
            <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
           
            <div class="carousel-inner ">
                 @php
                    if(count($chores_service)>0){
                         $image=App\Image::where('id',$chores_service[0]->image_id)->first();
                    }else {
                        $image=null;
                    }
                    
                @endphp
                @if($image)
                <div class="carousel-item active div-slider">
                    <img src="{{asset('uploads/image/'.$image->image)}}" class="d-block w-100" alt="...">
                    <h6 class="c_name">{{$chores_service[0]->name}}</h6>
                    <h6 class="c_price">{{$chores_service[0]->price}}</h6>
                    
                    
                </div>
                @endif
               
                 @php
                  if(count($chores_service)>1){
                         $image=App\Image::where('id',$chores_service[1]->image_id)->first();
                    }else {
                        $image=null;
                    }
                  
                    
                @endphp
                 @if($image)
                <div class="carousel-item div-slider">
                   
                <img src="{{asset('uploads/image/'.$image->image)}}" class="d-block w-100" alt="...">
                    <h6 class="c_name">{{$chores_service[1]->name}}</h6>
                    <h6 class="c_price">{{$chores_service[1]->price}}</h6>
                </div>
                @endif
                
                 @php
                  if(count($chores_service)>2){
                         $image=App\Image::where('id',$chores_service[2]->image_id)->first();
                    }else {
                        $image=null;
                    }
                   
                @endphp
                @if($image)
                <div class="carousel-item div-slider">
                <img src="{{asset('uploads/image/'.$image->image)}}" class="d-block w-100" alt="...">
                    <h6 class="c_name">{{$chores_service[2]->name}}</h6>
                    <h6 class="c_price">{{$chores_service[2]->price}}</h6>
                </div>
                @endif
            </div>
           
            </div>
        </div>
    </div>
    <div class="category card">
        <div class="card-header">
             <h6 class="widget-title">
                <span> 
                Browse Category
                </span>
            </h6>
        </div>
       <div class="card-body">

       
            <ul style="list-style:none" class="card-body">
                @php
                    $chore_category=App\ChoreCategory::all();
                @endphp
                @foreach($chore_category as $chore_category)
                <li style="float:left"><i class="fas fa-plus-circle">{{$chore_category->name}}</i></li>
                @endforeach
            </ul>
        </div>

    </div>
   
    <div class="chore ">
     
            <h6 class="widget-title">
                <span> 
                  Latest Chores
                </span>
            </h6>
       
      
         @foreach($chores as $chores)
        <a href="{{url('chores/details/'.$chores->id)}}">
            <div class="chore-div ">
                @php
                    $image=App\Image::where('id',$chores->image_id)->first();
                @endphp
                <img src="{{asset('uploads/image/'.$image->image)}}" class="chore-img" alt="">
                <div>
                    @php
                        if($chores->precidance==1){
                        $p='Featured';
                        }else{
                            $p='Normal';
                        } 
                        if($chores->type==1){
                                $c='Chore';
                            }else{
                                $c='Service';
                            }
                    @endphp
                    <small class="featured badge badge-success">{{$p}}</small>
                    <small class="type badge badge-danger">{{$c}}</small>
                
                </div>
                <h6 style="font-size: 17px;text-align: center;color: black;">{{$chores->name}}</h6>
                <small class="price">$ {{$chores->price}}</small>

            </div>
        </a>
         @endforeach

    </div>
   
    <div class="chore ">
       <h6 class="widget-title">
                <span> 
                  Latest Services
                </span>
        </h6>
            @if($chores_service)
            @foreach($chores_service as $chores)
            <a href="{{url('service/details/'.$chores->id)}}">
                <div class="chore-div ">
                    @php
                        $image=App\Image::where('id',$chores->image_id)->first();
                    @endphp
                    <img src="{{asset('uploads/image/'.$image->image)}}" class="chore-img" alt="">
                    <div>
                        @php
                            if($chores->precidance==1){
                            $p='Featured';
                            }else{
                                $p='Normal';
                            } 
                            if($chores->type==1){
                                $c='Chore';
                            }else{
                                $c='Service';
                            }
                        @endphp
                        <small class="featured badge badge-success">{{$p}}</small>
                        <small class="type badge badge-danger">{{$c}}</small>
                    
                    </div>
                    <h6 style="font-size: 17px;text-align: center;color: black;">{{$chores->name}}</h6>
                    <small class="price">$ {{$chores->price}}</small>

                </div>
            </a>
            
            @endforeach
            @endif
        


    </div>
   

</div>

@endsection