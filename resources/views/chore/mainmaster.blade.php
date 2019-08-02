
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    @include('chore.style.CSS')
    @include('chore.style.choreContent')
     <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    
    <!-- Styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-bs4.css" rel="stylesheet">

    <!-- Dropzone Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!-- Custom Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css" /> --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/css/tempusdominus-bootstrap-4.min.css" />
    <link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet">
    <title>Chore</title>
</head>
<body>

<div class="">
   @php
       $chores=App\Chore::where('type',1)->get();
       $chores_service=App\Chore::where('type',2)->get();
    //    print_r($chores[0]->id);

   @endphp
    <div class="main-div awesome">
        <div class="top-div">
            <h3>Find local help for your chores or trade your services</h3>
            <small>You can start by posting a chore you need done, or a service you can do for others</small>
        </div>
        @auth
        <div class="post">
            <a href="{{url('service/add')}}" class="btn btn-info ">Post a service</a>
            <a href="{{url('chores/add')}}" class="btn btn-info ">Post a Task</a>
        </div>
        <div class="post">
             <a href="{{url('chores/admin')}}" class="btn btn-success">Your Dashboard</a>
        </div>
        @endauth
        
        <div class="sliderm">            
            <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
                @if($chores)
                <div class="carousel-inner ">
                    @if(count($chores)>0)
                        @php
                            $image=App\Image::where('id',$chores[0]->image_id)->first();
                           
                        @endphp
                        <div class="carousel-item active div-slider ">
                            <img src="{{asset('uploads/image/'.$image->image)}}" class="d-block w-100 " alt="...">
                            <h6>{{$chores[0]->name}}</h6>
                            <h6>${{$chores[0]->price}}</h6>
                            
                            
                        </div>
                    @endif    
                
                    @if(count($chores)>1)
                        @php
                            $image=App\Image::where('id',$chores[1]->image_id)->first();
                        @endphp
                        <div class="carousel-item div-slider">
                            <img src="{{asset('uploads/image/'.$image->image)}}" class="d-block w-100" alt="...">
                            <h6>{{$chores[1]->name}}</h6>
                            <h6>${{$chores[1]->price}}</h6>
                        </div>
                    @endif
                    
                    @if(count($chores)>2)
                        @php
                            $image=App\Image::where('id',$chores[2]->image_id)->first();
                            
                        @endphp
                        <div class="carousel-item div-slider">
                        <img src="{{asset('uploads/image/'.$image->image)}}" class="d-block w-100" alt="...">
                            <h6>{{$chores[2]->name}}</h6>
                            <h6>${{$chores[2]->price}}</h6>
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
                        <h6>{{$chores[3]->name}}</h6>
                        <h6>${{$chores[3]->price}}</h6>
                        
                        
                    </div>
                @endif

                @if(count($chores)>4)
                    <div class="carousel-item div-slider">
                        @php
                            $image=App\Image::where('id',$chores[4]->image_id)->first();
                        @endphp
                    
                    <img src="{{asset('uploads/image/'.$image->image)}}" class="d-block w-100" alt="...">
                        <h6>{{$chores[4]->name}}</h6>
                        <h6>${{$chores[4]->price}}</h6>
                    </div>
                @endif

                @if(count($chores)>5)
                    <div class="carousel-item div-slider">
                    @php
                        $image=App\Image::where('id',$chores[5]->image_id)->first();
                        
                    @endphp
                    <img src="{{asset('uploads/image/'.$image->image)}}" class="d-block w-100" alt="...">
                        <h6>{{$chores[5]->name}}</h6>
                        <h6>${{$chores[5]->price}}</h6>
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
                    <h6>{{$chores_service[0]->name}}</h6>
                    <h6>{{$chores_service[0]->price}}</h6>
                    
                    
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
                    <h6>{{$chores_service[1]->name}}</h6>
                    <h6>{{$chores_service[1]->price}}</h6>
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
                    <h6>{{$chores_service[2]->name}}</h6>
                    <h6>{{$chores_service[2]->price}}</h6>
                </div>
                @endif
            </div>
           
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
             <h6>Browse Category</h6>
        </div>
       <div class="card-body">

       
            <ul style="list-style:none" class="card-body">
                @php
                    $chore_category=App\ChoreCategory::all();
                @endphp
                @if($chore_category)
                    @foreach($chore_category as $chore_category)
                    <li style="float:left"><i class="fas fa-plus-circle">{{$chore_category->name}}</i></li>
                    @endforeach
                @endif
            </ul>
        </div>

    </div>
   
    <div class="chore">
        <div class="letest">
            latest chores
        </div>
        <hr>
        @if($chores)
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
                        <h6 style="padding: 6px;color: brown;font-size: 18px;">{{$chores->name}}</h6>
                        <small class="price">$ {{$chores->price}}</small>

                    </div>
                </a>
            @endforeach
         @endif

    </div>
   
    <div class="chore ">
        <div class="letest">
            latest Service
        </div>
       
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
                        <h6 style="padding: 6px;color: brown;font-size: 18px;">{{$chores->name}}</h6>
                        <small class="price">$ {{$chores->price}}</small>

                    </div>
                </a>
                
                @endforeach
            @endif
        


    </div>
   

</div>

</body>
</html>
