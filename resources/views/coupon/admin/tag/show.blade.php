@extends('coupon.layouts.admin')
@section('content')
  <div class="content-main-block mrg-t-40">
    <div class="admin-create-btn-block">
      <p>{{$tag->title}} Tag Blogs<small>({{$tag->blogs()->count()}})</small></p>
    </div>
    <div class="content-block box-body">
      <table class="table table-hover">
        <thead>
          <tr class="table-heading-row">
            <th>#</th>
            <th>Title</th> 
            <th>Tags</th>    
            <th>Actions</th>
          </tr>
        </thead>
        @if(isset($tag))
          <tbody>
            @foreach($tag->blogs as $key => $item)
              <tr>
                <td>
                  {{$key+1}}
                </td>
                <td>{{$item->title}}</td>
                <td>
                  @foreach($item->tags as $tags)
                    <span class="label label-primary">{{$tags->title}}</span>
                  @endforeach
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
