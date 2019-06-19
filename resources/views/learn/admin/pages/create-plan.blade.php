@extends('admin.layout.master')
@section('import-css')
@stop
@section('body')
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title ">{{$page_title}}
                    <a href="{{route('plan.all')}}" class="btn btn-success btn-md pull-right ">
                        <i class="fa fa-eye"></i> All Posts
                    </a>
                </h3>
                <div class="tile-body">
                    <form role="form" method="POST" action="{{route('plan.store')}}" name="editForm" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-md-12">
                                <h6> Title</h6>
                                <div class="input-group">
                                    <input type="text" class="form-control input-lg"
                                           name="title" placeholder="Give Video Title">
                                    <div class="input-group-append"><span class="input-group-text">
                                            <i class="fa fa-font"></i>
                                            </span>
                                    </div>
                                </div>
                                @if ($errors->has('title'))
                                    <div class="error">{{ $errors->first('title') }}</div>
                                @endif

                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-md-6">
                                <h6>Category</h6>
                                <select name="category_id" id="category_id" class="form-control">
                                    <option value="">Select Category</option>
                                    @foreach($category as $data)
                                        <option value="{{$data->id}}">{{$data->name}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('category_id'))
                                    <div class="error">{{ $errors->first('category_id') }}</div>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <h6>Sub-Category</h6>
                                <select name="subcategory_id" id="subcategory_id" class="form-control" >
                                    <option value="">Select One</option>
                                </select>
                            </div>
                        </div>
                        <br>



                        <div class="row">
                            <div class="col-md-12">
                                <h6>  Embed Video </h6>
                                <div class="input-group">
                                    <input type="text" class="form-control input-lg"
                                           name="video" placeholder=" Youtube video Link">
                                    <div class="input-group-append"><span class="input-group-text">
                                            <i class="fa fa-video"></i>
                                            </span>
                                    </div>
                                </div>
                                @if ($errors->has('video'))
                                    <div class="error">{{ $errors->first('video') }}</div>
                                @endif

                            </div>
                        </div><br>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <h6>Details</h6>
                                <textarea name="details" id="area1" cols="30" rows="12" class="form-control"></textarea>
                            </div>

                        </div><br>


                        <div class="row">
                            <div class="col-md-12">
                                <h6>Status</h6>
                                <input data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-width="100%" type="checkbox" name="status">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <hr/>
                            <div class="col-md-12 ">
                                <button class="btn btn-primary btn-block btn-lg">Save Post</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('import-script')
@stop
@section('script')

    <script src="{{ asset('assets/admin/js/nicEdit-latest.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#category_id').on('change',function (e) {
                var category_id = e.target.value;
                console.log(category_id);
                var url = '{{ url('/') }}';
                $.get(url + '/category-get-subcategory?category_id=' + category_id,function (data) {
                    $('#subcategory_id').empty();
                    $.each(data,function (index,subcatObj) {
                        $('#subcategory_id').append('<option value="'+subcatObj.id+'">'+subcatObj.title+'</option>');
                    })
                })
            });
        });
    </script>
    
    <script type="text/javascript">
        bkLib.onDomLoaded(function() { new nicEditor({fullPanel : true}).panelInstance('area1'); });
    </script>
@stop