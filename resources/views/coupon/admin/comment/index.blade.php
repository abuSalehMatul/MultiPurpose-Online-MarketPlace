@extends('coupon.layouts.admin')
@section('content')
  <div class="content-main-block  mrg-t-40">
    <div class="admin-create-btn-block">
      <!-- Delete Modal -->
      <a type="button" class="btn btn-danger btn-md" data-toggle="modal" data-target="#bulk_delete"><i class="material-icons left">delete</i> Delete Selected</a>   
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
              {!! Form::open(['method' => 'POST', 'action' => 'CommentController@bulk_delete', 'id' => 'bulk_delete_form']) !!}
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
            #</th>
            <th>Comment</th>
            <th>Title</th>
            <th>User</th>
            <th>Replied To</th>
            <th>Comment</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        @if (isset($comment))
          <tbody>
            @foreach ($comment as $key => $item)
              <tr>
                <td>
                  <div class="inline">
                    <input type="checkbox" form="bulk_delete_form" class="filled-in material-checkbox-input" name="checked[]" value="{{$item->id}}" id="checkbox{{$item->id}}">
                    <label for="checkbox{{$item->id}}" class="material-checkbox"></label>
                  </div>
                  {{$item->id}}
                </td>
                <td>
                  {{$item->commentable->type == 'd' ? 'Deal' : $item->commentable->type == 'c' ? 'Coupon' : 'Discussion'}}
                </td>
                <td>{{str_limit($item->commentable->title, 20)}}</td>
                <td>{{$item->users->name}}</td>
                <td>{{$item->reply_id}}</td>
                <td>{!! str_limit($item->body,50) !!}</td>
                <td>
                    {!! Form::open(['method' => 'POST', 'action' => ['CommentController@status_update', $item->id]]) !!}
                      <label class="switch">
                        {!! Form::checkbox('is_active', null, $item->is_active == 1 ? 1 : 0, ['class' => 'checkbox-switch', 'onChange'=>"this.form.submit()"]) !!}
                        <span class="slider round"></span>
                      </label>
                    {!! Form::close() !!}
                  </td>
                <td>
                  <div class="admin-table-action-block">
                    <!-- Delete Modal -->
                    <button type="button" class="btn-danger btn-floating" data-toggle="modal" data-target="#{{$item->id}}deleteModal"><i class="material-icons">delete</i> </button>
                    <!-- Modal -->
                    <div id="{{$item->id}}deleteModal" class="delete-modal modal fade" role="dialog">
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
                            {!! Form::open(['method' => 'DELETE', 'action' => ['CommentController@destroy', $item->id]]) !!}
                                <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
                                <button type="submit" class="btn btn-danger">Yes</button>
                            {!! Form::close() !!}
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        @endif  
      </table>
    </div>
  </div>
@endsection