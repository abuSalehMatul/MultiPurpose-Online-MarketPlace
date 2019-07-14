@extends('chore.admin.admin')
@section('title','WishList')
@section('chore_content')
<div class="breadcrumb-wrap">
    <div class="padd10">
        <span typeof="v:Breadcrumb">
        <a  href="{{url('chores/admin')}}" class="main-home">My account</a></span> &gt; 
        <span typeof="v:Breadcrumb"><a  href="{{url('chores/mywishlist')}}" class="home">My Wishlist</a></span>
    </div>
</div>
<style>

</style>
<div id="content" class="content-for-account  col-xs-10 col-sm-8 col-lg-8 ">
     <div class="my_box3" style="height:100%">      
          <div class=""> 
               <h6 class="widget-title">
                        <span> 
                       My Wishlist
                        </span>
                </h6>
     
          </div>
          @php
              $u=Auth::user();
              $wish=App\Wishlist::where('user_id',$u->id)->get();
          @endphp
          @if($wish)
             @foreach($wish as $wish)
              @php
                  $mytask=App\chore::find($wish->ChoSer_id)->first();
              @endphp
                <div class="grid_task">
                    @if($wish->type==1)
                        <div class="badge badge-success ">Task</div>
                    @else 
                        <div class="badge badge-success ">Service</div>
                    @endif
                    @if($mytask->precidance==1)
                        <div class="badge badge-warning ">Featured</div>
                    @else 
                        <div class="badge badge-warning ">Normal</div>
                    @endif
                        
                                
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
<div class="clear10"></div>
       
</div>
 
@endsection