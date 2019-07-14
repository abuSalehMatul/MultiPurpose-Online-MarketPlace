@extends('chore.admin.admin')
@section('chore_content')
<div class="breadcrumb-wrap">
    <div class="padd10">
        <span typeof="v:Breadcrumb">
        <a  href="{{url('/')}}" class="main-home">Healthbuite</a></span> &gt; 
        <span typeof="v:Breadcrumb"><a  href="{{url('chores/admin')}}" class="home">My Account</a></span>
    </div>
</div>
<div id="content" class="content-for-account  col-xs-12 col-sm-9 col-lg-9 ">
    
        <div class="my_box3">
          
                <h6 class="widget-title">
                        <span> 
                        My Active Task
                        </span>
                </h6>
          @php
              $u=Auth::user()->id;
              $mytask=App\chore::where('creator',$u)->where('type',1)->get();
              $myservice=App\chore::where('creator',$u)->where('type',2)->get();
          @endphp
          <div class="box_content" id="tasks_me"> 
              @if($mytask)
                @foreach($mytask as $mytask)
                <div class="grid_task">
        
                    <div class="task_badge_seal"></div>
                    
                    <div class="featured-one"></div>
                            
                    <div class="slider_picture">
                    <a href="{{url('chores/details/'.$mytask->id)}}">
                        @php
                            $image=App\Image::find($mytask->image_id)->first();
                        @endphp
                        <img class="image_sld" src="{{asset('uploads/image/'.$image->image)}}" width="160" height="160" alt="Oil Change" />
                    </a>
                    </div>
                        
                    <div class="slider_versatile">
                        {{$mytask->name}}<br/>
                        <span class="prcs_prcs">$ {{$mytask->price}}</span>
                    </div>
            
                </div>
                @endforeach
                @endif
                                                    
          </div>
  
        </div>
        <div class="my_box3 last_row">
          
                     <h6 class="widget-title">
                        <span> 
                            My Active Service
                        </span>
                    </h6>
          <div class="box_content" id="services_me"> 
            @if($myservice) 
              @foreach($myservice as $myservice)                                     
                <div class="grid_task">
                
                    <div class="service_badge_seal"></div>
                     @php
                            $image=App\Image::find($myservice->image_id)->first();
                    @endphp
                            
                    <div class="slider_picture">
                    <a href="{{url('chores/details/'.$myservice->id)}}">
                        <img class="image_sld" src="{{asset('uploads/image/'.$image->image)}}" width="160" height="160" alt="physio" />
                    </a>
                    </div>
                    
                    <div class="slider_versatile">
                        {{$myservice->name}}<br/>
                        <span class="prcs_prcs">$ {{$myservice->price}}</span>
                    </div>
            
                </div>
               @endforeach
            @endif
         
                                                      
          </div>
  
        </div>

    </div> 
@endsection