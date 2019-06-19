@extends('layouts.admin')
@section('content')
  <div class="content-main-block mrg-t-40">
    <div class="admin-create-btn-block">
      <a href="{{route('user.create')}}" class="btn btn-danger btn-md"><i class="material-icons left">add</i> Create User</a>
      <!-- Delete Modal -->
      <a type="button" class="btn btn-danger btn-md z-depth-0" data-toggle="modal" data-target="#bulk_delete"><i class="material-icons left">delete</i> Delete Selected</a>   
      <!-- Modal -->
      <div id="bulk_delete" class="delete-modal modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <div class="delete-icon"></div>
            </div>
            <div class="modal-body text-center">
              <h4 class="modal-heading">Are You Sure ?</h4>
              <p>Do you really want to delete these records? This process cannot be undone.</p>
            </div>
            <div class="modal-footer">
              {!! Form::open(['method' => 'POST', 'action' => 'UserController@bulk_delete', 'id' => 'bulk_delete_form']) !!}
                <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
                <button type="submit" class="btn btn-danger">Yes</button>
              {!! Form::close() !!}
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="content-block box-body">
      <table id="full_detail_table" class="table table-hover table-responsive">
        <thead>
          <tr class="table-heading-row">
            <th>
              <div class="inline">
                <input id="checkboxAll" type="checkbox" class="filled-in" name="checked[]" value="all" id="checkboxAll">
                <label for="checkboxAll" class="material-checkbox"></label>
              </div>
              #
            </th>
            <th>Image</th>
            <th>Name</th>
            <th>Email</th>
            <th>Mobile</th>
            <th>DOB</th>
            <th>Address</th>
            <th>Gender</th>
            {{-- <th>Followers</th>
            <th>Following</th> --}}
            <th>Role</th>
            <th>Created At</th>
            <th>Actions</th>  
          </tr>
        </thead>
        @if ($user)
          <tbody>
            @php ($no = 1)
            @foreach ($user as $user)
              @if($user->id != $auth->id)
                <tr>
                  <td>
                    <div class="inline">
                      <input type="checkbox" form="bulk_delete_form" class="filled-in material-checkbox-input" name="checked[]" value="{{$user->id}}" id="checkbox{{$user->id}}">
                      <label for="checkbox{{$user->id}}" class="material-checkbox"></label>
                    </div>
                    {{$no}}
                    @php ($no++)
                  </td>
                  <td> @if ($user->image != null)
                      <img src="{{ asset('images/user/'.$user->image) }}" class="img-responsive" width="50" alt="image">
                    @else
                      N/A  
                    @endif
                  </td>
                  <td>{{$user->name}}</td>
                  <td>{{$user->email}}</td>
                  <td>{{$user->mobile}}</td>
                  <td>{{$user->dob}}</td>
                  <td>{{str_limit($user->address, 20)}}</td>
                  <td>{{$user->gender == 'f' ? 'Female' : 'Male'}}</td>
                  {{-- <td>{{$user->followers()->count()}}</td>
                  <td>{{$user->followings()->count()}}</td> --}}
                  <td>{{$user->is_admin == 1 ? 'Admin' : 'User'}}</td>
                  <td>{{$user->created_at->diffForHumans()}}</td>
                  <td>
                    <div class="admin-table-action-block">
                      <a href="{{route('user.edit', $user->id)}}" data-toggle="tooltip" data-original-title="Edit" class="btn-info btn-floating"><i class="material-icons">mode_edit</i></a>
                      <!-- Delete Modal -->
                      @if ($user->is_admin == 1)
                        <a type="button" class="btn-danger btn-floating disabled" disabled="disabled" data-toggle="tooltip" data-original-title="You can not delete admin!"><i class="material-icons">delete</i> </a>
                      @else  
                        <button type="button" class="btn-danger btn-floating" data-toggle="modal" data-target="#{{$user->id}}deleteModal"><i class="material-icons">delete</i> </button>
                      @endif
                    </div>
                  </td>
                </tr>
              @endif
              <!-- Modal -->
              <div id="{{$user->id}}deleteModal" class="delete-modal modal fade" role="dialog">
                <div class="modal-dialog modal-sm">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <div class="delete-icon"></div>
                    </div>
                    <div class="modal-body text-center">
                      <h4 class="modal-heading">Are You Sure ?</h4>
                      <p>Do you really want to delete these records? This process cannot be undone.</p>
                    </div>
                    <div class="modal-footer">
                      {!! Form::open(['method' => 'DELETE', 'action' => ['UserController@destroy', $user->id]]) !!}
                          <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
                          <button type="submit" class="btn btn-danger">Yes</button>
                      {!! Form::close() !!}
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          </tbody>
        @endif  
      </table>
    </div>
  </div>
@endsection
@section('custom-script')
  <script>
    $(function(){
      $('#checkboxAll').on('change', function(){
        if($(this).prop("checked") == true){
          $('.material-checkbox-input').attr('checked', true);
        }
        else if($(this).prop("checked") == false){
          $('.material-checkbox-input').attr('checked', false);
        }
      });
    });
  </script>
@endsection