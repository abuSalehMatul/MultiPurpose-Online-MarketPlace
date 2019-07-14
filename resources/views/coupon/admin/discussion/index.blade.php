@extends('coupon.layouts.admin')
@section('content')
  <div class="content-main-block  mrg-t-40">
    <div class="admin-create-btn-block">
      <a href="{{route('discussion.create')}}" class="btn btn-danger btn-md">Add Discussion</a>
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
              {!! Form::open(['method' => 'POST', 'action' => 'DiscussionController@bulk_delete', 'id' => 'bulk_delete_form']) !!}
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
            <th>Image</th>
            <th>Type</th>
            <th>Title</th>
            <th>Detail</th>
            <th>User</th>
            <th>Featured</th>
            <th>Stauts</th>
            <th>Actions</th>
          </tr>
      </thead>
        @if (isset($discussion))
          <tbody>
            @foreach ($discussion as $key => $item)
              <tr>
                <td>
                  <div class="inline">
                    <input type="checkbox" form="bulk_delete_form" class="filled-in material-checkbox-input" name="checked[]" value="{{$item->id}}" id="checkbox{{$item->id}}">
                    <label for="checkbox{{$item->id}}" class="material-checkbox"></label>
                  </div>
                  {{$key+1}}
                </td>
                <td>
                  @if ($item->image != null)
                    <img src="{{ asset('coupon/images/discussion/'.$item->image) }}" class="img-responsive" width="80" alt="image">
                  @else
                    N/A  
                  @endif
                </td>
                <td>{{str_limit($item->forumcategory->title, 20)}}</td>
                <td>{{str_limit($item->title,20)}}</td>
                <td>{!! substr(strip_tags($item->detail), 0, 20) !!}...</td>
                <td>{{strtok($item->user->name,' ')}}</td>
                <td>{{$item->is_featured == '1' ? 'Featured' : 'Not'}}</td>
                <td>{{$item->is_active == '1' ? 'Active' : 'Deactive'}}</td>
                <td>
                  <div class="admin-table-action-block">
                    <a href="{{route('discussion.edit', $item->id)}}" data-toggle="tooltip" data-original-title="Edit" class="btn-info btn-floating"><i class="material-icons">mode_edit</i></a>
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
                            {!! Form::open(['method' => 'DELETE', 'action' => ['DiscussionController@destroy', $item->id]]) !!}
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
      {{-- <div class="eloquent-pagination">
        {{ $cities->links() }}
      </div> --}}
    </div>
  </div>
@endsection
