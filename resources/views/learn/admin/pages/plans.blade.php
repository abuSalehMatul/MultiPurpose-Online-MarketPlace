@extends('admin.layout.master')
@section('import-css')

@stop

@section('body')
    <style>
        .app-search__input {
            font-size: 20px;
            padding: 0px 10px;
            border: 2px solid #009688;
            border-radius: 2px;
            background-color: rgba(255, 255, 255, 0.8);
        }

        .videoWrapper iframe {
            /*position: absolute;*/
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
    </style>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-title ">
                    <a href="{{route('plan.create')}}" class="btn btn-success btn-md pull-left ">
                        <i class="fa fa-plus"></i> Create New Post
                    </a>


                    <ul class="app-nav pull-right">
                        <li class="app-search">
                            <form action="{{route('search.post')}}" method="post">
                                @csrf
                            <input class="app-search__input" name="search" type="search" placeholder="Search">
                            <button class="app-search__button"><i class="fa fa-search"></i></button>
                            </form>
                        </li>
                    </ul>
                </div>
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" >
                            <thead>
                            <tr>
                                <th > Video</th>
                                <th> Title</th>
                                <th> Category</th>
                                <th>SubCategory</th>
                                <th>Status</th>
                                <th>ACTION</th>
                            </tr>
                            </thead>

                            <tbody>

                            @foreach($plans as $k=>$data)
                                <tr>
                                    <td data-label="Title">
                                        <div class="videoWrapper">
                                        {!! $data->video or '-' !!}
                                        </div>
                                    </td>
                                    <td data-label="Title">{{$data->title or '-'}}</td>
                                    <td data-label="Unit">{{$data->category->name or '-'}}</td>
                                    <td data-label="Category">{{$data->subcategory->title or '-'}}</td>
                                    <td data-label="Status">
                                        <b class="btn btn-sm btn-{{ $data->status ==0 ? 'warning' : 'success' }}">{{ $data->status == 0 ? 'Deactive' : 'Active' }}</b>
                                    </td>
                                    <td data-label="Action">
                                        <a href="{{route('plan.edit',$data->id)}}" class="btn btn-outline-primary btn-sm ">
                                            <i class="fa fa-edit"></i> EDIT
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        {!! $plans->links() !!}
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')

@endsection