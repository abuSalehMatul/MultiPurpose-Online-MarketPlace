@extends('backend.layouts.master')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
@section('content')
 <div class="account-pages mt-5 mb-5">
        <div class="container">                         
            <div class="row">
                <table>
                    <thead style="display:block">
                        <th >
                            <button class="btn btn-info" onclick="show('list')">Permission list</button>
                            <button class="btn btn-info" onclick="show('modification')">Permission Manage</button>
                            {{-- <button class="btn btn-info" onclick="show('remove')">Permission Remove</button> --}}
                        </th>
                    </thead>
                    <tbody>
                        <tr>
                            <table class="table" id="list" style="display:none">
                            <thead>
                                <th>Permission Name</th>
                                <th>Creation Date</th>
                            </thead>
                            <tbody>
                                @if($permission)
                                    @foreach($permission as $per)
                                        <tr>
                                            <td>{{$per->name}}</td>
                                            <td>{{$per->created_at}}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                            </table>
                            <br>
                            <br>
                          
                        </tr>
                    </tbody>
                </table>


                    <div class=" modification offset-1" style="display:none" >
           
                        <form action="{{url('set_permission')}}" method="POST">

                        @csrf 
                        <div class="form-group">
                           
                            <input type="text" name="email" class="form-control" id="email">
                            <li class="btn btn-info" onclick="search()">Search</li>
                           
                        </div class="form-group"> 
                            @if($permission)
                                @foreach($permission as $perm)
                                    <div class="form-group" > 
                                        <label style="display:none" for="{{$perm->id}}" class="modification">{{$perm->name}}</label>
                                        <input style="display:none" type="checkbox" id="{{$perm->name}}" name="{{$perm->name}}" class=" modification"> 
                                    </div> 
                                
                                @endforeach
                                @endif  
                        <input type="submit" style="display:none" class="btn btn-info modification form-control">
                        </form>
                        
                    </div>
            </div>
        </div>
 </div>

@endsection
@section('script')
    <script>
        function show(data){
            if(data=='list'){
                $('#list').show();
                $('.modification').hide();
            }else{
                 $('#list').hide();
                $('.modification').show();
            }
        }
       
    </script>
    <script>
        console.log('ami');
        function search(){
                var value=$('#email').val();
                var i;
                $.ajax({
                    type:'get',
                    url:'{{url('/get_email')}}',
                    data:{'email':value},
                    success:function(data){
                        console.log();
                        for(i=0;i<20;i++){
                            $('#'+data[i]).attr('checked','checked');
                        }
                    }
                })
            }
    </script>
@endsection
