
@extends('layouts.app')
@section('title','My Account')
@section('content')


@include('chore.style.CSS')
@include('chore.style.choreContent')
@include('chore.style.choreDetailsCSS')
@include('chore.style.choreDetailsJS')

<div class="container" style="margin-top:3%;">
    	
   @yield('chore_content')
     
    <div id="right-sidebar" class="sidebar-for-account col-xs-12 col-sm-3 col-lg-3">
        
        <div class="main_avatar">
            <a href="">
               
                <img class="avatar_ma" src="{{asset('uploads/image/'.Auth::user()->image)}}" width="140" height="140" alt="avatar_user" />
            </a>
            <br>
            <br>
            <a class="name_account_main" href="">{{ Auth::user()->name }}</a>   
            <li><span class="badge badge-success">{{ Auth::user()->email }}</span></li>  

        </div>
        
        
			<ul class="xoxo">
			
			<li class="widget-container widget_text">
                            <h6 class="widget-title">
                                <span> 
                                    Menu
                                </span>
                            
                                <span> 
                                    <a href="{{url('chores/view')}}">View Chores</a>
                                   
                                </span>
                            </h6>
            	<div class="my-only-widget-content">
                <ul id="my-account-admin-menu">
                        <li><a href="{{url('chores/admin')}}">MyAccount Home</a></li>
                        <li><a href="{{url('chores/add')}}">Post New Task</a></li>
                        <li><a href="{{url('service/add')}}">Post New Service</a></li>
                        <li><a href="{{url('paypal/ec-checkout')}}">Payments</a></li>
                      
                        <li><a href="reviews/index.html">Reviews <span class='notif_a'>1</span></a></li>
                        <li class="final_row_a"><a href="{{url('chores/mywishlist')}}" >Wishlist</a></li>
                </ul>        
                </div>        
            </li>
            
            
                        
            <li class="widget-container widget_text">
                           <h6 class="widget-title">
                                <span> 
                                Task Menu
                                </span>
                            </h6>
            	<div class="my-only-widget-content">
                <ul id="my-account-admin-menu_seller">
     				<li><a href="{{url('chores/my_active_task')}}">My Active Tasks</a></li>
                 
     				<li><a href="{{url('chores/proposal_received')}}">Proposals Received </a></li> 
                    <li><a href="{{url('chores/my_proposals')}}">My Task Proposals</a></li> 
                     <li class=""><a href="">Complited service </a></li>  
                    
                </ul>        
                </div>        
            </li>
            
            
            <li class="widget-container widget_text">
                            <h6 class="widget-title">
                                <span> 
                                    Service Menu
                                </span>
                            </h6>
            	<div class="my-only-widget-content">
                <ul id="my-account-admin-menu_seller">
                	
                    <li><a href="{{url('service/sold_service')}}">Sold Services </a></li>    
                    <li class=""><a href="{{url('service/proposal_received')}}">Proposal Received </a></li>    
                    <li class=""><a href="{{url('service/my_active_service')}}">Active Services </a></li>    
                    <li class=""><a href="{{url('service/my_service')}}">My Services </a></li>    
                    {{-- <li class=""><a href="{{url('service/purchased_service')}}">Purchased Services </a></li>     --}}
                    
                </ul>        
                </div>        
            </li>
            
    
    		</ul>
    	
        </div>

</div> 

@endsection