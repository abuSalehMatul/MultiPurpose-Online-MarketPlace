@extends('chore.admin.admin')
@section('chore_content')
<div class="breadcrumb-wrap">
    <div class="padd10">
        <span typeof="v:Breadcrumb">
        <a  href="{{url('/')}}" class="main-home">Healthbuite</a></span> &gt; 
        <span typeof="v:Breadcrumb"><a  href="{{url('chores/admin')}}" class="home">My Account</a></span>
    </div>
</div>
@php
$id = Auth::user()->id;

$chore = App\chore::where('creator', $id)->where('type',1)->get();
@endphp
<div id="content" class="content-for-account  col-xs-10 col-sm-8 col-lg-8 ">
     <div class="my_box3" style="height:100%">      
         
        <h6 class="widget-title">
                <span> 
                    I have given 
                </span>
        </h6>

      <div>
          @if($chore)
            @foreach($chore as $chore)
                @php
                    $proposal=App\Chore_proposal::where('chore_id',$chore->id)->where('status',1)->first();
                    // print_r($chore->id);
                    // exit();
                    // if($proposal){
                    //     if($proposal->status==1){
                    //         continue;
                    //     }
                    // }
                    if(!$proposal){
                        continue;
                    }
                    
                @endphp
                <div class="proposal">
                    <div style="width:100%">
                        <h6 class=""><strong>Task Is: </strong>{{$chore->name}}</h6>
                        @php
                            $sender=App\All_user::find($proposal->user_id);
                          // print_r($sender);
                        @endphp
                        <h6 class=""><strong>Job Won: </strong>{{$sender->name}}</h6>
                        <h6 class=""><strong>Woner Email:</strong> {{$sender->email}}</h6>
                        <h6>Accepted at: {{$proposal->updated_at}}</h6>
                    </div>
                   
                    <div style="width:100%">
                        
                        <div class="">
                             <br>
                            
                           <strong>Price : $</strong>{{$proposal->price}}
                        </div>
                        {{-- <div>
                            <a href="{{url('chores/proposal_accept/'.$proposal->id)}}" class="btn btn-success alink"> Accept</a>
                            <a href="{{url('chores/proposal_denied/'.$proposal->id)}}" class="btn btn-danger alink"> Decline</a>
                        </div> --}}
                    </div>
                    
                    

                </div>
            @endforeach
          @endif

      </div>
        
     </div>

@php
$id = Auth::user()->id;

$chore = App\chore::where('gifted', $id)->get();
@endphp

     <div class="my_box3" style="height:100%">      
         
        <h6 class="widget-title">
                <span> 
                    I have got 
                </span>
        </h6>

      <div>
          @if($chore)
            @foreach($chore as $chore)
                @php
                    $proposal=App\Chore_proposal::where('chore_id',$chore->id)->where('status',1)->first();
                    // print_r($chore->id);
                    // exit();
                    // if($proposal){
                    //     if($proposal->status==1){
                    //         continue;
                    //     }
                    // }
                    if(!$proposal){
                        continue;
                    }
                    
                @endphp
                <div class="proposal">
                    <div style="width:100%">
                        <h6 class=""><strong>Task Is: </strong>{{$chore->name}}</h6>
                        @php
                            $sender=App\All_user::find($proposal->user_id);
                          // print_r($sender);
                        @endphp
                        <h6 class=""><strong>Job Won: </strong>{{$sender->name}}</h6>
                        <h6 class=""><strong>Woner Email:</strong> {{$sender->email}}</h6>
                        <h6>Accepted at: {{$proposal->updated_at}}</h6>
                    </div>
                   
                    <div style="width:100%">
                        
                        <div class="">
                             <br>
                            
                           <strong>Price : $</strong>{{$proposal->price}}
                        </div>
                        {{-- <div>
                            <a href="{{url('chores/proposal_accept/'.$proposal->id)}}" class="btn btn-success alink"> Accept</a>
                            <a href="{{url('chores/proposal_denied/'.$proposal->id)}}" class="btn btn-danger alink"> Decline</a>
                        </div> --}}
                    </div>
                    
                    

                </div>
            @endforeach
          @endif

      </div>
        
     </div>
</div>
@endsection