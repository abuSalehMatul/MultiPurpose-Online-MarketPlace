@extends('coupon.layouts.admin')
@section('content')
  <div class="content-main-block mrg-t-40">
    <div class="admin-create-btn-block">
        @if(isset($tagdtl))
          {!! Form::model($tagdtl, ['method' => 'PATCH', 'action' => ['TagController@update', $tagdtl->id]]) !!}
        @else
          {!! Form::open(['method' => 'POST', 'action' => 'TagController@store']) !!}
        @endif
        <div class="row admin-form-block">
          <div class="col-md-4">
            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                {!! Form::label('title', 'Add Tag') !!}
                {!! Form::text('title', old('title'), ['class' => 'form-control', 'placeholder' => 'Enter Tag']) !!}
                <small class="text-danger">{{ $errors->first('title') }}</small>
            </div>
          </div>
          <div class="col-md-3">
            <div class="btn-group pull-right">
              <button type="submit" class="btn btn-success">Submit</button>
              <button type="reset" class="btn btn-info">Reset</button>
            </div>
          </div>
        </div>
      {!! Form::close() !!}
    </div>
    <div class="content-block box-body">
      <table class="table table-hover">
        <thead>
          <tr class="table-heading-row">
            <th>#</th>
            <th>Title</th>    
            <th>Actions</th>
          </tr>
        </thead>
        @if (isset($tag))
          <tbody>
            @foreach($tag as $key => $item)
              <tr>
                <td>
                  {{$key+1}}
                </td>
                <td><a href="{{route('tag.show', $item->id)}}">{{$item->title}}</a></td>
                <td>
                  <div class="admin-table-action-block">
                    <a href="{{route('tag.edit', $item->id)}}" data-toggle="tooltip" data-original-title="Edit" class="btn-info btn-floating"><i class="material-icons">mode_edit</i></a>
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
                            {!! Form::open(['method' => 'DELETE', 'action' => ['TagController@destroy', $item->id]]) !!}
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
