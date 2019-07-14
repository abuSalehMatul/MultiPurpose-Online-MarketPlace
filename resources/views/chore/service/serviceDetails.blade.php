
@extends('layouts.app')
@section('title','Service')
@section('content')


@include('chore.style.CSS')
@include('chore.style.choreContent')
@include('chore.style.choreDetailsCSS')
@include('chore.style.choreDetailsJS')


<div id="main">
    <div class="bg-success text-info proposal_sent">
        @php
            $m=Session::get('message');
        @endphp
        {{$m}}
    </div>
    @php
        $cat=App\ChoreCategory::where('id',$chore->category_id)->first();
        $image=App\Image::where('id',$chore->image_id)->first();
    @endphp  	
    <div class="get_div">  <!-- Breadcrumb NavXT 5.2.2 -->
        <span typeof="v:Breadcrumb">
            <a  class="main-home">healthbute</a>
        </span> &gt; <span typeof="v:Breadcrumb">
            <a  class="home">{{$cat->name}}</a>
        </span> &gt; <span typeof="v:Breadcrumb">
            <a >Tasks</a>
        </span> &gt; 
        <span typeof="v:Breadcrumb">
            <span property="v:title">{{$chore->name}}
            </span>
        </span> 
    </div> 
    <div class="clear10"></div>	

	<div id="content" class="col-xs-12 col-sm-9 col-lg-9">
		<div class="taskerdev_single_title">
			<div class="my_title_single col-xs-12 col-sm-8 col-lg-8">
            <h1>{{$chore->name}}</h1>  
                
            	<p>Posted on: {{$chore->created_at}}<br/>
                Posted in:                 </p> 
            </div>
			@php
                $creator=App\All_user::find($chore->creator);
            @endphp
            <div class="user_avatar col-xs-12 col-sm-4 col-lg-4">
            	<div class="user_av_1"><img class="avatar_ma" src="" width="80" height="80" alt="avatar_user" /></div>
                <div class="user_av_2"><a href="">{{$creator->name}}</a></div>
                <div class="user_av_2"><a href="" class="sh_link">Contact Buyer</a></div>
            </div>
            
        </div>
        
        <div class="main_description">
            <h6 class="widget-title">
                <span> 
                  Task Description
                </span>
            </h6>
                <p>
                    {{$chore->description}}
                </p>
                
        
        </div>
        
        
        <div class="clear10"></div>
        
        <div class="my_box3">          
            <h6 class="widget-title">
                <span> 
                  Request for Buy
                </span>
            </h6>
          
    		<table id="my_bids" width="100%">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Proposal</th>
                        <th>Date Made</th>
                    </tr>
                </thead>
                @php
                    $proposal=App\Chore_proposal::where('chore_id',$chore->id)->get();
                @endphp
                @if($proposal)
                <tbody>
                    @foreach($proposal as $proposal)
                    @php
                        $user=App\All_user::find($proposal->user_id);
                    @endphp
                    <tr>
                        <th>
                            <a href="">{{$user->name}}</a>
                        </th>
                        <th>$ {{$proposal->price}}</th>
                        <th>{{$proposal->created_at}}</th>
                    </tr>
                    @endforeach
                </tbody>
                @endif
            </table>	
        </div>
        
         <div class="clear10"></div>
        
        {{-- <div class="my_box3 last_row" style="display:inline-block; padding-bottom:10px">          
          <div class="box_title"><span>Map Location</span></div>
            <div id="map" style="width: 755px; height: 300px;border:1px solid #ccc;float:left; border-radius:6px;">
            </div>
				

        </div> --}}
        
        
         <div class="clear10"></div>
        
        <div class="my_box3 last_row">
       <h6 class="widget-title">
                <span> 
                  Related Task
                </span>
        </h6>
         	       
            
                 @php
                     $all_chore=App\chore::where('category_id',$chore->category_id)->where('type',2)->get();
                     $j=0;
                 @endphp
                 @if($all_chore)
                    @foreach($all_chore as $chores)
                     @php
                        $j++;
                        if($j==5){
                            break;
                        }
                    @endphp 
                        <div class="chore" style="float:left">
                               
                             
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
                                            @endphp
                                            <small class="featured badge badge-success">{{$p}}</small>
                                        
                                        </div>
                                        <h6 style="padding: 6px;color: brown;font-size: 18px;">{{$chores->name}}</h6>
                                        <small class="price">$ {{$chores->price}}</small>

                                    </div>
                                </a>
                               
                            </div>
                    @endforeach

                 @endif
               
        </div>
        
        
        
    </div> <!-- end content div -->
    
    
    <div id="right-sidebar" class="col-xs-12 col-sm-3 col-lg-3">
    	<div class="price_div">
        
            <div class="task_badge_seal3"></div>
            
            <div class="featured-one"></div>
                <p class="p_nzl"><span class="price_symbol">$</span>{{$chore->price}}</p>
            
            <p>
                @php
                $u=Auth::user()->id;
                    $proposal=App\Chore_proposal::where('chore_id',$chore->id)->where('user_id',$u)->first();
                @endphp
                @if(!$proposal)
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                    Buy offer
                </button>
                @else 
                    <button type="button" class="btn btn-primary">
                   Offer Bought
                </button>
                @endif
            </p>
      
        </div>
    	<!-- Button trigger modal -->


<!-- Modal -->
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Post a Bid</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{url('service/proposal/'.$chore->id)}}" method="POST" style="padding:15px;box-sizing: border-box;">
                    @csrf
                    <div class="modal-body" style="box-shadow:1px 1px greenyellow; padding:10px;color:green">
                    <p>You are Going Buy the offer <strong><i>{{$chore->name}}</i></strong></p>
                    <p>The budget mentioned by the seller is: <strong><i>${{$chore->price}}</i></strong></p>
                    <h6>Your Proposal</h6>
                    <input type="number" name="price" class="" placeholder="$..">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" value="Save">
                    </div>
                </form>
                </div>
            </div>
            </div>
        
        <div class="detail_div">
        	<p class="p_nzl2 watch-list"> 
                @php
                      $u=Auth::user()->id;
                     $wish=App\Wishlist::where('ChoSer_id',$chore->id)->where('type',2)->where('user_id',$u)->first();
                @endphp
                @if(!$wish)
                <a class="btn btn-success" rel="89" id="add" onclick="wishlist('add',<?php echo $chore->id; ?> ,2)">Add to watchlist</a>
 
                @else
                <a class="btn btn-danger" rel="89" id="rem" onclick="wishlist('rem',<?php echo $chore->id; ?>,2)">Remove from watchlist</a>
                @endif
            </p>
        </div>
        
        
        <div class="detail_div">
        	<p class="p_nzl2">Views for this offer: {{$chore->view}}</p>
        </div>

        <div class="detail_div">
        	
			<div class="addthis_sharing_toolbox"></div>
        </div>
        
            

        <li class="widget-container">
        	<h6 class="widget-title">
                <span> 
                   Picture
                </span>
            </h6>
        	<p>
                <ul class="image-gallery" style="padding-top:10px">
                    <li>
                        <a href="" data-fancybox-group="gallery" class="image_gal1">
                            <img width="55" height="55" src="{{asset('uploads/image/'.$image->image)}}" class="attachment-55x55 size-55x55" alt=""  sizes="(max-width: 55px) 100vw, 55px" /></a>
                    </li>
                </ul>          
            </p>
        </li>
        
    
    </div>
 
</div> 
<script>
    function wishlist(data,id,type){
        console.log(data);
        console.log(id);
        console.log(type);
       $.ajax({
            type: 'get',
            url : '{{URL::to('chores/wishlist')}}',
            data:{'data':data,'type':type,'ChoSer_id':id },
            success:function(data){
               
                console.log(data);
                if(data=='success'){
                    location.reload();
                }else{
                     location.reload();
                }
            }
        })
    }
</script>

@endsection