@extends('chore.admin.admin')
@section('title','My Proposals')
@section('chore_content')
<div class="breadcrumb-wrap">
    <div class="padd10">
        <span typeof="v:Breadcrumb">
        <a  href="{{url('chores/admin')}}" class="main-home">My account</a></span> &gt; 
        <span typeof="v:Breadcrumb"><a  href="{{url('chores/my_proposals')}}" class="home">My Proposals</a></span>
    </div>
</div>
@php
$id = Auth::user()->id;
$proposal=App\Chore_proposal::where('user_id',$id)->get();
// $chore = App\chore::where('creator', $id)->get();
@endphp
<div id="content" class="content-for-account  col-xs-10 col-sm-8 col-lg-8 ">
     <div class="my_box3" style="height:100%">      
         
        <h6 class="widget-title">
                <span> 
                    My Proposals
                </span>
        </h6>

      <div>
          @if($proposal)
            @foreach($proposal as $proposal)
                @php
                    $chore=App\chore::find($proposal->chore_id);
                    // print_r($chore->id);
                    // exit();
                   
                    if(!$chore){
                        continue;
                    }
                    
                @endphp
                <div class="proposal">
                    <div style="width:100%">
                        <h6 class=""><strong>Task Is: </strong>{{$chore->name}}</h6>
                        @php
                            $owner=App\All_user::find($chore->creator);
                          // print_r($sender);
                        @endphp
                        <h6 class=""><strong>Owner Name: </strong>{{$owner->name}}</h6>
                        <h6 class=""><strong>Owner Email:</strong> {{$owner->email}}</h6>
                        <h6>Sent at: {{$proposal->created_at}}</h6>
                    </div>
                   
                    <div style="width:100%">
                        
                        <div class="">
                             <br>
                            
                           <strong>Price mentioned: $</strong>{{$proposal->price}}
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