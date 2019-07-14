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
//$proposal=App\Chore_proposal::where('user_id',$id)->get();
 $chore = App\chore::where('creator', $id)->get();
@endphp
<div id="content" class="content-for-account  col-xs-10 col-sm-8 col-lg-8 ">
     <div class="my_box3" style="height:100%">      
         
        <h6 class="widget-title">
                <span> 
                    Sold Service
                </span>
        </h6>

      <div>
          @if($chore)
            @foreach($chore as $chore)
                @php
                   // $chore=App\chore::find($proposal->chore_id);
                    // print_r($chore->id);
                    // exit();
                   
                    if(!$chore){
                        continue;
                    }
                    if($chore->type==1){
                        continue;
                    }
                    $proposal=App\Chore_proposal::where('chore_id',$chore->id)->where('status',1)->get();
                @endphp
                <div class="proposal">
                    <div style="width:100%">
                        <h6 class=""><strong>Task Is: </strong>{{$chore->name}}</h6>
                        {{-- @php
                            $owner=App\All_user::find($chore->creator);
                          // print_r($sender);
                        @endphp --}}
                        @if($proposal)
                            @foreach ($proposal as $proposal)
                            @php
                                $sender=App\All_user::find($proposal->user_id);
                            @endphp
                                <h6 class=""><strong>Sender Name: </strong>{{$sender->name}}</h6>
                                <h6 class=""><strong>sender Email:</strong> {{$sender->email}}</h6>
                                <h6>Accepted at: {{$proposal->updated_at}}</h6>
                                 <div style="width:100%">
                                    
                                   
                                        
                                    <strong>Price mentioned: $</strong>{{$proposal->price}}
                                   
                                
                                </div>
                            @endforeach
                        
                        @endif
                    </div>
                   
                   
                    
                    

                </div>
            @endforeach
          @endif

      </div>
        
     </div>
</div>

@endsection